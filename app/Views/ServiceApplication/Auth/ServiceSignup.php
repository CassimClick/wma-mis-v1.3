<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="description" content="Responsive Admin Template" />
    <meta name="author" content="SmartUniversity" />
    <title>Create Account</title>
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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
            border: 5px solid #e1e1e1e1;
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

        @media screen and (max-width:720) {
            .wrapper1 {
                width: 100%;
                height: 100%;
            }
        }
    </style>
</head>

<body style="overflow-x:hidden ; ">

    <section>
        <div class="page-content-wrapper1">
            <div class="page-content4">
                <div class="row">
                    <div class="col-md-6  p-5 text-white bg-orange wrapper1  scrollBar">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-6 text-center" id="logo">
                                <img src="<?= base_url() ?>/assets/images/wma1.png" alt="wma logo">
                            </div>
                        </div>
                        <h3 class="text-center m-0">WEIGHT AND MEASURE AGENCY</h3>
                        <h4 class="text-center m-0 mb-2">ONLINE SERVICE APPLICATION SYSTEM</h4>
                        <p class="mb-2">
                            To apply for wma-online services application (wma-osa) at WMA you have to be a registered user. If you do not have a user name and password, please register as user first and activate your account, click „Create WMA-OSA account“. If you have a user name and password, click „Login for registered users “and login.
                        </p>
                        <h3>Guidelines for Registrations and Login</h3>
                        <p class="mb-2">
                            <b>For new members/practitioner:</b> To apply for wma-online services application (wma-osa) at WMA you have to be a registered user. If you do not have a user name and password, please register as user first and activate your account through your email, click „Create WMA-OSA account“.
                        </p>
                        <p>
                            <b>For Registered members/practitioners:</b> You should login by providing your account credential as indicated.
                        </p>




                    </div>
                    <div class="col-md-6  p-5 wrapper1 scrollBar">
                        <!-- 199404082311300001225 -->
                        <div class="accountCreated"></div>
                        <div class="registrationForm">
                            <form id="signupForm">
                                <!-- <div class="form-group">
                                    <label for="">Nationality</label>
                                    <select class="form-control" name="nationality" id="nationality" >
                                        <option value="Tanzanian">Tanzanian</option>
                                        <option value="Foreigner">Foreigner</option>

                                    </select>
                                </div> -->
                                <span id="foreign" style="display:none;">
                                    <?= view('ServiceApplication/Components/Countries') ?>
                                    <div class="form-group">
                                        <label for="">Passport Number</label>
                                        <input type="text" name="passportNumber" id="passportNumber" class="form-control">
                                    </div>


                                </span>
                                <span id="local">
                                    <?= view('ServiceApplication/Components/Regions') ?>
                                    <!-- <div class="form-group" id="tanzanian">
                                        <label for="simpleFormEmail">National Id Number (NIDA) <div class="spinner-border spinner-border-md text-orange" id="loader" role="status" style="width:1.4rem;height:1.4rem;display: none;">
                                            </div></label>
                                        <input type="text" maxlength="20" name="nationalId" class="form-control" id="nationalId" placeholder="Enter NIDA Number" oninput="verifyNida(this)">
                                        <small class="nationalId text-danger"></small>
                                    </div> -->
                                </span>

                                <span id="names">
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <input type="text" name="firstName" id="firstName" placeholder="Enter First Name" class="form-control nameInput" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Middle Name</label>
                                        <input type="text" name="middleName" id="middleName" placeholder="Enter Middle Name" class="form-control nameInput" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Last Name</label>
                                        <input type="text" name="lastName" id="lastName" placeholder="Enter Last Name" class="form-control nameInput" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Gender</label>
                                        <div class="form-group">

                                            <select class="form-control Name" name="gender" id="gender" required readoly>
                                                <option value="xx">--Select Gender--</option>
                                                <option value="MALE">MALE</option>
                                                <option value="FEMALE">FEMALE</option>

                                            </select>
                                        </div>
                                    </div>
                                </span>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email Address">
                                    <small class="text-danger email"></small>
                                </div>
                                <div class="form-group">
                                    <label for="">Phone Number</label>
                                    <input type="text" name="phoneNumber" id="phoneNumber" class="form-control phone" placeholder="Enter Phone Number">
                                    <small class="text-danger email"></small>
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Eenter Password">
                                    <small class="text-danger password"></small>
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="password" name="password2" id="password2" class="form-control" placeholder="Confirm Password">
                                    <small class="text-danger password2"></small>
                                </div>

                                <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                                <button class="btn btn-primary" type="submit" id="submit">
                                    <span id="spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none"></span>
                                    <span class="visually-hidden">Sign Up</span>
                                </button>

                            </form>
                            Already A member?
                            <a href="<?= base_url('service-request/login') ?>">Login</a>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </section>



    <script>
        $('.select2').select2();



        function requestOnProgress(element) {
            document.querySelector('#' + element).style.display = 'inline-block'
            document.querySelector('#submit').setAttribute('disabled', 'disabled')

        }

        function requestDone(element) {
            document.querySelector('#' + element).style.display = 'none'
            document.querySelector('#submit').removeAttribute('disabled', 'disabled')

        }



        function showError(field, errors) {
            const element = document.querySelector('.' + field)
            errors[field] ? element.textContent = errors[field] : element.textContent = ''

        }



        const signupForm = document.querySelector('#signupForm')
        signupForm.addEventListener('submit', (e) => {
            e.preventDefault()
            const formData = new FormData(signupForm)
            // signupForm.append('token',document.querySelector('.token'))
            requestOnProgress('spinner')
            fetch('<?= base_url() ?>/service-request/signup', {
                method: 'POST',
                // headers: {
                //     'Content-Type': 'application/json',
                // },
                body: formData,
            }).then((response) => response.json()).then((data) => {
                console.log(data)
                const {
                    status,
                    token,
                    errors,
                    activation
                } = data

                if (status == 1) {
                    // requestDone('spinner')
                    window.location = activation
                } else {
                    requestDone('spinner')

                }


                showError('email', errors)
                showError('password', errors)
                showError('password2', errors)



            })
        })
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