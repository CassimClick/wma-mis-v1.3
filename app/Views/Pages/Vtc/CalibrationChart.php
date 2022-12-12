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
                <h5>VERIFICATION CHART NO <?= $chart->chartNumber ?></h5>
                <h5>FOR: TANK/TR <?= $chart->plateNumber ?></h5>
                <h5>FOR: <?= $chart->customer ?></h5>
                <h5>CAPACITY: <?= $chart->capacity ?> LITRE</h5>

            </div>
            <div class="logo-right">
                <img src='data:image/jpeg;base64,<?= wmaLogo() ?>' alt="">
            </div>
        </div>

    </header>
    <div class="container">
        <table class="table">


            <tbody>
                <tr class="row" id="upperChart">
                    <?= $chart->upperChart ?>
                </tr>


            </tbody>



        </table>
        <span class="line"></span>


        <table class="table text-bold">
            <tr class="row">
                <td class="col-md-6">The dipsticks were marked</td>
                <td class="col-md-6">
                    <span id="chartNumber"><?= $chart->chartNumber ?></span></br>
                    <span id="customer"><?= $chart->customer ?></span></br>
                    <span id="plateNumber"><?= $chart->plateNumber ?></span></br>
                </td>
            </tr>
            <br>

            <tr class="row" id="lowerChart">
                <?= $chart->lowerChart ?>

            </tr>
        </table>
        <span class="line"></span>
        <span class="text-bold text">The tank was verified &nbsp; 1. On a level plane 2 . against approved measure</><br>
            NOTE (a) the compartments should be filled in the order &nbsp; <span id="fillOrder"><?= $chart->fillOrder ?></span> and emptied in the order &nbsp; <span id="emptyOrder"><?= $chart->emptyOrder ?></span> <br>
            (b) THIS TANK SHALL BE VERIFIED AGAIN IF SUSPECTED OF GIVING INCORRECT MEASUREMENTS BUT IN ANY CASE NOT LATER THAN <span id="nextVerification"><?= $chart->nextVerification ?></span>
            <table class="table text-bold">
                <tr>
                    <td>
                        DATE: <?= $chart->verificationDate ?> <br>
                        <span>DISTRIBUTION OF COPIES:-</span> <br>
                        1. <?= $chart->customer ?> <br>
                        2. Weights & Measures Agency,
                          <br> P.o Box 313 Dar Es Salaam
                    </td>
                    <td class="text-x">
                        <span>REGIONAL MANAGER</span> <br>
                        ILALA<br>
                    </td>
                    <td>
                        <div class="p-1" style="border:1px solid gray;height:130px; width:130px;padding:2px; font-size:10px;text-align:center">
                            WMA OFFICIAL SEAL
                        </div>
                    </td>
                </tr>
            </table>
    </div>
</body>

</html>