<?php

namespace App\Controllers;

use App\Models\ScaleModel;
use App\Libraries\CommonTasksLibrary;
use App\Models\ProfileModel;
use \CodeIgniter\Validation\Rules;
//use CodeIgniter\View\Table;

class Scales extends BaseController
{
    public $scaleModel;
    public $session;
    public $uniqueId;
    public $managerId;
    public $profileModel;
    public $CommonTasks;
    public $role;
    public $city;
    public $security;
    public function __construct()
    {
        $this->scaleModel = new ScaleModel();
        $this->profileModel = new ProfileModel();
        $this->session = session();
        $this->security = \Config\Services::security();

        $this->uniqueId = $this->session->get('loggedUser');
        $this->managerId = $this->session->get('manager');
        $this->city = $this->session->get('city');
        $this->role = $this->session->get('role');
        helper(['form', 'array', 'regions']);

        $this->CommonTasks = new CommonTasksLibrary();
    }
    // A method for scales
    public function newScale()
    {

        if (!$this->session->has('loggedUser')) {
            return redirect()->to('/login');
        }
        $data = [];
        $data['validation'] = null;
        $rules = [];
        $rules = [
            "firstname" => "required|min_length[3]|max_length[15]",
            "lastname"  => "required|min_length[3]|max_length[15]",
            "gender"    => "required",
            "city"      => "required",
            "district"  => "required",
            "ward"      => "required",
            // "postal"            => "required",
            "phone"         => "required",
            "date"          => "required",
            // "scaletype"     => "required",
            // "scalecapacity" => "required|numeric",
            // "status"        => "required",
            // "stickernumber"     => "required",
            // "passcontrolnumber" => "required",
            // "passramount"       => "required",


            'condemnationnote'        => 'max_size[condemnationnote,3072]|ext_in[condemnationnote,pdf,jpg,png,jpeg]'

        ];
        $data['page'] = [
            "title"   => "Scale",
            "heading" => "New Scale"
        ];
        $data['genderValues'] = ['Male', 'Female'];
        $data['statusResult'] = ['Pass', 'Rejected', 'Condemned'];

        $data['scalesTypes'] = [
            'Trade/Economy',
            'Precious Stones'
        ];
        $data['scales'] = $this->CommonTasks->scalesList();
        $data['weights'] = $this->CommonTasks->weights();
        $data['loweClassWeights'] = $this->CommonTasks->lowerClassWeights();
        $data['higherClassWeights'] = $this->CommonTasks->higherClassWeights();
        $data['metricScale'] = $this->CommonTasks->metric();
        $data['denominations'] = $this->CommonTasks->denominations();
        $data['capacityForCustomer'] = $this->CommonTasks->capacityMeasureForCustomer();
        $data['capacityForVerification'] = $this->CommonTasks->capacityMeasureForVerification();


        if ($this->request->getMethod() == 'post') {
            if ($this->validate($rules)) {

                $results = $this->request->getVar('status', FILTER_SANITIZE_STRING);
                $amount = 0;
                $controlNumber = '';
                $filePath = '';
                $payment = '';
                switch ($results) {
                    case 'Pass':
                        $amount += $this->request->getVar('passamount', FILTER_SANITIZE_NUMBER_INT);
                        $controlNumber .= $this->request->getVar('passcontrolnumber', FILTER_SANITIZE_STRING);
                        $payment .= $this->request->getVar('pass-payment', FILTER_SANITIZE_STRING);
                        $filePath .= $this->CommonTasks
                            ->processFile($this->request->getFile('certificateofcorrectness'));

                        break;
                    case 'Rejected':
                        $amount += $this->request->getVar('rejectedamount', FILTER_SANITIZE_NUMBER_INT);
                        $controlNumber .= $this->request->getVar('rejectedcontrolnumber', FILTER_SANITIZE_STRING);
                        $payment .= $this->request->getVar('rejection-payment', FILTER_SANITIZE_STRING);
                        $filePath .= $this->CommonTasks
                            ->processFile($this->request->getFile('rejectionnote'));

                        break;
                    case 'Condemned':
                        $filePath .= $this->CommonTasks
                            ->processFile($this->request->getFile('condemnationnote'));
                        break;

                    default:
                        # code...
                        break;
                }

                $scaleType = '';




                $tradeScaleType = $this->request->getVar('tradeScaleType', FILTER_SANITIZE_STRING);
                $tradeScaleCapacity = $this->request->getVar('tradeScaleCapacity', FILTER_SANITIZE_STRING);
                $tradeScalesAmount = $this->request->getVar('tradeScalesAmount', FILTER_SANITIZE_STRING);

                $preciousStoneScaleType = $this->request->getVar('preciousStoneScaleType', FILTER_SANITIZE_STRING);
                $preciousStoneScaleQuantity = $this->request->getVar('preciousStoneScaleQuantity', FILTER_SANITIZE_STRING);
                $preciousScaleCapacity = $this->request->getVar('preciousScaleCapacity', FILTER_SANITIZE_STRING);
                $preciousScaleAmount = $this->request->getVar('preciousScaleAmount', FILTER_SANITIZE_STRING);

                $labScaletype = $this->request->getVar('labScaletype', FILTER_SANITIZE_STRING);
                $labScalecapacity = $this->request->getVar('labScalecapacity', FILTER_SANITIZE_STRING);
                $labScaleAmount = $this->request->getVar('labScaleAmount', FILTER_SANITIZE_STRING);
                $lowerClassWeights = $this->request->getVar('lowerClassWeights', FILTER_SANITIZE_STRING);
                $lowerClassAmount = $this->request->getVar('lowerClassAmount', FILTER_SANITIZE_STRING);
                $higherClassWeights = $this->request->getVar('higherClassWeights', FILTER_SANITIZE_STRING);
                $higherClassAmount = $this->request->getVar('higherClassAmount', FILTER_SANITIZE_STRING);
                $metricWeights = $this->request->getVar('metricWeights', FILTER_SANITIZE_STRING);
                $metricAmount = $this->request->getVar('metricAmount', FILTER_SANITIZE_STRING);
                $customerCapacity = $this->request->getVar('customerCapacity', FILTER_SANITIZE_STRING);
                $customerCapacityAmount = $this->request->getVar('customerCapacityAmount', FILTER_SANITIZE_STRING);
                $verificationCapacity = $this->request->getVar('verificationCapacity', FILTER_SANITIZE_STRING);
                $verificationCapacityAmount = $this->request->getVar('verificationCapacityAmount', FILTER_SANITIZE_STRING);



                if ($tradeScaleType == null && $preciousStoneScaleType == null) {

                    $scaleType .= $labScaletype;
                } elseif ($tradeScaleType == null && $labScaletype == null) {
                    $scaleType .= $preciousStoneScaleType;
                } else {
                    $scaleType .= $tradeScaleType;
                }


                echo $scaleType;
                exit;










                $scaleData = [
                    "hash" => md5(str_shuffle('abcdefghijklmnopqqrtuvwzyz0123456789')),
                    "first_name" => $this->request->getVar('firstname', FILTER_SANITIZE_STRING),
                    "last_name" => $this->request->getVar('lastname', FILTER_SANITIZE_STRING),
                    "gender" => $this->request->getVar('gender', FILTER_SANITIZE_STRING),
                    "city" => $this->request->getVar('city', FILTER_SANITIZE_STRING),
                    "district" => $this->request->getVar('district', FILTER_SANITIZE_STRING),
                    "ward" => $this->request->getVar('ward', FILTER_SANITIZE_STRING),
                    "village" => $this->request->getVar('village', FILTER_SANITIZE_STRING),
                    "postal_address" => $this->request->getVar('postal', FILTER_SANITIZE_STRING),
                    "phone_number" => $this->request->getVar('phone', FILTER_SANITIZE_STRING),
                    "date" => $this->request->getVar('date'),

                    "scale_type" => $this->request->getVar('scaletype', FILTER_SANITIZE_STRING),
                    "scale_capacity" => $this->request->getVar('scalecapacity', FILTER_SANITIZE_STRING),
                    "weights" => $this->request->getVar('weights', FILTER_SANITIZE_STRING),
                    "koroboi" => $this->request->getVar('koroboi', FILTER_SANITIZE_STRING),
                    "status" => $this->request->getVar('status', FILTER_SANITIZE_STRING),
                    "sticker_number" => $this->request->getVar('stickernumber', FILTER_SANITIZE_NUMBER_INT),
                    "control_number" => $controlNumber,
                    "amount" => $amount,
                    "payment" => $payment,
                    "unique_id" => $this->uniqueId,

                    "file_path" => $filePath,
                ];
                $status =  $this->scaleModel->saveScaleData($scaleData);

                if ($status) {


                    $this->session->setFlashdata('success', 'Data Inserted Successfully <i class="fal fa-smile-wink"></i>');
                    return redirect()->to(current_url());
                    // echo "<script>alert('Data Inserted');</script>";
                } else {
                    $this->session->setFlashdata('error', 'Fail To Insert Data Try Again');
                }
            }
        } else {
            $data['validation'] = $this->validator;
        }




        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['role'] = $role;
        return view('Pages/Scales/newScale', $data);
    }

