<?php namespace App\Controllers;

use App\Libraries\CommonTasksLibrary;
use App\Models\PortModel;
use App\Models\ProfileModel;

class NoteOfFactBeforeDischarge extends BaseController
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
        $this->appRequest = service('request');
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
            "title" => "Note Of Fact Before Discharging",
            "heading" => "Note Of Fact Before Discharging",
        ];

        return view('pages/port/noteBefore', $data);
    }

    public function addNoteOfFactBefore()
    {
        if ($this->request->getMethod() == 'post') {

            $noteOfFactB4 = [
                'ship_id' => (float) $this->getVariable('shipId'),
                'billOfLading1' => (float) $this->getVariable('billOfLading1'),
                'vesselFigAfterLoading1' => (float) $this->getVariable('vesselFigAfterLoading1'),
                'arrivalQuantity1' => (float) $this->getVariable('arrivalQuantity1'),
                'arrivalQuantity2' => (float) $this->getVariable('arrivalQuantity2'),
                'Difference1' => (float) $this->getVariable('Difference1'),
                'Difference2' => (float) $this->getVariable('Difference2'),
                'DifferencePercent1' => (float) $this->getVariable('DifferencePercent1'),
                'DifferencePercent2' => (float) $this->getVariable('DifferencePercent2'),
                'vesselExperienceFactor' => (float) $this->getVariable('vesselExperienceFactor'),
                'billOfLading1_b' => (float) $this->getVariable('billOfLading1_b'),
                'vesselFigAfterLoading1_b' => (float) $this->getVariable('vesselFigAfterLoading1_b'),
                'arrivalQuantity1_b' => (float) $this->getVariable('arrivalQuantity1_b'),
                'arrivalQuantity2_b' => (float) $this->getVariable('arrivalQuantity2_b'),
                'Difference1_b' => (float) $this->getVariable('Difference1_b'),
                'Difference2_b' => (float) $this->getVariable('Difference2_b'),
                'DifferencePercent1_b' => (float) $this->getVariable('DifferencePercent1_b'),
                'DifferencePercent2_b' => (float) $this->getVariable('DifferencePercent2_b'),
                'unique_id' => $this->uniqueId,

            ];

            // echo json_encode($noteOfFactB4);
            // exit;
            $request = $this->portUnitModel->saveNoteOfFactBefore($noteOfFactB4);
            if ($request) {
                echo json_encode('Added');
            } else {
                echo json_encode('Something Went Wrong');
            }

        }

    }

    public function getNoteOfFactBefore()
    {
        
        if ($this->request->getMethod() == 'post') {

            $shipId = $this->getVariable('shipId');
            $request = $this->portUnitModel->getNoteOfFactBefore($shipId);
            if ($request) {
                echo json_encode($request);
            } else {
                echo json_encode('nothing');
            }

        }
    }

    //=================Download note of fact before discharge====================
    public function downloadNoteOfFactBefore($shipId)
    {
        

        $date = date('d-M,Y h:i:s ');
        $dompdf = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();

        $title = 'Note Of Fact Before Discharging';

// $data['details'] = $this->portUnitModel->downloadDocument($shipId);
        $data['note'] = $this->portUnitModel->getNoteOfFactBefore($shipId);
        $dompdf->loadHtml(view('PortUnitTemplates/noteOfFactBeforePdf', $data));
        $dompdf->setPaper('A4', 'portrait');
        $options->set('isRemoteEnabled', true);

// Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream($title . ':' . $shipId . '.pdf', array('Attachment' => 0));

    }

}