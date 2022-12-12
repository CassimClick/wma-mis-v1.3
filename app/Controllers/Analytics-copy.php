<?php namespace App\Controllers;

use App\Models\LorriesModel;
use App\Models\MiscellaneousModel;
use App\Models\PortModel;
use App\Models\ProfileModel;
use App\Models\VtcModel;
use App\Models\WaterMeterModel;
use CodeIgniter\RESTful\ResourceController;

class Analytics extends ResourceController
{

    private $uniqueId;
    //   public $uniqueId;
    private $role;
    private $city;
    private $portUnitModel;
    private $session;
    private $profileModel;

    private $contacts;

    private $vtcModel;
    private $lorriesModel;
    private $waterMeterModel;

    public function __construct()
    {
        $this->portUnitModel = new PortModel();
        $this->profileModel = new ProfileModel();

        $this->vtcModel = new VtcModel();
        $this->lorriesModel = new LorriesModel();
        $this->waterMeterModel = new WaterMeterModel();
        $this->contacts = new MiscellaneousModel();

        $this->session = session();
        $this->uniqueId = $this->session->get('loggedUser');
        // $this->uniqueId = $this->session->get('loggedUser');
        $this->role = $this->session->get('role');
        $this->city = $this->session->get('city');

        helper(['array', 'regions', 'date', 'documents']);

    }

    public function index()
    {
        if (!$this->session->has('loggedUser')) {
            return redirect()->to('/login');
        }
        $data['page'] = [
            'title' => 'Collection Analytics',
            'heading' => 'Collection Analytics',
        ];
        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['role'] = $role;
        return view('Pages/AnalyticsPage', $data);
    }
    public function strToInt($num)
    {
        return (int) str_replace(',', '', $num);
    }

    public function bulkInstruments()
    {

    }
    public function getVariable($var)
    {
        return $this->request->getVar($var, FILTER_SANITIZE_STRING);
    }
    public function getActivityCollection()
    {
        $month = $this->getVariable('month');
        $year = $this->getVariable('year');
        $overallTarget = 30000000;
        $vtcTargetAmount = 20000000;
        $vtcTargetInstruments = 400;
        $sblTargetAmount = 10000000;
        $sblTargetInstruments = 400;
        $waterMeterTargetAmount = 10000000;
        $waterMeterTargetInstruments = 1500;
        $registeredVtc = 0;
        $registeredSbl = 0;
        $registeredWaterMeter = 0;

        if ($month == 0) {
            $monthFrom = 1;
            $monthTo = 12;
            $vtc = $this->vtcModel->vtcQuarterReportManager($this->city, $monthFrom, $monthTo, $year);
            $sbl = $this->lorriesModel->sblQuarterReportManager($this->city, $monthFrom, $monthTo, $year);
            $waterMeter = $this->waterMeterModel->waterMeterQuarterReportManager($this->city, $monthFrom, $monthTo, $year
            );

        } else {
            $vtc = $this->vtcModel->vtcMonthlyReportManager($this->city, $month, $year);
            $sbl = $this->lorriesModel->sblMonthlyReportManager($this->city, $month, $year);
            $waterMeter = $this->waterMeterModel->waterMeterMonthlyReportManager($this->city, $month, $year);

        }

        //=================Quantity====================
        $registeredVtc += (int) count($vtc);
        $registeredSbl += (int) count($sbl);
        $registeredWaterMeter += meterQuantityAll($waterMeter);

        $overallCollected = $this->strToInt(totalAmount($vtc)) + $this->strToInt(totalAmount($sbl)) + $this->strToInt(totalAmount($waterMeter));
        $overallPercentage = ($overallCollected / $overallTarget) * 100;

        $vtcPercentage = ($this->strToInt(totalAmount($vtc)) / $vtcTargetAmount) * 100;
        $sblPercentage = ($this->strToInt(totalAmount($sbl)) / $sblTargetAmount) * 100;
        $waterMeterPercentage = ($this->strToInt(totalAmount($waterMeter)) / $sblTargetAmount) * 100;

        $data = [
            'overall' => [
                'overallTarget' => number_format($overallTarget),
                'collected' => number_format($overallCollected),
                'percentage' => round($overallPercentage),
            ],
            'vtc' => [
                'vtcTargetAmount' => number_format($vtcTargetAmount),
                'vtcCollectedAmount' => number_format($this->strToInt(totalAmount($vtc))),
                'vtcPercentage' => round($vtcPercentage),
                'vtcRegisteredInstruments' => $registeredVtc,
                'vtcTargetInstruments' => $vtcTargetInstruments,
            ],
            'sbl' => [
                'sblTargetAmount' => number_format($sblTargetAmount),
                'sblCollectedAmount' => number_format($this->strToInt(totalAmount($sbl))),
                'sblPercentage' => round($sblPercentage),
                'sblRegisteredInstruments' => $registeredSbl,
                'sblTargetInstruments' => $sblTargetInstruments,
            ],
            'waterMeter' => [
                'waterMeterTargetAmount' => number_format($waterMeterTargetAmount),
                'waterMeterCollectedAmount' => number_format($this->strToInt(totalAmount($waterMeter))),
                'waterMeterPercentage' => round($waterMeterPercentage),
                'waterMeterRegisteredInstruments' => $registeredWaterMeter,
                'waterMeterTargetInstruments' => $waterMeterTargetInstruments,
            ],

        ];
        return json_encode($data);
    }

    public function mmm()
    {
        $result = array(
            0 => array('a' => 1, 'b' => 'Hello'),
            1 => array('a' => 1, 'b' => 'duplicate_val'),
            2 => array('a' => 1, 'b' => 'duplicate_val'),
        );
        $unique = array_map("unserialize", array_unique(array_map("serialize", $result)));
        echo ('<pre>');
        print_r($unique);
    }

    public function xxx()
    {
        $data = [];
        $regions = [];

        foreach (renderRegions() as $region) {
            array_push($regions, $region['region']);

            // echo $region['region'];
        }
        // echo '<pre>';
        // print_r($regions);

        foreach ($regions as $region) {

            foreach ($this->vtcModel->getAllInRegion($region) as $vehicleTanks) {
                if ($region == $vehicleTanks->region) {

                    $result = [
                        'activity' => 'vtc',
                        'id' => $vehicleTanks->id,
                        'region' => $vehicleTanks->region,
                        'amount' => $vehicleTanks->amount,
                        'payment' => $vehicleTanks->payment,
                    ];
                    array_push($data, (object) [
                        'activity' => 'vtc',
                        'id' => $vehicleTanks->id,
                        'region' => $vehicleTanks->region,
                        'amount' => $vehicleTanks->amount,
                        'payment' => $vehicleTanks->payment,
                    ]);

                }

            }
            foreach ($this->lorriesModel->getAllInRegion($region) as $lorry) {
                if ($region == $lorry->region) {
                    array_push($data, (object) [
                        'activity' => 'sbl',
                        'id' => $lorry->id,
                        'region' => $lorry->region,
                        'amount' => $lorry->amount,
                        'payment' => $lorry->payment,
                    ]);

                }

            }
            //=====================================

        }

        return json_encode($data);

    }
}