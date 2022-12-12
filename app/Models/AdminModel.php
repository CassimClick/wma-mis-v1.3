<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
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

    public function updateAvatar($path, $id)
    {

        return $this->usersTable
            ->where(['unique_id' => $id])
            ->set(['avatar' => $path])
            ->update();
    }
    public function updatePassword($id, $password)
    {

        return $this->usersTable
            ->where(['unique_id' => $id])
            ->set(['password' => $password])
            ->update();
    }

    public function createUser($data)
    {
        return $this->usersTable->insert($data);
    }

    public function getAllUsers(){
          return $this->usersTable->select()->get()->getResult();
    }
    public function getUser($id){
          return $this->usersTable->select(
              'first_name,
              last_name,
              email,
              city,
              role,
              position,
              unique_id as x_id'

          )->where(['unique_id' => $id])->get()->getRow();
    }

    public function changeStatus($id,$status)
    {
        return $this->usersTable
            ->where(['unique_id' => $id])
            ->set(['status' => $status])
            ->update();
    }
    public function activateAccount($id)
    {
        return $this->usersTable
            ->where(['unique_id' => $id])
            ->set(['status' => 'active'])
            ->update();
    }
    public function deactivateAccount($id)
    {
        return $this->usersTable
            ->where(['unique_id' => $id])
            ->set(['status' => 'inactive'])
            ->update();
    }

    public function updateUser($id, $data)
    {

        return $this->usersTable
            ->where(['unique_id' => $id])
            ->set($data)
            ->update();
    }
}