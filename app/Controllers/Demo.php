<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\WaterMeterModel;


class Demo extends BaseController
{


    public function index1()
    {
        helper('form');

        $meterModel = new WaterMeterModel();
        $data = [];

        $id = 2;
        if ($this->request->getMethod() == 'post') {
            // $dd = $this->request->getVar('payment', FILTER_SANITIZE_STRING);
            // echo $dd;
            $userData = [
                'payment' => $this->request->getVar('payment', FILTER_SANITIZE_STRING),
                // 'city' => 'Arusha'
            ];
            $req = $meterModel->updatePayment($userData, $id);
            if ($req) {
                echo "Updated";
            } else {
                echo "Fail to Update";
            }
            exit;
        }




        return view('myview', $data);
    }

    public function arr()
    {
        $rules = [
            "firstname" => "required|min_length[3]|max_length[15]",
            "lastname"  => "required|min_length[3]|max_length[15]",
            "gender"    => "required",
            // "city"      => "required",
            // "district"  => "required",
            // "ward"      => "required",
            // // "postal"            => "required",
            // "phone"         => "required",
            // "date"          => "required",
            // "scaletype"     => "required",
            // "scalecapacity" => "required|numeric",
            // "status"        => "required",
            // // "stickernumber"     => "required",
            // // "passcontrolnumber" => "required",
            // // "passramount"       => "required",


            // 'condemnationnote'        => 'max_size[condemnationnote,3072]|ext_in[condemnationnote,pdf,jpg,png,jpeg]'

        ];

        $newRules = [
            "city"      => "required",
            "district"  => "required",
        ];

        array_push($rules, ['city']);

        print_r($rules);
    }


    public function index()
    {


        helper('form');

        function percentage($value)
        {

            echo $value * (50 / 100);
        }

        percentage(2000);

        if ($this->request->getMethod() == 'post') {
            $userName = '';
            $favoriteColor = '';
            $name1 = $this->request->getVar('name');
            $name2 = $this->request->getVar('name2');
            $color1 = $this->request->getVar('color');
            $color2 = $this->request->getVar('color2');

            if ($name1 != null && $name2 != null) {
                $userName .= implode(',', [$name1, $name2]);
            }
            if ($color1 != null && $color2 != null) {
                $favoriteColor .= implode(',', [$color1, $color2]);
            }

            if ($name1 == null) {
                $userName .= $name2;
            } else if ($name2 == null) {
                $userName .= $name1;
            }
            if ($color1 == null) {
                $favoriteColor .= $color2;
            } else if ($color2 == null) {
                $favoriteColor .= $color1;
            }

            $data = [
                'user' => $userName,
                'fav_color' => $favoriteColor,

            ];

            print_r($data);
        }

        return view('start');
    }
}