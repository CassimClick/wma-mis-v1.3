<?= $this->extend('ServiceApplication/Layout/ServiceLayout'); ?>
<?= $this->section('content'); ?>

<!-- Button trigger modal -->
<?= csrf_field() ?>

<!-- Modal -->
<div class="col-md-12 col-sm-12">
    <div class="card  card-box">
        <div class="card-head">
            <header>Submitted Service Requests</header>
            <div class="tools">
                <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
            </div>
        </div>
        <div class="card-body ">
            <div class="table-wrap">
                <div class="table-responsive">
                    <table class="table display product-overview mb-30" id="support_table5">
                        <thead>
                            <tr>
                                <th>Services</th>
                                <th>Region</th>
                                <th>District</th>
                                <th>Date</th>
                                <th>Status</th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requests as $request) : ?>

                                <tr>
                                    <td><?=$request->services ?></td>
                                    <td><?=$request->region ?></td>
                                    <td><?=$request->district ?></td>
                                    <td><?= dateFormatter($request->created_at) ?></td>
                                   
                                    <?php if ($request->status == 1) : ?>
                                        <td><span class="label label-sm label-success">Seen</span></td>
                                    <?php else : ?>
                                        <td><span class="label label-sm label-danger">Not Seen</span></td>
                                    <?php endif; ?>
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