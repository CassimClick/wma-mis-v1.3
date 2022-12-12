<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/wma1.png" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/bootstrap.css">
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/dist/js/bootstrap.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <title><?= $page['title'] ?></title>
    <style>
        body {
            overflow: hidden;
            /* height: 100%; */
            font-family: 'Nunito', sans-serif;
        }

        h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
        }





        .authentication {
            margin-top: 3.4rem;
            height: 350px;
            /* background: green; */
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            padding: 0;
            border-radius: 5px;
            /* width: 60vw; */
            overflow: hidden;
            /* margin-right: -1rem; */
        }

        /* #box-x {
            display: block;
            width: 500px !important;
        } */

        .slide {
            height: 350px;
            overflow: hidden;
        }

        .slide img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            overflow: hidden;
        }

        .form-box {
            padding-right: 2.5rem;
            padding-top: 4rem;
            /* width: 100%; */
        }

        .mg {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }



        @media screen and (max-width:640px) {
            .hide {
                display: none;
            }

            body {
                height: 100%;
            }

            h5 {
                margin: 0;
                font-size: 0.6rem;
            }

            .authentication {
                margin-top: 2rem;
                width: 90vw;
                /* height: 100%; */
                /* background: green; */
                /* overflow: hidden; */
                box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
                padding: 0;
                margin-left: 0;

            }

            .mg {
                padding: 2rem;

            }

            .form-box {
                padding: 2.5rem;

            }

            /* .auth-nav {
                padding: 0;

            } */

            /* #login {
                padding: 2rem;
                di
            } */
        }
    </style>
</head>

<body>
    <?php $pageSession = \CodeIgniter\Config\Services::session(); ?>
    <nav class="auth-nav">
        <img class="auth-logo" src="<?= base_url() ?>/assets/images/emblem.png" alt="">
        <div class="heading text-center">
            <h5>THE UNITED REPUBLIC OF TANZANIA</h5>
            <h5>WEIGHTS AND MEASURES AGENCY</h5>
            <h5>MANAGEMENT INFORMATION SYSTEM (WMA-MIS)</h5>
        </div>
        <img class="auth-logo" src="<?= base_url() ?>/assets/images/wma1.png" alt="">
    </nav>

    <main id="login">
        <!-- Carousel -->





        <div>
            <div class="row ">
                <div class="mg">
                    <div class="col-md-8 authentication" id="box-x">
                        <div class="row">
                            <div class="col-md-6 hide">
                                <div id="carouselId" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carouselId" data-slide-to="0" class="active"></li>
                                        <li data-target="#carouselId" data-slide-to="1"></li>
                                        <li data-target="#carouselId" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner" role="listbox">
                                        <div class="carousel-item active">
                                            <img src="<?= base_url('assets/images/slide1.JPG') ?>" alt="First slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?= base_url('assets/images/slide2.JPG') ?>" alt="Second slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?= base_url('assets/images/slide3.JPG') ?>" alt="Third slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?= base_url('assets/images/slide4.JPG') ?>" alt="Fourth slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?= base_url('assets/images/slide5.JPG') ?>" alt="Fifth slide">
                                        </div>
                                    </div> 
                                    <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 form-box">
                                <?php if ($pageSession->getFlashdata('Success')) : ?>
                                    <div id="message" class="alert alert-success text-center" role="alert">
                                        <?= $pageSession->getFlashdata('Success'); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($pageSession->getFlashdata('error')) : ?>
                                    <div id="message" class="alert alert-danger text-center" role="alert">
                                        <?= $pageSession->getFlashdata('error'); ?>
                                    </div>
                                <?php endif; ?>
                                <?= form_open() ?>
                                <div class="sign text-centecr">
                                    <!-- <p class="sign__input">Log in to continue </p> -->

                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control" placeholder="Enter your email" value="<?= set_value('email') ?>">
                                        <span class="text-danger"><?= displayError($validation, 'email') ?></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Enter your password" value="<?= set_value('password') ?>">
                                        <span class="text-danger"><?= displayError($validation, 'password') ?></span>
                                    </div>
                                </div>

                                <div class="option">
                                    <div class="option__item">
                                        <button style="background: #DB611E;" type="submit" class="button">Login</button>
                                    </div>

                                </div>

                                </form>
                            </div>
                        </div>


                    </div>



                </div>
            </div>

            <p class="text-center pt-2">For any technical inquiry,please contact ICT technical team <b>ictsupport@wma.go.tz</b></p>
            <p class="text-center">Copyright &copy; <?= date('Y') ?> All rights reserved</p>
        </div>
        </div>
    </main>

    <script>
        setInterval(function() {
            $('#message').fadeOut(7000)
        });
    </script>

</body>

</html>