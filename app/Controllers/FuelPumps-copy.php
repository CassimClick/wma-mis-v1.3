<?php

namespace App\Controllers;

//use \CodeIgniter\Models\FuelPumpModel;
use App\Models\FuelPumpModel as ModelForPumps;
use \CodeIgniter\Validation\Rules;

class FuelPumps extends BaseController
{
        public $pumpModel;
        public function __construct()
        {
                $this->pumpModel = new ModelForPumps();
                helper('form');
        }

        // A method for fuel Pumps
        public function newPump()
        {


                $session = session();
                $data = [];
                $data['validation'] = null;
                $rules = [
                        "firstname"          => "required|min_length[3]|max_length[15]",
                        "lastname"           => "required|min_length[3]|max_length[15]",
                        "gender"             => "required",
                        "city"               => "required",
                        "ward"               => "required",
                        "postal"             => "required",
                        "phone"              => "required",
                        "date"               => "required",
                        "petrolstation"      => "required",
                        "product"            => "required",
                        "pumptype"           => "required",
                        "pumpcapacity"       => "required|numeric",
                        "numberofdispensers" => "required|numeric",
                        "status"             => "required",
                        "sickernumber"       => "required",
                        "controlnumber"      => "required",

                ];
                $data['page'] = [
                        "title"   => "Fuel Pump",
                        "heading" => "New Fuel Pump"
                ];
                $data['statusResult'] = ['Pass', 'Rejected'];
                $data['genderValues'] = ['Male', 'Female'];
                $data['products'] = [
                        'Petrol And Diesel',
                        'Petrol',
                        'Diesel',
                ];



                $data['pumps'] = [
                        'Gilbarco',
                        'ChangLong',
                        'Tokheim',
                        'Tatsuno',
                        'EgoStar',
                        'Piusi',
                        'Zecheng',
                        'L & T',
                        'Mekser',

                ];

                if ($this->request->getMethod() == 'post') {
                        if ($this->validate($rules)) {
                                // return redirect()->to('dashboard');
                                $pumpData = [
                                        "first_name" => $this->request->getVar('firstname', FILTER_SANITIZE_STRING),
                                        "last_name" => $this->request->getVar('lastname', FILTER_SANITIZE_STRING),
                                        "gender" => $this->request->getVar('gender', FILTER_SANITIZE_STRING),
                                        "city" => $this->request->getVar('city', FILTER_SANITIZE_STRING),
                                        "ward" => $this->request->getVar('ward', FILTER_SANITIZE_STRING),
                                        "postal_address" => $this->request->getVar('postal', FILTER_SANITIZE_STRING),
                                        "phone_number" => $this->request->getVar('phone', FILTER_SANITIZE_STRING),
                                        "date" => $this->request->getVar('date'),
                                        "petrol_station" => $this->request->getVar('petrolstation', FILTER_SANITIZE_STRING),
                                        "product" => $this->request->getVar('product', FILTER_SANITIZE_STRING),
                                        "pump_type" => $this->request->getVar('pumptype', FILTER_SANITIZE_STRING),
                                        "capacity" => $this->request->getVar('pumpcapacity', FILTER_SANITIZE_STRING),
                                        "dispensers" => $this->request->getVar('numberofdispensers', FILTER_SANITIZE_STRING),
                                        "status" => $this->request->getVar('status', FILTER_SANITIZE_STRING),
                                        "sticker_number" => $this->request->getVar('stickernumber', FILTER_SANITIZE_NUMBER_INT),
                                        "control_number" => $this->request->getVar('controlnumber', FILTER_SANITIZE_NUMBER_INT)
                                ];

                                $data['details'] = $pumpData;
                                // $status =   $this->pumpModel->savePumpData($pumpData);

                                // if ($status) {
                                //         $session->setFlashdata('success', 'Data Inserted Successfully <i class="fal fa-smile-wink"></i>');
                                //         return redirect()->to(current_url());
                                //         // echo "<script>alert('Data Inserted');</script>";
                                // } else {
                                //         $session->setFlashdata('error', 'Fail To Insert Data Try Again');
                                // }
                        } else {
                                $data['validation'] = $this->validator;
                        }
                }






                return view('pages/newPump', $data);
        }

        // A method for Packages

}