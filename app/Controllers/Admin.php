<?php

namespace App\Controllers;

use Config\Validation;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ProfileModel;
use App\Models\scaleModel;
use App\Models\FuelPumpModel;
use App\Models\PrePackageModel;
use App\Models\DirectorModel;
use App\Models\LorriesModel;
use App\Models\VtcModel;
use App\Models\BulkStorageTankModel;
use App\Models\FixedStorageTankModel;
use App\Models\FlowMeterModel;
use App\Models\WaterMeterModel;
use App\Libraries\CommonTasksLibrary;
use App\Models\AdminModel;

class Admin extends ResourceController
{
    // public $scaleModel;
    public $session;
    public $uniqueId;
    public $role;
    public $city;
    public $profileModel;
    public $scaleModel;
    public $fuelPumpModel;
    public $prePackageModel;
    public $DirectorModel;
    public $lorriesModel;
    public $vtcModel;
    public $bstModel;
    public $fstModel;
    public $flowMeterModel;
    public $waterMeterModel;
    public $commonTasks;
    public $admin;
    public $adminModel;


    // ================Global variables to store Amount collected in all regions==============

    public $scalesCollection;
    public $fuelPumpCollection;
    public $prePackageCollection;
    public $vehicleTankCollection;
    public $lorriesCollection;
    public $bulkStorageTankCollection;
    public $fixedStorageTankCollection;
    public $flowMeterCollection;
    public $waterMeterCollection;
    public $appRequest;
    public $email;
    public $token;


    public function __construct()
    {
        $this->token = csrf_hash();
        $this->email = \Config\Services::email();
        $this->appRequest = service('request');
        helper(['form', 'array', 'regions', 'date', 'emailTemplate', 'image']);
        $this->commonTasks     = new CommonTasksLibrary;
        $this->session         = session();
        $this->adminModel    = new AdminModel();
        $this->profileModel    = new ProfileModel();
        $this->scaleModel      = new scaleModel();
        $this->fuelPumpModel   = new FuelPumpModel();
        $this->prePackageModel = new prePackageModel();
        $this->DirectorModel   = new DirectorModel();
        $this->lorriesModel    = new LorriesModel();
        $this->vtcModel        = new VtcModel();
        $this->bstModel        = new BulkStorageTankModel();
        $this->fstModel        = new FixedStorageTankModel();
        $this->flowMeterModel  = new FlowMeterModel();
        $this->waterMeterModel = new WaterMeterModel();
        $this->uniqueId        = $this->session->get('loggedUser');
        $this->admin        =  $this->session->get('SuperAdmin');
        $this->role = $this->profileModel->getRole($this->uniqueId)->role;
        $this->city            = $this->session->get('city');
        // ==============================
        $this->scalesCollection = 0;
        $this->fuelPumpCollection = 0;
        $this->prePackageCollection = 0;
        $this->vehicleTankCollection = 0;
        $this->lorriesCollection = 0;
        $this->bulkStorageTankCollection = 0;
        $this->fixedStorageTankCollection = 0;
        $this->flowMeterCollection = 0;
        $this->waterMeterCollection = 0;
    }

    public function getVariable($var)
    {
        return $this->request->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    public function index()
    {

        $data['page'] = [
            "title"   => "Home | Dashboard",
            "heading" => 'Admin'
        ];

        $data['role'] = $this->role;





        $data['admin'] = $this->admin;
        $data['location'] = $this->city;
        $location = $this->city;
        $uniqueId = $this->uniqueId;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);



        // $data['scaleDetails']      = $this->scaleModel->getFullDataForDirector();
        // $data['fuelPumpDetails']   = $this->fuelPumpModel->getFullDataForDirector();
        // $data['prePackageDetails'] = $this->prePackageModel->getFullDataForDirector();
        $data['vtcDetails']        = $this->vtcModel->getFullDataForDirector();
        $data['sblDetails']        = $this->lorriesModel->getFullDataForDirector();
        // $data['bstDetails']        = $this->bstModel->getFullDataForDirector();
        //$data['fstDetails']        = $this->fstModel->getFullDataForDirector();
        //$data['flowMeterDetails']  = $this->flowMeterModel->getFullDataForDirector();
        $data['waterMeterDetails'] = $this->waterMeterModel->getFullDataForDirector();
        return view('pages/dashBoardEntry', $data);
        // return view('pages/dashboard', $data);
    }

