<?php

namespace App\Controllers;

use App\Models\ProfileModel;
use App\Libraries\BillLibrary;
use App\Models\PrePackageModel;
use App\Libraries\PrePackageLibrary;
use App\Libraries\CommonTasksLibrary;



class PrePackageController extends BaseController
{
    protected $uniqueId;
    protected $managerId;
    protected $role;
    protected $city;
    protected $PrePackageModel;
    protected $session;
    protected $profileModel;
    protected $CommonTasks;
    protected $appRequest;
    protected $prePackageLibrary;
    protected $billLibrary;
    protected $token;

    public function __construct()
    {
        $this->appRequest = service('request');
        $this->PrePackageModel = new PrePackageModel();
        $this->profileModel = new ProfileModel();
        $this->prePackageLibrary = new PrePackageLibrary();
        $this->billLibrary = new BillLibrary();
        $this->session = session();
        $this->token = csrf_hash();
        $this->uniqueId = $this->session->get('loggedUser');
        $this->managerId = $this->session->get('manager');
        $this->role = $this->profileModel->getRole($this->uniqueId)->role;
        $this->city = $this->session->get('city');
        $this->CommonTasks = new CommonTasksLibrary();
        helper(['form', 'array', 'regions', 'date', 'prePackage_helper', 'image', 'url']);
    }

