<?= $this->extend('ServiceApplication/Layout/ServiceLayout'); ?>
<?= $this->section('content'); ?>
<div class="card"></div>
<!-- <div class="card-header">
   <h4>PERSONAL PARTICULARS</h4>
</div> -->
<!-- Button trigger modal -->
<?= csrf_field() ?>

<!-- Modal -->

<?php if (session()->getFlashdata('success') !== null) : ?>
    <?= Success() ?>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <?= Error() ?>
<?php endif; ?>

<?php $licenseClasses = ['Class A', 'Class B', 'Class C', 'Class D', 'Class E', 'Tank Calibration License', 'Tank Fabrication', 'Accredited meter Verifier', 'Accredited meter Verifier']; ?>


<div class="card card-box">
    <div class="card-head">

        <header>Applicant Particulars</header>

    </div>
    <div class="card-body">
        <form action="<?= base_url('service-request/update-applicant-particulars/' . $applicant->user_id) ?>" method="post">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Applicant Name</label>
                        <input type="text" id="" class="form-control" placeholder="" value="<?= $applicant->applicant_name ?>" readonly>


                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Nationality</label>
                        <input type="text" id="" class="form-control" placeholder="" value="<?= $applicant->nationality ?>" readonly>
                    </div>
                </div>



                <?php if ($applicant->nationality == 'Tanzanian') : ?>
                    <div class="col-md-3" id="nidaBlock">
                        <div class="form-group">
                            <label for="">NIDA Number</label>
                            <input type="text" id="" class="form-control" placeholder="" value="<?= $applicant->nida_number ?>" readonly>


                        </div>
                    </div>
                <?php else : ?>

                    <div class="col-md-3" id="permitBlock" style="display: none;">
                        <div class="form-group">
                            <label for="">Permit</label>
                            <input type="text" id="" class="form-control" placeholder="" value="<?= $applicant->permit ?>" readonly>

                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Mobile Number</label>
                        <input type="text" name="mobile_number" id="" class="form-control" placeholder="" value="<?= $applicant->mobile_number ?>" data-mask="+255 999 999 999">
                        <span class="text-danger"><?= displayError($validation, 'mobile_number') ?></span>


                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" id="" class="form-control" placeholder="" value="<?= $applicant->email ?>">
                        <span class="text-danger"><?= displayError($validation, 'email') ?></span>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">

                        <label for="">Region</label>
                        <select class="form-control" name="region" id="" onchange="getDistricts(this.value)">
                            <?php foreach ($regions as $region) : ?>
                                <option value="<?= $region->name ?>" <?= setSelect($region->name, $applicant->region); ?>><?= $region->name ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>



                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">District</label>
                        <select class="form-control" name="district" id="districts" onchange="getWards(this.value)">
                            <?php foreach ($districts as $district) : ?>
                                <option value="<?= $district->name ?>" <?= setSelect($district->name, $applicant->district); ?>><?= $district->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Ward</label>
                        <select class="form-control" name="ward" id="wards" onchange="getPostcodes(this.value)">
                            <?php foreach ($wards as $ward) : ?>
                                <option value="<?= $ward->name ?>" <?= setSelect($ward->name, $applicant->ward); ?>><?= $ward->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Post Code</label>
                        <input type="text" name="postal_code" id="postCode" class="form-control" placeholder="" value="<?= $applicant->postal_code ?>" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Postal Address</label>
                        <input type="text" name="postal_address" id="" class="form-control" placeholder="" value="<?= $applicant->postal_address ?>">
                        <span class="text-danger"><?= displayError($validation, 'postal_address') ?></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Physical Address</label>
                        <input type="text" name="physical_address" id="" class="form-control" placeholder="" value="<?= $applicant->physical_address ?>">

                    </div>
                </div>
                <?php if ($applicant->company_registration_number != '') : ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Company Registration Number</label>

                            <input type="text" name="company_registration_number" id="" class="form-control" placeholder="" value="<?= $applicant->company_registration_number ?>" data-mask="999-999-999">

                        </div>
                    </div>
                <?php endif; ?>




            </div>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary btn-sm">Update</button>
    </div>
    </form>

</div>





<script>
    //get all regions
    let baseUrl = '<?= base_url() ?>'
    httpRequest('regions', '<?= base_url('fetchAllRegions') ?>', 'all')


    // get all districts
    function getDistricts(region) {
        document.querySelector('#wards').innerHTML = ''
        document.querySelector('#postCode').value = ''
        httpRequest('districts', baseUrl + '/fetchAllDistricts', region)

    }
    // get all wards from the district
    function getWards(district) {
        httpRequest('wards', baseUrl + '/fetchAllWards', district)

    }

    function getPostcodes(ward) {
        httpRequest('postcodes', baseUrl + '/fetchAllPostCodes', ward)

    }

    function httpRequest(element, url, param) {


        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    "X-Requested-With": "XMLHttpRequest"
                },

                body: JSON.stringify({
                    param: param,
                    // csrf_hash: document.querySelector('.token').value
                }),

            }).then(response => response.json())
            .then(data => {

                const selectBox = document.querySelector('#' + element)
                const {
                    status,
                    token,
                    dataList
                } = data

                console.log(dataList)
                console.log(url)
                document.querySelector('.token').value = token
                if (dataList.postcode) {
                    document.querySelector('#postCode').value = dataList.postcode != undefined ? dataList.postcode : ''
                } else {
                    const options = dataList.map(list =>
                        `<option value="${list.name}">${list.name}</option>`
                    )

                    selectBox.innerHTML = options
                }



            })
    }
</script>


<?= $this->endSection(); ?>