    // ================get all data for an Api==============
    public function analytics()
    {

        $data = [];
        // $scale = $this->scaleModel->getFullDataForDirector();
        // $fuelPump = $this->fuelPumpModel->getFullDataForDirector();
        // $prePackage = $this->prePackageModel->getFullDataForDirector();
        // $prePackage = $this->prePackageModel->getFullDataForDirector();
        // $bst = $this->bstModel->getFullDataForDirector();
        // $fst = $this->fstModel->getFullDataForDirector();
        $vtc = $this->vtcModel->getFullDataForDirector();
        $lorries = $this->lorriesModel->getFullDataForDirector();
        $waterMeter = $this->waterMeterModel->getFullDataFoprDirector();

        // array_push($data, $scale, $fuelPump, $prePackage, $vtc, $lorries, $bst, $fst, $waterMeter);
        array_push($data, $vtc, $lorries, $waterMeter);




        if ($data) {

            return $this->respond($data);
        } else {
            return $this->failNotFound('No data found');
        }
    }

    public function wmaFullReport()
    {


        $data['page'] = [
            'title' => 'Full Report',
            'heading' => 'Full Report',
        ];


        $regions = [];
        $cities = [];
        $allAmount = [];
        $paid = [];
        $pending = [];
        $keyValues = [];
        foreach (renderRegions() as $city) {
            array_push($regions, $city['region']);
        }


        function reportFunction()
        {
            $args    = func_get_args();
            // $keys    = array_shift($args);
            $arrayKey   = array_shift($args);
            $results = array();

            foreach ($args as $key => $array) {
                $vkey = array_shift($arrayKey);

                foreach ($array as $akey => $val) {
                    $result[$akey][$vkey] = $val;
                }
            }

            return $result;
        }



        foreach ($regions as $region) {

            // ================scales==============
            $amount = 0;
            $paidAmount = 0;
            $pendingAmount = 0;
            // foreach ($this->scaleModel->getAllInRegion($region) as $scale) {

            //         if ($region) {
            //                 if ($scale->payment == 'Paid') {
            //                         $paidAmount += $scale->amount;
            //                         // echo $paidAmount;

            //                 } else if ($scale->payment == 'Pending') {
            //                         $pendingAmount += $scale->amount;
            //                         // echo $pendingAmount;
            //                 }
            //                 $amount += $scale->amount;
            //         }
            // }





            // ================fuel Pump==============
            // foreach ($this->fuelPumpModel->getAllInRegion($region) as $pump) {
            //         if ($region) {
            //                 if ($pump->payment == 'Paid') {
            //                         $paidAmount += $pump->amount;
            //                         // echo $paidAmount;

            //                 } else if ($pump->payment == 'Pending') {
            //                         $pendingAmount += $pump->amount;
            //                         // echo $pendingAmount;
            //                 }
            //                 $amount += $pump->amount;
            //         }
            // }

            //================Pre packages==============
            // foreach ($this->prePackageModel->getAllInRegion($region) as $prePackaging) {
            //         if ($region) {
            //                 if ($prePackaging->payment == 'Paid') {
            //                         $paidAmount += $prePackaging->amount;
            //                         // echo $paidAmount;

            //                 } else if ($prePackaging->payment == 'Pending') {
            //                         $pendingAmount += $prePackaging->amount;
            //                         // echo $pendingAmount;
            //                 }
            //                 $amount += $prePackaging->amount;
            //         }
            // }
            // ================Vehicle Tanks==============
            // echo '<pre>>';
            // print_r($this->vtcModel->getAllInRegion($region));
            // echo '</pre>';
            // exit;
            foreach ($this->vtcModel->getAllInRegion($region) as $vehicleTanks) {
                if ($region) {
                    if ($vehicleTanks->payment == 'Paid') {
                        $paidAmount += $vehicleTanks->amount;
                        // echo $paidAmount;

                    } else if ($vehicleTanks->payment == 'Pending') {
                        $pendingAmount += $vehicleTanks->amount;
                        // echo $pendingAmount;
                    }
                    $amount += $vehicleTanks->amount;
                }
                // print_r($amount);
                // exit;
            }
            // ================Lories==============
            foreach ($this->lorriesModel->getAllInRegion($region) as $lorries) {
                if ($region) {
                    if ($lorries->payment == 'Paid') {
                        $paidAmount += $lorries->amount;
                        // echo $paidAmount;

                    } else if ($lorries->payment == 'Pending') {
                        $pendingAmount += $lorries->amount;
                        // echo $pendingAmount;
                    }
                    $amount += $lorries->amount;
                }
            }
            // ================Bulk Storage Tanks==============
            // foreach ($this->bstModel->getAllInRegion($region) as $bst) {
            //         if ($region) {
            //                 if ($bst->payment == 'Paid') {
            //                         $paidAmount += $bst->amount;
            //                         // echo $paidAmount;

            //                 } else if ($bst->payment == 'Pending') {
            //                         $pendingAmount += $bst->amount;
            //                         // echo $pendingAmount;
            //                 }
            //                 $amount += $bst->amount;
            //         }
            // }
            // ================Fixed Storage Tanks==============
            // foreach ($this->fstModel->getAllInRegion($region) as $fst) {
            //         if ($region) {
            //                 if ($fst->payment == 'Paid') {
            //                         $paidAmount += $fst->amount;
            //                         // echo $paidAmount;

            //                 } else if ($fst->payment == 'Pending') {
            //                         $pendingAmount += $fst->amount;
            //                         // echo $pendingAmount;
            //                 }
            //                 $amount += $fst->amount;
            //         }
            // }
            // ================Flow meter==============
            // foreach ($this->flowMeterModel->getAllInRegion($region) as $flowMeter) {
            //         if ($region) {
            //                 if ($flowMeter->payment == 'Paid') {
            //                         $paidAmount += $flowMeter->amount;
            //                         // echo $paidAmount;

            //                 } else if ($flowMeter->payment == 'Pending') {
            //                         $pendingAmount += $flowMeter->amount;
            //                         // echo $pendingAmount;
            //                 }
            //                 $amount += $flowMeter->amount;
            //         }
            // }
            // ================Water Meter==============
            foreach ($this->waterMeterModel->getAllInRegion($region) as $waterMeter) {
                if ($region) {
                    if ($waterMeter->payment == 'Paid') {
                        $paidAmount += $waterMeter->amount;
                        // echo $paidAmount;

                    } else if ($waterMeter->payment == 'Pending') {
                        $pendingAmount += $waterMeter->amount;
                        // echo $pendingAmount;
                    }
                    $amount += $waterMeter->amount;
                }
            }


            if ($amount > 0) {
                // $data->amount = number_format($amount);
                // echo '<h4>' . $paidAmount .  '</h4>';


                array_push($cities, $region);
                array_push($allAmount, $amount);
                array_push($paid, $paidAmount);
                array_push($pending, $pendingAmount);


                $data['combine'] = [
                    'cities' => $cities
                ];
                $data['cities'] = $cities;
                $data['money'] = $allAmount;

                // $data['nationalReport'] = array_combine($cities, $allAmount);

                // $keys   = array('u1', 'u2', 'u3');
                $regions  = $cities;
                $paid =  $paid; //$paid;
                $pending    = $pending; //$pending;
                $total    = $allAmount; //$allAmount;
                $vkeys  = array('region', 'paid', 'pending', 'total');
                $data['fullReport'] = reportFunction($vkeys, $regions, $paid, $pending, $total);




                //  echo json_encode(reportFunction($vkeys, $regions, $paid, $pending, $total));
                // exit;
            }
        }


        $uniqueId = $this->uniqueId;
        $data['role'] = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        return view('Pages/Dts/fullReport', $data);
    }
    public function printFullReport()
    {
        if (!$this->session->has('loggedUser')) {
            return redirect()->to('login');
        }

        $data['page'] = [
            'title' => 'Full Report',
            'heading' => 'Full Report',
        ];


        $regions = [];
        $cities = [];
        $allAmount = [];
        $paid = [];
        $pending = [];
        $keyValues = [];
        foreach (renderRegions() as $city) {
            array_push($regions, $city['region']);
        }


        function reportFunctionPrint()
        {
            $args    = func_get_args();
            // $keys    = array_shift($args);
            $arrayKey   = array_shift($args);
            $results = array();

            foreach ($args as $key => $array) {
                $vkey = array_shift($arrayKey);

                foreach ($array as $akey => $val) {
                    $result[$akey][$vkey] = $val;
                }
            }

            return $result;
        }

        foreach ($regions as $region) {

            // ================scales==============
            $amount = 0;
            $paidAmount = 0;
            $pendingAmount = 0;


            foreach ($this->scaleModel->getAllInRegion($region) as $scale) {

                if ($region) {
                    if ($scale->payment == 'Paid') {
                        $paidAmount += $scale->amount;
                        // echo $paidAmount;

                    } else if ($scale->payment == 'Pending') {
                        $pendingAmount += $scale->amount;
                        // echo $pendingAmount;
                    }
                    $amount += $scale->amount;
                }
            }





            // ================fuel Pump==============
            foreach ($this->fuelPumpModel->getAllInRegion($region) as $pump) {
                if ($region) {
                    if ($pump->payment == 'Paid') {
                        $paidAmount += $pump->amount;
                        // echo $paidAmount;

                    } else if ($pump->payment == 'Pending') {
                        $pendingAmount += $pump->amount;
                        // echo $pendingAmount;
                    }
                    $amount += $pump->amount;
                }
            }

            //================Pre packages==============
            foreach ($this->prePackageModel->getAllInRegion($region) as $prePackaging) {
                if ($region) {
                    if ($prePackaging->payment == 'Paid') {
                        $paidAmount += $prePackaging->amount;
                        // echo $paidAmount;

                    } else if ($prePackaging->payment == 'Pending') {
                        $pendingAmount += $prePackaging->amount;
                        // echo $pendingAmount;
                    }
                    $amount += $prePackaging->amount;
                }
            }
            // ================Vehicle Tanks==============

            foreach ($this->vtcModel->getAllInRegion($region) as $vehicleTanks) {
                if ($region) {
                    if ($vehicleTanks->payment == 'Paid') {
                        $paidAmount += $vehicleTanks->amount;
                        // echo $paidAmount;

                    } else if ($vehicleTanks->payment == 'Pending') {
                        $pendingAmount += $vehicleTanks->amount;
                        // echo $pendingAmount;
                    }
                    $amount += $vehicleTanks->amount;
                }
            }
            // ================Lories==============
            foreach ($this->lorriesModel->getAllInRegion($region) as $lorries) {
                if ($region) {
                    if ($lorries->payment == 'Paid') {
                        $paidAmount += $lorries->amount;
                        // echo $paidAmount;

                    } else if ($lorries->payment == 'Pending') {
                        $pendingAmount += $lorries->amount;
                        // echo $pendingAmount;
                    }
                    $amount += $lorries->amount;
                }
            }
            // ================Bulk Storage Tanks==============
            foreach ($this->bstModel->getAllInRegion($region) as $bst) {
                if ($region) {
                    if ($bst->payment == 'Paid') {
                        $paidAmount += $bst->amount;
                        // echo $paidAmount;

                    } else if ($bst->payment == 'Pending') {
                        $pendingAmount += $bst->amount;
                        // echo $pendingAmount;
                    }
                    $amount += $bst->amount;
                }
            }
            // ================Fixed Storage Tanks==============
            foreach ($this->fstModel->getAllInRegion($region) as $fst) {
                if ($region) {
                    if ($fst->payment == 'Paid') {
                        $paidAmount += $fst->amount;
                        // echo $paidAmount;

                    } else if ($fst->payment == 'Pending') {
                        $pendingAmount += $fst->amount;
                        // echo $pendingAmount;
                    }
                    $amount += $fst->amount;
                }
            }
            // ================Flow meter==============
            foreach ($this->flowMeterModel->getAllInRegion($region) as $flowMeter) {
                if ($region) {
                    if ($flowMeter->payment == 'Paid') {
                        $paidAmount += $flowMeter->amount;
                        // echo $paidAmount;

                    } else if ($flowMeter->payment == 'Pending') {
                        $pendingAmount += $flowMeter->amount;
                        // echo $pendingAmount;
                    }
                    $amount += $flowMeter->amount;
                }
            }
            // ================Water Meter==============
            foreach ($this->waterMeterModel->getAllInRegion($region) as $waterMeter) {
                if ($region) {
                    if ($waterMeter->payment == 'Paid') {
                        $paidAmount += $waterMeter->amount;
                        // echo $paidAmount;

                    } else if ($waterMeter->payment == 'Pending') {
                        $pendingAmount += $waterMeter->amount;
                        // echo $pendingAmount;
                    }
                    $amount += $waterMeter->amount;
                }
            }



            if ($amount > 0) {
                // $data->amount = number_format($amount);
                // echo '<h4>' . $paidAmount .  '</h4>';


                array_push($cities, $region);
                array_push($allAmount, $amount);
                array_push($paid, $paidAmount);
                array_push($pending, $pendingAmount);



                $data['cities'] = $cities;
                $data['money'] = $allAmount;

                // $data['nationalReport'] = array_combine($cities, $allAmount);

                // $keys   = array('u1', 'u2', 'u3');
                $regions  = $cities;
                $paid =  $paid; //$paid;
                $pending    = $pending; //$pending;
                $total    = $allAmount; //$allAmount;
                $vkeys  = array('region', 'paid', 'pending', 'total');
                $data['fullReport'] = reportFunctionPrint($vkeys, $regions, $paid, $pending, $total);
            }
        }


        $uniqueId = $this->uniqueId;
        $data['role'] = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        return view('Pages/Dts/report-print', $data);
    }



