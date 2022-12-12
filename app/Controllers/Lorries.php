<?php

namespace App\Controllers;

use App\Libraries\CommonTasksLibrary;
use App\Models\CustomerModel;
use App\Models\LorriesModel;
use App\Models\ProfileModel;

//use \CodeIgniter\Models\lorryModel;

class Lorries extends BaseController
{
    protected $uniqueId;
    protected $managerId;
    protected $role;
    protected $city;
    protected $lorryModel;
    protected $session;
    protected $profileModel;
    protected $CommonTasks;
    protected $token;
    protected $GfsCode;


    public function __construct()
    {
        $this->GfsCode = '14210121';
        $this->lorryModel = new LorriesModel();
        $this->profileModel = new ProfileModel();
        $this->customersModel = new CustomerModel();
        $this->session = session();
        $this->token = csrf_hash();
        $this->uniqueId = $this->session->get('loggedUser');
        $this->managerId = $this->session->get('manager');
        $this->role = $this->profileModel->getRole($this->uniqueId)->role;
        $this->city = $this->session->get('city');
        $this->CommonTasks = new CommonTasksLibrary();
        helper(['form', 'array', 'regions', 'date']);
    }

    public function getVariable($var)
    {
        return $this->request->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function searchSbl()
    {
        $hash = $this->getVariable('hash');
        $plateNumber = $this->getVariable('licensePlate');
        $request = $this->lorryModel->findMatch($hash, $plateNumber);
        if ($request) {
            return $this->response->setJSON([
                'status' => 1,
                'data' => $request,
                'token' => $this->token
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'data' => '',
                'token' => $this->token
            ]);
        }
    }

    // ================Adding customer lorry information to database ==============

    public function registerLorry()
    {

        //=================Checking the last id its available====================

        if ($this->request->getMethod() == 'post') {

            //=================Checking the last Id before incrementing it====================
            $IdValue = $this->lorryModel->checkLastId();

            foreach ($IdValue as $theTd) {
                $lastId = $theTd->id;
            }

            if (count($IdValue) < 1) {
                $instrumentId = 'SBL1';
            } else {
                $instrumentId = substr($lastId, 3);
                $instrumentId = intval($instrumentId);
                $instrumentId = 'SBL' . ($instrumentId + 1);
            }

            //=================adding extra charges when applicable====================
            $extraCharges = 0;
            $otherCharges = $this->getVariable('charges');
            if ($otherCharges == '') {
                $extraCharges += 0;
            } else {
                $extraCharges += $otherCharges;
            }

            $amount = ($this->getVariable('lorryCapacity') * 15000) + $extraCharges;
            $registrationDate = $this->getVariable('createdAt');
            $lorryDetails = [
                'id' => $instrumentId,
                'hash' => $this->getVariable('sblCustomerHash'),
                'activity' => $this->getVariable('activity'),
                'registration_date' => $this->getVariable('createdAt'),
                "next_calibration" => $this->CommonTasks->nextYear($registrationDate),

                'tin_number' => $this->getVariable('tinNumber'),
                'driver_name' => $this->getVariable('driverName'),
                'driver_license' => $this->getVariable('driverLicense'),
                'vehicle_brand' => $this->getVariable('vehicleBrand'),
                'plate_number' => $this->getVariable('plateNumber'),
                'capacity' => $this->getVariable('lorryCapacity'),
                'status' => $this->getVariable('status'),
                'sticker_number' => $this->getVariable('stickerNumber'),
                'amount' => $amount,
                'other_charges' => $extraCharges,
                'remark' => $this->getVariable('remark'),
                'unique_id' => $this->uniqueId,

            ];

            // echo json_encode($lorryDetails);
            // exit;
            $request = $this->lorryModel->registerLorryInDb($lorryDetails);

            if ($request) {
                return $this->response->setJSON([
                    'status' => 1,
                    'token' => $this->token
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => $this->token
                ]);
            }
        }
    }

    //=================check if customer has any unpaid Lorry====================
    public function getUnpaidLorries()
    {
        if ($this->request->getMethod() == 'post') {
            $hashValue = $this->getVariable('hashString');
            $instrumentIdArray = [];
            $paidVehiclesId = $this->lorryModel->filterCustomersPaidLorries($hashValue);

            //=================check if vehicle exist in lorriesRecords table====================
            if (count($paidVehiclesId) > 0) {
                foreach ($paidVehiclesId as $id) {
                    array_push($instrumentIdArray, $id->original_id);
                    //     echo json_encode($instrumentIdArray);
                    //       exit;
                }
            } else {
                array_push($instrumentIdArray, '000');
                //echo json_encode($paidVehiclesId);
            }

            $request = $this->lorryModel->getAllUnpaidLorries($hashValue, $instrumentIdArray);
            if ($request) {
                return $this->response->setJSON([
                    'status' => 1,
                    'data' => $request,
                    'token' => $this->token
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 1,
                    'data' => '',
                    'token' => $this->token
                ]);
            }
        }
    }

    //=================publish lorry info to transaction table====================
    public function publishLorryData()
    {
        if ($this->request->getMethod() == 'post') {
            $vehicleId = $this->getVariable('vehicleId');

            $hash = $this->getVariable('customerHash');
            $controlNumber = $this->getVariable('controlNumber');
            $total = $this->getVariable('totalAmount');
            $payment = $this->getVariable('payment');
            $userId = $this->uniqueId;

            $transaction = [];
            $hashArray = [];
            $controlNumberArray = [];
            $totalArray = [];
            $paymentArray = [];
            $userIdArray = [];
            // $vehicle = $this->lorryModel->findVehicle($plateNumber);

            // $lorryId = $this->lorryModel->checkLastIdByPlate($plateNumber)->id;

            $vehicleIds = array_map(fn ($id) => $id . '_' . randomString(), $vehicleId);

            //  echo json_encode($vehicleIds);
            //  exit;
            for ($i = 0; $i < count($vehicleIds); $i++) {
                array_push($hashArray, $hash);
                array_push($controlNumberArray, $controlNumber);
                array_push($totalArray, $total);
                array_push($paymentArray, $payment);
                array_push($userIdArray, $userId);
            };

            $vehicles = array_map(function ($id) {
                $vehicle = $this->lorryModel->findVehicle(substr($id, 0, 5));
                return [

                    'id' => $id,
                    'hash' => $vehicle->hash,
                    'original_id' => $vehicle->data_id,
                    'activity' => $vehicle->activity,
                    'registration_date' => date('Y-m-d'),
                    "next_calibration" => $this->CommonTasks->nextYear(date('Y-m-d')),
                    'tin_number' => $vehicle->tin_number,

                    'driver_name' => $vehicle->driver_name,
                    'driver_license' => $vehicle->driver_license,
                    'vehicle_brand' => $vehicle->vehicle_brand,
                    'plate_number' => $vehicle->plate_number,
                    'capacity' => $vehicle->capacity,
                    'status' => $vehicle->status,
                    'sticker_number' => $vehicle->sticker_number,
                    'amount' => $vehicle->amount,
                    'other_charges' => $vehicle->other_charges,
                    'remark' => $vehicle->remark,
                    'unique_id' => $this->uniqueId,
                ];
            }, $vehicleIds);





            $transactionData = [

                'instrument_id' => $vehicleIds,
                'customer_hash' =>   $hashArray,
                'control_number' =>   $controlNumberArray,
                'amount' =>   $totalArray,
                'payment' =>   $paymentArray,
                'unique_id' => $userIdArray,
            ];

            $customer = $this->customersModel->selectCustomer($hash);
            $printedBy = $this->profileModel->getLoggedUserData($this->uniqueId);
            $createdBy = $this->profileModel->getLoggedUserData($vehicles[0]['unique_id']);

            $items = array_map(fn ($vehicle) => [
                'product' => $vehicle['vehicle_brand'] . ' ' . $vehicle['plate_number'] . ' ' . $vehicle['capacity'] . ' m<sup>3</sup>',
                'amount' => number_format($vehicle['amount']),
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
            //     'status' => 1,
            //     'bill' => $bill,
            //     'transaction' => $transaction,
            //     'vehicles' => $vehicles,
            // ]);
            // exit;
            $request1 = $this->lorryModel->registerLorryTankRecord($vehicles);
            $request2 = $this->lorryModel->publishLorryTransaction($transaction);

            if ($request1 && $request2) {

                return $this->response->setJSON([
                    'status' => 1,
                    'bill' => $bill,
                    'token' => $this->token
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => $this->token
                ]);
            }
        }
    }

    public function grabLastLorry()
    {
        $lastVehicle = $this->lorryModel->grabTheLastVehicle();
        echo json_encode($lastVehicle);
    }

    // ================Adding Lorry information to database ==============
    public function addLorry()
    {
        if (!$this->session->has('loggedUser')) {
            return redirect()->to('login');
        }
        $data = [];

        $data['page'] = [
            "title" => "Sbl",
            "heading" => "Sbl",
        ];
        $data['statusResult'] = ['Pass', 'Rejected'];
        $data['genderValues'] = ['Male', 'Female'];

        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['role'] = $role;
        return view('Pages/Lorries/addLorry', $data);
    }

    public function listRegisteredLorries()
    {


        $data['page'] = [
            "title" => " Sbl List",
            "heading" => "Registered Sbl",
        ];

        $uniqueId = $this->uniqueId;
        $managerId = $this->managerId;
        $role = $this->role;
        $city = $this->city;
        $data['role'] = $role;

        if ($role == 1) {
            $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
            $data['lorryResults'] = $this->lorryModel->getRegisteredLorries($uniqueId);
        } elseif ($role == 2) {
            $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);

            $data['lorryResults'] = $this->lorryModel->getAllLorries($city);
        } elseif ($role == 3 || $role == 7) {
            $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
            $data['lorryResults'] = $this->lorryModel->getAllLorriesTz($city);
        }

        return view('Pages/Lorries/listLorries', $data);
    }

    // delete a record from a database
    public function deleteLorry($id)
    {

        $this->lorryModel->deleteRecord($id);
        $this->session->setFlashdata('Success', 'Record Deleted Successfully');
        return redirect()->to('/listLorries');
    }

    public function editSbl()
    {
        $vehicleId = $this->getVariable('id');
        $request = $this->lorryModel->getVehicle($vehicleId);
        if ($request) {
            return $this->response->setJSON([
                'status' => 1,
                'data' => $request,
                'token' => $this->token
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'data' => '',
                'token' => $this->token
            ]);
        }
    }

    // ================Update lorry Details==============
    public function updateLorry()
    {
        $amount = $this->getVariable('tankCapacity') * 15000;

        $id = $this->getVariable('theId');
        $vehicle = [

            'activity' => $this->getVariable('activity'),

            "next_calibration" => $this->CommonTasks->nextYear(date('Y-m-d')),
            'tin_number' => $this->getVariable('tinNumber'),

            'driver_name' => $this->getVariable('driverName'),
            'driver_license' => $this->getVariable('driverLicense'),
            'vehicle_brand' => $this->getVariable('vehicleBrand'),
            'plate_number' => $this->getVariable('licensePlate'),
            'capacity' => $this->getVariable('tankCapacity'),
            'status' => $this->getVariable('status'),
            'sticker_number' => $this->getVariable('stickerNumber'),
            'amount' => $amount,
            //      'other_charges' => $this->getVariable('charges'),
            'remark' => $this->getVariable('remark'),
            //      'unique_id' => $this->uniqueId,

        ];

        //echo json_encode($vehicle);
        //  exit;
        $request = $this->lorryModel->updateLorry($vehicle, $id);

        if ($request) {
            return $this->response->setJSON([
                'status' => 1,
                'token' => $this->token
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'token' => $this->token
            ]);
        }
    }
}
