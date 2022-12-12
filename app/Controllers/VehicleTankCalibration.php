<?php

namespace App\Controllers;

use stdClass;
use Dompdf\Options;
use App\Models\VtcModel;
use CodeIgniter\I18n\Time;
use App\Models\ProfileModel;
use App\Models\CustomerModel;
use App\Libraries\ArrayLibrary;
use App\Libraries\CommonTasksLibrary;
use App\Libraries\VtvLibrary;

//use \CodeIgniter\Models\VtcModel;

class VehicleTankCalibration extends BaseController
{
    protected $uniqueId;
    protected $managerId;
    protected $role;
    protected $city;
    protected $VtcModel;
    protected $session;
    protected $profileModel;
    protected $CommonTasks;
    protected $token;
    protected $customersModel;
    protected $vtvLibrary;
    protected $GfsCode;


    public function __construct()
    {
        $this->GfsCode = '14220104';
        $this->VtcModel = new VtcModel();
        $this->vtvLibrary = new VtvLibrary();
        $this->profileModel = new ProfileModel();
        $this->session = session();
        $this->token = csrf_hash();
        $this->uniqueId = $this->session->get('loggedUser');
        $this->managerId = $this->session->get('manager');
        $this->role = $this->profileModel->getRole($this->uniqueId)->role;
        $this->city = $this->session->get('city');
        $this->CommonTasks = new CommonTasksLibrary();
        $this->customersModel = new CustomerModel;
        helper(['form', 'array', 'date', 'regions', 'text']);
    }


