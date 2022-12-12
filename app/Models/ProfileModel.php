<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    public $db;
    public $usersTable;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->usersTable = $this->db->table('users');
    }

    public function getLoggedUserData($id)
    {
        $builder = $this->usersTable;
        $builder->where('unique_id', $id);
        $result = $builder->get();
        if (count($result->getResultArray()) == 1) {
            return $result->getRow();
        } else {
            return false;
        }
    }

    public function getRole($id){
        return $this->usersTable->select('role')->where(['unique_id' => $id])->get()->getRow();
    }
    public function getAdmin($id){
        return $this->usersTable->select('position')->where(['position'=>'SuperAdmin'])->where(['unique_id' => $id])->get()->getRow();
    }

    public function updateAvatar($filePath, $id)
    {

        return $this->usersTable
            ->set('avatar', $filePath)
            ->where(['unique_id' => $id])
            ->update();
    }
    public function updatePassword($id, $password)
    {

        return $this->usersTable
            ->where(['unique_id' => $id])
            ->set(['password' => $password])
            ->update();
    }
    public function savePassword($id, $data)
    {

        return $this->usersTable
            ->where(['unique_id' => $id])
            ->set($data)
            ->update();
    }
    public function checkEmail($email)
    {

        return $this->usersTable
            ->select('email')
            ->where(['email' => $email])
            ->get()
            ->getRow();
    }
}