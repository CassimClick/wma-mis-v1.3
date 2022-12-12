<?php

namespace App\Controllers\ServiceApplication;

use App\Models\ProfileModel;
use App\Controllers\BaseController;
use App\Libraries\CommonTasksLibrary;
use App\Models\MiscellaneousModel;
use App\Models\ServiceApplication\LicenseModel;

class LicenseController extends BaseController
{


    public $role;
    public $city;
    public $user;

    public $session;

    public $CommonTasks;
    public $token;
    public $userId;
    public $licenseModel;
    public $miscellaneousModel;

    public function __construct()
    {
        $this->profileModel = new ProfileModel();
        $this->licenseModel = new LicenseModel();
        $this->miscellaneousModel = new MiscellaneousModel();
        $this->session = session();
        $this->token = csrf_hash();
        $this->userId = $this->session->get('service-applicant');
        $this->user = $this->licenseModel->getUser($this->userId);
        // $this->managerId = $this->session->get('manager');
        $this->CommonTasks = new CommonTasksLibrary();
        helper('string');
    }


    public function getVariable($var)
    {
        return $this->request->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function calcProgress(int $current, int $maxValue)
    {
        return round(((($current - 0) * (100 - 0)) / ($maxValue - 0) + 0));
    }
    public function index()
    {
        $data['page'] = (object)[
            "title" => "Dashboard",
            "heading" => "Dashboard",
        ];




        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;

        $params = [
            'user_id' => $this->userId,
            'submission' => 0
        ];

        $particulars = $this->licenseModel->getApplicantParticulars($params) != [] ? 1 : 0;
        $qualifications = $this->licenseModel->getApplicantQualifications($params) != [] ? 1 : 0;
        $licenseType = $this->licenseModel->getLicenseType($params) != [] ? 1 : 0;
        $tools = $this->licenseModel->getTools($params) != [] ? 1 : 0;
        $attachments = $this->licenseModel->getAttachments($params);

        $filled = $particulars + $qualifications + $licenseType + $tools + count($attachments);
        $data['progress'] = $this->calcProgress($filled > 10 ? 10 : $filled, 10);

        $data['application'] = (object)[
            'particulars' => $particulars,
            'qualifications' => $qualifications,
            'licenseType' => $licenseType,
            'attachments' => $attachments != [] ? 1 : 0,
            'tools' => $tools,
            'progress' => $particulars,

        ];



        return view('ServiceApplication/Pages/LicenseDashboard', $data);
    }
    public function licenseType()
    {
        $data['page'] = (object)[
            "title" => "Type Of License",
            "heading" => "Type Of License",
        ];


        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;

        $params = [
            'user_id' => $this->userId,
            'submission' => 0
        ];

        $data['particulars'] = $this->licenseModel->getApplicantParticulars($params) != [] ? 1 : 0;
        $data['qualifications'] = $this->licenseModel->getApplicantQualifications($params) != [] ? 1 : 0;
        // $data['tools'] = $this->licenseModel->getApplicantTools($this->userId) != [] ? 1 : 0;
        // $data['attachments'] = $this->licenseModel->getApplicantAttachments($this->userId) != [] ? 1 : 0;
        $data['licenses'] = $this->licenseModel->getLicenseType($params);




        return view('ServiceApplication/Pages/LicenseType', $data);
    }


    public function tools()
    {
        $data['page'] = (object)[
            "title" => "Tools/Equipments Or Facility",
            "heading" => "Tools/Equipments Or Facility",
        ];


        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;

        $params = [
            'user_id' => $this->userId,
            'submission' => 0
        ];

        $data['particulars'] = $this->licenseModel->getApplicantParticulars($params) != [] ? 1 : 0;
        $data['qualifications'] = $this->licenseModel->getApplicantQualifications($params) != [] ? 1 : 0;
        $data['tools'] = $this->licenseModel->getTools($params);
        // $data['licenses'] = $this->licenseModel->getLicenseType($params);




        return view('ServiceApplication/Pages/Tools', $data);
    }








    public function applicantQualifications()
    {
        $data['page'] = (object)[
            "title" => "Applicant Qualifications",
            "heading" => "Applicant Qualifications",
        ];




        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;

        $params = [
            'user_id' => $this->userId,
            'submission' => 0
        ];

        $data['userId'] = $this->userId;
        $data['license'] = 0;
        // $data['tools'] = $this->licenseModel->getApplicantTools($this->userId) != [] ? 1 : 0;
        $data['qualifications'] = $this->licenseModel->getQualifications($params);




        return view('ServiceApplication/Pages/ApplicantQualifications', $data);
    }
    public function attachments()
    {
        $data['page'] = (object)[
            "title" => "Upload Attachments",
            "heading" => "Upload Attachments",
        ];




        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;

        $params = [
            'user_id' => $this->userId,
            'submission' => 0
        ];

        $data['userId'] = $this->userId;
        $data['license'] = 0;
        // $data['tools'] = $this->licenseModel->getApplicantTools($this->userId) != [] ? 1 : 0;
        $data['attachments'] = $this->licenseModel->getAttachments($params);




        return view('ServiceApplication/Pages/Attachments', $data);
    }
    public function getApplicationId()
    {
        $applicationId = '';
        $id = $this->licenseModel->getApplicationId($this->userId);
        if (empty($id)) {
            $query =  $this->licenseModel->createApplicationId([
                'application_id' => randomString(),
                'user_id' => $this->userId,
            ]);
            if ($query) $applicationId .= $this->licenseModel->getApplicationId($this->userId)->application_id;
        } else {
            $applicationId .= $id->application_id;
        }

        return $applicationId;
    }

    public function addQualification()
    {
        if ($this->request->getMethod() == 'post') {
            $params = [
                'user_id' => $this->userId,
                'submission' => 0
            ];
            $rules = [
                'qualification' => [
                    'label' => 'qualification',
                    "rules" => "required",
                    'errors' => [
                        'required' => 'Please Enter Qualification',
                    ]
                ],
                'duration' => [
                    'label' => 'duration',
                    "rules" => "required",
                    'errors' => [
                        'required' => 'Please Enter Duration',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => $this->token,
                    'errors' => $this->validator->getErrors()
                ]);
            } else {
                $data = [
                    'qualification' => $this->getVariable('qualification'),
                    'duration' => $this->getVariable('duration'),
                    'application_id' => $this->getApplicationId(),
                    'user_id' => $this->userId,

                ];

                $query = $this->licenseModel->addQualification($data);
                if ($query) {

                    $tr = '';
                    $qualifications = $this->licenseModel->getQualifications($params);

                    foreach ($qualifications as $qualification) {
                        $tr .= <<<"HTML"
                          <tr>
                              <td>$qualification->qualification </td>
                              <td>$qualification->duration Years</td>
                              <td><a href="deleteQualification/$qualification->id" class="btn btn-tbl-edit  btn-primary btn-xs"><i class="fas fa-trash"></i></a></td>
                          </tr>
                         HTML;
                    }





                    return $this->response->setJSON([
                        'status' => 1,
                        'msg' => 'Qualification Added',
                        'qualifications' => $tr,
                        'token' => $this->token,
                        'errors' => []
                    ]);
                }
            }
        }
    }








 

    public function addLicense()
    {
        if ($this->request->getMethod() == 'post') {
            $params = [
                'user_id' => $this->userId,
                'submission' => 0
            ];
            $rules = [
                'licenseType' => [
                    'label' => 'licenseType',
                    "rules" => "required",
                    'errors' => [
                        'required' => 'Please Select License Type',
                    ]
                ],

            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => $this->token,
                    'errors' => $this->validator->getErrors()
                ]);
            } else {
                $data = [
                    'type' => humanize($this->getVariable('licenseType')),
                    'application_id' => $this->licenseModel->getApplicationId($this->userId)->application_id,
                    'user_id' => $this->userId,

                ];

                $query = $this->licenseModel->addLicense($data);
                if ($query) {

                    $tr = '';
                    $licenses = $this->licenseModel->getLicenseType($params);

                    foreach ($licenses as $license) {
                        $tr .= <<<"HTML"
                          <tr>
                              <td>$license->type </td>
                              <td><a href="deleteLicense/$license->id" class="btn btn-tbl-edit  btn-primary btn-xs"><i class="fas fa-trash"></i></a></td>
                          </tr>
                         HTML;
                    }





                    return $this->response->setJSON([
                        'status' => 1,
                        'msg' => 'License Added',
                        'licenses' => $tr,
                        'token' => $this->token,
                        'errors' => []
                    ]);
                }
            }
        }
    }
    public function deleteLicense($id)
    {
        $query = $this->licenseModel->deleteLicense([
            'user_id' => $this->userId,
            'id' => $id,
        ]);
        if ($query) {
            session()->setFlashdata('success', 'License Type Deleted');
            return redirect()->back();
        } else {

            session()->setFlashdata('error', 'Something Went Wrong');
            return redirect()->back();
        }
    }



    public function addTool()
    {
        if ($this->request->getMethod() == 'post') {
            $params = [
                'user_id' => $this->userId,
                'submission' => 0
            ];
            $rules = [
                'tool' => [
                    'label' => 'tool',
                    "rules" => "required",
                    'errors' => [
                        'required' => 'Please Enter Tool/Equipment',
                    ]
                ],

            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => $this->token,
                    'errors' => $this->validator->getErrors()
                ]);
            } else {
                $data = [
                    'tool' => $this->getVariable('tool'),
                    'application_id' => $this->licenseModel->getApplicationId($this->userId)->application_id,
                    'user_id' => $this->userId,

                ];

                $query = $this->licenseModel->addTool($data);
                if ($query) {

                    $tr = '';
                    $tools = $this->licenseModel->getTools($params);

                    foreach ($tools as $tool) {
                        $tr .= <<<"HTML"
                          <tr>
                              <td>$tool->tool </td>
                              <td><a href="deleteTool/$tool->id" class="btn btn-tbl-edit  btn-primary btn-xs"><i class="fas fa-trash"></i></a></td>
                          </tr>
                         HTML;
                    }





                    return $this->response->setJSON([
                        'status' => 1,
                        'msg' => 'Tool Added',
                        'tools' => $tr,
                        'token' => $this->token,
                        'errors' => []
                    ]);
                }
            }
        }
    }
    public function deleteTool($id)
    {
        $query = $this->licenseModel->deleteTool([
            'user_id' => $this->userId,
            'id' => $id,
        ]);
        if ($query) {
            session()->setFlashdata('success', 'Tool Deleted');
            return redirect()->back();
        } else {

            session()->setFlashdata('error', 'Something Went Wrong');
            return redirect()->back();
        }
    }




    public function addAttachment()
    {
        if ($this->request->getMethod() == 'post') {
            $params = [
                'user_id' => $this->userId,
                'submission' => 0
            ];
            $rules = [
                'document' => [
                    'label' => 'document',
                    // "rules" => "uploaded[document]|ext_in[document,pdf,mp4]",
                    "rules" => "uploaded[document]|ext_in[document,pdf]",
                    'errors' => [
                        'uploaded' => 'Please Select A file',
                        'ext_in' => 'Only Pdf Files Are Allowed',
                    ]
                ],

            ];
            // 'avatar' => 'uploaded[avatar]|max_size[avatar,1024]',

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => $this->token,
                    'errors' => $this->validator->getErrors()
                ]);
            } else {
                $file = $this->request->getFile('document');

                $path = $this->CommonTasks->processFile($file);
                $document = $this->getVariable('documentName');
                $data = [
                    'document' => $document,
                    'path' => $path,
                    'application_id' => $this->licenseModel->getApplicationId($this->userId)->application_id,
                    'user_id' => $this->userId,


                ];

                $query = $this->licenseModel->addAttachment($data);
                if ($query) {

                    $tr = '';
                    $attachments = $this->licenseModel->getAttachments($params);

                    foreach ($attachments as $attachment) {
                        $tr .= <<<"HTML"
                          <tr>
                              <td>$attachment->document </td>
                              <td>

                               <a href="$attachment->path" download class="btn btn-tbl-edit  btn-success btn-tbl-edit btn-xs" ><i class="fas fa-file-pdf"></i></a>
                                 
                                
                            </td>
                              <td>

                                 
                                  <button  class="btn btn-tbl-edit  btn-primary btn-tbl-edit btn-xs" onclick="editAttachment('$attachment->id')"><i class="fas fa-pen"></i></button>
                              
                            </td>
                              <td>

                              
                                 
                                   <a href="deleteAttachment/$attachment->id" class="btn btn-tbl-edit  btn-danger btn-tbl-edit btn-xs"><i class="fas fa-trash"></i></a>
                            </td>
                          </tr>
                         HTML;
                    }


                    return $this->response->setJSON([
                        'status' => 1,
                        'msg' =>  $document . ' Uploaded',
                        'attachments' => $tr,
                        'token' => $this->token,
                        'errors' => []
                    ]);
                }
            }
        }
    }
    public function deleteAttachment($id)
    {
        $query = $this->licenseModel->deleteAttachment([
            'user_id' => $this->userId,
            'id' => $id,
        ]);
        if ($query) {
            session()->setFlashdata('success', 'Attachment Deleted');
            return redirect()->back();
        } else {

            session()->setFlashdata('error', 'Something Went Wrong');
            return redirect()->back();
        }
    }


    public function editAttachment()
    {
        $query = $this->licenseModel->editAttachment([
            'user_id' => $this->userId,
            'id' => $this->getVariable('id'),
        ]);
        if ($query) {
            return $this->response->setJSON([
                'status' => 1,
                'documentName' => $query->document,
                'token' => $this->token,
            ]);
        } else {

            return $this->response->setJSON([
                'status' => 0,
                'attachment' => '',
                'token' => $this->token,
            ]);
        }
    }

    public function updateAttachment()
    {
        $id = $this->getVariable('id');
        $file = $this->request->getFile('document');
        $document = $this->getVariable('documentName');
        $data = [
            'document' => $document,
        ];
        if ($file != '') $data['path'] = $this->CommonTasks->processFile($file);

        // return $this->response->setJSON([$id,$data]);
        // exit;

        $query = $this->licenseModel->updateAttachment($id, $data);
        if ($query) {


            $params = [
                'user_id' => $this->userId,
                'submission' => 0
            ];
            $tr = '';
            $attachments = $this->licenseModel->getAttachments($params);


            foreach ($attachments as $attachment) {
                $tr .= <<<"HTML"
                          <tr>
                              <td>$attachment->document </td>
                              <td>

                               <a href="$attachment->path" download class="btn btn-tbl-edit  btn-success btn-tbl-edit btn-xs" ><i class="fas fa-file-pdf"></i></a>
                                 
                                
                            </td>
                              <td>

                                 
                                  <button  class="btn btn-tbl-edit  btn-primary btn-tbl-edit btn-xs" onclick="editAttachment('$attachment->id')"><i class="fas fa-pen"></i></button>
                              
                            </td>
                              <td>

                              
                                 
                                   <a href="deleteAttachment/$attachment->id" class="btn btn-tbl-edit  btn-danger btn-tbl-edit btn-xs"><i class="fas fa-trash"></i></a>
                            </td>
                          </tr>
                         HTML;
            }
        }

        return $this->response->setJSON([
            'status' => 1,
            'msg' =>  $document . ' Updated',
            'attachments' => $tr,
            'token' => $this->token,

        ]);
        // $query = $this->licenseModel->editAttachment($id,$data);  
    }





    public function deleteQualification($id)
    {
        $query = $this->licenseModel->deleteQualification([
            'user_id' => $this->userId,
            'id' => $id,
        ]);
        if ($query) {
            session()->setFlashdata('success', 'Qualification Deleted');
            return redirect()->back();
        } else {

            session()->setFlashdata('error', 'Something Went Wrong');
            return redirect()->back();
        }
    }

    public function submission()
    {

        $data['page'] = (object)[
            "title" => "Applicant Submission",
            "heading" => "Applicant Submission",
        ];




        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;

        $params = [
            'user_id' => $this->userId,
            'submission' => 0
        ];

        $data['userId'] = $this->userId;
        $data['license'] = 0;
        $applicationId = $this->licenseModel->getApplicationId($this->userId);
        $data['qualifications'] = $this->licenseModel->getApplicationId($this->userId);

        $data['isSubmitted'] = $applicationId ? 1 : 0 ;




        return view('ServiceApplication/Pages/Submission', $data);
    }


    public function submitApplication()
    {
        $applicationId = $this->licenseModel->getApplicationId($this->userId)->application_id;
        $query = $this->licenseModel->submitApplication($applicationId);
        if ($query) {
            $this->licenseModel->deleteApplicationId($this->userId);
            session()->setFlashdata('success', 'Application Submitted Successfully ');
            return redirect()->back();
        } else {

            session()->setFlashdata('error', 'Something Went Wrong');
            return redirect()->back();
        }
    }

    public function applicationPreview()
    {
        $data['page'] = (object)[
            "title" => "Application Preview",
            "heading" => "Application Preview",
        ];

        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;
        $data['applications'] = $this->licenseModel->getLicenseType([
            'user_id' => $this->userId,
            'submission' => 1,
        ]);

        return view('ServiceApplication/Pages/ApplicationPreview', $data);
    }

    public function applicationDetails($applicationId)
    {
        $data['page'] = (object)[
            "title" => "Application Details",
            "heading" => "Application Details",
        ];

        $params = [
            'user_id' => $this->userId,
            'application_id' => $applicationId,
            'submission' => 1,
        ];

        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;
        $data['licenseTypes'] = $this->licenseModel->getLicenseType($params);
        $data['tools'] = $this->licenseModel->getTools($params);
        $data['qualifications'] = $this->licenseModel->getQualifications($params);
        $data['attachments'] = $this->licenseModel->getAttachments($params);

        return view('ServiceApplication/Pages/ApplicationDetails', $data);
    }


    public function addApplicantParticulars()
    {
        $applicant = $this->licenseModel->getApplicantParticulars(['user_id' => $this->userId
        ]);
        if(empty($applicant)){

        

        $data['page'] = (object)[
            "title" => "Personal Particular",
            "heading" => "Personal Particular",
        ];

        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;


        $data['validation'] = null;
        if ($this->request->getMethod() == 'post') {

            // die('form submitted');
            $nationality = $this->getVariable('nationality');
            $rules = [
                'applicant_name' => 'required',
                'nationality' => 'required',
                'mobile_number' => 'required',
                'email' => 'required',
                'nationality' => 'required',
                'region' => 'required',
                'district' => 'required',
                'company_registration_number' => 'required',


            ];


            ($nationality == 'Foreigner') ? $rules['passport'] = 'required' : $rules['nida_number'] = 'required';



            if ($this->validate($rules)) {
                $data['validation'] = null;
                $formData = [
                    'applicant_name' => $this->getVariable('applicant_name'),
                    'nationality' => $nationality,
                    'mobile_number' => $this->getVariable('mobile_number'),
                    'email' => $this->getVariable('email'),
                    'region' => $this->getVariable('region'),
                    'district' => $this->getVariable('district'),
                    'ward' => $this->getVariable('ward'),
                    'postal_code' => $this->getVariable('postal_code'),
                    'postal_address' => $this->getVariable('postal_address'),
                    'physical_address' => $this->getVariable('physical_address'),


                   
                    'company_registration_number' => $this->getVariable('company_registration_number'),

                    'user_id' =>  $this->userId,


                ];
                ($nationality != 'Tanzanian') ? $formData['passport'] = $this->getVariable('passport') : $formData['nida_number'] = $this->getVariable('nida_number');

                // return $this->response->setJSON([$formData]);
                // exit;




                $query = $this->licenseModel->addApplicantParticulars($formData);

                if ($query) {

                    // $data['user'] =  $formData;

                    session()->setFlashdata('success', 'Request Submitted Successfully');
                    // return redirect()->to('service-request/applicant-particulars');
                    return redirect()->back();
                } else {
                    session()->setFlashdata('error', 'Something Went Wrong');
                }
                return redirect()->back();
            } else {
                $data['validation'] = $this->validator;
            }
        }



        // $data['profile'] = $this->profileModel->getLoggedUserData($this->userId);
        return view('ServiceApplication/Pages/ApplicantParticulars', $data);
        }else{
            return redirect()->to('service-request/applicant-particulars');
        }
    }
    public function editApplicantParticulars($userId)
    {

        $data['page'] = (object)[
            "title" => "Personal Particular",
            "heading" => "Personal Particular",
        ];
        $params = [
            'user_id' => $this->userId,
            'submission' => 0
        ];

        $data['validation'] = null;
        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;
        $applicant = $this->licenseModel->getApplicantParticulars($params);
        $data['applicant'] = $applicant;
        $data['regions'] = $this->miscellaneousModel->fetchRegions();
        $data['districts'] = $this->miscellaneousModel->fetchDistricts($applicant->region);
        $data['wards'] = $this->miscellaneousModel->fetchWards($applicant->district);

        // $data['profile'] = $this->profileModel->getLoggedUserData($this->userId);
        return view('ServiceApplication/Pages/editApplicantParticulars', $data);
    }
    public function updateApplicantParticulars($userId)
    {



        $data['page'] = (object)[
            "title" => "Personal Particular",
            "heading" => "Personal Particular",
        ];
        $params = [
            'user_id' => $this->userId,
            'submission' => 0
        ];


        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;
        $applicant = $this->licenseModel->getApplicantParticulars($params);
        $data['applicant'] = $applicant;
        $data['regions'] = $this->miscellaneousModel->fetchRegions();
        $data['districts'] = $this->miscellaneousModel->fetchDistricts($applicant->region);
        $data['wards'] = $this->miscellaneousModel->fetchWards($applicant->district);



        $data['validation'] = null;
        if ($this->request->getMethod() == 'post') {

            // die('form submitted');

            $rules = [

                'email' => 'required',
                'region' => 'required',
                'district' => 'required',
                'email' => 'required',
                'mobile_number' => 'required',
                'company_registration_number' => 'required',




            ];


            if ($this->validate($rules)) {
                $data['validation'] = null;
                $formData = [


                    'mobile_number' => $this->getVariable('mobile_number'),
                    'email' => $this->getVariable('email'),
                    'region' => $this->getVariable('region'),
                    'district' => $this->getVariable('district'),
                    'ward' => $this->getVariable('ward'),
                    'postal_code' => $this->getVariable('postal_code'),
                    'postal_address' => $this->getVariable('postal_address'),
                    'physical_address' => $this->getVariable('physical_address'),



                    'company_registration_number' => $this->getVariable('company_registration_number'),

                    'user_id' =>  $this->userId,


                ];


                // return $this->response->setJSON([$formData]);
                // exit;




                $query = $this->licenseModel->updateApplicantParticulars($userId, $formData);

                if ($query) {

                    // $data['user'] =  $formData;

                    session()->setFlashdata('success', 'Particulars Updated Successfully');
                    return redirect()->to('service-request/applicant-particulars');
                    // return redirect()->back();
                } else {
                    session()->setFlashdata('error', 'Something Went Wrong');
                }
                return redirect()->back();
            } else {
                $data['validation'] = $this->validator;
            }
        }



        // $data['profile'] = $this->profileModel->getLoggedUserData($this->userId);
        return view('ServiceApplication/Pages/editApplicantParticulars', $data);
    }

    public function applicantParticulars()
    {
        $data['page'] = (object)[
            "title" => "Submitted Service Request",
            "heading" => "Submitted Service Request",
        ];
        $params = [
            'user_id' => $this->userId,
            'submission' => 0
        ];


        $data['userId'] = $this->userId;
        $data['role'] = $this->role;
        $data['user'] = $this->user;
        $data['validation'] = null;
        $data['applicant'] = $this->licenseModel->getApplicantParticulars($params);
        $data['qualifications'] = $this->licenseModel->getApplicantQualifications($params) != [] ? 1 : 0;


        return view('ServiceApplication/Pages/ViewApplicantParticulars', $data);
    }
}
