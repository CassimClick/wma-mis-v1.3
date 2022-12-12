<?php

namespace App\Controllers;

use App\Models\PhoneModel;



class Shop extends BaseController
{
    public function index()
    {
        return view('alpine');
    }

    public function data()
    {
        $model = new PhoneModel();

        return $this->response->setJSON([
            $model->getData()

        ]);
    }
    public function addItem()
    {
        $model = new PhoneModel();

        if ($this->request->getMethod() == 'post') {
            $customer = $this->request->getVar('customer');
            $product =   $this->request->getVar('product');
            $img =   $this->request->getFile('img');
            $fileName = $img->getRandomName();

            $path = base_url() . '/uploads/img/' . $fileName;
            $img->move(FCPATH . 'uploads/img/', $fileName);


            $data = [
                'customer' => $customer,
                'product' => $product,
                'path' => $path,
                'img' => $img,
               
            ];
           // print_r($img);



           return $this->response->setJSON([$data]);
            exit;

            $req = $model->saveData($data);

            if ($req) {
                return $this->response->setJSON([
                    'msg' => 'Data Saved '

                ]);
            } else {
                return $this->response->setJSON([
                    'msg' =>  'Something Went Wrong'

                ]);
            }
        }
    }



    //--------------------------------------------------------------------

}
