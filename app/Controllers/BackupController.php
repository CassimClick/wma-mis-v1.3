<?php

namespace App\Controllers;

use Ifsnop\Mysqldump as IMysqldump;
use App\Models\ProfileModel;
use App\Controllers\BaseController;
use App\Models\MiscellaneousModel;
use CodeIgniter\Database\Query;


class BackupController extends BaseController
{

    public $role;
    public $session;
    public $uniqueId;
    public $profileModel;
    public $appRequest;
    public $token;
    // public $dumpSettings;
    // public $pdoSettings;
    public $_dumpSettings;
    public $db;

    public function __construct(
        $dumpSettings = array(),
        $pdoSettings = array()
    )
    {
        $this->appRequest = service('request');
        $this->profileModel = new ProfileModel();
        $this->db = \Config\Database::connect();
        $this->session = session();
        $this->token = csrf_hash();
        $this->uniqueId = $this->session->get('loggedUser');
        $this->role = $this->profileModel->getRole($this->uniqueId)->role;

        // $this->dumpSettings = $dumpSettings;
        // $this->pdoSettings = $pdoSettings;
        $this->_dumpSettings ;


    //     $dumpSettings = array(),
    // $pdoSettings = array()
    }


    public function index()
    {


        $miscModel = new MiscellaneousModel();
        $data['page'] = ['title' => 'Database Backup', 'heading' => 'Database Backup',];
        $data['profile'] = $this->profileModel->getLoggedUserData($this->uniqueId);
        $data['role'] = $this->role;
        $data['date'] = $miscModel->readBackupDate() ?  $miscModel->readBackupDate()->date : '';

        return view('pages/admin/backup', $data);
    }


