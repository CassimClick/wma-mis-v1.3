<?php

namespace App\Controllers;

use App\Libraries\CommonTasksLibrary;
use App\Models\CustomerModel;
use App\Models\ProfileModel;
use App\Models\WaterMeterModel;
use Dompdf\Dompdf;

//use \CodeIgniter\Models\waterMeterModel;

class WaterMeter extends BaseController
{
    protected $uniqueId;
    protected $managerId;
    protected $role;
    protected $city;
    protected $waterMeterModel;
    protected $session;
    protected $profileModel;
    protected $CommonTasks;
    protected $appRequest;
    protected $token;
    protected $customersModel;
    protected $GfsCode;


    public function __construct()
    {
        $this->GfsCode = '14210121';
        $this->appRequest = service('request');
        $this->waterMeterModel = new WaterMeterModel();
        $this->profileModel = new ProfileModel();
        $this->customersModel = new CustomerModel();
        $this->session = session();
        $this->token = csrf_hash();
        $this->uniqueId = $this->session->get('loggedUser');
        $this->managerId = $this->session->get('manager');
        $this->role = $this->profileModel->getRole($this->uniqueId)->role;
        $this->city = $this->session->get('city');
        $this->CommonTasks
            = new CommonTasksLibrary();
        helper(['form', 'array', 'date', 'regions']);
    }



