<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Authentication Middleware
// $routes->get('activateAccount/(:any)', 'Profile::activateAccount/$1');
$routes->match(['get', 'post'], 'user/activateAccount/(:any)/(:any)', 'UserAccountController::activateAccount/$1/$2');
//$routes->match(['get', 'post'], 'user/activate/(:any)/(:any)', 'UserAccountController::activate/$1/$2');
$routes->post('checkSession', 'Miscellaneous::checkSession');
$routes->get('text', 'Yap::text');
$routes->get('shop', 'Shop::index');
$routes->get('data', 'Shop::data');
$routes->post('addItem', 'Shop::addItem');
$routes->get('pdf', 'Yap::pdf');
$routes->get('getVisitors', 'Home::getData');
$routes->get('groupBy', 'Yap::groupBy');
$routes->get('searchBy', 'Yap::searchBy');
$routes->get('bill', 'Yap::bill');
$routes->get('toXml', 'XmlController::toXml');
$routes->get('xml', 'XmlController::toXml');
$routes->get('xmlPost', 'XmlController::xmlPost');
$routes->get('fileContent', 'XmlController::fileContent');



$routes->group('', ['filter' => 'AuthFilter'], function ($routes, $appRoutes = []) {

    $routes->post('checkEmail', 'Admin::checkEmail');
    //=================customer====================
    $appRoutes['addCustomer'] = 'CustomerController::addCustomer';
    $appRoutes['selectClient'] = 'CustomerController::selectCustomer';
    $appRoutes['searchCustomer'] = 'CustomerController::searchCustomer';


    // ================Dts==============
    $appRoutes['directorDashboard'] = 'Dts::index';
    $appRoutes['graphData'] = 'Dts::analytic';
    $appRoutes['fullReport'] = 'Dts::wmaFullReport';
    $appRoutes['printFullReport'] = 'Dts::printFullReport';
    $appRoutes['regionReport/(:any)'] = 'Dts::regionReport/$1';
    $appRoutes['regionalReportPrint/(:any)'] = 'Dts::regionalReportPrint/$1';
    $appRoutes['listAllScales/(:any)'] = 'Dts::listAllScales/$1';
    $appRoutes['listAllFuelPumps/(:any)'] = 'Dts::listAllFuelPumps/$1';
    $appRoutes['listAllPrePackage/(:any)'] = 'Dts::listAllPrePackage/$1';
    $appRoutes['listAllVehicleTanks/(:any)'] = 'Dts::listAllVehicleTanks/$1';
    $appRoutes['listAllLorries/(:any)'] = 'Dts::listAllLorries/$1';
    $appRoutes['listAllBulkStorageTanks/(:any)'] = 'Dts::listAllBulkStorageTanks/$1';
    $appRoutes['listAllFixedStorageTanks/(:any)'] = 'Dts::listAllFixedStorageTanks/$1';
    $appRoutes['listAllFlowMeters/(:any)'] = 'Dts::listAllFlowMeters/$1';
    $appRoutes['listAllWaterMeters/(:any)'] = 'Dts::listAllWaterMeters/$1';

    // ================Manager==============
    $appRoutes['managerChart'] = 'Manager::analytics';
    $appRoutes['manager'] = 'Manager::index';
    $appRoutes['managerProfile'] = 'Manager::managerProfile';
    $appRoutes['managerDashboard'] = 'Manager::index';
    $appRoutes['addGroup'] = 'Manager::addGroup';

    $appRoutes['createTask'] = 'Manager::createTask';
    $appRoutes['assignToGroup'] = 'Manager::assignToGroup';
    $appRoutes['assignTask'] = 'Manager::assignTask';
    $appRoutes['assignToIndividual'] = 'Manager::assignToIndividual';
    $appRoutes['viewTasks'] = 'Manager::viewTasks';
    $appRoutes['listAllScales'] = 'Manager::listAllScales';
    $appRoutes['service-requests'] = 'Manager::serviceRequests';
    //101
    $appRoutes['license-applications'] = 'Manager::licenseApplications';
    $appRoutes['view-application/(:any)'] = 'Manager::applicationDetails/$1';
    $appRoutes['download-application/(:any)'] = 'Manager::downloadApplication/$1';

    $appRoutes['confirm-service-request/(:any)'] = 'Manager::confirmServiceRequests/$1';
    $appRoutes['download-service-request/(:any)'] = 'Manager::downloadServiceRequests/$1';


    // ================User profile==============
    $appRoutes['profile'] = 'Profile::index';
    $appRoutes['changePassword'] = 'Profile::changePassword';
    $appRoutes['managerProfile'] = 'Profile::managerProfile';
    $appRoutes['directorProfile'] = 'Profile::directorProfile';
    $appRoutes['confirmTask/(:any)'] = 'Profile::confirmTask/$1';
    $appRoutes['home'] = 'Home::index';

    // $routes->add('activate/(:any)','Auth\Signup::activate/$1');
    // ================Authentication==============
    //$appRoutes['activate'] = 'Auth\Signup::activate';  

    // $appRoutes['login']  = 'Login::index';
    $appRoutes['newCustomer'] = 'PersonalDetails::newCustomer';
    $appRoutes['searchExistingCustomer'] = 'PersonalDetails::searchExistingCustomer';
    $appRoutes['selectCustomer'] = 'PersonalDetails::selectCustomer';
    $appRoutes['updateCustomer'] = 'PersonalDetails::updateCustomer';
    // =======================Scales===================================
    $appRoutes['newScale'] = 'Scales::newScale';
    $appRoutes['listScales'] = 'Scales::listRegisteredScales';
    $appRoutes['registerScale'] = 'Scales::registerScale';
    $appRoutes['getCustomerScales'] = 'Scales::getCustomerScales';
    $appRoutes['saveScaleData'] = 'Scales::saveScaleData';

    // =======================Fuel Pumps==========================
    $appRoutes['newPump'] = 'FuelPumps::newPump';
    $appRoutes['listFuelPumps'] = 'FuelPumps::listRegisteredFuelPumps';
    // ============================================================
    $appRoutes['dashboard'] = 'Dashboard';
    $appRoutes['viewPrepackage'] = 'PrepackageController::listPrepackage';
    $appRoutes['logout'] = 'Profile::logout';
    // ======================Industrial Packages==========================================
    $appRoutes['newIndustrialPackage'] = 'IndustrialPackages::newIndustrialPackage';
    $appRoutes['listIndustrialPackages'] = 'IndustrialPackages::listIndustrialPackages';

    // ==================== Lories================================

    $appRoutes['addLorry'] = 'Lorries::addLorry';
    $appRoutes['registerLorry'] = 'Lorries::registerLorry';
    $appRoutes['getUnpaidLorries'] = 'Lorries::getUnpaidLorries';
    $appRoutes['listLorries'] = 'Lorries::listRegisteredLorries';
    $appRoutes['publishLorryData'] = 'Lorries::publishLorryData';
    $appRoutes['searchSbl'] = 'Lorries::searchSbl';
    $appRoutes['editSbl'] = 'Lorries::editSbl';
    $appRoutes['updateLorry'] = 'Lorries::updateLorry';
    $appRoutes['grabLastLorry'] = 'Lorries::grabLastLorry';

    // ================Vehicle Tanks==============
    $appRoutes['addVehicleTank'] = 'VehicleTankCalibration::addVtc';
    $appRoutes['listVehicleTanks'] = 'VehicleTankCalibration::listRegisteredVtc';
    $appRoutes['registerVehicleTank'] = 'VehicleTankCalibration::registerVehicleTank';
    $appRoutes['grabLastVehicle'] = 'VehicleTankCalibration::grabLastVehicle';
    $appRoutes['getUnpaidVehicles'] = 'VehicleTankCalibration::getUnpaidVehicles';
    $appRoutes['publishVtcData'] = 'VehicleTankCalibration::publishVtcData';
    $appRoutes['searchVtc'] = 'VehicleTankCalibration::searchVtc';
    $appRoutes['editVtc'] = 'VehicleTankCalibration::editVtc';

    $appRoutes['newVehicleTank'] = 'VehicleTankCalibration::newVehicleTank';
    $appRoutes['updateVehicleTank'] = 'VehicleTankCalibration::updateVehicleTank';

    $appRoutes['getVehicleDetails'] = 'VehicleTankCalibration::getVehicleDetails';
    $appRoutes['getCalibratedTanks'] = 'VehicleTankCalibration::getCalibratedTanks';
    $appRoutes['downloadCalibrationChart/(:any)'] = 'VehicleTankCalibration::downloadCalibrationChart/$1';

    //=================chart====================

    $appRoutes['createChart'] = 'VehicleTankCalibration::createChart';

    // ================Bulk Storage Tanks==============
    $appRoutes['addBulkStorageTank'] = 'BulkStorageTank::addBulkStorageTank';
    $appRoutes['listBulkStorageTanks'] = 'BulkStorageTank::listRegisteredBulkStorageTanks';
    $appRoutes['editBulkStorageTank/(:any)'] = 'BulkStorageTank::editBulkStorageTank/$1';
    $appRoutes['deleteBulkStorageTank/(:any)'] = 'BulkStorageTank::deleteBulkStorageTank/$1';

    // ================Fixed Storage Tanks==============
    $appRoutes['addFixedStorageTank'] = 'FixedStorageTank::addFixedStorageTank';
    $appRoutes['listFixedStorageTanks'] = 'FixedStorageTank::listRegisteredFixedStorageTanks';
    $appRoutes['editFixedStorageTank/(:any)'] = 'FixedStorageTank::editFixedStorageTank/$1';
    $appRoutes['deleteFixedStorageTank/(:any)'] = 'FixedStorageTank::deleteFixedStorageTank/$1';

    // ================flow Meter==============
    $appRoutes['addFlowMeter'] = 'FlowMeter::addFlowMeter';
    $appRoutes['FlowMeterList'] = 'FlowMeter::listRegisteredFlowMeters';
    $appRoutes['editFlowMeter/(:any)'] = 'FlowMeter::editFlowMeter/$1';
    $appRoutes['deleteFlowMeter/(:any)'] = 'FlowMeter::deleteFlowMeter/$1';

    // ================Water Meter==============

    $appRoutes['addWaterMeter'] = 'WaterMeter::addWaterMeter';
    $appRoutes['registerWaterMeter'] = 'WaterMeter::registerWaterMeter';
    $appRoutes['getUnpaidWaterMeters'] = 'WaterMeter::getUnpaidWaterMeters';
    $appRoutes['publishWaterMeterData'] = 'WaterMeter::publishWaterMeterData';
    $appRoutes['WaterMeterList'] = 'WaterMeter::listRegisteredWaterMeters';
    $appRoutes['editWaterMeter/(:any)'] = 'WaterMeter::editWaterMeter/$1';
    $appRoutes['deleteWaterMeter/(:any)'] = 'WaterMeter::deleteWaterMeter/$1';
    $appRoutes['downloadMeterChart/(:any)'] = 'WaterMeter::downloadMeterChart/$1';

    //=================Reports====================
    $appRoutes['reports'] = 'CollectionReports::index';
    $appRoutes['reportsManager'] = 'CollectionReports::index';
    $appRoutes['reportsDts'] = 'CollectionReports::index';



    $appRoutes['getQuarterReportWithDateRange'] = 'CollectionReports::getQuarterReportWithDateRange';
    $appRoutes['getQuarterReport'] = 'CollectionReports::getQuarterReport';
    $appRoutes['getMonthlyReport'] = 'CollectionReports::getMonthlyReport';
    $appRoutes['customDateReport'] = 'CollectionReports::customDateReport';
    $appRoutes['downloadQuarterReport/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'CollectionReports::downloadQuarterReport/$1/$2/$3/$4/$5/$6/$7';
    $appRoutes['downloadMonthlyReport/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'CollectionReports::downloadMonthlyReport/$1/$2/$3/$4/$5/$6';
    $appRoutes['downloadCustomDateReport/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'CollectionReports::downloadCustomDateReport/$1/$2/$3/$4/$5/$6';

    //=================searching ====================
    $appRoutes['search'] = 'SearchController::index';
    // $appRoutes['searchManager'] = 'Search::index';
    // $appRoutes['searchDirector'] = 'Search::index';

    $appRoutes['searchItem'] = 'SearchController::searchItem';
    $appRoutes['selectItem'] = 'SearchController::selectItem';

    $appRoutes['searchingVtc'] = 'Search::searchingVtc';
    $appRoutes['searchingSbl'] = 'Search::searchingSbl';
    $appRoutes['searchingWaterMeter'] = 'Search::searchingWaterMeter';

    $appRoutes['renderSelectedVtc'] = 'Search::renderSelectedVtc';
    $appRoutes['renderSelectedSbl'] = 'Search::renderSelectedSbl';
    $appRoutes['renderSelectedWaterMeters'] = 'Search::renderSelectedWaterMeters';

    //=================PortUnit====================
    $appRoutes['timeLog'] = 'TimeLog::timeLog';
    $appRoutes['addTimeLog'] = 'TimeLog::addTimeLog';
    $appRoutes['getLastLog'] = 'TimeLog::getLastLog';
    $appRoutes['getAllTimeLogs'] = 'TimeLog::getAllTimeLogs';
    $appRoutes['getAllTimeLogs'] = 'TimeLog::getAllTimeLogs';
    $appRoutes['downloadTimeLog/(:any)'] = 'TimeLog::downloadTimeLog/$1';

    $appRoutes['ullageBeforeDischarging'] = 'ShipUllage::index';
    $appRoutes['addShipOilTank'] = 'ShipUllage::addShipOilTank';
    $appRoutes['getAvailableShipUllageB4Discharge'] = 'ShipUllage::getAvailableShipUllageB4Discharge';
    $appRoutes['downloadUllageB4Discharging/(:any)'] = 'ShipUllage::downloadUllageB4Discharging/$1';

    $appRoutes['ullageAfterDischarging'] = 'ShipUllageAfter::index';
    $appRoutes['addShipOilTankUllageAfter'] = 'ShipUllageAfter::addShipOilTank';
    $appRoutes['getAvailableShipUllageAfterDischarge'] = 'ShipUllageAfter::getAvailableShipUllageAfterDischarge';
    $appRoutes['downloadUllageAfterDischarging/(:any)'] = 'ShipUllageAfter::downloadUllageAfterDischarging/$1';

    $appRoutes['addShipParticulars'] = 'PortUnit::addShipParticulars';
    $appRoutes['documents'] = 'PortUnit::documents';
    $appRoutes['searchExistingShips'] = 'PortUnit::searchExistingShips';
    $appRoutes['saveShipDocumentsInfo'] = 'PortUnit::saveShipDocumentsInfo';
    $appRoutes['selectShipDocuments'] = 'PortUnit::selectShipDocuments';
    $appRoutes['selectedShip'] = 'PortUnit::selectedShip';
    $appRoutes['downloadPortDocsPDF/(:any)'] = 'PortUnit::downloadPortDocsPDF/$1';

    $appRoutes['certificateOfQuantity'] = 'CertificateOfQuantity::index';
    $appRoutes['addCertificateOfQuantity'] = 'CertificateOfQuantity::addCertificateOfQuantity';
    $appRoutes['getCertificateOfQuantity'] = 'CertificateOfQuantity::getCertificateOfQuantity';
    $appRoutes['downloadCertificateOfQuantity/(:any)'] = 'CertificateOfQuantity::downloadCertificateOfQuantity/$1';

    $appRoutes['noteOfFactBeforeDischarging'] = 'NoteOfFactBeforeDischarge::index';
    $appRoutes['getNoteOfFactBefore'] = 'NoteOfFactBeforeDischarge::getNoteOfFactBefore';
    $appRoutes['addNoteOfFactBefore'] = 'NoteOfFactBeforeDischarge::addNoteOfFactBefore';
    $appRoutes['getNoteOfFactBefore'] = 'NoteOfFactBeforeDischarge::getNoteOfFactBefore';
    $appRoutes['downloadNoteOfFactBefore/(:any)'] = 'NoteOfFactBeforeDischarge::downloadNoteOfFactBefore/$1';

    //=================After====================
    $appRoutes['noteOfFactAfterDischarging'] = 'NoteOfFactAfterDischarge::index';
    $appRoutes['addNoteOfFactAfter'] = 'NoteOfFactAfterDischarge::addNoteOfFactAfter';
    $appRoutes['getNoteOfFactAfter'] = 'NoteOfFactAfterDischarge::getNoteOfFactAfter';
    $appRoutes['downloadNoteOfFactAfter/(:any)'] = 'NoteOfFactAfterDischarge::downloadNoteOfFactAfter/$1';

    //=================pressure log====================
    $appRoutes['pressureLog'] = 'PressureLog::index';
    $appRoutes['addPressureLog'] = 'PressureLog::addPressureLog';
    $appRoutes['getLastPressureLog'] = 'PressureLog::getLastPressureLog';
    $appRoutes['getAllPressureLogs'] = 'PressureLog::getAllPressureLogs';
    $appRoutes['downloadPressureLog/(:any)'] = 'PressureLog::downloadPressureLog/$1';

    $appRoutes['dischargingSequence'] = 'DischargingSequence::index';
    $appRoutes['addTankDischargingSequence'] = 'DischargingSequence::addTankDischargingSequence';
    $appRoutes['checkTanks'] = 'DischargingSequence::checkTanks';
    $appRoutes['updateTankTimeDate'] = 'DischargingSequence::updateTankTimeDate';
    $appRoutes['getDischargingSequence'] = 'DischargingSequence::getDischargingSequence';
    $appRoutes['downloadDischargingSequence/(:any)'] = 'DischargingSequence::downloadDischargingSequence/$1';

    $appRoutes['lineDisplacement'] = 'LineDisplacement::index';
    $appRoutes['addLineDisplacement'] = 'LineDisplacement::addLineDisplacement';
    $appRoutes['getLineDisplacement'] = 'LineDisplacement::getLineDisplacement';
    $appRoutes['downloadLineDisplacement/(:any)'] = 'LineDisplacement::downloadLineDisplacement/$1';

    $appRoutes['provisionalReport'] = 'ProvisionalReport::index';
    $appRoutes['addProvisionalReport'] = 'ProvisionalReport::addProvisionalReport';
    $appRoutes['getProvisionalReport'] = 'ProvisionalReport::getProvisionalReport';
    $appRoutes['downloadProvisionalReport/(:any)'] = 'ProvisionalReport::downloadProvisionalReport/$1';

    //=================Discharge order====================
    $appRoutes['dischargeOrder'] = 'DischargeOrder::index';
    $appRoutes['addDischargeOrder'] = 'DischargeOrder::addDischargeOrder';
    $appRoutes['getDischargeOrder'] = 'DischargeOrder::getDischargeOrder';
    $appRoutes['downloadDischargeOrder/(:any)'] = 'DischargeOrder::downloadDischargeOrder/$1';

    //=================ON SHORE====================

    $appRoutes['shoreTankMeasurement'] = 'shoreTankMeasurementData::index';
    $appRoutes['addShoreTank'] = 'shoreTankMeasurementData::addShoreTank';
    $appRoutes['checkShoreTanks'] = 'shoreTankMeasurementData::checkTanks';
    $appRoutes['getTankDetails'] = 'shoreTankMeasurementData::getTankDetails';
    $appRoutes['addMeasurementData'] = 'shoreTankMeasurementData::addMeasurementData';
    $appRoutes['getTankMeasurements'] = 'shoreTankMeasurementData::getTankMeasurements';
    $appRoutes['addSealPosition'] = 'shoreTankMeasurementData::addSealPosition';
    $appRoutes['getSealPositions'] = 'shoreTankMeasurementData::getSealPositions';
    $appRoutes['addStatus'] = 'shoreTankMeasurementData::addStatus';
    $appRoutes['getStatus'] = 'shoreTankMeasurementData::getStatus';
    $appRoutes['downloadShoreTankMeasurementData/(:any)/(:any)'] = 'shoreTankMeasurementData::downloadShoreTankMeasurementData/$1/$2';

    //=================Analytic====================

    $appRoutes['analytics'] = 'Analytics::index';
    $appRoutes['analyticsOfficer'] = 'Analytics::index';
    $appRoutes['analyticsManager'] = 'Analytics::index';
    $appRoutes['projection'] = 'Analytics::index';
    $appRoutes['getActivityCollection'] = 'Analytics::getActivityCollection';
    $appRoutes['getVtcCollection'] = 'Analytics::getVtcCollection';
    $appRoutes['getSblCollection'] = 'Analytics::getSblCollection';
    $appRoutes['collectionTarget'] = 'Analytics::targets';

    $appRoutes['saveRegionalTarget'] = 'Analytics::saveRegionalTarget';
    $appRoutes['getRegionTargets'] = 'Analytics::getRegionTargets';
    $appRoutes['editRegionTarget'] = 'Analytics::editRegionTarget';

    $appRoutes['activitiesInRegion'] = 'Analytics::activitiesInRegion';

    $appRoutes['updateRegionTarget'] = 'Analytics::updateRegionTarget';

    $appRoutes['saveActivityTarget'] = 'Analytics::saveActivityTarget';
    $appRoutes['getActivityTargets'] = 'Analytics::getActivityTargets';
    $appRoutes['editActivityTarget'] = 'Analytics::editActivityTarget';
    $appRoutes['updateActivityTarget'] = 'Analytics::updateActivityTarget';

    $appRoutes['xxx'] = 'Analytics::xxx';

    $appRoutes['printPage'] = 'Yap::pdf';
    $appRoutes['getControlNumber'] = 'Miscellaneous::getControlNumber';

    //=================PRE PACKAGE ROUTES==================== 

    $appRoutes['prePackage'] = 'PrePackageController::index';
    $appRoutes['addPrePackageCustomer'] = 'PrePackageController::addPrePackageCustomer';
    $appRoutes['searchPrePackageCustomer'] = 'PrePackageController::searchCustomer';
    $appRoutes['editPrePackageCustomer'] = 'PrePackageController::editPrePackageCustomer';
    $appRoutes['getPrePackageCustomer'] = 'PrePackageController::getPrePackageCustomer';
    $appRoutes['addProductDetails'] = 'PrePackageController::addProductDetails';
    $appRoutes['selectProduct'] = 'PrePackageController::selectProduct';
    $appRoutes['saveMeasurementData'] = 'PrePackageController::saveMeasurementData';
    $appRoutes['getMeasurementData'] = 'PrePackageController::getMeasurementData';
    $appRoutes['getCompleteProducts'] = 'PrePackageController::getCompleteProducts';
    $appRoutes['createBill'] = 'PrePackageController::createBill';
    $appRoutes['registeredPrepackages'] = 'PrePackageController::registeredPrepackages';
    $appRoutes['downloadProductData/(:any)/(:any)/(:any)'] = 'PrePackageController::downloadProductData/$1/$2/$3';

    $appRoutes['prePackageReport'] = 'PrePackageController::prePackageReport';
    $appRoutes['productList'] = 'PrePackageController::productList';
    $appRoutes['generatePrepackageReport'] = 'PrePackageController::generatePrepackageReport';
    $appRoutes['downloadPrepackageReport/(:any)'] = 'PrePackageController::downloadPrepackageReport/$1';

    $appRoutes['getProductsWithMeasurements'] = 'PrePackageController::getProductsWithMeasurements';
    $appRoutes['checkQuantityId'] = 'PrePackageController::checkQuantityId';



    // Billing and Receipt 
    $appRoutes['billManagement'] = 'BillController::index';
    $appRoutes['searchBill'] = 'BillController::searchBill';
    $appRoutes['selectBill'] = 'BillController::selectBill';
    $appRoutes['billCreation'] = 'BillController::billCreation';
    $appRoutes['billSubmissionRequest'] = 'BillController::billSubmissionRequest';
    $appRoutes['dom'] = 'BillController::dom';
    $appRoutes['domAjax'] = 'BillController::domAjax';
    //=================call back urls for GePg====================
    $appRoutes['control_number'] = 'BillController::controlNumber';
    $appRoutes['bill_payment'] = 'BillController::billPayment';
    $appRoutes['bill_reconciliation'] = 'BillController::billReconciliation';


    $appRoutes['payments'] = 'PaymentController::payments';
    $appRoutes['searchPayment'] = 'PaymentController::searchPayment';
    $appRoutes['selectPayment'] = 'PaymentController::selectPayment';

    // regions, districts, wards and postal codes
    $appRoutes['fetchRegions'] = 'Miscellaneous::fetchRegions';
    $appRoutes['fetchDistricts'] = 'Miscellaneous::fetchDistricts';
    $appRoutes['fetchWards'] = 'Miscellaneous::fetchWards';
    $appRoutes['fetchPostCodes'] = 'Miscellaneous::fetchPostCodes';


    $routes->map($appRoutes);
});

$routes->get('denied', 'Miscellaneous::accessDenied');
$routes->get('goBack', 'Miscellaneous::goBack');
$routes->group('admin', ['filter' => 'AdminFilter'], function ($routes, $adminRoutes = []) {
    $adminRoutes['createUserAccount'] = 'Admin::createUserAccount';
    $adminRoutes['createBackup'] = 'BackupController::createBackup';
    $adminRoutes['backup'] = 'BackupController::index';
    $adminRoutes['dashboard'] = 'Admin::index';
    $adminRoutes['users'] = 'Admin::usersPage';
    $adminRoutes['getUsers'] = 'Admin::getUsers';
    $adminRoutes['changeStatus'] = 'Admin::changeStatus';
    $adminRoutes['getAllUsers'] = 'Admin::getAllUsers';
    $adminRoutes['activateAccount/(:any)'] = 'Admin::activateAccount/$1';
    $adminRoutes['deactivateAccount/(:any)'] = 'Admin::deactivateAccount/$1';
    $adminRoutes['editUser'] = 'Admin::getSingleUser';
    $adminRoutes['updateUser'] = 'Admin::updateUser';
    $adminRoutes['resetPassword'] = 'Admin::resetPassword';
    $adminRoutes['setting'] = 'SettingsController::index';


    $routes->map($adminRoutes);
});


//=================ROUTES FOR LICENSE APPLICATION====================




//=================ROUTES FOR SERVICE APPLICATION====================

$namespace =  ['namespace' => 'App\Controllers\ServiceApplication'];


$routes->match(['get', 'post'], 'service-request/login', 'ServiceAuthController::login', $namespace);
$routes->match(['get', 'post'], 'service-request/forgot-password', 'ServiceAuthController::forgotPassword', $namespace);
$routes->get('service-request/create-account', 'ServiceAuthController::signup', $namespace);
$routes->post('service-request/signup', 'ServiceAuthController::createAccount', $namespace);
$routes->get('service-request/confirm-email/(:any)', 'ServiceAuthController::confirmEmail/$1', $namespace);
$routes->get('service-request/password-reset/(:any)', 'ServiceAuthController::passwordReset/$1', $namespace);
$routes->match(['get', 'post'], 'service-request/new-password/(:any)', 'ServiceAuthController::newPassword/$1', $namespace);
$routes->get('service-request/user-account-activation/(:any)', 'ServiceAuthController::AccountActivation/$1', $namespace);
$routes->post('service-request/verifyNida', 'ServiceAuthController::verifyNida', $namespace);

$routes->post('fetchAllRegions', 'Miscellaneous::fetchRegions');
$routes->post('fetchAllWards', 'Miscellaneous::fetchWards',['namespace' => 'App\Controllers']);
$routes->post('fetchAllDistricts','Miscellaneous::fetchDistricts', ['namespace' => 'App\Controllers']);
$routes->post('fetchAllPostCodes','Miscellaneous::fetchPostCodes', ['namespace' => 'App\Controllers']);



$routes->get('service-request/welcome', 'ServiceController::welcome', $namespace);
$routes->get('service-request/how-to-request-service', 'ServiceController::serviceRequest', $namespace);
$routes->get('service-request/how-to-apply-license', 'ServiceController::licenseApplication', $namespace);

$routes->group(
    'service-request',
    [
        'namespace' => 'App\Controllers\ServiceApplication',
        'filter' => 'ServiceFilter'
    ],
    function ($routes, $serviceRoutes = []) {
        $serviceRoutes['dashboard'] = 'ServiceController::index';
        $serviceRoutes['service-application'] = 'ServiceController::ServiceApplication';
        $serviceRoutes['submitted-service-requests'] = 'ServiceController::SubmittedRequests';
        $serviceRoutes['user-logout'] = 'ServiceAuthController::logout';

        $serviceRoutes['license-application'] = 'LicenseController::index';
        $serviceRoutes['applicant-particulars'] = 'LicenseController::applicantParticulars';
        $serviceRoutes['add-applicant-particulars'] = 'LicenseController::addApplicantParticulars';
        $serviceRoutes['edit-applicant-particulars/(:any)'] = 'LicenseController::editApplicantParticulars/$1';
        $serviceRoutes['update-applicant-particulars/(:any)'] = 'LicenseController::updateApplicantParticulars/$1';
        
        $serviceRoutes['applicant-qualifications'] = 'LicenseController::applicantQualifications';
        $serviceRoutes['addQualification'] = 'LicenseController::addQualification';
        $serviceRoutes['submitApplication'] = 'LicenseController::submitApplication';
        $serviceRoutes['deleteQualification/(:any)'] = 'LicenseController::deleteQualification/$1';
        
        $serviceRoutes['license-type'] = 'LicenseController::licenseType';
        $serviceRoutes['addLicense'] = 'LicenseController::addLicense';
        $serviceRoutes['deleteLicense/(:any)'] = 'LicenseController::deleteLicense/$1';

        $serviceRoutes['tools'] = 'LicenseController::tools';
        $serviceRoutes['addTool'] = 'LicenseController::addTool';
        $serviceRoutes['deleteTool/(:any)'] = 'LicenseController::deleteTool/$1';
        

        $serviceRoutes['attachments'] = 'LicenseController::attachments';
        $serviceRoutes['addAttachment'] = 'LicenseController::addAttachment';
        $serviceRoutes['deleteAttachment/(:any)'] = 'LicenseController::deleteAttachment/$1';
        $serviceRoutes['editAttachment'] = 'LicenseController::editAttachment';
        $serviceRoutes['updateAttachment'] = 'LicenseController::updateAttachment';
        $serviceRoutes['submission'] = 'LicenseController::submission';
        $serviceRoutes['submitApplication'] = 'LicenseController::submitApplication';
        $serviceRoutes['application-preview'] = 'LicenseController::applicationPreview';
        $serviceRoutes['application-details/(:any)'] = 'LicenseController::applicationDetails/$1';
        $routes->map($serviceRoutes);
    }
);















$routes->get('newForm', 'ContactController2::index');
$routes->post('addForm', 'ContactController2::create');
$routes->post('editRecord', 'ContactController2::editRecord');
$routes->post('updateRecord', 'ContactController2::updateRecord');



$routes->set404Override(function () {

    $data = [
        "title" => "Not Found",

    ];

    echo view('Pages/404', $data);
});



// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
