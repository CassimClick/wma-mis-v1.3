<?php namespace App\Controllers;

use App\Libraries\CommonTasksLibrary;
use App\Models\PortModel;
use App\Models\ProfileModel;

class NoteOfFactAfterDischarge extends BaseController
{
    public $uniqueId;
    public $managerId;
    public $role;
    public $city;
    public $portUnitModel;
    public $session;
    public $profileModel;
    public $CommonTasks;

    public $sessionExpiration;

    public $variable;
    public $appRequest;

    public function __construct()
    {
        $this->appRequest =service('request');
        $this->portUnitModel = new PortModel();
        $this->profileModel = new ProfileModel();
        $this->session = session();

        $this->uniqueId = $this->session->get('loggedUser');
        $this->managerId = $this->session->get('manager');
        $this->role = $this->profileModel->getRole($this->uniqueId)->role;
        $this->city = $this->session->get('city');
        $this->CommonTasks = new CommonTasksLibrary();
        helper(['form', 'array', 'regions', 'date', 'documents','image']);

    }

    public function getVariable($var)
    {
        return $this->appRequest->getVar($var, FILTER_SANITIZE_STRING);
    }

    public function index()
    {

        

        $uniqueId = $this->uniqueId;
        $role = $this->role;
        $data['profile'] = $this->profileModel->getLoggedUserData($uniqueId);
        $data['role'] = $role;
        $data['page'] = [
            "title" => "Note Of Fact After Discharging",
            "heading" => "Note Of Fact After Discharging",
        ];

      

        return view('pages/port/noteAfter', $data);
    }

    public function addNoteOfFactAfter()
    {
        if ($this->request->getMethod() == 'post') {

            $token = csrf_hash();

            $noteOfFactB4 = [
                'ship_id' => $this->getVariable('shipId'),
                'at_loading' => $this->getVariable('atLoading'),
                'at_discharging' => $this->getVariable('atDischarging'),
                'at_transfer' => $this->getVariable('atTransfer'),
                'at_shore' => $this->getVariable('atShore'),
                'at_vessel' => $this->getVariable('atVessel'),
                'master' => $this->getVariable('master'),
                'terminal_rep' => $this->getVariable('terminalRep'),
                'receiver' => $this->getVariable('receiver'),
                'bill_of_lading_qty' => $this->getVariable('billOfLadingQty'),
                'ship_discharging_qty' => $this->getVariable('shipDischargeQuantity'),
                'qty_diff' => $this->getVariable('quantityDifference'),
                'diff_percentage' => $this->getVariable('differencePercentage'),
                'discharging_qty_15c' => $this->getVariable('dischargeQuantity15c'),
                'discharging_qty_20c' => $this->getVariable('dischargeQuantity20c'),
                'shore_outturn_qty' => $this->getVariable('shoreOutturnQuantity20c'),
                'qty_diff_2' => $this->getVariable('quantityDifference2'),
                'diff_percentage_2' => $this->getVariable('differencePercentage2'),
                'unique_id' => $this->uniqueId,

            ];

            // echo json_encode($noteOfFactB4);
            // exit;
            $request = $this->portUnitModel->saveNoteOfFactAfter($noteOfFactB4);
            if ($request) {
                echo json_encode([
                    'message' => 'Added',
                    'token' => $token,

                ]);
            } else {
                echo json_encode([
                    'message' => 'Failed',
                ]);
            }

        }

    }

    public function getNoteOfFactAfter()
    {
        
        if ($this->request->getMethod() == 'post') {

            $shipId = $this->getVariable('shipId');
            $request = $this->portUnitModel->getNoteOfFactAfter($shipId);
            if ($request) {
                echo json_encode($request);
            } else {
                echo json_encode('nothing');
            }

        }
    }

    //=================Download note of fact After discharge====================
    public function downloadNoteOfFactAfter($shipId)
    {
        

        $date = date('d-M,Y h:i:s ');
        $dompdf = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();

        // $title = 'Note Of Fact After Discharging';
        $data['title'] = 'Note Of Fact After Discharging';

// $data['details'] = $this->portUnitModel->downloadDocument($shipId);
        $data['note'] = $this->portUnitModel->getNoteOfFactAfter($shipId);
        $dompdf->loadHtml(view('PortUnitTemplates/noteOfFactAfterPdf', $data));
        $dompdf->setPaper('A4', 'portrait');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

// Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream($data['title'] . ':' . $date . '.pdf', array('Attachment' => 0));

    }

}