    public function listRegisteredScales()
    {


        $data['page'] = [
            "title"   => "Scales List",
            "heading" => "Registered Scales"
        ];



        $uniqueId = $this->uniqueId;
        $managerId  = $this->managerId;
        $data['role'] = $this->role;
        if ($this->role == 1) {
            $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
            $data['scaleResults'] =  $this->scaleModel->getRegisteredScales($uniqueId);
            return view('Pages/Scales/scalesList', $data);
        } else if ($this->role == 2) {
            $data['profile'] = $this->profileModel->getLoggedUserData($managerId);
            $data['scaleResults'] =  $this->scaleModel->getAllScales($this->city);
            return view('Pages/Scales/scalesList', $data);
        }
    }


    // deleting a Record
    public function deleteScale($id)
    {

        $this->scaleModel->deleteRecord($id);
        $this->session->setFlashdata('Success', 'Record Deleted Successfully');
        return redirect()->to('/listScales');
    }

    // Retrieve A record from the database
    public function editScale($id)
    {
        $data = [];
        $data['record'] =  $this->scaleModel->editRecord($id);
        $data['validation'] = null;

        $data['page'] = [
            "title"   => "Edit Scale Record",
            "heading" => "Edit Scale Record "
        ];
        $data['genderValues'] = ['Male', 'Female'];
        $data['statusResult'] = ['Pass', 'Rejected'];


        $data['scales'] = $this->CommonTasks
            ->scalesList();
        $data['weights'] = $this->CommonTasks
            ->weights();
        $data['denominations'] = $this->CommonTasks
            ->denominations();



        $uniqueId = $this->uniqueId;
        $managerId  = $this->managerId;
        $data['role'] = $this->role;
        if ($this->role == 1) {
            $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
            return view('Pages/Scales/editScale', $data);
        } else if ($this->role == 2) {
            $data['profile'] = $this->profileModel->getLoggedUserData($managerId);
            return view('Pages/Scales/editScale', $data);
        }
    }

