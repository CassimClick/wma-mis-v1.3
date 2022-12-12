<div id="plateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Search Plate Number</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- <div class="input-group">
                    <input class="form-control" type="text" placeholder="Plate Number" id="plateNumber">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary" id="plateSearch"><i class="far fa-search"></i>
                            Search</button>
                    </div>
                </div> -->

                <div id="searchResults"></div>

            </div>
            <div class="modal-footer">
                Footer
            </div>
        </div>
    </div>
</div>
<div class="modal edit-vtc-modal fade" id="edit-vtc">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New vehicle Tank</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="customerForm">
                <div class="modal-body">
                    <div class="form-group">
                        <input id="customerHash" class="form-control" type="text">
                    </div>
                    <div class="row">
                        <!-- <div class="form-group col-md-6">
                            <label for="">Date</label>
                            <input id="createdAt" class="form-control" type="date">
                        </div> -->
                        <div class="form-group col-md-6">
                            <label for="">Activity</label>
                            <select class="form-control" name="" id="activityUpdate">
                                <option disabled selected>-Select Activity-</option>
                                <option value="On Verification">On Verification</option>
                                <option value="Reverification">Reverification</option>
                                <option value="Inspection">Inspection</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Supervisor Name</label>
                            <input type="text" class="form-control" id="supervisorUpdate"
                                placeholder="Enter Supervisor">


                        </div>
                        <div class="form-group col-md-6">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" id="supervisorPhoneUpdate"
                                placeholder="Enter owner or company">


                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tin Number </label>
                        <input type="text" class="form-control" id="tinNumberUpdate" placeholder="Enter Tin Number">


                    </div>
                    <div class="form-group">
                        <label for="my-input">Driver's Full Name</label>

                        <div class="input-group">
                            <input class="form-control" id="driverNameUpdate" type="text"
                                placeholder=" Enter Driver's full Name" value="">

                        </div>


                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Vehicle Brand</label>
                            <input type="text" class="form-control" id="vehicleBrandUpdate" placeholder="Enter Brand">


                        </div>
                        <div class="form-group col-md-6">
                            <label>Vehicle Plate Number </label>
                            <input type="text" class="form-control" id="plateNumberUpdate"
                                placeholder="Enter Plate Number">


                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label>Tank Capacity</label>
                            <input type="number" class="form-control" id="tankCapacityUpdate"
                                placeholder="Enter  Tank Capacity">

                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Status</label>
                            <select class="form-control" id="status">
                                <option value="Valid"> Valid</option>
                                <option value="Not valid"> Not valid</option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="my-textarea">Remark</label>
                        <textarea id="remarkUpdate" class="form-control" name="" rows="3"></textarea>
                    </div>
                </div>
            </form>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="update-vtc">Update</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>





<script>
const plateSearch = document.querySelector('#plateSearch')

plateSearch.addEventListener('click', (e) => {
    e.preventDefault()
    const plateNumber = document.querySelector('#plateNumber')
    const hash = document.querySelector('#customerHash')


    if (hash.value == '') {
        swal({
            title: 'Select Customer First',
            icon: "warning",
            timer: 2500
        });
    } else {
        if (plateNumber.value == '') {
            plateNumber.style.border = '1px solid red'
        } else {
            plateNumber.style.border = '1px solid green'
            renderResult(hash.value, plateNumber.value)
        }


    }

})

