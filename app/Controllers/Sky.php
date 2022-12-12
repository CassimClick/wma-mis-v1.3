<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Sky extends BaseController
{
    public function index()
    {

        return view('sky');
    }

    public function user()
    {
        $token = csrf_hash();
        // if ($this->request->getMethod() == 'post') {




            $uniqueId = md5(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890' . time()));
            $userData = [
                "id" => $this->request->getVar('id'),
                // "last_name" => $this->getVariable('lastName'),
                // "city" => $this->getVariable('region'),
                // "role" => $this->getVariable('role'),
                // "position" => $this->getVariable('role') == '7'  ? 'superAdmin' : 'normalUser',
                // "email" => $this->getVariable('email'),
                "unique_id" => $uniqueId,



            ];

            return $this->response->setJSON([
                'data' => $userData,
                'token' => $token,

            ]);
           
    }
}
// }
