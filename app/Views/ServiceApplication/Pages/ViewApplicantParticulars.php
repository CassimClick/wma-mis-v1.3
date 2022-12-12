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
<?php $link = base_url('service-request'); ?>

<div class="card card-box">
    <div class="card-head">
        <header>Applicant Particulars</header>

        <div class="btn-group pull-right btn-prev-next">

            <a href="<?= $link . '/applicant-qualifications' ?>" class="btn btn-sm btn-primary" type="button">
               Next:</i> Qualifications <i class="fa fa-chevron-right"></i>
            </a>
            
        </div>


    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Applicant Name</label>
                    <input type="text" name="applicant_name" id="" class="form-control" placeholder="" value="<?= $applicant->applicant_name ?>" readonly>


                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Nationality</label>
                    <input type="text" name="applicant_name" id="" class="form-control" placeholder="" value="<?= $applicant->nationality ?>" readonly>
                </div>
            </div>



            <?php if ($applicant->nationality == 'Tanzanian') : ?>
                <div class="col-md-3" id="nidaBlock">
                    <div class="form-group">
                        <label for="">NIDA Number</label>
                        <input type="text" name="nida_number" id="" class="form-control" placeholder="" value="<?= $applicant->nida_number ?>" readonly>


                    </div>
                </div>
            <?php else : ?>

                <div class="col-md-3" id="passportBlock" style="display: none;">
                    <div class="form-group">
                        <label for="">Permit</label>
                        <input type="text" name="nida_number" id="" class="form-control" placeholder="" value="<?= $applicant->passport ?>" readonly>

                    </div>
                </div>
            <?php endif; ?>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Mobile Number</label>
                    <input type="text" name="mobile_number" id="" class="form-control" placeholder="" value="<?= $applicant->mobile_number ?>" readonly>


                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" id="" class="form-control" placeholder="" value="<?= $applicant->email ?>" readonly>


                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Region</label>
                    <input type="text" name="email" id="" class="form-control" placeholder="" value="<?= $applicant->region ?>" readonly>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="">District</label>
                    <input type="text" name="email" id="" class="form-control" placeholder="" value="<?= $applicant->district ?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Ward</label>
                    <input type="text" name="email" id="" class="form-control" placeholder="" value="<?= $applicant->ward ?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Post Code</label>
                    <input type="text" name="email" id="" class="form-control" placeholder="" value="<?= $applicant->postal_code ?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Postal Address</label>
                    <input type="text" name="email" id="" class="form-control" placeholder="" value="<?= $applicant->postal_address ?>" readonly>

                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Physical Address</label>
                    <input type="text" name="email" id="" class="form-control" placeholder="" value="<?= $applicant->physical_address ?>" readonly>

                </div>
            </div>
            <?php if ($applicant->company_registration_number != '') : ?>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Company Registration Number</label>

                        <input type="text" name="email" id="" class="form-control" placeholder="" value="<?= $applicant->company_registration_number ?>" readonly>

                    </div>
                </div>
            <?php endif; ?>

        </div>


    </div>
    <div class="card-footer">
        <a href="<?= base_url('service-request/edit-applicant-particulars/' . $applicant->user_id) ?>" type="submit" class="btn btn-primary btn-sm">Edit</a>
    </div>

</div>





<script>
    function switchNationality(val) {
        const nidaBlock = document.querySelector('#nidaBlock')
        const passportBlock = document.querySelector('#passportBlock')
        if (val == 'Foreigner') {
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

                    selectBox.innerHTML = '<option selected value="<?= $applicant->region ?>"><?= $applicant->region ?></option>' + options
                }



            })
    }
</script>


<?= $this->endSection(); ?>