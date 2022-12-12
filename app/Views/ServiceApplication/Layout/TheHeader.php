<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="description" content="Responsive Admin Template" />
    <meta name="author" content="SmartUniversity" />
    <title>WMA - License Application</title>
    <!-- icons -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--bootstrap -->
    <link href="<?= base_url() ?>/ServiceApplication/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/ServiceApplication/assets/plugins/summernote/summernote.css" rel="stylesheet">

    <!-- Material Design Lite CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/ServiceApplication/assets/plugins/material/material.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/ServiceApplication/assets/css/material_style.css">
    <!-- animation -->
    <link href="<?= base_url() ?>/ServiceApplication/assets/css/pages/animate_page.css" rel="stylesheet">
    <!-- Template Styles -->
    <link href="<?= base_url() ?>/ServiceApplication/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/ServiceApplication/assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/ServiceApplication/assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/ServiceApplication/assets/css/theme-color.css" rel="stylesheet" type="text/css" />
    <script src="<?= base_url() ?>/ServiceApplication/assets/plugins/jquery/jquery.min.js"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.0.279/pdf.min.js" integrity="sha512-QJy1NRNGKQoHmgJ7v+45V2uDbf2me+xFoN9XewaSKkGwlqEHyqLVaLtVm93FzxVCKnYEZLFTI4s6v0oD0FbAlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.8/pdfobject.min.js" integrity="sha512-MoP2OErV7Mtk4VL893VYBFq8yJHWQtqJxTyIAsCVKzILrvHyKQpAwJf9noILczN6psvXUxTr19T5h+ndywCoVw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/wma1.png" />

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
            font-weight: 300;
            font-size: 20px;
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

        .show-hide {
            border: 1px solid #e1e1e1;
            border-radius: 5px;
            margin: 0 1.2rem !important;
            padding: 1rem;
            width: 100%;
        }

        #class_a,
        #class_b,
        #class_c,
        #class_d,
        #class_e,
        #tank_calibration_license,
        #gas_meter_calibration_license,
        #pressures_gauges_and_valves_calibration_license {
            display: none;
        }

        .progress {
            height: 15px;
            /* background: #B64B11;
            color: #fff; */
        }


        .progressEdit {
            /* height: px !important; */
            /* background: #B64B11;
            color: #fff; */
            height: 15px;
            text-align: center;
        }

        .progress-bar {

            background: #DB611E;
            color: #fff;
        }

        .progress-barEdit {

            background: #DB611E;
            height: 15px !important;
            color: #fff;
        }

        .shade {
            background: #777;
            color: #fff;
        }
    </style>
</head>
<!-- END HEAD -->

<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white dark-sidebar-color logo-dark">
    <div class="page-wrapper">
        <!-- start header -->
        <div class="page-header navbar navbar-fixed-top">
            <div class="page-header-inner ">
                <!-- logo start -->
                <div class="page-logo">
                    <a href="#">
                        <!-- <img alt="" src="<?= base_url() ?>/assets/images/wma1.png"> -->
                        <span class="logo-default">WMA-OSA</span>
                    </a>
                </div>
                <!-- logo end -->
                <ul class="nav navbar-nav navbar-left in">
                    <li><a href="#" class="menu-toggler sidebar-toggler"><i class="fa fa-navicon"></i></a></li>
                </ul>

                <!-- start mobile menu -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    <span></span>
                </a>
                <!-- end mobile menu -->
                <!-- start header menu -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- start notification dropdown -->

                        <!-- end message dropdown -->
                        <!-- start manage user dropdown -->
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle " src="<?= base_url() ?>/ServiceApplication/assets/img/avatar.png" />
                                <span class="username username-hide-on-mobile"> <?= $user->first_name . ' ' . $user->last_name ?> </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default animated jello">
                                <!-- <li>
                                    <a href="user_profile.html">
                                        <i class="icon-user"></i> Profile </a>
                                </li> -->
                                <!-- <li>
                                    <a href="#">
                                        <i class="icon-settings"></i> Settings
                                    </a>
                                </li> -->
                                <li>
                                    <a href="#">
                                        <i class="fa-solid fa-question"></i> Help
                                    </a>
                                </li>
                                <li class="divider"> </li>

                                <li>
                                    <a href="<?= base_url('service-request/user-logout') ?>">
                                        <i class="fa-solid fa-right-from-bracket"></i> Log Out </a>
                                </li>
                            </ul>
                        </li>
                        <!-- end manage user dropdown -->

                    </ul>
                </div>
            </div>
        </div>
        <!-- end header -->