    public function regionReport($location)
    {
        if (!$this->session->has('loggedUser')) {
            return redirect()->to('login');
        }
        $region =  str_replace('%20', ' ', $location);
        $data['region'] = $region;
        $data['page'] = [
            'title' => $region . ' Report',
            'heading' => $region . ' Report',
        ];


        $data['region'] = $region;
        $data['scaleCollection']      = $this->scaleModel->scalesDetails($region);
        $data['fuelPumpCollection']  = $this->fuelPumpModel->fuelPumpDetails($region);
        $data['prePackageCollection'] = $this->prePackageModel->prePackageDetails($region);
        $data['vtcCollection']       = $this->vtcModel->vtcDetails($region);
        $data['sblCollection']        = $this->lorriesModel->sblDetails($region);
        $data['bstCollection']        = $this->bstModel->bstDetails($region);
        $data['fstCollection']        = $this->fstModel->fstDetails($region);
        $data['flowMeterCollection']  = $this->flowMeterModel->flowMeterDetails($region);
        $data['waterMeterCollection'] = $this->waterMeterModel->waterMeterDetails($region);


        $uniqueId = $this->uniqueId;

        $data['role'] = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        return view('Pages/Dts/regionalReport', $data);
    }
    function regionalReportPrint($location)
    {
        $region =  str_replace('%20', ' ', $location);
        $data['region'] = $region;
        $data['page'] = [
            'title' => $region . ' Report',
            'heading' => $region . ' Report',


        ];



        $data['scaleCollection']      = $this->scaleModel->scalesDetails($region);
        $data['fuelPumpCollection']  = $this->fuelPumpModel->fuelPumpDetails($region);
        $data['prePackageCollection'] = $this->prePackageModel->prePackageDetails($region);
        $data['vtcCollection']       = $this->vtcModel->vtcDetails($region);
        $data['sblCollection']        = $this->lorriesModel->sblDetails($region);
        $data['bstCollection']        = $this->bstModel->bstDetails($region);
        $data['fstCollection']        = $this->fstModel->fstDetails($region);
        $data['flowMeterCollection']  = $this->flowMeterModel->flowMeterDetails($region);
        $data['waterMeterCollection'] = $this->waterMeterModel->waterMeterDetails($region);


        $uniqueId = $this->uniqueId;

        $data['role'] = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        return view('Pages/Dts/regional-report-print', $data);
    }

