<?php

namespace App\Controllers;

use App\Models\ManagerModel;
use App\Models\ProfileModel;

class Profile extends BaseController
{

    public $session;
    public $managerModel;
    public $profileModel;
    public $uniqueId;
    public $managerId;
    // public $admin;
    public $userRole;
    public $appRequest;
    public function __construct()
    {
        $this->appRequest = service('request');
        $this->profileModel = new ProfileModel();
        $this->managerModel = new ManagerModel();
        $this->session = session();
        $this->uniqueId = $this->session->get('loggedUser');

        // $this->admin = $this->session->get('SuperUser');
        $this->userRole = $this->role = $this->profileModel->getRole($this->uniqueId)->role;
        helper(['form', 'url', 'array', 'date']);
    }

    public function getVariable($var)
    {
        return $this->appRequest->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    public function index()
    {



        $uniqueId = $this->uniqueId;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['role'] = $this->userRole;
        $data['tasks'] = $this->managerModel->getMyTask($uniqueId);

        $data['page'] = [
            'title' => 'User Profile',
            'heading' => 'User Profile',
        ];

        // ==============================

        $rules = [
            'avatar' => 'uploaded[avatar]|max_size[avatar,1024]|ext_in[avatar,png,jpeg,jpg]',
        ];

        if ($this->request->getMethod() == 'post') {
            if ($this->validate($rules)) {
                $file = $this->appRequest->getFile('avatar');
                if ($file->isValid() && !$file->hasMoved()) {
                    $randomName = $file->getRandomName();
                    if ($file->move(FCPATH . 'public/uploads/avatars/', $randomName)) {

                        $path = base_url() . '/public/uploads/avatars/' . $randomName;

                        $upload = $this->profileModel->updateAvatar($path, $this->uniqueId);
                        if ($upload) {
                            $this->session->setFlashdata('Success', 'Profile Picture Updated');
                            return redirect()->to(current_url());
                        } else {
                            $this->session->setFlashdata('error', 'Fail to update profile picture');
                            return redirect()->to(current_url());
                        }
                    }
                } else {

                    $this->session->setFlashdata('error', $file->getErrorString() . '' . $file->getError());
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('pages/profile/userProfile', $data);
    }
    public function changePassword()
    {
        $data = [];
        $data['validation'] = null;
        $data['page'] = [
            'title' => 'Change Password',
            'heading' => 'Change Password',
        ];
        $uniqueId = $this->uniqueId;
        $managerId =  $this->uniqueId;
        $role = $this->userRole;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        // if ($role == 1) {
        // } elseif ($role == 2) {
        //     $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        // }

        $data['role'] = $role;

        if ($this->request->getMethod() == 'post') {
            $rules = [

                'oldPassword' => 'required|min_length[6]|max_length[15]',
                'newPassword' => 'required|min_length[6]|max_length[20]|includeUpperCase[newPassword]|includeLowerCase[newPassword]|includeNumber[newPassword]|includeSpecialChars[newPassword]',
                'confirmNewPassword' => 'required|matches[newPassword]',
            ];



            $errors = [
                'password' => [
                    'includeUpperCase' => 'Password Must Contain  Uppercase Latter',
                    'includeLowerCase' => 'Password Must Contain  Lowercase Latter',
                    'includeNumber' => 'Password Must Contain  Number',
                    'includeSpecialChars' => 'Password Must Contain  Special Character',
                ]
            ];

            if ($this->validate($rules,  $errors)) {
                $oldPassword = $this->appRequest->getVar('oldPassword');
                $confirmNewPassword = password_hash($this->appRequest->getVar('confirmNewPassword'), PASSWORD_DEFAULT);

                if (password_verify($oldPassword, $data['profile']->password)) {
                    $request = $this->profileModel->updatePassword($uniqueId, $confirmNewPassword);

                    if ($request) {

                        $this->session->setFlashData('Success', 'Password Updated Successfully');
                        if ($role == 1) {
                            return redirect()->to('dashboard');
                        } elseif ($role == 2) {
                            return redirect()->to('managerDashboard');
                        }
                    }
                } else {
                    $this->session->setFlashData('error', 'Invalid Old Password');
                }
                // exit;
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('pages/auth/changePassword', $data);
    }

    public function confirmTask($id)
    {

        //$id  = $this->request->getVar('id');
        $uniqueId = $this->uniqueId;
        $taskData = $this->managerModel->getMyTask($uniqueId);

        $this->managerModel->confirmTask($id);
        $this->session->setFlashdata('Success', 'Task Confirmed');
        // return redirect()->to('/listBulkStorageTanks');

        return redirect()->to('/profile');
    }

    public function managerProfile()
    {


        $uniqueId = $this->uniqueId;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['role'] = $this->userRole;
        // $data['tasks'] = $this->managerModel->getMyTask($uniqueId);

        $data['page'] = [
            'title' => 'User Profile',
            'heading' => 'User Profile',
        ];

        // ==============================

        $rules = [
            'avatar' => 'uploaded[avatar]|max_size[avatar,1024]|ext_in[avatar,png,jpeg,jpg]',
        ];

        if ($this->request->getMethod() == 'post') {
            if ($this->validate($rules)) {
                $file = $this->appRequest->getFile('avatar');
                if ($file->isValid() && !$file->hasMoved()) {
                    $randomName = $file->getRandomName();
                    if ($file->move(FCPATH . 'public/uploads/avatars/', $randomName)) {

                        $path = base_url() . '/public/uploads/avatars/' . $randomName;
                        $upload = $this->profileModel->updateAvatar($path,  $this->uniqueId);
                        if ($upload) {
                            $this->session->setFlashdata('Success', 'Profile Picture Updated');
                            return redirect()->to(current_url());
                        } else {
                            $this->session->setFlashdata('error', 'Fail to update profile picture');
                            return redirect()->to(current_url());
                        }
                    }
                } else {

                    $this->session->setFlashdata('error', $file->getErrorString() . '' . $file->getError());
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('pages/profile/userprofile', $data);
    }

    public function directorProfile()
    {


        // $director = $this->director;
        $data['profile'] = $this->profileModel->getLoggedUserData($this->uniqueId);
        $data['role'] = $this->userRole;
        // $data['tasks'] = $this->managerModel->getMyTask($uniqueId);

        $data['page'] = [
            'title' => 'User Profile',
            'heading' => 'User Profile',
        ];

        // ==============================

        $rules = [
            'avatar' => 'uploaded[avatar]|max_size[avatar,1024]|ext_in[avatar,png,jpeg,jpg]',
        ];

        if ($this->request->getMethod() == 'post') {
            if ($this->validate($rules)) {
                $file = $this->appRequest->getFile('avatar');
                if ($file->isValid() && !$file->hasMoved()) {
                    $randomName = $file->getRandomName();
                    if ($file->move(FCPATH . 'public/uploads/avatars/', $randomName)) {

                        $path = base_url() . '/public/uploads/avatars/' . $randomName;
                        $upload = $this->profileModel->updateAvatar($path,  $this->uniqueId);
                        if ($upload) {
                            $this->session->setFlashdata('Success', 'Profile Picture Updated');
                            return redirect()->to(current_url());
                        } else {
                            $this->session->setFlashdata('error', 'Fail to update profile picture');
                            return redirect()->to(current_url());
                        }
                    }
                } else {

                    $this->session->setFlashdata('error', $file->getErrorString() . '' . $file->getError());
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('pages/profile/userprofile', $data);
    }

    public function avatar()
    {

        $rules = [
            'avatar' => 'uploaded[avatar]|max_size[avatar,1024]|ext_in[avatar,png,jpeg,jpg]',
        ];

        if ($this->request->getMethod() == 'post') {
            if ($this->validate($rules)) {
                $file = $this->appRequest->getFile('avatar');
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(WRITEPATH . 'uploads/avatars/', $newName);

                    echo "file uploaded";
                } else {
                    $file->getErrorString() . '' . $file->getError();
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('pages/profile/userprofile', $data);
    }
    public function logout()
    {
        $this->session->remove('loggedUser');
        $this->session->destroy();
        return redirect()->to('/login');
    }


    public function activateAccount($hash)
    {
        $data = [];
        $data['validation'] = null;
        $data['page'] = [
            'title' => 'Account Activation',
        ];
        if ($this->appRequest->getMethod() == 'post') {
            $rules = [


                "password"        => "required|min_length[6]|max_length[20]|includeUpperCase[password]|includeLowerCase[password]|includeNumber[password]|includeSpecialChars[password]",
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
                $userData = [
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'status' => 'active'
                ];
                // print_r($userData);
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
}
