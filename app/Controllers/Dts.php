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
use App\Libraries\PrePackageLibrary;

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
        public $prePackageLibrary;
        public $DirectorModel;
        public $lorriesModel;
        public $vtcModel;
        public $bstModel;
        public $fstModel;
        public $flowMeterModel;
        public $waterMeterModel;
        public $commonTasks;

        // ================Global variables to store Amount collected in all rg==============

        public $scalesCollection;
        public $fuelPumpCollection;
        public $prePackageCollection;
        public $vehicleTankCollection;
        public $lorriesCollection;
        public $bulkStorageTankCollection;
        public $fixedStorageTankCollection;
        public $flowMeterCollection;
        public $waterMeterCollection;

        public $locations = [];


        public function __construct()
        {
                helper(['form', 'array', 'regions', 'date', 'prePackage']);
                $this->commonTasks     = new CommonTasksLibrary;
                $this->prePackageLibrary     = new PrePackageLibrary();
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
                $this->uniqueId        = $this->session->get('loggedUser');
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
                foreach (renderRegions() as $city) {
                        // array_push($rg, $city['region']);
                        array_push($this->locations, $city['region']);
                }
        }
        // ================get all data for an Api==============
        public function analytic()
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
                $waterMeter = $this->waterMeterModel->getFullDataForDirector();

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
                $data['admin'] = null;


                $rg = [];
                $rg = [];
                $cities = [];
                $allAmount = [];
                $paid = [];
                $pending = [];
                $keyValues = [];



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

                // $data['xxx'] = $rg;

                $prePackaging = [];

                foreach ($this->locations as $region) {

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

                        // ================Water Meter==============
                        foreach ($this->waterMeterModel->getAllInRegion($region) as $waterMeter) {
                                if ($region) {
                                        if ($waterMeter->payment == 'Paid') {
                                                $amount = isset($waterMeter->amount) ? $waterMeter->amount : $waterMeter->total_amount;
                                                $paidAmount += $amount;
                                                // echo $paidAmount;

                                        } else if ($waterMeter->payment == 'Pending') {
                                                $pendingAmount += $waterMeter->amount;
                                                // echo $pendingAmount;
                                        }
                                        $amount += $amount;
                                }
                        }

                        // $data['xxx'] = $this->prePackageModel->getAllInRegion($region);


                        // ================Pre Package==============
                        foreach ($this->prePackageModel->getAllInRegion($region) as $prepackage) {
                                // echo $region.'<br>';

                                if ($region == $prepackage->region) {
                                        // array_push($prePackaging, $prepackage);

                                        if ($prepackage->payment == 'Paid') {
                                                $paidAmount += $prepackage->amount;
                                                // echo $paidAmount;

                                        } else if ($prepackage->payment == 'Pending') {
                                                $pendingAmount += $prepackage->amount;
                                                // echo $pendingAmount;
                                        }
                                        $amount += $prepackage->amount;
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
                                // $data['xxx'] = $prePackaging;
                                // $data['xxx'] = $rg;

                                // $data['nationalReport'] = array_combine($cities, $allAmount);

                                // $keys   = array('u1', 'u2', 'u3');
                                $rg  = $cities;
                                $paid =  $paid; //$paid;
                                $pending    = $pending; //$pending;
                                $total    = $allAmount; //$allAmount;
                                $vkeys  = array('region', 'paid', 'pending', 'total');
                                $data['fullReport'] = reportFunction($vkeys, $rg, $paid, $pending, $total);




                                //  echo json_encode(reportFunction($vkeys, $rg, $paid, $pending, $total));
                                // exit;
                        }
                }


                // $rg = ['Arusha', 'Mwanza', 'Temeke',  'Mbeya', 'Kilimanjaro'];

                $arr1 = [];
                foreach ($this->locations as $region) {
                        $x = $this->prePackageModel->getAllInRegion($region);
                        if ($x == []) {
                                unset($x);
                        } else {

                                array_push($arr1, $x);
                        }
                }

                $data['xxx'] = array_values($arr1);
                // $data['xxx'] = $this->locations;

                $uniqueId = $this->uniqueId;
                $data['role'] = $this->role;
                $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
                return view('Pages/Dts/fullReport', $data);
        }



















































        public function printFullReport()
        {


                $data['page'] = [
                        'title' => 'Full Report',
                        'heading' => 'Full Report',
                ];


                $rg = [];
                $cities = [];
                $allAmount = [];
                $paid = [];
                $pending = [];
                $keyValues = [];
                foreach (renderRegions() as $city) {
                        array_push($rg, $city['region']);
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

                foreach ($this->locations as $region) {

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
                                $rg  = $cities;
                                $paid =  $paid; //$paid;
                                $pending    = $pending; //$pending;
                                $total    = $allAmount; //$allAmount;
                                $vkeys  = array('region', 'paid', 'pending', 'total');
                                $data['fullReport'] = reportFunctionPrint($vkeys, $rg, $paid, $pending, $total);
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
                $data['prePackageCollection'] = $this->prePackageModel->getAllInRegion($region);
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
                $data['prePackageCollection'] = $this->prePackageModel->getAllInRegion($region);
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
                // $data['industrialPackageResults'] =  $this->prePackageModel->getAllPrePackages($region);
                $data['prePackageData'] = $this->prePackageLibrary->formatDataset($this->prePackageModel->prePackageDataRegion($region));

                return view('Pages/IndustrialPackages/listIndustrialPackages', $data);
        }
        public function listAllVehicleTanks($location)
        {
                if (!$this->session->has('loggedUser')) {
                        return redirect()->to('login');
                }

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
        public function listAllBulkStorageTanks($location)
        {
                if (!$this->session->has('loggedUser')) {
                        return redirect()->to('login');
                }

                $region =  str_replace('%20', ' ', $location);
                $data['page'] = [
                        "title"   => "Bulk Storage Tanks In " . $region,
                        "heading" => "Bulk Storage Tanks In " . $region,
                ];

                $uniqueId = $this->uniqueId;
                $data['role'] = $this->role;
                $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
                $data['bulkStorageTankResults'] =  $this->bstModel->getAllBulkStorageTank($region);
                return view('Pages/bulkstoragetank/listBulkstoragetank', $data);
        }
        public function listAllFixedStorageTanks($location)
        {

                $region =  str_replace('%20', ' ', $location);
                $data['page'] = [
                        "title"   => "Fixed Storage Tanks In " . $region,
                        "heading" => "Fixed Storage Tanks In " . $region,
                ];

                $uniqueId = $this->uniqueId;
                $data['role'] = $this->role;
                $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
                $data['FixedStorageTankResults'] =  $this->fstModel->getAllFixedStorageTank($region);
                return view('Pages/Fixedstoragetank/listFixedstoragetank', $data);
        }
        public function listAllFlowMeters($location)
        {

                $region =  str_replace('%20', ' ', $location);
                $data['page'] = [
                        "title"   => "Flow Meter In " . $region,
                        "heading" => "Flow Meter In " . $region,
                ];

                $uniqueId = $this->uniqueId;
                $data['role'] = $this->role;
                $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
                $data['FlowMeterResults'] =  $this->flowMeterModel->getAllFlowMeter($region);
                return view('Pages/FlowMeter/FlowMeterList', $data);
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











        public function index()
        {

                $data['page'] = [
                        "title"   => "Home | Dashboard",
                        "heading" => 'Director'
                ];

                $data['role'] = $this->role;
                $data['admin'] = null;



                // if (!$this->session->has('loggedUser')) {
                //         return redirect()->to('/login');
                // }


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