    public function listAllScales($location)
    {



        $region =  str_replace('%20', ' ', $location);
        $data['page'] = [
            "title"   => "Scales In " . $region,
            "heading" => "Scales In " . $region,
        ];

        $uniqueId = $this->uniqueId;
        $data['role'] = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['scaleResults'] =  $this->scaleModel->getAllScales($region);
        return view('Pages/Scales/scalesList', $data);
    }
    public function listAllFuelPumps($location)
    {

        $region =  str_replace('%20', ' ', $location);
        $data['page'] = [
            "title"   => "Fuel Pumps In " . $region,
            "heading" => "Fuel Pumps In " . $region,
        ];

        $uniqueId = $this->uniqueId;
        $data['role'] = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['pumpResults'] =  $this->fuelPumpModel->getAllPumps($region);
        return view('Pages/Dts/allFuelPumpsInRegion', $data);
    }
    public function listAllPrePackage($location)
    {

        $region =  str_replace('%20', ' ', $location);
        $data['page'] = [
            "title"   => "Pre Packaging In " . $region,
            "heading" => "Pre Packaging In " . $region,
        ];

        $uniqueId = $this->uniqueId;
        $data['role'] = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['industrialPackageResults'] =  $this->prePackageModel->getAllPrePackages($region);
        return view('Pages/IndustrialPackages/listIndustrialPackages', $data);
    }
    public function listAllVehicleTanks($location)
    {


        $region =  str_replace('%20', ' ', $location);
        $data['page'] = [
            "title"   => "Vehicle Tanks In " . $region,
            "heading" => "Vehicle Tanks In " . $region,
        ];

        $uniqueId = $this->uniqueId;
        $data['role'] = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['vtcResults'] =  $this->vtcModel->getAllVtc($region);
        return view('Pages/Vtc/listVtc', $data);
    }
    public function listAllLorries($location)
    {

        $region =  str_replace('%20', ' ', $location);
        $data['page'] = [
            "title"   => "Lorries  In " . $region,
            "heading" => "Lorries  In " . $region,
        ];

        $uniqueId = $this->uniqueId;
        $data['role'] = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['lorryResults'] =  $this->lorriesModel->getAllLorries($region);
        return view('Pages/Lorries/listLorries', $data);
    }