function renderResult(hash, plateNumber) {

    const resultContainer = document.querySelector('#vehicles')
    $.ajax({
        type: "POST",
        url: "searchVtc",
        data: {
            hash: hash,
            plateNumber: plateNumber,

        },
        dataType: "json",
        success: function(response) {
            // $('#vehicles').html('')
            console.log(response)
            if (response == 'empty') {
                $('#vehicles').append('<tr></tr>')
            } else {
                $('#searchPlate').css('visibility', 'visible')

                $('#vehicles').append(
                    `
                      
                                <li class="list-group-item">${response.vehicle_brand}
                                | ${response.plate_number}
                                | ${response.capacity} Litres
                                | <span class="amount">${response.amount} </span>
                                | Driver:${response.driver_name}
                                | ${response.status}
                                <button type="button" data-remove="remove" class="remove btn btn-danger btn-sm ">Remove</i></button>
                                <button type="button" class="btn btn-success btn-sm"
                                        onclick="editVehicle('${response.id}')">Update</button>
                                        <input type='text' value='${response.id} hidden' class='vehicleId'>
                                        </li>

                            
                        `
                )

            }
        }
    });



}



const resultContainer = document.querySelector('#vehicles') //tbody
resultContainer.addEventListener('click', (e) => {

    if (e.target.hasAttribute('data-remove', 'remove')) {

        const li = e.target.parentElement;

        resultContainer.removeChild(li)

    }
})

function editVehicle(id) {
    $('.edit-vtc-modal').modal({
        show: true,
        focus: true,
        backdrop: 'static'

    })
}

function updateVehicle() {
    const updateVtc = document.querySelector('#update-vtc')


    updateVtc.addEventListener('click', () => {
        const vtcCustomerHash = $('#customerHash')
        const activityUpdate = $('#activityUpdate')
        const tinNumberUpdate = $('#tinNumberUpdate')
        const supervisorUpdate = $('#supervisorUpdate')
        const supervisorPhoneUpdate = $('#supervisorPhoneUpdate')
        const driverNameUpdate = $('#driverNameUpdate')
        const vehicleBrandUpdate = $('#vehicleBrandUpdate')
        const plateNumberUpdate = $('#plateNumberUpdate')
        const tankCapacityUpdate = $('#tankCapacityUpdate')
        const statusUpdate = $('#statusUpdate')
        const amountUpdate = $('#amountUpdate')
        const remarkUpdate = $('#remarkUpdate')



        function validateInput(formInput) {

            if (formInput.val() == '') {
                formInput.css('border', '1px solid #ff6348')
                return false
            } else {
                formInput.css('border', '1px solid #2ed573')
                return true
            }

        }



        if (validateInput(activityUpdate) && validateInput(supervisorUpdate) && validateInput(
                supervisorPhoneUpdate) &&
            validateInput(tinNumberUpdate) && validateInput(driverNameUpdate) && validateInput(
                vehicleBrandUpdate) &&
            validateInput(plateNumberUpdate) && validateInput(tankCapacityUpdate) && validateInput(statusUpdate)
        ) {



            $.ajax({
                type: "POST",
                url: "updateVehicleTank",
                data: {
                    vtcCustomerHash: vtcCustomerHash.val(),
                    createdAt: createdAtUpdate.val(),
                    activity: activityUpdate.val(),
                    tinNumber: tinNumberUpdate.val(),
                    supervisor: supervisorUpdate.val(),
                    supervisorPhone: supervisorPhoneUpdate.val(),
                    driverName: driverNameUpdate.val(),
                    vehicleBrand: vehicleBrandUpdate.val(),
                    plateNumber: plateNumberUpdate.val(),
                    tankCapacity: tankCapacityUpdate.val(),
                    status: statusUpdate.val(),
                    charges: chargesUpdate.val(),
                    remark: remarkUpdate.val(),



                },
                dataType: "json",
                success: function(response) {
                    //clearInputs()
                    $('.vtc-modal').modal('hide');

                    // console.log(response)
                    syncVehicles()

                    if (response == 'Added') {
                        swal({
                            title: 'Vehicle Added',
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
                error: function(err) {
                    console.log(err)
                }

            });

        }



    })
}

function calcTotal() {
    const amounts = document.querySelectorAll('.amount')
    let total = 0;
    for (let amount of amounts) {
        total += parseInt(amount.innerHTML)
    }
    $('#totalAmount').val(total)

}
</script>