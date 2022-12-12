<?php

namespace App\Controllers;

//use App\Models\ScaleModel;
use App\Models\BulkStorageTankModel;
use App\Models\FixedStorageTankModel;
use App\Models\FlowMeterModel;
use App\Models\FuelPumpModel;
use App\Models\LorriesModel;
use App\Models\ManagerModel;
use App\Models\PhoneModel;
use App\Models\PrePackageModel;
use App\Models\ProfileModel;
use App\Models\scaleModel;
use App\Models\VtcModel;
use App\Models\WaterMeterModel;
use App\Libraries\CommonTasksLibrary;
use App\Models\ServiceApplication\LicenseModel;
use App\Models\ServiceApplication\ServiceModel;
use CodeIgniter\RESTful\ResourceController;
use Dompdf\Dompdf;

// use App\Models\UserModel;

class Manager extends ResourceController
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
    public $ManagerModel;
    public $LorriesModel;
    public $vtcModel;
    public $bstModel;
    public $fstModel;
    public $flowMeterModel;
    public $serviceModel;
    public $waterMeterModel;
    public $commonTask;
    public $token;
    public $licenseModel;

    public function __construct()
    {
        helper(['alert', 'form', 'array', 'regions', 'date', 'image', 'inflector', 'format']);
        $this->session = session();
        $this->commonTask = new CommonTasksLibrary;
        $this->profileModel = new ProfileModel();
        $this->serviceModel = new ServiceModel();

        $this->licenseModel = new LicenseModel();

        $this->scaleModel = new scaleModel();
        $this->fuelPumpModel = new FuelPumpModel();
        $this->prePackageModel = new prePackageModel();
        $this->ManagerModel = new ManagerModel();
        $this->lorriesModel = new LorriesModel();
        $this->vtcModel = new VtcModel();
        $this->bstModel = new BulkStorageTankModel();
        $this->fstModel = new FixedStorageTankModel();
        $this->flowMeterModel = new FlowMeterModel();
        $this->waterMeterModel = new WaterMeterModel();
        $this->uniqueId = $this->session->get('loggedUser');
        $this->role = $this->profileModel->getRole($this->uniqueId)->role;
        $this->region = $this->session->get('city');
        $this->token = csrf_hash();
    }

    public function getVariable($var)
    {
        return $this->request->getPost($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    public function analytics()
    {

        $data = [];
        $scale = $this->scaleModel->getData($this->region);
        $fuelPump = $this->fuelPumpModel->getData($this->region);
        // $prePackage = $this->prePackageModel->getData($this->region);
        $vtc = $this->vtcModel->getData($this->region);
        $lorries = $this->lorriesModel->getData($this->region);
        $bst = $this->bstModel->getData($this->region);
        $fst = $this->fstModel->getData($this->region);
        $waterMeter = $this->waterMeterModel->getData($this->region);

        array_push($data, $vtc, $lorries, $waterMeter);

        if ($data) {

            return $this->respond($data);
        } else {
            return $this->failNotFound('No data found');
        }
    }

    public function index()
    {

        $data['page'] = [
            "title" => "Home | Dashboard",
            "heading" => "Dashboard",
        ];

        $data['role'] = $this->role;

        $uniqueId = $this->uniqueId;
        $location = $this->region;
        $data['location'] = $this->region;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);

        // $data['scaleDetails']      = $this->scaleModel->scalesDetails($location);
        // $data['fuelPumpDetails']   = $this->fuelPumpModel->fuelPumpDetails($location);
        // $data['prePackageDetails'] = $this->prePackageModel->prePackageDetails($location);
        // $data['bstDetails']        = $this->bstModel->bstDetails($location);
        // $data['fstDetails']        = $this->fstModel->fstDetails($location);
        // $data['flowMeterDetails']  = $this->flowMeterModel->flowMeterDetails($location);

        $data['vtcDetails'] = $this->vtcModel->vtcDetails($location);
        $data['sblDetails'] = $this->lorriesModel->sblDetails($location);
        $data['waterMeterDetails'] = $this->waterMeterModel->waterMeterDetails($location);
        return view('pages/Manager/managerDashboard', $data);
        // return view('pages/dashboard', $data);
    }


    public function serviceRequests()
    {

        $data = [];
        $data['page'] = [
            "title" => "Service Requests",
            "heading" => "Service Requests",
        ];
        //

        $uniqueId = $this->uniqueId;

        $data['role'] = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['requests'] = $this->serviceModel->getServiceRequestsInRegion($this->region);
        return view('pages/manager/regionalServiceRequests', $data);
    }
    public function licenseApplications()
    {

        $data = [];
        $data['page'] = [
            "title" => "License Applications",
            "heading" => "License Applications",
        ];
        //

        $uniqueId = $this->uniqueId;

        $data['role'] = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $params = [
            'region' => $this->region
        ];
        $data['applications'] = $this->licenseModel->getLicenseApplicationsInRegion($params);
        return view('pages/manager/regionalLicenseApplications', $data);
    }
    public function applicationDetails($applicationId)
    {
        $data['page'] = [
            "title" => "Application Details",
            "heading" => "Application Details",
        ];

        $params = [
            'application_id' => $applicationId,
            'submission' => 1,
        ];


        $data['role'] = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($this->uniqueId);
        $data['particulars'] = $this->licenseModel->getApplicantParticulars(
            [
                'user_id' => $this->licenseModel->getLicenseType($params)[0]->user_id
            ]
        );
        $data['licenseTypes'] = $this->licenseModel->getLicenseType($params);
        $data['tools'] = $this->licenseModel->getTools($params);
        $data['qualifications'] = $this->licenseModel->getQualifications($params);
        $data['attachments'] = $this->licenseModel->getAttachments($params);
        $data['applicationId'] = $applicationId;

        return view('Pages/manager/LicenseApplicationDetails', $data);
    }
    public function downloadApplication($applicationId)
    {

        $params = [
            'application_id' => $applicationId,
            'submission' => 1,
        ];

        $particulars = $this->licenseModel->getApplicantParticulars(
            [
                'user_id' => $this->licenseModel->getLicenseType($params)[0]->user_id
            ]
        );
        $data['particulars'] = $particulars;
        $data['licenseTypes'] = $this->licenseModel->getLicenseType($params);
        $data['tools'] = $this->licenseModel->getTools($params);
        $data['qualifications'] = $this->licenseModel->getQualifications($params);
        $data['attachments'] = $this->licenseModel->getAttachments($params);
        $data['applicationId'] = $applicationId;




        $dompdf = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();

        $title = $particulars->applicant_name . '-'.time();

        // $dompdf->loadHtml(view('Pages/manager/LicenseApplicationPdf', $data));
        $dompdf->loadHtml(view('Pages/manager/LicenseApplicationPdf', $data));
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        $options->set('isRemoteEnabled', true);

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream($title . '.pdf', array('Attachment' => 1));
    }

    public function confirmServiceRequests($id)
    {
        $query = $this->serviceModel->confirmServiceRequests($id);
        if ($query) {
            session()->setFlashdata('success', 'Request Status Updated');
            return redirect()->to('service-requests');
        }
    }
    public function downloadServiceRequests($id)
    {
        $customerRequest = $this->serviceModel->getSingleRequest($id);
        $title = $customerRequest->name . '-' . time();
        $data['request'] = $customerRequest;
        $dompdf = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();
        $dompdf->loadHtml(view('Pages/manager/ServiceRequestPdf', $data));
        $dompdf->setPaper('A4', 'portrait');
        $options->set('isRemoteEnabled', TRUE);

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream($title . '.pdf', array('Attachment' => 1));
    }



    public function addGroup()
    {




        if ($this->request->getMethod() == 'post') {

            $groupId = md5(str_shuffle('abcdefghijklmnopqrstuvwxyz' . time()));
            $officerIds = $this->getVariable('officer');
            $groupName = $this->request->getPost('groupName');

            $groupData = [];
            $groupIdArray = [];
            $groupNameArray = [];
            $uniqueIds = [];


            if ($officerIds == null) {

                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Please Select At Least One officer',
                    'token' => $this->token,

                ]);
            } else {
                for ($i = 0; $i < count($officerIds); $i++) {
                    array_push($groupIdArray,   $groupId);
                    array_push($groupNameArray, $groupName);
                    array_push($uniqueIds, $this->uniqueId);
                }
                $data = [
                    "group_name" => $groupNameArray,
                    // "group_id" => $groupIdArray,
                    'officer_id' => $officerIds,
                    "unique_id" => $uniqueIds,

                ];

                foreach ($data as $key => $value) {
                    for ($i = 0; $i < count($value); $i++) {
                        $groupData[$i][$key] = $value[$i];
                    }
                }


                $status = $this->ManagerModel->saveGroupData($groupData);

                if ($status) {

                    return $this->response->setJSON([
                        'status' => 1,
                        'msg' => 'Group Created Successfully',
                        'groups' => $this->ManagerModel->getGroups($this->uniqueId),
                        'token' => $this->token,

                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 0,
                        'msg' => 'Something Went Wrong',
                        'token' => $this->token,

                    ]);
                }
            }
        }
    }

    // ================Assigning officers to  A group ==============
    public function createTask()
    {
        if ($this->request->getMethod() == 'post') {

            $taskData = [
                "activity" => $this->getVariable('activity'),
                "description" => $this->getVariable('description'),
                "the_group" => $this->getVariable('group'),
                "region" => $this->getVariable('region'),
                "district" => $this->request->getVar('district'),
                "ward" => $this->getVariable('ward'),
                "unique_id" => $this->uniqueId,

            ];
            // return $this->response->setJSON([
            //     $taskData,
            //     // 'status' => 1,
            //     // 'msg' => 'Group Created Successfully',
            //     // 'token' => $this->token,

            // ]);
            // exit;

            $status = $this->ManagerModel->assignTaskToGroup($taskData);


            if ($status) {

                return $this->response->setJSON([
                    'status' => 1,
                    'msg' => 'Task Assigned Successfully',
                    'token' => $this->token,

                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Something Went Wrong',
                    'token' => $this->token,

                ]);
            }
        }
    }

    // ================Assigning a task to a group==============

    public function assignTask()
    {

        $data = [];
        $data['page'] = [
            "title" => "Assign Task To A Group",
            "heading" => "Assign Task To A Group",
        ];
        // ================All regions==============
        $data['regions'] = ['Arusha', 'Dar es Salaam', 'Dodoma', 'Geita', 'Iringa', 'Kagera', 'Katavi', 'Kigoma', 'Kilimanjaro', 'Lindi', 'Manyara', 'Mara', 'Mbeya', 'Morogoro', 'Mtwara', 'Njombe', 'Pemba North', 'Pemba South', 'Pwani', 'Rukwa', 'Ruvuma', 'Shinyanga', 'Simiyu', 'Singida', 'Tabora', 'Tanga', 'Zanzibar'];

        $data['districts'] = ['Arusha City', 'Arusha Rural', 'Karatu', 'Longido', 'Meru', 'Monduli', 'Ngorongoro'];

        // ================Activities==============
        $data['activities'] = [
            'Inspection and verification of scales',
            'Inspection and verification of fuel pumps',
            'Inspection   of fuel pumps industrial packages',
            'Vehicle Tank Calibration',
            'Sandy and ballast lorries calibration',
            'Bulk storage tank calibration',
            'Flow meter inspection',

        ];
        $uniqueId = $this->uniqueId;
        $city = $this->region;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        // ================A function to get all officers==============
        $data['officers'] = $this->ManagerModel->getAllOfficers($city);
        // ================get all the groups created==============
        $data['groups'] = $this->ManagerModel->getGroups($uniqueId);



        // return redirect()->to(current_url());
        $data['role'] = $this->role;
        return view('pages/manager/assignTaskToGroup', $data);
    }
    public function assignToIndividual()
    {

        $data = [];
        $data['page'] = [
            "title" => "Assign Task To A Individual",
            "heading" => "Assign Task To A Individual",
        ];

        // ================Activities==============
        $data['activities'] = [
            'Inspection and verification of scales',
            'Inspection and verification of fuel pumps',
            'Inspection   of fuel pumps (F/P) ',
            'Pre-packaged Inspections ',
            'Vehicle Tank Calibration (VTC)',
            'Sandy and ballast lorries calibration (SBL)',
            'Bulk Storage Tank calibration (BST)',
            'Fixed Storage Tank (FST)',
            'Flow meter inspection (FM)',

        ];
        $uniqueId = $this->uniqueId;
        $city = $this->region;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        // ================A function to get all officers==============
        $data['officers'] = $this->ManagerModel->getAllOfficers($city);
        // ================get all the groups created==============
        $data['groups'] = $this->ManagerModel->getAllGroups($uniqueId);

        $data['validation'] = null;
        $rules = [
            // "groupname"     => "required|min_length[3]|max_length[15]|is_unique[users_group.group_name]",

            'activity' => [
                'label' => 'Activity',
                'rules' => 'required',
                'errors' => [
                    'required' => 'You must select an activity',

                ],
            ],
            // ==============================
            'group' => [
                'label' => 'Group',
                'rules' => 'required',
                'errors' => [
                    'required' => 'You must select a group',

                ],
            ],
            'region' => [
                'label' => 'Region',
                'rules' => 'required',
                'errors' => [
                    'required' => 'You must select a region',

                ],
            ],
            'district' => [
                'label' => 'district',
                'rules' => 'required',
                'errors' => [
                    'required' => 'You must select a district',

                ],
            ],
            'district' => [
                'label' => 'district',
                'rules' => 'required',
                'errors' => [
                    'required' => 'You must select a district',

                ],
            ],
            'ward' => [
                'label' => 'ward',
                'rules' => 'required',
                'errors' => [
                    'required' => 'You must select a ward',

                ],
            ],
            // ==============================

        ];
        if ($this->request->getMethod() == 'post') {
            if ($this->validate($rules)) {
                $group = $this->request->getVar('group', FILTER_SANITIZE_SPECIAL_CHARS);
                $taskData = [
                    "activity" => $this->request->getVar('activity', FILTER_SANITIZE_SPECIAL_CHARS),
                    "description" => $this->request->getVar('description', FILTER_SANITIZE_SPECIAL_CHARS),
                    "the_group" => $this->request->getVar('group', FILTER_SANITIZE_SPECIAL_CHARS),
                    "region" => $this->request->getVar('region', FILTER_SANITIZE_SPECIAL_CHARS),
                    "district" => $this->request->getVar('district', FILTER_SANITIZE_SPECIAL_CHARS),
                    "ward" => $this->request->getVar('ward', FILTER_SANITIZE_SPECIAL_CHARS),
                    "unique_id" => $this->uniqueId,

                ];

                $status = $this->ManagerModel->assignTaskToGroup($taskData);

                if ($status) {
                    $this->session->setFlashdata('Success', 'Task assigned to ' . $group . ' group Successfully <i class="fal fa-smile-wink"></i>');
                    return redirect()->to(current_url());
                    // echo "<script>alert('Data Inserted');</script>";
                } else {
                    $this->session->setFlashdata('error', 'Fail To  Add To A  Group Try Again');
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        // return redirect()->to(current_url());
        $data['role'] = $this->role;
        return view('pages/manager/assignTaskToIndividual', $data);
    }

    public function viewTasks()
    {

        $data = [];
        $data['page'] = [
            "title" => "View Tasks And Groups",
            "heading" => "View Tasks And Groups",
        ];
        $uniqueId = $this->uniqueId;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['role'] = $this->role;
        //$city = $this->region;
        $data['activities'] = $this->ManagerModel->getAllTasks($uniqueId);
        return view('pages/manager/activities', $data);
    }

    public function cool()
    {
        $res = $this->ManagerModel->getGroupAndOfficers();

        //print_r($res);
        echo json_encode($res);
    }

    public function listAllScales()
    {

        $data['page'] = [
            "title" => "Scales List",
            "heading" => "Registered Scales",
        ];

        $uniqueId = $this->uniqueId;
        $location = $this->region;
        $data['role'] = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['scaleResults'] = $this->scaleModel->getAllScales($location);
        return view('Pages/Scales/allScales', $data);
    }

    public function test()
    {
        helper('form');
        $phone = new PhoneModel();
        $data['page'] = [
            "title" => "Task",
            "heading" => "Task",
        ];

        if ($this->request->getMethod() == 'post') {

            $groupName = $this->request->getVar('groupName', FILTER_SANITIZE_SPECIAL_CHARS);

            $officerId = $this->request->getVar('officer', FILTER_SANITIZE_SPECIAL_CHARS);
            foreach ($officerId as $id) {
                $groupData = [
                    'group_name' => $groupName,
                    'officer_id' => $id,
                    'unique_id' => $this->uniqueId,
                ];

                $this->ManagerModel->addOfficerToGroup($groupData);
            }
        }
        return redirect()->to('/assignTask');
        //return view('pages/manager/assignTaskToGroup', $data);
    }
}
