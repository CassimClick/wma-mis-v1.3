<?php

namespace App\Controllers;

use SimpleXMLElement;
use App\Models\BillModel;
use App\Models\ProfileModel;
use App\Libraries\ArrayLibrary;
use App\Controllers\BaseController;
use App\Libraries\GepgProcess;
use App\Libraries\XmlLibrary;
use LSS\Array2XML;

class BillController extends BaseController
{
    protected $billModel;
    protected $uniqueId;
    protected $managerId;
    protected $role;
    protected $city;

    protected $session;
    protected $profileModel;
    protected $CommonTasks;

    protected $billLibrary;
    protected $xmlLibrary;
    protected $GepGpProcess;
    protected $token;


    public function __construct()
    {

        $this->session = session();
        $this->token = csrf_hash();
        $this->billModel = new BillModel();
        $this->xmlLibrary = new XmlLibrary();
        $this->GepGpProcess = new GepgProcess();
        $this->profileModel = new profileModel();
        $this->uniqueId = $this->session->get('loggedUser');
        $this->managerId = $this->session->get('manager');
        $this->role = $this->profileModel->getRole($this->uniqueId)->role;
        $this->city = $this->session->get('city');
        helper(['form', 'array', 'regions', 'date', 'prePackage_helper', 'image', 'url']);
    }

    public function getVariable($var)
    {
        return $this->request->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }





    public function getUser(): string
    {
        $user = $this->profileModel->getLoggedUserData($this->uniqueId);
        return $user->first_name . ' ' . $user->last_name;
    }


    public function billSubmissionRequest()
    {
        $billDetails = [
            'BillHdr' => [
                'SpCode' => $this->SpCode,
                'RtrRespFlg' => true

            ],

               'BillTrxInf'=>[
                'BillId' => randomString(),
                'SubSpCode' => $this->SubSpCode,
                'SpSysId' => $this->SpSysId,
                'BillAmt' => $this->getVariable('BillAmt'),
                'MiscAmt' =>  $this->getVariable('MiscAmt'),
                'BillExprDt' => date("Y-m-dTh:i:s", strtotime($this->getVariable('BillExprDt'))),
                'PyrId' =>  $this->getVariable('PyrId'),
                'PyrId' => randomString(),
                'PyrName' =>  $this->getVariable('PyrName'),
                'BillGenDt' => date('Y-m-d h:i:s'),
                'BillGenBy' =>   $this->getUser(),
                'BillDesc' =>  $this->getVariable('BillAmt'),
                'PyrEmail' =>  $this->getVariable('PyrEmail'),
                'PyrCellNum' =>  $this->getVariable('PyrCellNum'),
                'Ccy' =>  $this->getVariable('Ccy'),
                'BillEqvAmt' =>  $this->getVariable('BillEqvAmt'),
                'RemFlag' =>  $this->getVariable('RemFlag') == 'on' ? true : false,
                'BillPayOpt' =>  $this->getVariable('BillPayOpt'),
                'BillItems' => [
                    'BillItem' => multiDimensionArray([
                        'GfsCode' => $this->getVariable('GfsCode'),
                        'BillItemAmt' => $this->getVariable('BillItemAmt'),
                        'BillItemEqvAmt' => $this->getVariable('BillItemAmt'),
                        'BillItemRef' => $this->getVariable('BillItemRef'),
                        'GfsCode' => $this->getVariable('GfsCode'),
                    ])
                ],
               ]

           
        ];
       
        echo $this->GepGpProcess->billSubmission($billDetails);
    }











    public function index()
    {
        $currentPage =  url_is('billManagement') ? "Bill Management" : "Payments";
        $data['page'] = [
            "title" => $currentPage,
            "heading" =>  $currentPage,
        ];



        $data['profile'] = $this->profileModel->getLoggedUserData($this->uniqueId);
        $data['role'] = $this->role;
        url_is('billManagement') ? "Bill Management" : "Payments";

        return view('Pages/Transactions/searchBill', $data);
    }

