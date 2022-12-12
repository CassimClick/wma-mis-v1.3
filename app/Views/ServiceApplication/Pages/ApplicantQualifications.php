<?= $this->extend('ServiceApplication/Layout/ServiceLayout'); ?>
<?= $this->section('content'); ?>


<?php $link = base_url('service-request'); ?>
<?= Success() ?>
<?= Error() ?>


<!-- Modal -->

<div class="modal fade" id="qualificationModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <?= csrf_field() ?>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Qualification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="qualificationForm">
                    <input type="text" name="userId" id="" class="form-control" value="<?= $userId ?>" hidden>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Qualification Name</label>
                                <input type="text" name="qualification" id="" class="form-control" placeholder="Qualification Name">
                                <small id="qualification" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Qualification Duration</label>
                                <input type="number" name="duration" max="20" id="" class="form-control" placeholder="Duration">
                                <small id="duration" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>



<div class="card card-box">
    <div class="card-header">


        <button id="sample_editable_1_new" class="btn btn-primary btn-sm pull-left" data-toggle="modal" data-target="#qualificationModel"> Add Qualification
            <i class="fa fa-plus"></i>
        </button>
        <div class="btn-group pull-right btn-prev-next">

            <a href="<?= $link . '/add-applicant-particulars' ?>" class="btn btn-sm btn-primary" type="button">
                <i class="fa fa-chevron-left"></i>back: Applicant Particulars
            </a>
            <a href="<?= $link . '/license-type' ?>" class="btn btn-sm btn-primary <?= empty($qualifications) ? 'disabled' : '' ?>" type="button" id="nextBtn">
              next:  Type Of License<i class="fa fa-chevron-right"></i>
            </a>

        </div>
    </div>
    <div class="card-body">
        <div>
            <table class="table table-sm" style="width:100% ;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Duration</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="qualifications">
                    <?php foreach ($qualifications as $qualification) : ?>
                        <tr>
                            <td><?= $qualification->qualification ?></td>
                            <td><?= $qualification->duration ?> Years</td>
                            <td><a href="<?= base_url('service-request/deleteQualification/' . $qualification->id) ?>" class="btn btn-tbl-edit btn-danger btn-xs"><i class="fas fa-trash    "></i></a></td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>





    </div>
</div>
</div>

<script>
    function validationError(field, errors) {
        const element = document.querySelector('#' + field)
        errors[field] ? element.textContent = errors[field] : element.textContent = ''

    }
    const qualificationForm = document.querySelector('#qualificationForm')

    qualificationForm.addEventListener('submit', (e) => {
        e.preventDefault()
        const formData = new FormData(qualificationForm)
        formData.append('csrf_hash', document.querySelector('.token').value)
        fetch('addQualification', {
                method: 'POST',
                headers: {
                    // 'Content-Type': 'application/json;charset=utf-8',
                    "X-Requested-With": "XMLHttpRequest"
                },

                body: formData,

            }).then(response => response.json())
            .then(data => {
                const {
                    status,
                    token,
                    errors,
                    qualifications,
                    msg
                } = data
                document.querySelector('.token').value = token
                validationError('qualification', errors)
                validationError('duration', errors)
                if (status == 1) {
                    document.querySelector('#nextBtn').classList.remove('disabled')
                 
                    document.querySelector('#qualifications').innerHTML = qualifications
                    qualificationForm.reset()
                    $('#qualificationModel').modal('hide')
                    swal({
                        title: msg,
                        icon: "success",
                    });
                }

                //console.log(data)
            })
    })
</script>





<?= $this->endSection(); ?>