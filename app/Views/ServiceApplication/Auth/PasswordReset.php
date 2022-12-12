<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="description" content="Responsive Admin Template" />
    <meta name="author" content="SmartUniversity" />
    <title>Password Reset </title>
    <!-- icons -->
    <link href="<?= base_url() ?>/ServiceApplication/assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/ServiceApplication/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!--bootstrap -->
    <link href="<?= base_url() ?>/ServiceApplication/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Material Design Lite CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/ServiceApplication/assets/plugins/material/material.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/ServiceApplication/<?= base_url() ?>/ServiceApplication/assets/css/material_style.css">
    <!-- animation -->
    <link href="<?= base_url() ?>/ServiceApplication/assets/css/pages/animate_page.css" rel="stylesheet">
    <!-- Template Styles -->
    <link href="<?= base_url() ?>/ServiceApplication/assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/ServiceApplication/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/ServiceApplication/assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/ServiceApplication/assets/css/theme-color.css" rel="stylesheet" type="text/css" />
    <!-- dropzone -->
    <link href="<?= base_url() ?>/ServiceApplication/assets/plugins/dropzone/dropzone.css" rel="stylesheet" media="screen">
    <!-- Date Time item CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/ServiceApplication/assets/plugins/flatpicker/flatpickr.min.css">
    <!-- favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/wma1.png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



    <style>
        .swal-button {
            padding: 7px 19px;
            border-radius: 2px;
            background-color: #B64B11;
            font-size: 12px;
            border: 1px solid #e1e1e1;
            text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.3);
        }

        .swal-button-container .swal-button--danger {

            background: #B64B11 !important;

        }


        .swal-button--cancel {

            background-color: #333 !important;
            color: #fff !important;

        }

        .swal-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 300;
        }

        .swal-button--confirm:hover,
        .swal-button-container .swal-button--danger:hover {
            background-color: #e56824 !important;
            border-radius: 2px;
        }

        .swal-button--cancel:hover {
            background-color: #555 !important;
            border-radius: 2px;
        }

        #logo img {
            border: 3px solid #333;
            padding: 5px;
            width: 100px;
            height: 95px;
            border-radius: 50%;
            background-color: #fff;
        }

        .wrapper1 {
            width: 100%;
            height: 100vh;
            overflow: auto;
            scrollbar-width: thin;
            scrollbar-color: #777;
        }

        ul {
            list-style-type: none;
        }

        #image {
            width: 50px;
            text-align: center;
        }

        #heading {
            font-size: 11.1rem;
 
            line-height: 1;

        }

        @media screen and(max-width:620px) {
            .wrapper1 {
                width: 100%;
                height: 100%;
            }

            #heading {
                font-size: 1.5rem;
                margin: 1px 0;
                line-height: 1.2;

            }

        }



        body {
            background: #e1e1e1;
        }
    </style>
</head>

<body style="overflow-x:hidden ; ">

    <section>
        <div class="page-content-wrapper1">
            <div class="page-content4">
                <div class="row">
                    <div class="col-md-12  p-5 text-white  wrapper1  scrollBar">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-6 text-center" id="logo">
                                <img src="<?= base_url() ?>/assets/images/wma1.png" alt="wma logo">
                            </div>
                        </div>
                        <h3 class="text-center   text-dark" id="heading">WEIGHTS AND MEASURE AGENCY</h3>
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-6">
                                <div class="card text-dark p-4">
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-md-6 text-center">

                                            <img id="image" src="<?= base_url() ?>/ServiceApplication/assets/img/reset.png" alt="Reset Password">
                                        </div>
                                    </div>
                                    <h4 class="text-center">Check your email to reset your password</h4>
                                    <p>We have sent message to <b><?=$email ?></b> with link to set up your new password</p>
                                    <p>If you do not get an email from us within few minutes </p>
                                    <ul class="p-0 m-0">
                                        <li> -Check your spam folder</li>
                                        <li> -Your email address might have a typo error</li>

                                    </ul>
                                   
                                </div>
                            </div>
                        </div>




                    </div>

                </div>

            </div>
        </div>
    </section>



    <script>

    </script>
    <!-- start js include path -->
    <script data-cfasync="false" src="../../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="<?= base_url() ?>/ServiceApplication/assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/ServiceApplication/assets/plugins/popper/popper.min.js"></script>
    <script src="<?= base_url() ?>/ServiceApplication/assets/plugins/jquery-blockui/jquery.blockui.min.js"></script>
    <script src="<?= base_url() ?>/ServiceApplication/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- bootstrap -->
    <script src="<?= base_url() ?>/ServiceApplication/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Common js-->
    <script src="<?= base_url() ?>/ServiceApplication/assets/js/app.js"></script>
    <script src="<?= base_url() ?>/ServiceApplication/assets/js/layout.js"></script>
    <script src="<?= base_url() ?>/ServiceApplication/assets/js/theme-color.js"></script>
    <!-- Material -->
    <script src="<?= base_url() ?>/ServiceApplication/assets/plugins/material/material.min.js"></script>
    <script src="<?= base_url() ?>/ServiceApplication/assets/js/pages/material_select/getmdl-select.js"></script>
    <!-- dropzone -->
    <script src="<?= base_url() ?>/ServiceApplication/assets/plugins/dropzone/dropzone.js"></script>
    <script src="<?= base_url() ?>/ServiceApplication/assets/plugins/dropzone/dropzone-call.js"></script>
    <!-- date and time 	 -->
    <script src="<?= base_url() ?>/ServiceApplication/assets/plugins/flatpicker/flatpickr.min.js"></script>
    <script src="<?= base_url() ?>/ServiceApplication/assets/js/pages/datetime/datetime-data.js"></script>
    <!-- animation -->
    <script src="<?= base_url() ?>/ServiceApplication/assets/js/pages/ui/animations.js"></script>
    <!-- end js include path -->
    <script src="<?= base_url() ?>/dist/js/inputMaskLibrary.js"></script>
    <script src="<?= base_url() ?>/dist/js/inputMask.js"></script>
</body>


</html>