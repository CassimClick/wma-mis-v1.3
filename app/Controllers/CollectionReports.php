<?php

namespace App\Controllers;

use App\Libraries\CommonTasksLibrary;
use App\Models\LorriesModel;
use App\Models\MiscellaneousModel;
use App\Models\PortModel;
use App\Models\ProfileModel;
use App\Models\VtcModel;
use App\Models\WaterMeterModel;
use App\Libraries\DownloadReport;
use App\Libraries\RenderReport;
use App\Models\PrePackageModel;
use App\Libraries\PrePackageLibrary;

// use PrePackageLibrary;

class CollectionReports extends BaseController
{
    private $uniqueId;
    //   public $uniqueId;
    private $role;
    private $city;
    private $portUnitModel;
    private $session;
    private $profileModel;
    private $CommonTasks;
    private $contacts;
    private $prePackageLibrary;

    private $vtcModel;
    private $lorriesModel;
    private $waterMeterModel;
    private $prePackageModel;

    public $sessionExpiration;

    public $variable;
    public $appRequest;

    public $renderReport;
    public $downloadReport;

    private $token;
    private $report;

    public function __construct()
    {
        $this->appRequest = service('request');
        $this->portUnitModel = new PortModel();
        $this->profileModel = new ProfileModel();
        $this->session = session();
        $this->token = csrf_hash();
        $this->report = 'Report For  Financial Year';

        $this->renderReport = new RenderReport();
        $this->downloadReport = new DownloadReport();

        $this->vtcModel = new VtcModel();
        $this->prePackageModel = new PrePackageModel();
        $this->lorriesModel = new LorriesModel();
        $this->waterMeterModel = new WaterMeterModel();
        $this->contacts = new MiscellaneousModel();
        $this->prePackageLibrary = new PrePackageLibrary();

        $this->uniqueId = $this->session->get('loggedUser');
        // $this->uniqueId = $this->session->get('loggedUser');
        $this->role = $this->profileModel->getRole($this->uniqueId)->role;
        $this->city = $this->session->get('city');
        $this->CommonTasks = new CommonTasksLibrary();
        helper(['form', 'array', 'regions', 'date', 'documents', 'image']);
    }

    public function getVariable($var)
    {
        return $this->appRequest->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }



    public function index()
    {


        $uniqueId = $this->uniqueId;
        $role = $this->role;

        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);

        $data['role'] = $role;
        $data['page'] = [
            "title" => "Reports",
            "heading" => "Reports",
        ];

