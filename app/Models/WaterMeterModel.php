<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class WaterMeterModel extends Model
{
    public $db;
    public $waterMetersTable;
    public $transactionTable;


    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->waterMetersTable = $this->db->table('water_meters');
        $this->transactionTable = $this->db->table('transactions');
    }

    public function registerWaterMeter($data)
    {

        return $this->waterMetersTable->insertBatch($data);
    }
    //=================Publish water meter in transaction table====================
    public function publishWaterMeterData($data)
    {

        return $this->transactionTable->insertBatch($data);
    }

    //=================check all paid water meter if exist====================
    public function filterCustomersPaidWaterMeters($hash)
    {
        return $this->transactionTable
            ->select('instrument_id')
            ->where(['customer_hash' => $hash])
            ->get()
            ->getResult();
    }
    //=================get meter details====================
    public function getMeterDetails($id)
    {
        return $this->waterMetersTable
            ->select()
            ->where(['id' => $id])
            ->get()
            ->getRow();
    }

    public function getAllUnpaidWaterMeters($hash, $ids)
    {
        return $this->waterMetersTable
            ->select()
            ->where(['hash' => $hash])
            ->whereNotIn('batch_id', $ids)
            ->groupBy('batch_id')
            ->get()
            ->getResult();
    }
    public function getMetersByBatchId($batchId)
    {
        return $this->waterMetersTable
            ->select()
            ->where(['batch_id' => $batchId])
            
            ->get()
            ->getResult();
    }
    public function getMetersByBatch($batchId)
    {
        return $this->waterMetersTable
            ->select()
            ->where(['batch_id' => $batchId])
            ->join('customers','customers.hash = water_meters.hash')
            ->join('users', 'users.unique_id = water_meters.unique_id')
            ->get()
            ->getResult();
    }

    //=================check Last id====================

    public function checkLastId()
    {
        return $this->waterMetersTable
            ->select('id')
            ->orderBy('data_id', 'DESC')
            ->limit(1)
            ->get()
            ->getResult();
    }

    public function getRegisteredWaterMeters($id)
    {
        return $this->transactionTable
            ->select()
            //->select('customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number,water_meters.vehicle_brand')
            ->where(['transactions.unique_id' => $id])
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('water_meters', 'water_meters.batch_id = transactions.instrument_id')
            ->groupBy('batch_id')
            ->groupBy('batch_id')
            ->get()
            ->getResult();
    }
    public function getAllWaterMeters($region)
    {
        return $this->transactionTable
            ->select()
            //->select('customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number,water_meters.vehicle_brand')
            ->where(['customers.region' => $region])
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('water_meters', 'water_meters.batch_id = transactions.instrument_id')
            ->groupBy('batch_id')
            ->get()
            ->getResult();
    }
    public function getAllWaterMetersTz()
    {
        return $this->transactionTable
            ->select()
            //->select('customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number,water_meters.vehicle_brand')
            // ->where(['customers.region' => $region])
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('water_meters', 'water_meters.batch_id = transactions.instrument_id')
            ->groupBy('batch_id')
            // ->groupBy('water_meters.batch_id')
            ->get()
            ->getResult();
    }

    public function deleteRecord($id)
    {
        $this->waterMetersTable
            ->where(['id' => $id])
            ->delete();
    }
    public function editRecord($id)
    {
        return $this->waterMetersTable
            ->select()
            ->select('customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number')
            ->where(['id' => $id])
            ->join('customers', 'customers.hash = watermeter.customer_hash')
            ->get()
            ->getRow();
    }

    public function updateWaterMeterData($data, $id)
    {

        return $this->waterMetersTable
            ->set($data)
            ->where(['id' => $id])
            ->update();
    }
    public function updatePayment($data, $id)
    {

        return $this->waterMetersTable
            ->set($data)
            ->where(['id' => $id])
            ->update();
    }

    //=================get paid and pending amounts in water meter in specific region ====================
    public function waterMeterDetails($region)
    {
        return $this->transactionTable
            ->select('water_meters.amount,payment')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('water_meters', 'water_meters.batch_id = transactions.instrument_id')
            ->groupBy('batch_id')
            ->where(['customers.region' => $region])
            ->get()
            ->getResult();
    }
    // ================Get all details in all regions==============
    public function getAllInRegion($location)
    {
        return $this->transactionTable
            ->select('transactions.id,water_meters.amount,payment,customers.region,water_meters.quantity')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('water_meters', 'water_meters.batch_id = transactions.instrument_id')
            ->groupBy('batch_id')
            ->where(['customers.region' => $location])
            ->get()
            ->getResult();
    }

    // ================Api data for specific region(MANAGER) ==============
    public function getData($city)
    {

        return $this->transactionTable
            ->select('water_meters.amount,customers.region,water_meters.created_at,payment')
            ->where(['customers.region' => $city])
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('water_meters', 'water_meters.batch_id = transactions.instrument_id')
            ->groupBy('batch_id')
            ->get()
            ->getResult();
    }

    // ================Data for Api for entire country (DIRECTOR) ==============
    public function getFullDataForDirector()
    {
        return $this->transactionTable
            ->select('water_meters.amount,payment,water_meters.created_at,water_meters.quantity')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('water_meters', 'water_meters.batch_id = transactions.instrument_id')
            ->groupBy('batch_id')
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
    public function waterMeterQuarterReport($params, $monthFrom, $monthTo)
    {
        return $this->transactionTable
            ->select('users.first_name as fName,users.last_name as lName')
            ->select('customers.name,customers.phone_number,water_meters.brand,water_meters.quantity,water_meters.flow_rate,water_meters.class,water_meters.amount,meter_size')
            ->select('instrument_id,transactions.payment,control_number,transactions.created_on')
            ->where($params)
            ->where('MONTH(created_on) BETWEEN ' . $monthFrom . ' AND ' . $monthTo . '')


            ->orderBy('created_on', 'ASC')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('water_meters', 'water_meters.batch_id = transactions.instrument_id')
            ->groupBy('batch_id')
           
            ->get()
            ->getResult();
    }




    //=================%% report for directors %%====================




    #--------------------------------------------------------
    ###########################################################
    # ################ONLY WITHIN A MONTH #####################
    ###########################################################
    #--------------------------------------------------------------

    //=================%% report for officers %%====================
    public function dataReport($params)
    {
        return $this->transactionTable
            ->select('customers.name,customers.phone_number,water_meters.brand,water_meters.quantity,water_meters.flow_rate,water_meters.class,water_meters.amount ,meter_size')
            ->select('instrument_id,transactions.payment,control_number,transactions.created_on')
            ->select('users.first_name as fName,users.last_name as lName')
            ->where($params)
            ->orderBy('created_on', 'ASC')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('water_meters', 'water_meters.batch_id = transactions.instrument_id')
            ->groupBy('batch_id')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->get()
            ->getResult();
    }

    public function collectionSum($params)
    {
        return $this->transactionTable
            ->selectSum('water_meters.amount')

            ->where($params)
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('water_meters', 'water_meters.batch_id = transactions.instrument_id')
            ->groupBy('batch_id')
            ->get()
            ->getResult();
    }

    public function dateRangeReport($params, $dateFrom, $dateTo)
    {
        return $this->transactionTable
            ->select('customers.name,customers.phone_number,water_meters.brand,water_meters.quantity,water_meters.flow_rate,water_meters.class,water_meters.amount ,meter_size')
            ->select('instrument_id,transactions.payment,control_number,transactions.created_on')
            ->select('users.first_name as fName,users.last_name as lName')
            ->where($params)
            ->where(['created_on >=' => $dateFrom])
            ->where(['created_on <=' => $dateTo])
            ->orderBy('created_on', 'ASC')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('water_meters', 'water_meters.batch_id = transactions.instrument_id')
            ->groupBy('batch_id')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->get()
            ->getResult();
    }






    //=================searching water meters====================
    public function searchingWaterMeter()
    {
        return $this->waterMetersTable
            ->select(
                '
       water_meters.batch_id,
       water_meters.activity,
       water_meters.created_at,
       water_meters.meter_size,
       water_meters.brand,
       water_meters.quantity,
       water_meters.flow_rate,
       water_meters.class,
       water_meters.lab,
       water_meters.testing_method,
       water_meters.status,
       water_meters.status,
       water_meters.other_charges,
       water_meters.remark,
       water_meters.other_charges,

       transactions.control_number,
       transactions.payment,


       users.first_name as officerFirstName,
       users.last_name as officerLastName

        '
            )
            ->select('customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number')
            ->join('transactions', 'water_meters.batch_id = transactions.instrument_id')
            ->join('customers', 'customers.hash = water_meters.hash')
            ->join('users', 'users.unique_id = water_meters.unique_id')
            ->get()
            ->getResultArray();
    }

    //=================get water meter details after searching====================
    public function waterMeterMatch($id)
    {
        return $this->waterMetersTable
            ->select(
                '


        water_meters.activity,
        water_meters.created_at,
        water_meters.meter_size,
        water_meters.brand,
        water_meters.quantity,
        water_meters.flow_rate,
        water_meters.class,
        water_meters.lab,
        water_meters.testing_method,
        water_meters.status,
        water_meters.amount,
        water_meters.other_charges,
        water_meters.remark,
        water_meters.other_charges,

       transactions.control_number,
       transactions.payment,


       users.first_name as officerFirstName,
       users.last_name as officerLastName

        '
            )
            ->select('customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number')
            ->where(['water_meters.batch_id' => $id])
            ->join('transactions', 'water_meters.batch_id = transactions.instrument_id')
            ->join('customers', 'customers.hash = water_meters.hash')
            ->join('users', 'users.unique_id = water_meters.unique_id')
            ->get()
            ->getRow();
    }
}
