<?php

namespace App\Controllers;


use App\Models\VtcModel;
use App\Models\MiscellaneousModel;


class Miscellaneous extends BaseController
{
  private $controlNumber;
  public $token;
  public $miscellaneousModel;
  public function __construct()
  {
    $this->miscellaneousModel = new MiscellaneousModel();
    $this->token = csrf_hash();
  }

  public function getVariable($var)
  {
     return $this->request->getVar($var,FILTER_SANITIZE_SPECIAL_CHARS);  
  }

  public function checkSession()
  {


    $session = session();
    if (!$session->get('loggedUser')) {
      return $this->response->setJSON([
        'status' => 0,
        'msg' => 'Session has expired',
        'token' => $this->token
      ]);
    }else{
      return $this->response->setJSON([
        'status' => 1,
        'msg' => 'Session Active',
        'token' => $this->token
      ]);
    }
  }

  // grab latest control number
  public function getControlNumber()
  {

    $lastNumber = (int)$this->miscellaneousModel->getLastControlNumber()->control_number;
    $newNumber = $lastNumber + 1;
    return $this->response->setJSON([
      'data' => $newNumber,
      'token' => $this->token
    ]);
  }

  // render access denial page
  public function accessDenied()
  {
    // echo 'denied';
    // return redirect()->back();
    return view('denied');
  }

  // go back to previous page after access denial



  //=================get regions====================

  public function fetchRegions ()
  {
    $param = $this->getVariable('param');
    $list = $this->miscellaneousModel->fetchRegions();
    return $this->response->setJSON([
      'status' => 1,
      'token' => $this->token,
      'dataList' => $list,
    ]);
       
  }
  public function fetchDistricts ()
  {
    $param = $this->getVariable('param');
    $list = $this->miscellaneousModel->fetchDistricts($param);
    if($list){
      return $this->response->setJSON([
        'status' => 1,
        'token' => $this->token,
        'dataList' => $list,
      ]);
    }else{
      return $this->response->setJSON([
        'status' => 1,
        'token' => $this->token,
        'dataList' => [],
      ]);
    }
    
       
  }

  public function fetchWards()
  {
    $param = $this->getVariable('param');
    $list = $this->miscellaneousModel->fetchWards($param);
    if ($list) {
      return $this->response->setJSON([
        'status' => 1,
        'token' => $this->token,
        'dataList' => $list,
      ]);
    } else {
      return $this->response->setJSON([
        'status' => 1,
        'token' => $this->token,
        'dataList' => [],
      ]);
    }
       
  }
  public function fetchPostCodes()
  {
    $param = $this->getVariable('param');
    $code = $this->miscellaneousModel->fetchPostCodes($param);
    if ($code) {
      return $this->response->setJSON([
        'status' => 1,
        'token' => $this->token,
        'dataList' => $code,
      ]);
    } else {
      return $this->response->setJSON([
        'status' => 1,
        'token' => $this->token,
        'dataList' => [],
      ]);
    }
       
  }



}