        $data['role'] = $this->role;
        $data['userLocation'] = $this->city;
        return view('pages/collectionReports/wmaReport', $data);
    }





    //generate quarter report
    public function getQuarterReport()
    {

        $params = [];
        $prePackageParams = [];

        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $region = $this->city;
        $activity = $this->getVariable('activity');
        $task = $this->getVariable('task');
        $payment = $this->getVariable('payment');
        $year = $this->getVariable('year');
        $monthFrom = $this->getVariable('monthFrom');
        $monthTo = $this->getVariable('monthTo');
        $collectionRegion = $this->getVariable('region');



        $reportTitle = '';


        if ($monthFrom == 7 && $monthTo == 9) {
            $reportTitle = "Quarter One Report For  Financial Year  $year ";
        } else if ($monthFrom == 10 && $monthTo == 12) {
            $reportTitle .= "Quarter Report For  Financial Year $year ";
        } else if ($monthFrom == 1 && $monthTo == 3) {
            $reportTitle = "Quarter Report For  Financial Year $year ";
        } else if ($monthFrom == 4 && $monthTo == 6) {
            $reportTitle = "Quarter Four Report For  Financial Year $year ";
        } else if ($monthFrom == 1 && $monthTo == 12) {
            $reportTitle = "Annual Report For  Financial Year $year";
        }

        //'activity' => $task
        //'transactions.payment' => $payment





        if ($role == 1) {
            array_push($params, ['transactions.unique_id' => $uniqueId, 'YEAR(created_on) ' => $year, 'activity' => $task, 'transactions.payment' => $payment]);

            array_push($prePackageParams, ['transactions.unique_id' => $uniqueId,  'YEAR(created_on) =' => $year, 'activity' => $task, 'transactions.payment' => $payment]);
        } elseif ($role == 2) {
            array_push($params, ['customers.region' => $region,  'YEAR(created_on) =' => $year, 'activity' => $task, 'transactions.payment' => $payment]);

            array_push($prePackageParams, ['customers.region' => $region,  'YEAR(created_on) =' => $year, 'activity' => $task, 'transactions.payment' => $payment]);
        } elseif ($role == 3 || $role == 7) {



            array_push($params,  ['YEAR(created_on) ' => $year, 'customers.region' => $collectionRegion, 'activity' => $task, 'transactions.payment' => $payment]);
            // array_push($params,  ['YEAR(created_on) ' => $year]);
            array_push(
                $prePackageParams,
                [
                    'YEAR(created_on) ' => $year,
                    'activity' => $task,
                    'transactions.payment' => $payment,
                    'customers.region' => $collectionRegion,
                ]
            );
        }








        //clean parameters based on conditions
        foreach ($prePackageParams as $key => $subArr) {
            if ($collectionRegion == 'Tanzania') unset($subArr['customers.region']);
            if ($task == 'All') unset($subArr['activity']);
            if ($payment == 'All') unset($subArr['transactions.payment']);

            $prePackageParams[$key] = $subArr;
        }

        foreach ($params as $key => $subArr) {
            if ($collectionRegion == 'Tanzania') unset($subArr['customers.region']);
            if ($task == 'All') unset($subArr['activity']);
            if ($payment == 'All') unset($subArr['transactions.payment']);

            $params[$key] = $subArr;
        }



        // echo json_encode($task);
        // exit;

        $queryParams = array_merge(...$params);
        $prepackageQueryParams = array_merge(...$prePackageParams);







        $vtc =  $this->vtcModel->vtcQuarterReport($queryParams, $monthFrom, $monthTo);
        $sbl = $this->lorriesModel->sblQuarterReport($queryParams, $monthFrom, $monthTo);
        $waterMeter = $this->waterMeterModel->waterMeterQuarterReport($queryParams, $monthFrom, $monthTo);
        $prePackageData = $this->prePackageModel->prePackageQuarterReport($prepackageQueryParams, $monthFrom, $monthTo);

        $location = $role == 3 || $role == 7 ? $collectionRegion : $region;

        $url = "";
        if ($task != '' && $payment != '') {
            $url .= "/downloadQuarterReport/$activity/$monthFrom/$monthTo/$year/$task/$payment/$location";
        } elseif ($task != '') {
            $url .= "/downloadQuarterReport/$activity/$monthFrom/$monthTo/$year/$task/$location";
        } elseif ($payment != '') {
            $url .= "/downloadQuarterReport/$activity/$monthFrom/$monthTo/$year/$payment/$location";
        } else {
            // $url .= "/downloadQuarterReport/$activity/$monthFrom/$monthTo/$year/$location";
            $url .= "/downloadQuarterReport/$activity/$monthFrom/$monthTo/$year/$task/$payment/$location";
        }

        $data = (object)[
            'activity' => $activity,
            'vtc' => $vtc,
            'reportTitle' => $reportTitle . ' ' . '(' . $task . ')',
            'sbl' => $sbl,
            'waterMeter' => $waterMeter,
            'prePackage' => $this->prePackageLibrary->formatDataset(($prePackageData)),
            //'xxx' => $this->prePackageLibrary->formatDataset(($prePackageData)),
            'token' => $this->token,
            'downloadUrl' => base_url() . $url


        ];

        // echo json_encode($data->prePackage);
        // exit;


        //push data to a library and render  html
        $this->renderReport->renderActivities($data);
    }
    ##########################################################
    //=================MONTHLY REPORT====================
    ##########################################################
    public function getMonthlyReport()
    {

        $params = [];
        $prePackageParams = [];
        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $region = $this->city;

        $activity = $this->getVariable('activity');
        $task = $this->getVariable('task');
        $payment = $this->getVariable('payment');
        $year = $this->getVariable('year');
        $month = $this->getVariable('month');
        $collectionRegion = $this->getVariable('region');

        $reportTitle = '';
        if ($month == 1) {
            $reportTitle .= 'January ' . $year . ' Report';
        } else if ($month == 2) {
            $reportTitle .= 'February  ' . $year . '  Report';
        } else if ($month == 3) {
            $reportTitle .= 'March  ' . $year . '  Report';
        } else if ($month == 4) {
            $reportTitle .= 'April  ' . $year . '  Report';
        } else if ($month == 5) {
            $reportTitle .= 'May  ' . $year . '  Report';
        } else if ($month == 6) {
            $reportTitle .= 'June  ' . $year . '  Report';
        } else if ($month == 7) {
            $reportTitle .= 'july  ' . $year . '  Report';
        } else if ($month == 8) {
            $reportTitle .= 'August  ' . $year . '  Report';
        } else if ($month == 9) {
            $reportTitle .= 'September  ' . $year . '  Report';
        } else if ($month == 10) {
            $reportTitle .= 'October  ' . $year . '  Report';
        } else if ($month == 11) {
            $reportTitle .= 'November  ' . $year . '  Report';
        } else if ($month == 12) {
            $reportTitle .= 'December  ' . $year . '  Report';
        }
        //=====================================

        // 'activity' => $task,'transactions.payment'=>$payment
        if ($role == 1) {
            array_push($params, ['transactions.unique_id' => $uniqueId, 'YEAR(created_on) ' => $year, 'MONTH(created_on)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
            array_push($prePackageParams, ['transactions.unique_id' => $uniqueId, 'YEAR(prepackage.created_at) ' => $year, 'MONTH(prepackage.created_at)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
        } elseif ($role == 2) {
            array_push($params, ['customers.region' => $region,  'YEAR(created_on) =' => $year, 'MONTH(created_on)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
            array_push($prePackageParams, ['customers.region' => $region,  'YEAR(prepackage.created_at) =' => $year, 'MONTH(prepackage.created_at)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
        } elseif ($role == 3 || $role == 7) {

            if ($collectionRegion == 'Tanzania') {

                array_push($params,  ['YEAR(created_on) ' => $year, 'MONTH(created_on)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
                array_push($prePackageParams,  ['YEAR(prepackage.created_at) ' => $year, 'MONTH(prepackage.created_at)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
            } else {
                array_push($params,  ['YEAR(created_on) ' => $year, 'customers.region' => $collectionRegion, 'MONTH(created_on)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
                array_push($prePackageParams,  ['YEAR(prepackage.created_at) ' => $year, 'customers.region' => $collectionRegion, 'MONTH(prepackage.created_at)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
            }
        }



        //clean parameters based on conditions
        foreach ($prePackageParams as $key => $subArr) {
            if ($collectionRegion == 'Tanzania') unset($subArr['customers.region']);
            if ($task == 'All') unset($subArr['activity']);
            if ($payment == 'All') unset($subArr['transactions.payment']);

            $prePackageParams[$key] = $subArr;
        }

        foreach ($params as $key => $subArr) {
            if ($collectionRegion == 'Tanzania') unset($subArr['customers.region']);
            if ($task == 'All') unset($subArr['activity']);
            if ($payment == 'All') unset($subArr['transactions.payment']);

            $params[$key] = $subArr;
        }

        $queryParams = array_merge(...$params);
        $prepackageQueryParams = array_merge(...$prePackageParams);

        // echo json_encode($queryParams);
        // exit;





        $vtc = $this->vtcModel->dataReport($queryParams);
        $sbl = $this->lorriesModel->dataReport($queryParams);
        $waterMeter = $this->waterMeterModel->dataReport($queryParams);
        $prePackageData = $this->prePackageModel->dataReport($prepackageQueryParams);

        $location = $role == 3 || $role == 7 ? $collectionRegion : $region;

        $url = "";
        if ($task != '' && $payment != '') {
            $url .= "/downloadMonthlyReport/$activity/$month/$year/$task/$payment/$location";
        } elseif ($task != '') {
            $url .= "/downloadMonthlyReport/$activity/$month/$year/$task/$location";
        } elseif ($payment != '') {
            $url .= "/downloadMonthlyReport/$activity/$month/$year/$payment/$location";
        } else {

            $url .= "/downloadMonthlyReport/$activity/$month/$year/$task/$payment/$location";
        }

        $data = (object)[
            'reportTitle' => $reportTitle . ' ' . '(' . $task . ')',
            'token' => $this->token,
            'activity' => $activity,
            'vtc' => $vtc,
            'sbl' => $sbl,
            'waterMeter' => $waterMeter,
            'prePackage' => $this->prePackageLibrary->formatDataset(($prePackageData)),
            'downloadUrl' => base_url() . $url
        ];




        //push data to a library and render  html
        $this->renderReport->renderActivities($data);

        //=====================================

    }

    #############################################################
    #################### CUSTOM DATE RANGE####################
    #########################################################
    public function customDateReport()
    {
        $params = [];
        $prePackageParams = [];
        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $region = $this->city;
        $activity = $this->getVariable('activity');
        $task = $this->getVariable('task');
        $payment = $this->getVariable('payment');
        $dateFrom = $this->getVariable('dateFrom');
        $dateTo = $this->getVariable('dateTo');

        $dateTo = $this->getVariable('dateTo');
        $collectionRegion = $this->getVariable('region');

        $reportTitle = '';
        //=====================================

        if ($role == 1) {
            array_push($params, ['transactions.unique_id' => $uniqueId, 'activity' => $task, 'transactions.payment' => $payment]);
            array_push($prePackageParams, ['transactions.unique_id' => $uniqueId, 'activity' => $task, 'transactions.payment' => $payment]);
        } elseif ($role == 2) {
            array_push($params, ['customers.region' => $region, 'activity' => $task, 'transactions.payment' => $payment]);
            array_push($prePackageParams, ['customers.region' => $region, 'activity' => $task, 'transactions.payment' => $payment]);
        } elseif ($role == 3 || $role == 7) {
            array_push($params,  ['customers.region' => $collectionRegion, 'activity' => $task, 'transactions.payment' => $payment]);
            array_push($prePackageParams,  ['customers.region' => $collectionRegion, 'activity' => $task, 'transactions.payment' => $payment]);
        }

        //clean parameters based on conditions
        foreach ($prePackageParams as $key => $subArr) {
            if ($collectionRegion == 'Tanzania') unset($subArr['customers.region']);
            if ($task == 'All') unset($subArr['activity']);
            if ($payment == 'All') unset($subArr['transactions.payment']);

            $prePackageParams[$key] = $subArr;
        }

        foreach ($params as $key => $subArr) {
            if ($collectionRegion == 'Tanzania') unset($subArr['customers.region']);
            if ($task == 'All') unset($subArr['activity']);
            if ($payment == 'All') unset($subArr['transactions.payment']);

            $params[$key] = $subArr;
        }
        $queryParams = array_merge(...$params);
        $prepackageQueryParams = array_merge(...$prePackageParams);


        // echo json_encode($params);
        // exit;




        $vtc = $this->vtcModel->dateRangeReport($queryParams, $dateFrom, $dateTo);
        $sbl = $this->lorriesModel->dateRangeReport($queryParams, $dateFrom, $dateTo);
        $waterMeter = $this->waterMeterModel->dateRangeReport($queryParams, $dateFrom, $dateTo);
        $prePackageData = $this->prePackageModel->dateRangeReport($prepackageQueryParams, $dateFrom, $dateTo);

        $location = $role == 3 || $role == 7 ? $collectionRegion : $region;

        $url = "";
        if ($task != '' && $payment != '') {
            $url .= "/downloadCustomDateReport/$activity/$dateFrom/$dateTo/$task/$payment/$location";
        } elseif ($task != '') {
            $url .= "/downloadCustomDateReport/$activity/$dateFrom/$dateTo/$task/$location";
        } elseif ($payment != '') {
            $url .= "/downloadCustomDateReport/$activity/$dateFrom/$dateTo/$payment/$location";
        } else {

            $url .= "/downloadCustomDateReport/$activity/$dateFrom/$dateTo/$task/$payment/$location";
        }

        $data = (object)[


            'reportTitle' => $reportTitle .= ' ' . dateFormatter($dateFrom) . ' To ' . dateFormatter($dateTo) . '(' . $task . ')',
            'token' => $this->token,
            'activity' => $activity,
            'vtc' => $vtc,
            'sbl' => $sbl,
            'waterMeter' => $waterMeter,
            'prePackage' => $this->prePackageLibrary->formatDataset(($prePackageData)),
            'downloadUrl' => base_url() . $url
        ];



        //push data to a library and render  html
        $this->renderReport->renderActivities($data);

        //=====================================

    }

    //=================@@@@@@@@@ DOWNLOADING REPORTS @@@@@@@@@====================




    public function downloadQuarterReport($activity, $monthFrom, $monthTo, $year, $task, $payment, $collectionRegion)
    {


        $params = [];
        $prePackageParams = [];

        // echo '<pre>';

        // print_r([
        //    'activity' => $activity,
        //    'monthFrom' => $monthFrom,
        //    'x' => '45'
        // ]);
        // echo '</pre>';

        //exit;



        $reportTitle = '';




        if ($monthFrom == 7 && $monthTo == 9) {
            $reportTitle = "Quarter One Report For  Financial Year  $year ";
        } else if ($monthFrom == 10 && $monthTo == 12) {
            $reportTitle .= "Quarter Report For  Financial Year $year ";
        } else if ($monthFrom == 1 && $monthTo == 3) {
            $reportTitle = "Quarter Report For  Financial Year $year ";
        } else if ($monthFrom == 4 && $monthTo == 6) {
            $reportTitle = "Quarter Four Report For  Financial Year $year ";
        } else if ($monthFrom == 1 && $monthTo == 12) {
            $reportTitle = "Annual Report For  Financial Year $year";
        }
        $data['reportTitle'] = $reportTitle;

        $role = $this->role;
        $uniqueId = $this->uniqueId;
        $region = $this->city;


        if ($role == 1) {
            array_push($params, ['transactions.unique_id' => $uniqueId, 'YEAR(created_on) ' => $year, 'activity' => $task, 'transactions.payment' => $payment]);

            array_push($prePackageParams, ['transactions.unique_id' => $uniqueId,  'YEAR(created_on) =' => $year, 'activity' => $task, 'transactions.payment' => $payment]);
        } elseif ($role == 2) {
            array_push($params, ['customers.region' => $region,  'YEAR(created_on) =' => $year, 'activity' => $task, 'transactions.payment' => $payment]);

            array_push($prePackageParams, ['customers.region' => $region,  'YEAR(created_on) =' => $year, 'activity' => $task, 'transactions.payment' => $payment]);
        } elseif ($role == 3 || $role == 7) {



            array_push($params,  ['YEAR(created_on) ' => $year, 'customers.region' => $collectionRegion, 'activity' => $task, 'transactions.payment' => $payment]);
            // array_push($params,  ['YEAR(created_on) ' => $year]);
            array_push(
                $prePackageParams,
                [
                    'YEAR(created_on) ' => $year,
                    'activity' => $task,
                    'transactions.payment' => $payment,
                    'customers.region' => $collectionRegion,
                ]
            );
        }









        // if ($collectionRegion == 'Tanzania') {
        foreach ($prePackageParams as $key => $subArr) {
            if ($collectionRegion == 'Tanzania') unset($subArr['customers.region']);
            if ($task == 'All') unset($subArr['activity']);
            if ($payment == 'All') unset($subArr['transactions.payment']);

            $prePackageParams[$key] = $subArr;
        }

        foreach ($params as $key => $subArr) {
            if ($collectionRegion == 'Tanzania') unset($subArr['customers.region']);
            if ($task == 'All') unset($subArr['activity']);
            if ($payment == 'All') unset($subArr['transactions.payment']);

            $params[$key] = $subArr;
        }



        // echo json_encode($prePackageParams);
        // exit;

        $queryParams = array_merge(...$params);
        $prepackageQueryParams = array_merge(...$prePackageParams);



        $vtc =  $this->vtcModel->vtcQuarterReport($queryParams, $monthFrom, $monthTo);
        $sbl = $this->lorriesModel->sblQuarterReport($queryParams, $monthFrom, $monthTo);
        $waterMeter = $this->waterMeterModel->waterMeterQuarterReport($queryParams, $monthFrom, $monthTo);
        $prePackageData = $this->prePackageModel->prePackageQuarterReport($prepackageQueryParams, $monthFrom, $monthTo);

        //  echo '<pre>';

        //         print_r($sbl1);
        //         exit;
        $data = (object)[
            'collectionRegion' => $collectionRegion,
            'reportTitle' => $reportTitle,
            'activity' => $activity,
            'vtc' => $vtc,
            'sbl' => $sbl,
            'waterMeter' => $waterMeter,
            'prePackage' => $this->prePackageLibrary->formatDataset($prePackageData),
            'role' => $this->role,
            'city' => $this->city,
            'token' => $this->token,
        ];

        $this->downloadReport->activitiesDownload($data);
    }
    //--------------------------------------------------------------------
    #
    #
    #            DOWNLOADING MONTHLY REPORTS
    #
    #
    //-----------------------------------------------------------------------

    public function downloadMonthlyReport($activity, $month, $year, $task, $payment, $collectionRegion)
    {

        $params = [];
        $prePackageParams = [];

        $reportTitle = '';
        if ($month == 1) {
            $reportTitle .= 'January ' . $year . ' Report ';
        } else if ($month == 2) {
            $reportTitle .= 'February  ' . $year . '  Report';
        } else if ($month == 3) {
            $reportTitle .= 'March  ' . $year . '  Report';
        } else if ($month == 4) {
            $reportTitle .= 'April  ' . $year . '  Report';
        } else if ($month == 5) {
            $reportTitle .= 'May  ' . $year . '  Report';
        } else if ($month == 6) {
            $reportTitle .= 'June  ' . $year . '  Report';
        } else if ($month == 7) {
            $reportTitle .= 'july  ' . $year . '  Report';
        } else if ($month == 8) {
            $reportTitle .= 'August  ' . $year . '  Report';
        } else if ($month == 9) {
            $reportTitle .= 'September  ' . $year . '  Report';
        } else if ($month == 10) {
            $reportTitle .= 'October  ' . $year . '  Report';
        } else if ($month == 11) {
            $reportTitle .= 'November  ' . $year . '  Report';
        } else if ($month == 12) {
            $reportTitle .= 'December  ' . $year . '  Report';
        }
        $data['reportTitle'] = $reportTitle;

        $role = $this->role;
        $uniqueId = $this->uniqueId;
        $region = $this->city;


        //=====================================
        if ($role == 1) {
            array_push($params, ['transactions.unique_id' => $uniqueId, 'YEAR(created_on) ' => $year, 'MONTH(created_on)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
            array_push($prePackageParams, ['transactions.unique_id' => $uniqueId, 'YEAR(prepackage.created_at) ' => $year, 'MONTH(prepackage.created_at)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
        } elseif ($role == 2) {
            array_push($params, ['customers.region' => $region,  'YEAR(created_on) =' => $year, 'MONTH(created_on)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
            array_push($prePackageParams, ['customers.region' => $region,  'YEAR(prepackage.created_at) =' => $year, 'MONTH(prepackage.created_at)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
        } elseif ($role == 3 || $role == 7) {

            if ($collectionRegion == 'Tanzania') {

                array_push($params,  ['YEAR(created_on) ' => $year, 'MONTH(created_on)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
                array_push($prePackageParams,  ['YEAR(prepackage.created_at) ' => $year, 'MONTH(prepackage.created_at)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
            } else {
                array_push($params,  ['YEAR(created_on) ' => $year, 'customers.region' => $collectionRegion, 'MONTH(created_on)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
                array_push($prePackageParams,  ['YEAR(prepackage.created_at) ' => $year, 'customers.region' => $collectionRegion, 'MONTH(prepackage.created_at)' => $month, 'activity' => $task, 'transactions.payment' => $payment]);
            }
        }



        //clean parameters based on conditions
        foreach ($prePackageParams as $key => $subArr) {
            if ($collectionRegion == 'Tanzania') unset($subArr['customers.region']);
            if ($task == 'All') unset($subArr['activity']);
            if ($payment == 'All') unset($subArr['transactions.payment']);

            $prePackageParams[$key] = $subArr;
        }

        foreach ($params as $key => $subArr) {
            if ($collectionRegion == 'Tanzania') unset($subArr['customers.region']);
            if ($task == 'All') unset($subArr['activity']);
            if ($payment == 'All') unset($subArr['transactions.payment']);

            $params[$key] = $subArr;
        }

        $queryParams = array_merge(...$params);
        $prepackageQueryParams = array_merge(...$prePackageParams);

        // echo json_encode($queryParams);
        // exit;





        $vtc = $this->vtcModel->dataReport($queryParams);
        $sbl = $this->lorriesModel->dataReport($queryParams);
        $waterMeter = $this->waterMeterModel->dataReport($queryParams);
        $prePackageData = $this->prePackageModel->dataReport($prepackageQueryParams);

        $location = $role == 3 || $role == 7 ? $collectionRegion : $region;

        $url = "";
        if ($task != '' && $payment != '') {
            $url .= "/downloadMonthlyReport/$activity/$month/$year/$task/$payment/$location";
        } elseif ($task != '') {
            $url .= "/downloadMonthlyReport/$activity/$month/$year/$task/$location";
        } elseif ($payment != '') {
            $url .= "/downloadMonthlyReport/$activity/$month/$year/$payment/$location";
        } else {

            $url .= "/downloadMonthlyReport/$activity/$month/$year/$task/$payment/$location";
        }





        $data = (object)[
            'collectionRegion' => $collectionRegion,
            'reportTitle' => $reportTitle . ' ' . '(' . $task . ')',
            'activity' => $activity,
            'vtc' => $vtc,
            'sbl' => $sbl,
            'waterMeter' => $waterMeter,
            'prePackage' => $this->prePackageLibrary->formatDataset(($prePackageData)),
            'downloadUrl' => base_url() . $url,
            'role' => $this->role,
            'city' => $this->city,
            'token' => $this->token,
        ];

        $this->downloadReport->activitiesDownload($data);
    }

    //--------------------------------------------------------------
    #
    #                DOWNLOAD CUSTOM DATE REPORT
    #
    #
    //-------------------------------------------------------------

    public function downloadCustomDateReport($activity, $dateFrom, $dateTo, $task, $payment, $collectionRegion)
    {




        $params = [];
        $prePackageParams = [];

        $reportTitle = '';

        $role = $this->role;
        $uniqueId = $this->uniqueId;
        $region = $this->city;

        if ($role == 1) {
            array_push($params, ['transactions.unique_id' => $uniqueId, 'activity' => $task, 'transactions.payment' => $payment]);
            array_push($prePackageParams, ['transactions.unique_id' => $uniqueId, 'activity' => $task, 'transactions.payment' => $payment]);
        } elseif ($role == 2) {
            array_push($params, ['customers.region' => $region, 'activity' => $task, 'transactions.payment' => $payment]);
            array_push($prePackageParams, ['customers.region' => $region, 'activity' => $task, 'transactions.payment' => $payment]);
        } elseif ($role == 3 || $role == 7) {
            array_push($params,  ['customers.region' => $collectionRegion, 'activity' => $task, 'transactions.payment' => $payment]);
            array_push($prePackageParams,  ['customers.region' => $collectionRegion, 'activity' => $task, 'transactions.payment' => $payment]);
        }

        //clean parameters based on conditions
        foreach ($prePackageParams as $key => $subArr) {
            if ($collectionRegion == 'Tanzania') unset($subArr['customers.region']);
            if ($task == 'All') unset($subArr['activity']);
            if ($payment == 'All') unset($subArr['transactions.payment']);

            $prePackageParams[$key] = $subArr;
        }

        foreach ($params as $key => $subArr) {
            if ($collectionRegion == 'Tanzania') unset($subArr['customers.region']);
            if ($task == 'All') unset($subArr['activity']);
            if ($payment == 'All') unset($subArr['transactions.payment']);

            $params[$key] = $subArr;
        }
        $queryParams = array_merge(...$params);
        $prepackageQueryParams = array_merge(...$prePackageParams);



        $vtc = $this->vtcModel->dateRangeReport($queryParams, $dateFrom, $dateTo);
        $sbl = $this->lorriesModel->dateRangeReport($queryParams, $dateFrom, $dateTo);
        $waterMeter = $this->waterMeterModel->dateRangeReport($queryParams, $dateFrom, $dateTo);
        $prePackageData = $this->prePackageModel->dateRangeReport($prepackageQueryParams, $dateFrom, $dateTo);



        $data = (object)[
            'collectionRegion' => $collectionRegion,
            'reportTitle' => $reportTitle .= ' ' . dateFormatter($dateFrom) . ' To ' . dateFormatter($dateTo) . '(' . $task . ')',
            'activity' => $activity,
            'vtc' => $vtc,
            'sbl' => $sbl,
            'waterMeter' => $waterMeter,
            'prePackage' => $this->prePackageLibrary->formatDataset($prePackageData),
            'role' => $this->role,
            'city' => $this->city,
            'token' => $this->token,
        ];

        $this->downloadReport->activitiesDownload($data);
    }
}
