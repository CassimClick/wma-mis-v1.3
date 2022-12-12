<?php

namespace App\Controllers\ServiceApplication;

use App\Models\ProfileModel;
use App\Controllers\BaseController;
use App\Libraries\CommonTasksLibrary;
use App\Models\ServiceApplication\ServiceModel;

class ServiceController extends BaseController
{


    public $role;
    public $city;
    public $user;

    public $session;

    public $CommonTasks;
    public $token;
    public $userId;
    public $serviceModel;

    public function __construct()
    {
        $this->profileModel = new ProfileModel();
        $this->serviceModel = new ServiceModel();
        $this->session = session();
        $this->token = csrf_hash();
        $this->userId = $this->session->get('service-applicant');
        $this->user = $this->serviceModel->getUser($this->userId);
        // $this->managerId = $this->session->get('manager');
        $this->CommonTasks = new CommonTasksLibrary();
        // helper(['form', 'array', 'date', 'regions']);
    }


    public function getVariable($var)
    {
        return $this->request->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    public function welcome(){
        $data['page'] = (object)[
            "title" => "Dashboard",
            "heading" => "Dashboard",
        ];


        // $data['profile'] = $this->profileModel->getLoggedUserData($this->userId);
        return view('ServiceApplication/Pages/ServiceLandingPage', $data); 
    }
    public function serviceRequest(){
        $data['page'] = (object)[
            "title" => "How To Request Service",
            "heading" => "How To Request Service",
        ];
        


        // $data['profile'] = $this->profileModel->getLoggedUserData($this->userId);
        return view('ServiceApplication/Pages/ServiceRequestDetails', $data); 
    }
    public function licenseApplication(){
        $data['page'] = (object)[
            "title" => "How To Apply license",
            "heading" => "How To Apply license",
        ];
        


        // $data['profile'] = $this->profileModel->getLoggedUserData($this->userId);
        return view('ServiceApplication/Pages/LicenseApplicationDetails', $data); 
    }
    public function index()
    {
        $data['page'] = (object)[
            "title" => "Dashboard",
            "heading" => "Dashboard",
        ];




        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;



        // $data['profile'] = $this->profileModel->getLoggedUserData($this->userId);
        return view('ServiceApplication/Pages/ServiceDashboard', $data);
    }


    public function serviceApplication()
    {
        $data['page'] = (object)[
            "title" => "Service Request",
            "heading" => "Service Request",
        ];

        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;


        $data['validation'] = null;
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'name' => 'required',
                'tin_number' => 'required',
                'mobile_number' => 'required',
                'region' => 'required',
                'district' => 'required',
                'ward' => 'required',
                // 'region' => 'required',
                // 'district' => 'required',
                // 'ward' => 'required',
            ];

            $services = $this->getVariable('services');
            $count = count($this->getVariable('services'));

            if ($this->validate($rules)) {
                $data['validation'] = null;
                $formData = [
                    'name' => fillArray($count, $this->getVariable('name')),
                    'tin_number' => fillArray($count, $this->getVariable('tin_number')),
                    'mobile_number' => fillArray($count, $this->getVariable('mobile_number')),
                    'region' => fillArray($count, $this->getVariable('region')),
                    'district' => fillArray($count, $this->getVariable('district')),
                    'ward' => fillArray($count, $this->getVariable('ward')),
                    'postal_code' => fillArray($count, $this->getVariable('postal_code')),
                    'postal_address' => fillArray($count, $this->getVariable('postal_address')),
                    'physical_address' => fillArray($count, $this->getVariable('physical_address')),
                    'services' => $this->getVariable('services'),
                    'addition_info' => fillArray($count, $this->getVariable('addition_info')),
                    'user_id' =>  fillArray($count, $this->userId),


                ];

                $request = multiDimensionArray($formData);


                $query = $this->serviceModel->saveServiceFormData($request);

                if ($query) {

                    // $data['user'] =  $formData;

                    session()->setFlashdata('success', 'Request Submitted Successfully');
                } else {
                    session()->setFlashdata('error', 'Something Went Wrong');
                }
                return redirect()->back();
            } else {
                $data['validation'] = $this->validator;
            }
        }



        // $data['profile'] = $this->profileModel->getLoggedUserData($this->userId);
        return view('ServiceApplication/Pages/ServiceApplication', $data);
    }

    public function SubmittedRequests()
    {
        $data['page'] = (object)[
            "title" => "Submitted Service Request",
            "heading" => "Submitted Service Request",
        ];

        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;
        $data['requests'] = $this->serviceModel->getServiceRequests($this->userId);


        return view('ServiceApplication/Pages/SubmittedRequests', $data);   
    }
}