    public function listAllWaterMeters($location)
    {

        $region =  str_replace('%20', ' ', $location);
        $data['page'] = [
            "title"   => "Water Meter In " . $region,
            "heading" => "Water Meter In " . $region,
        ];

        $uniqueId = $this->uniqueId;
        $data['role'] = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['WaterMeterResults'] =  $this->waterMeterModel->getAllWaterMeters($region);
        return view('Pages/WaterMeter/waterMeterList', $data);
    }

    public function getSingleUser()
    {
        $id = $this->getVariable('id');
        $user = $this->adminModel->getUser($id);

        return $this->response->setJSON([
            'data' => $user,
            'token' => $this->token
        ]);
    }

    public function checkEmail()
    {
        $email =  $this->appRequest->getVar('email');
        $request =  $this->profileModel->checkEmail($email);

        if ($request) {
            return $this->response->setJSON([
                'status' => 1,
                'msg' => 'Email Is Already Taken!!',
                'token' => $this->token,

            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'msg' => 'Email Available',
                'token' => $this->token,

            ]);
        }
    }

    public function createUserAccount()
    {
        $token = csrf_hash();
        if ($this->request->getMethod() == 'post') {




            $uniqueId = md5(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890' . time()));
            $userData = [
                "first_name" => $this->getVariable('firstName'),
                "last_name" => $this->getVariable('lastName'),
                "city" => $this->getVariable('region'),
                "role" => $this->getVariable('role'),
                "position" => $this->getVariable('role') == '7'  ? 'superAdmin' : 'normalUser',
                "email" => $this->getVariable('email'),
                "unique_id" => $uniqueId,



            ];

            // return $this->response->setJSON([
            //         'data' => $userData,
            //         'token' => $token,

            //     ]);
            // exit;


            $request = $this->adminModel->createUser($userData);
            if ($request) {
                $fullName = $userData['first_name'] . ' ' . $userData['last_name'];

                $to = $userData['email'];
                $subject = 'SETTING UP ACCOUNT PASSWORD';
                // $message = emailTemplate($fullName, $uniqueId, 'Welcome', 'Your account has been created');


                $data['user'] = (object)[
                    'id' => $uniqueId,
                    'name' => $fullName,
                    'contact' => 1,
                    'greetings' => 'Welcome',
                    'msg' => 'Your account has been created',
                ];
                $message = view('Pages/EmailTemplate', $data);

                // ================Email configurations==============
                $this->email->setTo($to);
                $this->email->setFrom('purposemany@gmail.com', 'WMA-MIS');
                $this->email->setSubject($subject);
                $this->email->setMessage($message);
                $this->email->send();


                return $this->response->setJSON([
                    'msg' => 'User Created Successfully',
                    'token' => $token,

                ]);
            }
        }
    }
    public function updateUser()
    {

        if ($this->request->getMethod() == 'post') {

            $id = $this->getVariable('id');
            $userData = [

                "first_name" => $this->getVariable('firstName'),
                "last_name" => $this->getVariable('lastName'),
                "city" => $this->getVariable('region'),
                "city" => $this->getVariable('region'),
                "role" => $this->getVariable('role'),
                "email" => $this->getVariable('email'),




            ];

            // return $this->response->setJSON([
            //         'data' => $userData,
            //         'token' => $this->token,

            //     ]);
            // exit;


            $request = $this->adminModel->updateUser($id, $userData);
            if ($request) {


                return $this->response->setJSON([
                    'status' => 'ok',
                    'msg' => 'User Updated Successfully',
                    'token' => $this->token,

                ]);
            }
        }
    }


    public function usersPage()
    {
        $data = [];
        $data['validation'] = null;
        $data['page'] = [
            "title"   => "Home | Dashboard",
            "heading" => 'Admin | Users'
        ];




        $data['role'] = $this->role;
        $data['admin'] = $this->admin;
        $data['location'] = $this->city;
        $uniqueId = $this->uniqueId;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);

        $data['users'] = $this->adminModel->getAllUsers();

        return view('pages/admin/users', $data);
    }