    public function getVariable($var)
    {
        return $this->request->getVar($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function index()
    {
        $data['page'] = [
            "title" => "Pre Package",
            "heading" => "Pre Package",
        ];


        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['role'] = $role;
        // return view('Pages/Prepackage/prepackage', $data);
        return view('Pages/Prepackage/prepackaging', $data);
    }

    public function listPrepackage()
    {
        $data['page'] = [
            "title" => "Pre Package",
            "heading" => "Pre Package",
        ];


        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['role'] = $role;
        $data['prePackageData'] = $this->prePackageLibrary->formatDataset($this->PrePackageModel->prePackageData($uniqueId));
        // return view('Pages/Prepackage/prepackage', $data);
        return view('Pages/Prepackage/listPrepackage', $data);
    }

    public function addPrePackageCustomer()
    {

        $token = csrf_hash();
        if ($this->request->getMethod() == 'post') {


            // $hash = md5(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890' . time()));
            $hash = randomString();
            $customer = [
                "hash" => $hash,
                "name" => $this->getVariable('name'),
                "region" => $this->getVariable('region'),
                "district" => $this->getVariable('district'),
                "physical_address" => $this->getVariable('physicalAddress'),
                "postal_address" => $this->getVariable('postalAddress'),
                "postal_code" => $this->getVariable('postalCode'),
                "location" => $this->getVariable('location'),
                "village" => $this->getVariable('village'),
                "phone_number" => $this->getVariable('phoneNumber'),
                "unique_id" => $this->uniqueId,

            ];

            // return $this->response->setJSON([
            //     'data' => $customer,
            //     'token' => $token,

            // ]);
            // exit;
            $request = $this->PrePackageModel->addCustomer($customer);
            // $lastHash = $this->PrePackageModel->lastHash();

            if ($request) {
                return $this->response->setJSON([
                    'status' => 1,
                    'hash' => $this->PrePackageModel->lastHash()[0]->hash,
                    'msg' => 'Customer Added',
                    'token' => $this->token,

                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Something went wrong',
                    'token' => $this->token,

                ]);
            }
        }
    }



    //=================searching existing customer====================
    public function searchCustomer()
    {

        $keyword = $this->getVariable('keyword');
        $request = $this->PrePackageModel->searchCustomer($keyword);
        if (count($request) > 0) {
            return $this->response->setJSON([
                'status' => 1,
                'data' => $request,
                'token' => $this->token
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'data' => [],
                'token' => $this->token
            ]);
        }
    }

    public function getPrePackageCustomer()
    {


        $hash = $this->getVariable('hash');



        $products  = $this->PrePackageModel->getPaidProducts($hash);


        //===============================================================================


        $request = $this->PrePackageModel->getCustomerInfo($hash);
        if ($request) {
            return $this->response->setJSON([
                'products' =>  $products,
                'status' => 1,
                'data' => $request,
                'token' => $this->token
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'data' => '',
                'token' => $this->token
            ]);
        }
    }
    public function editPrePackageCustomer()
    {


        $hash = $this->getVariable('hash');
        // $ids = [];

        // $billedProducts =   $this->PrePackageModel->getBilledProducts($hash);
        $billedProducts = $this->PrePackageModel->getPaidProducts($hash);


        if (count($billedProducts) == 0) {



            return $this->response->setJSON([
                'status' => count($billedProducts) == 0 ? 0 : 1,
                'products' => $this->PrePackageModel->getProducts($hash),
                'data' => $this->PrePackageModel->getCustomerInfo($hash),
                'token' => $this->token
            ]);
        } else {

            // foreach ($billedProducts as $id) {
            //     array_push($ids, $id->product_id);
            // }
            $billedProductIds = array_map(fn ($id) => $id->product_id, $billedProducts);

            $products  = $this->PrePackageModel->getUnpaidProducts($hash, $billedProductIds);
        }



        //===============================================================================


        $request = $this->PrePackageModel->getCustomerInfo($hash);
        if ($request) {
            return $this->response->setJSON([
                'products' =>  $products,
                'status' => 1,
                'data' => $request,
                'token' => $this->token,
                'billedProductIds' =>  $billedProductIds
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'data' => '',
                'token' => $this->token
            ]);
        }
    }
    public function checkMeasurements($measurements, $category, $sampleSize)
    {
        $quantity = count($measurements);

        $categories1 = ['Area', 'General', 'Bread', 'Poultry', 'Count', 'Linear', 'Cubic', 'Seeds', 'Medical_Gases', 'Gases', 'Anthracite', 'Fruits', 'Sheets'];

        $categories2 = ['Area_Linear', 'Linear 2', 'Area & Linear'];

        if (in_array($category, $categories1)) {
            if ($quantity != $sampleSize) {
                return false;
            } else {
                return true;
            }
        } else if (in_array($category, $categories2)) {
            if ($quantity <= $sampleSize) {
                return false;
            } else {
                return true;
            }
        }
    }


    public function selectProduct()
    {
        //px1
        // $sampleSize = 20;
        $productId = $this->getVariable('id');
        //  $quantityId = $this->getVariable('quantityId');
        $sampleSize = (int)$this->PrePackageModel->selectProduct($productId)->sample_size;
        $category = $this->PrePackageModel->selectProduct($productId)->analysis_category;
        $params = [
            'product_id' => $productId,
            // 'quantity_id' => $measurementId
        ];
        $measurements = $this->PrePackageModel->getMeasurementData($params);
        $set1Measurements = array_slice($measurements, 0, $sampleSize);
        $set2Measurements = array_slice($measurements, $sampleSize);
        $measurementIds = [
            $set1Measurements ? $set1Measurements[0]->quantity_id : '',
            $set2Measurements ? $set2Measurements[0]->quantity_id : '',

        ];

        $idz = array_filter($measurementIds, fn ($id) => $id != '');

        $request = $this->PrePackageModel->selectProduct($productId);
        if ($request) {
            return $this->response->setJSON([
                'status' => 1,
                'sampleSize' => $sampleSize,
                'quantityIds' =>  $idz,
                'measurements' =>  $this->checkMeasurements($measurements, $category, $sampleSize),
                'set 1' => $set1Measurements,
                'set 2' => $set2Measurements,
                'data' => $request,
                'ms qty' => count($measurements),
                'category' => $category,
                // 'sampleSize' => $sampleSize, 
                'token' => $this->token,
                //'num' => numString(20),
                'num' => time(),
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'data' => '',
                'token' => $this->token
            ]);
        }
    }





    // ================Adding customer lorry information to database ==============

    public function addProductDetails()
    {

        //=================Checking the last id its available====================

        if ($this->request->getMethod() == 'post') {
            $hash = $this->getVariable('customerId');

            $quantity_2 = $this->getVariable('quantity2');
            $unit_2 = $this->getVariable('unit2');
            $grossQuantity = $this->getVariable('grosValue');
            $unit = $this->getVariable('unit');
            $type = $this->getVariable('type');
            $tansardDocument = $this->request->getFile('tansardDocument');
            $tansardFile = '';



            if ($type == 'Imported') {
                $tansardFile .= $this->CommonTasks->processFile($tansardDocument);
            } else {
                $tansardFile = '';
            }




            $productDetails = [
                'hash' => $hash,
                'type' => $type,
                'commodity' => $this->getVariable('commodity'),
                'activity' => $this->getVariable('activityType'),
                'quantity' => $this->getVariable('quantity'),
                'unit' => $unit,
                'quantity_2' => $quantity_2,
                'unit_2' => $unit_2,

                'quantity1_id' => numString(10) . '-' . $grossQuantity . $unit,
                'quantity2_id' => $quantity_2 != '' ? numString(10) . '-' . $quantity_2 . $unit_2 : '',
                'ref_number' => $this->getVariable('refNumber'),

                //  Imported
                'tansard_number' => $type == 'Imported' ? $this->getVariable('tansardNumber') : '',
                'tansard_file' => $tansardFile,
                'fob' => $this->getVariable('fob'),
                'date' => dateFormatter($this->getVariable('date')),






                'batch_number' => $this->getVariable('batchNumber'),
                'analysis_category' => $this->getVariable('categoryAnalysis'),
                'packing_declaration' => $this->getVariable('packingDeclaration'),
                'lot' => $this->getVariable('batchSize'),
                'method' => $this->getVariable('method'),
                'measurement_unit' => $this->getVariable('measurementUnit'),
                'sampling' => $this->getVariable('sampling'),
                'measurement_nature' => $this->getVariable('measurementNature'),
                'tare' => $this->getVariable('tareWeight'),
                'product_nature' => $this->getVariable('productNature'),
                'density' =>  $this->getVariable('density'),
                'gross_quantity' => $this->getVariable('grosValue'),
                'sample_size' => $this->getVariable('sampleSize'),

                //labeling
                'packer_identification' => $this->getVariable('packerIdentification'),
                'product_identification' => $this->getVariable('productIdentification'),
                'correct_unit' => $this->getVariable('correctUnit'),
                'correct_symbol' => $this->getVariable('correctSymbol'),
                'correct_height' => $this->getVariable('correctHeight'),
                'correct_quantity' => $this->getVariable('correctQuantity'),
                'general_appearance' => $this->getVariable('generalAppearance'),
                'recommendation' => $this->getVariable('recommendation'),



                'unique_id' => $this->uniqueId,

            ];

            // echo json_encode($productDetails);
            // exit;
            $ids = [];

            $request = $this->PrePackageModel->addProductDetails($productDetails);

            if ($request) {

                $billedProducts =   $this->PrePackageModel->getBilledProducts($hash);

                if (count($billedProducts) == 0) {



                    return $this->response->setJSON([
                        'status' =>  1,
                        'msg' => 'Product Added Successfully!',
                        'products' => $this->PrePackageModel->getProducts($hash),
                        // 'products' =>   $this->PrePackageModel->getUnpaidProducts($hash, $billedProducts),
                        'lastProduct' =>  $this->PrePackageModel->getProducts($hash)[0],
                        'data' => $this->PrePackageModel->getCustomerInfo($hash),
                        'token' => $this->token
                    ]);
                } else {


                    // foreach ($billedProducts as $id) {

                    //     array_push($ids, $id->instrument_id);
                    // }
                    $billedProductIds = array_map(fn ($id) => $id->instrument_id, $billedProducts);

                    $products  = $this->PrePackageModel->getUnpaidProducts($hash, $billedProductIds);
                    return $this->response->setJSON([
                        'status' => 1,
                        'msg' => 'Product Added Successfully!',
                        'lastProduct' =>  $this->PrePackageModel->getProducts($hash)[0],
                        //px
                        'products' =>  $products,
                        'token' => $this->token
                    ]);
                }


                // echo json_encode($billedProducts);
                // exit;

                // $products =  $this->PrePackageModel->getUnpaidProducts($hash, $ids);


            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Something Went Wrong 1111!',
                    'token' => $this->token
                ]);
            }
        }
    }




