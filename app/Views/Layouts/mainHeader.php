<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= $page['title']; ?></title>

    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/wma1.png" type="image/x-icon">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">

    <!-- iCheck for checkboxes and radio inputs -->

    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>

    <!-- Jquery Validator -->
    <script src="<?= base_url() ?>/dist/js/additional-methods.min.js"></script>
    <script src="<?= base_url() ?>/dist/js/jquery.validate.min.js"></script>


    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/progress.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


    <!-- Data Tables -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/timePicker.css">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- ============================================= -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css"> -->
    <!-- =============== -->
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">



    <!-- light box -->
    <!-- <link href="path/to/lightbox.css" rel="stylesheet" />
    <script src="path/to/lightbox.js"></script> -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->
    <script src="<?= base_url() ?>/dist/js/sweetalert.js"></script>
    <script src="<?= base_url() ?>/dist/js/axios.js"></script>
    <script src="<?= base_url() ?>/dist/js/apexCharts.js"></script>
    <!-- <script src="<?= base_url() ?>/dist/js/prepackage.js"></script> -->


    <!-- input Mask -->

    <!-- <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script> -->



    <style>
        ::selection {
            background: transparent;
            /* WebKit/Blink Browsers */
        }

        ::-moz-selection {
            background: transparent;
            /* Gecko Browsers */
        }

        .error {

            color: #dc3545;
        }

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

        /* 
        .swal-button-container .swal-button--danger:hover {

           
           
            background-color: #B64B11 !important;
        } */

        .tableData {
            padding: 0px !important
        }

        .bill-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        /* 
        .modal-body-wrapper {
            overflow-y: scroll;
            height: 60vh;
        } */

        @media print {
            .modal-body-wrapper {
                position: relative;

            }

            .bill-header {
                display: flex;
                justify-content: space-between;
                margin-bottom: 1rem;
            }

            #modal-body {
                /* margin-top: -67.5rem; */
                position: absolute;
                top: 0;
                font-size: 1.2rem;
                margin: 0 20px;

                -webkit-margin: 0px 20px;
                -moz-margin: 0px 20px;
                -ms-margin: 0px 20px;
                -o-margin: 0px 20px;


                padding: 0;
                /* background-color: #dc3545 !important; */
            }

            body * {
                /* padding: 0;
                margin: 0; */
                visibility: hidden;

            }

            #modal-body,
            #modal-body * {
                /* font-size: 1.3rem; */

                /* margin-top: -80px; */
                /* padding: 0; */
                visibility: visible;

            }




        }
        .shade{
            background-color: #555;
            color: #fff;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="far fa-bars"></i></a>
                </li>



            </ul>

            <!-- SEARCH FORM -->
            <!-- <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="far fa-search"></i>
                        </button>
                    </div>
                </div>
            </form> -->
            <img class="avatar  " src="<?= base_url() ?>/assets/images/emblem.png" alt="User profile picture">


            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown d-sm-inline-block mr-4">

                    <a href="#" data-toggle="dropdown">
                        <div class="img-box">

                            <img class="avatar  " src="<?= base_url() ?>/assets/images/wma1.png" alt="User profile picture">
                        </div>

                    </a>
                    <!-- <div class="dropdown-menu dropdown-menu-md dropdown-menu-right mt-2">
                        <a href="#" class="dropdown-item">
                            <span> <?= ucfirst($profile->first_name) . ' ' . ucfirst($profile->last_name) ?></span>

                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url() ?>/changePassword" class="dropdown-item">
                            <i class="far fa-key mr-2  "></i>Change Password

                        </a>
                        <div class="dropdown-divider"></div>
                        <?php if ($role == 1) : ?>
                        <a href="<?= base_url() ?>/profile" class="dropdown-item">
                            <i class="far fa-user mr-2  "></i>My Profile
                        </a>
                        <?php elseif ($role == 2) : ?>
                        <a href="<?= base_url() ?>/managerProfile" class="dropdown-item">
                            <i class="far fa-user mr-2  "></i>My Profile
                        </a>
                        <?php endif; ?>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url() ?>/logout" class="dropdown-item">
                            <i class="far fa-power-off mr-2  "></i>Log Out

                        </a>

                    </div> -->
                </li>

            </ul>
        </nav>