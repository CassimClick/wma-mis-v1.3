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
    private $regionTarget;

    public function __construct()
    {
        $this->portUnitModel = new PortModel();
        $this->profileModel = new ProfileModel();
        $this->session = session();

        $this->vtcModel = new VtcModel();
        $this->lorriesModel = new LorriesModel();
        $this->waterMeterModel = new WaterMeterModel();
        $this->contacts = new MiscellaneousModel();
        $this->regionTarget = new MiscellaneousModel();

        $this->uniqueId = $this->session->get('loggedUser');
        // $this->uniqueId = $this->session->get('loggedUser');
        $this->role = $this->session->get('role');
        $this->city = $this->session->get('city');

        helper(['array', 'regions', 'date', 'documents']);

    }

    public function getVariable($var)
    {
        return $this->request->getVar($var, FILTER_SANITIZE_STRING);
    }

    public function targets()
    {
        if (!$this->session->has('loggedUser')) {
            return redirect()->to('/login');
        }
        $data['page'] = [
            'title' => 'Collection Targets',
            'heading' => 'Collection Targets',
        ];
        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['role'] = $role;
        return view('Pages/Target', $data);

    }

    public function saveRegionalTarget()
    {
        if ($this->request->getMethod() == 'post') {
            $data = [
                'region' => $this->getVariable('regionOverall'),
                'amount' => $this->getVariable('regionAmount'),
                'month' => $this->getVariable('monthRegionTarget'),
                'year' => $this->getVariable('yearRegionTarget'),
                'unique_id' => $this->uniqueId,
            ];

            $request = $this->regionTarget->saveRegionTarget($data);
            if ($request) {
                return json_encode([
                    'message' => 'Added',
                    // 'targets' => $this->regionTarget->getRegionTarget(),
                ]);
            }
        }
    }
    public function saveActivityTarget()
    {
        if ($this->request->getMethod() == 'post') {
            $data = [
                'region' => $this->city,
                'activity' => $this->getVariable('activity'),
                'amount' => $this->getVariable('amount'),
                'instruments' => $this->getVariable('instruments'),
                'month' => $this->getVariable('month'),
                'year' => $this->getVariable('year'),
                'unique_id' => $this->uniqueId,
            ];

            // return json_encode($data);
            // exit;

            $request = $this->regionTarget->saveActivityTarget($data);
            if ($request) {
                return json_encode([
                    'message' => 'Added',
                    // 'targets' => $this->regionTarget->getRegionTarget(),
                ]);
            }
        }
    }
    public function updateRegionTarget()
    {
        if ($this->request->getMethod() == 'post') {
            $id = $this->getVariable('id');
            $data = [

                'region' => $this->getVariable('region'),
                'amount' => $this->getVariable('amount'),
                'month' => $this->getVariable('month'),
                'year' => $this->getVariable('year'),
                // 'unique_id' => $this->uniqueId,
            ];

            // return json_encode($data);
            // exit;
            $request = $this->regionTarget->updateRegionTarget($id, $data);
            if ($request) {
                return json_encode([
                    'message' => 'Updated',
                    // 'targets' => $this->regionTarget->getRegionTarget(),
                ]);
            }
        }
    }
    public function getRegionTargets()
    {
        return json_encode($this->regionTarget->getRegionTarget());
    }
    public function getActivityTargets()
    {
        return json_encode($this->regionTarget->getActivityTarget($this->city));
    }
    public function editRegionTarget()
    {
        $id = $this->getVariable('id');
        return json_encode($this->regionTarget->editRegionTarget($id));
    }
    public function editActivityTarget()
    {
        $id = $this->getVariable('id');
        return json_encode($this->regionTarget->editActivityTarget($id));
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
        if ($role == 3) {

            return view('Pages/AnalyticsPageDirector', $data);
        } else {

            return view('Pages/AnalyticsPage', $data);
        }
    }
    public function strToInt($num)
    {
        return (int) str_replace(',', '', $num);
    }

    public function regionOverallTargetAmount()
    {

        $amount = 0;
        $target = $this->regionTarget->readOverallTarget($this->city);

        if (count($target) > 0) {
            foreach ($target as $tg) {
                $amount += $tg->amount;
            }
        } else {

            return 0;
        }

        return $amount;
    }
    //=====================================
    public function regionTargetAmount($month, $region)
    {

        $target = $this->regionTarget->readRegionTarget($month, $region);
        if ($target != '') {
            return (int) $target->amount;

        } else {
            return 1;
        }

    }

    public function getActivityMonthlyTarget($region, $month, $year, $activity)
    {
        $target = $this->regionTarget->getActivityMonthlyTarget($region, $month, $year, $activity);
        if ($target != '') {
            return $target->amount;
        } else {
            return 2000000;
        }

    }
    public function getActivityMonthlyTargetInstruments($region, $month, $year, $activity)
    {
        $target = $this->regionTarget->getActivityMonthlyTarget($region, $month, $year, $activity);
        if ($target != '') {
            return $target->instruments;
        } else {
            return 1;
        }

    }

    public function getActivityCollection()
    {
        $overallTarget = 0;
        $month = $this->getVariable('month');
        $year = $this->getVariable('year');

        if ($month == 0) {
            $overallTarget += $this->regionOverallTargetAmount();

        } else {
            $overallTarget += $this->regionTargetAmount($month, $this->city);

        }

        $vtcTargetAmount = $this->getActivityMonthlyTarget($this->city, $month, $year, 'vtc');
        $vtcTargetInstruments = $this->getActivityMonthlyTargetInstruments($this->city, $month, $year, 'vtc');
        $sblTargetAmount = $this->getActivityMonthlyTarget($this->city, $month, $year, 'sbl');

        $sblTargetInstruments = $this->getActivityMonthlyTargetInstruments($this->city, $month, $year, 'sbl');

        $waterMeterTargetAmount = $this->getActivityMonthlyTarget($this->city, $month, $year, 'waterMeter');
        $waterMeterTargetInstruments = $this->getActivityMonthlyTargetInstruments($this->city, $month, $year, 'waterMeter ');
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

    public function getTarget($month, $year)
    {
        return $this->regionTarget->fetchTarget($month, $year);

    }

    public function xxx()
    {
        $month = $this->getVariable('month');
        $year = $this->getVariable('year');
        $location = $this->getVariable('location');

        // return json_encode([
        //     $month, $year, $location,
        // ]);

        // exit;
        $data = [];
        $regions = [];
        $myData = [];

        foreach (renderRegions() as $region) {
            array_push($regions, $region['region']);

        }
        $vtc = $this->vtcModel->vtcMonthlyReportDirector($month, $year);
        $sbl = $this->lorriesModel->sblMonthlyReportDirector($month, $year);
        $waterMeters = $this->waterMeterModel->waterMeterMonthlyReportDirector($month, $year);
        array_push($myData, $vtc, $sbl, $waterMeters);

        array_push($data, $this->getTarget($month, $year));
        // foreach ($regions as $region) {
        foreach ($vtc as $vehicleTanks) {
            // if ($region == $vehicleTanks->region) {

            array_push($data, (object) [
                'activity' => 'vtc',
                // 'id' => $vehicleTanks->id,
                'region' => $vehicleTanks->region,
                'amount' => $vehicleTanks->amount,
                'payment' => $vehicleTanks->payment,
                'instruments' => count($vtc),

            ]);

            // }

        }
        foreach ($sbl as $lorry) {
            // if ($region == $lorry->region) {
            array_push($data, (object) [
                'activity' => 'sbl',
                // 'id' => $lorry->id,
                'region' => $lorry->region,
                'amount' => $lorry->amount,
                'payment' => $lorry->payment,
                'instruments' => count($sbl),

            ]);

            // }

        }
        foreach ($waterMeters as $waterMeter) {
            // if ($region == $waterMeter->region) {
            array_push($data, (object) [
                'activity' => 'waterMeter',
                // 'id' => $waterMeter->id,
                'region' => $waterMeter->region,
                'amount' => $waterMeter->amount,
                'payment' => $waterMeter->payment,
                'instruments' => meterQuantityAll($waterMeters),
            ]);

            // }

        }

        // }

        return json_encode($data);

    }
}