    // get products with measurement data but they are not in billing table
    public function getCompleteProducts()
    {
        $ids = [];
        if ($this->request->getMethod() == 'post') {
            $hash = $this->getVariable('customerId');

            $billedProducts =   $this->PrePackageModel->getBilledProducts($hash);


            if (count($billedProducts) == 0) {



                return $this->response->setJSON([
                    'status' => count($billedProducts) == 0 ? 0 : 1,
                    'products' =>   $this->PrePackageModel->getProducts($hash),
                    'Hello' => 'world',
                    'token' => $this->token
                ]);
            } else {

                foreach ($billedProducts as $id) {
                    array_push($ids, $id->instrument_id);
                }

                $billedProductIds = array_map(fn ($id) => $id->instrument_id, $billedProducts);

                // $p  = $this->PrePackageModel->getProductId($hash, $ids);

                $products = $this->PrePackageModel->getUnpaidProducts($hash, $billedProductIds);
                // echo json_encode($billedProducts);

                // exit;


                return $this->response->setJSON([

                    'status' => 1,
                    'products' =>   $products,
                    'token' => $this->token
                ]);
            }
        }
    }
    //check if measurement is already created

    public function checkQuantityId()
    {
        if ($this->request->getMethod() == 'post') {
            $id = $this->getVariable('quantityId');
            $productId = $this->getVariable('productId');
            $product = $this->PrePackageModel->selectProduct($productId);
            $quantity1 = $product->quantity;
            $current = substr(preg_replace('/[^0-9]/', '', $id), 10);
            $category = $product->analysis_category;
            $switch = $category == 'Area_Linear' && ($current < $quantity1) ? true : false;

            // return $this->response->setJSON([
            //    'q1' =>$quantity1 ,
            //     'current' => $current ,
            //     'switch' => $switch , 
            // ]);

            // exit;

            $request = $this->PrePackageModel->checkQuantityId($id);
            if ($request) {
                return $this->response->setJSON([

                    'status' => 1,
                    'qId' => $id,
                    'token' => $this->token,
                    'switch' => $switch,
                    'current' => $current,
                    'quantity1' => $quantity1,
                    'sampleSize' => (int)$product->sample_size,


                ]);
            } else {
                return $this->response->setJSON([
                    'qId' => $id,
                    'current' => $current,
                    'quantity1' => $quantity1,
                    'status' => 0,
                    'id' => $id,
                    'token' => $this->token,
                    'switch' => $switch,
                    'sampleSize' => (int)$product->sample_size,

                ]);
            }
        }
    }

