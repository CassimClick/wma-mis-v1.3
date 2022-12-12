<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class CustomerController extends BaseController
{
    protected $customerModel;
    protected $token;
    protected $uniqueId;
    protected $session;
    public function __construct()
    {
        $this->session = session();
        $this->token = csrf_hash();
        $this->customerModel = new CustomerModel();
        $this->uniqueId = $this->session->get('loggedUser');
    }
    public function getVariable($var)
    {
        return $this->request->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }


    public function addCustomer()
    {

        if ($this->request->getMethod() == 'post') {


            $hash = random_string('alnum', 32);
            $customer = [
                "hash" => $hash,
                "name" => $this->getVariable('name'),
                "region" => $this->getVariable('region'),
                "district" => $this->getVariable('district'),
                "ward" => $this->getVariable('ward'),
                "location" => $this->getVariable('location'),
                "village" => $this->getVariable('village'),
                "physical_address" => $this->getVariable('physicalAddress'),
                "postal_address" => $this->getVariable('postalAddress'),
                "postal_code" => $this->getVariable('postalCode'),
                "phone_number" => $this->getVariable('phoneNumber'),


                //"unique_id" => $this->uniqueId,

            ];

            // return $this->response->setJSON([
            //     'data' => $customer,
            //     'token' => $this->token,

            // ]);
            // exit;
            $request = $this->customerModel->createCustomer($customer);
            // $lastHash = $this->customerModel->lastHash();

            if ($request) {
                return $this->response->setJSON([
                    'hash' => $this->customerModel->lastHash()[0]->hash,
                    'status' => 1,
                    'customer' => $this->customerModel->selectCustomer($hash),
                    'msg' => 'Customer Added',
                    'token' => $this->token,

                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Something went wrong',
                    'token' => $this->token,

                ]);
            }
        }
    }
    

    public function selectCustomer()
    {
        $hash = $this->getVariable('hash');
        $request = $this->customerModel->selectCustomer($hash);

        if ($request) {
            return $this->response->setJSON([
                'status' => 1,
                'customer' => $request,
                'token' => $this->token,

            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'msg' => 'Something went wrong',
                'customer' => [],
                'token' => $this->token,

            ]);
        }
         
    }



    //=================searching existing customer====================
    public function searchCustomer()
    {

        $keyword = $this->getVariable('keyword');
        $request = $this->customerModel->searchCustomer($keyword);
        if (count($request) > 0) {
            return $this->response->setJSON([
                'status' => 1,
                'data' => $request,
                'token' => $this->token
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'data' => [],
                'token' => $this->token
            ]);
        }
    }
}
