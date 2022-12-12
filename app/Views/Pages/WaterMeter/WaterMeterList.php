<?= $this->extend('layouts/coreLayout'); ?>
<?= $this->section('content'); ?>
<?php
$pageSession = \CodeIgniter\Config\Services::session();
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1 class="m-0 text-dark"></h1> -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <?php if ($role == 3) : ?>
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/fullReport">Full Report</a></li>
                    <?php else : ?>
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/dashboard">Dashboard</a></li>
                    <?php endif; ?>
                    <li class="breadcrumb-item active"><?= $page['heading'] ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content body">
    <div class="container-fluid">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <?php if ($pageSession->getFlashdata('Success')) : ?>
                        <div id="message" class="alert alert-success text-center" role="alert">
                            <?= $pageSession->getFlashdata('Success'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <!-- meterQuantityAll -->
                            <h5 class="card-title"><?= $page['heading'] ?><b>(<?= number_format(meterQuantityAll($WaterMeterResults)) ?>)</b> &nbsp; &nbsp; &nbsp; Total Amount: <b class="">Tsh <?= totalAmount($WaterMeterResults) ?></b></h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">


                            <?php if ($WaterMeterResults) : ?>
                                <table id="example1" class="table table-sm table-bordered ">
                                    <!-- <h4>Total Amount <span class="total"></span></h4> -->
                                    <thead>
                                        <tr>
                                            <th class="head">Full Name</th>
                                            <th class="head">City</th>
                                            <th class="head">Ward</th>
                                            <th class="head">Village</th>
                                            <th class="head">Postal Address</th>
                                            <th class="head">Phone Number</th>
                                            <th class="head">Date</th>
                                            <th class="head">Meter Size</th>
                                            <th class="head">brand</th>
                                            <th class="head">Quantity</th>
                                            <th class="head">Flow Rate</th>
                                            <th class="head">Class</th>
                                            <th class="head">Testing Laboratory</th>
                                            <th class="head">Testing Method</th>

                                           
                                            <th class="head">Control Number</th>
                                            <th class="head" id="amount">Amount</th>
                                            <th class="head">Payment</th>
                                            <th class="head">Report</th>
                                            <?php if ($role == 1 || $role == 2) : ?>


                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($WaterMeterResults as $waterMeter) : ?>
                                            <tr>
                                                <td><?= $waterMeter->name ?></td>
                                                <td><?= $waterMeter->region ?></td>
                                                <td><?= $waterMeter->ward ?></td>
                                                <td><?= $waterMeter->village ?></td>
                                                <td><?= $waterMeter->postal_address ?></td>
                                                <td><?= $waterMeter->phone_number ?></td>
                                                <td><?= dateFormatter($waterMeter->date) ?></td>
                                                <td><?= $waterMeter->meter_size ?> mm</td>
                                                <td><?= $waterMeter->brand ?></td>
                                                <td><?= $waterMeter->quantity ?> Meters</td>
                                                <td><?= $waterMeter->flow_rate ?> m<sup>3</sup>/h</td>
                                                <td><?= $waterMeter->class ?></td>
                                                <td><?= $waterMeter->lab ?></td>
                                                <td><?= $waterMeter->testing_method ?></td>



                                               
                                                <td>

                                                    <?= $waterMeter->control_number ?>
                                                </td>


                                                <td>
                                                    <?= number_format($waterMeter->amount) ?> Tsh
                                                </td>
                                                <td>
                                                    <?php if ($waterMeter->payment == 'Paid') : ?>
                                                        <span class="badge-pill badge-primary">Paid</span>
                                                    <?php else : ?>
                                                        <span class="badge-pill badge-danger">Pending</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?=base_url('downloadMeterChart/'. $waterMeter->batch_id)?>" target="_blank" class="btn btn-primary btn-xs"><i class="far fa-download"></i> Download Report</a>
                                                </td>




                                            </tr>
                                        <?php endforeach; ?>


                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>City</th>
                                            <th>Ward</th>
                                            <th>Village</th>
                                            <th>Postal Address</th>
                                            <th>Phone Number</th>
                                            <th>Date</th>
                                            <th>Meter Size</th>
                                            <th>brand</th>
                                            <th>Quantity</th>
                                            <th>Flow Rate</th>
                                            <th>Class</th>
                                            <th>Testing Laboratory</th>
                                            <th>Testing Method</th>

                                 
                                            <th>Control Number</th>
                                            <th id="amount">Amount</th>
                                            <th>Payment</th>
                                            <th>Report</th>

                                        </tr>


                                    </tfoot>
                                </table> <?php else : ?> <h2>There Are No Records Currently Available</h2>
                            <?php endif; ?>
                            <!-- <table id="example1" class="my-table " border="1"> -->

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>

    </div>
    <!-- /.card -->

    </div>
    </div>

</section>


<?= $this->endSection(); ?>