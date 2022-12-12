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
        // $this->managerId = $this->session->get('manager');
        $this->CommonTasks = new CommonTasksLibrary();
        // helper(['form', 'array', 'date', 'regions']);
    }


    public function getVariable($var)
    {
        return $this->request->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    public function index()
    {
        $data['page'] = (object)[
            "title" => "Dashboard",
            "heading" => "Dashboard",
        ];




        $data['userId'] = $this->userId;
        $data['role'] = $this->role;



        // $data['profile'] = $this->profileModel->getLoggedUserData($this->userId);
        return view('ServiceApplication/Pages/ServiceDashboard', $data);
    }


    public function personalParticulars()
    {
        $data['page'] = (object)[
            "title" => "Service Request",
            "heading" => "Service Request",
        ];

        // session()->setFlashdata('xx','123');




        $data['userId'] = $this->userId;
        $data['role'] = $this->role;


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

            if ($this->validate($rules)) {
                $data['validation'] = null;
                $formData = [
                    'name' => $this->getVariable('name'),
                    'tin_number' => $this->getVariable('tin_number'),
                    'mobile_number' => $this->getVariable('mobile_number'),
                    'region' => $this->getVariable('region'),
                    'district' => $this->getVariable('district'),
                    'ward' => $this->getVariable('ward'),
                    'postal_code' => $this->getVariable('postal_code'),
                    'postal_address' => $this->getVariable('postal_address'),
                    'physical_address' => $this->getVariable('physical_address'),
                    'services' => implode(',', $this->getVariable('services')),
                    'addition_info' => $this->getVariable('addition_info'),
                    'user_id' =>  $this->userId,


                ];


                $query = $this->serviceModel->saveServiceFormData($formData);

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
        return view('ServiceApplication/Pages/PersonalParticulars', $data);
    }
}
