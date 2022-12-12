<?php

namespace App\Controllers;

use App\Models\MiscellaneousModel;

class Home extends BaseController
{
    public function index()
    {
        $model = new MiscellaneousModel();
        $int = mt_rand(1262055681, 1262055681);

        $data['date'] = date("Y-m-d H:i:s", $int);
        $data['data'] = $model->getVisitors();
        return view('visitors', $data);
    }
    public function getData()
    {
        $model = new MiscellaneousModel();
        $data = $model->getVisitors();
        return $this->response->setJSON([
            'data' => $data,

        ]);
    }
}
