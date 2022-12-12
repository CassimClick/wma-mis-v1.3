<?= $this->extend('layouts/coreLayout'); ?>
<?= $this->section('content'); ?>
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

<!-- Main content -->
<section class="content body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-12">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= count($totalScales) ?></h3>

                        <p>Scales</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-balance-scale"></i>
                    </div>
                    <a href="<?= base_url() ?>/listScales" class="small-box-footer">
                        More info <i class="far fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-12">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= count($totalPumps) ?></h3>

                        <p>Fuel Pumps</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-gas-pump"></i>
                    </div>
                    <a href="<?= base_url() ?>/listFuelPumps" class="small-box-footer">
                        More info <i class="far fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-12">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= count($totalIndustrialPackages) ?></h3>

                        <p>Industrial Packages</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-box-full"></i>
                    </div>
                    <a href="<?= base_url() ?>/listIndustrialPackages" class="small-box-footer">
                        More info <i class="far fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-12">
                <!-- small card -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= count($totalVehicleTanks) ?></h3>

                        <p>Vehicle Tanks</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-truck"></i>
                    </div>
                    <a href="<?= base_url() ?>/listVehicleTanks" class="small-box-footer">
                        More info <i class="far fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <!-- small card -->
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3><?= count($totalLorries) ?></h3>

                        <p>Lorries</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-rv"></i>
                    </div>
                    <a href="<?= base_url() ?>/listLorries" class="small-box-footer">
                        More info <i class="far fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-12">
                <!-- small card -->
                <div class="small-box bg-olive">
                    <div class="inner">
                        <h3><?= count($totalBst) ?></h3>

                        <p>BST</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-database"></i>
                    </div>
                    <a href="<?= base_url() ?>/listBulkStorageTanks" class="small-box-footer">
                        More info <i class="far fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <!-- small card -->
                <div class="small-box bg-maroon">
                    <div class="inner">
                        <h3><?= count($totalFst) ?></h3>

                        <p>FST</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-container-storage"></i>
                    </div>
                    <a href="<?= base_url() ?>/listFixedStorageTanks" class="small-box-footer">
                        More info <i class="far fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-12">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= count($totalFlowMeter) ?></h3>

                        <p>Flow Meter</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-bullseye"></i>
                    </div>
                    <a href="<?= base_url() ?>/FlowMeterList" class="small-box-footer">
                        More info <i class="far fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-12">
                <!-- small card -->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3><?= count($totalWaterMeter) ?></h3>

                        <p>Water Meter</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-ring"></i>
                    </div>
                    <a href="<?= base_url() ?>/WaterMeterList" class="small-box-footer">
                        More info <i class="far fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
        </div>

        <!-- ======================================= -->
        <!-- <div class="card ">
            <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                            class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="barChart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
            
    </div> -->
    </div>

</section>

<?= $this->endSection(); ?>