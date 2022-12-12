<div class="row">
    <div class="col-md-<?= $colSize ?>">
        <div class="form-group">
            <label for="">Name Of The Company/Client</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Name Of The Company/Client" required>

        </div>
    </div>

    <div class="col-md-<?= $colSize ?>">
        <div class="form-group">
            <label for="">Region</label>
            <select class="form-control select2bs4" name="region" id="regions" onchange="getDistricts(this.value)">


            </select>
        </div>
    </div>

    <div class="col-md-<?= $colSize ?>">
        <div class="form-group">
            <label for="">District</label>
            <select class="form-control select2bs4" name="district" id="districts" onchange="getWards(this.value)">
            </select>
        </div>
    </div>
    <div class="col-md-<?= $colSize ?>">
        <div class="form-group">
            <label for="">Ward</label>
            <select class="form-control select2bs4" name="ward" id="wards" onchange="getPostcodes(this.value)">
            </select>
        </div>
    </div>
    <div class="col-md-<?= $colSize ?>">
        <div class="form-group">
            <label for="">Post Code</label>
            <input type="text" class="form-control" name="postalCode" id="postCode" readonly>

        </div>
    </div>
    <div class="col-md-<?= $colSize ?>">
        <div class="form-group">
            <label for="">Village</label>
            <input type="text" class="form-control" name="village" id="village" >

        </div>
    </div>
    <div class="col-md-<?= $colSize ?>">
        <div class="form-group">
            <label for="">Physical Address</label>
            <input type="text" class="form-control" name="physicalAddress" id="physicalAddress">

        </div>
    </div>
    <div class="col-md-<?= $colSize ?>">
        <div class="form-group">
            <label for="">Location</label>
            <input type="text" class="form-control" name="location" id="location">

        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Postal Address</label>
            <input type="text" name="postalAddress" id="postalAddress" class="form-control postal" placeholder="Postal Address">

        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="">Phone Number</label>
            <input type="text" name="phoneNumber" id="phoneNumber" class="form-control phone" placeholder="Phone Number" required>

        </div>
    </div>
</div>

<script>
    //get all regions
    httpRequest('regions', 'fetchRegions', 'all')


    // get all districts
    function getDistricts(region) {
        document.querySelector('#wards').innerHTML = ''
        document.querySelector('#postCode').value = ''
        httpRequest('districts', 'fetchDistricts', region)

    }
    // get all wards from the district
    function getWards(district) {
        httpRequest('wards', 'fetchWards', district)

    }

    function getPostcodes(ward) {
        httpRequest('postcodes', 'fetchPostCodes', ward)

    }

    function httpRequest(element, url, param) {

        const selectBox = document.querySelector('#' + element)
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
                const {
                    status,
                    token,
                    dataList
                } = data
                document.querySelector('.token').value = token
                if (url == 'fetchPostCodes') {
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