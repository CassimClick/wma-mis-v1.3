<button type="button" class="btn btn-primary btn-sm" id="addSblButton"><i class="far fa-plus"></i> Add </button>
<button type="button" class="btn btn-success btn-sm" onclick="syncLorries()"><i class="far fa-sync"></i> Check</button>

<div class="input-group  mt-2">
    <input class="form-control" type="text" placeholder="Plate Number" id="licensePlate" oninput="this.value = this.value.toUpperCase().replaceAll(/\s/g,'')">
    <div class="input-group-append">
        <button type="button" class="btn btn-primary btn-sm" id="plateSearch"><i class="far fa-search"></i>
            Search</button>
    </div>
</div>

<?= $this->include('Components/Lorries/searchSbl') ?>


<div class="card mt-3">
    <div class="card-body">

        <div class="form-group">
            <label for="my-input">Total Amount</label>
            <input id="totalAmount" class="form-control" type="text" name="">
        </div>
        <?= $this->include('Components/controlNumber') ?>
        <div class="form-group">
            <label for="my-select">Payment</label>
            <select id="payment" class="form-control" name="">
                <!-- <option selected disabled>-Select Payment-</option> -->
                <option value="Paid">Paid</option>
                <option value="Pending">Pending</option>
            </select>
        </div>

    </div>
</div>



<div class="Sbl"></div>


<div class="modal Sbl-modal fade" id="add-Sbl">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Lorry</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="customerForm">
                <div class="modal-body">
                    <div class="form-group">
                        <input id="customerId" class="form-control" type="text" hidden>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Date</label>
                            <input id="createdAt" class="form-control" type="date">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Activity</label>
                            <select class="form-control" name="" id="activity">
                                <!-- <option disabled selected>-Select Activity-</option> -->
                                <option value="Verification">Verification</option>
                                <option value="Reverification">Reverification</option>
                                <option value="Inspection">Inspection</option>
                            </select>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="form-group col-md-6">
                            <label>Verified by</label>
                            <input type="text" class="form-control clearIt" id="supervisor" placeholder="verified by">


                        </div>
                        <div class="form-group col-md-6">
                            <label>Phone Number</label>
                            <input type="text" class="form-control phone clearIt" id="supervisorPhone" placeholder="Enter owner or company" data-clear>


                        </div>
                    </div> -->
                    <div class="form-group">
                        <label>Tin Number </label>
                        <input type="text" class="form-control tin clearIt" id="tinNumber" placeholder="Enter Tin Number" data-clear>


                    </div>
                    <div class="row">


                        <div class="form-group col-md-6">
                            <label for="my-input">Driver's Full Name</label>

                            <div class="input-group">
                                <input class="form-control clearIt" name="driverName" id="driverName" type="text" placeholder=" Enter Driver's full Name" value="" data-clear>

                            </div>


                        </div>
                        <div class="form-group col-md-6">
                            <label for="my-input">Driver's License</label>

                            <div class="input-group">
                                <input class="form-control license clearIt" id="driverLicense" type="text" placeholder=" Enter Driver's Licence" value="" data-clear>

                            </div>


                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Vehicle Brand</label>
                            <input type="text" class="form-control" id="vehicleBrand" placeholder="Enter Brand" data-clear>


                        </div>
                        <div class="form-group col-md-6">
                            <label>Vehicle Plate Number </label>
                            <input type="text" class="form-control clearIt" id="plateNumber" placeholder="Enter Plate Number" oninput="this.value = this.value.toUpperCase().replaceAll(/\s/g,'')" data-clear>


                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label>Lorry Capacity in m<sup>3</sup></label>
                            <input type="number" class="form-control clearIt" id="lorryCapacity" placeholder="Enter  lorry Capacity in Cubic Meter" data-clear>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Status</label>
                            <select class="form-control" id="status">
                                <option value="Valid"> Valid</option>
                                <option value="Not valid"> Not valid</option>

                            </select>
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label>Sticker Number</label>
                            <input type="text" class="form-control sblSticker clearIt" id="stickerNumber" placeholder="Enter Sticker Number" data-clear>

                        </div>


                        <div class="form-group col-md-6">
                            <label>Other Charges</label>
                            <input type="number" class="form-control clearIt" id="charges" placeholder="Other Charges" data-clear>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="my-textarea">Remark</label>
                        <textarea id="remark" class="form-control clearIt" name="" rows="3" data-clear></textarea>
                    </div>
                </div>
            </form>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="save-Sbl">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Search customer -->
