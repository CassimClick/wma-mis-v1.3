<?php

namespace App\Controllers;

use SimpleXMLElement;
use App\Models\BillModel;
use App\Models\ProfileModel;
use App\Libraries\ArrayLibrary;
use App\Controllers\BaseController;
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
    protected $token;


    public function __construct()
    {

        $this->session = session();
        $this->token = csrf_hash();
        $this->billModel = new BillModel();
        $this->xmlLibrary = new XmlLibrary();
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
        //"digitalsignature\gepg.p12"
        if (!$cert_store = file_get_contents("gepgclientprivate.pfx")) {
            echo "Error: Unable to read the cert file\n";
            exit;
        } else {
            if (openssl_pkcs12_read($cert_store, $cert_info, "passpass")) {


                //print_r($cert_info);    //Certificate Information;
                //$pkey = $cert_info['pkey'];  //private key
                //$cert = $cert_info['cert'];  //public key
                $id = round(microtime(true) * 1000);
                //Bill Request 
                $content = "<gepgBillSubReq>
        <BillHdr>
            <SpCode>SP104</SpCode>
            <RtrRespFlg>true</RtrRespFlg>
        </BillHdr>
        <BillTrxInf>
            <BillId>" . $id . "</BillId>
            <SubSpCode>1002</SubSpCode>
            <ColCentCode>HQ</ColCentCode>
            <SpSysId>TDAWASCO001</SpSysId>
            <BillAmt>10000</BillAmt>
            <MiscAmt>0</MiscAmt>
            <BillExprDt>2021-06-27T00:00:00</BillExprDt>
            <PyrId>100109148213415390436</PyrId>
            <PyrName>Yohana</PyrName>
            <BillDesc>Sale of seedlings</BillDesc>
            <BillGenDt>2021-05-28T09:59:02</BillGenDt>
            <BillGenBy>2212</BillGenBy>
            <BillApprBy>SPPORTAL</BillApprBy>
            <PyrCellNum>0788234876</PyrCellNum>
            <PyrEmail>yohana@gmail.com</PyrEmail>
            <Ccy>TZS</Ccy>
            <BillEqvAmt>10000</BillEqvAmt>
            <RemFlag>true</RemFlag>
            <BillPayOpt>3</BillPayOpt>
            <BillItems>
                <BillItem>
                    <BillItemRef>123BN</BillItemRef>
                    <UseItemRefOnPay>N</UseItemRefOnPay>
                    <BillItemAmt>10000</BillItemAmt>
                    <BillItemEqvAmt>10000</BillItemEqvAmt>
                    <BillItemMiscAmt>0</BillItemMiscAmt>
                    <GfsCode>140202</GfsCode>
                </BillItem>
            </BillItems>
        </BillTrxInf>
    </gepgBillSubReq>";

                //create signature
                openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");

                $signature = base64_encode($signature);  //output encrypted data base64 encoded  

                //echo "Signature of Signed Content"."\n".$signature."\n";

                //Compose xml request
                $data = "<Gepg>" . $content . "<gepgSignature>" . $signature . "</gepgSignature></Gepg>";


                $resultCurlPost = "";
                $serverIp = "http://154.118.230.18";

                $uri = "/api/bill/sigqrequest"; //this is for qrequest
                //$uri = "/api/bill/sigsrequest"; //this if for srequest

                $data_string = $data;
                echo "Message ready to GePG:" . "\n" . $data_string . "\n";

                $ch = curl_init($serverIp . $uri);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type:application/xml',
                        'Gepg-Com:default.sp.in',
                        'Gepg-Code:SP104',
                        'Content-Length:' . strlen($data_string)
                    )
                );

                curl_setopt($ch, CURLOPT_TIMEOUT, 50);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 50);

                //Capture returned content from GePG
                $resultCurlPost = curl_exec($ch);
                curl_close($ch);
                //$resultCurlPost=$data; 
                if (!empty($resultCurlPost)) {

                    echo "\n\n";
                    echo "Received Response\n";
                    echo  $resultCurlPost;
                    echo "\n";

                    //Tag for respose
                    $datatag = "gepgBillSubReqAck";
                    $sigtag = "gepgSignature";

                    $vdata = $this->getDataString($resultCurlPost, $datatag);
                    $vsignature = $this->getSignatureString($resultCurlPost, $sigtag);

                    echo "\n\n";
                    echo "Data Received:\n";
                    echo $vdata;
                    echo "\n\n";
                    echo "Signature Received:\n";
                    echo $vsignature;
                    echo "\n";

                    if (!$pcert_store = file_get_contents("gepgpubliccertificate.pfx")) {
                        echo "Error: Unable to read the cert file\n";
                        exit;
                    } else {

                        //Read Certificate
                        if (openssl_pkcs12_read($pcert_store, $pcert_info, "passpass")) {

                            //print_r($pcert_info);
                            //print_r($pcert_info['extracerts']);
                            //print_r($pcert_info['extracerts']['0']);

                            //Decode Received Signature String
                            $rawsignature = base64_decode($vsignature);

                            //Verify Signature and state whether signature is okay or not
                            $ok = openssl_verify($vdata, $rawsignature, $pcert_info['extracerts']['0']);
                            if ($ok == 1) {
                                echo "\n\nSignature Status:";
                                echo "GOOD";
                            } elseif ($ok == 0) {
                                echo "\n\nSignature Status:";
                                echo "BAD";
                            } else {
                                echo "\n\nSignature Status:";
                                echo "UGLY, Error checking signature";
                            }
                        }
                    }
                } else {
                    echo "No result Returned" . "\n";
                }
            } else {

                echo "Error: Unable to read the cert store.\n";
                exit;
            }
        }
        
        
    }

   public function getDataString($inputstr, $datatag)
    {
        $datastartpos = strpos($inputstr, $datatag);
        $dataendpos = strrpos($inputstr, $datatag);
        $data = substr($inputstr, $datastartpos - 1, $dataendpos + strlen($datatag) + 2 - $datastartpos);
        return $data;
    }

   public function getSignatureString($inputstr, $sigtag)
    {
        $sigstartpos = strpos($inputstr, $sigtag);
        $sigendpos = strrpos($inputstr, $sigtag);
        $signature = substr($inputstr, $sigstartpos + strlen($sigtag) + 1, $sigendpos - $sigstartpos - strlen($sigtag) - 3);
        return $signature;
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