    // grab all products with complete measurements
    public function getProductsWithMeasurements()
    {

        if ($this->request->getMethod() == 'post') {

            // $measurementIds  = $this->PrePackageModel->getMeasurementData();
            $hash = $this->getVariable('customerId');
            $activity = $this->getVariable('activity');
            $inspectionType = $this->getVariable('inspectionType');


            $params = [
                'product_details.hash' => $hash,
                'product_details.activity' => $activity,
                'product_details.type' => $inspectionType,
            ];

            $products = $this->PrePackageModel->getCustomerProducts($params);

            // echo json_encode($params);
            // exit;


            //create a array of ids of customers products
            $idz = array_map(function ($id) {
                return $id->id;
            }, $products);

            // get the products based on id array
            $fromMeasurements = $this->PrePackageModel->getProductsWithMeasurements($idz == [] ? ['_0_'] : $idz, $hash);



            //removing the duplicates
            $arr = array_map("unserialize", array_unique(array_map("serialize", $fromMeasurements)));
            $idx = array_map(function ($x) {
                return $x->id;
            }, $arr);

            $prod = $this->PrePackageModel->grabProducts($idx ? $idx : ['_0_'], $hash);
            $customerProducts  = array_values($arr);

            $billed = array_map(function ($p) {
                return $p->id;
            }, $prod);

            // remove every billed product
            function removeBilledProducts($array, $values)
            {
                foreach ($values as $v) {

                    foreach ($array as $subKey => $subArray) {

                        if ($subArray->id == $v) {
                            unset($array[$subKey]);
                        }
                    }
                }

                return array_values($array);
            }


            $theProducts = removeBilledProducts($customerProducts, $billed);




            $productsArr = array_map(function ($item) {
                // $params2 = [
                //     'product_id' => $item->product_id,
                //     //'quantity_id' => $item->quantity_id
                // ];
                $product = $this->PrePackageModel->selectProduct($item->product_id);
                $category = $product->analysis_category;
                $measurements = $this->PrePackageModel->getMeasurementData(['product_id' => $item->product_id]);

                // return $measurements;/
                $sampleSize = $item->sample_size;
                // $sampleSize = 100;

                $set1Measurements = array_slice($measurements, 0, $sampleSize);
                $set2Measurements = array_slice($measurements, $sampleSize);







                $set1Status = $this->prePackageLibrary->processingMeasurements($set1Measurements);


                $set2Status =
                    !empty($set2Measurements) ? $this->prePackageLibrary->processingMeasurements($set2Measurements) : [];

                $status = $this->prePackageLibrary->evaluateStatus($set1Status, $set2Status);

                return [
                    'commodity' => $item->commodity . ' ' . $item->quantity . ' ' . $item->unit,
                    'hash' => $item->hash,
                    'id' => $item->product_id,
                    'lot' => $item->lot,
                    'type' => $item->type,
                    'fob' => $item->fob,
                    'tansardNumber' => $item->tansard_number,
                    'date' => $item->date,
                    'activity' => $item->activity,
                    'measurements' => $this->PrePackageModel->getMeasurementData($item->product_id, $category),
                    'measurements' => $set1Measurements,
                    'measurements two' => $set2Measurements,
                    // 'item' => $item,



                    'result' => $status,
                    'status 1' =>  $set1Status,
                    'status 2' =>  $set2Status,
                    // 'PRODUCT STATUS' => $status
                ];
            }, $theProducts);



            // echo json_encode($productsArr);
            // exit;

            return $this->response->setJSON([

                'status' => 1,
                'billed' => $billed,
                'products' => $productsArr,
                'type' => $inspectionType,
                // 'idx' => array_values($idx),
                // '' => removeBilledProducts($customerProducts, $billed) ,
                'token' => $this->token
            ]);
        }
    }


    public function getProducts()
    {
        $ids = [];
        if ($this->request->getMethod() == 'post') {
            $hash = $this->getVariable('customerId');

            $products =   $this->PrePackageModel->getTheProducts($hash);


            return $this->response->setJSON([

                'status' => 1,
                'products' =>   $products,
                'token' => $this->token
            ]);
        }
    }
    function getProductInfo($id)
    {
        $product = $this->PrePackageModel->selectProduct($id);
        return  $product->commodity . ' ' . $product->quantity . ' ' . $product->unit;
    }
    public function createBill()
    {

        $billingData =  [];
        $transactionData =  [];
        if ($this->request->getMethod() == 'post') {
            $hash = $this->getVariable('customerHash');
            $controlNumber = $this->getVariable('controlNumber');
            $totalAmount = $this->getVariable('totalAmount');
            $activityType = $this->getVariable('activityType');



            //crating ids to match length of the data set
            // $amountArray = [];
            // for ($i = 0; $i < count($hash); $i++) {
            //     array_push($amountArray, (int)$totalAmount);
            // }
            //crating ids to match length of the data set
            //quantity_id
            $amountArray = [];
            $controlNumberArray = [];
            $uniqueIds = [];
            $activityArray = [];
            $activityArray = [];
            $quantityIdArray = [];
            for ($i = 0; $i < count($hash); $i++) {
                array_push($amountArray, (int)$totalAmount);
                array_push($controlNumberArray, $controlNumber);
                array_push($uniqueIds, $this->uniqueId);
                array_push($activityArray, $activityType);
            }




            $data = [
                'hash' => $hash,
                'product_id' => $this->getVariable('prodId'),
                'unique_id' => $uniqueIds,
                'amount' =>  $activityType == 'Inspection' ? $amountArray : $this->getVariable('prodMount'),
                // 'activity_type' =>  $activityArray,
            ];



            $transaction = [
                'customer_hash' => $hash,
                'instrument_id' => $this->getVariable('prodId'),
                'control_number' => $controlNumberArray,
                'unique_id' => $uniqueIds,
                'amount' => $amountArray,
                // 'activity_type' =>  $activityArray,
            ];



            // creating multidimensional array for batch insertion
            foreach ($data as $key => $value) {
                for ($i = 0; $i < count($value); $i++) {
                    $billingData[$i][$key] = $value[$i];
                }
            }

            foreach ($transaction as $key => $value) {
                for ($i = 0; $i < count($value); $i++) {
                    $transactionData[$i][$key] = $value[$i];
                }
            }
            // $bill = array_map(fn () => [
            //     'customer' => $this->PrePackageModel->getCustomerInfo($hash[0]),
            //     'products' => $billingData
            // ], $transactionData);

            $products = array_map(fn ($product) =>
            [


                'product' =>  $this->getProductInfo($product['product_id']),
                'amount' => number_format($product['amount']),

            ], $billingData);
            $user = $this->profileModel->getLoggedUserData($this->uniqueId);

            $bill =  [
                'controlNumber' => $transaction['control_number'][0],
                'paymentRef' => time(),
                'payer' => $this->PrePackageModel->getCustomerInfo($hash[0]),
                'products' => $products,
                'billTotal' => 'Tsh ' . number_format($totalAmount) . ' (TZS)',
                'billTotalInWords' =>  toWords($totalAmount),
                'createdBy' => $user->first_name . ' ' . $user->last_name,
                'printedBy' => $user->first_name . ' ' . $user->last_name,
                'printedOn' => date('d M Y'),

            ];
            // return $this->response->setJSON(['status' => 1, 'bill' => $bill]);

            // exit;

            $request1 = $this->PrePackageModel->createBill($billingData);
            $request2 = $this->PrePackageModel->createPrePackageBill($transactionData);
            if ($request1 && $request2) {
                return $this->response->setJSON([
                    'status' => 1,
                    'msg' => 'Bill Created successfully',
                    //'data' => $transactionData,
                    'bill' => $bill,
                    'token' => $this->token
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Something went wrong! ',
                    'token' => $this->token
                ]);
            }
        }
    }

