<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProfileModel;

class UserAccountController extends BaseController
{

    public $profileModel;

    public $appRequest;
    public function __construct()
    {
        $this->appRequest = service('request');
        $this->profileModel = new ProfileModel();

        helper(['form', 'url', 'array', 'date']);
    }
    public function index()
    {
        echo 'hello';
    }
    public function getVariable($var)
    {
        return $this->appRequest->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }



    public function activateAccount($contact,$hash)

    {
        // var_dump($hash);
        // exit;
        $params = [];
        $data = [];
        $data['validation'] = null;
       // $contact = $contact;
        $data['contact'] = $contact;
        $data['page'] = [
            'title' => 'Account Activation',
        ];
        if ($this->appRequest->getMethod() == 'post') {
            $rules = [


                // "phone"        => "required|min_length[10]|max_length[10]",
                "password"   => "required|min_length[8]|max_length[20]|includeUpperCase[password]|includeLowerCase[password]|includeNumber[password]",
                "confirm-password" => "required|matches[password]",
            ];

            if ($contact == 1) {
                $rules = [

                    "phone"        => "required|min_length[10]|max_length[10]",
                    "password"        => "required|min_length[8]|max_length[20]|includeUpperCase[password]|includeLowerCase[password]|includeNumber[password]|includeSpecialChars[password]",
                    "confirm-password" => "required|matches[password]",
                ];
            } else {
                $rules = [
                    "password"        => "required|min_length[8]|max_length[20]|includeUpperCase[password]|includeLowerCase[password]|includeNumber[password]|includeSpecialChars[password]",
                    "confirm-password" => "required|matches[password]",
                ];
            }



            $errors = [
                'password' => [
                    'includeUpperCase' => 'Password Must Contain  Uppercase Latter',
                    'includeLowerCase' => 'Password Must Contain  Lowercase Latter',
                    'includeNumber' => 'Password Must Contain  Number',
                    'includeSpecialChars' => 'Password Must Contain  Special Character',
                ]
            ];



            if ($this->validate($rules,$errors)) {

                $password = $this->appRequest->getVar('password');
                if($contact == 1){
                    $userData = [
                        'phone_number' => $this->getVariable('phone'),
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                        'status' => 'active'
                    ];
                }else{
                    $userData = [
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                        'status' => 'active'
                    ];
                }
               
                // var_dump($userData);
                // exit;


                $request = $this->profileModel->savePassword($hash, $userData);
                if ($request) {
                    return redirect()->to('/login');
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('pages/auth/ActivationPage', $data);
    }
    public function activate($contact,$hash)

    {
        // var_dump($hash);
        // exit;
        $params = [];
        $data = [];
        $data['validation'] = null;
        $data['contact'] = $contact;
        $data['page'] = [
            'title' => 'Account Activation',
        ];
        if ($this->appRequest->getMethod() == 'post') {
            $rules = [


                "phone"        => "required|min_length[10]|max_length[10]",
                "password"   => "required|min_length[8]|max_length[20]|includeUpperCase[password]|includeLowerCase[password]|includeNumber[password]|includeSpecialChars[password]",
                "confirm-password" => "required|matches[password]",
            ];


            $errors = [
                'password' => [
                    'includeUpperCase' => 'Password Must Contain  Uppercase Latter',
                    'includeLowerCase' => 'Password Must Contain  Lowercase Latter',
                    'includeNumber' => 'Password Must Contain  Number',
                    'includeSpecialChars' => 'Password Must Contain  Special Character',
                ]
            ];


            if ($this->validate($rules, $errors)) {

                $password = $this->appRequest->getVar('password');
                if($contact == 1){
                    $userData = [
                        'phone_number' => $this->getVariable('phone'),
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                        'status' => 'active'
                    ];
                }else{
                    $userData = [
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                        'status' => 'active'
                    ];
                }
               
                // var_dump($userData);
                // exit;


                $request = $this->profileModel->savePassword($hash, $userData);
                if ($request) {
                    return redirect()->to('/login');
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        //return view('pages/auth/ActivationPage', $data);
    }
}
