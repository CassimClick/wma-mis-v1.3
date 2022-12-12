<?php

namespace App\Controllers;

//use App\Models\ScaleModel;
use \CodeIgniter\Validation\Rules;
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

class Dts extends ResourceController
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
        public $LorriesModel;
        public $vtcModel;
        public $bstModel;
        public $fstModel;
        public $flowMeterModel;
        public $waterMeterModel;
        public $commonTasks;

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


        public function __construct()
        {
                helper(['form', 'array', 'regions', 'date']);
                $this->commonTasks     = new CommonTasksLibrary;
                $this->session         = session();
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
                $this->uniqueId        = $this->session->get('dts');
                $this->role            = $this->session->get('role');
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
        // ================get all data for an Api==============
        public function analytics()
        {
                $data = [];
                $scale = $this->scaleModel->getFullData();
                $fuelPump = $this->fuelPumpModel->getFullData();
                $prePackage = $this->prePackageModel->getFullData();
                $prePackage = $this->prePackageModel->getFullData();
                $vtc = $this->vtcModel->getFullData();
                $lorries = $this->lorriesModel->getFullData();
                $bst = $this->bstModel->getFullData();
                $fst = $this->fstModel->getFullData();
                $waterMeter = $this->waterMeterModel->getFullData();

                array_push($data, $scale, $fuelPump, $prePackage, $vtc, $lorries, $bst, $fst, $waterMeter);




                if ($data) {

                        return $this->respond($data);
                } else {
                        return $this->failNotFound('No data found');
                }
        }

        public function wmaTanzania()
        {

                $data = [];
                $regions = [];
                $cities = [];
                $allAmount = [];
                $paid = [];
                $pending = [];
                foreach (renderRegions() as $city) {
                        array_push($regions, $city['region']);
                }


                foreach ($regions as $region) {

                        // ================scales==============
                        $amount = 0;
                        $paidAmount = 0;
                        $pendingAmount = 0;
                        foreach ($this->scaleModel->getAllInRegion($region) as $scale) {


                                if ($region) {
                                        if ($scale['payment'] == 'Paid') {
                                                $paidAmount += $scale['amount'];
                                                echo $paidAmount;
                                                echo '<br>';
                                        } else if ($scale['payment'] == 'Pending') {
                                                $pendingAmount += $scale['amount'];
                                                echo $pendingAmount;
                                        }
                                        $amount += $scale['amount'];
                                }
                                if ($region) {
                                        $amount += $scale['amount'];
                                }
                        }





                        // ================fuel Pump==============
                        foreach ($this->fuelPumpModel->getAllInRegion($region) as $pump) {
                                // if ($region) {
                                //         $amount += $pump['amount'];
                                // }
                        }

                        // ================Pre packages==============
                        // foreach ($this->prePackageModel->getAllInRegion($region) as $prePackaging) {
                        //         $this->prePackageCollection += $prePackaging['amount'];
                        // }
                        // // ================Vehicle Tanks==============
                        // foreach ($this->vtcModel->getAllInRegion($region) as $vehicleTanks) {
                        //         $this->vehicleTankCollection += $vehicleTanks['amount'];
                        // }

                        if ($amount > 0) {
                                // $data['amount'] = number_format($amount);
                                echo '<h4>' . $region . ' - ' . number_format($amount) . '</h4>';
                                array_push($cities, $region);
                                array_push($allAmount, $amount);
                                array_push($paid, $paidAmount);
                                array_push($pending, $pendingAmount);


                                $data['paidAmount'] = $paidAmount;
                                $data['cities'] = $cities;
                                $data['money'] = $allAmount;

                                $data['nationalReport'] = array_combine($cities, $allAmount);
                                //exit;
                                // print_r(array_combine($cities, [$allAmount, $paidAmount]));

                                function reportFunction()
                                {
                                        $args    = func_get_args();
                                        $keys    = array_shift($args);
                                        $arrayKey   = array_shift($args);
                                        $results = array();

                                        foreach ($args as $key => $array) {
                                                $vkey = array_shift($arrayKey);

                                                foreach ($array as $akey => $val) {
                                                        $result[$keys[$akey]][$vkey] = $val;
                                                }
                                        }

                                        return $result;
                                }
                                $keys   = array('u1', 'u2');
                                $regions  = $cities;
                                $paid =  [210, 486]; //$paid;
                                $pending    = [210, 486]; //$pending;
                                $total    = [210, 486]; //$allAmount;
                                $vkeys  = array('region', 'paid_amount', 'pending_amount', 'total');
                                $data['info'] = reportFunction($keys, $vkeys, $regions, $paid, $pending, $total);
                                return view('report', $data);
                        }
                }



                // echo $table->generate($data);
        }


        public function func()
        {
                function reportFunction()
                {
                        $args    = func_get_args();
                        $keys    = array_shift($args);
                        $arrayKey   = array_shift($args);
                        $results = array();

                        foreach ($args as $key => $array) {
                                $vkey = array_shift($arrayKey);

                                foreach ($array as $akey => $val) {
                                        $result[$keys[$akey]][$vkey] = $val;
                                }
                        }

                        return $result;
                }

                $keys   = array('u1', 'u2', 'u3', 'u9');
                $regions  = array('Arusha', 'Mwanza', 'Dodoma', 'Tanga');
                $paid = array(1200, 426, 840, 120);
                $pending    = array(652, 3000, 4896, 3220);
                $total    = array(652, 3000, 4896, 3220);
                $vkeys  = array('region', 'paid_amount', 'pending_amount', 'total');

                $dd =  reportFunction($keys, $vkeys, $regions, $paid, $pending, $total);
                // echo '<pre>';
                //  print_r($dd);

                $data['info'] = reportFunction($keys, $vkeys, $regions, $paid, $pending, $total);

                return view('uxui_services', $data);
        }




        public function index()
        {
                $data['page'] = [
                        "title"   => "Home | Dashboard",
                        "heading" => 'Director'
                ];

                $data['role'] = $this->role;



                if (!$this->session->has('dts')) {
                        return redirect()->to('/login');
                }


                $uniqueId = $this->uniqueId;
                $location = $this->city;
                $data['location'] = $this->city;
                $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);



                $data['scaleDetails']      = $this->scaleModel->activityFullDetails();
                $data['fuelPumpDetails']   = $this->fuelPumpModel->activityFullDetails();
                $data['prePackageDetails'] = $this->prePackageModel->activityFullDetails();
                $data['vtcDetails']        = $this->vtcModel->activityFullDetails();
                $data['sblDetails']        = $this->lorriesModel->activityFullDetails();
                $data['bstDetails']        = $this->bstModel->activityFullDetails();
                $data['fstDetails']        = $this->fstModel->activityFullDetails();
                $data['flowMeterDetails']  = $this->flowMeterModel->activityFullDetails();
                $data['waterMeterDetails'] = $this->waterMeterModel->activityFullDetails();
                return view('pages/Dts/dtsDashboard', $data);
                // return view('pages/dashboard', $data);
        }

        public function logout()
        {
                $this->session->remove('dts');
                $this->session->destroy();
                return redirect()->to('/login');
        }





        // ================Assigning a task to a group==============





        public function cool()
        {
                $res =  $this->DirectorModel->getGroupAndOfficers();

                //print_r($res);
                echo json_encode($res);
        }
}
