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
<form action="<?= base_url('service-request/add-applicant-particulars') ?>" method="post">

    <div class="card card-box">
        <div class="card-head">
            <header>Applicant Particulars</header>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Applicant/Company Name</label>
                        <input type="text" name="applicant_name" id="" class="form-control" placeholder="" value="<?= set_value('applicant_name') ?>">
                        <span class="text-danger"><?= displayError($validation, 'applicant_name') ?></span>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Nationality</label>
                        <select class="form-control" name="nationality" id="countries" onchange="switchNationality(this.value)" style="height: 2.8rem !important;">
                            <option value="Tanzanian">Tanzanian</option>
                            <?php foreach (countries() as $country) : ?>

                                <option value="<?= $country ?>"><?= $country ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>
                <div class="col-md-3" id="nidaBlock">
                    <div class="form-group">
                        <label for="">NIDA Number</label>
                        <input type="text" name="nida_number" id="" class="form-control" placeholder="" value="<?= set_value('nida_number') ?>" data-mask="+255 999 999 999">
                        <span class="text-danger"><?= displayError($validation, 'nida_number') ?></span>

                    </div>
                </div>
                <div class="col-md-3" id="passportBlock" style="display: none;">
                    <div class="form-group">
                        <label for="">Passport Number</label>
                        <input type="text" name="passport" id="" class="form-control" placeholder="" value="<?= set_value('passport') ?>">
                        <span class="text-danger"><?= displayError($validation, 'passport') ?></span>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Mobile Number</label>
                        <input type="text" name="mobile_number" id="" class="form-control" placeholder="" value="<?= set_value('mobile_number') ?>" data-mask="9999999999-99999-99999-99">
                        <span class="text-danger"><?= displayError($validation, 'mobile_number') ?></span>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" id="" class="form-control" placeholder="" value="<?= set_value('email') ?>">
                        <span class="text-danger"><?= displayError($validation, 'email') ?></span>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Region</label>
                        <select class="form-control select2bs4" name="region" id="regions" onchange="getDistricts(this.value)">


                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">District</label>
                        <select class="form-control select2bs4" name="district" id="districts" onchange="getWards(this.value)" value="<?= set_value('district') ?>">
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Ward</label>
                        <select class="form-control select2bs4" name="ward" id="wards" onchange="getPostcodes(this.value)" value="<?= set_value('ward') ?>">
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Post Code</label>
                        <input type="text" class="form-control" name="postal_code" id="postCode" readonly value="<?= set_value('postal_code') ?>">

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Postal Address</label>
                        <input type="text" name="postal_address" id="postalAddress" class="form-control postal" placeholder="Postal Address" value="<?= set_value('postal_address') ?>">

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Physical Address</label>
                        <input type="text" class="form-control" name="physical_address" id="physicalAddress" value="<?= set_value('physical_address') ?>">

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Company Registration Number</label>
                        <input type="text" class="form-control" name="company_registration_number" id="physicalAddress" value="<?= set_value('company_registration_number') ?>" data-mask="999-999-999">

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Previous License Number (If Any)</label>
                        <input type="text" class="form-control" name="previous_license_number" id="physicalAddress" value="<?= set_value('previous_license_number') ?>">

                    </div>
                </div>





            </div>


        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </div>

    </div>


</form>


<script>
    $('#countries').select2({
        width: '100%',
        padding: '40px',
        dropdownCssClass: "bigdrop"
    });

    function switchNationality(val) {
        const nidaBlock = document.querySelector('#nidaBlock')
        const passportBlock = document.querySelector('#passportBlock')
        if (val != 'Tanzanian') {
            passportBlock.style.display = 'block'
            nidaBlock.style.display = 'none'
        } else {
            passportBlock.style.display = 'none'
            nidaBlock.style.display = 'block'
        }

    }
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

                    selectBox.innerHTML = '<option selected disabled>--select--</option>' + options
                }



            })
    }
</script>


<?= $this->endSection(); ?>