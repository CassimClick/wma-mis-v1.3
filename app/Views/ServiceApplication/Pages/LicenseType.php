<?= $this->extend('ServiceApplication/Layout/ServiceLayout'); ?>
<?= $this->section('content'); ?>


<?php $link = base_url('service-request'); ?>
<?= Success() ?>
<?= Error() ?>


<!-- Modal -->

<div class="modal fade" id="licenseModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <?= csrf_field() ?>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type of License Being Applied For</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="licenseForm">
                    <input type="text" name="userId" id="" class="form-control" value="<?= $userId ?>" hidden>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">License Type</label>
                                <select class="form-control" name="licenseType" id="" onchange="showHide(this)">
                                    <option value="">--Select License Type--</option>
                                    <option value="class_a">Class A</option>
                                    <option value="class_b">Class B</option>
                                    <option value="class_c">Class C</option>
                                    <option value="class_d">Class D</option>
                                    <option value="class_e">Class E</option>
                                    <option value="tank_calibration_license">Tank Calibration License</option>
                                    <option value="gas_meter_calibration_license">Gas Meter Calibration License</option>
                                    <option value="tank_fabrication_license">Tank Fabrication License</option>
                                    <option value="pressures_gauges_and_valves_calibration_license">Pressures Gauges & Valves Calibration License</option>

                                </select>
                                <span id="licenseType" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="show-hide" id="class_a">
                            To install, overhaul, service or repair all types of weighing instruments throughout the Mainland Tanzania.
                        </div>
                        <div class="show-hide" id="class_b">
                            To install, overhaul, service or repair not more than six and not less than four types of Measuring Instrument or Systems throughout the Mainland Tanzania.
                        </div>
                        <div class="show-hide" id="class_c">
                            To install, overhaul, service or repair not more than three types of weighing instruments throughout the Mainland Tanzania.
                        </div>
                        <div class="show-hide" id="class_d">
                            To erect, install, overhaul, adjust, service or repair measuring of Liquid Measuring Pumps and Flow Meters throughout the Mainland Tanzania.
                        </div>
                        <div class="show-hide" id="class_e">
                            To manufacture the weighing/measuring instruments or systems throughout the Mainland Tanzania.
                        </div>
                        <div class="show-hide" id="tank_calibration_license">
                            To Calibrate Underground Storage Tanks throughout the Mainland Tanzania
                        </div>
                        <div class="show-hide" id="gas_meter_calibration_license">
                            To Calibrate Gas flow Meters throughout the Mainland Tanzania
                        </div>
                        <div class="show-hide" id="pressures_gauges_and_valves_calibration_license">
                            To Calibrate Gas flow Meters throughout the Mainland Tanzania
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


        <button id="sample_editable_1_new" class="btn btn-primary btn-sm pull-left" data-toggle="modal" data-target="#licenseModel"> Add License Type
            <i class="fa fa-plus"></i>
        </button>
        <div class="btn-group pull-right btn-prev-next">

            <a href="<?= $link . '/applicant-qualifications' ?>" class="btn btn-sm btn-primary" type="button">
                <i class="fa fa-chevron-left"></i>back: Applicant Qualifications
            </a>
            <a href="<?= $link . '/tools' ?>" class="btn btn-sm btn-primary <?= empty($licenses) ? 'disabled' : '' ?>" type="button" id="nextBtn">
               next: Tools/Equipments<i class="fa fa-chevron-right"></i>
            </a>

        </div>
    </div>
    <div class="card-body">
        <div>
            <table class="table table-sm" style="width:100% ;">
                <thead>
                    <tr>
                        <th>License Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="licenses">
                    <?php foreach ($licenses as $license) : ?>
                        <tr>
                            <td><?= $license->type ?></td>
                            <td><a href="<?= $link . '/deleteLicense/' . $license->id ?>" class="btn btn-tbl-edit  btn-danger btn-xs"><i class="fas fa-trash"></i></a></td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>





    </div>
</div>
</div>

<script>
    const infoBlocks = document.querySelectorAll('.show-hide')

    function showHide(elem) {
        if (elem.selectedIndex !== 0) {
            for (var i = 0; i < infoBlocks.length; i++) {
                infoBlocks[i].style.display = 'none';
            }
            document.getElementById(elem.value).style.display = 'block';
        }
    }

    function validationError(field, errors) {
        const element = document.querySelector('#' + field)
        errors[field] ? element.textContent = errors[field] : element.textContent = ''

    }
    const licenseForm = document.querySelector('#licenseForm')

    licenseForm.addEventListener('submit', (e) => {
        e.preventDefault()
        const formData = new FormData(licenseForm)
        formData.append('csrf_hash', document.querySelector('.token').value)
        fetch('addLicense', {
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
                    licenses,
                    msg
                } = data
                document.querySelector('.token').value = token
                validationError('licenseType', errors)
                if (status == 1) {
                    document.querySelector('#nextBtn').classList.remove('disabled')
                    document.querySelector('#licenses').innerHTML = licenses
                    licenseForm.reset()
                    $('#licenseModel').modal('hide')
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