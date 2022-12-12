<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \App\Models\LoginModel;

class Login extends BaseController
{
    public $loginModel;
    public $session;
    public $request;

    public function __construct()
    {
        $this->request = service('request');
        $this->loginModel = new LoginModel();
        $this->session = session();
        helper(['form', 'url', 'array']);
    }

    public function index()
    {

       

        $data = [];
        $data['validation'] = null;
        $data['page'] = [
            'title' => 'Log In',
        ];

        if ($this->request->getMethod() == 'post') {
            $rules = [

                "email" => "required|valid_email",
                "password" => "required|min_length[6]|max_length[25]",
            ];

            $errors = [
                'password' => [
                    'includeSpecialChars' => 'Password Must Contain At least One Special Character',
                    // 'includeLowerCase' => 'Password Must Contain At least One Lowercase Latter',
                    // 'includeNumber' => 'Password Must Contain At least One Number',
                ]
            ];
            if ($this->validate($rules)) {

                $email =   $this->request->getVar('email', FILTER_SANITIZE_SPECIAL_CHARS);
                $password =   $this->request->getVar('password', FILTER_SANITIZE_SPECIAL_CHARS);

                $userData = $this->loginModel->verifyEmail($email);

                if ($userData) {
                    if (password_verify($password, $userData['password'])) {
                        if ($userData['status'] === 'active') {

                            if ($userData['role'] == 1) {
                                $this->session->set('loggedUser', $userData['unique_id']);
                                $this->session->set('status', $userData['status']);
                          
                                $this->session->set('city', $userData['city']);
                                return redirect()->to('/dashboard');
                            }
                            if ($userData['role'] == 2) {
                                $this->session->set('loggedUser', $userData['unique_id']);
                                $this->session->set('status', $userData['status']);
                                $this->session->set('city', $userData['city']);
                                return redirect()->to('/manager');
                            }
                            if ($userData['role'] == 3) {
                                $this->session->set('loggedUser', $userData['unique_id']);
                                $this->session->set('status', $userData['status']);
                                $this->session->set('city', $userData['city']);
                                return redirect()->to('/directorDashboard');
                            }
                            if ($userData['role'] == 7) {

                                $SessionData = [
                                    'loggedUser'  => $userData['unique_id'],
                                    'SuperAdmin'     => 'SuperAdmin',
                                    'city'     => $userData['city'],
                                    
                                ];
                                $this->session->set($SessionData);

                              
                               
                                return redirect()->to('admin/dashboard');
                            }
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
        return view('pages/auth/UserLogin', $data);
    }
}