    public function tables(){
        
        $serverName = "localhost";
        $username = "root";
        $password = "";
        $dbname = "wma_mis";

        $conn =  mysqli_connect($serverName, $username, $password, $dbname);
        $sql = "show tables";

        $result = mysqli_query($conn, $sql); // run the query and assign the result to $result
        while ($table = mysqli_fetch_array($result)) { // go through each row that was returned in $result
            echo ($table[0] . "<BR>");    // print the table that was returned on that row.

        }
    }
    public function getVariable($var)
    {
        return $this->appRequest->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function createBackup()
    {
        $miscModel = new MiscellaneousModel();
        try {
            $dump = new IMysqldump\Mysqldump('mysql:host=localhost;dbname=wma_mis', 'root', '');

            $date  = date('d M Y h;i a l');
            $dir = WRITEPATH . 'Backups';
            $str = str_shuffle(time());
            $title = $dir . "\ $str $date.sql";

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            
            $day = $this->getVariable('days');
            $month = $this->getVariable('month');
            $value = $day !=  '' ?   $day : $month;
            
            $period = $day!='' ?'DAY' : 'MONTH';

            if(!$day && !$month){
             $period = 'DAY';
             $value = '1';
            }

            // return $this->response->setJSON([
            //     'period' => $period,
            //     'value' => $value,
            //     // 'day' => $day,
            //     // 'month' => $month,
                

            // ]);

            // exit;

            $dump->setTableWheres(array(
                'transactions' => "created_on > NOW() - INTERVAL $value $period",
                'measurement_sheet' => "created_at > NOW() - INTERVAL $value $period",
                'prepackage' => "created_at > NOW() - INTERVAL $value $period",
                'activity_targets' => "created_at > NOW() - INTERVAL $value $period",
                'backup' => "created_at > NOW() - INTERVAL $value $period",
                'bulkstoragetank' => "created_at > NOW() - INTERVAL $value $period",
                'certificate_of_quantity' => "created_at > NOW() - INTERVAL $value $period",
                'contacts' => "created_at > NOW() - INTERVAL $value $period",
                'contact_form' => "created_at > NOW() - INTERVAL $value $period",
                'control-no' => "created_at > NOW() - INTERVAL $value $period",
                'customers' => "created_at > NOW() - INTERVAL $value $period",
                'customer_scale' => "created_at > NOW() - INTERVAL $value $period",
                'discharge_order' => "created_at > NOW() - INTERVAL $value $period",
                'discharging_sequence' => "created_at > NOW() - INTERVAL $value $period",
                'fixedstoragetank' => "created_at > NOW() - INTERVAL $value $period",
                'flowmeter' => "created_at > NOW() - INTERVAL $value $period",
                'fuelpumps' => "created_at > NOW() - INTERVAL $value $period",
                'line_displacement' => "created_at > NOW() - INTERVAL $value $period",
                'measurement_sheet' => "created_at > NOW() - INTERVAL $value $period",
                'note_of_fact_after_discharge' => "created_at > NOW() - INTERVAL $value $period",
                'note_of_fact_before_discharge' => "created_at > NOW() - INTERVAL $value $period",
                'officers_group' => "created_at > NOW() - INTERVAL $value $period",
                'oilvehicles' => "created_at > NOW() - INTERVAL $value $period",
                'permissions' => "created_at > NOW() - INTERVAL $value $period",
                'phone' => "created_at > NOW() - INTERVAL $value $period",
                'ports' => "created_at > NOW() - INTERVAL $value $period",
                'port_documents' => "created_at > NOW() - INTERVAL $value $period",
                'prepackage' => "created_at > NOW() - INTERVAL $value $period",
                'prepackagecustomers' => "created_at > NOW() - INTERVAL $value $period",
                'pressure_log' => "created_at > NOW() - INTERVAL $value $period",
                'producttest' => "created_at > NOW() - INTERVAL $value $period",
                'product_details' => "created_at > NOW() - INTERVAL $value $period",
                'provisional_report' => "created_at > NOW() - INTERVAL $value $period",
                'regional_targets' => "created_at > NOW() - INTERVAL $value $period",
                'role_permission' => "created_at > NOW() - INTERVAL $value $period",
                'sandy_lorries' => "created_at > NOW() - INTERVAL $value $period",
                'sandy_lorries_records' => "created_at > NOW() - INTERVAL $value $period",
                'scaling' => "created_at > NOW() - INTERVAL $value $period",
                'ship_particulars' => "created_at > NOW() - INTERVAL $value $period",
                'ship_ullage_after_discharging' => "created_at > NOW() - INTERVAL $value $period",
                'ship_ullage_before_discharging`' => "created_at > NOW() - INTERVAL $value $period",
                'shore_tanks' => "created_at > NOW() - INTERVAL $value $period",
                'shore_tank_measurements' => "created_at > NOW() - INTERVAL $value $period",

                'shore_tank_seal_number' => "created_at > NOW() - INTERVAL $value $period",
                'shore_tank_seal_positions' => "created_at > NOW() - INTERVAL $value $period",
                'shore_tank_status' => "created_at > NOW() - INTERVAL $value $period",
                'tank_measurement_particulars' => "created_at > NOW() - INTERVAL $value $period",
                'task_group' => "created_at > NOW() - INTERVAL $value $period",
                'time_log' => "created_at > NOW() - INTERVAL $value $period",
                'vehicle_tanks' => "created_at > NOW() - INTERVAL $value $period",
                'vtc' => "created_at > NOW() - INTERVAL $value $period",
                'watermeter' => "created_at > NOW() - INTERVAL $value $period",
                'water_meters' => "created_at > NOW() - INTERVAL $value $period",


            ));
          

            
            $dump->start($title);

            $miscModel->writeBackupDate([
                'title' => $title,
                'date' => str_replace(';', ':', $date),
                'unique_id' => $this->uniqueId,
            ]);



            return $this->response->setJSON([
                'status' => 1,
                'data' => $miscModel->readBackupDate()->date,
                'msg' => 'Backup Created Successfully'

            ]);


        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 0,
                'msg' =>  $e->getMessage()

            ]);
        }
    }
}
