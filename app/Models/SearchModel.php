<?php

namespace App\Models;

use CodeIgniter\Model;

class SearchModel extends Model
{
    protected $billTable;
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->billTable = $this->db->table('bill');
    }


    //creating new customer
    public function createBill($data)
    {
        return $this->billTable->insertBatch($data);
    }
    //update customer
    public function updateBill($hash, $data)
    {
        return $this->billTable
            ->where(['hash' => $hash])
            ->update($data);
    }
    //searching existing customer
    public function searchItem($keyword, $activity)
    {

        $tableToJoin = '';
        $id = '';

        $items = '';



        $builder = $this->db->table('transactions');

        switch ($activity) {
            case 'prepackage':
                $id .= 'product_id';
                $tableToJoin .= 'prepackage';
                $items .= 'commodity,quantity,unit';
                $builder->join('product_details', "product_details.id = transactions.instrument_id");
                break;

            case 'vtv':
                $tableToJoin .= 'calibrated_tanks';
                $id .= 'id';
                // $items .= "vehicle_brand,' ',hose_plate_number,trailer_plate_number,' ',capacity";
                $items .= "vehicle_brand,hose_plate_number,trailer_plate_number,CONCAT(capacity, ' ','Liters')";

                break;


            case 'sbl':
                $tableToJoin .= 'sandy_lorries_records';
                $id .= 'id';
                // $items .= "vehicle_brand,' ',hose_plate_number,trailer_plate_number,' ',capacity";
                $items .= "vehicle_brand,plate_number,CONCAT(capacity, ' ','m<sup>3</sup>')";


                break;
            case 'waterMeters':
                $tableToJoin .= 'water_meters';
                $id .= 'id';
                $items .= "brand,CONCAT(flow_rate, ' ','m<sup>3</sup>/h'),CONCAT(quantity,' ','Meters')";
                break;

            default:
                # code...
                break;
        }
        $builder->join($tableToJoin, "$tableToJoin.$id = transactions.instrument_id");
        $builder->join('customers', "customers.hash = transactions.customer_hash");

        $builder->like(['customers.name' => $keyword]);
        $builder->orLike(['customers.phone_number' => $keyword]);
        if ($activity == 'vtv' ) {

            $builder->orLike(['hose_plate_number' => $keyword])->orLike(['trailer_plate_number' => $keyword]);
        }else if($activity == 'sbl'){
            $builder->orLike(['plate_number' => $keyword]);

        }




        $builder->select(
            "$tableToJoin.hash,
      transactions.id,
      transactions.amount as total,
      name,phone_number,
      control_number,
      payment,
      $tableToJoin.amount,
      transactions.created_on,
      CONCAT_WS(' ',$items) as item
      "
        );
        // $builder->select();
        $builder->orderBy('transactions.id', 'DESC');
        // $builder->groupBy('control_number');


        return $builder->get()->getResult();
        // return $builder->getCompiledSelect();
    }






    //get single Item 
    public function selectItem($identifier, $activity)
    {
        $tableToJoin = '';
        $id = '';

        $items = '';
        $columns = '';



        $builder = $this->db->table('transactions');

        switch ($activity) {
            case 'prepackage':
                $id .= 'product_id';
                $tableToJoin .= 'prepackage';
                $items .= 'commodity,quantity,unit';
                $builder->join('product_details', "product_details.id = transactions.instrument_id");
                break;

            case 'vtv':
                $tableToJoin .= 'calibrated_tanks';
                $id .= 'id';
                $items .= "vehicle_brand,hose_plate_number,trailer_plate_number,CONCAT(capacity, ' ','Liters')";
                $columns .= 'sticker_number,DATE_FORMAT(registration_date,"%d %M %Y") as calibratedOn,DATE_FORMAT(next_calibration,"%d %M %Y") as nextCalibration,';
                break;
            case 'sbl':
                $tableToJoin .= 'sandy_lorries_records';
                $id .= 'id';
                $items .= "vehicle_brand,hose_plate_number,trailer_plate_number,CONCAT(capacity, ' ','m<sup>3</sup>')";
                $columns .= 'sticker_number,DATE_FORMAT(registration_date,"%d %M %Y") as calibratedOn,DATE_FORMAT(next_calibration,"%d %M %Y") as nextCalibration,';
                break;
            case 'waterMeters':
                $tableToJoin .= 'water_meters';
                $id .= 'id';
                $items .= "brand,CONCAT(flow_rate, ' ','m<sup>3</sup>/h'),CONCAT(quantity,' ','Meters')";
                break;

            default:
                # code...
                break;
        }
        $builder->join($tableToJoin, "$tableToJoin.$id = transactions.instrument_id");
        $builder->join('customers', "customers.hash = transactions.customer_hash");
        $builder->join('users', "users.unique_id = transactions.unique_id");

        $builder->where(['transactions.id' => $identifier]);
        // $builder->where(['payment' => 'pending']);

        $builder->select(
            "$tableToJoin.hash,
      transactions.id,
      transactions.amount as total,
      transactions.paid_amount as paid,
      name,
      customers.phone_number,
      customers.region,
      control_number,
      payment,
      $columns
      $tableToJoin.amount,
      transactions.created_on,
      transactions.updated_at as paymentDate,
      CONCAT_WS(' ',$items) as item,
      CONCAT(users.first_name,' ',users.last_name) as creator
      "
        );
        // $builder->select();


        return $builder->get()->getResult();
    }



    //get latest inserted customer hash 
    public function lastHash()
    {

        return $this->billTable
            ->select('id,hash')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()
            ->getResult();
    }
}
