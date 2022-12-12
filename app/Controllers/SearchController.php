<?php namespace App\Controllers;
use App\Models\LorriesModel;
use App\Models\VtcModel;
use App\Models\WaterMeterModel;
use App\Models\ProfileModel;
use App\Libraries\CommonTasksLibrary;
use App\Models\SearchModel;

class SearchController extends BaseController
{
  private $lorriesModel;
  private $searchModel;
  private $waterMeterModel;
  public $commonTasks;

  public $token;
  public function __construct()
  {
    
          helper(['form', 'array', 'regions', 'date']);
          $this->commonTasks     = new CommonTasksLibrary;
          $this->session         = session();
          $this->token         = csrf_hash();
          $this->profileModel    = new ProfileModel();
          $this->lorriesModel    = new LorriesModel();
          $this->searchModel        = new SearchModel();
          $this->waterMeterModel = new WaterMeterModel();
          $this->uniqueId        = $this->session->get('loggedUser');
          $this->role = $this->profileModel->getRole($this->uniqueId)->role;
          $this->city            = $this->session->get('city');
  }

  public function getVariable($var)
  {
    return $this->request->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
  }
public function index()

{
 
  $data['page']=[
    'title' => 'Searching Page',
    'heading' => 'Searching Page',
  ];


  //  $data['vtc'] = $this->vtcModel->searchingVtc();


  $data['role']= $this->role;
  $data['region']= $this->city;
  $data['profile'] = $this->profileModel->getLoggedUserData($this->uniqueId);
  return view('pages/search/searchPage',$data);
}


//=================searching vtc====================
public function searchItem(){
  $keyword =  $this->getVariable('keyword');
  $activity =  $this->getVariable('activity');

  

  $data = $this->searchModel->searchItem($keyword,$activity);

  return $this->response->setJSON([
  'status'=>1,
  'data'=> $data,
  'activity'=> $activity,
  'token'=>$this->token
  ]);
  
}
public function selectItem(){
  $id =  $this->getVariable('id');
  $activity =  $this->getVariable('activity');

  

  $request = $this->searchModel->selectItem($id,$activity);

  $data= [
      'status' => 1,
      'data' => $request,
      'activity' => $activity,
      'token' => $this->token
  ];

  return $this->response->setJSON($data);
  
}
public function renderSelectedVtc(){
  if($this->request->getMethod() =='post'){
    $vehicleId = $this->getVariable('id');
    $request = $this->vtcModel->vehicleMatch($vehicleId);
    $data = [
      'vtcData' =>  $request,
      'activity' => 'vtc',
      'verificationDate' => dateFormatter($request->registration_date),
      'nextVerification' => dateFormatter($request->next_calibration),
    ];

    return $this->response->setJSON([
    'status'=>1,
    'data'=>$data,
    'token'=>$this->token
    ]);
  
  }
}



//=================searching sbl====================
public function searchingSbl(){
  $sblDetails =  $this->lorriesModel->searchingSbl();

    return $this->response->setJSON([
      'status' => 1,
      'data' => $sblDetails,
      'token' => $this->token
    ]);
}
public function renderSelectedSbl(){
  if($this->request->getMethod() =='post'){
    $vehicleId = $this->getVariable('id');
    $request = $this->lorriesModel->vehicleMatch($vehicleId);
    $data = [
      'activity' => 'sbl',
      'sblData' => $request,
      'verificationDate' => dateFormatter($request->registration_date),
      'nextVerification' => dateFormatter($request->next_calibration),
    ];
      return $this->response->setJSON([
        'status' => 1,
        'data' => $data,
        'token' => $this->token
      ]);
  }
}

//=================searching water meters====================
public function searchingWaterMeter(){
  $waterMeterDetails =  $this->waterMeterModel->searchingWaterMeter();

 
    return $this->response->setJSON([
      'status' => 1,
      'data' => $waterMeterDetails,
      'token' => $this->token
    ]);
}
public function renderSelectedWaterMeters(){
  if($this->request->getMethod() =='post'){
    $meterId = $this->getVariable('id');
    $request = $this->waterMeterModel->waterMeterMatch($meterId);
    $data = [
      'activity' => 'waterMeter',
      'waterMeterData' => $request,
      // 'verificationDate' => dateFormatter($request->registration_date),
      // 'nextVerification' => dateFormatter($request->next_calibration),
    ];
      return $this->response->setJSON([
        'status' => 1,
        'data' => $data,
        'token' => $this->token
      ]);
  }
}
}