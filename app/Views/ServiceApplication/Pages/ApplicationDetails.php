<?= $this->extend('ServiceApplication/Layout/ServiceLayout'); ?>
<?= $this->section('content'); ?>

<!-- Button trigger modal -->
<?= csrf_field() ?>

<!-- Modal -->
<div class="col-md-12 col-sm-12">
    <div class="card  card-box">
        <div class="card-head">
            <header>Application Preview</header>
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
                        <!-- <thead>
                            <tr>
                                <th>Name</th>
                                <th>Details</th>

                            </tr>
                        </thead> -->
                        <tbody>
                            <tr class="shade">

                                <td colspan="2">APPLICANT QUALIFICATIONS</td>
                            </tr>
                            <?php foreach ($qualifications as $qualification) : ?>
                                <tr>
                                    <td><?= $qualification->qualification ?></td>
                                    <td><?= $qualification->duration ?> Years</td>

                                </tr>
                            <?php endforeach; ?>
                            <!-- *********************************************** -->
                            <tr class="shade">

                                <td colspan="2">LICENSE TYPE</td>
                            </tr>
                            <?php foreach ($licenseTypes as $license) : ?>
                                <tr>
                                    <td><?= $license->type ?></td>
                                    <td></td>

                                </tr>
                            <?php endforeach; ?>
                            <!-- *************************************************** -->
                            <tr class="shade">

                                <td colspan="2">TOOLS/EQUIPMENTS OR FACILITY</td>
                            </tr>
                            <?php foreach ($tools as $tool) : ?>
                                <tr>
                                    <td><?= $tool->tool ?></td>
                                    <td></td>

                                </tr>
                            <?php endforeach; ?>
                            <!-- *************************************************** -->
                            <tr class="shade">

                                <td colspan="2">ATTACHMENTS</td>
                            </tr>
                            <?php foreach ($attachments as $attachment) : ?>
                                <tr>
                                    <td><?= $attachment->document ?></td>
                                    <td>
                                        <i class="fas fa-check"></i>
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