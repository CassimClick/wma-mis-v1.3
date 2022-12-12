<!DOCTYPE html>
<html>
<?php $pageSession = \CodeIgniter\Config\Services::session(); ?>

<head>
    <title>Codeigniter 4 jQuery Form Validation Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        .error {
            width: 100%;
            margin-top: .25rem;
            font-size: .875em;
            color: #dc3545;
        }

        #message {
            position: absolute;
            right: 1rem;
            top: 1rem;
            background-color: #20963DF6;
            color: #fff;
        }
        #message2 {
            position: absolute;
            right: 1rem;
            top: 1rem;
            background-color: #D3471CF6;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php if ($pageSession->getFlashdata('Success')) : ?>
        <div id="message" class="alert alert-success text-center" role="alert" aria-disabled="true">
            <?= $pageSession->getFlashdata('Success'); ?>
        </div>
    <?php endif; ?>
    <?php if ($pageSession->getFlashdata('error')) : ?>
        <div id="message2" class="alert alert-danger text-center" role="alert" aria-disabled="true">
            <?= $pageSession->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>
    <div class="container">
        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">

                            <?php $attributes = ['id' => 'contact_form', 'name' => 'contact_form']; ?>
                            <?= form_open('addForm', $attributes) ?>
                            <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                            <div class="form-group mb-3">
                                <label class="fw-bold mb-2">Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-2">Email</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-2">Mobile</label>
                                <input type="text" name="mobile" class="form-control">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- ############################################################# -->
        <!-- ############################################################# -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">



                            <form id="contact_form_update">

                                <input type="text" name="id" id="id" class="form-control">
                                <div class="form-group mb-3">
                                    <label class="fw-bold mb-2">Name</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="fw-bold mb-2">Email</label>
                                    <input type="text" name="email" id="email" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="fw-bold mb-2">Mobile</label>
                                    <input type="text" name="mobile" id="mobile" class="form-control">
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
                </div>
            </div>
        </div>


        <div class="tb mt-5">
            <br>
            <br>

            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add
            </button>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>

                        <tr>
                            <td><?= $user->id ?></td>
                            <td><?= $user->name ?></td>
                            <td><?= $user->email ?></td>
                            <td><?= $user->mobile ?></td>
                            <td>
                                <button onclick="editRecord('<?= $user->id ?>')" class="btn btn-success btn-sm">
                                    edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        function getCsrfHash() {

            const csrfHash = document.querySelector('.txt_csrfname').value; // CSRF hash
            return csrfHash
        }
        setInterval(function() {
            $('#message').fadeOut(7000)
        });

        function updateToken(token) {

            document.querySelector('.txt_csrfname').value = token
        }


        $("#contact_form").validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 60
                },
                mobile: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Name is required",
                },
                email: {
                    email: "It doe not seem valid email",
                    required: "Email is required",
                    maxlength: "Upto 50 characters are allowed",
                },
                mobile: {
                    required: "Please, enter mobile",
                },
            },
        })

        function editRecord(id) {

            let data = {
                id: id,
                // csrf_hash: getCsrfHash(),
                csrf_hash: document.querySelector('.txt_csrfname').value,

            }
            // console.table(data);
            $.ajax({
                type: "post",
                url: "editRecord",
                data: data,
                dataType: "json",
                success: function(response) {

                    updateToken(response.token)
                    $('#editModal').modal('show');
                    document.querySelector('#id').value = response.data.hash
                    document.querySelector('#name').value = response.data.name
                    document.querySelector('#email').value = response.data.email
                    document.querySelector('#mobile').value = response.data.mobile
                }
            });
        }


        function updateRecord() {
            $('#contact_form_update').on('submit', function(e) {
                e.preventDefault()
                let formData = new FormData(this);
                formData.append("csrf_hash", document.querySelector('.txt_csrfname').value);

                $.ajax({
                    type: "POST",
                    url: "updateRecord",
                    cache: false,
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        updateToken(response.token)
                        $('#editModal').modal('hide');
                        swal({
                            title: response.msg,
                            // text: "You clicked 217 the button!",
                            icon: "success",
                        });
                        setTimeout(function() {

                            location.reload();
                        }, 3000);
                    }
                });


            })
        }
        updateRecord()
    </script>
</body>

</html>