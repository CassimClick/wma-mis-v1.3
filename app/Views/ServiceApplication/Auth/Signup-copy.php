<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="description" content="Responsive Admin Template" />
    <meta name="author" content="SmartUniversity" />
    <title><?= $page->title ?></title>
    <!-- icons -->
    <link href="<?= base_url() ?>/ServiceApplication/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>/ServiceApplication/assets/plugins/iconic/css/material-design-iconic-font.min.css">
    <!-- bootstrap -->
    <link href="<?= base_url() ?>/ServiceApplication/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- style -->
    <link rel="stylesheet" href="<?= base_url() ?>/ServiceApplication/assets/css/pages/extra_pages.css">
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
    <!-- favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>/ServiceApplication/assets/img/favicon.ico" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
    </style>
</head>

<body>
    <div class="limiter">
        <div class="container-login100 page-background">
            <div class="wrap-login100">
                <form class="login100-form validate-form" id="signupForm">
                    <span class="login100-form-logo">
                        <img src="<?= base_url() ?>/assets/images/wma1.png" alt="">
                    </span>
                    <span class="login100-form-title text-sm p-b-10 p-t-17">
                        Registration
                    </span>
                    <div class="text-center text-white mb-2" id="loader" style="display:none;">
                        <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 p-t-10">
                            <div class="wrap-input100 validate-input" data-validate="Enter Nida Number">
                                <input class="input100" type="text" name="nationalId" id="nationalId" placeholder="Nida Number" oninput="verifyNida(this)">
                                <span class="focus-input100" data-placeholder="&#xf207;"></span>
                            </div>
                        </div>
                        <div class="col-lg-12 p-t-10 input-name" style="display: none;">
                            <div class="wrap-input100 validate-input">
                                <input class="input100" type="text" name="firstName" id="firstName" placeholder="First name" disabled>
                                <span class="focus-input100" data-placeholder="&#xf207;"></span>
                            </div>
                        </div>
                        <div class="col-lg-12 p-t-10 input-name" style="display: none;">
                            <div class="wrap-input100 validate-input">
                                <input class="input100" type="text" name="middleName" id="middleName" placeholder="Middle name" disabled>
                                <span class="focus-input100" data-placeholder="&#xf207;"></span>
                            </div>
                        </div>
                        <div class="col-lg-12 p-t-20">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                <input class="mdl-textfield__input" type="text" id="txtCity">
                                <label class="mdl-textfield__label">City</label>
                            </div>
                        </div>
                        <div class="col-lg-12 p-t-10 input-name" style="display: none;">
                            <div class="wrap-input100 validate-input">
                                <input class="input100" type="text" name="lastName" id="lastName" placeholder="Last name" disabled>
                                <span class="focus-input100" data-placeholder="&#xf207;"></span>
                            </div>
                        </div>

                        <div class="col-lg-12 p-t-20">
                            <div class="wrap-input100 validate-input" data-validate="Enter email">
                                <input class="input100" type="email" name="email" placeholder="Email">
                                <span class="focus-input100" data-placeholder="&#xf207;"></span>
                            </div>
                        </div>

                        <div class="col-lg-12 p-t-10">
                            <div class="wrap-input100 validate-input" data-validate="Enter password">
                                <input class="input100" type="password" name="password" placeholder="Password">
                                <span class="focus-input100" data-placeholder="&#xf191;"></span>
                            </div>
                        </div>
                        <div class="col-lg-12 p-t-10">
                            <div class="wrap-input100 validate-input" data-validate="Enter password again">
                                <input class="input100" type="password" name="password2" placeholder="Confirm password">
                                <span class="focus-input100" data-placeholder="&#xf191;"></span>
                            </div>
                        </div>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Sign In
                        </button>
                    </div>
                    <div class="text-center p-t-90">
                        <a class="txt1" href="#">
                            You already have a membership?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const loader = document.querySelector('#loader')


        function requestOnProgress() {
            loader.style.display = 'block'
        }

        function requestDone() {
            loader.style.display = 'none'
        }

        function showHideInputs(property) {
            const inputs = document.querySelectorAll('.input-name')
            for (input of inputs) {
                input.style.display = property
            }

        }

        function hideInputs() {

        }

        function verifyNida(nationalId) {

            //19940408231130000125
            if (nationalId.value.length == 20) {

                const data = {
                    nationalId: nationalId.value
                };
                requestOnProgress()
                fetch('<?= base_url() ?>/license-application/verifyNida', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        const firstName = document.querySelector('#firstName')
                        const middleName = document.querySelector('#middleName')
                        const lastName = document.querySelector('#lastName')
                        const userData = data.user
                        if (data.status == 1) {
                            nationalId.setAttribute('disabled', 'disabled')
                            requestDone()
                            showHideInputs('block')
                            firstName.value = userData.FirstName
                            middleName.value = userData.MiddleName
                            lastName.value = userData.LastName
                            // window.location = 'dashboard'
                        } else {
                            nationalId.removeAttribute('disabled', 'disabled')
                            requestDone()
                            showHideInputs('none')
                            swal({
                                title: data.msg,
                                icon: "warning",
                                timer: 4500
                            });
                        }
                        console.log(data);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });


            } else {
                console.log('nida incomplete')
            }


        }
    </script>
    <!-- start js include path -->
    <script src="<?= base_url() ?>/ServiceApplication/assets/plugins/jquery/jquery.min.js"></script>
    <!-- bootstrap -->
    <script src="<?= base_url() ?>/ServiceApplication/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/ServiceApplication/assets/js/pages/extra_pages/login.js"></script>
    <!-- end js include path -->
</body>


</html>