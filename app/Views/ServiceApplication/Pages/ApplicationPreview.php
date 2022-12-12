<?= $this->extend('ServiceApplication/Layout/ServiceLayout'); ?>
<?= $this->section('content'); ?>

<!-- Button trigger modal -->
<?= csrf_field() ?>

<!-- Modal -->
<div class="col-md-12 col-sm-12">
    <div class="card  card-box">
        <div class="card-head">
            <header>Application Details</header>
            <!-- <div class="tools">
                <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
            </div> -->
        </div>
        <div class="card-body ">
            <div class="table-wrap">
                <div class="table-responsive">
                    <!-- <pre>
                        <?php var_dump($applications) ?>
                    </pre> -->
                    <table class="table display product-overview mb-30" id="support_table5">
                        <thead>
                            <tr>
                                <th>Application</th>
                                <th>Date</th>
                                <th>Action</th>



                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $application) : ?>
                            <tr>
                                    <td><?= $application->type ?></td>
                                    <td><?= dateFormatter($application->created_at) ?></td>
                                    <td>
                                        <a href="<?= 'application-details/'.$application->application_id ?>" class="btn btn-tbl-edit btn-primary">
                                            <i class="fas fa-eye    "></i>
                                        </a>
                                        
                                    </td>
                                </tr>
                                <?php endforeach; ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>