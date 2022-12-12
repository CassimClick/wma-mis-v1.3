<?php

namespace App\Controllers;

use App\Libraries\CommonTasksLibrary;
use App\Models\PrePackageModel;
use App\Models\ProfileModel;
use \CodeIgniter\Validation\Rules;
//use \CodeIgniter\Models\industrialModel;

class IndustrialPackages extends BaseController
{
        public $uniqueId;
        public $managerId;
        public $role;
        public $city;
        public $industrialModel;
        public $session;
        public $profileModel;
        public $CommonTasks;
        public function __construct()
        {
                $this->industrialModel = new PrePackageModel();
                $this->profileModel = new ProfileModel();
                $this->session = session();
                $this->uniqueId = $this->session->get('loggedUser');
                $this->managerId = $this->session->get('manager');
                $this->role = $this->profileModel->getRole($this->uniqueId)->role;
                $this->city = $this->session->get('city');
                $this->CommonTasks = new CommonTasksLibrary;
                helper(['form', 'array', 'regions']);
        }





        // A method for Packages
        public function newIndustrialPackage()
        {



                $data = [];
                $data['validation'] = null;
                $rules = [
                       


                        "industryname"  => "required",
                        "product"       => "required",
                        "status"        => "required",
                        // "controlnumber" => "required|numeric",
                        // "amount"        => "required|numeric",


                ];
                $data['page'] = [
                        "title"   => "Industrial Packages",
                        "heading" => "Industrial Packages"
                ];
                $data['genderValues'] = ['Male', 'Female'];
                $data['statusResult'] = ['Pass', 'Rejected'];



                if ($this->request->getMethod() == 'post') {
                        $results = $this->request->getVar('status', FILTER_SANITIZE_STRING);
                        $amount = 0;
                        $controlNumber = '';
                    
                        $payment = '';
                        switch ($results) {
                                case 'Pass':
                                        $amount += $this->request->getVar('passamount', FILTER_SANITIZE_NUMBER_INT);
                                        $controlNumber .= $this->request->getVar('passcontrolnumber', FILTER_SANITIZE_STRING);
                                        $payment .= $this->request->getVar('pass-payment', FILTER_SANITIZE_STRING);
                                      

                                        break;
                                case 'Rejected':
                                        $amount += $this->request->getVar('rejectedamount', FILTER_SANITIZE_NUMBER_INT);
                                        $controlNumber .= $this->request->getVar('rejectedcontrolnumber', FILTER_SANITIZE_STRING);
                                        $payment .= $this->request->getVar('rejection-payment', FILTER_SANITIZE_STRING);
                                     

                                        break;
                                case 'Condemned':
                                    
                                        break;

                                default:
                                        # code...
                                        break;
                        }

                        if ($this->validate($rules)) {
                                // return redirect()->to('dashboard');
                                $packageData = [
                                        "hash" => md5(str_shuffle('abcdefghijklmnopqqrtuvwzyz0123456789')),
                                     
                                        "customer_hash" => $this->request->getVar('customer_hash', FILTER_SANITIZE_STRING),
                                        "industry_name" => $this->request->getVar('industryname', FILTER_SANITIZE_STRING),
                                        "product" => $this->request->getVar('product', FILTER_SANITIZE_STRING),
                                        "status" => $this->request->getVar('status', FILTER_SANITIZE_STRING),
                                        "control_number" => $controlNumber,
                                        "amount" => $amount,
                                        "payment" => $payment,
                                        
                                        "unique_id" => $this->uniqueId
                                ];


                                $status =   $this->industrialModel->saveIndustrialData($packageData);

                                if ($status) {
                                        $this->session->setFlashdata('Success', 'Data Inserted Successfully <i class="fal fa-smile-wink"></i>');
                                        return redirect()->to(current_url());
                                        // echo "<script>alert('Data Inserted');</script>";
                                } else {
                                        $this->session->setFlashdata('error', 'Fail To Insert Data Try Again');
                                }
                        } else {
                                $data['validation'] = $this->validator;
                        }
                }

                $uniqueId = $this->uniqueId;
                $role = $this->role;

                $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
                $data['role'] = $role;
                return view('pages/IndustrialPackages/addPackages', $data);
        }


