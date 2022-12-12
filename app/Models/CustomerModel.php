<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $customersTable;
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->customersTable = $this->db->table('customers');
    }


    //creating new customer
    public function createCustomer($data)
    {
        return $this->customersTable->insert($data);
    }
    //update customer
    public function updateCustomer($hash, $data)
    {
        return $this->customersTable
            ->where(['hash' => $hash])
            ->update($data);
    }
    //searching existing customer
    public function searchCustomer($keyword)
    {

        return $this->customersTable->select()
            ->like(['name' => $keyword])
            ->orLike(['phone_number' => $keyword])
            ->get()
            ->getResult();
    }
    //get single Customer customer
    public function selectCustomer($hash)
    {
        return $this->customersTable
            ->select()
            ->where(['hash' => $hash])
            ->get()
            ->getRow();
    }
    //get all Customer customer
    public function selectAllCustomers()
    {
        return $this->customersTable
            ->select()
            ->get()
            ->getResult();
    }

    //get latest inserted customer hash 
    public function lastHash()
    {

        return $this->customersTable
            ->select('id,hash')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()
            ->getResult();
    }
}
