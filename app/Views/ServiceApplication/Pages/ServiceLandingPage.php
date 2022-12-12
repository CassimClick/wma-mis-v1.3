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
                <h2>WELCOME TO WMA ONLINE SERVICE APPLICATION </h2>
            </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="mb-30 col-md-6 col-lg-4">
                <div class="card">
                    <img class="card-icon" src="<?= base_url('assets/images/customer-service.png') ?>" alt="monitoring">
                    <h3 class="card-title">New Application</h3>
                    <p class="card-text">This service allow a prospecting customer to requests For Approval of New Measures.</p>
                    <a class="card-link" href="<?= base_url('service-request/how-to-request-service') ?>">Learn more</a>
                </div>
            </div>
            <div class="mb-30 col-md-6 col-lg-4">
                <div class="card">
                    <img class="card-icon" src="<?= base_url('assets/images/certificate.png') ?>" alt="monitoring">
                    <h3 class="card-title">License Application</h3>
                    <p class="card-text">This service allow a prospecting customer to request For the License.</p>
                    <a class="card-link" href="<?= base_url('service-request/how-to-apply-license') ?>">Learn more</a>
                </div>
            </div>
            <div class="mb-30 col-md-6 col-lg-4">
                <div class="card">
                    <img class="card-icon" src="<?= base_url('assets/images/registration-form.png') ?>" alt="team management">
                    <h3 class="card-title">Application status </h3>
                    <p class="card-text">Follow up an application.</p>
                    <a class="card-link" href="#">Learn more</a>
                </div>
            </div>

        </div>
    </div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center">Weights And Measures Agency &copy; <?= date('Y') ?></p>
                </div>

            </div>
        </div>
    </footer>
</body>

</html>