    //=================save measurement sheet data ====================
    public function saveMeasurementData()
    {
        if ($this->request->getMethod() == 'post') {

            $measurementData = [];
            $idArray = [];
            $quantityIdArray = [];
            // $gross = $this->getVariable('weightGross');
            $switcher = $this->getVariable('switcher');
            $comment = $this->getVariable('comment');
            $status = $this->getVariable('status');
            $commodityId = $this->getVariable('commodityId');
            $commodityCategory = $this->getVariable('commodityCategory');

            $category = '';

            $commodityCategory =
                $switcher != '' ?   $category .= 'Linear' : $category .= $commodityCategory;
            $quantityId =  $this->getVariable('currentQuantity');


            //crating ids to match length of the data set
            for ($i = 0; $i < count($comment); $i++) {
                array_push($idArray, $commodityId);
                array_push($quantityIdArray, $quantityId);
            }


            // return $this->response->setJSON([
            //     'data' => $quantityIdArray,

            //    // 'token' => $this->token
            // ]);
            // exit;
            $data = null;
            switch ($category) {
                case 'General':
                case 'Linear':
                case 'Linear 2':
                case 'Count':
                case 'Fruits':
                case 'Bread':
                case 'Poultry':
                case 'Gases':
                case 'Seeds':
                case 'Sheets':
                case 'Anthracite':
                    $data = [
                        'gross_quantity' => $this->getVariable('weightGross'),
                        'net_quantity' => $this->getVariable('weightNet'),
                        'comment' => $comment,
                        'status' => $status,
                        'product_id' => $idArray,
                        'quantity_id' => $quantityIdArray,
                    ];
                    break;
                case 'Area':
                case 'Area_Linear':
                    $data = [
                        'length' => $this->getVariable('length'),
                        'width' =>  $this->getVariable('width'),
                        'net_quantity' =>  $this->getVariable('area'),
                        'comment' => $comment,
                        'status' => $status,
                        'product_id' => $idArray,
                        'quantity_id' => $quantityIdArray,
                    ];
                    break;
                case 'Cubic':
                    $data = [
                        'length' => $this->getVariable('length'),
                        'width' =>  $this->getVariable('width'),
                        'height' =>  $this->getVariable('height'),
                        'net_quantity' =>  $this->getVariable('volume'),
                        'comment' => $comment,
                        'status' => $status,
                        'product_id' => $idArray,
                        'quantity_id' => $quantityIdArray,
                    ];
                    break;

                default:
                    # code...
                    break;
            }

            // $data = [
            //     'gross_quantity' => $gross,
            //     'net_quantity' => $net,
            //     'comment' => $comment,
            //     'status' => $status,
            //     'product_id' => $idArray,
            // ];




            // creating multidimensional array for batch insertion
            foreach ($data as $key => $value) {
                for ($i = 0; $i < count($value); $i++) {
                    $measurementData[$i][$key] = $value[$i];
                }
            }


            // return $this->response->setJSON([
            //     'data' => $measurementData,
            //     'token' => $this->token
            // ]);

            // exit;



            $request = $this->PrePackageModel->addMeasurementSheetData($measurementData);
            if ($request) {
                return $this->response->setJSON([
                    'status' => 1,
                    'msg' => 'Data inserted successfully',
                    'commodityId' => $commodityId,
                    'token' => $this->token
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'commodityId' => $commodityId,
                    'msg' => 'something went wrong ',
                    'token' => $this->token
                ]);
            }
        }
    }


    public function getMeasurementData()
    {
        if ($this->request->getMethod() == 'post') {

            $productId = $this->getVariable('productId');
            $quantityId = $this->getVariable('quantityId');
            $product = $this->PrePackageModel->selectProduct($productId);
            $category = $product->analysis_category;
            $sampleSize = (int)$product->sample_size;
            $params = [
                'product_id' => $productId,
                'quantity_id' => $quantityId
            ];
            // return json_encode($params);
            // exit;
            $data = $this->PrePackageModel->getMeasurementData($params);



            $measurements = $this->PrePackageModel->getMeasurementData(['product_id' => $productId]);
            $set1Measurements = array_slice($measurements, 0, $sampleSize);
            $set2Measurements = array_slice($measurements, $sampleSize);

            // $measurementIds = [
            //     $set1Measurements ? $set1Measurements[0]->quantity_id : '',
            //     $set2Measurements ? $set2Measurements[0]->quantity_id : '',

            // ];

            $set1StatusArray = $this->prePackageLibrary->processingMeasurements($set1Measurements);
            $set2StatusArray  = !empty($set2Measurements) ? $this->prePackageLibrary->processingMeasurements($set2Measurements) : [];



            $set1Status = $this->prePackageLibrary->evaluateStatus($set1StatusArray);
            $set2Status = $this->prePackageLibrary->evaluateStatus($set2StatusArray);

            $product = $this->PrePackageModel->selectProduct($productId);
            $category = $product->analysis_category;
            $quantity1 = $product->quantity . ' ' . $product->unit;
            $quantity2 = $product->quantity_2 . ' ' . $product->unit_2;

            $declaredQuantity = preg_replace('/[^0-9]/', '', substr($quantityId, 11));

            $switch = '';
            $declaredQuantity == $product->quantity_2  ? $switch .= 1 : $switch .= 0;
            $dataSet = [
                'status' => 1,
                'switcher' =>  $switch,
                'data' => $data,

                'token' => $this->token,
                'results' => [
                    'quantity1' => $quantity1,
                    'quantity1Status' => $set1Status,
                    'category' => $category,
                ],

            ];
            $dataSet['results']['quantity2'] = count($measurements) > $sampleSize ? $quantity2 : null;
            $dataSet['results']['quantity2Status'] = $set2Status;
            $dataSet['results']['overallStatus'] = $this->prePackageLibrary->evaluateStatus(array_merge($set1StatusArray, $set2StatusArray));

            // if ($category == 'Area' || $category == 'Linear 2') {


            // }
            return $this->response->setJSON($dataSet);


            // return json_encode($data);
        }
    }


