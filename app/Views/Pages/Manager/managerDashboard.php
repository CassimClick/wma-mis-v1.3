<?= $this->extend('layouts/coreLayout'); ?>
<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark"><?= $page['heading'] ?></h4>
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

<!-- Main content -->
<section class="content body">
    <div class="container-fluid">
        <!-- Scales -->
        <div class="row">
            <!-- <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-purple elevation-2 p-10"><i class="fal fa-balance-scale"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">Scales</span>
                        <span class="">Paid: Tsh<?= '0'; ?></span><br>
                        <span class="">Pending: Tsh<?= '0'; ?></span>
                        <span class="info-box-number">Total: Tsh <?= '0'; ?></span>
                    </div>

                </div>

            </div> -->
            <!-- <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-2 p-10"><i class="fal fa-gas-pump"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">Fuel Pumps</span>
                        <span class="">Paid: Tsh<?= '0'; ?></span><br>
                        <span class="">Pending: Tsh<?= '0'; ?></span>
                        <span class="info-box-number">Total: Tsh <?= '0'; ?></span>
                    </div>

                </div>

            </div> -->
            <!-- <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-2 p-10"><i class="fal fa-box-full"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">Pre Packages</span>
                        <span class="">Paid: Tsh <?= '0'; ?></span><br>
                        <span class="">Pending: Tsh <?= '0'; ?></span>
                        <span class="info-box-number">Total: Tsh <?= '0'; ?></span>
                    </div>

                </div>

            </div> -->
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-2 p-10"><i class="fal fa-truck-container"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">VTC</span>
                        <span class="">Paid: Tsh<?= paidAmount($vtcDetails); ?></span><br>
                        <span class="">Pending: Tsh<?= pendingAmount($vtcDetails); ?></span>
                        <span class="info-box-number">Total: Tsh <?= totalAmount($vtcDetails); ?></span>
                    </div>

                </div>

            </div>
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-2 p-10"><i class="fal fa-truck"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">SBL</span>
                        <span class="">Paid: Tsh <?= paidAmount($sblDetails); ?></span><br>
                        <span class="">Pending: Tsh <?= pendingAmount($sblDetails); ?></span>
                        <span class="info-box-number">Total: Tsh <?= totalAmount($sblDetails); ?></span>
                    </div>

                </div>

            </div>




            <!-- <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-indigo elevation-2 p-10"><i class="fal fa-database"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">BST</span>
                        <span class="">Paid: Tsh <?= '0' ?></span><br>
                        <span class="">Pending: Tsh <?= '0' ?></span>
                        <span class="info-box-number">Total: Tsh <?= '0' ?></span>
                    </div>

                </div>

            </div> -->
            <!-- <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-teal elevation-2 p-10"><i class="fal fa-container-storage"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">FST</span>
                        <span class="">Paid: Tsh <?= '0' ?></span><br>
                        <span class="">Pending: Tsh <?= '0' ?></span>
                        <span class="info-box-number">Total: Tsh <?= '0' ?></span>
                    </div>

                </div>

            </div> -->
            <!-- <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-navy elevation-2 p-10"><i class="fal fa-bullseye"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">Flow Meter</span>
                        <span class="">Paid: Tsh <?= '0' ?></span><br>
                        <span class="">Pending: Tsh <?= '0' ?></span>
                        <span class="info-box-number">Total: Tsh <?= '0' ?></span>
                    </div>

                </div>

            </div> -->
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-2 p-10"><i class="fal fa-ring"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">Water Meter</span>
                        <span class="">Paid: Tsh <?= paidAmount($waterMeterDetails); ?></span><br>
                        <span class="">Pending: Tsh <?= pendingAmount($waterMeterDetails); ?></span>
                        <span class="info-box-number">Total: Tsh <?= totalAmount($waterMeterDetails); ?></span>
                    </div>

                </div>

            </div>
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-2 p-10"><i class="fal fa-ship"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">Metrological Supervision</span>
                        <span class="">Paid: Tsh <?= '0'; ?></span><br>
                        <span class="">Pending: Tsh <?= '0'; ?></span>
                        <span class="info-box-number">Total: Tsh <?= '0'; ?></span>
                    </div>

                </div>

            </div>
        </div>


        <div class="card">
            <!-- <div class="card-header">
                Collection Summary
            </div> -->
            <div class="card-body">
                <div id="chart" class="mt-5"></div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-4 col-6">
                        <div class="description-block border-right">
                            <!-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span> -->
                            <h5 id="paid" class="description-header"></h5>
                            <span class="description-text">PAID AMOUNT</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 col-6">
                        <div class="description-block border-right">
                            <!-- <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i>
                                0%</span> -->
                            <h5 id="pending" class="description-header"></h5>
                            <span class="description-text">PENDING AMOUNT</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 col-6">
                        <div class="description-block border-right">
                            <!-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span> -->
                            <h5 id="total" class="description-header"></h5>
                            <span class="description-text">TOTAL AMOUNT</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->


        <!-- ======================================= -->

    </div>

</section>

<?= $this->endSection(); ?>