    public function getVariable($var)
    {
        return $this->appRequest->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    // ================Adding Vtc information to database ==============

    public function registerWaterMeter()
    {
        if ($this->request->getMethod() == 'post') {
            //=================Checking the last Id before incrementing it====================


            $decision =   $this->getVariable('decision');
            $count = count($decision);



            $amount = array_map(fn ($d) => $d == 'PASS' ? 10000 : 5000, $decision);

            $data = [

                'serial_number' =>   $this->getVariable('serialNumber'),
                'item_amount' => $amount,
                'amount' =>  fillArray($count, array_sum($amount)),
                'quantity' =>  fillArray($count, $count),
                'decision' =>   $decision,
                'initial_reading' =>   $this->getVariable('initialReading'),
                'final_reading' =>   $this->getVariable('finalReading'),
                'indicated_volume' =>   $this->getVariable('indicatedVolume'),
                'actual_volume' =>   $this->getVariable('actualVolume'),
                'error' =>   $this->getVariable('error'),
                'batch_id' => array_fill(0, $count, numString(10)),
                'hash' =>   fillArray($count, $this->getVariable('customerId')),
                'activity' =>   fillArray($count, $this->getVariable('activity')),
                'meter_size' =>   fillArray($count, $this->getVariable('meterSize')),
                'brand' =>   fillArray($count, $this->getVariable('brandName')),
                'flow_rate' =>   fillArray($count, $this->getVariable('flowRate')),
                'class' =>   fillArray($count, $this->getVariable('class')),
                'lab' =>   fillArray($count, $this->getVariable('testingLab')),
                'verifier' =>   fillArray($count, $this->getVariable('verifier')),
                'testing_method' => fillArray($count, $this->getVariable('testMethod')),
                'unique_id' => fillArray($count, $this->uniqueId),

            ];




            $meters = multiDimensionArray($data);


            // return $this->response->setJSON([
            //     'status' => 1,
            //     // 'data' => $WaterMeterData,
            //     'data' => $meters,
            //     'token' => $this->token
            // ]);
            // exit;
            $req = $this->waterMeterModel->registerWaterMeter($meters);

            if ($req) {
                $billed = $this->waterMeterModel->filterCustomersPaidWaterMeters($data['hash'][0]);
                $ids = $billed != [] ? array_map(fn ($meter) => $meter->instrument_id, $billed) : ['_'];
                $unbilled = $this->waterMeterModel->getAllUnpaidWaterMeters($data['hash'][0], $ids);
                return $this->response->setJSON([
                    'status' => 1,
                    // 'meter' => $this->waterMeterModel->getMetersByBatchId($data['hash'][0]),
                    'meters' => $unbilled,
                    'msg' => 'Water Meters Added',
                    'token' => $this->token
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Something Went Wrong!',
                    'meters' => [],
                    'token' => $this->token
                ]);
            }
        }
    }

    //=================check if customer has any unpaid WaterMeter====================
    public function getUnpaidWaterMeters()
    {
        if ($this->appRequest->getMethod() == 'post') {
            $hash =   $this->getVariable('customerId');
            $billed = $this->waterMeterModel->filterCustomersPaidWaterMeters($hash);
            $ids = $billed != [] ? array_map(fn ($meter) => $meter->instrument_id, $billed) : ['_'];
            $unbilled = $this->waterMeterModel->getAllUnpaidWaterMeters($hash, $ids);

            $meters = '';

            foreach ($unbilled as $meter) {
                $amount = number_format($meter->amount);
                $link = base_url('downloadMeterChart/' . $meter->batch_id);
                $meters .= <<<"HTML"
                  <tr>
                    <td>$meter->brand
                        <input type="text" value="$meter->batch_id"  name="batchId[]" hidden>
                    </td>
                    <td>$meter->meter_size mm</td>
                    <td>$meter->flow_rate m<sup>3</sup>/h</td>
                    <td>$meter->class</td>
                    <td>$meter->quantity Meters</td>
                    <td>$amount Tsh
                        <input type="text" value="$meter->amount" class="itemAmount" hidden>
                    </td>
                    <td><a href="$link" target="_blank" class="btn btn-primary btn-sm"><i class="far fa-download"></i></a></td>
                    
                  </tr>
                 HTML;
            }


            $html = <<<"HTML"
               <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Brand</th>
                                <th>Meter Size</th>
                                <th>Flow Rate</th>
                                <th>Class</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Chart</th>
                            </tr>
                        </thead>
                        <tbody>
                            $meters
                        </tbody>
                    </table>
             HTML;

            if ($unbilled != []) {
                return $this->response->setJSON([
                    'status' => 1,
                    'meters' =>  $html,
                    'meters count' => count($unbilled),
                    'unbilled' => $unbilled,
                    'token' => $this->token
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'meters' => '<p>No Data Found</p>',
                    'msg' => 'No Data Found !',
                    'token' => $this->token
                ]);
            }
        }
    }

    //=================Publishing Water meter In transaction table====================

    public function publishWaterMeterData()
    {
        if ($this->appRequest->getMethod() == 'post') {

            $hash = $this->getVariable('customerId');
            $batchId = $this->getVariable('batchId');

            $userId = $this->uniqueId;

            $count = count($batchId);
            $data = [
                'amount' =>  fillArray($count, $this->getVariable('totalAmount')),
                'instrument_id' => $batchId,
                'customer_hash ' =>   fillArray($count, $this->getVariable('customerId')),
                'control_number' =>   fillArray($count, $this->getVariable('controlNumber')),
                'payment' =>   fillArray($count, $this->getVariable('payment')),
                'unique_id' =>   fillArray($count, $userId),
            ];



            $transaction = multiDimensionArray($data);

            $items = array_map(function ($id) {
                $meter = $this->waterMeterModel->getMetersByBatchId($id);
                for ($i = 0; $i < count($meter); $i++) {
                    return [
                        'product' => $meter[$i]->brand .' '. $meter[$i]->meter_size. ' mm ' . $meter[$i]->flow_rate . 'm<sup>3</sup>/h',
                        'amount' => number_format($meter[$i]->amount),
                        'unique_id' => $meter[$i]->unique_id,
                    ];
                }
            }, $batchId);


            
            $customer = $this->customersModel->selectCustomer($hash);
            $printedBy = $this->profileModel->getLoggedUserData($this->uniqueId);
            $createdBy = $this->profileModel->getLoggedUserData($items[0]['unique_id']);


            $bill =  [
                'controlNumber' => $data['control_number'][0],
                'paymentRef' => time(),
                'payer' => $customer,
                'products' => $items,
                'billTotal' => 'Tsh ' . number_format($data['amount'][0]) . ' (TZS)',
                'billTotalInWords' =>  toWords($data['amount'][0]),
                'createdBy' => $createdBy->first_name . ' ' . $createdBy->last_name,
                'printedBy' => $printedBy->first_name . ' ' . $printedBy->last_name,
                'printedOn' => date('d M Y'),

            ];

            // echo json_encode([
            //     'status' => 1,
            //     'data1' => $bill,
            //     //  'Vehicle Data' => $vehicles,
            //     // 'bill' => $bill
            // ]);
            // exit;





            $request = $this->waterMeterModel->publishWaterMeterData($transaction);
            // $request = true;

            if ($request) {

                return $this->response->setJSON([
                    'status' => 1,
                    'msg'=> 'Water Meters Registered Successfully ',
                    'bill' => $bill,
                    'token' => $this->token
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg'=> 'Something Went Wrong',
                    'token' => $this->token
                ]);
            }
        }
    }

    public function addWaterMeter()
    {

        $data = [];
        $data['validation'] = null;

        $data['page'] = [
            "title" => "Water Meter",
            "heading" => "Water Meter",
        ];
        $data['statusResult'] = ['Pass', 'Rejected'];
        $data['genderValues'] = ['Male', 'Female'];

        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['role'] = $role;
        return view('pages/WaterMeter/addWaterMeter', $data);
    }

    public function listRegisteredWaterMeters()
    {
        if (!$this->session->has('loggedUser')) {
            return redirect()->to('login');
        }

        $data['page'] = [
            "title" => "WaterMeter List",
            "heading" => "Registered  Water Meters",
        ];

        $uniqueId = $this->uniqueId;
        $managerId = $this->managerId;
        $role = $this->role;
        $city = $this->city;

        if ($role == 1) {
            $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
            $data['role'] = $role;
            $data['WaterMeterResults'] = $this->waterMeterModel->getRegisteredWaterMeters($uniqueId);
        } elseif ($role == 2) {
            $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
            $data['role'] = $role;
            $data['WaterMeterResults'] = $this->waterMeterModel->getAllWaterMeters($city);
        } elseif ($role == 3 || $role == 7) {
            $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
            $data['role'] = $role;
            $data['WaterMeterResults'] = $this->waterMeterModel->getAllWaterMetersTz();
        }

        return view('pages/WaterMeter/WaterMeterList', $data);
    }

    public function downloadMeterChart($batchId)
    {
        $meters = $this->waterMeterModel->getMetersByBatch($batchId);

         $dompdf = new \Dompdf\Dompdf();
         $options = new \Dompdf\Options();
         $data['report'] = $meters;
         $dompdf->loadHtml(view('Pages/WaterMeter/WaterMeterChart',$data));
         $title = $meters[0]->name . ''.numString(5);
      
         $dompdf->setPaper('A4', 'portrait');
         $options->set('isRemoteEnabled', TRUE);
        
        // Render the HTML as PDF
         $dompdf->render();
         $dompdf->stream($title.'.pdf');
        

        // echo '<pre>';
        // print_r($meters);
        // echo '</pre>';

         
    }

    // delete a record from a database
    public function deleteWaterMeter($id)
    {

        $this->waterMeterModel->deleteRecord($id);
        $this->session->setFlashdata('Success', 'Record Deleted Successfully');
        return redirect()->to('/WaterMeterList');
    }

    // Edit a record from a database
    public function editWaterMeter($id)
    {
        $data = [];
        $data['record'] = $this->waterMeterModel->editRecord($id);
        $data['validation'] = null;

        $data['page'] = [
            "title" => "Edit WaterMeter Record",
            "heading" => "Edit  WaterMeter Record ",
        ];
        $data['statusResult'] = ['Pass', 'Rejected'];
        $data['genderValues'] = ['Male', 'Female'];

        $uniqueId = $this->uniqueId;
        $managerId = $this->managerId;
        $role = $this->role;

        if ($role == 1) {
            $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
            $data['role'] = $role;
        } elseif ($role == 2) {
            $data['profile'] = $this->profileModel->getLoggedUserData($managerId);
            $data['role'] = $role;
        }

        return view('pages/WaterMeter/editWaterMeter', $data);
    }









    public function updateWaterMeter($id)
    {

        $data = [];
        $data['validation'] = null;
        $rules = [

            "metersize" => "required",
            "brand" => "required",
            "flowrate" => "required",
            "class" => "required",
            "laboratory" => "required",
            "testmethod" => "required",

            // "stickernumber"      => "required",
            // "controlnumber"      => "required",

        ];
        $data['page'] = [
            "title" => "WaterMeter",
            "heading" => "New WaterMeter",
        ];
        $data['statusResult'] = ['Pass', 'Rejected'];
        $data['genderValues'] = ['Male', 'Female'];

        return redirect()->to('/WaterMeterList');
    }
}
