<?php namespace App\Controllers;

use App\Libraries\CommonTasksLibrary;
use App\Models\LorriesModel;
use App\Models\MiscellaneousModel;
use App\Models\PortModel;
use App\Models\ProfileModel;
use App\Models\VtcModel;
use App\Models\WaterMeterModel;

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

    private $vtcModel;
    private $lorriesModel;
    private $waterMeterModel;

    public $sessionExpiration;

    public $variable;
    public $appRequest;

    public function __construct()
    {
        $this->appRequest = service('request');
        $this->portUnitModel = new PortModel();
        $this->profileModel = new ProfileModel();
        $this->session = session();

        $this->vtcModel = new VtcModel();
        $this->lorriesModel = new LorriesModel();
        $this->waterMeterModel = new WaterMeterModel();
        $this->contacts = new MiscellaneousModel();

        $this->uniqueId = $this->session->get('loggedUser');
        // $this->uniqueId = $this->session->get('loggedUser');
        $this->role = $this->profileModel->getRole($this->uniqueId)->role;
        $this->city = $this->session->get('city');
        $this->CommonTasks = new CommonTasksLibrary();
        helper(['form', 'array', 'regions', 'date', 'documents', 'image']);

    }

    public function getVariable($var)
    {
        return $this->appRequest->getVar($var, FILTER_SANITIZE_STRING);
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

//    function levels($arr){
    //        if($this->role == 1){
    //            $data = $arr;

//          echo json_encode($data);

//        }
    //    }

    //=================get quarter report with date range====================
    public function getQuarterReportWithDateRange()
    {
       
        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $region = $this->city;
        $activity = $this->getVariable('activity');
        $status = $this->getVariable('status');
        $year = $this->getVariable('year');
        $monthFrom = $this->getVariable('monthFrom');
        $monthTo = $this->getVariable('monthTo');
        $dateFrom = $this->getVariable('dateFrom');
        $dateTo = $this->getVariable('dateTo');

        $reportTitle = '';
        if ($monthFrom == 7 && $monthTo == 9) {
            $reportTitle .= 'Quarter One Report';
        }
        if ($monthFrom == 10 && $monthTo == 12) {
            $reportTitle .= 'Quarter Two Report';
        }
        if ($monthFrom == 1 && $monthTo == 3) {
            $reportTitle .= 'Quarter Three Report';
        }
        if ($monthFrom == 4 && $monthTo == 6) {
            $reportTitle .= 'Quarter Four Report';
        }

        switch ($activity) {
            case 'All':
                $title = 'All Activities ';
                $title .= $reportTitle;
                if ($role == 1) {

                    $vtc = $this->vtcModel->vtcQuarterReportWithDateRangeOfficer($uniqueId, $dateFrom, $dateTo, $monthFrom, $monthTo, $year);
                    $sbl = $this->lorriesModel->sblQuarterReportWithDateRangeOfficer($uniqueId, $dateFrom, $dateTo, $monthFrom, $monthTo, $year);
                    $waterMeter = $this->waterMeterModel->waterMeterQuarterReportWithDateRangeOfficer($uniqueId, $dateFrom, $dateTo, $monthFrom, $monthTo, $year);

                } elseif ($role == 2) {
                  
                    $vtc = $this->vtcModel->vtcQuarterReportWithDateRangeManager($region, $dateFrom, $dateTo, $monthFrom, $monthTo, $year);
                    $sbl = $this->lorriesModel->sblQuarterReportWithDateRangeManager($region, $dateFrom, $dateTo, $monthFrom, $monthTo, $year);
                    $waterMeter = $this->waterMeterModel->waterMeterQuarterReportWithDateRangeManager($region, $dateFrom, $dateTo, $monthFrom, $monthTo, $year);
                } elseif ($role == 3 || $role == 7) {
                    $vtc = $this->vtcModel->vtcQuarterReportWithDateRangeDirector($dateFrom, $dateTo, $monthFrom, $monthTo, $year);
                    $sbl = $this->lorriesModel->sblQuarterReportWithDateRangeDirector($dateFrom, $dateTo, $monthFrom, $monthTo, $year);
                    $waterMeter = $this->waterMeterModel->waterMeterQuarterReportWithDateRangeDirector($dateFrom, $dateTo, $monthFrom, $monthTo, $year);
                }

                $allActivities = [
                    'category' => 'all',
                    'title' => $title,
                    'vtc' => [
                        'vtcQuantity' => count($vtc),
                        'vtcPaidQuantity' => paidInstruments($vtc),
                        'vtcPendingQuantity' => pendingInstruments($vtc),
                        'paidVtc' => paidAmount($vtc),
                        'pendingVtc' => pendingAmount($vtc),
                        'totalVtc' => totalAmount($vtc),
                    ],
                    'sbl' => [
                        'sblQuantity' => count($sbl),
                        'sblPaidQuantity' => paidInstruments($sbl),
                        'sblPendingQuantity' => pendingInstruments($sbl),
                        'paidSbl' => paidAmount($sbl),
                        'pendingSbl' => pendingAmount($sbl),
                        'totalSbl' => totalAmount($sbl),
                    ],
                    'waterMeter' => [
                        'waterMeterQuantity' => meterQuantityAll($waterMeter),
                        'waterMeterPaidQuantity' => meterQuantityPaid($waterMeter),
                        'waterMeterPendingQuantity' => meterQuantityPending($waterMeter),
                        'paidWaterMeter' => paidAmount($waterMeter),
                        'pendingWaterMeter' => pendingAmount($waterMeter),
                        'totalWaterMeter' => totalAmount($waterMeter),
                    ],

                ];

                echo json_encode($allActivities);

                break;

            case 'vtc':
                $title = 'Vehicle Tank Verification';
                $title .= $reportTitle;
                if ($role == 1) {

                    $vtc = $this->vtcModel->vtcQuarterReportWithDateRangeOfficer($uniqueId, $dateFrom, $dateTo, $monthFrom, $monthTo, $year);
                    if ($status != '') {

                        $vtc = $this->vtcModel->vtcQuarterReportWithDateRangeOfficerWithStatus($uniqueId, $dateFrom, $dateTo, $monthFrom, $monthTo, $year, $status);
                    }
                } elseif ($role == 2) {
                    $vtc = $this->vtcModel->vtcQuarterReportWithDateRangeManager($region, $dateFrom, $dateTo, $monthFrom, $monthTo, $year);
                } elseif ($role == 3 || $role == 7) {
                    $vtc = $this->vtcModel->vtcQuarterReportWithDateRangeDirector($dateFrom, $dateTo, $monthFrom, $monthTo, $year);
                }

                $allVtc = [
                    'category' => 'vtcOnly',
                    'title' => $title,
                    'vtcDetails' => $vtc,
                    'vtc' => [

                        'vtcQuantity' => count($vtc),
                        'vtcPaidQuantity' => paidInstruments($vtc),
                        'vtcPendingQuantity' => pendingInstruments($vtc),
                        'paidVtc' => paidAmount($vtc),
                        'pendingVtc' => pendingAmount($vtc),
                        'totalVtc' => totalAmount($vtc),
                    ],

                ];

                echo json_encode($allVtc);
                break;
            case 'sbl':
                # code...
                break;
            case 'water':
                # code...
                break;

            default:
                # code...
                break;
        }

    }

    //=================only within a quarter====================
    #
    #
    #
    #                     QUARTER REPORT
    #
    #
    #
    #
    public function getQuarterReport()
    {

        $params = [];

        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $region = $this->city;
        $activity = $this->getVariable('activity');
        $status = $this->getVariable('status');
        $year = $this->getVariable('year');
        $monthFrom = $this->getVariable('monthFrom');
        $monthTo = $this->getVariable('monthTo');
        $collectionRegion = $this->getVariable('region');

        // if($role == 1){
        //     $params =

        // }elseif($role == 2){

        // }
        // elseif($role == 3 || $role == 7 ){

        // }


        $reportTitle = '';
        if ($monthFrom == 7 && $monthTo == 9) {
            $reportTitle .= 'Quarter One Report';
        }
        if ($monthFrom == 10 && $monthTo == 12) {
            $reportTitle .= 'Quarter Two Report';
        }
        if ($monthFrom == 1 && $monthTo == 3) {
            $reportTitle .= 'Quarter Three Report';
        }
        if ($monthFrom == 4 && $monthTo == 6) {
            $reportTitle .= 'Quarter Four Report';
        }

        //=====================================
        if ($role == 1) {

            $vtc = $this->vtcModel->vtcQuarterReportOfficer($uniqueId, $monthFrom, $monthTo, $year);
            $sbl = $this->lorriesModel->sblQuarterReportOfficer($uniqueId, $monthFrom, $monthTo, $year);
            $waterMeter = $this->waterMeterModel->waterMeterQuarterReportOfficer($uniqueId, $monthFrom, $monthTo, $year);

        } elseif ($role == 2) {
            $params = [$region, $monthFrom, $monthTo, $year];
            $vtc = $this->vtcModel->vtcQuarterReportManager(...$params);
            $sbl = $this->lorriesModel->sblQuarterReportManager(...$params);
            $waterMeter = $this->waterMeterModel->waterMeterQuarterReportManager(...$params);
        } elseif ($role == 3 || $role == 7) {
            if ($collectionRegion == 'Tanzania') {

                $vtc = $this->vtcModel->vtcQuarterReportDirector($monthFrom, $monthTo, $year);
                $sbl = $this->lorriesModel->sblQuarterReportDirector($monthFrom, $monthTo, $year);
                $waterMeter = $this->waterMeterModel->waterMeterQuarterReportDirector($monthFrom, $monthTo, $year);
            } else {
                $vtc = $this->vtcModel->vtcQuarterReportDirectorRegional($monthFrom, $monthTo, $year, $collectionRegion);
                $sbl = $this->lorriesModel->sblQuarterReportDirectorRegional($monthFrom, $monthTo, $year, $collectionRegion);
                $waterMeter = $this->waterMeterModel->waterMeterQuarterReportDirectorRegional($monthFrom, $monthTo, $year, $collectionRegion);
            }
        }

        //=====================================

        switch ($activity) {
            case 'All':
                $title = 'All Activities ';
                $title .= $reportTitle;

                $allActivities = [
                    'category' => 'all',
                    'title' => $title,
                    'vtc' => [
                        'vtcQuantity' => count($vtc),
                        'vtcPaidQuantity' => paidInstruments($vtc),
                        'vtcPendingQuantity' => pendingInstruments($vtc),
                        'paidVtc' => paidAmount($vtc),
                        'pendingVtc' => pendingAmount($vtc),
                        'totalVtc' => totalAmount($vtc),
                    ],
                    'sbl' => [
                        'sblQuantity' => count($sbl),
                        'sblPaidQuantity' => paidInstruments($sbl),
                        'sblPendingQuantity' => pendingInstruments($sbl),
                        'paidSbl' => paidAmount($sbl),
                        'pendingSbl' => pendingAmount($sbl),
                        'totalSbl' => totalAmount($sbl),
                    ],
                    'waterMeter' => [
                        'waterMeterQuantity' => meterQuantityAll($waterMeter),
                        'waterMeterPaidQuantity' => meterQuantityPaid($waterMeter),
                        'waterMeterPendingQuantity' => meterQuantityPending($waterMeter),
                        'paidWaterMeter' => paidAmount($waterMeter),
                        'pendingWaterMeter' => pendingAmount($waterMeter),
                        'totalWaterMeter' => totalAmount($waterMeter),
                    ],

                ];

                echo json_encode($allActivities);

                break;

            case 'vtc':
                $title = 'Vehicle Tank Verification';
                $title .= $reportTitle;

                $allVtc = [
                    'category' => 'vtcOnly',
                    'title' => $title,
                    'vtcDetails' => $vtc,
                    'vtc' => [

                        'vtcQuantity' => count($vtc),
                        'vtcPaidQuantity' => paidInstruments($vtc),
                        'vtcPendingQuantity' => pendingInstruments($vtc),
                        'paidVtc' => paidAmount($vtc),
                        'pendingVtc' => pendingAmount($vtc),
                        'totalVtc' => totalAmount($vtc),
                    ],

                ];

                echo json_encode($allVtc);
                break;
            case 'sbl':
                $title = 'Sandy and Ballast Lorries';
                $title .= $reportTitle;

                $allSbl = [
                    'category' => 'sblOnly',
                    'title' => $title,
                    'sblDetails' => $sbl,
                    'sbl' => [

                        'sblQuantity' => count($sbl),
                        'sblPaidQuantity' => paidInstruments($sbl),
                        'sblPendingQuantity' => pendingInstruments($sbl),
                        'paidSbl' => paidAmount($sbl),
                        'pendingSbl' => pendingAmount($sbl),
                        'totalSbl' => totalAmount($sbl),
                    ],

                ];

                echo json_encode($allSbl);
                break;
            case 'water':
                $title = 'Water Meters';
                $title .= $reportTitle;

                $allWaterMeter = [
                    'category' => 'waterMeterOnly',
                    'title' => $title,
                    'waterMeterDetails' => $waterMeter,
                    'waterMeter' => [

                        'waterMeterQuantity' => meterQuantityAll($waterMeter),
                        'waterMeterPaidQuantity' => meterQuantityPaid($waterMeter),
                        'waterMeterPendingQuantity' => meterQuantityPending($waterMeter),
                        'paidWaterMeter' => paidAmount($waterMeter),
                        'pendingWaterMeter' => pendingAmount($waterMeter),
                        'totalWaterMeter' => totalAmount($waterMeter),
                    ],

                ];

                echo json_encode($allWaterMeter);
                # code...
                break;

            default:
                # code...
                break;
        }

    }
    ##########################################################
    //=================MONTHLY REPORT====================
    ##########################################################
    public function getMonthlyReport()
    {
       
        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $region = $this->city;

        $activity = $this->getVariable('activity');
        $year = $this->getVariable('year');
        $month = $this->getVariable('month');
        $collectionRegion = $this->getVariable('region');

        $reportTitle = '';
        if ($month == 1) {
            $reportTitle .= 'January Report';
        } else if ($month == 2) {
            $reportTitle .= 'February Report';
        } else if ($month == 3) {
            $reportTitle .= 'March Report';
        } else if ($month == 4) {
            $reportTitle .= 'April Report';
        } else if ($month == 5) {
            $reportTitle .= 'May Report';
        } else if ($month == 6) {
            $reportTitle .= 'June Report';
        } else if ($month == 7) {
            $reportTitle .= 'july Report';
        } else if ($month == 8) {
            $reportTitle .= 'August Report';
        } else if ($month == 9) {
            $reportTitle .= 'September Report';
        } else if ($month == 10) {
            $reportTitle .= 'October Report';
        } else if ($month == 11) {
            $reportTitle .= 'November Report';
        } else if ($month == 12) {
            $reportTitle .= 'December Report';
        }
        //=====================================
        if ($role == 1) {

            $vtc = $this->vtcModel->vtcMonthlyReportOfficer($uniqueId, $month, $year);
            $sbl = $this->lorriesModel->sblMonthlyReportOfficer($uniqueId, $month, $year);
            $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportOfficer($uniqueId, $month, $year);

        } elseif ($role == 2) {
            $vtc = $this->vtcModel->vtcMonthlyReportManager($region, $month, $year);
            $sbl = $this->lorriesModel->sblMonthlyReportManager($region, $month, $year);
            $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportManager($region, $month, $year);
        } elseif ($role == 3 || $role == 7) {
            if ($collectionRegion == 'Tanzania') {

                $vtc = $this->vtcModel->vtcMonthlyReportDirector($month, $year);
                $sbl = $this->lorriesModel->sblMonthlyReportDirector($month, $year);
                $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportDirector($month, $year);
            } else {
                $vtc = $this->vtcModel->vtcMonthlyReportDirectorRegional($month, $year, $collectionRegion);
                $sbl = $this->lorriesModel->sblMonthlyReportDirectorRegional($month, $year, $collectionRegion);
                $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportDirectorRegional($month, $year, $collectionRegion);
            }
        }
        //=====================================
        switch ($activity) {
            case 'All':
                $title = 'All Activities ';
                $title .= $reportTitle;

                $allActivities = [
                    'category' => 'all',
                    'title' => $title,
                    'vtc' => [
                        'vtcQuantity' => count($vtc),
                        'vtcPaidQuantity' => paidInstruments($vtc),
                        'vtcPendingQuantity' => pendingInstruments($vtc),
                        'paidVtc' => paidAmount($vtc),
                        'pendingVtc' => pendingAmount($vtc),
                        'totalVtc' => totalAmount($vtc),
                    ],
                    'sbl' => [
                        'sblQuantity' => count($sbl),
                        'sblPaidQuantity' => paidInstruments($sbl),
                        'sblPendingQuantity' => pendingInstruments($sbl),
                        'paidSbl' => paidAmount($sbl),
                        'pendingSbl' => pendingAmount($sbl),
                        'totalSbl' => totalAmount($sbl),
                    ],
                    'waterMeter' => [
                        'waterMeterQuantity' => meterQuantityAll($waterMeter),
                        'waterMeterPaidQuantity' => meterQuantityPaid($waterMeter),
                        'waterMeterPendingQuantity' => meterQuantityPending($waterMeter),
                        'paidWaterMeter' => paidAmount($waterMeter),
                        'pendingWaterMeter' => pendingAmount($waterMeter),
                        'totalWaterMeter' => totalAmount($waterMeter),
                    ],

                ];

                echo json_encode($allActivities);

                break;

            case 'vtc':
                $title = 'Vehicle Tank Verification';
                $title .= $reportTitle;

                $allVtc = [
                    'category' => 'vtcOnly',
                    'title' => $title,
                    'vtcDetails' => $vtc,
                    'vtc' => [

                        'vtcQuantity' => count($vtc),
                        'vtcPaidQuantity' => paidInstruments($vtc),
                        'vtcPendingQuantity' => pendingInstruments($vtc),
                        'paidVtc' => paidAmount($vtc),
                        'pendingVtc' => pendingAmount($vtc),
                        'totalVtc' => totalAmount($vtc),
                    ],

                ];

                echo json_encode($allVtc);
                break;
            case 'sbl':
                $title = 'Sandy and Ballast Lorries';
                $title .= $reportTitle;

                $allSbl = [
                    'category' => 'sblOnly',
                    'title' => $title,
                    'sblDetails' => $sbl,
                    'sbl' => [

                        'sblQuantity' => count($sbl),
                        'sblPaidQuantity' => paidInstruments($sbl),
                        'sblPendingQuantity' => pendingInstruments($sbl),
                        'paidSbl' => paidAmount($sbl),
                        'pendingSbl' => pendingAmount($sbl),
                        'totalSbl' => totalAmount($sbl),
                    ],

                ];

                echo json_encode($allSbl);
                break;
            case 'water':
                $title = 'Water Meters';
                $title .= $reportTitle;

                $allWaterMeter = [
                    'category' => 'waterMeterOnly',
                    'title' => $title,
                    'waterMeterDetails' => $waterMeter,
                    'waterMeter' => [

                        'waterMeterQuantity' => meterQuantityAll($waterMeter),
                        'waterMeterPaidQuantity' => meterQuantityPaid($waterMeter),
                        'waterMeterPendingQuantity' => meterQuantityPending($waterMeter),
                        'paidWaterMeter' => paidAmount($waterMeter),
                        'pendingWaterMeter' => pendingAmount($waterMeter),
                        'totalWaterMeter' => totalAmount($waterMeter),
                    ],

                ];

                echo json_encode($allWaterMeter);
                # code...
                break;

            default:
                # code...
                break;
        }

    }

    #############################################################
    #################### CUSTOM DATE RANGE####################
    #########################################################
    public function customDateReport()
    {
       
        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $region = $this->city;
        $activity = $this->getVariable('activity');
        $dateFrom = $this->getVariable('dateFrom');
        $dateTo = $this->getVariable('dateTo');

        $dateTo = $this->getVariable('dateTo');
        $collectionRegion = $this->getVariable('region');

        $reportTitle = '';
        //=====================================
        if ($role == 1) {

            $vtc = $this->vtcModel->vtcReportWithDateRangeOfficer($uniqueId, $dateFrom, $dateTo);
            $sbl = $this->lorriesModel->sblReportWithDateRangeOfficer($uniqueId, $dateFrom, $dateTo);
            $waterMeter = $this->waterMeterModel->waterMeterReportWithDateRangeOfficer($uniqueId, $dateFrom, $dateTo);

        } elseif ($role == 2) {
            $vtc = $this->vtcModel->vtcReportWithDateRangeManager($region, $dateFrom, $dateTo);
            $sbl = $this->lorriesModel->sblReportWithDateRangeManager($region, $dateFrom, $dateTo);
            $waterMeter = $this->waterMeterModel->waterMeterReportWithDateRangeManager($region, $dateFrom, $dateTo);
        } elseif ($role == 3 || $role == 7) {
            if ($collectionRegion == 'Tanzania') {
                $vtc = $this->vtcModel->vtcReportWithDateRangeDirector($dateFrom, $dateTo);
                $sbl = $this->lorriesModel->sblReportWithDateRangeDirector($dateFrom, $dateTo);
                $waterMeter = $this->waterMeterModel->waterMeterReportWithDateRangeDirector($dateFrom, $dateTo);
            } else {
                $vtc = $this->vtcModel->vtcReportWithDateRangeDirectorRegional($dateFrom, $dateTo, $collectionRegion);
                $sbl = $this->lorriesModel->sblReportWithDateRangeDirectorRegional($dateFrom, $dateTo, $collectionRegion);
                $waterMeter = $this->waterMeterModel->waterMeterReportWithDateRangeDirectorRegional($dateFrom, $dateTo, $collectionRegion);
            }
        }

        //=====================================

        switch ($activity) {
            case 'All':
                $title = 'All Activities ';
                $title .= $reportTitle;

                $allActivities = [
                    'category' => 'all',
                    'title' => $title,
                    'vtc' => [
                        'vtcQuantity' => count($vtc),
                        'vtcPaidQuantity' => paidInstruments($vtc),
                        'vtcPendingQuantity' => pendingInstruments($vtc),
                        'paidVtc' => paidAmount($vtc),
                        'pendingVtc' => pendingAmount($vtc),
                        'totalVtc' => totalAmount($vtc),
                    ],
                    'sbl' => [
                        'sblQuantity' => count($sbl),
                        'sblPaidQuantity' => paidInstruments($sbl),
                        'sblPendingQuantity' => pendingInstruments($sbl),
                        'paidSbl' => paidAmount($sbl),
                        'pendingSbl' => pendingAmount($sbl),
                        'totalSbl' => totalAmount($sbl),
                    ],
                    'waterMeter' => [
                        'waterMeterQuantity' => meterQuantityAll($waterMeter),
                        'waterMeterPaidQuantity' => meterQuantityPaid($waterMeter),
                        'waterMeterPendingQuantity' => meterQuantityPending($waterMeter),
                        'paidWaterMeter' => paidAmount($waterMeter),
                        'pendingWaterMeter' => pendingAmount($waterMeter),
                        'totalWaterMeter' => totalAmount($waterMeter),
                    ],

                ];

                echo json_encode($allActivities);

                break;

            case 'vtc':
                $title = 'Vehicle Tank Verification';
                $title .= $reportTitle;

                $allVtc = [
                    'category' => 'vtcOnly',
                    'title' => $title,
                    'vtcDetails' => $vtc,
                    'vtc' => [

                        'vtcQuantity' => count($vtc),
                        'vtcPaidQuantity' => paidInstruments($vtc),
                        'vtcPendingQuantity' => pendingInstruments($vtc),
                        'paidVtc' => paidAmount($vtc),
                        'pendingVtc' => pendingAmount($vtc),
                        'totalVtc' => totalAmount($vtc),
                    ],

                ];

                echo json_encode($allVtc);
                break;
            case 'sbl':
                $title = 'Sandy and Ballast Lorries';
                $title .= $reportTitle;

                $allSbl = [
                    'category' => 'sblOnly',
                    'title' => $title,
                    'sblDetails' => $sbl,
                    'sbl' => [

                        'sblQuantity' => count($sbl),
                        'sblPaidQuantity' => paidInstruments($sbl),
                        'sblPendingQuantity' => pendingInstruments($sbl),
                        'paidSbl' => paidAmount($sbl),
                        'pendingSbl' => pendingAmount($sbl),
                        'totalSbl' => totalAmount($sbl),
                    ],

                ];

                echo json_encode($allSbl);
                break;
            case 'water':
                $title = 'Water Meters';
                $title .= $reportTitle;

                $allWaterMeter = [
                    'category' => 'waterMeterOnly',
                    'title' => $title,
                    'waterMeterDetails' => $waterMeter,
                    'waterMeter' => [

                        'waterMeterQuantity' => meterQuantityAll($waterMeter),
                        'waterMeterPaidQuantity' => meterQuantityPaid($waterMeter),
                        'waterMeterPendingQuantity' => meterQuantityPending($waterMeter),
                        'paidWaterMeter' => paidAmount($waterMeter),
                        'pendingWaterMeter' => pendingAmount($waterMeter),
                        'totalWaterMeter' => totalAmount($waterMeter),
                    ],

                ];

                echo json_encode($allWaterMeter);
                # code...
                break;

            default:
                # code...
                break;
        }

    }

    //=================@@@@@@@@@ DOWNLOADING REPORTS @@@@@@@@@====================

    public function downloadQuarterReport($activity, $monthFrom, $monthTo, $year, $status, $collectionRegion)
    {

        if (!$this->session->has('loggedUser')) {
            return redirect()->to('/login');
        }

        $date = date('d-M,Y h:i:s ');
        $dompdf = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();

        $reportTitle = '';
        if ($monthFrom == 7 && $monthTo == 9) {
            $reportTitle = 'Quarter One Report';
        } else if ($monthFrom == 10 && $monthTo == 12) {
            $reportTitle .= 'Quarter Two Report';
        } else if ($monthFrom == 1 && $monthTo == 3) {
            $reportTitle = 'Quarter Three Report';
        } else if ($monthFrom == 4 && $monthTo == 6) {
            $reportTitle = 'Quarter Four Report';
        } else if ($monthFrom == 1 && $monthTo == 12) {
            $reportTitle = 'Annual Report';
        }
        $data['reportTitle'] = $reportTitle;

        $role = $this->role;
        $uniqueId = $this->uniqueId;
        $region = $this->city;

        switch ($activity) {
            case 'All':
                $title = 'All Activities ' . $reportTitle;

                if ($role == 1) {

                    $vtc = $this->vtcModel->vtcQuarterReportOfficer($uniqueId, $monthFrom, $monthTo, $year);
                    $sbl = $this->lorriesModel->sblQuarterReportOfficer($uniqueId, $monthFrom, $monthTo, $year);
                    $waterMeter = $this->waterMeterModel->waterMeterQuarterReportOfficer($uniqueId, $monthFrom, $monthTo, $year);

                } elseif ($role == 2) {
                    $vtc = $this->vtcModel->vtcQuarterReportManager($region, $monthFrom, $monthTo, $year);
                    $sbl = $this->lorriesModel->sblQuarterReportManager($region, $monthFrom, $monthTo, $year);
                    $waterMeter = $this->waterMeterModel->waterMeterQuarterReportManager($region, $monthFrom, $monthTo, $year);
                } elseif ($role == 3 || $role == 7) {
                    if ($collectionRegion == 'Tanzania') {
                        $vtc = $this->vtcModel->vtcQuarterReportDirector($monthFrom, $monthTo, $year);
                        $sbl = $this->lorriesModel->sblQuarterReportDirector($monthFrom, $monthTo, $year);
                        $waterMeter = $this->waterMeterModel->waterMeterQuarterReportDirector($monthFrom, $monthTo, $year);
                    } else {
                        $vtc = $this->vtcModel->vtcQuarterReportDirectorRegional($monthFrom, $monthTo, $year, $collectionRegion);
                        $sbl = $this->lorriesModel->sblQuarterReportDirectorRegional($monthFrom, $monthTo, $year, $collectionRegion);
                        $waterMeter = $this->waterMeterModel->waterMeterQuarterReportDirectorRegional($monthFrom, $monthTo, $year, $collectionRegion);
                    }

                }

                $allActivities = [
                    'category' => 'all',
                    'title' => $title,
                    'vtc' => [
                        'vtcQuantity' => count($vtc),
                        'vtcPaidQuantity' => paidInstruments($vtc),
                        'vtcPendingQuantity' => pendingInstruments($vtc),
                        'paidVtc' => paidAmount($vtc),
                        'pendingVtc' => pendingAmount($vtc),
                        'totalVtc' => totalAmount($vtc),
                    ],
                    'sbl' => [
                        'sblQuantity' => count($sbl),
                        'sblPaidQuantity' => paidInstruments($sbl),
                        'sblPendingQuantity' => pendingInstruments($sbl),
                        'paidSbl' => paidAmount($sbl),
                        'pendingSbl' => pendingAmount($sbl),
                        'totalSbl' => totalAmount($sbl),
                    ],
                    'waterMeter' => [
                        'waterMeterQuantity' => meterQuantityAll($waterMeter),
                        'waterMeterPaidQuantity' => meterQuantityPaid($waterMeter),
                        'waterMeterPendingQuantity' => meterQuantityPending($waterMeter),
                        'paidWaterMeter' => paidAmount($waterMeter),
                        'pendingWaterMeter' => pendingAmount($waterMeter),
                        'totalWaterMeter' => totalAmount($waterMeter),
                    ],

                ];
                $data['allActivities'] = $allActivities;
                $data['reportTitle'] = $title;
                $data['collectionRegion'] = $collectionRegion;

                $theRegion = ($collectionRegion == 'Tanzania') ? $this->city : $collectionRegion;
                $data['contacts'] = renderContacts($this->contacts->getContacts($theRegion));

                //=================loading a report template====================
                $dompdf->loadHtml(view('ReportTemplates/allActivities', $data));
                break;

            //=================VTC quarter report start====================
            case 'vtc':
                $title = 'Vehicle Tank Verification ' . $reportTitle;

//=================check payment status and render a report====================
                switch ($status) {
                    case 'total':
                        if ($role == 1) {

                            $vtc = $this->vtcModel->vtcQuarterReportOfficer($uniqueId, $monthFrom, $monthTo, $year, $status);
                        } elseif ($role == 2) {
                            $vtc = $this->vtcModel->vtcQuarterReportManager($region, $monthFrom, $monthTo, $year);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {

                                $vtc = $this->vtcModel->vtcQuarterReportDirector($monthFrom, $monthTo, $year);
                            } else {
                                $vtc = $this->vtcModel->vtcQuarterReportDirectorRegional($monthFrom, $monthTo, $year, $collectionRegion);

                            }
                        }
                        break;
                    default:

                        if ($role == 1) {

                            $vtc = $this->vtcModel->vtcQuarterReportOfficerStatus($uniqueId, $monthFrom, $monthTo, $year, $status);
                        } elseif ($role == 2) {
                            $vtc = $this->vtcModel->vtcQuarterReportManagerStatus($region, $monthFrom, $monthTo, $year, $status);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {
                                $vtc = $this->vtcModel->vtcQuarterReportDirectorStatus($monthFrom, $monthTo, $year, $status);

                            } else {
                                $vtc = $this->vtcModel->vtcQuarterReportDirectorStatusRegional($monthFrom, $monthTo, $year, $status, $collectionRegion);

                            }
                        }

                        break;
                }
//=================end check payment status====================

                //=================throwing vtc data to the template====================

                $vtcSummary = [

                    'vtcQuantity' => count($vtc),
                    'vtcPaidQuantity' => paidInstruments($vtc),
                    'vtcPendingQuantity' => pendingInstruments($vtc),
                    'paidVtc' => paidAmount($vtc),
                    'pendingVtc' => pendingAmount($vtc),
                    'totalVtc' => totalAmount($vtc),
                ];

                $data['role'] = $this->role;
                $data['collectionRegion'] = $collectionRegion;
                $data['reportTitle'] = $title;
                $data['vtcClients'] = $vtc;
                $data['vtcSummary'] = $vtcSummary;
                $theRegion = ($collectionRegion == 'Tanzania') ? $this->city : $collectionRegion;
                $data['contacts'] = renderContacts($this->contacts->getContacts($theRegion));
                $dompdf->loadHtml(view('ReportTemplates/vtcReport', $data));
                break;
            //=================vtc quarter report ends here====================
            #############################
            #
            //=================SBL PRINTING====================
            #
            ##############################
            case 'sbl':
                $title = 'Sandy & Ballast Lorries ' . $reportTitle;
                //=================check payment status and render a report====================
                switch ($status) {
                    case 'total':
                        if ($role == 1) {

                            $sbl = $this->lorriesModel->sblQuarterReportOfficer($uniqueId, $monthFrom, $monthTo, $year, $status);
                        } elseif ($role == 2) {
                            $sbl = $this->lorriesModel->sblQuarterReportManager($region, $monthFrom, $monthTo, $year);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {

                                $sbl = $this->lorriesModel->sblQuarterReportDirector($monthFrom, $monthTo, $year);
                            } else {
                                $sbl = $this->lorriesModel->sblQuarterReportDirectorRegional($monthFrom, $monthTo, $year, $collectionRegion);

                            }
                        }
                        break;
                    default:

                        if ($role == 1) {

                            $sbl = $this->lorriesModel->sblQuarterReportOfficerStatus($uniqueId, $monthFrom, $monthTo, $year, $status);
                        } elseif ($role == 2) {
                            $sbl = $this->lorriesModel->sblQuarterReportManagerStatus($region, $monthFrom, $monthTo, $year, $status);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {

                                $sbl = $this->lorriesModel->sblQuarterReportDirectorStatus($monthFrom, $monthTo, $year, $status);
                            } else {

                                $sbl = $this->lorriesModel->sblQuarterReportDirectorStatusRegional($monthFrom, $monthTo, $year, $status, $collectionRegion);
                            }
                        }

                        break;
                }
//=================end check payment status====================

                //=================throwing SBL data to the template====================
                $sblSummary = [

                    'sblQuantity' => count($sbl),
                    'sblPaidQuantity' => paidInstruments($sbl),
                    'sblPendingQuantity' => pendingInstruments($sbl),
                    'paidSbl' => paidAmount($sbl),
                    'pendingSbl' => pendingAmount($sbl),
                    'totalSbl' => totalAmount($sbl),
                ];
                $data['role'] = $this->role;
                $data['collectionRegion'] = $collectionRegion;
                $data['reportTitle'] = $title;
                $data['sblClients'] = $sbl;
                $data['sblSummary'] = $sblSummary;
                $theRegion = ($collectionRegion == 'Tanzania') ? $this->city : $collectionRegion;
                $data['contacts'] = renderContacts($this->contacts->getContacts($theRegion));
                $dompdf->loadHtml(view('ReportTemplates/sblReport', $data));
                ##################################
                ##############WATER METER#################
                ###################################

                break;
            case 'water':
                $title = 'Water Meters ' . $reportTitle;
                //=================check payment status and render a report====================
                switch ($status) {
                    case 'total':
                        if ($role == 1) {

                            $waterMeter = $this->waterMeterModel->waterMeterQuarterReportOfficer($uniqueId, $monthFrom, $monthTo, $year, $status);
                        } elseif ($role == 2) {
                            $waterMeter = $this->waterMeterModel->waterMeterQuarterReportManager($region, $monthFrom, $monthTo, $year);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {

                                $waterMeter = $this->waterMeterModel->waterMeterQuarterReportDirector($monthFrom, $monthTo, $year);
                            } else {

                                $waterMeter = $this->waterMeterModel->waterMeterQuarterReportDirectorRegional($monthFrom, $monthTo, $year, $collectionRegion);
                            }
                        }
                        break;

                    default:
                        if ($role == 1) {

                            $waterMeter = $this->waterMeterModel->waterMeterQuarterReportOfficerStatus($uniqueId, $monthFrom, $monthTo, $year, $status);
                        } elseif ($role == 2) {
                            $waterMeter = $this->waterMeterModel->waterMeterQuarterReportManagerStatus($region, $monthFrom, $monthTo, $year, $status);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {

                                $waterMeter = $this->waterMeterModel->waterMeterQuarterReportDirectorStatus($monthFrom, $monthTo, $year, $status);
                            } else {

                                $waterMeter = $this->waterMeterModel->waterMeterQuarterReportDirectorStatusRegional($monthFrom, $monthTo, $year, $status, $collectionRegion);
                            }
                        }

                        break;
                }
//=================end check payment status====================

                //=================throwing SBL data to the template====================
                $waterMeterSummary = [

                    'waterMeterQuantity' => count($waterMeter),
                    'waterMeterPaidQuantity' => paidInstruments($waterMeter),
                    'waterMeterPendingQuantity' => pendingInstruments($waterMeter),
                    'paidWaterMeter' => paidAmount($waterMeter),
                    'pendingWaterMeter' => pendingAmount($waterMeter),
                    'totalWaterMeter' => totalAmount($waterMeter),
                ];

                $data['role'] = $this->role;
                $data['collectionRegion'] = $collectionRegion;
                $data['reportTitle'] = $title;
                $data['waterMeterClients'] = $waterMeter;
                $data['waterMeterSummary'] = $waterMeterSummary;
                $theRegion = ($collectionRegion == 'Tanzania') ? $this->city : $collectionRegion;
                $data['contacts'] = renderContacts($this->contacts->getContacts($theRegion));
                $dompdf->loadHtml(view('ReportTemplates/waterMeterReport', $data));

                break;

        }

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        $options->set('isRemoteEnabled', true);

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream($title . ':' . $date . '.pdf', array('Attachment' => 0));

    }
    //--------------------------------------------------------------------
    #
    #
    #            DOWNLOADING MONTHLY REPORTS
    #
    #
    //-----------------------------------------------------------------------

    public function downloadMonthlyReport($activity, $month, $year, $status, $collectionRegion)
    {
       
        $date = date('d-M,Y h:i:s ');
        $dompdf = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();

        $reportTitle = '';
        if ($month == 1) {
            $reportTitle .= 'January Report';
        } else if ($month == 2) {
            $reportTitle .= 'February Report';
        } else if ($month == 3) {
            $reportTitle = 'March Report';
        } else if ($month == 4) {
            $reportTitle = 'April Report';
        } else if ($month == 5) {
            $reportTitle = 'May Report';
        } else if ($month == 6) {
            $reportTitle = 'June Report';
        } else if ($month == 7) {
            $reportTitle = 'july Report';
        } else if ($month == 8) {
            $reportTitle = 'August Report';
        } else if ($month == 9) {
            $reportTitle = 'September Report';
        } else if ($month == 10) {
            $reportTitle = 'October Report';
        } else if ($month == 11) {
            $reportTitle = 'November Report';
        } else if ($month == 12) {
            $reportTitle = 'December Report';
        }
        $data['reportTitle'] = $reportTitle;

        $role = $this->role;
        $uniqueId = $this->uniqueId;
        $region = $this->city;

        switch ($activity) {
            case 'All':
                $title = 'All Activities ' . $reportTitle;

                if ($role == 1) {

                    $vtc = $this->vtcModel->vtcMonthlyReportOfficer($uniqueId, $month, $year);
                    $sbl = $this->lorriesModel->sblMonthlyReportOfficer($uniqueId, $month, $year);
                    $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportOfficer($uniqueId, $month, $year);

                } elseif ($role == 2) {
                    $vtc = $this->vtcModel->vtcMonthlyReportManager($region, $month, $year);
                    $sbl = $this->lorriesModel->sblMonthlyReportManager($region, $month, $year);
                    $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportManager($region, $month, $year);
                } elseif ($role == 3 || $role == 7) {
                    if ($collectionRegion == 'Tanzania') {
                        $vtc = $this->vtcModel->vtcMonthlyReportDirector($month, $year);
                        $sbl = $this->lorriesModel->sblMonthlyReportDirector($month, $year);
                        $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportDirector($month, $year);
                    } else {
                        $vtc = $this->vtcModel->vtcMonthlyReportDirectorRegional($month, $year, $collectionRegion);
                        $sbl = $this->lorriesModel->sblMonthlyReportDirectorRegional($month, $year, $collectionRegion);
                        $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportDirectorRegional($month, $year, $collectionRegion);
                    }
                }

                $allActivities = [
                    'category' => 'all',
                    'title' => $title,
                    'vtc' => [
                        'vtcQuantity' => count($vtc),
                        'vtcPaidQuantity' => paidInstruments($vtc),
                        'vtcPendingQuantity' => pendingInstruments($vtc),
                        'paidVtc' => paidAmount($vtc),
                        'pendingVtc' => pendingAmount($vtc),
                        'totalVtc' => totalAmount($vtc),
                    ],
                    'sbl' => [
                        'sblQuantity' => count($sbl),
                        'sblPaidQuantity' => paidInstruments($sbl),
                        'sblPendingQuantity' => pendingInstruments($sbl),
                        'paidSbl' => paidAmount($sbl),
                        'pendingSbl' => pendingAmount($sbl),
                        'totalSbl' => totalAmount($sbl),
                    ],
                    'waterMeter' => [
                        'waterMeterQuantity' => meterQuantityAll($waterMeter),
                        'waterMeterPaidQuantity' => meterQuantityPaid($waterMeter),
                        'waterMeterPendingQuantity' => meterQuantityPending($waterMeter),
                        'paidWaterMeter' => paidAmount($waterMeter),
                        'pendingWaterMeter' => pendingAmount($waterMeter),
                        'totalWaterMeter' => totalAmount($waterMeter),
                    ],

                ];

                $data['allActivities'] = $allActivities;
                $data['reportTitle'] = $title;
                $data['collectionRegion'] = $collectionRegion;
                $theRegion = ($collectionRegion == 'Tanzania') ? $this->city : $collectionRegion;
                $data['contacts'] = renderContacts($this->contacts->getContacts($theRegion));
                //=================loading a report template====================
                $dompdf->loadHtml(view('ReportTemplates/allActivities', $data));
                break;

            //=================VTC Monthly report start====================
            case 'vtc':
                $title = 'Vehicle Tank Verification ' . $reportTitle;

//=================check payment status and render a report====================
                switch ($status) {
                    case 'total':
                        if ($role == 1) {

                            $vtc = $this->vtcModel->vtcMonthlyReportOfficer($uniqueId, $month, $year, $status);
                        } elseif ($role == 2) {
                            $vtc = $this->vtcModel->vtcMonthlyReportManager($region, $month, $year);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {

                                $vtc = $this->vtcModel->vtcMonthlyReportDirector($month, $year);
                            } else {
                                $vtc = $this->vtcModel->vtcMonthlyReportDirectorRegional($month, $year, $collectionRegion);

                            }
                        }
                        break;

                    default:
                        if ($role == 1) {

                            $vtc = $this->vtcModel->vtcMonthlyReportOfficerStatus($uniqueId, $month, $year, $status);
                        } elseif ($role == 2) {
                            $vtc = $this->vtcModel->vtcMonthlyReportManagerStatus($region, $month, $year, $status);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {

                                $vtc = $this->vtcModel->vtcMonthlyReportDirectorStatus($month, $year, $status);
                            } else {
                                $vtc = $this->vtcModel->vtcMonthlyReportDirectorStatusRegional($month, $year, $status, $collectionRegion);

                            }
                        }

                        break;
                }
//=================end check payment status====================

                //=================throwing vtc data to the template====================

                $vtcSummary = [

                    'vtcQuantity' => count($vtc),
                    'vtcPaidQuantity' => paidInstruments($vtc),
                    'vtcPendingQuantity' => pendingInstruments($vtc),
                    'paidVtc' => paidAmount($vtc),
                    'pendingVtc' => pendingAmount($vtc),
                    'totalVtc' => totalAmount($vtc),
                ];
                $data['role'] = $this->role;
                $data['reportTitle'] = $title;
                $data['collectionRegion'] = $collectionRegion;
                $data['vtcClients'] = $vtc;
                $data['vtcSummary'] = $vtcSummary;
                $theRegion = ($collectionRegion == 'Tanzania') ? $this->city : $collectionRegion;
                $data['contacts'] = renderContacts($this->contacts->getContacts($theRegion));
                $dompdf->loadHtml(view('ReportTemplates/vtcReport', $data));
                break;
            //=================vtc Monthly report ends here====================
            #############################
            #
            //=================SBL PRINTING====================
            #
            ##############################
            case 'sbl':
                $title = 'Sandy & Ballast Lorries ' . $reportTitle;
                //=================check payment status and render a report====================
                switch ($status) {
                    case 'total':
                        if ($role == 1) {

                            $sbl = $this->lorriesModel->sblMonthlyReportOfficer($uniqueId, $month, $year, $status);
                        } elseif ($role == 2) {
                            $sbl = $this->lorriesModel->sblMonthlyReportManager($region, $month, $year);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {
                                $sbl = $this->lorriesModel->sblMonthlyReportDirector($month, $year);

                            } else {

                                $sbl = $this->lorriesModel->sblMonthlyReportDirectorRegional($month, $year, $collectionRegion);
                            }
                        }
                        break;

                    default:
                        if ($role == 1) {

                            $sbl = $this->lorriesModel->sblMonthlyReportOfficerStatus($uniqueId, $month, $year, $status);
                        } elseif ($role == 2) {
                            $sbl = $this->lorriesModel->sblMonthlyReportManagerStatus($region, $month, $year, $status);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {
                                $sbl = $this->lorriesModel->sblMonthlyReportDirectorStatus($month, $year, $status);

                            } else {
                                $sbl = $this->lorriesModel->sblMonthlyReportDirectorStatusRegional($month, $year, $status, $collectionRegion);

                            }
                        }

                        break;
                }
//=================end check payment status====================

                //=================throwing SBL data to the template====================
                $sblSummary = [

                    'sblQuantity' => count($sbl),
                    'sblPaidQuantity' => paidInstruments($sbl),
                    'sblPendingQuantity' => pendingInstruments($sbl),
                    'paidSbl' => paidAmount($sbl),
                    'pendingSbl' => pendingAmount($sbl),
                    'totalSbl' => totalAmount($sbl),
                ];
                $data['role'] = $this->role;
                $data['reportTitle'] = $title;
                $data['collectionRegion'] = $collectionRegion;
                $data['sblClients'] = $sbl;
                $data['sblSummary'] = $sblSummary;
                $theRegion = ($collectionRegion == 'Tanzania') ? $this->city : $collectionRegion;
                $data['contacts'] = renderContacts($this->contacts->getContacts($theRegion));
                $dompdf->loadHtml(view('ReportTemplates/sblReport', $data));
                ##################################
                ##############WATER METER#################
                ###################################

                break;
            case 'water':
                $title = 'Water Meters ' . $reportTitle;
                //=================check payment status and render a report====================
                switch ($status) {
                    case 'total':
                        if ($role == 1) {

                            $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportOfficer($uniqueId, $month, $year, $status);
                        } elseif ($role == 2) {
                            $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportManager($region, $month, $year);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {
                                $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportDirector($month, $year);

                            } else {
                                $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportDirectorRegional($month, $year, $collectionRegion);

                            }
                        }
                        break;

                    default:
                        if ($role == 1) {

                            $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportOfficerStatus($uniqueId, $month, $year, $status);
                        } elseif ($role == 2) {
                            $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportManagerStatus($region, $month, $year, $status);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {
                                $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportDirectorStatus($month, $year, $status);

                            } else {
                                $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportDirectorStatusRegional($month, $year, $status, $collectionRegion);

                            }
                        }

                        break;
                }
//=================end check payment status====================

                //=================throwing SBL data to the template====================
                $waterMeterSummary = [

                    'waterMeterQuantity' => count($waterMeter),
                    'waterMeterPaidQuantity' => paidInstruments($waterMeter),
                    'waterMeterPendingQuantity' => pendingInstruments($waterMeter),
                    'paidWaterMeter' => paidAmount($waterMeter),
                    'pendingWaterMeter' => pendingAmount($waterMeter),
                    'totalWaterMeter' => totalAmount($waterMeter),
                ];

                $data['role'] = $this->role;
                $data['reportTitle'] = $title;
                $data['collectionRegion'] = $collectionRegion;
                $data['waterMeterClients'] = $waterMeter;
                $data['waterMeterSummary'] = $waterMeterSummary;
                $theRegion = ($collectionRegion == 'Tanzania') ? $this->city : $collectionRegion;
                $data['contacts'] = renderContacts($this->contacts->getContacts($theRegion));
                $dompdf->loadHtml(view('ReportTemplates/waterMeterReport', $data));

                break;

        }

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        $options->set('isRemoteEnabled', true);

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream($title . ':' . $date . '.pdf', array('Attachment' => 0));

    }

    //--------------------------------------------------------------
    #
    #                DOWNLOAD CUSTOM DATE REPORT
    #
    #
    //-------------------------------------------------------------

    public function downloadCustomDateReport($activity, $dateFrom, $dateTo, $status, $collectionRegion)
    {
       
        $date = date('d-M,Y h:i:s ');
        $dompdf = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();

        $reportTitle = dateFormatter($dateFrom) . ' To ' . dateFormatter($dateTo);

        $role = $this->role;
        $uniqueId = $this->uniqueId;
        $region = $this->city;

        switch ($activity) {
            case 'All':
                $title = 'All Activities ' . $reportTitle;

                if ($role == 1) {

                    $vtc = $this->vtcModel->vtcReportWithDateRangeOfficer($uniqueId, $dateFrom, $dateTo);
                    $sbl = $this->lorriesModel->sblReportWithDateRangeOfficer($uniqueId, $dateFrom, $dateTo);
                    $waterMeter = $this->waterMeterModel->waterMeterReportWithDateRangeOfficer($uniqueId, $dateFrom, $dateTo);

                } elseif ($role == 2) {
                    $vtc = $this->vtcModel->vtcReportWithDateRangeManager($region, $dateFrom, $dateTo);
                    $sbl = $this->lorriesModel->sblReportWithDateRangeManager($region, $dateFrom, $dateTo);
                    $waterMeter = $this->waterMeterModel->waterMeterReportWithDateRangeManager($region, $dateFrom, $dateTo);
                } elseif ($role == 3 || $role == 7) {

                    if ($collectionRegion == 'Tanzania') {

                        $vtc = $this->vtcModel->vtcReportWithDateRangeDirector($dateFrom, $dateTo);
                        $sbl = $this->lorriesModel->sblReportWithDateRangeDirector($dateFrom, $dateTo);
                        $waterMeter = $this->waterMeterModel->waterMeterReportWithDateRangeDirector($dateFrom, $dateTo);
                    } else {
                        $vtc = $this->vtcModel->vtcReportWithDateRangeDirectorRegional($dateFrom, $dateTo, $collectionRegion);
                        $sbl = $this->lorriesModel->sblReportWithDateRangeDirectorRegional($dateFrom, $dateTo, $collectionRegion);
                        $waterMeter = $this->waterMeterModel->waterMeterReportWithDateRangeDirectorRegional($dateFrom, $dateTo, $collectionRegion);
                    }
                }

                $allActivities = [
                    'category' => 'all',
                    'title' => $title,
                    'vtc' => [
                        'vtcQuantity' => count($vtc),
                        'vtcPaidQuantity' => paidInstruments($vtc),
                        'vtcPendingQuantity' => pendingInstruments($vtc),
                        'paidVtc' => paidAmount($vtc),
                        'pendingVtc' => pendingAmount($vtc),
                        'totalVtc' => totalAmount($vtc),
                    ],
                    'sbl' => [
                        'sblQuantity' => count($sbl),
                        'sblPaidQuantity' => paidInstruments($sbl),
                        'sblPendingQuantity' => pendingInstruments($sbl),
                        'paidSbl' => paidAmount($sbl),
                        'pendingSbl' => pendingAmount($sbl),
                        'totalSbl' => totalAmount($sbl),
                    ],
                    'waterMeter' => [
                        'waterMeterQuantity' => meterQuantityAll($waterMeter),
                        'waterMeterPaidQuantity' => meterQuantityPaid($waterMeter),
                        'waterMeterPendingQuantity' => meterQuantityPending($waterMeter),
                        'paidWaterMeter' => paidAmount($waterMeter),
                        'pendingWaterMeter' => pendingAmount($waterMeter),
                        'totalWaterMeter' => totalAmount($waterMeter),
                    ],

                ];

                $data['allActivities'] = $allActivities;
                $data['reportTitle'] = $title;
                $data['collectionRegion'] = $collectionRegion;
                $theRegion = ($collectionRegion == 'Tanzania') ? $this->city : $collectionRegion;
                $data['contacts'] = renderContacts($this->contacts->getContacts($theRegion));
                //=================loading a report template====================
                $dompdf->loadHtml(view('ReportTemplates/allActivities', $data));
                break;

            //=================VTC Monthly report start====================
            case 'vtc':
                $title = 'Vehicle Tank Verification ' . $reportTitle;

//=================check payment status and render a report====================
                switch ($status) {
                    case 'total':
                        if ($role == 1) {

                            $vtc = $this->vtcModel->vtcReportWithDateRangeOfficer($uniqueId, $dateFrom, $dateTo, $status);
                        } elseif ($role == 2) {
                            $vtc = $this->vtcModel->vtcReportWithDateRangeManager($region, $dateFrom, $dateTo);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {

                                $vtc = $this->vtcModel->vtcReportWithDateRangeDirector($dateFrom, $dateTo);
                            } else {
                                $vtc = $this->vtcModel->vtcReportWithDateRangeDirectorRegional($dateFrom, $dateTo, $collectionRegion);

                            }
                        }
                        break;

                    default:

                        if ($role == 1) {

                            $vtc = $this->vtcModel->vtcReportWithDateRangeOfficerStatus($uniqueId, $dateFrom, $dateTo, $status);
                        } elseif ($role == 2) {
                            $vtc = $this->vtcModel->vtcReportWithDateRangeManagerStatus($region, $dateFrom, $dateTo, $status);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {
                                $vtc = $this->vtcModel->vtcReportWithDateRangeDirectorStatus($dateFrom, $dateTo, $status);

                            } else {
                                $vtc = $this->vtcModel->vtcReportWithDateRangeDirectorStatusRegional($dateFrom, $dateTo, $status, $collectionRegion);

                            }
                        }

                        break;
                }
//=================end check payment status====================

                //=================throwing vtc data to the template====================

                $vtcSummary = [

                    'vtcQuantity' => count($vtc),
                    'vtcPaidQuantity' => paidInstruments($vtc),
                    'vtcPendingQuantity' => pendingInstruments($vtc),
                    'paidVtc' => paidAmount($vtc),
                    'pendingVtc' => pendingAmount($vtc),
                    'totalVtc' => totalAmount($vtc),
                ];
                $data['role'] = $this->role;
                $data['reportTitle'] = $title;
                $data['collectionRegion'] = $collectionRegion;
                $data['vtcClients'] = $vtc;
                $data['vtcSummary'] = $vtcSummary;
                $theRegion = ($collectionRegion == 'Tanzania') ? $this->city : $collectionRegion;
                $data['contacts'] = renderContacts($this->contacts->getContacts($theRegion));
                $dompdf->loadHtml(view('ReportTemplates/vtcReport', $data));
                break;
            //=================vtc Monthly report ends here====================
            #############################
            #
            //=================SBL PRINTING====================
            #
            ##############################
            case 'sbl':
                $title = 'Sandy & Ballast Lorries ' . $reportTitle;
                //=================check payment status and render a report====================
                switch ($status) {
                    case 'total':
                        if ($role == 1) {

                            $sbl = $this->lorriesModel->sblReportWithDateRangeOfficer($uniqueId, $dateFrom, $dateTo, $status);
                        } elseif ($role == 2) {
                            $sbl = $this->lorriesModel->sblReportWithDateRangeManager($region, $dateFrom, $dateTo);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {
                                $sbl = $this->lorriesModel->sblReportWithDateRangeDirector($dateFrom, $dateTo);

                            } else {
                                $sbl = $this->lorriesModel->sblReportWithDateRangeDirectorRegional($dateFrom, $dateTo, $collectionRegion);

                            }
                        }
                        break;

                    default:
                        if ($role == 1) {

                            $sbl = $this->lorriesModel->sblReportWithDateRangeOfficerStats($uniqueId, $dateFrom, $dateTo, $status);
                        } elseif ($role == 2) {
                            $sbl = $this->lorriesModel->sblReportWithDateRangeManagerStatus($region, $dateFrom, $dateTo, $status);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {

                                $sbl = $this->lorriesModel->sblReportWithDateRangeDirectorStatus($dateFrom, $dateTo, $status);
                            } else {
                                $sbl = $this->lorriesModel->sblReportWithDateRangeDirectorStatusRegional($dateFrom, $dateTo, $status, $collectionRegion);

                            }
                        }

                        break;
                }
//=================end check payment status====================

                //=================throwing SBL data to the template====================
                $sblSummary = [

                    'sblQuantity' => count($sbl),
                    'sblPaidQuantity' => paidInstruments($sbl),
                    'sblPendingQuantity' => pendingInstruments($sbl),
                    'paidSbl' => paidAmount($sbl),
                    'pendingSbl' => pendingAmount($sbl),
                    'totalSbl' => totalAmount($sbl),
                ];
                $data['role'] = $this->role;
                $data['reportTitle'] = $title;
                $data['collectionRegion'] = $collectionRegion;
                $data['sblClients'] = $sbl;
                $data['sblSummary'] = $sblSummary;
                $theRegion = ($collectionRegion == 'Tanzania') ? $this->city : $collectionRegion;
                $data['contacts'] = renderContacts($this->contacts->getContacts($theRegion));
                $dompdf->loadHtml(view('ReportTemplates/sblReport', $data));
                ##################################
                ##############WATER METER#################
                ###################################

                break;
            case 'water':
                $title = 'Water Meters ' . $reportTitle;
                //=================check payment status and render a report====================
                switch ($status) {
                    case 'total':
                        if ($role == 1) {

                            $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportOfficer($uniqueId, $dateFrom, $dateTo, $status);
                        } elseif ($role == 2) {
                            $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportManager($region, $dateFrom, $dateTo);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {

                                $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportDirector($dateFrom, $dateTo);
                            } else {
                                $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportDirectorRegional($dateFrom, $dateTo, $collectionRegion);

                            }
                        }
                        break;

                    default:
                        if ($role == 1) {

                            $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportOfficerStatus($uniqueId, $dateFrom, $dateTo, $status);
                        } elseif ($role == 2) {
                            $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportManagerStatus($region, $dateFrom, $dateTo, $status);
                        } elseif ($role == 3 || $role == 7) {
                            if ($collectionRegion == 'Tanzania') {
                                $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportDirectorStatus($dateFrom, $dateTo, $status);

                            } else {
                                $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportDirectorStatusRegional($dateFrom, $dateTo, $status, $collectionRegion);

                            }
                        }

                        break;
                }
//=================end check payment status====================

                //=================throwing water meter data to the template====================
                $waterMeterSummary = [

                    'waterMeterQuantity' => count($waterMeter),
                    'waterMeterPaidQuantity' => paidInstruments($waterMeter),
                    'waterMeterPendingQuantity' => pendingInstruments($waterMeter),
                    'paidWaterMeter' => paidAmount($waterMeter),
                    'pendingWaterMeter' => pendingAmount($waterMeter),
                    'totalWaterMeter' => totalAmount($waterMeter),
                ];

                $data['role'] = $this->role;
                $data['reportTitle'] = $title;
                $data['collectionRegion'] = $collectionRegion;
                $data['waterMeterClients'] = $waterMeter;
                $data['waterMeterSummary'] = $waterMeterSummary;
                $theRegion = ($collectionRegion == 'Tanzania') ? $this->city : $collectionRegion;
                $data['contacts'] = renderContacts($this->contacts->getContacts($theRegion));
                $dompdf->loadHtml(view('ReportTemplates/waterMeterReport', $data));

                break;

        }

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        $options->set('isRemoteEnabled', true);

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream($title . ':' . $date . '.pdf', array('Attachment' => 0));

    }

}