<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('ServiceApplication/css/landing.css') ?>">
    <title>WMA-OSA</title>
</head>

<body>
    <nav>
        <div class="logo">
            WMA-OSA
        </div>

    </nav>
    <section class="banner">
        <div class="overlay"></div>
        <div class="container">
            <div class="banner-text">
                <h2><?= $page->heading ?></h2>
            </div>
    </section>

    <div class="container">
        <div class="">
            <h3>Requirements/Conditions:</h3>
            <p>The following documents will be required during license application</p>
            <ul style="list-style: none;margin:0;padding:0;">
                <li>1. Copy of receipt of application payment</li>
                <li>2. Valid business license</li>
                <li>3. Tax Payer Identification Number (TIN)</li>
                <li>4 Certificate of tax clearance</li>
                <li>5. Certificate of registration/incorporation from BRELA</li>
                <li>6. Identity Card (Nation ID/Driver's License/Voter ID)</li>
                <li>7 .Working Permit for non-citizen of Tanzania</li>

            </ul>

            <h3>License Categories.</h3>

            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Descriptions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>A</td>
                        <td>To install, overhaul, service or repair all types of weighing instruments throughout the Mainland Tanzania.</td>
                    </tr>
                    <tr>
                        <td>B</td>
                        <td>To install, overhaul, service or repair not more than six and not less than four types of Measuring Instrument or Systems throughout the Mainland Tanzania.</td>
                    </tr>
                    <tr>
                        <td>C</td>
                        <td>To install, overhaul, service or repair not more than three types of weighing instruments throughout the Mainland Tanzania.</td>
                    </tr>
                    <tr>
                        <td>D</td>
                        <td>To erect, install, overhaul, adjust, service or repair measuring of Liquid Measuring Pumps and Flow Meters throughout the Mainland Tanzania.</td>
                    </tr>
                    <tr>
                        <td>E</td>
                        <td>To manufacture the weighing/measuring instruments or systems throughout the Mainland Tanzania</td>
                    </tr>
                    <tr>
                        <td>Gas meters calibrators</td>
                        <td>To Calibrate Gas flow Meters throughout the Mainland Tanzania</td>
                    </tr>
                    <tr>
                        <td>Pressures gauges &amp; valves calibrators</td>
                        <td>To calibrate Pressures gauges &amp; valves throughout the Mainland Tanzania</td>
                    </tr>


                </tbody>
            </table>
            <h3>Requirements/Conditions:</h3>
            <p>The following documents will be required during license application</p>



            <h3>Cost</h3>
            <p>The application fee is Shs. 50,000/= for a Tanzanian and Sh. 200,000/= for a non-citizen of Tanzania.</p>
            <p>License fee (will depend on the type of license as seen in Section A 5(a)), the cost of each license is as follows:</p>

            <ul style="list-style: none;margin:0;padding:0;">
                <li> <i class="fas fa-arrow-right"></i> Class 'A' License Sh. 100,000/= </li>
                <li><i class="fas fa-arrow-right"></i> Class 'B' License Sh. 75,000/=, </li>
                <li><i class="fas fa-arrow-right"></i> Grade 'C' License Sh. 50.000/=, </li>
                <li><i class="fas fa-arrow-right"></i> Grade 'D' License Sh. 250,000/=</li>
                <li><i class="fas fa-arrow-right"></i> Grade 'E' license Tsh. 300,000/= </li>
                <li><i class="fas fa-arrow-right"></i> Tank Calibration License Tsh 400,000 (Tank Calibration License)</li>
                <li><i class="fas fa-arrow-right"></i> License to create tanks Tsh 800,000-(Tank Fabrication) </li>
                <li><i class="fas fa-arrow-right"></i> Application fee for Accredited meter verifier Tsh 500,000-(Accredited meter Verifier)</li>
                <li><i class="fas fa-arrow-right"></i> Accredited meter verifier license Tsh 2,000,000-(Accredited meter verifier)</li>

            </ul>
        </div>

        <a href="<?=base_url('service-request/login')?>" class="button">Apply Now</a>
    </div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center">Weights And Measure Agency &copy; <?= date('Y') ?></p>
                </div>

            </div>
        </div>
    </footer>
</body>

</html>