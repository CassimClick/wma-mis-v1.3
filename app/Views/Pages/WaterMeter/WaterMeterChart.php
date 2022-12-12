<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart</title>

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            padding-top: 20px;
            font-family: sans-serif;
            color: #181818;
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }

        table {
            width: 100%;
            /* color: #333; */
            border-collapse: collapse;
            font-size: 12.5px;
        }


        th {
            background-color: #555;
            color: #fff;
            padding: 3px;
            text-align: left;
        }


        td {
            padding: 3px;
        }

        .logo-left {
            position: absolute;
            left: 50px;
        }

        .logo-right {
            position: absolute;
            right: 50px;
            top: 20px;
        }

        .headings {
            text-align: center;
            /* line-height: 2; */
            color: #3a3a3a;
            margin-bottom: 20px;
        }

        h5 {
            margin: 0;
            padding: 0;
            font-size: 14px;
            text-transform: uppercase;
        }

        .left {
            text-align: left;
        }

        .pageBreak {
            page-break-before: always;
        }

        .icon {
            width: 17px;
            height: 17px;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text {
            font-size: 12px;
        }

        .line {
            width: 100%;
            height: 1px;
            background: #1e272e;
            display: inline-block;
            margin: 2px 0;
        }
    </style>

</head>

<body>

    <header>
        <div class="wrapper">
            <div class="logo-left">
                <img src='data:image/jpeg;base64,<?= coatOfArm() ?>' alt="">
            </div>
            <div class="headings">
                <h5><b>THE UNITED REPUBLIC OF TANZANIA</b></h5>
                <h5><b>MINISTRY OF INDUSTRY AND TRADE </b></h5>
                <h5>WEIGHTS AND MEASURES AGENCY </h5>
                <h5>WATER METER VERIFICATION REPORT</h5>


            </div>
            <div class="logo-right">
                <img src='data:image/jpeg;base64,<?= wmaLogo() ?>' alt="">
            </div>
        </div>

    </header>
    <div class="container">
        <table border="0" style="width: 40%; margin-top:41px;">
            <tr>
                <td><b>Client:</b></td>
                <td><?= $report[0]->name ?></td>
            </tr>
            <tr>
                <td><b>Brand Name:</b></td>
                <td><?= $report[0]->brand ?></td>
            </tr>
            <tr>
                <td><b>Meter Size:</b></td>
                <td><?= $report[0]->meter_size ?>mm</td>
            </tr>
            <tr>
                <td><b>Flow Rate:</b></td>
                <td><?= $report[0]->flow_rate ?> <sup>3</sup>/h</td>
            </tr>
            <tr>
                <td><b>Testing Center:</b></td>
                <td><?= $report[0]->lab ?></td>
            </tr>
            <tr>
                <td><b>Testing Method:</b></td>
                <td><?= $report[0]->testing_method ?></td>
            </tr>
            <tr>
                <td><b>Testing Date:</b></td>
                <td><?= dateFormatter($report[0]->created_at) ?></td>
            </tr>
            <tr>
                <td><b>Verified By:</b></td>
                <td><?= $report[0]->verifier ?></td>
            </tr>

        </table>
        <table class="table" border="1">
            <thead>
                <th>No.</th>
                <th>Meter Serial No.</th>
                <th>Initial Reading</th>
                <th>Final Reading</th>
                <th>Indicated Volume Vi(L)</th>
                <th>Actual Volume Va(L)</th>
                <th>% Error</th>
                <th>Decision</th>

            </thead>
            <?php $index = 1;  ?>

            <tbody>
                <?php foreach ($report as $meter) : ?>
                    <tr class="row">
                        <td><?= $index++ ?></td>
                        <td><?= $meter->serial_number ?></td>
                        <td><?= $meter->initial_reading ?></td>
                        <td><?= $meter->final_reading ?></td>
                        <td><?= $meter->indicated_volume ?></td>
                        <td><?= $meter->actual_volume ?></td>
                        <td><?= $meter->error ?></td>
                        <td><?= $meter->decision ?></td>
                    </tr>
                <?php endforeach; ?>



            </tbody>



        </table>



<br>
        <table class="table text-bold">
            <tr>
                <td>
                    <h4><b>Verifier</b></h4>
                    <?= $report[0]->first_name .' '.$report[0]->last_name  ?><br>
                   
                    Weights & Measures Officer <br>
                    Weights & Measures Agency
                    
                </td>

                <td>
                    <b>Authorizes Client Representative</b> <br>
                    <?= $report[0]->name ?>


                </td>
            </tr>
        </table>
    </div>
</body>

</html>