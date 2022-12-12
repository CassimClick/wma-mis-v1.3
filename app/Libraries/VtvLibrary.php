<?php

namespace App\Libraries;

use stdClass;
use App\Models\VtcModel;
use App\Libraries\ArrayLibrary;
use App\Models\CustomerModel;

class VtvLibrary
{
    public function groupCompartments($array, $key): array
    {
        $result = new stdClass();
        // $result = [];

        foreach ($array as $val) {
            if (isset($key, $val)) {
                $data = $val->$key;
                $result->$data[] = $val;
            } else {
                $data = [''];
                $result->$data[] = $val;
            }
        }


        return (array)$result;
    }
    public function formatCompartmentData($compartments, $oilCompartments)
    {
        $vtcModal = new VtcModel();
        $customerModal = new CustomerModel();
        $vehicleId = $compartments[0]->vehicle_id;
        $vehicle = $vtcModal->getVehicleDetails($vehicleId);

        $customer = $customerModal->selectCustomer($vehicle->hash)->name;
        $verificationDate = $vehicle->registration_date;
        $nextVerification = $vehicle->next_calibration;
        $plateNumber = $vehicle->trailer_plate_number;
        $requiredCompartments = $vehicle->compartments;

        $chartNumber = 'V:IL4525.2022';



        $data = new ArrayLibrary((array)$compartments);
        $compNo =  array_unique($data->map(fn ($c) => $c->compartment_number)->get());
        $filledCompartments = $this->groupCompartments((array)$compartments, 'compartment_number');
        $tankTop = [];
        $order = range(1, $oilCompartments);
        $emptying = $order;
        rsort($emptying);

        $fillOrder = '';
        $emptyOrder = '';
        $labels = [];
        $stamps = [];



        for ($i = 0; $i < $oilCompartments; $i++) {
            $fillOrder .= $order[$i] . ',';
            $emptyOrder .= $emptying[$i] . ',';
            array_push($labels, 'COMPT NO. ' . $order[$i]);
            array_push($tankTop, array_values($filledCompartments)[$i][0]->tank_top);
            array_push($stamps, array_values($filledCompartments)[$i][0]->stamp_number);
        }
        $htmlData = array_map(
            fn ($d) =>
            array_map(
                function ($x) {

                    $litres = number_format((int)$x->litres);
                    $millimeters = number_format((int)$x->millimeters);
                    return <<<HTML
                    <tr>
                        <td class="text-1">$litres</td>
                        <td class="text-1">$millimeters</td>
                       
                    </tr>
                    
             HTML;
                },
                $vtcModal->getCompartmentData($d, $vehicleId)
            ),
            $compNo
        );
        $measurementData = array_map(
            fn ($data) =>
            array_map(
                function ($x) {
                    return [
                        // 'compartmentNumber' =>$x->compartment_number,
                        'litres' => (int)$x->litres,
                        'millimeters' => (int)$x->millimeters,
                    ];
                },
                $vtcModal->getCompartmentData($data,  $vehicleId)
            ),
            $compNo
        );

        $measurements = array_values($measurementData);


        [$tableData0, $tableData1, $tableData2, $tableData3, $tableData4, $tableData5, $tableData6, $tableData7, $tableData8] = '';
        [$maxLitres0, $maxLitres1, $maxLitres2, $maxLitres3, $maxLitres4, $maxLitres5, $maxLitres6, $maxLitres7, $maxLitres8] = [[], [], [], [], [], [], [], [], []];
        [$maxMm0, $maxMm1, $maxMm2, $maxMm3, $maxMm4, $maxMm5, $maxMm6, $maxMm7, $maxMm8] = [[], [], [], [], [], [], [], [], []];
        $htmlArr = array_values($htmlData);
        $column = $oilCompartments == 3 ? 4 : ($oilCompartments == 4 ? 3 : ($oilCompartments == 2 ? 6 : ($oilCompartments >= 6 ? 2 : 2)));

        //=================get total of each column====================
        for ($i = 0; $i < count($measurements); $i++) {
            foreach ($measurements[$i] as $measurement) {

                for ($c = 0; $c < $oilCompartments; $c++) {
                    if ($c == $i) {

                        array_push(${'maxLitres' . $c}, $measurement['litres']);
                        array_push(${'maxMm' . $c}, $measurement['millimeters']);
                    }
                }
            }
        }


        for ($i = 0; $i < count($htmlArr); $i++) {
            foreach ($htmlArr[$i] as $table) {

                for ($c = 0; $c < $oilCompartments; $c++) {
                    if ($c == $i) ${'tableData' . $c} .= $table;
                }
            }
        }

        $htmlUpperChart = '';
        $htmlLowerChart = '';


        $capacity = 0;
        for ($j = 0; $j < $oilCompartments; $j++) {
            $tank = $tankTop[$j];
            $litres = number_format(max(${'maxLitres' . $j}));
            $capacity += max(${'maxLitres' . $j});
            $millimeters = number_format(max(${'maxMm' . $j}));
            $label = $labels[$j];
            $stamp = 'STAMP: ' . $stamps[$j];

            if (${'tableData' . $j} != '')

                $htmlLowerChart .= <<<"HTML"
                    <td class="col-md-$column">
                         $label<br>
                         $litres LITRE <br> 
                         $stamp <br>
                    </td>
                          
                   
                      
             HTML;


            $htmlUpperChart .=  <<<HTML
             <td class="col-md-$column text-sm text-center">
                 <h5 class="text-sm"><b>T.T $tank mm</b></h5>
                <table class="table table-sm">
                   <thead>
                     <tr>
                        <th>Litres</th>
                        <th>mm</th>
                    </tr>
                   </thead>
                   <tbody>
                     ${'tableData' .$j}
                   </tbody>

                   
                </table>
             </td>
             <table></table>
             HTML;
        }

        return (object)[
            'link' => base_url('downloadCalibrationChart/'.$vehicleId),
            'complete' => $requiredCompartments == $oilCompartments ? true : false,
            'chartNumber' => $chartNumber,
            'customer' => $customer,
            'verificationDate' => dateFormatter($verificationDate),
            'nextVerification' => dateFormatter($nextVerification),
            'plateNumber' => 'TANK/TR NO '.$plateNumber,
            'capacity' => $capacity,
            'upperChart' => $htmlUpperChart,
            'lowerChart' => $htmlLowerChart,
            'fillOrder' => rtrim($fillOrder, ','),
            'emptyOrder' => rtrim($emptyOrder, ','),
        ];
        // return $htmlLowerChart;
    }
}