<div class="modal fade" id="search">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Search Existing Customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group">

                    <input id="searchKeyWord" class="form-control border-right-0" type="text">
                    <button type="button" id="searchButton" class="btn btn-primary btn-sm"><i class="far fa-search"></i>Search</button>
                </div>
                <div class="searchResults mt-2">


                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Proceed</button> -->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    //=================Publish Sbl data to transaction table with vehicle id customer hash and control number====================
    function publishSblData() {
        const lorriesIds = document.querySelectorAll('.lorryId')
        const hash = document.querySelector('#customerId')
        const totalAmount = document.querySelector('#totalAmount')
        const payment = document.querySelector('#payment')
        const controlNumber = document.querySelector('#controlNumber')

        // console.log(lorriesIds)
        let vehicleIds = []
        for (id of lorriesIds) {
            vehicleIds.push(id.value)
        }



        // console.log(vehicleId.value)
        $.ajax({
            type: "POST",
            url: "publishLorryData",
            data: {
                // csrf_hash: document.querySelector('.token').value,
                vehicleId: vehicleIds,
                customerHash: hash.value,
                controlNumber: controlNumber.value,
                totalAmount: totalAmount.value,
                payment: payment.value

            },
            dataType: "json",
            success: function(response) {
                // document.querySelector('.token').value = response.token

                console.log(response)
                if (response.status == 1) {
                    $('#vehicles').html('')
                    controlNumber.value = ''
                    swal({
                        title: 'Lorry  Registered',
                        // text: "You clicked the button!",
                        icon: "success",
                        timer: 4500
                    });

                    printBill(response.bill)
                    // setTimeout(() => {
                    //     location.reload()
                    // }, "2000")
                } else {
                    swal({
                        title: 'Something Went Wrong',
                        // text: "You clicked the button!",
                        icon: "warning",
                        // timer: 2500
                    });
                }

            }
        });


    }

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
    //*************************************************************************** */

    //=================check if there is any customer lorry which is not in the transaction table====================
    function syncLorries() {

        const totalAmount = document.querySelector('#totalAmount')
        let total = 0
        const hashString = $('#customerId').val()

        if (hashString != '') {
            $.ajax({
                type: "POST",
                url: "getUnpaidLorries",
                data: {
                    // csrf_hash: document.querySelector('.token').value,
                    hashString: hashString
                },
                dataType: "json",
                success: function(vehicles) {
                    // document.querySelector('.token').value = vehicles.token
                    $('#vehicles').html('')

                    if (vehicles.data == '') {
                        swal({
                            title: 'No Data Found',
                            // text: "You clicked the button!",
                            icon: "warning",
                            timer: 2500
                        });

                    } else {
                        $('#vehicles').html('')
                        for (let vehicle of vehicles.data) {


                            $('#vehicles').append(
                                `
                            <li class="list-group-item">${vehicle.vehicle_brand}
                                | ${vehicle.plate_number}
                                | ${vehicle.capacity} m<sup>3</sup>
                                | <span class="amount">${vehicle.amount} </span>
                                | Driver:${vehicle.driver_name}
                                | ${vehicle.status}
                                | ${vehicle.next_calibration}

                                  <i data-remove="remove" class="fas fa-times-square" id="delete-btn"></i>
                                  <i class="fas fa-pen-square"
                                        onclick="editVehicle('${vehicle.id}')" id="update-btn"></i>

                                        <input type='text' value='${vehicle.id}'  class="lorryId" hidden >
                                </li>

                        `
                            );

                            total += parseInt(vehicle.amount)
                        }
                    }


                    totalAmount.value = total
                }
            });
        } else {
            checkCustomer()
            // swal({
            //     title: 'Please Select Customer First!',
            //     // text: "You clicked the button!",
            //     icon: "warning",
            //     timer: 2500
            // });
        }


    }
    //*********************************************************** */




    //=================Taking all lorry details and store to sandy lorries table====================
    function SblProcessing() {
        const addSblButton = document.querySelector('#addSblButton')
        addSblButton.addEventListener('click', (e) => {
            e.preventDefault()
            const Hash = document.querySelector('#customerId').value

            // console.log(Hash.value);

            if (Hash == '') {
                checkCustomer()
                // swal({
                //     title: 'Please Select Customer First!',
                //     icon: "warning",
                //     timer: 2500
                // });
            } else {
                $('.Sbl-modal').modal({
                    show: true,
                    focus: true,
                    backdrop: 'static'

                })
            }


        })

        const saveSbl = document.querySelector('#save-Sbl')


        saveSbl.addEventListener('click', () => {
            const sblCustomerHash = $('#customerId')
            const createdAt = $('#createdAt')
            const activity = $('#activity')
            const tinNumber = $('#tinNumber')
            const driverName = $('#driverName')
            const driverLicense = $('#driverLicense')
            const vehicleBrand = $('#vehicleBrand')
            const plateNumber = $('#plateNumber')
            const lorryCapacity = $('#lorryCapacity')
            const status = $('#status')
            const stickerNumber = $('#stickerNumber')
            const amount = $('#amount')
            const charges = $('#charges')
            const remark = $('#remark')



            function validateInput(formInput) {

                if (formInput.val() == '') {
                    formInput.css('border', '1px solid #ff6348')
                    return false
                } else {
                    formInput.css('border', '1px solid #2ed573')
                    return true
                }

            }



            if (validateInput(createdAt) && validateInput(activity) && validateInput(
                    driverName) && validateInput(vehicleBrand) &&
                validateInput(plateNumber) && validateInput(lorryCapacity) && validateInput(status) &&
                validateInput(stickerNumber)) {



                $.ajax({
                    type: "POST",
                    url: "registerLorry",
                    data: {
                        // csrf_hash: document.querySelector('.token').value,
                        sblCustomerHash: sblCustomerHash.val(),
                        createdAt: createdAt.val(),
                        activity: activity.val(),
                        // supervisor: supervisor.val(),
                        tinNumber: tinNumber.val(),

                        driverName: driverName.val(),
                        driverLicense: driverLicense.val(),
                        vehicleBrand: vehicleBrand.val(),
                        plateNumber: plateNumber.val(),
                        lorryCapacity: lorryCapacity.val(),
                        status: status.val(),
                        stickerNumber: stickerNumber.val(),
                        amount: amount.val(),
                        charges: charges.val(),
                        remark: remark.val(),



                    },
                    dataType: "json",
                    success: function(response) {
                        // document.querySelector('.token').value = response.token
                        console.log(response)
                        // syncLorries()

                        $('.Sbl-modal').modal('hide');

                        if (response.status == 1) {

                            clearInputs()
                            swal({
                                title: 'Lorry Added',
                                // text: "You clicked the button!",
                                icon: "success",
                                button: "Ok",
                            });

                            grabLastVehicle()


                        } else {
                            swal({
                                title: 'Something Went Wrong!',
                                // text: "You clicked the button!",
                                icon: "error",
                                button: "Ok",
                            });
                        }


                    },


                });
                //************************************** */


                //=================take last   saved vehicle from the database  ====================
                function grabLastVehicle() {
                    $.ajax({
                        type: "GET",
                        url: "grabLastLorry",

                        dataType: "json",
                        success: function(vehicle) {
                            console.log(vehicle.data_id)

                            $('#vehicles').append(
                                `
                            <li class="list-group-item">${vehicle.vehicle_brand}
                                | ${vehicle.plate_number}
                                | ${vehicle.capacity} m<sup>3</sup>
                                | <span class="amount">${vehicle.amount} </span>
                                | Driver:${vehicle.driver_name}
                                | ${vehicle.status}
                                | ${vehicle.next_calibration}

                                  <i data-remove="remove" class="fas fa-times-square" id="delete-btn"></i>
                                  <i class="fas fa-pen-square"
                                        onclick="editVehicle('${vehicle.id}')" id="update-btn"></i>

                                        <input type='text' value='${vehicle.plate_number}'  class="lorryId" hidden >
                                </li>

                        `
                            );

                        }
                    });
                }

                //*********************************************************** */




            }

        })
    }

    SblProcessing()

    //=====================================
</script>