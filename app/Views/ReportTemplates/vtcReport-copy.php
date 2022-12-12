<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>pdf</title>
    <style>
    * {
        /* padding: 0;
        margin: 0; */
        box-sizing: border-box;
        font-family: sans-serif;
    }

    header,
    section,
    aside {
        margin: 0 1.5% 10px 1.5%;
    }

    section {
        float: left;
        width: 30%;
    }


    .contacts {
        clear: both;
        margin-bottom: 0;
    }

    .left,
    .right {
        width: 20%;
    }

    .right img {
        float: right;
    }

    .middle {
        width: 50%;
    }

    .headings {
        /* margin-top: 10px; */
        text-align: center;
        line-height: 1;
    }

    .headings h5 {
        margin: 5px;
    }

    .center {
        text-align: center;
    }

    .contacts {
        width: 100%;



    }

    .contacts p {
        margin: 0;
        padding: 0;
        margin-top: -30px;
    }

    .contacts h5 {
        margin: 0;
        padding: 0;
        /* margin-top: -30px; */
    }

    .report {
        width: 100%;
        margin-top: 60px;
    }

    .mainTable {
        width: 100%;
        border-collapse: collapse;
        color: #222;
        font-size: 14px;

    }

    .mainTable td {
        padding: 7px;
        text-align: left;
        border-bottom: 1px solid #333;
    }

    .mainTable th {
        padding: 10px;
        text-align: left;
        background: #e6e6e6;
    }


    .summary table {

        width: 40%;
        position: absolute;
        right: 0;
        border-collapse: collapse;
        color: #222;
        font-size: 14px;
    }


    .summary table td {
        padding: 7px;
        text-align: left;
        border-bottom: 1px solid #333;

    }
    </style>
</head>

<body>
    <!-- <header>
        <code>&#60;header&#62;</code>
        <?=base_url()?>/
    </header> -->

    <header>
        <section class="left">
            <img src="assets/images/emblem.png" alt="">
        </section>

        <section class="middle">
            <div class="headings">
                <h5><b>THE UNITED REPUBLIC OF TANZANIA</b></h5>
                <h5><b>MINISTRY OF INDUSTRY AND TRADE </b></h5>
                <h5>WEIGHTS AND MEASURES AGENCY </h5>
            </div>
        </section>

        <section class="right">
            <img src="assets/images/wma1.png" alt="" width="120px">
        </section>
    </header>
    <div class="contacts">
        <p class="center"> Tel: 0788 5665 6565 Fax: 233 165 6 , P O Box 154 Tanga', wma@info.go.tz</p>
        <h5 class="center">VTC VTC</h5>
    </div>

    <section class="report">

        <table class="mainTable" border="0">
            <thead>
                <tr>
                    <th>Owner Name</th>
                    <th>Phone Number</th>
                    <th>Vehicle Brand</th>
                    <th>Plate Number</th>
                    <th>Capacity</th>
                    <th>Amount</th>
                    <th>Control Number</th>
                    <th>Status</th>

                </tr>
            </thead>
            <tbody>
                <tr>

                </tr>




            </tbody>
            <tfoot></tfoot>
        </table>



        <div class="summary">

            <table border="0">
                <tr>
                    <td>
                        <h3>Collection Summary</h3>
                    </td>
                    <td></td>

                </tr>
                <tr>
                    <td><b>Paid Amount</b></td>

                </tr>
                <tr>
                    <td><b>Pending Amount</b></td>

                </tr>
                <tr>
                    <td><b>Total Amount</b></td>

                </tr>
            </table>
        </div>


    </section>