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
<form action="<?= base_url('service-request/service-application') ?>" method="post">

    <div class="card card-box">
        <div class="card-head">
            <header>Personal Particulars</header>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Company Name / Client Name</label>
                        <input type="text" name="name" id="" class="form-control" placeholder="" value="<?= set_value('name') ?>">
                        <span class="text-danger"><?= displayError($validation, 'name') ?></span>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Tin Number</label>
                        <input type="text" name="tin_number" id="" class="form-control" placeholder="" value="<?= set_value('tin_number') ?>" data-mask="999-999-999 ">
                        <span class="text-danger"><?= displayError($validation, 'tin_number') ?></span>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Mobile Number</label>
                        <input type="text" name="mobile_number" id="" class="form-control" placeholder="" value="<?= set_value('mobile_number') ?>" data-mask="+255 999 999 999">
                        <span class="text-danger"><?= displayError($validation, 'mobile_number') ?></span>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Region</label>
                        <select class="form-control select2bs4" name="region" id="regions" onchange="getDistricts(this.value)">


                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">District</label>
                        <select class="form-control select2bs4" name="district" id="districts" onchange="getWards(this.value)">
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Ward</label>
                        <select class="form-control select2bs4" name="ward" id="wards" onchange="getPostcodes(this.value)">
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Post Code</label>
                        <input type="text" class="form-control" name="postal_code" id="postCode" readonly>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Postal Address</label>
                        <input type="text" name="postal_address" id="postalAddress" class="form-control postal" placeholder="Postal Address">

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Physical Address</label>
                        <input type="text" class="form-control" name="physical_address" id="physicalAddress">

                    </div>
                </div>




            </div>


        </div>

    </div>

    <div class="card card-box">
        <div class="card-head">
            <header>Select Services</header>

        </div>
        <div class="card-body " id="bar-parent2">
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="checkbox checkbox-icon-black">
                            <input id="checkbox1" type="checkbox" value="Vehicle Tank Verification (VTV)" name="services[]" />
                            <label for="checkbox1">
                                Vehicle Tank Verification (VTV)
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="checkbox2" type="checkbox" value="Sandy & Ballast lorry (SBL)" name="services[]">
                            <label for="checkbox2">
                                Sandy & Ballast lorry (SBL)
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="checkbox3" type="checkbox" value="FST – Fixed Storage Tank" name="services[]">
                            <label for="checkbox3">
                                FST – Fixed Storage Tank
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="checkbox4" type="checkbox" value="Bulk Storage Tank (BST)" name="services[]">
                            <label for="checkbox4">
                                Bulk Storage Tank (BST)
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="checkbox5" type="checkbox" value="Pre-packages" name="services[]">
                            <label for="checkbox5">
                                Pre-packages
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="checkbox6" type="checkbox" value="CNG filling Station" name="services[]">
                            <label for="checkbox6">
                                CNG filling Station
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="checkbox7" type="checkbox" value="F/M – Flow Meter " name="services[]">
                            <label for="checkbox7">
                                F/M – Flow Meter
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="checkbox8" type="checkbox" value="Weighing and Linear Measuring Instruments " name="services[]">
                            <label for="checkbox8">
                                Weighing and Linear Measuring Instruments
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="checkbox9" type="checkbox" value="WGT – Wagon Tank " name="services[]">
                            <label for="checkbox9">
                                WGT – Wagon Tank
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="checkbox10" type="checkbox" value="Ch/p - check pump" name="services[]">
                            <label for="checkbox10">
                                Ch/p - check pump
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="BRIM - Brim Measure  system" name="services[]">
                            <label for="">
                                BRIM - Brim Measure system
                            </label>
                        </div>

                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="C/S - Counter scale" name="services[]">
                            <label for="">
                                C/S - Counter scale
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="P/s - Platform scale" name="services[]">
                            <label for="">
                                P/s - Platform scale
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="S/B - Spring Balance" name="services[]">
                            <label for="">
                                S/B - Spring Balance
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="Bal - Balance " name="services[]">
                            <label for="">
                                Bal - Balance
                            </label>
                        </div>



                    </div>
                    <div class="col-md-6">

                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="Kor - Koroboi" name="services[]">
                            <label for="">
                                Kor - Koroboi
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="Vib – Vibaba" name="services[]">
                            <label for="">
                                Vib – Vibaba
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="Ax/w - Weigher" name="services[]">
                            <label for="">
                                Ax/w - Weigher
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="Pis – Pishi" name="services[]">
                            <label for="">
                                Pis – Pishi
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="Au/W - Automatic Weigher" name="services[]">
                            <label for="">
                                Au/W - Automatic Weigher
                            </label>
                        </div>

                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="B/S - Beam Scale" name="services[]">
                            <label for="">
                                B/S - Beam Scale
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="W-Weights" name="services[]">
                            <label for="">
                                W-Weights
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="MR - Metre Rule" name="services[]">
                            <label for="">
                                MR - Metre Rule
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="value" name="services[]">
                            <label for="">
                                value
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="Taximeter" name="services[]">
                            <label for="">
                                Taximeter
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="MR - Metre Rule" name="services[]">
                            <label for="">
                                MR - Metre Rule
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="TM - Tape Measure" name="services[]">
                            <label for="">
                                TM - Tape Measure
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="M. LE - Measures of Length" name="services[]">
                            <label for="">
                                M. LE - Measures of Length
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="value" name="services[]">
                            <label for="">
                                value
                            </label>
                        </div>
                        <div class="checkbox checkbox-icon-yellow">
                            <input id="" type="checkbox" value="value" name="services[]">
                            <label for="">
                                value
                            </label>
                        </div>
                        <!-- ************* -->
                    </div>




                </div>
                <hr>
                <div class="form-group">
                    <label for="">Addition Information</label>
                    <textarea class="form-control" name="addition_info" id="" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</form>


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

                    selectBox.innerHTML = '<option selected disabled>--select--</option>' + options
                }



            })
    }
</script>


<?= $this->endSection(); ?>