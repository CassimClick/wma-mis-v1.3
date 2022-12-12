<!-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#plateModal"><i
        class="far fa-search"></i> Search </button> -->



<?= view('Components/vtc/searchVtc') ?>



<div class="card">
    <div class="card-header">CALIBRATION CHART</div>
    <div class="card-body" id="chartResults" style="display: none;">
        <table class="table">


            <tbody>
                <tr class="row" id="upperChart"></tr>


            </tbody>



        </table>
        <table class="table text-bold">
            <tr class=" row">
                <td class="col-md-6">The dipsticks were marked</td>
                <td class="col-md-6">
                    <span id="chartNumber"></span></br>
                    <span id="customer"></span></br>
                    <span id="plateNumber"></span></br>
                </td>
            </tr>

            <tr class="row" id="lowerChart">


            </tr>
        </table>
        <span class="text-bold">The tank was verified &nbsp; 1. On a level plane 2 . against approved measure</><br>
            NOTE (a) the compartments should be filled in the order &nbsp; <span id="fillOrder"></span> and emptied in the order &nbsp; <span id="emptyOrder"></span> <br>
            (b) THIS TANK SHALL BE VERIFIED AGAIN IF SUSPECTED OF GIVING INCORRECT MEASUREMENTS BUT IN ANY CASE NOT LATER THAN <span id="nextVerification"></span>

    </div>
    <div class="card-footer">
        <a target="_blank" class="btn btn-primary btn-sm" id="chartDownload" style="float:right;"><i class="fal fa-download" aria-hidden="true"></i> Download Chart</a>
    </div>
    <!-- <table class="table text-bold">
        <tr>
            <td>
                DATE: 07 Apr 2022 <br>
                <span>DISTRIBUTION OF COPIES:-</span> <br>
                1. ASTRA LOGISTICS <br>
                1. WMA PO BOX 313 DAR ES SALAAM
            </td>
            <td class="">
                <span>REGIONAL MANAGER</span> <br>
                ILALA<br>
            </td>
            <td>
                <div class="p-1" style="border:1px solid gray;height:130px; width:130px">
                    WMA OFFICIAL SEAL
                </div>
            </td>
        </tr>
    </table> -->
</div>





<div class="card mt-3">
    <div class="card-header">
        <button type="button" class="btn btn-primary btn-sm" onclick="getCalibratedTanks()">
            <i class="far fa-eye" aria-hidden="true"></i> View Calibrated
        </button>
    </div>

    <div class="card-body">
        <form id="vtvDataForm">
            <div id="getCalibratedTanks"></div>

            <!-- including receipt modal -->

            <?= view('Components/controlNumber') ?>



            <div class="form-group">
                <label for="my-select">Payment</label>
                <select id="payment" class="form-control" name="payment">
                    <!-- <option selected disabled>-Select Payment-</option> -->
                    <option value="Paid">Paid</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary btn-sm">Save</button>
    </div>
    </form>
</div>



<div class="vtc">

</div>


