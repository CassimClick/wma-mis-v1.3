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
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?= $page['heading'] ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
 <!-- Main content -->
    <section class="content body">
        <di class="container-fluid">

            <?= view('Components/bill') ?>

            <?= $this->include('widgets/customerOptions.php') ?>
            <?= $this->include('components/Customers') ?>



            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="selectedCustomerDetails"></div>
                    </div>

                    <ul class="list-group" id="customerVehicles">


                    </ul>
                    <!-- /.card -->
                    <div id="vehicleWrapper">

                        <!-- <table class="table" id="vehicleTable"> -->
                        <ul class="list-group" id="vehicles">

                        </ul>
                        <!-- </table> -->
                        <button type="button" class="btn btn-primary mt-3 btn-sm" onclick="calcTotal()">Calculate</button>
                    </div>


                </div>




                <!-- Technical details -->
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="far fa-cogs icon"></i>VTV Technical Details</h3>
                            <div class="card-tools">
                                <!-- Buttons, labels, and many other things can be placed here! -->
                                <!-- Here is a label for example -->

                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- Technical details foe the scale -->
                            <?= $this->include('Components/vtc/vtcTechnicalDetails'); ?>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="form-group">

                                <!-- <button class="btn btn-primary"><i class="far fa-save"></i> Save</button> -->
                                <button type="button" onclick="publishVtcData()" class="btn btn-primary btn-sm">Save</button>
                            </div>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            </form>

            <!-- /.card -->


            </div>
            <!-- /.card -->

            </div>
            </div>

    </section>

    <?= $this->endSection(); ?>