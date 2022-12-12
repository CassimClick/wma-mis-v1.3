<?php

namespace App\Controllers\ServiceApplication;

use App\Models\ProfileModel;
use App\Controllers\BaseController;
use App\Libraries\CommonTasksLibrary;
use App\Models\ServiceApplication\LicenseModel;
use GuzzleHttp\Client;

class LicenseAuthController extends BaseController
{

    public $uniqueId;
    public $managerId;
    public $session;
    public $profileModel;
    public $licenseModel;
    public $CommonTasks;
    public $token;
    public function __construct()
    {
        $this->profileModel = new ProfileModel();
        $this->licenseModel = new LicenseModel();
        $this->session = session();
        $this->token = csrf_hash();
        $this->uniqueId = $this->session->get('license-applicant');
        $this->CommonTasks = new CommonTasksLibrary();
        helper(['form', 'array', 'date', 'regions']);
    }


    public function getVariable($var)
    {
        return $this->request->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function verifyNida()
    {


        $client = new Client();
        $nationalId = $this->getVariable('nationalId');
       
     
        $url = 'https://ors.brela.go.tz/um/load/load_nida/' . $nationalId;
        
        $headers = ["Content-Type" => "application/json", "Content-Length" => "0", "Connection" => "keep-alive", "Accept-Encoding" => "gzip, deflate, br"];

        $res = $client->request('POST', $url, ['headers' => $headers]);
        $data  = json_decode($res->getBody(), true)['obj'];

        return $this->response->setJSON([$data]);
        exit;



        if (!key_exists('result', $data)) {
            return $this->response->setJSON([
                'status' => 0,
                'msg' => 'Invalid NIDA Number',
                'NIDA' =>  $nationalId,
            ]);
        } else {
            $this->session->set('license-applicant', 'HelloWorld');

            return $this->response->setJSON([
                'status' => 1,
                'user' => $data['result'],
                'session' =>  $this->session->get('license-applicant')
            ]);
        }
       
    }


    public function index()
    {



        $data['page'] = (object)[
            "title" => "Dashboard",
            "heading" => "Dashboard",
        ];


        // $data['uniqueId'] = $this->uniqueId;
        // $data['role'] = $this->role;
        // $data['profile'] = $this->profileModel->getLoggedUserData($this->uniqueId);
        return view('ServiceApplication/Pages/LicenseDashboard');
    }

    public function signup()
    {
        $data['page'] = (object)[
            "title" => "User Signup",
            "heading" => "User Signup",
        ];
        return view('ServiceApplication/Auth/Signup', $data);
    }

    public function sendEmail($hash)
    {
        $user = $this->licenseModel->getUser($hash);
        $userEmail = $user->email;
        $data['username'] = $user->first_name . ' '. $user->last_name;

        $data['link'] = base_url('license-application/user-account-activation/' . $hash);
        
        $email = \Config\Services::email();

        $email->setTo($userEmail);
      

        $email->setSubject('Account Activation');
        $email->setMessage(view('ServiceApplication/Auth/ActivationTemplate', $data));

        $email->send();
         
    }

    public function createAccount()
    {
        $nationality = $this->getVariable('nationality');
        $rule = [

            
            'email' => [
                'label' => 'email',
                "rules" => "required|valid_email|is_unique[license_users.email]",
                'errors' => [
                    'required' => 'Please Enter Email  Address',
                    'valid_email' => 'Invalid Email Address',
                    'is_unique' => 'Email Address Already Taken',
                ]
            ],
            'phoneNumber' => [
                'label' => 'phoneNumber',
                "rules" => "required",
                'errors' => [
                    'required' => 'Please Enter Phone Number',
                  
                ]
            ],
            'password' => [
                'label' => 'password',
                'rules' => 'required|min_length[8]|includeUpperCase[password]|includeLowerCase[password]|includeNumber[password]|includeSpecialChars[password]',
                'errors' => [
                    'required' => 'Please Enter Password',
                    'min_length' => 'Password Must Contain More Than 8 Characters',
                    'includeUpperCase' => 'Password Must Include Upper Case Latter',
                    'includeLowerCase' => 'Password Must Include Lower Case Latter',
                    'includeSpecialChars' => 'Password Must Include Special Characters',
                    'includeNumber' => 'Password Must Include Numbers',
                ]
            ],
            'password2' => [
                'label' => 'password2',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Please Enter Password',
                    'matches' => 'Passwords Do Not Match',

                ]
            ],
        ];

        if ($nationality == 'Foreigner') {
            $rules['country'] = [
                'label' => 'country',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Select Country.',
                   
                ]
            ];
            $rules['passportNumber'] =
            [
                'label' => 'passportNumber',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Passport Number',
                   
                ]
            ];
        }
        if ($nationality == 'Tanzanian') {
            $rules['national_id'] =
            [
                'label' => 'nationalId',
                'rules' => 'required|min_length[20]',
                'errors' => [
                    'required' => 'Please enter your NIDA ID.',
                    'min_length' => 'Nida Id is Not Complete',
                    // 'isValidNida' => 'Invalid National Id Number',
                ]
            ];
            $rules['region'] = [
                'label' => 'region',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Select Region',
                   
                ]
            ];
        }

        


        if (!$this->validate($rule)) {
            return $this->response->setJSON([
                'status' => 0,
                'token' => $this->token,
                'errors' => $this->validator->getErrors()
            ]);
        } else {
           $hash = randomString();
            $user = [
                'hash' => $hash,
                'nationality' =>$nationality,
                'first_name' => ucfirst(strtolower($this->getVariable('firstName'))),
                'middle_name' => ucfirst(strtolower($this->getVariable('middleName'))),
                'last_name' => ucfirst(strtolower($this->getVariable('lastName'))),
                'gender' => ucfirst(strtolower($this->getVariable('gender'))),
                'email' => $this->getVariable('email'),
                'phone_number' => $this->getVariable('phoneNumber'),
                'password' => password_hash($this->getVariable('password'),PASSWORD_DEFAULT),
            ];

            if($nationality == 'Foreigner') {
                $user['country'] = $this->getVariable('country');
                $user['passport_number'] = $this->getVariable('passportNumber');

            }
            if($nationality == 'Tanzanian') {
                $user['national_id'] = $this->getVariable('nationalId');
                $user['region'] = $this->getVariable('region');
            }
            // return $this->response->setJSON([
            //     'user'=>$user,
            //     'errors' => [],
            //     'activation' => base_url('license-application/confirm-email/' . $hash)
            // ]);
            // exit;
            $query = $this->licenseModel->createAccount($user);
            // $query = true;
            if ($query) {
                return $this->response->setJSON([
                    'status' => 1,
                    'msg' => 'Account Created',
                    'email' => $this->getVariable('email'),
                    'token' => $this->token,
                    'errors' => [],
                    'activation' => base_url('license-application/confirm-email/' . $hash)
                    
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => $this->token,
                    'errors' => [],
                    
                ]);
            }
        }
    }
    public function signin()
    {
        $data['page'] = (object)[
            "title" => "User Signin",
            "heading" => "User Signin",
        ];
        return view('ServiceApplication/Auth/Signin', $data);
    }

    public function confirmEmail($hash)
    {
        $send = $this->sendEmail($hash);
        $data['page'] = (object)[
            "title" => "Confirm Email Address",
            "heading" => "Confirm Email Address",
        ];
        return view('ServiceApplication/Auth/ConfirmEmail', $data);  
    }

    


    public function logout()
    {
        $this->session->remove('license-applicant');
        $this->session->destroy();
        return redirect()->to('/license-application/signin');
    }
}
