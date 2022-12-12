<?php

namespace App\Controllers\ServiceApplication;

use App\Models\ProfileModel;
use App\Controllers\BaseController;
use App\Libraries\CommonTasksLibrary;
use App\Models\ServiceApplication\ServiceModel;
use GuzzleHttp\Client;

class ServiceAuthController extends BaseController
{

    public $uniqueId;
    public $managerId;
    public $session;
    public $profileModel;
    public $serviceModel;
    public $CommonTasks;
    public $token;
    public function __construct()
    {
        $this->profileModel = new ProfileModel();
        $this->serviceModel = new ServiceModel();
        $this->session = session();
        $this->token = csrf_hash();
        $this->uniqueId = $this->session->get('service-applicant');
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
            $this->session->set('service-applicant', 'HelloWorld');

            return $this->response->setJSON([
                'status' => 1,
                'user' => $data['result'],
                'session' =>  $this->session->get('service-applicant')
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
        return view('ServiceApplication/Pages/ServiceDashboard');
    }

    public function signup()
    {
        $data['page'] = (object)[
            "title" => "User Signup",
            "heading" => "User Signup",
        ];
        return view('ServiceApplication/Auth/ServiceSignup', $data);
    }

    public function sendEmail($user)
    {

        $userEmail = $user->email;
        $data['username'] = $user->first_name . ' ' . $user->last_name;

        $data['link'] = base_url('service-request/user-account-activation/' . $user->hash);

        $email = \Config\Services::email();

        $email->setTo($userEmail);


        $email->setSubject('Account Activation');
        $email->setMessage(view('ServiceApplication/Auth/ActivationTemplate', $data));

        $email->send();
    }

    public function createAccount()
    {

        $rule = [


            'email' => [
                'label' => 'email',
                "rules" => "required|valid_email|is_unique[service_users.email]",
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
            'region' => [
                'label' => 'region',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Select Region',

                ]
            ]
        ];


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
                'first_name' => ucfirst(strtolower($this->getVariable('firstName'))),
                'middle_name' => ucfirst(strtolower($this->getVariable('middleName'))),
                'last_name' => ucfirst(strtolower($this->getVariable('lastName'))),
                'gender' => ucfirst(strtolower($this->getVariable('gender'))),
                'email' => $this->getVariable('email'),
                'phone_number' => $this->getVariable('phoneNumber'),
                'password' => password_hash($this->getVariable('password'), PASSWORD_BCRYPT),
            ];


            // return $this->response->setJSON([
            //     'user'=>$user,
            //     'errors' => [],
            //     'activation' => base_url('service-request/confirm-email/' . $hash)
            // ]);
            // exit;
            $query = $this->serviceModel->createAccount($user);
            // $query = true;
            if ($query) {
                return $this->response->setJSON([
                    'status' => 1,
                    'msg' => 'Account Created',
                    'email' => $this->getVariable('email'),
                    'token' => $this->token,
                    'errors' => [],
                    'activation' => base_url('service-request/confirm-email/' . $hash)

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
    public function login()
    {
        $data = [];
        $data['page'] = (object)[
            "title" => "User Signin",
            "heading" => "User Signin",
        ];
        $data['validation'] = null;


        if ($this->request->getMethod() == 'post') {
            $rules = [

                "email" => "required|valid_email",
                "password" => "required|min_length[6]|max_length[25]",
            ];

            $errors = [
                'password' => [
                    'includeSpecialChars' => 'Password Must Contain At least One Special Character',
                    'includeLowerCase' => 'Password Must Contain At least One Lowercase Latter',
                    'includeUpperCase' => 'Password Must Contain At least One Upper case Latter',
                    'includeNumber' => 'Password Must Contain At least One Number',
                ]
            ];
            if ($this->validate($rules, $errors)) {

                $email =   $this->request->getVar('email', FILTER_SANITIZE_SPECIAL_CHARS);
                $password =   $this->request->getVar('password', FILTER_SANITIZE_SPECIAL_CHARS);

                $userData = $this->serviceModel->verifyEmail($email);

                if ($userData) {
                    if (password_verify($password, $userData['password'])) {
                        if ($userData['status'] === 'Active') {
                            $SessionData = [
                                'service-applicant'  => $userData['hash'],
                                'city'     => $userData['region'],

                            ];
                            $this->session->set($SessionData);
                            return redirect()->to('service-request/license-application');
                        } else {
                            $this->session->setFlashdata('error', 'Your Account in Inactive');
                            return redirect()->to(current_url());
                        }
                    } else {
                        $this->session->setFlashdata('error', 'Wrong Credentials Entered');
                        return redirect()->to(current_url());
                    }
                } else {
                    $this->session->setFlashdata('error', 'Email Does Not Exist');
                    return redirect()->to(current_url());
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('ServiceApplication/Auth/Signin', $data);
    }

    public function confirmEmail($hash)
    {
        $user = $this->serviceModel->getUser($hash);
        $this->sendEmail($user);
        $data['page'] = (object)[
            "title" => "Confirm Email Address",
            "heading" => "Confirm Email Address",

        ];
        $data['email'] = $user->email;
        return view('ServiceApplication/Auth/ConfirmEmail', $data);
    }

    public function AccountActivation($hash)
    {
        $req = $this->serviceModel->activateACCount($hash);
        if ($req) {
            return redirect()->to('service-request/login');
        } else {
            return redirect()->back();
        }
    }

    public function forgotPassword()
    {
        $data['page'] = (object)[
            "title" => "Reset Password",
            "heading" => "Reset Password",

        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                "email" => "required|valid_email",
            ];
            $userEmail =   $this->request->getVar('email', FILTER_SANITIZE_SPECIAL_CHARS);
            if ($this->validate($rules)) {
                $user = $this->serviceModel->verifyApplicantEmail($userEmail);
                if ($user) {
                
                    $data['username'] = $user->first_name . ' ' . $user->last_name;

                    $data['link'] = base_url('service-request/new-password/' . $user->hash);

                    $email = \Config\Services::email();

                    $email->setTo($userEmail);


                    $email->setSubject('Password Reset');
                    $data['msg'] = 'You recently requested your WMA OSA password.Click the button bellow to setup new password';
                    $email->setMessage(view('ServiceApplication/Auth/PasswordTemplate', $data));

                    $email->send();
                    return redirect()->to(base_url('service-request/password-reset/'. $userEmail));
                } else {
                    $this->session->setFlashdata('error', 'Email Does Not Exist');
                    return redirect()->to(current_url());
                }
            }
        }



        return view('ServiceApplication/Auth/ForgotPassword', $data);
    }

    public function passwordReset($email = null)
    {
        $data['email'] = $email;

        return view('ServiceApplication/Auth/PasswordReset',$data);   
    }
    public function newPassword($hash)
    {

        $data['page'] = (object)[
            "title" => "New  Password",
            "heading" => "New  Password",

        ];
        $data['validation'] = null;
     

        if($this->request->getMethod() == 'post'){
            $rules = [
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
                'confirm_password' => [
                    'label' => 'confirm_password',
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Please Enter Password',
                        'matches' => 'Passwords Do Not Match',

                    ]
                ],
            ];

            if($this->validate($rules)){

                $password = password_hash($this->getVariable('password'),PASSWORD_BCRYPT);
                $query = $this->serviceModel->updatePassword($hash,$password);
                if($query){
                    return redirect()->to('service-request/login');
                }else{
                    // $this->session->setFlashdata('error', 'Wrong Credentials Entered');
                    return redirect()->to(current_url());
                }
          
            }else{
                $data['validation'] = $this->validator;
            }

        }

        return view('ServiceApplication/Auth/NewPassword',$data);   
    }




    public function logout()
    {
        $this->session->remove('service-applicant');
        $this->session->destroy();
        return redirect()->to('/service-request/login');
    }
}
