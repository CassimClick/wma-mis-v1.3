<?= $this->extend('ServiceApplication/Layout/ServiceLayout'); ?>
<?= $this->section('content'); ?>


<?php $link = base_url('service-request'); ?>
<?= Success() ?>
<?= Error() ?>


<!-- Modal -->





<div class="card card-box">

    <div class="card-body">
        <p>I declare that the information given above is correct to the best of my knowledge.</p>
        <div class="alert alert-warning" role="alert">
            <strong>NOTE : Once agreed and submit, your application will be sent for review. You will not be able to modify YOUR PERSONAL DETAILS on this application until the verification process is complete. If disagree, all particulars filled in will be rejected and deleted from the System </strong>
        </div>
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div>

                <div class="form-check form-check-inline">
                    <?php if ($isSubmitted == 1) : ?>
                        <label class="form-check-label">
                            <input class="form-check-input" style="transform: scale(1.5); cursor:pointer;accent-color: #B64B11;" type="checkbox" name="" id="" value="checkedValue" onchange="toggleButton(this)"> Agree Terms
                        </label>
                    <?php endif; ?>
                </div><br>
                <?php if ($isSubmitted == 0) : ?>
                    <a href="#" class="btn btn-success mt-2">Application Submitted</a>
                <?php else : ?>
                    <a href="<?= base_url('service-request/submitApplication') ?>" class="btn btn-primary mt-2 disabled">Submit Application</a>
                <?php endif; ?>
            </div>
        </div>


    </div>
</div>
</div>

<script>
    function toggleButton(checkbox) {
        const btn = document.querySelector('.btn')
        checkbox.checked ? btn.classList.remove('disabled') : btn.classList.add('disabled')

    }
</script>







<?= $this->endSection(); ?>