<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class LorriesModel extends Model
{
    public $db;
    public $dataTable;
    public $lorriesTable;
    public $lorriesRecords;
    public $transactionTable;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->dataTable = $this->db->table('lorries');
        $this->lorriesTable = $this->db->table('sandy_lorries');
        $this->lorriesRecords = $this->db->table('sandy_lorries_records');
        $this->transactionTable = $this->db->table('transactions');
    }

    //=================check Last id====================

    public function checkLastId()
    {
        return $this->lorriesTable
            ->select('id')
            ->orderBy('data_id', 'DESC')
            ->limit(1)
            ->get()
            ->getResult();

    }
    public function findVehicle($id)
    {
        return $this->lorriesTable
            ->select()
            ->where(['id' => $id])
            ->get()
            ->getRow();
    }
    public function checkLastIdByPlate($plateNumber)
    {
        return $this->lorriesTable
            ->select('id')
            ->where(['plate_number' => $plateNumber])
            ->orderBy('data_id', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();

    }

    public function checkLastVehicleId()
    {
        return $this->lorriesRecords
            ->select('id')
            ->orderBy('data_id', 'DESC')
            ->limit(1)
            ->get()
            ->getResult();

    }

    public function getVehicle($id)
    {
        return $this->lorriesTable
            ->select()
            ->where(['id' => $id])
            ->get()
            ->getRow();
    }

    public function grabTheLastVehicle()
    {
        return $this->lorriesTable
            ->select()
            ->orderBy('data_id', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();

    }
    //=================searching  a plate number====================
    public function findMatch($hash, $plateNumber)
    {
        return $this->lorriesTable
            ->select()
            ->where(['hash' => $hash])
            ->where(['plate_number' => $plateNumber])
            ->get()
            ->getRow();
    }
    public function registerLorryTankRecord($data)
    {

       return $this->lorriesRecords->insertBatch($data);
       
    }

    public function saveLorryData($data)
    {

       return $this->dataTable->insert($data);
       
    }
    //=================Add sandyLorries====================
    public function registerLorryInDb($data)
    {
       return $this->lorriesTable->insert($data);
       
    }

    //=================check all paid Lorries if exist====================
    public function filterCustomersPaidLorries($hash)
    {
        return $this->lorriesRecords
            ->select('original_id')
            ->where(['hash' => $hash])
            ->get()
            ->getResult();
    }

    public function getAllUnpaidLorries($hash, $ids)
    {
        return $this->lorriesTable
            ->select()
            ->where(['hash' => $hash])
            ->whereNotIn('data_id', $ids)
        //->join('transactions','sandy_lorries_records.id = transactions.instrument_id')
            ->get()
            ->getResult();

    }

    //=================Publish Lorry ni transaction====================
    public function publishLorryTransaction($data)
    {

       return $this->transactionTable->insertBatch($data);
       
    }

    public function getRegisteredLorries($id)
    {
        return $this->transactionTable
            ->select()
            ->select('users.phone_number as phoneNumber ,users.first_name as firstName ,users.last_name as lastName,customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number,sandy_lorries_records.vehicle_brand')
            ->where(['transactions.unique_id' => $id])
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('sandy_lorries_records', 'sandy_lorries_records.id = transactions.instrument_id')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->get()
            ->getResult();
    }
    public function getAllLorries($region)
    {
        return $this->transactionTable
            ->select()
            ->select('users.phone_number as phoneNumber ,users.first_name as firstName ,users.last_name as lastName,customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number,sandy_lorries_records.vehicle_brand')
            ->where(['customers.region' => $region])
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('sandy_lorries_records', 'sandy_lorries_records.id = transactions.instrument_id')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->get()
            ->getResult();
    }
    public function getAllLorriesTz()
    {
        return $this->transactionTable
            ->select()
            ->select('users.phone_number as phoneNumber ,users.first_name as firstName ,users.last_name as lastName,customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number,sandy_lorries_records.vehicle_brand')
            // ->where(['customers.region' => $region])
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('sandy_lorries_records', 'sandy_lorries_records.id = transactions.instrument_id')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->get()
            ->getResult();
    }

    public function deleteRecord($id)
    {
        $this->dataTable
            ->where(['id' => $id])
            ->delete();
    }
    public function editRecord($id)
    {
        return $this->dataTable
            ->select()
            ->select('customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number')
            ->where(['id' => $id])
            ->join('customers', 'customers.hash = lorries.customer_hash')
            ->get()
            ->getRow();
    }

    public function updateLorry($data, $id)
    {

        return $this->lorriesTable
            ->set($data)
            ->where(['id' => $id])
            ->update();
    }

    public function sblDetails($location)
    {
        return $this->transactionTable
            ->select('sandy_lorries_records.amount,payment')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('sandy_lorries_records', 'sandy_lorries_records.id = transactions.instrument_id')
            ->where(['customers.region' => $location])
            ->get()
            ->getResult();
    }
    // ================Get all details in all regions==============
    public function getAllInRegion($location)
    {
        return $this->transactionTable
            ->select('transactions.id,sandy_lorries_records.amount,payment,customers.region')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('sandy_lorries_records', 'sandy_lorries_records.id = transactions.instrument_id')
            ->where(['customers.region' => $location])
            ->get()
            ->getResult();
    }
    // ================Full details on  activity==============

// ================Api Data for a specific region==============
    public function getData($city)
    {
        return $this->transactionTable
            ->select('customers.region,sandy_lorries_records.registration_date,sandy_lorries_records.amount,payment')
            ->where(['customers.region' => $city])
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('sandy_lorries_records', 'sandy_lorries_records.id = transactions.instrument_id')
            ->get()
            ->getResult();
    }

    // ================Data for Api for entire country (DIRECTOR) ==============
    public function getFullDataForDirector()
    {
        return $this->transactionTable
            ->select('sandy_lorries_records.amount,payment,sandy_lorries_records.registration_date')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('sandy_lorries_records', 'sandy_lorries_records.id = transactions.instrument_id')
            ->get()
            ->getResult();
    }

    //=================DATA FOR THE REPORTS====================
    //=================%% report for officers %%====================

    //=================%% report for managers %%====================
  
    //=================%% report for directors %%====================
    
    #--------------------------------------------------------
    #
    # ONLY WITHIN A QUARTER
    #
    #--------------------------------------------------------------

    //=================%% report for officers %%====================
    public function sblQuarterReport($params, $monthFrom, $monthTo)
    {
        return $this->transactionTable
            ->select('users.first_name as fName,users.last_name as lName')
            ->select('customers.name,customers.phone_number,sandy_lorries_records.vehicle_brand,sandy_lorries_records.plate_number,sandy_lorries_records.capacity,sandy_lorries_records.amount as vehicle_amount')
            ->select('instrument_id,transactions.payment,sandy_lorries_records.amount,control_number,transactions.created_on')
            ->where($params)
            ->where('MONTH(created_on) BETWEEN ' . $monthFrom . ' AND ' . $monthTo . '')
            
            
            ->orderBy('created_on', 'ASC')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('sandy_lorries_records', 'sandy_lorries_records.id = transactions.instrument_id')
            ->get()
            ->getResult();
    }


    //=================%% report for managers %%====================
    public function sblQuarterReportManager($region, $monthFrom, $monthTo, $year)
    {
        return $this->transactionTable
            ->select('users.first_name as fName,users.last_name as lName')
            ->select('customers.name,customers.phone_number,sandy_lorries_records.vehicle_brand,sandy_lorries_records.plate_number,sandy_lorries_records.capacity,sandy_lorries_records.amount as vehicle_amount')
            ->select('instrument_id,transactions.payment,sandy_lorries_records.amount,control_number,transactions.created_on')
            ->where(['customers.region' => $region])
            ->where('MONTH(created_on) BETWEEN ' . $monthFrom . ' AND ' . $monthTo . '')
            ->where('YEAR(created_on) = ' . $year . '')

            ->orderBy('created_on', 'ASC')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->join('sandy_lorries_records', 'sandy_lorries_records.id = transactions.instrument_id')
            ->get()
            ->getResult();
    }



    ########################################################################
    ############################# MONTHLY ONLY #############################
    #######################################################################
    public function dataReport($params)
    {
        return $this->transactionTable
            ->select('users.first_name as fName,users.last_name as lName')
            ->select('customers.name,customers.phone_number,sandy_lorries_records.vehicle_brand,sandy_lorries_records.plate_number,sandy_lorries_records.capacity,sandy_lorries_records.amount as vehicle_amount')
            ->select('instrument_id,transactions.payment,sandy_lorries_records.amount,control_number,transactions.created_on')
            ->where($params)
            ->orderBy('created_on', 'ASC')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->join('sandy_lorries_records', 'sandy_lorries_records.id = transactions.instrument_id')
            ->get()
            ->getResult();
    }

    public function collectionSum($params)
    {
        return $this->transactionTable
            ->selectSum('sandy_lorries_records.amount')

            ->where($params)
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('sandy_lorries_records', 'sandy_lorries_records.id = transactions.instrument_id')
            ->get()
            ->getResult();
    }



    public function dateRangeReport($params,$dateFrom,$dateTo)
    {
        return $this->transactionTable
            ->select('customers.name,customers.phone_number,sandy_lorries_records.vehicle_brand,sandy_lorries_records.plate_number,sandy_lorries_records.capacity,sandy_lorries_records.amount as vehicle_amount')
            ->select('instrument_id,transactions.payment,sandy_lorries_records.amount,control_number,transactions.created_on')
            ->select('users.first_name as fName,users.last_name as lName')
            ->where($params)
            ->where(['created_on >=' => $dateFrom])
            ->where(['created_on <=' => $dateTo])
            ->orderBy('created_on', 'ASC')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('sandy_lorries_records', 'sandy_lorries_records.id = transactions.instrument_id')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->get()
            ->getResult();
    }



    public function searchingSbl()
    {
        return $this->lorriesRecords
            ->select(
                '
          sandy_lorries_records.id,
         sandy_lorries_records.activity,
         sandy_lorries_records.registration_date,
         sandy_lorries_records.next_calibration,
         sandy_lorries_records.tin_number,
         sandy_lorries_records.supervisor,
         sandy_lorries_records.supervisor_phone,
         sandy_lorries_records.driver_name,
         sandy_lorries_records.driver_license,
         sandy_lorries_records.vehicle_brand,
         sandy_lorries_records.plate_number,
         sandy_lorries_records.capacity,
         sandy_lorries_records.status,
         sandy_lorries_records.sticker_number,
         sandy_lorries_records.amount,
         sandy_lorries_records.other_charges,
         sandy_lorries_records.remark,
         transactions.control_number,
         transactions.payment,


         users.first_name as officerFirstName,
         users.last_name as officerLastName

          '
            )
            ->select('customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number,sandy_lorries_records.vehicle_brand')
            ->join('transactions', 'sandy_lorries_records.id = transactions.instrument_id')
            ->join('customers', 'customers.hash = sandy_lorries_records.hash')
            ->join('users', 'users.unique_id = sandy_lorries_records.unique_id')
            ->get()
            ->getResultArray();
    }

    //=================get vehicle after searching====================
    public function vehicleMatch($id)
    {
        return $this->lorriesRecords
            ->select(
                '


         sandy_lorries_records.activity,
         sandy_lorries_records.registration_date,
         sandy_lorries_records.next_calibration,
         sandy_lorries_records.tin_number,
         sandy_lorries_records.supervisor,
         sandy_lorries_records.supervisor_phone,
         sandy_lorries_records.driver_name,
         sandy_lorries_records.driver_license,
         sandy_lorries_records.vehicle_brand,
         sandy_lorries_records.plate_number,
         sandy_lorries_records.capacity,
         sandy_lorries_records.status,
         sandy_lorries_records.sticker_number,
         sandy_lorries_records.amount,
         sandy_lorries_records.other_charges,
         sandy_lorries_records.remark,
         transactions.control_number,
         transactions.payment,


         users.first_name as officerFirstName,
         users.last_name as officerLastName

          '
            )
            ->select('customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number,sandy_lorries_records.vehicle_brand')
            ->where(['sandy_lorries_records.id' => $id])
            ->join('transactions', 'sandy_lorries_records.id = transactions.instrument_id')
            ->join('customers', 'customers.hash = sandy_lorries_records.hash')
            ->join('users', 'users.unique_id = sandy_lorries_records.unique_id')
            ->get()
            ->getRow();
    }
}