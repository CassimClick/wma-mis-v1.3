<?php

namespace App\Controllers;

//use App\Models\ScaleModel;

use App\Libraries\PrePackageLibrary;
use \CodeIgniter\Validation\Rules;
use App\Models\ProfileModel;
use App\Models\scaleModel;
use App\Models\FuelPumpModel;
use App\Models\PrePackageModel;
use App\Models\ManagerModel;
use App\Models\LorriesModel;
use App\Models\VtcModel;
use App\Models\BulkStorageTankModel;
use App\Models\FixedStorageTankModel;
use App\Models\FlowMeterModel;
use App\Models\WaterMeterModel;


class Dashboard extends BaseController
{
        // public $scaleModel;
        public $session;
        public $uniqueId;
        public  $role;
        public $profileModel;
        public $scaleModel;
        public $fuelPumpModel;
        public $PrePackageModel;
        public $ManagerModel;
        public $LorriesModel;
        public $vtcModel;
        public $bstModel;
        public $fstModel;
        public $flowMeterModel;
        public $waterMeterModel;
        public $PrePackageLibrary;


        public function __construct()
        {
                $this->session = session();
                $this->profileModel = new ProfileModel();
                $this->PrePackageLibrary = new PrePackageLibrary();
                $this->scaleModel = new scaleModel();
                $this->fuelPumpModel          = new FuelPumpModel();
                $this->PrePackageModel = new PrePackageModel();
                $this->ManagerModel           = new ManagerModel();
                $this->lorriesModel           = new LorriesModel();
                $this->vtcModel               = new VtcModel();
                $this->bstModel               = new BulkStorageTankModel();
                $this->fstModel               = new FixedStorageTankModel();
                $this->flowMeterModel         = new FlowMeterModel();
                $this->waterMeterModel        = new WaterMeterModel();
                $this->uniqueId = $this->session->get('loggedUser');
                $this->role = $this->profileModel->getRole($this->uniqueId)->role;
        }

        public function index()
        {
                $data['page'] = [
                        "title"   => "Home | Dashboard",
                        "heading" => "Dashboard",

                ];

                $data['role'] = $this->role;

              


                $uniqueId = $this->uniqueId;
                $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
                // ================Render Total Number Of Records in Each Category==============
                $data['totalScales'] = $this->scaleModel->getRegisteredScales($uniqueId);
                $data['totalPumps'] = $this->fuelPumpModel->getRegisteredPumps($uniqueId);
                // $data['totalPrePackages'] = $this->PrePackageModel->getPrePackages($uniqueId);
                $data['prePackageData'] = $this->PrePackageLibrary->formatDataset($this->PrePackageModel->prePackageData($uniqueId));
                $data['totalVehicleTanks'] = $this->vtcModel->getRegisteredVtc($uniqueId);
                $data['totalLorries'] = $this->lorriesModel->getRegisteredLorries($uniqueId);
                $data['totalBst'] = $this->bstModel->getRegisteredBulkStorageTank($uniqueId);
                $data['totalFst'] = $this->fstModel->getRegisteredFixedStorageTank($uniqueId);
                $data['totalFlowMeter'] = $this->flowMeterModel->getRegisteredFlowMeter($uniqueId);
                $data['totalWaterMeter'] = $this->waterMeterModel->getRegisteredWaterMeters($uniqueId);
                return view('pages/dashBoardEntry', $data);
                // return view('pages/dashboard', $data);
        }

        public function logout()
        {
                 $this->session->remove('loggedUser');
                $this->session->remove('role');
                $this->session->destroy();
                return redirect()->to(\base_url().'/login');
        }

        // public function totalScales()
        // {

        //         $uniqueId = $this->uniqueId;
        //         $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        //         $data['total'] = $this->scaleModel->totalScales($uniqueId);
        //         return view('pages/dashboard', $data);
        // }
}