    public function getUsers(){
         return $this->response->setJSON(['users'=> $this->adminModel->getAllUsers()]);
    }


    public function changeStatus(){
        $id = $this->getVariable('id');
        $status = $this->getVariable('status');
        $userStatus = '';

        if($status == 'active'){
            $userStatus .= 'inactive';
            
        }else if($status == 'inactive'){
            $userStatus .= 'active';

        }
        // return $this->response->setJSON([
        //     'status' => $status,
        //     // 'msg' => 'Account Status Changed',
        //     'token' => $this->token,

        // ]);

        // exit;
        $request = $this->adminModel->changeStatus($id, $status);

        if ($request) {
            return $this->response->setJSON([
                'status' => 1,
                'msg' => 'Account Status Changed',
                'token' => $this->token,

            ]);
        }
    }


    public function activateAccount($id)
    {
        $request = $this->adminModel->activateAccount($id);

        if ($request) {
            $this->session->setFlashdata('Success', 'Account Activated Successfully');
            return redirect()->to('/admin/users');
        }
    }
    public function deactivateAccount($id)
    {
        $request = $this->adminModel->deactivateAccount($id);

        if ($request) {
            $this->session->setFlashdata('Success', 'Account Deactivated Successfully');
            return redirect()->to('/admin/users');
        }
    }