    public function getVariable($var)
    {
        return $this->request->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    //=================search vehicle tank if exists====================

    public function searchVtc()
    {
        $hash = $this->getVariable('hash');
        $plateNumber =   $this->getVariable('licensePlate');
        $request = $this->VtcModel->findMatch($hash, $plateNumber);
        if ($request) {
            return  $this->response->setJSON([
                'status' => 1,
                'data' => $request,
                'token' => $this->token,
            ]);
        } else {
            return  $this->response->setJSON([
                'status' => 1,
                'msg' => 'empty',
                'data' => $request,
                'token' => $this->token,
            ]);
        }
    }
    // ================Adding Vtc information to database ==============

    public function newVehicleTank()
    {
        if ($this->request->getMethod() == 'post') {
            //=================Checking the last Id before incrementing it====================
            $lastId = $this->VtcModel->checkLastId();
            // $lastId ? $lastId->id : '';
            $instrumentId = '';


            if ($lastId != '') {
                $instrumentId .= increment_string($lastId->id);
            } else {
                $instrumentId .= 'VTV_1';
            }



            //=================adding extra charges when applicable====================





            $registrationDate =   date('Y-m-d');
            $hash = $this->getVariable('customerId');
            $vehicleTank = [
                'id' => $instrumentId,
                'hash' =>   $hash,
                'activity' =>   $this->getVariable('activity'),
                'registration_date' =>   $registrationDate,
                "next_calibration" => $this->CommonTasks->nextYear($registrationDate),
                'tin_number' =>   $this->getVariable('tinNumber'),

                'driver_name' =>   $this->getVariable('driverName'),
                'driver_license' =>   $this->getVariable('driverLicense'),
                'vehicle_brand' =>   $this->getVariable('vehicleBrand'),
                'compartments' =>   $this->getVariable('compartments'),
                'hose_plate_number' =>   $this->getVariable('hosePlateNumber'),
                'trailer_plate_number' =>   $this->getVariable('trailerPlateNumber'),

                'sticker_number' =>   $this->getVariable('stickerNumber'),

                'remark' =>   $this->getVariable('remark'),
                'unique_id' => $this->uniqueId,

            ];

            // return  $this->response->setJSON([
            //     'status' => 1,
            //     'vehicleTank' => $vehicleTank,
            //     'token' => $this->token,
            // ]);

            // exit;


            $request = $this->VtcModel->registerVehicleTank($vehicleTank);

            if ($request) {
                return  $this->response->setJSON([
                    'status' => 1,
                    'vehicles' => $this->VtcModel->getClientVehicles($hash),
                    'msg' => 'Vehicle Added',
                    'token' => $this->token,
                ]);
            } else {
                return  $this->response->setJSON([
                    'status' => 1,
                    'msg' => 'Something Went Wrong',
                    'token' => $this->token,
                ]);
            }
        }
    }

    //=================Grab last registered vehicle====================

    public function grabLastVehicle()
    {
        $lastVehicle = $this->VtcModel->grabTheLastVehicle();
        echo json_encode($lastVehicle);
    }

    //=================check if customer has any unpaid vehicle====================
    public function getUnpaidVehicles()
    {
        if ($this->request->getMethod() == 'post') {
            $hashValue =   $this->getVariable('hashValue');
            $instrumentIdArray = [];
            $paidVehiclesId = $this->VtcModel->filterCustomersPaidVehicles($hashValue);
            //=================check if vehicle exist in transaction table====================
            if (count($paidVehiclesId) > 0) {
                foreach ($paidVehiclesId as $id) {
                    array_push($instrumentIdArray, $id->original_id);
                    // echo $id->instrument_id;

                }
            } else {
                array_push($instrumentIdArray, '000x');
            }

            $request = $this->VtcModel->getAllUnpaidVehicles($hashValue, $instrumentIdArray);

            $vehicles = new ArrayLibrary($request);


            $noOfCompartments = $vehicles->map(function ($vehicle) {
                $data = $vehicle;
                $data->compartments = $this->VtcModel->getCompartments($vehicle->id);

                return
                    "<option value='$vehicle->id'>$vehicle->vehicle_brand |Hose: $vehicle->hose_plate_number | Trailer: $vehicle->trailer_plate_number </option>";
            })->get();




            $options = '';
            foreach ($noOfCompartments as $option) {
                $options .= $option;
            }

            $dropdown = <<<"HTML"
              <label>Vehicles</label>
              <select  class='form-control' onchange='getVehicleDetails(this.value)'>
                <option selected value="">--Select Vehicle--</option>
                  $options 
              </select>
             HTML;






            if ($request) {

                return  $this->response->setJSON([
                    'status' => 1,
                    'compartmentDropdown' => $dropdown,
                    'data' => $request,
                    'token' => $this->token,
                ]);
            } else {
                return  $this->response->setJSON([
                    'status' => 0,
                    'compartmentDropdown' => '<p>No Data Found</p>',
                    'msg' => 'No Data Found',
                    'token' => $this->token,
                ]);
            }
        }
    }
    public function checkCompartments($id): bool
    {
        $check = $this->VtcModel->getCompartments($id);
        if ($check) {
            return true;
        } else {
            return false;
        }
    }

    public function getVehicleDetails()
    {
        $id = $this->getVariable('vehicleId');
        $vehicle = $this->VtcModel->getVehicleDetails($id);
        $vehicle->hasCompartments = $this->checkCompartments($id);

        $compartmentBlocks = $vehicle->compartments;

        $tankCompartments = $this->VtcModel->getCompartments($id);


        $data = new ArrayLibrary((array)$tankCompartments);
        $availableCompartments =  count(array_unique($data->map(fn ($c) => $c->compartment_number)->get()));

        if ($tankCompartments != '') {

            $filledCompartments = $this->groupCompartments((array)$tankCompartments, 'compartment_number');
        } else {
            $filledCompartments = [];
        }


        $html = '';
        if ($vehicle != null) {
            $html .= <<<"HTML"
           <div class="card">
                                <div class="card-body">
                                     <input type="text" class="form-control" value="$vehicle->id" name="vehicleId" id="vehicleId" hidden>
                                     <input type="text" class="form-control" value="$vehicle->compartments" name="totalCompartments" id="totalCompartments" hidden>
                                    <table class="table table-default table-sm">
                                        <tr>
                                            <td><b>Activity</b></td>
                                            <td> $vehicle->activity </td>
                                        </tr>
                                        <tr>
                                            <td><b>Vehicle Brand</b></td>
                                            <td>$vehicle->vehicle_brand</td>
                                        </tr>
                                        <tr>
                                            <td><b>Number Of Compartments</b></td>
                                            <td>$vehicle->compartments Compartments</td>
                                        </tr>
                                        <tr>
                                            <td><b>Hose Plate Number</b></td>
                                            <td>$vehicle->hose_plate_number</td>
                                        </tr>
                                        <tr>
                                            <td><b>trailer Plate Number</b></td>
                                            <td>$vehicle->trailer_plate_number</td>
                                        </tr>
                                        <tr>
                                            <td><b>Driver</b></td>
                                            <td>$vehicle->driver_name</td>
                                        </tr>
                                        <tr>
                                            <td><b>Driver License</b></td>
                                            <td>$vehicle->driver_license</td>
                                        </tr>
                                        <tr>
                                            <td><b>TIN Number</b></td>
                                            <td>$vehicle->tin_number</td>
                                        </tr>
                                         
        HTML;

            $chart = $tankCompartments == []   ? (object)['complete' => false] : $this->vtvLibrary->formatCompartmentData($tankCompartments, $availableCompartments);


            if (!$chart->complete) {
                $html .=  <<<"HTML"
                                        <tr>
                                            <td><b>Chart</b></td>
                                           
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addChart">
                                                    <i class="far fa-plus"></i> Create Chart
                                                </button>
                                             
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
         HTML;
            }
        } else {
            $html = '';
        }

        $noOfCompartments = '<option  disabled>--Select Compartment--</option>';

        $list = array_unique(array_map(fn ($c) => preg_replace("/[^0-9]/", "", $c->compartment_number), $tankCompartments));

        for ($i = 1; $i <= $vehicle->compartments; $i++) {
            if (!in_array($i, $list)) {


                $noOfCompartments .=
                    <<<"HTML"
          <option  value='Compartment_$i'>Compartment No $i </option>
            }
          
        HTML;
            }
        }




        return $this->response->setJSON([
            'vehicleId' => $id,
            'tankCompartments' => $tankCompartments,
            'status' => 1,
            'vehicle' => $html,
            'noOfCompartments' => $noOfCompartments,
            'chart' => $tankCompartments == []  ? '' : $chart,
            'chartCount' => count((array)$filledCompartments),
            'data' => [
                'filledCompartments' => array_values($filledCompartments),
                'available' => $list,
            ],
            // 'data' => $availableCompartments,
            'token' => $this->token,
        ]);
    }




