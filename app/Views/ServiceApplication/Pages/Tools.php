<?= $this->extend('ServiceApplication/Layout/ServiceLayout'); ?>
<?= $this->section('content'); ?>


<?php $link = base_url('service-request'); ?>
<?= Success() ?>
<?= Error() ?>


<!-- Modal -->

<div class="modal fade" id="toolModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <?= csrf_field() ?>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Tool/Equipment Or Facility</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="toolForm">
                    <input type="text" name="userId" id="" class="form-control" value="<?= $userId ?>" hidden>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Tool/Equipment/Facility</label>
                                <input type="text" name="tool" id="" class="form-control" placeholder="Enter Tool/Equipment Or Facility" aria-describedby="helpId">
                                <small id="tool" class="text-danger" style="display:block ;"></small>
                                <small class="text-muted">List tools, machinery or other resources necessary to carry out the work for the applied license</small>
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


        <button id="sample_editable_1_new" class="btn btn-primary btn-sm pull-left" data-toggle="modal" data-target="#toolModel"> Add Tool/Equipment
            <i class="fa fa-plus"></i>
        </button>
        <div class="btn-group pull-right btn-prev-next">

            <a href="<?= $link . '/license-type' ?>" class="btn btn-sm btn-primary" type="button">
                <i class="fa fa-chevron-left"></i>Back: License Type
            </a>
            <a href="<?= $link . '/attachments' ?>" class="btn btn-sm btn-primary <?= empty($tools) ? 'disabled' : '' ?>" id="nextBtn" type="button">
                next: Attachments<i class="fa fa-chevron-right"></i>
            </a>

        </div>
    </div>
    <div class="card-body">
        <div>
            <table class="table table-sm" style="width:100% ;">
                <thead>
                    <tr>
                        <th>Instrument Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tools">
                    <?php foreach ($tools as $tool) : ?>
                        <tr>
                            <td><?= $tool->tool ?></td>
                            <td><a href="<?= $link . '/deleteTool/' . $tool->id ?>" class="btn  btn-tbl-edit  btn-danger btn-xs"><i class="fas fa-trash"></i></a></td>
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
    const toolForm = document.querySelector('#toolForm')

    toolForm.addEventListener('submit', (e) => {
        e.preventDefault()
        const formData = new FormData(toolForm)
        formData.append('csrf_hash', document.querySelector('.token').value)
        fetch('addTool', {
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
                    tools,
                    msg
                } = data
                document.querySelector('.token').value = token
                validationError('tool', errors)
                if (status == 1) {
                    document.querySelector('#nextBtn').classList.remove('disabled')
                    document.querySelector('#tools').innerHTML = tools
                    toolForm.reset()
                    $('#toolModel').modal('hide')
                    swal({
                        title: msg,
                        icon: "success",
                    });
                }

                console.log(data)
            })
    })
</script>





<?= $this->endSection(); ?>