    public function billCreation()
    {
        // $currentPage =  url_is('billManagement') ? "Bill Management" : "Payments";
        $data['page'] = [
            "title" => 'New Bill',
            "heading" =>  'New Bill',
        ];



        $data['profile'] = $this->profileModel->getLoggedUserData($this->uniqueId);
        $data['role'] = $this->role;

        return view('Pages/Transactions/createBill', $data);
    }
    public function payments()
    {

        $data['page'] = [
            "title" => 'Payments',
            "heading" =>  'Payments',
        ];



        $data['profile'] = $this->profileModel->getLoggedUserData($this->uniqueId);
        $data['role'] = $this->role;


        return view('Pages/Transactions/searchReceipt', $data);
    }


    public function searchBill()
    {
        $activity = $this->getVariable('activity');
        $payment = $this->getVariable('payment');
        $name = $this->getVariable('name');
        $phone = $this->getVariable('phone');
        $date = $this->getVariable('date');
        $controlNumber = $this->getVariable('controlNumber');

        $billParams = [
            // 'name' => $name,
            'payment' => $payment,
            'transactions.control_number' => $controlNumber,
            'customers.phone_number' => $phone,
            'DATE(transactions.created_on)' => $date,
        ];

        foreach ($billParams as $key => $value) {
            if ($value == '' || $value == 'All') {
                unset($billParams[$key]);
            }
        }

        // if($name == '' && count() ){

        // }
        $request =  $this->billModel->searchBill($billParams, $name, $activity);

        if ($request) {
            $bill = array_map(fn ($data) => [
                'id' => $data->id,
                'hash' => $data->hash,
                'name' => $data->name,
                'phoneNumber' => $data->phone_number,
                'controlNumber' => $data->control_number,
                'payment' => $data->payment,
                'amount' => $data->amount,
                'date' => dateFormatter($data->created_on),
                'item' => $data->item,
                'total' => 'Tsh ' . number_format($data->total),
                'totalInWords' => toWords($data->total),
            ], $request);
            return $this->response->setJSON([

                'status' => 1,
                'billData' => $bill,
                'activity' => $activity,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'billData' => [],
                'activity' => $activity,
            ]);
        }


        // return $this->response->setJSON([$bill]);
    }

    public function selectBill()
    {
        $activity = $this->getVariable('activity');
        $controlNumber = $this->getVariable('controlNumber');
        $document = $this->getVariable('document');

        // return $this->response->setJSON([$controlNumber,$activity]);
        // exit;

        $user = $this->profileModel->getLoggedUserData($this->uniqueId);


        $bill =  $this->billModel->selectBill($controlNumber, $activity);

        if ($bill) {
            $products = array_map(fn ($product) => [
                'product' => $product->item,
                'amount' => number_format(isset($product->amount) ? $product->amount : $product->total_amount),
            ], $bill);

            $data = [
                'status' => 1,
                'document' => $document,
                'products' =>  $products,
                'payer' => $bill[0]->name,
                'phoneNumber' => $bill[0]->phone_number,
                'controlNumber' => $bill[0]->control_number,
                'paymentDate' => dateFormatter($bill[0]->paymentDate),
                'billTotal' => 'Tsh ' . number_format($bill[0]->total) . ' (TZS)',
                'billTotalInWords' =>  toWords($bill[0]->total),
                'paymentRef' => time(),
                'createdBy' => $bill[0]->creator,
                'printedBy' => $user->first_name . ' ' . $user->last_name,
                'printedOn' => date('d M Y'),
            ];

            if ($document == 'receipt') {

                $data['balance'] = $bill[0]->total - $bill[0]->paid;
                $data['receptNumber'] = numString(13);
                $data['billReference'] = numString(16);
            }



            return $this->response->setJSON($data);
        } else {
            return $this->response->setJSON([
                'status' => 0,

            ]);
        }
    }

    public function dom()
    {
        return view('dom');
    }
    public function domAjax()
    {
        $amt = $this->getVariable('BillItemAmt');
        return $this->response->setJSON([$amt]);
    }

    public function controlNumber()
    {
    }
    public function billPayment()
    {
    }
    public function billReconciliation()
    {
    }
}
