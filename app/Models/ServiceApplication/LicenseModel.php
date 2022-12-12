<?php

namespace App\Models\ServiceApplication;

use CodeIgniter\Model;

class LicenseModel extends Model
{
    protected $licenseTable;
    protected $users;
    protected $applicantParticulars;
    protected $applicantQualifications;
    protected $db;
    protected $tempId;
    protected $licenseType;
    protected $tools;
    protected $attachments;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->licenseTable = $this->db->table('license');
        $this->users = $this->db->table('service_users');
        $this->applicantParticulars = $this->db->table('applicant_particulars');
        $this->applicantQualifications = $this->db->table('applicant_qualifications');
        $this->tempId = $this->db->table('temporary_id');
        $this->licenseType = $this->db->table('license_type');
        $this->tools = $this->db->table('tools');
        $this->attachments = $this->db->table('attachments');
    }


    public function getApplicantParticulars($params)
    {
        return $this->applicantParticulars->select()->where($params)->get()->getRow();
    }
    public function getLicenseApplicationsInRegion($params)
    {
        return $this->applicantParticulars->select()->where($params)
        ->join('license_type', 'license_type.user_id = applicant_particulars.user_id')
        ->get()
        ->getResult();
    }
    public function getApplicantQualifications($params)
    {
        return $this->applicantQualifications->select()->where($params)->get()->getResult();
    }
    public function addApplicantParticulars($data)
    {
        return $this->applicantParticulars->insert($data);
    }
    public function createApplicationId($data)
    {
        return $this->tempId->insert($data);
    }
    public function getUser($hash)
    {
        return $this->users->select()->where(['hash' => $hash])->get()->getRow();
    }



    public function updateApplicantParticulars($id, $data)
    {
        return $this->applicantParticulars->set($data)->where(['user_id' => $id])->update();
    }

    public function getApplicationId($id)
    {
        return $this->tempId->select()->where(['user_id' => $id])->get()->getRow();
    }

    //=================log the user in====================
    public function login()
    {
    }

    //=================Activating user account====================
    public function addQualification($data)
    {
        return $this->applicantQualifications->insert($data);
    }
    public function getQualifications($params)
    {
        return $this->applicantQualifications->select()->where($params)->get()->getResult();
    }
    public function deleteQualification($params)
    {
        return $this->applicantQualifications->where($params)->delete();
    }
   




    //=====================================
    public function addLicense($data)
    {
        return $this->licenseType->insert($data);
    }
    public function getLicenseType($params)
    {
        return $this->licenseType->select()->where($params)->get()->getResult();
    }

    public function deleteLicense($params)
    {
        return $this->licenseType->where($params)->delete();;
    }



    //=====================================
    public function addTool($data)
    {
        return $this->tools->insert($data);
    }
    public function getTools($params)
    {
        return $this->tools->select()->where($params)->get()->getResult();
    }

    public function deleteTool($params)
    {
        return $this->tools->where($params)->delete();;
    }


    //=====================================
    public function addAttachment($data)
    {
        return $this->attachments->insert($data);
    }
    public function getAttachments($params)
    {
        return $this->attachments->select()->where($params)->get()->getResult();
    }

    public function deleteAttachment($params)
    {
        return $this->attachments->where($params)->delete();
    }
    public function editAttachment($params)
    {
        return $this->attachments->select()->where($params)->get()->getRow();
    }
    public function updateAttachment($id, $data)
    {
        return $this->attachments->set($data)->where(['id' => $id])->update();
    }


    public function submitApplication($applicationId)
    {
        $value = 1;
        $tables = ['applicant_qualifications', 'license_type', 'tools', 'attachments'];
        $data = [];
        foreach ($tables as $table) {
            $sql = "UPDATE $table SET submission=$value WHERE application_id='$applicationId'";
            if($this->db->query($sql)){

                array_push($data, $table);
            }
        }
        if ($tables == $data) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteApplicationId($id)
    {
        return $this->tempId->where(['user_id' => $id])->delete();
    }
}