<div class="modal vtc-modal fade" id="add-vtc">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Vehicle Tank</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="vtvForm">
                <div class="modal-body">
                    <div class="form-group">
                        <input id="customerId" name="customerId" class="form-control" type="text" hidden>
                    </div>
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="">Activity</label>
                            <select class="form-control" name="activity" id="activity">
                                <!-- <option disabled selected>-Select Activity-</option> -->
                                <option value="Verification">Verification</option>
                                <option value="Reverification">Reverification</option>
                                <option value="Inspection">Inspection</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tin Number </label>
                                <input type="text" class="form-control tin " name="tinNumber" id="tinNumber" placeholder="Enter Tin Number">


                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="my-input">Driver's Full Name</label>

                            <div class="input-group">
                                <input class="form-control " name="driverName" id="driverName" type="text" placeholder=" Enter Driver's full Name" value="">

                            </div>


                        </div>
                        <div class="form-group col-md-6">
                            <label for="my-input">Driver's License</label>

                            <div class="input-group">
                                <input class="form-control license " name="driverLicense" id="driverLicense" type="text" placeholder=" Enter Driver's License" value="">

                            </div>


                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Vehicle Brand</label>
                            <input type="text" class="form-control " name="vehicleBrand" id="vehicleBrand" placeholder="Enter Brand" required>


                        </div>
                        <div class="form-group col-md-6">
                            <label>Number Of Compartments</label>
                            <select class="form-control" name="compartments" id="compartments" required>
                                <!-- <option value=""></option> -->
                                <?php for ($i = 1; $i <= 8; $i++) : ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>

                            </select>


                        </div>

                        <div class="form-group col-md-6">
                            <label>Hose Plate Number </label>
                            <input type="text" class="form-control " name="hosePlateNumber" id="hosePlateNumber" placeholder="Hose Plate Number" oninput="this.value = this.value.toUpperCase().replaceAll(/\s/g,'')">

                        </div>
                        <div class="form-group col-md-6">
                            <label>Trailer Plate Number </label>
                            <input type="text" class="form-control " name="trailerPlateNumber" id="trailerPlateNumber" placeholder="Trailer Plate Number" oninput="this.value = this.value.toUpperCase().replaceAll(/\s/g,'')">

                        </div>
                        <div class="form-group col-md-12">
                            <label>Sticker Number</label>
                            <input type="text" class="form-control vtcSticker " name="stickerNumber" id="stickerNumber" placeholder="Enter Sticker Number">

                        </div>
                    </div>


                    <div class="row">


                    </div class="form-group col-md-12">
                    <div class="form-group">
                        <label for="my-textarea">Remark</label>
                        <textarea id="remark" name="remark" class="form-control " name="" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="save-vtc">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Search customer -->