        public function listIndustrialPackages()
        {


                $data['page'] = [
                        "title"   => "Industrial Packages",
                        "heading" => "Industrial Packages"
                ];


                $uniqueId = $this->uniqueId;
                $managerId = $this->managerId;
                $role = $this->role;
                $city = $this->city;

                if ($role == 1) {

                        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
                        $data['role'] = $role;
                        $data['industrialPackageResults'] = $this->industrialModel->getIndustrialPackages($uniqueId);
                        return view('pages/IndustrialPackages/listIndustrialPackages', $data);
                } elseif ($role == 2) {
                        $data['profile'] = $this->profileModel->getLoggedUserData($managerId);
                        $data['role'] = $role;
                        $data['industrialPackageResults'] = $this->industrialModel->getAllPrePackages($city);
                        return view('pages/IndustrialPackages/listIndustrialPackages', $data);
                }
        }

        // deleting a Record
        public function deleteIndustrialPackage($id)
        {

                $this->industrialModel->deleteRecord($id);
                $this->session->setFlashdata('Success', 'Record Deleted Successfully');
                return redirect()->to('/listIndustrialPackages');
        }

        public function editIndustrialPackage($id)
        {
                $data = [];
                $data['record'] =  $this->industrialModel->editRecord($id);
                $data['validation'] = null;

                $data['page'] = [
                        "title"   => "Edit Industrial Packages",
                        "heading" => "Edit Industrial Packages"
                ];
                $data['genderValues'] = ['Male', 'Female'];
                $data['statusResult'] = ['Pass', 'Rejected'];
                $data['paymentStatus'] = $this->CommonTasks->payment();


                $uniqueId = $this->uniqueId;
                $managerId = $this->managerId;
                $role = $this->role;

                if ($role == 1) {

                        $data['role'] = $role;
                        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
                } elseif ($role == 2) {

                        $data['role'] = $role;
                        $data['profile'] = $this->profileModel->getLoggedUserData($managerId);
                }


                return view('pages/IndustrialPackages/packagesEdit', $data);
        }

        public function updateIndustrialPackage($id)
        {
                $data = [];
                $data['validation'] = null;
                $rules = [
                      


                        "industryname"  => "required",
                        "product"       => "required",
                        "status"        => "required",
                        // "controlnumber" => "required|numeric",
                        // "amount"        => "required|numeric",


                ];
                $data['page'] = [
                        "title"   => "Industrial Packages",
                        "heading" => "Industrial Packages"
                ];
                $data['genderValues'] = ['Male', 'Female'];
                $data['statusResult'] = ['Pass', 'Rejected'];



                if ($this->request->getMethod() == 'post') {

                        $results = $this->request->getVar('status', FILTER_SANITIZE_STRING);
                        $amount = 0;
                        $controlNumber = '';
                        $filePath = '';
                        $report = '';
                        $payment = '';
                        switch ($results) {
                                case 'Pass':
                                        $amount += $this->request->getVar('passamount', FILTER_SANITIZE_NUMBER_INT);
                                        $controlNumber .= $this->request->getVar('passcontrolnumber', FILTER_SANITIZE_STRING);
                                        $payment .= $this->request->getVar('pass-payment', FILTER_SANITIZE_STRING);
                                     

                                        break;
                                case 'Rejected':
                                        $amount += $this->request->getVar('rejectedamount', FILTER_SANITIZE_NUMBER_INT);
                                        $controlNumber .= $this->request->getVar('rejectedcontrolnumber', FILTER_SANITIZE_STRING);
                                        $payment .= $this->request->getVar('rejection-payment', FILTER_SANITIZE_STRING);
                                      

                                        break;
                                case 'Condemned':
                                      
                                        break;

                                default:
                                        # code...
                                        break;
                        }
                        if ($this->validate($rules)) {
                                // return redirect()->to('dashboard');
                                $packageData = [
                                       
                                        "industry_name" => $this->request->getVar('industryname', FILTER_SANITIZE_STRING),
                                        "product" => $this->request->getVar('product', FILTER_SANITIZE_STRING),
                                        "status" => $this->request->getVar('status', FILTER_SANITIZE_STRING),
                                        "control_number" => $controlNumber,
                                        "amount" => $amount,
                                        "payment" => $payment,
                                       

                                ];


                                $status =   $this->industrialModel->updateIndustrialPackage($packageData, $id);

                                if ($status) {
                                        $this->session->setFlashdata('Success', 'Record Updated Successfully <i class="fal fa-smile-wink"></i>');
                                        return redirect()->to('listIndustrialPackages');
                                        // echo "<script>alert('Data Inserted');</script>";
                                } else {
                                        $this->session->setFlashdata('error', 'Fail To Update Data Try Again');
                                }
                        } else {
                                $data['validation'] = $this->validator;
                        }
                }


                return redirect()->to('/listIndustrialPackages');
        }
}