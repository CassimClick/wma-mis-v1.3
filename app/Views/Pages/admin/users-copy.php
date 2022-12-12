<?= $this->extend('layouts/coreLayout'); ?>
<?= $this->section('content'); ?>
<?php
$pageSession = \CodeIgniter\Config\Services::session();
?>
<div class="content-header">

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark"><?= $page['heading'] ?></h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/AdminDashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?= $page['heading'] ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<!-- Modal for editing user -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="userEditForm" name="userEditForm">


                    <input type="text" id="id" name="id" class="form-control" required hidden>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">First Name</label>
                            <input type="text" id="firstName" name="firstName" class="form-control" required placeholder="First Name" required>

                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Last Name</label>
                            <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last Name" required>

                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required>

                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Region</label>
                            <select id="region" class="form-control select2bs4" name="region" required>
                                <option disabled selected>Select Region</option>
                                <?php foreach (renderRegions() as $region) : ?>
                                    <option value="<?= $region['region'] ?>"><?= $region['region'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">User Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option selected disabled>Select Role</option>
                            <option value="7">Admin</option>
                            <option value="3">Head Of Section</option>
                            <option value="2">Manager</option>
                            <option value="1">Officer</option>
                        </select>
                    </div>

            </div>

            <!-- <div class="option">
                                    <div class="option__item">
                                        <button type="submit" class="button">Register</button>
                                    </div>
                                </div> -->

            <!-- </div> -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- ======================================================== -->


<section class="content body">
    <div class="container-fluid">
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">System Users</h3>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-sm" style="float: right;" data-toggle="modal" data-target="#addUserModal">
                    Add User
                </button>

                <!-- Modal -->
                <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Create New User</h5>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form id="userForm" name="userForm">
                                    <?= csrf_field() ?>
                                    <div class="sign">


                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="">First Name</label>
                                                <input type="text" name="firstName" class="form-control" required placeholder="First Name" required>

                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="">Last Name</label>
                                                <input type="text" name="lastName" class="form-control" placeholder="Last Name" required>

                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="">Email</label>
                                                <input type="email" name="email" class="form-control" placeholder="Email Address" required onkeyup="checkEmail(this.value)">

                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="">Region</label>
                                                <select class="form-control select2bs4" name="region" required>
                                                    <option disabled selected>Select Region</option>
                                                    <?php foreach (renderRegions() as $region) : ?>
                                                        <option value="<?= $region['region'] ?>"><?= $region['region'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="">User Role</label>
                                            <select class="form-control" name="role" required>
                                                <option selected disabled>Select Role</option>
                                                <option value="7">Admin</option>
                                                <option value="3">Head Of Section</option>
                                                <option value="2">Manager</option>
                                                <option value="1">Officer</option>
                                            </select>
                                        </div>

                                    </div>

                                    <!-- <div class="option">
                                    <div class="option__item">
                                        <button type="submit" class="button">Register</button>
                                    </div>
                                </div> -->

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                <!-- <button type="submit" class="btn btn-primary btn-sm">Register</button> -->

                                <button id="submit" class="btn btn-primary btn-sm" type="submit">
                                    <div class="spinner" style="display: none;">
                                        <span class="spinner-border spinner-border-sm" role="status"></span>
                                        <span>Registering...</span>
                                    </div>
                                    <div class="label">
                                        <span>Register</span>
                                    </div>

                                </button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal -->

            </div>
            <!-- /.card-header -->


            <style>
                .spin {
                    animation-name: spinner;
                    animation-duration: 1000ms;
                    animation-iteration-count: infinite;
                    animation-timing-function: linear;
                }

                .swal-button--danger {
                    background: #0075F2;
                    color: #fff;
                }

                .swal-button--danger:hover {
                    background: #2250CE !important;
                }

                @keyframes spinner {
                    from {
                        transform: rotate(0deg);
                    }

                    to {
                        transform: rotate(360deg);

                    }

                }
            </style>

            <div class="card-body">

                <table id="usersTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Region</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody >
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?= $user->first_name . ' ' . $user->last_name ?></td>
                                <td><?= $user->email ?></td>
                                <td><?= $user->city ?></td>
                                <td>
                                    <?php if ($user->role == 1) : ?>
                                        Officer
                                    <?php elseif ($user->role == 2) : ?>
                                        Manager
                                    <?php elseif ($user->role == 3) : ?>
                                        Head Of Section
                                    <?php elseif ($user->role == 7) : ?>
                                        Admin
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($user->status == 'active') : ?>
                                        <span class="badge badge-pill badge-success">Active</span>
                                    <?php else : ?>
                                        <span class="badge badge-pill badge-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($user->status == 'inactive') : ?>
                                        <a href="<?= base_url() ?>/admin/activateAccount/<?= $user->unique_id ?>" class="btn btn-danger btn-xs"><i class="fas fa-lock-alt"></i></a>
                                    <?php elseif ($user->status == 'active') : ?>
                                        <a href="<?= base_url() ?>/admin/deactivateAccount/<?= $user->unique_id ?>" class="btn btn-success btn-xs"><i class="fas fa-lock-open"></i></a>
                                    <?php endif; ?>

                                    <!-- <a href="<?= base_url() ?>/admin/editUser/<?= $user->unique_id ?>" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a> -->

                                    <button type="button" onclick="editUser('<?= $user->unique_id ?>')" class="btn btn-primary btn-xs">
                                        <div class="">
                                            <i class="fas fa-pen"></i>

                                        </div>

                                    </button>

                                    <button type="button" onclick="resetPassword('<?= $user->unique_id ?>',this)" class="btn bg-navy btn-xs"><i class="fas fa-sync-alt"></i></button>

                                </td>

                            </tr>

                        <?php endforeach; ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Region</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>


    </div>
    <!-- /.card -->

    <script>
        function testing(id, el) {

            console.log(id);
            el.childNodes[0].classList.add('spin')

        }

        function checkEmail(email) {

            $.ajax({
                type: "POST",
                url: "checkEmail",
                data: {
                    csrf_hash: document.querySelector('.token').value,
                    email: email
                },
                dataType: "json",
                success: function(response) {
                    updateToken(response.token)
                    console.log(response);

                    if (response.status == 1) {
                        document.querySelector('#submit').setAttribute('disabled', 'disabled')
                        swal({
                            title: response.msg,
                            icon: "warning",
                            // timer: 2500
                        });

                    } else if (response.status == 0) {
                        console.log('okay');
                        document.querySelector('#submit').removeAttribute('disabled', 'disabled')
                    }


                }
            });


        }

        function updateToken(token) {

            document.querySelector('.token').value = token
        }
        $(document).ready(function() {
            $('#usersTable').DataTable();
        });

        $("#userForm").validate({
            rules: {
                firstName: {
                    required: true
                },
                lastName: {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                    // remote: {
                    //     url: "<?= base_url() ?>/checkEmail",
                    //     type: 'post',
                    //     cache: false,
                    //     data: {
                    //         email: function() {
                    //             return $("#email").val();
                    //         },
                    //         csrf_hash: document.querySelector('.token').value
                    //     }
                    // }
                },
                region: {
                    required: true,

                },
                role: {
                    required: true,


                },

            },
            messages: {
                email: {
                    required: "Email is required",
                    remote: 'Email Already Taken'
                },



            },
        })


        $('#userForm').on('submit', function(e) {
            e.preventDefault()

            if ($('#userForm').valid()) {

                let formData = new FormData(this);
                formData.append("csrf_hash", document.querySelector('.token').value);
                $.ajax({
                    type: "POST",
                    url: "createUserAccount",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.spinner').show();
                        $('.spinner').attr('disabled', 'disabled');
                        $('.label').hide();
                    },
                    success: function(response) {
                        $('.spinner').hide();
                        $('.spinner').attr('disabled', '');
                        $('.label').show();
                        console.log(response);
                        updateToken(response.token)
                        $('#userForm')[0].reset()
                        $('#addUserModal').modal('hide');
                        swal({
                            title: response.msg,
                            // text: "You clicked 217 the button!",
                            icon: "success",
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 3000)

                    },
                    error: function(err) {
                        console.log(err);
                    }

                });
            } else {
                return false
                // console.log('invalid');
            }

        })

        function editUser(id) {
            // $('#editUserModal').modal('show')    

            $.ajax({
                type: "post",
                url: "editUser",
                data: {
                    csrf_hash: document.querySelector('.token').value,
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    updateToken(response.token)
                    $('#id').val(response.data.x_id)
                    $('#firstName').val(response.data.first_name)
                    $('#lastName').val(response.data.last_name)
                    $('#email').val(response.data.email)
                    $('#role').val(response.data.role).change()
                    $('#region').val(response.data.city).change()
                    $('#editUserModal').modal('show')
                    console.log(response);
                }
            });

        }

        //=================submit data for update====================
        $("#userEditForm").validate()
        $('#userEditForm').on('submit', function(e) {
            e.preventDefault()

            if ($('#userEditForm').valid()) {

                let formData = new FormData(this);
                formData.append("csrf_hash", document.querySelector('.token').value);
                $.ajax({
                    type: "POST",
                    url: "updateUser",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    beforeSend: function() {
                        // $('#preloader').show();
                    },
                    success: function(response) {

                        console.log(response);
                        updateToken(response.token)
                        // $('#userForm')[0].reset()
                        $('#editUserModal').modal('hide');
                        swal({
                            title: response.msg,
                            icon: "success",
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 3000)

                    },
                    error: function(err) {
                        console.log(err);
                    }

                });
            } else {
                return false
                // console.log('invalid');
            }

        })


        function deleteUser(id) {
            console.log(id);
        }



        function resetPassword(id, targetElement) {

            let icon = targetElement.childNodes[0]


            swal({
                    title: "Are You Sure You Want To Reset Password?",
                    // text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    buttons: ["No!", "Yes I am"],
                    dangerMode: true,
                })
                .then((willRun) => {

                    if (willRun) {
                        $.ajax({
                            type: "post",
                            url: "resetPassword",
                            data: {
                                csrf_hash: document.querySelector('.token').value,
                                id: id
                            },
                            dataType: "json",
                            beforeSend: function() {
                                icon.classList.add('spin')
                            },
                            success: function(response) {
                                document.querySelector('.token').value = response.token
                                console.log(response);

                                if(response.status == 1){
                                icon.classList.remove('spin')
                                swal({
                                title: response.msg,
                                icon: "success",
                               
                                });
                                    
                                }
                            }
                        });


                    } else {
                        swal("Password Is Not Reset ");
                    }
                });



            // $.ajax({
            //     type: "post",
            //     url: "resetPassword",
            //     data: {
            //         csrf_hash: document.querySelector('.token').value,
            //         id: id
            //     },
            //     dataType: "json",
            //     success: function(response) {
            //         updateToken(response.token)
            //         console.log(response);
            //     }
            // });
        }
    </script>


</section>

<?= $this->endSection(); ?>