    public function downloadProductData($hash, $productId, $quantityId = '')
    {

        $params = [
            'product_id' => $productId,
            'quantity_id' => $quantityId != '00' ? $quantityId : ''
        ];






        $customerDetails = $this->PrePackageModel->getCustomerInfo($hash);
        $productDetails = $this->PrePackageModel->selectProduct($productId);
        $product = $this->PrePackageModel->selectProduct($productId);
        $category = $product->analysis_category;
        $measurementSheet = $this->PrePackageModel->getMeasurementData($params);

        //Data variables

        // $declaredQuantity = (int)$productDetails->quantity;
        $quantity = $product->quantity_2;

        $declaredQuantity = preg_replace('/[^0-9]/', '', substr($measurementSheet[0]->quantity_id, 11));

        $sampleSize = (int)$productDetails->sample_size;
        $lotSize = (int)$productDetails->lot;
        $appliedMethod = $productDetails->method;

        $switch = '';
        $declaredQuantity == $quantity ? $switch .= 1 : $switch .= 0;

        $data['customerDetails'] = $customerDetails;
        $data['productDetails'] = $productDetails;
        $data['measurementSheet'] = $measurementSheet;
        $data['declaredQuantity'] = $declaredQuantity;
        $data['sampleSize'] = $sampleSize;
        $data['lotSize'] = $lotSize;
        $data['productQuantity'] = $declaredQuantity;
        $data['switcher'] = $switch;

        //create array of net quantities
        $netQuantities = array_map(function ($net) use ($declaredQuantity) {
            return   $net->net_quantity - $declaredQuantity;
        }, $measurementSheet);

        $data['netQuantities'] = $netQuantities;
        //filter t1
        $withT1error = array_filter($measurementSheet, function ($data) {
            return $data->status == 1;
        });

        // filter t2
        $withT2error = array_filter($measurementSheet, function ($data) {
            return $data->status == 2;
        });

        // calculate individual error
        $individualError = array_reduce($netQuantities, function ($prev, $next) {
            return $prev + $next;
        });

        // echo '<pre>';

        // print_r($netQuantities);
        // echo '</pre>';

        // exit;


        /*

      
        const averageError = samplesWithError.reduce((prev, next) => {
            return +prev + +next
        }, 0) / samplesWithError.length v11

         */
        $realT1 = array_map(function ($t) use ($withT1error) {
            return $t->net_quantity;
        }, $withT1error);
        $realT2 = array_map(function ($t) use ($withT2error) {
            return $t->net_quantity;
        }, $withT2error);

        $samplesWithError = array_merge($realT1, $realT2);

        $t1Percentage = count($realT1) * 100 / $sampleSize;
        $t2Percentage = count($realT2) * 100 / $sampleSize;

        $averageError = $individualError / $sampleSize;

        $data['samplesWithError'] = $samplesWithError;
        $data['t1Percentage'] = $t1Percentage;
        $data['t2Percentage'] = $t2Percentage;
        $data['averageError'] = $averageError;
        $data['individualError'] = $individualError;


        $data['t1Items'] = count($realT1);
        $data['t2Items'] = count($realT2);



        // //=====================================
        // $measurementSheet = $this->PrePackageModel->getMeasurementData($params);



        $measurements = $this->PrePackageModel->getMeasurementData(['product_id' => $productId]);

        $set1Measurements = array_slice($measurements, 0, $sampleSize);
        $set2Measurements = array_slice($measurements, $sampleSize);

        // $measurementIds = [
        //     $set1Measurements ? $set1Measurements[0]->quantity_id : '',
        //     $set2Measurements ? $set2Measurements[0]->quantity_id : '',

        // ];

        $set1StatusArray = $this->prePackageLibrary->processingMeasurements($set1Measurements);
        $set2StatusArray  = !empty($set2Measurements) ? $this->prePackageLibrary->processingMeasurements($set2Measurements) : [];



        $set1Status = $this->prePackageLibrary->evaluateStatus($set1StatusArray);
        $set2Status = $this->prePackageLibrary->evaluateStatus($set2StatusArray);

        // $product = $this->PrePackageModel->selectProduct($productId);
        // $category = $product->analysis_category;
        $quantity1 = $product->quantity . ' ' . $product->unit;
        $quantity2 = $product->quantity_2 . ' ' . $product->unit_2;
        $dataSet = [

            'quantity1' => $quantity1,
            'quantity1Status' => $set1Status,
            'category' => $category,
            'count($measurementSheet)' => count($measurements),


        ];
        $dataSet['quantity2'] = count($measurements) > $sampleSize ? $quantity2 : null;
        $dataSet['quantity2Status'] = $set2Status;
        $dataSet['overallStatus'] = $this->prePackageLibrary->evaluateStatus(array_merge($set1StatusArray, $set2StatusArray));
        //=====================================

        $data['overallResults'] = (object)$dataSet;
        //   echo '<pre>';

        //   print_r($measurementSheet);
        //   echo '</pre>';

        //   exit;








        $approved = 0;
        $correctionFactor = 0;

        $decision = '';

        if ($sampleSize == 20 && $appliedMethod == 'Destructive') {
            $approved += 0;

            if ($approved > 0) {
                $decision .= ' Sample Failed the required test reject';
            }

            $correctionFactor += 0.640;
        } else if ($sampleSize == 50 && $appliedMethod == 'Non Destructive') {
            $approved += 3;
            if ($approved > 3) {
                $decision .= ' Sample Failed the required test reject';
            }
            $correctionFactor += 0.379;
        } else if ($sampleSize == 80 && $appliedMethod == 'Non Destructive') {
            $approved += 5;
            if ($approved > 5) {
                $decision = ' Sample Failed the required test reject';
            }
            $correctionFactor += 0.295;
        } else if ($sampleSize == 125 && $appliedMethod == 'Non Destructive') {
            $approved += 7;
            if ($approved > 7) {
                $decision .= ' Sample Failed the required test reject';
            }
            $correctionFactor += 0.234;
        }



        // if ($lotSize >= 100 && $lotSize <= 500 && $appliedMethod == 'Non Destructive') {
        //     $approved += 3;

        //     if (count($realT1) > 3) {
        //         $decision = ' Sample Failed the required test reject';
        //     }

        //     $correctionFactor += 0.379;
        // } else if ($lotSize >= 501 && $lotSize <= 3200 && $appliedMethod == 'Non Destructive') {
        //     $approved += 5;
        //     if (count($realT1) > 5) {
        //         $decision = ' Sample Failed the required test reject';
        //     }
        //     $correctionFactor += 0.295;
        // } else if ($lotSize > 3200) {
        //     $approved += 7;
        //     if (count($realT1) > 7 && $appliedMethod == 'Non Destructive') {
        //         $decision = ' Sample Failed the required test reject';
        //     }
        //     $correctionFactor += 0.234;
        // } else if ($lotSize >= 100 && $appliedMethod == 'Destructive') {
        //     $approved += 1;
        //     if (count($realT1)  > 1) {
        //         $decision = ' Sample Failed the required test reject';
        //     }
        //     $correctionFactor += 0.640;
        // }

        $data['approved'] = $approved;
        $data['correctionFactor'] = $correctionFactor;
        $data['decision'] = $decision;


        $title = $customerDetails->name . ' ' . $productDetails->commodity . ' ' . $productDetails->quantity . '' . $productDetails->unit . ' ' . str_shuffle(time());

        //=================Generating pdf====================
        $dompdf = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();

        $dompdf->loadHtml(view('PrePackageTemplates/productTemplate', $data));
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        $options->set('isRemoteEnabled', true);

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream($title . '.pdf', array('Attachment' => 1));
    }