    public function editUser($id)
    {
        $data['page'] = [
            "title"   => "Home | Dashboard",
            "heading" => 'Admin |Update User'
        ];
        $data['role'] = $this->role;
        $data['admin'] = $this->admin;
        $data['location'] = $this->city;
        $uniqueId = $this->uniqueId;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);

        $data['user'] = $this->adminModel->getUser($id);




        return view('pages/admin/editUser', $data);
    }

    public function resetPassword()
    {


        $id = $this->getVariable('id');
        $user = $this->adminModel->getUser($id);
        $name = $user->first_name . ' ' . $user->last_name;


        $to = $user->email;
        $subject = 'RESETTING ACCOUNT  PASSWORD';

        // $message = emailTemplate($name, $id, 'Hello', 'Your password has been reset');
        $data['user'] = (object)[
            'id' => $id,
            'name' => $name,
            'contact' => 0,
            'greetings' => 'Hello',
            'msg' => 'Your password has been reset',
        ];
        $message = view('Pages/EmailTemplate',$data);


        // ================Email configurations==============
        $this->email->setTo($to);
        $this->email->setFrom('purposemany@gmail.com', 'WMA-MIS');
        $this->email->setSubject($subject);
        $this->email->setMessage($message);
        $this->email->send();

        return $this->response->setJSON([
            'status' => 1,
            'msg' => 'Password Is Reset Successfully',
            'token' => $this->token,

        ]);

        // if($this->email->send()){
          
        // }



    }
}
