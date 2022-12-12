<?= $this->extend('ServiceApplication/Layout/ServiceLayout'); ?>
<?= $this->section('content'); ?>


<?php $link = base_url('service-request'); ?>
<p><b> <i class="fas fa-info-circle"></i> NOTE:</b> Applications Should be filled in Chronological Order</p>
<div class="progress mb-2 mt-2" style="background:#fff ; border-radius:6px;">
    <div class="progress-bar " role="progressbar" style="background:#DB611E;width: <?= $progress . '%' ?>;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $progress . '%' ?></div>

</div>
<div class="row clearfix">
    <div class="col-md-4 col-sm-12">
        <a href="<?= ($application->particulars == 1) ? $link . '/applicant-particulars' : $link . '/add-applicant-particulars' ?>">
            <div class="card">
                <div class="panel-body">
                    <h3 class="text-dark">1: Applicant's Particulars</h3>

                    <?php if ($application->particulars == 1) : ?>
                        <span class="feedLblStyle lblCommentStyle text-center">Filled</span>
                    <?php else : ?>
                        <span class="feedLblStyle lblReplyStyle">Not Filled</span>
                    <?php endif; ?>


                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4 col-sm-12">
        <a href="<?= $link . '/applicant-qualifications'  ?>">
            <div class="card">
                <div class="panel-body">
                    <h3 class="text-dark">2: Applicant's Qualification</h3>


                    <?php if ($application->qualifications == 1) : ?>
                        <span class="feedLblStyle lblCommentStyle text-center">Filled</span>
                    <?php else : ?>
                        <span class="feedLblStyle lblReplyStyle">Not Filled</span>
                    <?php endif; ?>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 col-sm-12">
        <a href="<?= ($application->qualifications == 1) ? $link . '/license-type' : '#' ?>">
            <div class="card">
                <div class="panel-body">
                    <h3 class="text-dark">3: Type Of License</h3>
                    <?php if ($application->licenseType == 1) : ?>
                        <span class="feedLblStyle lblCommentStyle text-center">Filled</span>
                    <?php else : ?>
                        <span class="feedLblStyle lblReplyStyle">Not Filled</span>
                    <?php endif; ?>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 col-sm-12">
        <a href="<?= ($application->licenseType == 1) ? $link . '/tools' : '#' ?>">
            <div class="card">
                <div class="panel-body">
                    <h3 class="text-dark">5: Equipment/Tools/Facility</h3>
                    <?php if ($application->tools == 1) : ?>
                        <span class="feedLblStyle lblCommentStyle text-center">Filled</span>
                    <?php else : ?>
                        <span class="feedLblStyle lblReplyStyle">Not Filled</span>
                    <?php endif; ?>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4 col-sm-12">
        <a href="<?= base_url('service-request/attachments') ?>">
            <div class="card">
                <div class="panel-body">
                    <h3 class="text-dark">6: Attachments</h3>

                    <?php if ($application->attachments == 1) : ?>
                        <span class="feedLblStyle lblCommentStyle text-center">Filled</span>
                    <?php else : ?>
                        <span class="feedLblStyle lblReplyStyle">Not Filled</span>
                    <?php endif; ?>
                </div>
            </div>
        </a>
    </div>
</div>



</div>

<?= $this->endSection(); ?>