    //=================group similar compartments data====================
    public function groupCompartments($array, $key): array
    {
        $result = new stdClass();
        // $result = [];

        foreach ($array as $val) {
            if (isset($key, $val)) {
                $data = $val->$key;
                $result->$data[] = $val;
            } else {
                $data = [''];
                $result->$data[] = $val;
            }
        }
        // foreach ($array as $val) {
        //     if (isset($key, $val)) {
        //         $data = $val[$key];
        //         $result[$data][] = $val;
        //     } else {
        //         $data = [''];
        //         $result[$data][] = $val;
        //     }
        // }

        return (array)$result;
    }

    //============Publish in transaction table==============

    public function createChart()
    {
        $vehicleId = $this->getVariable('vehicleId');
        $totalCompartments = (int)$this->getVariable('totalCompartments');
        $compartmentNumber = $this->getVariable('compNumber');
        $tankTop = $this->getVariable('tankTop');
        $stampNumber = $this->getVariable('stampNumber');
        $millimeters = $this->getVariable('millimeters');
        $litres = $this->getVariable('litres');
        $tankTopArr = [];
        $stampArr = [];
        $vehicleIdz = [];
        $compartments = [];
        $userId = [];
        for ($i = 0; $i < count($litres); $i++) {
            array_push($tankTopArr, $tankTop);
            array_push($stampArr, $stampNumber);
            array_push($vehicleIdz, $vehicleId);
            array_push($compartments, $compartmentNumber);
            array_push($userId, $this->uniqueId);
        }

        $vehicle = $this->VtcModel->getVehicleDetails($vehicleId);
        $compartmentBlocks = $vehicle->compartments;

        $data = [
            'vehicle_id' => $vehicleIdz,
            'compartment_number' => $compartments,
            'tank_top' => $tankTopArr,
            'stamp_number' => $stampArr,
            'litres' => $litres,
            'millimeters' => $millimeters,
            'unique_id' => $userId,
        ];

        $compartment = [];
        foreach ($data as $key => $value) {
            for ($i = 0; $i < count($value); $i++) {
                $compartment[$i][$key] = $value[$i];
            }
        }

        $tankComp = [];
        for ($i = 1; $i <= $totalCompartments; $i++) {
            array_push($tankComp, 'Compartment_' . $i);
        }


        $request = $this->VtcModel->addCompartmentData($compartment);
        $tankCompartments = $this->VtcModel->getCompartments($vehicleId);
        // $request = true;
        if ($request) {

            $noOfCompartments = '<option  disabled>--Select Compartment--</option>';

            $list = array_unique(array_map(fn ($c) => preg_replace("/[^0-9]/", "", $c->compartment_number), $tankCompartments));

            for ($i = 1; $i <= $vehicle->compartments; $i++) {
                if (!in_array($i, $list)) {

                    $noOfCompartments .=
                        <<<"HTML"
          <option  value='Compartment_$i'>Compartment No $i </option>
            }
          
        HTML;
                }
            }



            $data = new ArrayLibrary((array)$tankCompartments);
            $availableCompartments =  count(array_unique($data->map(fn ($c) => $c->compartment_number)->get()));


            $filledCompartments = $this->groupCompartments((array)$tankCompartments, 'compartment_number');

            return $this->response->setJSON([
                'status' => 1,
                'msg' => 'Compartment Data Added',
                'chart' =>  $tankCompartments == []   ? [] : $this->vtvLibrary->formatCompartmentData($tankCompartments, $availableCompartments),
                'compartmentsMenu' => $noOfCompartments,
                'filled' => count((array)$filledCompartments),
                'token' => $this->token
            ]);
        }

