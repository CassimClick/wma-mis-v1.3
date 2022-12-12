<?= $this->extend('layouts/coreLayout'); ?>
<?= $this->section('profileDetails'); ?>
<li class="nav-item dropdown d-sm-inline-block mr-4">
    <a href="#" data-toggle="dropdown">
        <?php if ($profile->avatar != '') : ?>
        <img class="avatar img-circle elevation-3" src="<?= $profile->avatar ?>" alt="User profile picture">
        <?php else : ?>
        <img class="avatar img-circle elevation-3" src="<?= base_url() ?>/assets/images/avatar.png"
            alt="User profile picture">
        <?php endif; ?>
    </a>
    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right mt-2">
        <a href="#" class="dropdown-item">
            <span> <?= ucfirst($profile->first_name) . ' ' . ucfirst($profile->last_name) ?></span>

        </a>
        <div class="dropdown-divider"></div>
        <a href="<?= base_url() ?>/profile" class="dropdown-item">
            <i class="far fa-user mr-2 mb-1 "></i>My Profile
        </a>
        <div class="dropdown-divider"></div>
        <a href="<?= base_url() ?>/logout" class="dropdown-item">
            <i class="far fa-power-off mr-2 mb-1 "></i>Log Out

        </a>

    </div>
</li>
<?= $this->endSection(); ?>



<?= $this->extend('layouts/coreLayout'); ?>
<?= $this->section('content'); ?>
<!-- ==================== -->


<?php
$pageSession = \CodeIgniter\Config\Services::session();
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= $page['heading'] ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active"><?= $page['heading'] ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<?php

//print_r($profile);
?>
<!-- Main content -->
<section class="content body">
    <div class="container-fluid">
        <?php if ($pageSession->getFlashdata('Success')) : ?>
        <div id="message" class="alert alert-success text-center" role="alert">
            <?= $pageSession->getFlashdata('Success'); ?>
        </div>
        <?php endif; ?>
        <?php if ($pageSession->getFlashdata('error')) : ?>
        <div id="message" class="alert alert-success text-center" role="alert">
            <?= $pageSession->getFlashdata('error'); ?>
        </div>

        <?php endif; ?>

        <?php if (isset($validation)) : ?>
        <div id="message" class="alert alert-danger" role="alert">
            <?= $validation->listErrors(); ?>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-4">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">

                        <div class="text-center">
                            <?php if ($profile->avatar != '') : ?>
                            <img class="profile-user-img img-fluid img-circle" src="<?= $profile->avatar ?>"
                                alt="User profile picture">
                            <?php else : ?>
                            <img class="profile-user-img img-fluid img-circle"
                                src="<?= base_url() ?>/assets/images/avatar.png" alt="User profile picture">
                            <?php endif; ?>
                        </div>

                        <h3 class="profile-username text-center">
                            <?= ucfirst($profile->first_name) . ' ' . ucfirst($profile->last_name) ?>
                        </h3>

                        <p class="text-muted text-center">Software Engineer</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <?= $profile->email ?>
                            </li>
                            <li class="list-group-item">
                                0744 236 287
                            </li>
                            <li class="list-group-item">
                                P.O Box 256 Moshi
                            </li>
                            <li class="list-group-item">
                                PF Number
                            </li>
                        </ul>


                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">


                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                        <p class="text-muted">Malibu, California</p>

                        <hr>

                        <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                        <p class="text-muted">
                            <span class="tag tag-danger">UI Design</span>
                            <span class="tag tag-success">Coding</span>
                            <span class="tag tag-info">Javascript</span>
                            <span class="tag tag-warning">PHP</span>
                            <span class="tag tag-primary">Node.js</span>
                        </p>

                        <hr>


                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-8">

                <?php
                print_r($tasks);
                ?>
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <!-- <li class="nav-item"><a class="nav-link active" href="#activity"
                                    data-toggle="tab">Activity</a></li> -->
                            <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">
                                    Activities</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Edit Profile</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Change
                                    Password</a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- <div class="active tab-pane" id="activity">
                               
                            </div> -->
                            <!-- /.tab-pane -->
                            <div class="active tab-pane" id="timeline">
                                <!-- The timeline -->
                                <?php foreach ($tasks as $task) : ?>
                                <div class="timeline timeline-inverse">
                                    <!-- timeline time label -->

                                    <div class="time-label">
                                        <span class="bg-success">
                                            <?= $task['created_at'] ?>

                                        </span>
                                    </div>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <div>
                                        <i class="far fa-check-circle bg-primary"></i>

                                        <div class="timeline-item">
                                            <!-- <span class="time"><i class="far fa-clock"></i> 12:05</span> -->

                                            <h3 class="timeline-header"> <b> <?= $task['activity'] ?></b>
                                            </h3>

                                            <div class="timeline-body">
                                                <p><?= $task['description'] ?></p>
                                                <ul class="list-group">
                                                    <li class="list-group-item ">Region:<?= $task['region'] ?></li>
                                                    <li class="list-group-item ">District:<?= $task['district'] ?></li>
                                                    <li class="list-group-item ">Ward:<?= $task['ward'] ?></li>

                                                </ul>

                                            </div>
                                            <div class="timeline-footer">
                                                <!-- <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                <a href="#" class="btn btn-danger btn-sm">Delete</a> -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END timeline item -->



                                    <!-- END timeline item -->

                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="settings">

                            <?= form_open_multipart() ?>
                            <div class="form-group">
                                <!-- <label for="my-input">Upload Profile Picture</label> -->
                                <input class="" type="file" name="avatar">
                            </div>
                            <div class="form-group row">
                                <div class=" ">
                                    <button type="submit" class="btn btn-success">Upload</button>
                                </div>
                            </div>

                            <?= form_close() ?>
                            <form class="">
                                <div class="form-group">
                                    <label for="inputName" class=" col-form-label">First Name</label>
                                    <div class="">
                                        <input type="email" class="form-control" id="inputName"
                                            placeholder="first Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class=" col-form-label">Last Name</label>
                                    <div class="">
                                        <input type="email" class="form-control" id="inputName" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class=" col-form-label">Email</label>
                                    <div class="">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName2" class=" col-form-label">Postal Address</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="inputName2"
                                            placeholder="Postal Address">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="inputExperience" class=" col-form-label">Location</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="inputName2" placeholder="Location">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputSkills" class=" col-form-label">Skills</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="">
                                        <input type="submit" value="Update Profile" class=" btn btn-primary">
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
    </div>
    </div>
</section>

<?= $this->endSection(); ?>