    public function prePackageReport()
    {
        $data['page'] = [
            "title" => "Pre Package Report",
            "heading" => "Pre Package Report",
        ];


        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['role'] = $role;
        $data['region'] = $this->city;
        return view('Pages/Prepackage/prePackageReport', $data);
    }

    public function generatePrepackageReport()
    {
        function getAllowedLimit($lot)
        {
            if ($lot > 100 && $lot <= 500) {
                return 3;
            } else if ($lot > 501 && $lot <= 3200) {
                return 3;
            } else if ($lot > 3200) {
                return 7;
            }
        }
        function evaluateStatus($measurementData, $declaredQuantity, $lotSize)
        {


            $withT1error = array_filter($measurementData, function ($data) {
                return $data->status == 1;
            });

            // filter t2
            $withT2error = array_filter($measurementData, function ($data) {
                return $data->status == 2;
            });

            $netQuantities = array_map(function ($net) use ($declaredQuantity) {
                return   (int)$declaredQuantity - (int)$net->net_quantity;
            }, $measurementData);

            // calculate individual error
            $individualError = array_reduce($netQuantities, function ($prev, $next) {
                return $prev + $next;
            });

            if (count($withT1error) > getAllowedLimit($lotSize) && count($withT2error) > 0) {
                return 'Failed';
            } else {
                return 'Pass';
            }
        }

        if ($this->request->getMethod() == 'post') {


            $region = $this->getVariable('region');

            if ($this->role == 7 || $this->role == 3) {
                $params = ['region' => $region];
            } elseif ($this->role == 2 || $this->role == 1) {
                $params = ['region' => $this->city];
            }
            $customerDetails = $this->PrePackageModel->getRegionalPrepackedData($params);

            /// check if no data found based on parameters supplied
            if (count($customerDetails)  == 0) {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'No Data Found',
                    'data' => [],
                    'token' => $this->token
                ]);
            } else {
                $company = [];
                $prepackage = array_map(function ($d) use ($company) {
                    $params = [
                        'product_id' => $d->product_id,
                        'quantity_id' => $d->quantity_id
                    ];
                    $product = $this->PrePackageModel->selectProduct($d->product_id);
                    $category = $product->analysis_category;
                    $measurements = $this->PrePackageModel->getMeasurementData($params);
                    array_push($company, $d->name);
                    return [

                        'name' => $d->name,
                        'date' => $d->created_at,
                        'details' => [
                            'measurements' => $measurements,
                            'commodity' => $d->commodity . ' ' . $d->quantity . '' . $d->unit,
                            'amount' => $d->amount,
                            'controlNumber' => $d->control_number,
                            'status' => evaluateStatus($measurements, $d->gross_quantity, $d->lot),
                            'region' => $d->region,
                            'location' => $d->location,
                            'date' => dateFormatter($d->created_at),
                        ]
                    ];
                }, $customerDetails);


                $unique = array();

                foreach ($prepackage as $arg) {
                    $tmp[$arg['name']][] = $arg['details'];
                }

                $output = array();

                foreach ($tmp as $customer => $data) {
                    $output[] = array(
                        'customer' => $customer,
                        'productData' => $data,
                        'region' => $data[0]['region'],
                        'location' => $data[0]['location'],
                        'date' => $data[0]['date'],
                        'controlNumber' => $data[0]['controlNumber'],
                        // 'controlNumber' => $data[0]['controlNumber'],
                    );
                }



                return $this->response->setJSON([
                    'status' => 1,
                    // 'data' => array_unique($unique),
                    'data' => $output,
                    //'data' => $unique,
                    'token' => $this->token
                ]);
            }
        }
    }




    //=================REPORT DOWNLOAD====================
    public function downloadPrepackageReport($region)
    {
        function getAllowedErrorLimit($lot)
        {
            if ($lot > 100 && $lot <= 500) {
                return 3;
            } else if ($lot > 501 && $lot <= 3200) {
                return 3;
            } else if ($lot > 3200) {
                return 7;
            }
        }
        function evaluateProductStatus($measurementData, $declaredQuantity, $lotSize)
        {


            $withT1error = array_filter($measurementData, function ($data) {
                return $data->status == 1;
            });

            // filter t2
            $withT2error = array_filter($measurementData, function ($data) {
                return $data->status == 2;
            });

            $netQuantities = array_map(function ($net) use ($declaredQuantity) {
                return (int)$net->net_quantity - (int)$declaredQuantity;
            }, $measurementData);

            // calculate individual error
            $individualError = array_reduce($netQuantities, function ($prev, $next) {
                return $prev + $next;
            });

            if (count($withT1error) > getAllowedErrorLimit($lotSize) && count($withT2error) > 0) {
                return 'Failed';
            } else {
                return 'Pass';
            }
        }





        if ($this->role == 7 || $this->role == 3) {
            $params = ['region' => $region];
        } elseif ($this->role == 2 || $this->role == 1) {
            $params = ['region' => $this->city];
        }
        $customerDetails = $this->PrePackageModel->getRegionalPrepackedData($params);


        $names = [];
        $prepackage = array_map(function ($d) use ($names) {

            $params = [
                'product_id' => $d->product_id,
                'quantity_id' => $d->quantity_id
            ];

            $product = $this->PrePackageModel->selectProduct($d->product_id);
            $category = $product->analysis_category;
            $measurements = $this->PrePackageModel->getMeasurementData($params);
            array_push($names, $d->name);
            return [

                'name' => $d->name,
                'date' => $d->created_at,
                'details' => [
                    'measurements' => $measurements,
                    // 'grossQuantity' => $d->gross_quantity,
                    // 'lot' => $d->lot,
                    'commodity' => $d->commodity . ' ' . $d->quantity . '' . $d->unit,
                    'amount' => $d->amount,
                    'controlNumber' => $d->control_number,
                    'status' => evaluateProductStatus($measurements, $d->gross_quantity, $d->lot),
                    'region' => $d->region,
                    'location' => $d->location,
                    'date' => dateFormatter($d->created_at),
                ]
            ];
        }, $customerDetails);;


        $unique = array();


        foreach ($prepackage as $arg) {
            $tmp[$arg['name']][] = $arg['details'];
        }

        (object)$output = array();

        foreach ($tmp as $customer => $data) {
            $output[] = array(
                'customer' => $customer,
                'productData' => $data,
                'region' => $data[0]['region'],
                'location' => $data[0]['location'],
                'date' => $data[0]['date'],
                'controlNumber' => $data[0]['controlNumber'],
            );
        }


        $title = 'Pre Package Report' . str_shuffle(time());

        $data['prePackageData'] = (object)$output;

        //=================Generating pdf====================
        $dompdf = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();

        $dompdf->loadHtml(view('PrePackageTemplates/prePackageRegionalReport', $data));
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        $options->set('isRemoteEnabled', true);

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream($title . '.pdf', array('Attachment' => 0));
    }





    public function registeredPrepackages()
    {


        $data['page'] = [
            "title" => "Registered Pre Packages",
            "heading" => "Registered Pre Packages",
        ];

        $uniqueId = $this->uniqueId;
        $managerId = $this->managerId;
        $role = $this->role;
        $city = $this->city;
        $data['role'] = $role;

        if ($role == 1) {
            $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
            // $data['lorryResults'] = $this->PrePackageModel->getRegisteredLorries($uniqueId);
        } elseif ($role == 2) {
            $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);

            // $data['lorryResults'] = $this->PrePackageModel->getAllLorries($city);
        } elseif ($role == 3 || $role == 7) {
            $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
            // $data['lorryResults'] = $this->PrePackageModel->getAllLorriesTz($city);
        }

        // return view('Pages/Prepackage/registeredPrepackage', $data);
        return view('Pages/Prepackage/prepackaging', $data);
    }
}