<script>
    //=================Publish vtc data with vehicle id customer hash and control number====================

    const vtvDataForm = document.querySelector('#vtvDataForm')

    vtvDataForm.addEventListener('submit', (e) => {
        e.preventDefault()
        const formData = new FormData(vtvDataForm)
        formData.append('csrf_hash', document.querySelector('.token').value)
        fetch('publishVtcData', {
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
                    bill,
                    token,
                    msg
                } = data

                if (status == 1) {
                    swal({
                        title: msg,
                        // text: "You clicked the button!",
                        icon: "success",
                        // timer: 3500
                    });
                    controlNumber.value = ''
                    setTimeout(() => {
                        // location.reload()
                    }, "2000")

                    printBill(bill)
                    document.querySelector('#getCalibratedTanks').innerHTML = ''
                    document.querySelector('#totalAmount').value = ''
                } else {
                    swal({
                        title: msg,
                        // text: "You clicked the button!",
                        icon: "warning",
                        // timer: 2500
                    });
                }
                document.querySelector('.token').value = token
                console.log(data)
            })
    })







    function printBill(bill) {
        // console.log('printing ......')
        console.log(bill)
        $('#printModal').modal({
            open: true,
            backdrop: 'static'
        })
        $('#billCustomer').html( /*html*/ `
            
            <tr>
               <td>Control Number:</td>
              <td><b>${bill.controlNumber}</b></td>
              </tr>
            <tr>
                <td>Payment Ref:</td>
                <td><b>${bill.paymentRef}</b></td>
            </tr>
            <tr>
                <td>Payer:</td>
                <td>${bill.payer.name}</td>
            </tr>
            <tr>
                <td>Payer Phone:</td>
                <td>${bill.payer.phone_number}</td>
            </tr>
            `)
        let sn = 1
        const items = bill.products.map(item => `
            <tr>
             <td>${sn++}</td>
             <td>${item.product}</td>
             <td>${item.amount}</td>
            </tr>
            
            `)
        $('#billItems').html(items)
        $('#billTotal').html(bill.billTotal)
        $('#billTotalInWords').html(bill.billTotalInWords)
        $('#preparedBy').html(bill.createdBy)
        $('#printedBy').html(bill.printedBy)
        $('#printedOn').html(bill.printedOn)

        const refs = document.querySelectorAll('.ref')
        refs.forEach(r => r.textContent = bill.controlNumber)
    }


    function syncVehicles() {

        const totalAmount = document.querySelector('#totalAmount')
        let total = 0
        const hashValue = document.querySelector('#customerId').value

        if (hashValue != '') {
            $.ajax({
                type: "POST",
                url: "getUnpaidVehicles",
                data: {
                    // csrf_hash: document.querySelector('.token').value, vehicleDetails
                    hashValue: hashValue
                },
                dataType: "json",
                success: function(vehicles) {
                    console.log(vehicles)
                    // const {status,token,}

                    document.querySelector('.token').value = vehicles.token
                    if (vehicles.status == 0) {
                        document.querySelector('#vehicleDetails').innerHTML = ''
                    }
                    $('#noCompartments').html(vehicles.compartmentDropdown)

                }
            });
        } else {
            swal({
                title: 'Please Select Customer First!',
                // text: "You clicked the button!",
                icon: "warning",
                timer: 2500
            });
        }


    }

    function getVehicleDetails(vehicleId) {
        document.querySelector('#calibrationForm').reset()
        document.querySelector('#dataRows').innerHTML = ''

        if (vehicleId != '') {
            fetch('getVehicleDetails', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8',
                        "X-Requested-With": "XMLHttpRequest"
                    },

                    body: JSON.stringify({
                        vehicleId: vehicleId,
                        csrf_hash: document.querySelector('.token').value

                    }),

                }).then(response => response.json())
                .then(data => {
                    console.log(data.data)
                    const {
                        token,
                        chart,
                        noOfCompartments,
                        vehicle,

                    } = data

                    // console.log(chart)
                    processChartDetails(chart)

                    document.querySelector('.token').value = token
                    document.querySelector('#vehicleDetails').innerHTML = vehicle
                    document.querySelector('#compNumber').innerHTML = noOfCompartments




                    // console.log(data)
                })
        }


    }


    const addVtcButton = document.querySelector('#addVtcButton')
    addVtcButton.addEventListener('click', (e) => {
        e.preventDefault()
        const Hash = document.querySelector('#customerId').value
        if (Hash != '') {
            $('.vtc-modal').modal({
                show: true,
                focus: true,
                backdrop: 'static'

            })
        } else {
            checkCustomer()
        }



    })
    const vtvForm = document.querySelector('#vtvForm')

    vtvForm.addEventListener('submit', (e) => {
        e.preventDefault()
        const formData = new FormData(vtvForm)
        formData.append('csrf_hash', document.querySelector('.token').value)
        formData.append('customerId', document.querySelector('#customerId').value)
        fetch('newVehicleTank', {
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
                    msg,
                    vehicles
                } = data

                document.querySelector('.token').value = token
                if (status == 1) {
                    vtvForm.reset()
                    $('.vtc-modal').modal('hide')
                    swal({
                        title: msg,
                        icon: "success",
                    });
                } else {
                    swal({
                        title: msg,
                        icon: "warning",
                        timer: 5500
                    });
                }
                console.log(data)
            })
    })

    function getCalibratedTanks() {
        fetch('getCalibratedTanks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    "X-Requested-With": "XMLHttpRequest"
                },

                body: JSON.stringify({
                    customerId: document.querySelector('#customerId').value,
                    csrf_hash: document.querySelector('.token').value
                }),

            }).then(response => response.json())
            .then(data => {
                const {
                    htmlTable,
                    status,
                    token
                } = data
                document.querySelector('.token').value = token
                document.querySelector('#getCalibratedTanks').innerHTML = htmlTable
                calculateTotalAmount()
                // console.log(htmlTable)

            })
    }
</script>