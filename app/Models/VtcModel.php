<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class VtcModel extends Model
{
    public $db;
    public $dataTable;
    public $calibratedTanks;
    public $transactionTable;
    public $compartments;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->dataTable = $this->db->table('vtc');
        $this->vehicle = $this->db->table('vehicle_tanks');
        $this->calibratedTanks = $this->db->table('calibrated_tanks');
        $this->transactionTable = $this->db->table('transactions');
        $this->compartments = $this->db->table('compartments');
    }
    //=================find any vehicle match====================
    public function findMatch($hash, $plateNumber)
    {
        return $this->vehicle
            ->select()
            ->where(['hash' => $hash])
            ->like(['trailer_plate_number' => $plateNumber])
            ->orLike(['hose_plate_number' => $plateNumber])
            ->get()
            ->getRow();
    }

    public function getVehicle($id)
    {
        return $this->vehicle
            ->select()
            ->where(['id' => $id])
            ->get()
            ->getRow();
    }

    public function getClientVehicles($hash)
    {
        return $this->vehicle
            ->select()
            //    ->select("SUM(compartments.litres) AS ltr")
            ->where(['vehicle_tanks.hash' => $hash])
            //    ->join('compartments', 'compartments.vehicle_id = vehicle_tanks.id','right')
            // ->groupBy('data_id')
            ->get()
            ->getResult();
    }
    public function getCompartments($vehicleId)
    {
        return $this->compartments
            ->select()
            ->where(['vehicle_id' => $vehicleId])
            ->get()
            ->getResult();
    }
    public function getCompartmentData($number, $vehicleId) 
    {
        return $this->compartments
            ->select()
            ->where(['compartment_number' => $number])
            ->where(['vehicle_id' => $vehicleId])
            ->get()
            ->getResult();
    }
    public function findVehicle($id)
    {
        return $this->vehicle
            ->select()
            ->where(['id' => $id])
            ->get()
            ->getRow();
    }

    //=================Register vehicle tanks====================
    public function registerVehicleTank($data)
    {

        return $this->vehicle->insert($data);
    }
    public function registerVehicleTankRecord($data)
    {

        return $this->calibratedTanks->insertBatch($data);
    }
    //=================updating vehicle====================
    public function updateVehicleTank($data, $id)
    {

        return $this->vehicle
            ->set($data)
            ->where(['id' => $id])
            ->update();
    }
    //=================Publish vtc ni transaction====================
    public function publishVtcTransaction($data)
    {

        return $this->transactionTable->insertBatch($data);
    }

    public function grabTheLastVehicle()
    {
        return $this->vehicle
            ->select()
            ->orderBy('data_id', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();
    }

    //=================check Last id====================

    public function checkLastId()
    {
        return $this->vehicle
            ->select('id')
            ->orderBy('data_id', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();
    }
    public function checkLastIdByPlate($plateNumber)
    {
        return $this->vehicle
            ->select('id')
            ->where(['trailer_plate_number' => $plateNumber])
            ->orderBy('data_id', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();
    }
    public function checkLastVehicleId()
    {
        return $this->calibratedTanks
            ->select('id')
            ->orderBy('data_id', 'DESC')
            ->limit(1)
            ->get()
            ->getResult();
    }

    //=================check all paid vehicles if exist====================
    public function filterCustomersPaidVehicles($hash)
    {
        return $this->calibratedTanks
            ->select('original_id')
            ->where(['hash' => $hash])
            ->get()
            ->getResult();
    }

    public function getAllUnpaidVehicles($hash, $ids)
    {
        return $this->vehicle
            ->select()
            ->where(['hash' => $hash])
            ->whereNotIn('data_id', $ids)
            ->get()
            ->getResult();
    }
    public function getVehicleDetails($id)
    {
        return $this->vehicle
            ->select()
            ->where(['id' => $id])
            ->get()
            ->getRow();
    }

    //=================addCompartmentData====================
    public function addCompartmentData($data)
    {

        return $this->compartments->insertBatch($data);
         
    }

    // public function saveVtcData($data)
    // {

    //  return  $this->dataTable->insert($data);
    //   if ($result->connID->affected_rows >= 1) {
    //     return true;
    //   } else {
    //     return false;
    //   }
    // }

    public function getRegisteredVtc($id)
    {
        return $this->transactionTable
            ->select()
            ->select('users.phone_number as phoneNumber ,users.first_name as firstName ,users.last_name as lastName,customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number,calibrated_tanks.vehicle_brand,calibrated_tanks.amount,calibrated_tanks.id as trailer_id,transactions.payment')
            ->where(['transactions.unique_id' => $id])
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('calibrated_tanks', 'calibrated_tanks.id = transactions.instrument_id', 'right')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->get()
            ->getResult();
    }

    public function getAllVtc($region)
    {
        return $this->transactionTable
            ->select()
            ->select('users.phone_number as phoneNumber ,users.first_name as firstName ,users.last_name as lastName,customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number,calibrated_tanks.vehicle_brand,calibrated_tanks.amount,calibrated_tanks.id as trailer_id,transactions.payment')
            ->where(['customers.region' => $region])
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('calibrated_tanks', 'calibrated_tanks.id = transactions.instrument_id')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->get()
            ->getResult();
    }
    public function getVtc()
    {
        return $this->transactionTable
          ->select()
            ->select('users.phone_number as phoneNumber ,users.first_name as firstName ,users.last_name as lastName,customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number,calibrated_tanks.vehicle_brand,calibrated_tanks.amount,calibrated_tanks.id as trailer_id,transactions.payment')
            //  ->where(['customers.region' => $region])
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('calibrated_tanks', 'calibrated_tanks.id = transactions.instrument_id')
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
            ->join('customers', 'customers.hash = vtc.customer_hash')
            ->get()
            ->getRow();
    }

    // ================Get all details in all regions==============
    public function getAllInRegion($location)
    {

        return $this->transactionTable
            ->select('transactions.id,calibrated_tanks.amount,payment,customers.region')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('calibrated_tanks', 'calibrated_tanks.id = transactions.instrument_id')
            ->where(['customers.region' => $location])
            ->get()
            ->getResult();
    }

    // ================Api for a specific region==============

    public function getData($region)
    {
        return $this->transactionTable
            ->select('customers.region,calibrated_tanks.registration_date,calibrated_tanks.amount,payment')
            ->where(['customers.region' => $region])
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('calibrated_tanks', 'calibrated_tanks.id = transactions.instrument_id')
            ->get()
            ->getResult();
    }

    // ================Data for Api for entire country (DIRECTOR) ==============
    public function getFullDataForDirector()
    {
        return $this->transactionTable
            ->select('calibrated_tanks.amount,payment,calibrated_tanks.registration_date')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('calibrated_tanks', 'calibrated_tanks.id = transactions.instrument_id')

            ->get()
            ->getResult();
    }

    public function vtcDetails($location)
    {
        return $this->transactionTable
            ->select('calibrated_tanks.amount,payment,calibrated_tanks.registration_date,calibrated_tanks.id,customers.region')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('calibrated_tanks', 'calibrated_tanks.id = transactions.instrument_id')

            ->where(['customers.region' => $location])
            ->get()
            ->getResult();
    }

    //=================DATA FOR THE REPORTS====================




    #--------------------------------------------------------
    #
    # ONLY WITHIN A QUARTER
    #
    #--------------------------------------------------------------

    public function payment()
    {
    }
    //=================%% quarter report %%====================
    public function vtcQuarterReport($params, $monthFrom, $monthTo)
    {
        return $this->transactionTable
            ->select('users.first_name as fName,users.last_name as lName')
            ->select('customers.name,customers.region,customers.phone_number,calibrated_tanks.vehicle_brand,calibrated_tanks.trailer_plate_number,calibrated_tanks.capacity,calibrated_tanks.amount as vehicle_amount')
            ->select('instrument_id,transactions.payment,calibrated_tanks.amount,control_number,transactions.created_on')
            ->where($params)
            ->where('MONTH(created_on) BETWEEN ' . $monthFrom . ' AND ' . $monthTo . '')


            ->orderBy('created_on', 'ASC')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('calibrated_tanks', 'calibrated_tanks.id = transactions.instrument_id')
            ->get()
            ->getResult();
    }


    ####################################################################
    ##########################WITHIN A MONTH ##########################
    ##################################################################
    public function dataReport($params)
    {
        return $this->transactionTable
            ->select('users.first_name as fName,users.last_name as lName')
            ->select('customers.name,customers.phone_number,calibrated_tanks.vehicle_brand,calibrated_tanks.trailer_plate_number,calibrated_tanks.capacity,calibrated_tanks.amount as vehicle_amount')
            ->select('instrument_id,transactions.payment,calibrated_tanks.amount,control_number,transactions.created_on')
            ->where($params)
            ->orderBy('created_on', 'ASC')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('calibrated_tanks', 'calibrated_tanks.id = transactions.instrument_id')
            ->get()
            ->getResult();
    }

    public function collectionSum($params)
    {
        return $this->transactionTable
            ->selectSum('calibrated_tanks.amount')

            ->where($params)
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('calibrated_tanks', 'calibrated_tanks.id = transactions.instrument_id')
            ->get()
            ->getResult();
    }

    public function dateRangeReport($params, $dateFrom, $dateTo)
    {
        return $this->transactionTable
            ->select('users.first_name as fName,users.last_name as lName')
            ->select('customers.name,customers.phone_number,calibrated_tanks.vehicle_brand,calibrated_tanks.trailer_plate_number,calibrated_tanks.capacity,calibrated_tanks.amount as vehicle_amount')
            ->select('instrument_id,transactions.payment,calibrated_tanks.amount,control_number,transactions.created_on')
            ->where($params)
            ->where(['created_on >=' => $dateFrom])
            ->where(['created_on <=' => $dateTo])
            ->orderBy('created_on', 'ASC')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('calibrated_tanks', 'calibrated_tanks.id = transactions.instrument_id')
            ->get()
            ->getResult();
    }





    //=================SEARCHING FUNCTION====================
    public function searchingVtc()
    {
        return $this->transactionTable

            ->select('
       calibrated_tanks.id,
       calibrated_tanks.activity,
       calibrated_tanks.region,
       calibrated_tanks.date_created,
       calibrated_tanks.next_calibration,
       calibrated_tanks.tin_number,
      
       calibrated_tanks.driver_name,
       calibrated_tanks.driver_license,
       calibrated_tanks.vehicle_brand,
       calibrated_tanks.trailer_plate_number,
       calibrated_tanks.capacity,
       calibrated_tanks.status,
       calibrated_tanks.sticker_number,
       calibrated_tanks.amount,
       calibrated_tanks.other_charges,
       calibrated_tanks.remark,


       users.first_name as officerFirstName,
       users.last_name as officerLastName



       ')

            ->select('customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number,calibrated_tanks.vehicle_brand')
            ->join('customers', 'customers.hash = transactions.customer_hash')
            ->join('calibrated_tanks', 'calibrated_tanks.id = transactions.instrument_id', 'right')
            ->join('users', 'users.unique_id = transactions.unique_id')
            ->get()
            ->getResultArray();
    }

    //=================get vehicle after searching====================
    public function vehicleMatch($id)
    {
        return $this->calibratedTanks
            ->select(
                '

       calibrated_tanks.activity,
       calibrated_tanks.region,
       calibrated_tanks.registration_date,
       calibrated_tanks.next_calibration,
       calibrated_tanks.tin_number,
      
       calibrated_tanks.driver_name,
       calibrated_tanks.driver_license,
       calibrated_tanks.vehicle_brand,
       calibrated_tanks.trailer_plate_number,
       calibrated_tanks.capacity,
       calibrated_tanks.status,
       calibrated_tanks.sticker_number,
       calibrated_tanks.amount,
       calibrated_tanks.other_charges,
       calibrated_tanks.remark,
       transactions.control_number,
       transactions.payment,


       users.first_name as officerFirstName,
       users.last_name as officerLastName

        '
            )
            ->select('customers.name,customers.region,customers.district,customers.ward,customers.village,customers.postal_address,customers.phone_number,calibrated_tanks.vehicle_brand')
            ->where(['calibrated_tanks.id' => $id])
            ->join('transactions', 'calibrated_tanks.id = transactions.instrument_id')
            ->join('customers', 'customers.hash = calibrated_tanks.hash')
            ->join('users', 'users.unique_id = calibrated_tanks.unique_id')
            ->get()
            ->getRow();
    }
}
