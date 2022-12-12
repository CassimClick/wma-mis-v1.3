<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class PrePackageModel extends Model
{
  public $db;
  public $prePackageTable;
  public $measurementTable;
  public $customersTable;
  public $productDetailsTable;
  public $productTest;
  public $transactionTable;

  public function __construct()
  {
    $this->db = \Config\Database::connect();
    $this->prePackageTable = $this->db->table('prepackage');
    $this->transactionTable = $this->db->table('transactions');
    $this->measurementTable = $this->db->table('measurement_sheet');
    $this->productDetailsTable = $this->db->table('product_details');
    $this->productTest = $this->db->table('producttest');
    $this->customersTable = $this->db->table('customers');
  }
  public function prePackageColumns()
  {
    return '
        customers.hash,
        name,
        location,
        physical_address,
        postal_address,
        customers.region,
        customers.phone_number,
        ref_number,
        batch_number,
        instrument_id,
        control_number,
        payment,
        transactions.amount as billAmount,
        payment,
        product_details.hash,
        commodity,
        quantity,
        unit,
        lot,
        sample_size,
        gross_quantity,
        prepackage.product_id,
        prepackage.amount,
        users.first_name as fName,users.last_name as lName,
        prepackage.hash,
        prepackage.created_at,
      
      ';
  }


   
  

  public function createBill($data)
  {
    return $this->prePackageTable->insertBatch($data);
  }
  public function createPrePackageBill($data)
  {
    return $this->transactionTable->insertBatch($data);
  }


  public function getUnpaidProducts($hash, $ids)
  {
    return $this->productDetailsTable
      ->select()
      ->where(['hash' => $hash])
      ->whereNotIn('id', $ids)
      ->get()
      ->getResult();
  }
  public function getPaidProducts($hash)
  {
    return $this->prePackageTable
      ->select()
      ->where(['prepackage.hash' => $hash])
      ->join('product_details', 'product_details.id = prepackage.product_id')
      ->get()
      ->getResult();
  }

  public function getBilledProducts($hash)
  {
    return $this->transactionTable
      ->select('instrument_id')
      ->where(['customer_hash' => $hash])
      ->get()
      ->getResult();
  }
  public function getTheProducts($hash)
  {
    return $this->prePackageTable
      // ->select('
      //  product_details.id,
      //  product_details.hash,
      //  product_details.commodity,
      //  product_details.quantity,
      //  product_details.unit,
      //  product_details.analysis_category,
      //  product_details.method,
      //  product_details.packing_declaration,
      //  product_details.measurement_unit,
      //  product_details.sampling,
      //  product_details.measurement_nature,
      //  product_details.tare,
      //  product_details.product_nature,
      //  product_details.density,
      //  product_details.gross_quantity,
      //  product_details.sample_size,
      //  product_details.unique_id,
      //  product_details.created_at,

      // ')

      ->select()
      ->where(['prepackage.hash' => $hash])
      ->join('product_details', 'product_details.id = prepackage.product_id ')
      ->get()
      ->getResult();
  }
  public function getRegionalPrepackedData($params)
  {
    return $this->customersTable
      ->select($this->prePackageColumns())
      ->where($params)
      ->join('prepackage', 'prepackage.hash = customers.hash')
      ->join('product_details', 'product_details.id = prepackage.product_id')
      ->join('transactions', 'transactions.instrument_id = prepackage.product_id')
      ->get()
      ->getResult();
  }

  public function prePackageData($id)
  {
    return $this->prePackageTable

      ->select($this->prePackageColumns())
      ->where(['prepackage.unique_id' => $id])
      ->orderBy('created_on', 'DESC')
      ->join('users', 'users.unique_id = prepackage.unique_id')
      ->join('customers', 'customers.hash = prepackage.hash')
      ->join('product_details', 'product_details.id = prepackage.product_id')
      ->join('transactions', 'transactions.instrument_id = prepackage.product_id')
      ->get()
      ->getResult();
  }
  public function prePackageDataRegion($region)
  {
    return $this->prePackageTable

      ->select($this->prePackageColumns())
      ->where(['customers.region' => $region])
      ->orderBy('created_on', 'DESC')
      ->join('users', 'users.unique_id = prepackage.unique_id')
      ->join('customers', 'customers.hash = prepackage.hash')
      ->join('product_details', 'product_details.id = prepackage.product_id')
      ->join('transactions', 'transactions.instrument_id = prepackage.product_id')
      ->get()
      ->getResult();
  }



  //QUARTER REPORT
  public function prePackageQuarterReport($params, $monthFrom, $monthTo)
  {
    return $this->prePackageTable

      ->select($this->prePackageColumns())
      ->where($params)
      ->where('MONTH(prepackage.created_at) BETWEEN ' . $monthFrom . ' AND ' . $monthTo . '')
      ->orderBy('prepackage.created_at', 'ASC')
      ->join('users', 'users.unique_id = prepackage.unique_id')
      ->join('customers', 'customers.hash = prepackage.hash')
      ->join('product_details', 'product_details.id = prepackage.product_id')
      ->join('transactions', 'transactions.instrument_id = prepackage.product_id')
      ->get()
      ->getResult();
  }
  //MONTHLY REPORT
  public function dataReport($params)
  {
    return $this->prePackageTable

      ->select($this->prePackageColumns())
      ->where($params)
      ->orderBy('created_on', 'ASC')
      ->join('users', 'users.unique_id = prepackage.unique_id')
      ->join('customers', 'customers.hash = prepackage.hash')
      ->join('product_details', 'product_details.id = prepackage.product_id')
      ->join('transactions', 'transactions.instrument_id = prepackage.product_id')
      ->get()
      ->getResult();
  }
  //DATE RANGE REPORT
  public function dateRangeReport($params, $dateFrom, $dateTo)
  {
    return $this->prePackageTable

      ->select($this->prePackageColumns())
      ->where($params)
      ->where(['created_on >=' => $dateFrom])
      ->where(['created_on <=' => $dateTo])
      ->orderBy('created_on', 'ASC')
      ->join('users', 'users.unique_id = prepackage.unique_id')
      ->join('customers', 'customers.hash = prepackage.hash')
      ->join('product_details', 'product_details.id = prepackage.product_id')
      ->join('transactions', 'transactions.instrument_id = prepackage.product_id')
      ->get()
      ->getResult();
  }

  public function addCustomer($data)
  {

    return $this->customersTable->insert($data);
  }
  
  public function addProductDetails($data)
  {

    return $this->productDetailsTable->insert($data);
  }
  public function getProducts($hash)
  {

    return $this->productDetailsTable->select()->where(['hash' => $hash])->orderBy('id', 'DESC')->get()->getResult();
  }
  public function collectionSum($params)
  {
    return $this->transactionTable
      ->selectSum('prepackage.amount')

      ->where($params)
      ->join('customers', 'customers.hash = transactions.customer_hash')
      ->join('prepackage', 'prepackage.id = transactions.instrument_id')
      ->get()
      ->getResult();
  }

  public function lastHash()
  {

    return $this->customersTable->select('id,hash')->orderBy('id', 'DESC')->limit(1)->get()->getResult();
  }

  public function searchCustomer($keyword)
  {

    return $this->customersTable->select()
      ->like(['name' => $keyword])
      ->orLike(['phone_number' => $keyword])
      ->get()
      ->getResult();
  }
  public function getCustomerInfo($hash)
  {

    return $this->customersTable->select()
      ->where(['hash' => $hash])
      ->get()
      ->getRow();
  }
  public function getCustomerProducts($params)
  {
    try {
      return $this->productDetailsTable->select(
        'id,
      hash,
      activity,
      commodity,
      quantity,
      unit,
      sample_size,
      lot,
      gross_quantity,
      created_at

      '


      )
        // ->where($params)
        ->where($params)
        ->get()
        ->getResult();
    } catch (\Exception $e) {
      echo ($e->getMessage());
    }
  }


  //=================Inserting measurement sheet data====================
  public function addMeasurementSheetData($data)
  {

    $builder = $this->db->table('measurement_sheet');


    return $builder->insertBatch($data);
  }
  public function checkQuantityId($id)
  {

    return $this->measurementTable
    ->select()
    ->where('quantity_id', $id)
    ->limit(1)
    ->get()
    ->getResult();
  }

  //=================grabbing measurement sheet data====================
  public function getProductsWithMeasurements($ids, $hash)
  {

    return $this->measurementTable
      ->select('product_details.id,measurement_sheet.product_id,product_details.hash,commodity,lot,quantity,unit,activity,product_details.gross_quantity,product_details.sample_size ,type,fob,date,tansard_number')
      // ->where(['prepackage.hash' => $hash])
      ->whereIn('measurement_sheet.product_id', $ids)
      // ->whereNotIn('prepackage.product_id', $ids)
      // ->join('prepackage', 'prepackage.product_id = measurement_sheet.product_id', 'right')
      ->join('product_details', 'product_details.id = measurement_sheet.product_id', 'right')
      ->get()
      ->getResult();
  }
  public function grabProducts($ids, $hash)
  {

    return $this->productDetailsTable
      ->select('product_details.id,product_details.hash,commodity,lot,gross_quantity')
      ->whereIn('product_details.id', $ids)
      ->where(['product_details.hash' => $hash])
      ->join('prepackage', 'prepackage.product_id = product_details.id')
      // ->join('product_details', 'product_details.id = prepackage.product_id')
      ->get()
      ->getResult();
  }
  //=================grabbing measurement sheet data====================
  public function getMeasurementData($params)
  {


    $builder = $this->db->table('measurement_sheet');

    return $builder
      ->select()
      ->where($params)
      //->where(['quantity_id' => $measurementId])
      ->get()
      ->getResult();
  }
  public function selectProduct($id)
  {

    return $this->productDetailsTable->select()
      ->where(['id' => $id])
      ->get()
      ->getRow();
  }

  public function getprepackage($id)
  {

    return $this->prePackageTable
      ->select()
      ->select('customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number')
      ->where(['unique_id' => $id])
      ->join('customers', 'customers.hash = prepackage.hash')
      ->get()
      ->getResult();
  }
  public function getAllPrePackages($region)
  {

    return $this->prePackageTable
      ->select()
      ->select('customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number')
      ->where(['region' => $region])
      ->join('customers', 'customers.hash = prepackage.hash')
      ->get()
      ->getResult();
  }

  public function deleteRecord($id)
  {
    $this->prePackageTable
      ->where(['id' => $id])
      ->delete();
  }


  public function editRecord($id)
  {
    return $this->prePackageTable
      ->select()
      ->select('customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number')
      ->where(['id' => $id])
      ->join('customers', 'customers.hash = prepackage.hash')
      ->get()
      ->getRow();
  }

  public function updateIndustrialPackage($data, $id)
  {


    return $this->prePackageTable
      ->set($data)
      ->where(['id' => $id])
      ->update();
  }
  public function prePackageDetails($location)
  {
    return $this->prePackageTable
      ->select('transactions.amount,payment')
      ->where(['customers.region' => $location])
      ->join('customers', 'customers.hash = prepackage.hash')
      ->join('transactions', 'transactions.instrument_id = prepackage.product_id')
      ->get()
      ->getResultArray();
  }
  // ================Get all details in all regions dts==============
  public function getAllInRegion($region)
  {
    return $this->prePackageTable

      ->select($this->prePackageColumns())
      ->where(['customers.region' => $region])
      ->orderBy('prepackage.created_at', 'ASC')
      ->join('users', 'users.unique_id = prepackage.unique_id')
      ->join('customers', 'customers.hash = prepackage.hash')
      ->join('product_details', 'product_details.id = prepackage.product_id')
      ->join('transactions', 'transactions.instrument_id = prepackage.product_id')
      ->get()
      ->getResult();
  }
  // ================Full details on  activity==============
  public function activityFullDetails()
  {
    return $this->prePackageTable
      // ->where(['region' => $location])
      ->select('amount,payment')
      ->get()
      ->getResultArray();
  }
  // ================Api==============
  public function getData($region)
  {
    return $this->prePackageTable
      ->select()
      ->where(['customers.region' => $region])
      ->join('customers', 'customers.hash = prepackage.hash')
      ->get()
      ->getResult();
  }

  // ================Data for Api==============
  public function getFullData()
  {
    return $this->prePackageTable
      ->select('customers.date,amount,payment')
      // ->where(['region' => $region])
      ->join('customers', 'customers.hash = prepackage.hash')
      ->get()
      ->getResult();
  }
}