    //    Update a record in the database
    public function updateScale($id)
    {

        $data = [];
        $data['validation'] = null;
        $rules = [
            "firstname"         => "required|min_length[3]|max_length[15]",
            "lastname"          => "required|min_length[3]|max_length[15]",
            "gender"            => "required",
            "city"              => "required",
            "ward"              => "required",
            // "postal"            => "required",
            "phone"             => "required",
            "date"              => "required",
            "scaletype"         => "required",
            "scalecapacity"     => "required|numeric",
            "status"            => "required",
            // "stickernumber"     => "required",
            // "passcontrolnumber" => "required",
            // "passramount"       => "required",


            'condemnationnote'        => 'max_size[condemnationnote,3072]|ext_in[condemnationnote,pdf,jpg,png,jpeg]'

        ];
        $data['page'] = [
            "title"   => "Scale",
            "heading" => "Update Scale"
        ];
        $data['genderValues'] = ['Male', 'Female'];
        $data['statusResult'] = ['Pass', 'Rejected'];
        $data['scales'] = $this->CommonTasks
            ->scalesList();
        $data['weights'] = $this->CommonTasks
            ->weights();
        $data['denominations'] = $this->CommonTasks
            ->denominations();




        if ($this->request->getMethod() == 'post') {
            if ($this->validate($rules)) {
                $results = $this->request->getVar('status', FILTER_SANITIZE_STRING);
                $amount = 0;
                $controlNumber = '';
                $filePath = '';
                $payment = '';
                switch ($results) {
                    case 'Pass':
                        $amount += $this->request->getVar('passamount', FILTER_SANITIZE_NUMBER_INT);
                        $controlNumber .= $this->request->getVar('passcontrolnumber', FILTER_SANITIZE_STRING);
                        $payment .= $this->request->getVar('pass-payment', FILTER_SANITIZE_STRING);
                        $filePath .= $this->CommonTasks
                            ->processFile($this->request->getFile('certificateofcorrectness'));

                        break;
                    case 'Rejected':
                        $amount += $this->request->getVar('rejectedamount', FILTER_SANITIZE_NUMBER_INT);
                        $controlNumber .= $this->request->getVar('rejectedcontrolnumber', FILTER_SANITIZE_STRING);
                        $payment .= $this->request->getVar('rejection-payment', FILTER_SANITIZE_STRING);
                        $filePath .= $this->CommonTasks
                            ->processFile($this->request->getFile('rejectionnote'));

                        break;
                    case 'Condemned':
                        $filePath .= $this->CommonTasks
                            ->processFile($this->request->getFile('condemnationnote'));
                        break;

                    default:
                        # code...
                        break;
                }
                $scaleData = [
                    "first_name" => $this->request->getVar('firstname', FILTER_SANITIZE_STRING),
                    "last_name" => $this->request->getVar('lastname', FILTER_SANITIZE_STRING),
                    "gender" => $this->request->getVar('gender', FILTER_SANITIZE_STRING),
                    "city" => $this->request->getVar('city', FILTER_SANITIZE_STRING),
                    "district" => $this->request->getVar('district', FILTER_SANITIZE_STRING),
                    "ward" => $this->request->getVar('ward', FILTER_SANITIZE_STRING),
                    "village" => $this->request->getVar('village', FILTER_SANITIZE_STRING),
                    "postal_address" => $this->request->getVar('postal', FILTER_SANITIZE_STRING),
                    "phone_number" => $this->request->getVar('phone', FILTER_SANITIZE_STRING),
                    "date" => $this->request->getVar('date'),
                    "scale_type" => $this->request->getVar('scaletype', FILTER_SANITIZE_STRING),
                    "scale_capacity" => $this->request->getVar('scalecapacity', FILTER_SANITIZE_STRING),
                    "weights" => $this->request->getVar('weights', FILTER_SANITIZE_STRING),
                    "koroboi" => $this->request->getVar('koroboi', FILTER_SANITIZE_STRING),
                    "status" => $this->request->getVar('status', FILTER_SANITIZE_STRING),
                    "sticker_number" => $this->request->getVar('stickernumber', FILTER_SANITIZE_NUMBER_INT),
                    "control_number" => $controlNumber,
                    "amount" => $amount,
                    "payment" => $payment,


                    "file_path" => $filePath,
                ];
                $status =   $this->scaleModel->updateScaleData($scaleData, $id);

                if ($status) {
                    $this->session->setFlashdata('Success', 'Data Updated Successfully <i class="fal fa-smile-wink"></i>');
                    // return redirect()->to('/listScales');
                    // echo "<script>alert('Data Inserted');</script>";
                } else {
                    $this->session->setFlashdata('error', 'Fail To Update Data Try Again');
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }



        $uniqueId = $this->uniqueId;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);


        return redirect()->to('/listScales');
    }
}

//       $status =  $this->scaleModel->updateScaleData($scaleData, $id);