        //001


        return $this->response->setJSON([
            'status' => 1,
            // 'msg' => 'Compartment Data Added',
            'data' => $compartment,
            'totalCompartments' => $tankComp,
            // 'noOfCompartments' => $noOfCompartments,
            'token' => $this->token
        ]);
    }



    //=================Get fully calibrated tanks====================

    public function getCalibratedTanks()
    {
        $customerId =   $this->getVariable('customerId');
        $instrumentIdArray = [];
        $paidVehiclesId = $this->VtcModel->filterCustomersPaidVehicles($customerId);
        //=================check if vehicle exist in transaction table====================
        if (count($paidVehiclesId) > 0) {
            foreach ($paidVehiclesId as $id) {
                array_push($instrumentIdArray, $id->original_id);
                // echo $id->instrument_id;

            }
        } else {
            array_push($instrumentIdArray, '000x');
        }

        $request = $this->VtcModel->getAllUnpaidVehicles($customerId, $instrumentIdArray);

        $vehicles = new ArrayLibrary($request);


        // $keys = array_keys((array)$request[0]);




        $withCompartments = $vehicles->map(function ($vehicle) {
            $data = $vehicle;
            $compartments = $this->VtcModel->getCompartments($vehicle->id);
            $compartmentBlocks = new ArrayLibrary($compartments);
            $data->filled = count(array_unique($compartmentBlocks->map(fn ($c) => $c->compartment_number)->get()));
            $data->compartmentNumber = $vehicle->compartments;
            $data->compartmentData = $compartments;
            return $data;
        })->filter(fn ($v) => !empty($v->compartmentData) && ($v->filled ==  $v->compartmentNumber))->map(
            function ($v) {

                $capacity = $this->vtvLibrary->formatCompartmentData($this->VtcModel->getCompartments($v->id), $v->compartments)->capacity;
                $totalAmount = $capacity * 15;

                $amountLabel = number_format($totalAmount);
                $capacityLabel = number_format($capacity);

                return <<<"HTML"
                 <tr>
                   
                    <td scope="row">
                        <input type="text" class="form-control" value="$v->id" name="vehicleId[]" hidden >
                        <input type="text" class="form-control" value="$v->hash" name="customerHash[]" hidden >
                        $v->vehicle_brand
                    </td>
                    <td>$v->hose_plate_number</td>
                    <td>$v->trailer_plate_number</td>
                    <td>
                      <input type="text" class="form-control" value="$capacity" name="capacity[]" hidden >  
                    $capacityLabel Litre</td>
                    <td>
                          <input type="text" class="form-control vehicleAmount" value="$totalAmount" name="totalAmount[]" hidden >
                       Tsh $amountLabel 
                    </td>
                    <td>
                        
                        <button type="button" class="btn btn-success btn-xs" onclick="removeItem(this)">
                            <i class="far fa-minus-circle"></i>
                        </button>
                        <!-- <button type="button" class="btn btn-success btn-xs">
                            <i class="fal fa-file-chart-line"></i>
                        </button> -->
                    </td>
                </tr>
             HTML;
            }
        )->get();
        $vehicleData = '';

        foreach ($withCompartments as $compData) {
            $vehicleData .= $compData;
        }


        $html = <<<"HTML"
  <table class="table table-sm mb-3">
            <thead>
                <tr>
                    
                    <th>Brand</th>
                    <th>Hose Plate Number</th>
                    <th>Trailer Plate Number</th>
                    <th>Capacity</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                 $vehicleData

            </tbody>
           
        </table>
        <div class="form-group">
            <label for="my-input">Total Amount</label>
            <input id="totalAmount" class="form-control" value="" type="number" name="" readonly>
        </div>
 HTML;






        return $this->response->setJSON([
            'status' => 1,
            'htmlTable' => $html,
            'token' => $this->token,
        ]);
    }

    public function downloadCalibrationChart($vehicleId)
    {
        $tankCompartments = $this->VtcModel->getCompartments($vehicleId);

        $tankData = new ArrayLibrary((array)$tankCompartments);
        $availableCompartments =  count(array_unique($tankData->map(fn ($c) => $c->compartment_number)->get()));

        $orientation =   $availableCompartments >= 5 ? 'landscape' : 'portrait';
        $title = 'Chart-' . randomString();
        $data['title'] = $title;
        $data['chart'] = $tankCompartments == []   ? [] : $this->vtvLibrary->formatCompartmentData($tankCompartments, $availableCompartments);

        $dompdf = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();
        $dompdf->loadHtml(view('Pages/Vtc/CalibrationChart', $data));
        $dompdf->setPaper('A4', $orientation);
        $options->set('isRemoteEnabled', false);

        // Render the HTML as PDF
        $dompdf->render();
        $dompdf->stream($title . ".pdf", array("Attachment" => 1));
    }








    public function publishVtcData()
    {
        if ($this->request->getMethod() == 'post') {
            $vehicleIdz =   $this->getVariable('vehicleId');
            $hash = $this->getVariable('customerHash');
            $controlNumber = $this->getVariable('controlNumber');
            $total = $this->getVariable('totalAmount');
            $capacity = $this->getVariable('capacity');
            $payment = $this->getVariable('payment');
            $userId = $this->uniqueId;

            $transaction = [];
            $hashArray = [];
            $controlNumberArray = [];
            $totalArray = [];
            $paymentArray = [];
            $userIdArray = [];

            $newVehicleId = array_map(
                fn ($id) =>
                $id . '_' . randomString(),
                $vehicleIdz
            );

            for ($i = 0; $i < count($newVehicleId); $i++) {
                // array_push($hashArray, $hash);
                array_push($controlNumberArray, $controlNumber);
                array_push($totalArray, array_sum($total));
                array_push($paymentArray, $payment);
                array_push($userIdArray, $userId);
            };



            $vehicles = array_map(function ($id) use ($newVehicleId, $total) {
                $vehicle = $this->VtcModel->findVehicle(substr($id, 0, 5));
                return  [

                    'id' => $id,
                    'hash' => $vehicle->hash,
                    'original_id' => $vehicle->data_id,
                    'activity' => $vehicle->activity,
                    'registration_date' => $vehicle->registration_date,
                    "next_calibration" => $vehicle->next_calibration,
                    'tin_number' => $vehicle->tin_number,

                    'driver_name' => $vehicle->driver_name,
                    'driver_license' => $vehicle->driver_license,
                    'vehicle_brand' => $vehicle->vehicle_brand,
                    'trailer_plate_number' => $vehicle->trailer_plate_number,
                    'trailer_plate_number' => $vehicle->trailer_plate_number,
                    'sticker_number' => $vehicle->sticker_number,
                    'remark' => $vehicle->remark,
                    'unique_id' => $this->uniqueId,
                ];
            }, $newVehicleId);


            for ($i = 0; $i < count($newVehicleId); $i++) {
                $vehicles[$i]['amount'] = $total[$i];
                $vehicles[$i]['capacity'] = $capacity[$i];
            }








            $transactionData = [

                'instrument_id' => $newVehicleId,
                'customer_hash' =>   $hash,
                'control_number' =>   $controlNumberArray,
                'amount' =>   $totalArray,
                'payment' =>   $paymentArray,
                'unique_id' => $userIdArray,
            ];


            $customer = $this->customersModel->selectCustomer($hash[0]);
            $printedBy = $this->profileModel->getLoggedUserData($this->uniqueId);
            $createdBy = $this->profileModel->getLoggedUserData($vehicles[0]['unique_id']);

            $items = array_map(fn ($vehicle) => [
                'product' => $vehicle['vehicle_brand'] . ' ' . $vehicle['trailer_plate_number'] . ' ' . $vehicle['capacity'] . ' Liters',
                'amount' => $vehicle['amount'],
            ], $vehicles);


            $bill =  [
                'controlNumber' => $transactionData['control_number'][0],
                'paymentRef' => time(),
                'payer' => $customer,
                'products' => $items,
                'billTotal' => 'Tsh ' . number_format($transactionData['amount'][0]) . ' (TZS)',
                'billTotalInWords' =>  toWords($transactionData['amount'][0]),
                'createdBy' => $createdBy->first_name . ' ' . $createdBy->last_name,
                'printedBy' => $printedBy->first_name . ' ' . $printedBy->last_name,
                'printedOn' => date('d M Y'),

            ];





            // creating multidimensional array for batch insertion
            foreach ($transactionData as $key => $value) {
                for ($i = 0; $i < count($value); $i++) {
                    $transaction[$i][$key] = $value[$i];
                }
            }
            // echo json_encode([
            //     //'amount' => $total,
            //     'data' => [
            //         'Transaction' => $transaction,
            //         'Vehicle Data' => $vehicles,
            //         'newVehicleId' => $newVehicleId,
            //     ],
            //     // 'Bill' => $bill
            // ]);
            // exit;

            // echo json_encode([
            //     'status' => 1,
            //     'Transaction' => $transaction,
            //    'Vehicle Data' => $vehicles,
            //    // 'bill' => $bill
            // ]);
            // exit;

            $request1 = $this->VtcModel->registerVehicleTankRecord($vehicles);
            $request2 = $this->VtcModel->publishVtcTransaction($transaction);

            if ($request1 && $request2) {

                return $this->response->setJSON([
                    'status' => 1,
                    'msg' => 'Vehicle Tanks Registered Successfully',
                    'bill' => $bill,
                    'token' => $this->token
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Something Went Wrong',
                    'token' => $this->token
                ]);
            }
        }
    }

    public function addVtc()
    {



        $data = [];

        $data['page'] = [
            "title" => "Vehicle Tank Verification",
            "heading" => "Vehicle Tank Verification",
        ];
        $data['statusResult'] = ['Pass', 'Rejected'];
        $data['genderValues'] = ['Male', 'Female'];

        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $data['uniqueId'] = $this->uniqueId;



        $data['role'] = $role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);


        return view('Pages/Vtc/addVtc', $data);
    }

    public function editVtc()
    {
        $vehicleId =   $this->getVariable('id');
        $request = $this->VtcModel->getVehicle($vehicleId);
        if ($request) {
            return  $this->response->setJSON([
                'status' => 1,
                'data' => $request,
                'token' => $this->token,
            ]);
        } else {
            return  $this->response->setJSON([
                'status' => 1,
                'msg' => 'empty',
                'token' => $this->token,
            ]);
        }
    }

    public function listRegisteredVtc()
    {



        $data['page'] = [
            "title" => "Registered Vehicle Tanks",
            "heading" => "Registered Vehicle Tanks",
        ];

        $uniqueId = $this->uniqueId;
        $managerId = $this->managerId;
        $role = $this->role;
        $city = $this->city;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['role'] = $role;

        if ($role == 1) {


            $data['vtcResults'] = $this->VtcModel->getRegisteredVtc($uniqueId);
        } elseif ($role == 2) {

            $data['vtcResults'] = $this->VtcModel->getAllVtc($city);
        } elseif ($role == 3 || $role == 7) {

            $data['vtcResults'] = $this->VtcModel->getVtc();
        }

        return view('Pages/Vtc/listVtc', $data);
    }

    public function updateVehicleTank()
    {
        $amount =   $this->getVariable('tankCapacity') * 15;
        // $registrationDate =    $this->getVariable('createdAt');
        $id =   $this->getVariable('theId');
        $vehicleTank = [

            'activity' =>   $this->getVariable('activity'),
            //      'registration_date' =>   $this->getVariable('createdAt'),
            //      "next_calibration" => $this->CommonTasks->nextYear($registrationDate),
            'tin_number' =>   $this->getVariable('tinNumber'),

            'driver_name' =>   $this->getVariable('driverName'),
            'driver_license' =>   $this->getVariable('driverLicense'),
            'vehicle_brand' =>   $this->getVariable('vehicleBrand'),
            'plate_number' =>   $this->getVariable('licensePlate'),
            'capacity' =>   $this->getVariable('tankCapacity'),
            'status' =>   $this->getVariable('status'),
            'sticker_number' =>   $this->getVariable('stickerNumber'),
            'amount' => $amount,
            //      'other_charges' =>   $this->getVariable('charges'),
            'remark' =>   $this->getVariable('remark'),
            //      'unique_id' => $this->uniqueId,

        ];

        // echo json_encode($vehicleTank);
        //  exit;
        $request = $this->VtcModel->updateVehicleTank($vehicleTank, $id);

        if ($request) {
            return  $this->response->setJSON([
                'status' => 1,
                'msg' => 'Vehicle Updated',
                'token' => $this->token,
            ]);
        } else {
            return  $this->response->setJSON([
                'status' => 0,
                'msg' => 'Error',
                'token' => $this->token,
            ]);
        }
    }
}
