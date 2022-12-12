<?= $this->extend('layouts/coreLayout'); ?>
<?= $this->section('content'); ?>
<?php
$pageSession = \CodeIgniter\Config\Services::session();
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="container">
                    <h1 class="m-0 text-dark"><?= $page['heading'] ?></h1>
                </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?= $page['heading'] ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content body">
    <div class="container-fluid">
        <?= view('Components/bill') ?>
        <?= view('Components/ClientsBlock') ?>


        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 flex">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#waterMeterModal"><i class="far fa-plus"></i> Add Water Meter</button>
                            <button type="button" class="btn btn-success btn-sm" onclick="getWaterMeters()"><i class="far fa-list"></i>
                                List Water Meters</button>

                        </div>


                    </div>
                    <!-- /.card-tools -->
                </div>
                <div class="card-body">
                    <form id="waterMeterBillForm">


                        <div id="unpaidMeters"></div>


                        <div class="form-group">
                            <label for="">Total Amount</label>
                            <input type="text" name="totalAmount" id="totalAmount" class="form-control" readonly>

                        </div>
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
        </div>


    </div>
    <!-- /.card -->

    </div>
    </div>

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="waterMeterModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Water Meters</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="waterMeterForm">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Activity</label>
                                            <select class="form-control" name="activity" id="activity">
                                                <option value="Verification">Verification</option>
                                                <option value="Inspection">Inspection</option>
                                                <option value="Reverification">Reverification</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Brand Name</label>
                                            <input type="text" name="brandName" id="brandName" class="form-control" placeholder="Brand Name" data-required>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Meter Size</label>
                                            <input type="text" name="meterSize" id="meterSize" class="form-control" placeholder="Meter Size" data-required>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Flow Rate Maximum</label>
                                            <input type="text" name="flowRate" id="flowRate" class="form-control" placeholder="Flow Rate" data-required>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Class</label>
                                            <input type="text" name="class" id="class" class="form-control" placeholder="Class" data-required>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Testing Center</label>
                                            <input type="text" name="testingLab" id="testingLab" class="form-control" placeholder="Testing Laboratory" data-required>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Test Method</label>
                                            <select class="form-control" name="testMethod" id="testMethod">
                                                <option value="Volumetric">Volumetric</option>
                                                <option value="Gravimetric">Gravimetric</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Verified By</label>
                                            <input type="text" name="verifier" id="verifier" class="form-control" placeholder="Verified By" data-required>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="form-group col-md-4">


                                        <label for="">Actual Volume</label>
                                        <select class="form-control" name="actualVolume" id="actualVolume">
                                            <option value="100">100 Liters</option>
                                            <option value="200">200 Liters</option>
                                            <option value="300">300 Liters</option>
                                            <option value="400">400 Liters</option>
                                            <option value="500">500 Liters</option>

                                        </select>

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Meter Quantity</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Number Of Meters" data-required>
                                    </div>
                                    <div class="form-group col-md-4">

                                        <button type="button" class="btn btn-primary  " style="margin-top:1.8rem ;" onclick="generateFields()"><i class="far fa-sync"></i> Generate Fields</button>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Meter Serial No</th>
                                            <th>Initial Reading</th>
                                            <th>Final Reading</th>
                                            <th>Indicated Volume Vi (L)</th>
                                            <th>Actual Volume Va (L)</th>
                                            <th>% Error</th>
                                            <th>Decision</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="fields">


                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

</section>
<script>
    const waterMeterForm = document.querySelector('#waterMeterForm')
    waterMeterForm.addEventListener('submit', (e) => {
        e.preventDefault()
        const formData = new FormData(waterMeterForm)
        formData.append('csrf_hash', document.querySelector('.token').value)
        formData.append('customerId', document.querySelector('#customerId').value)
        fetch('registerWaterMeter', {
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
                    meters
                } = data
                document.querySelector('.token').value = data
                if (status == 1) {
                    getWaterMeters()
                    waterMeterForm.reset()
                    $('#waterMeterModal').modal('hide')
                    swal({
                        title: msg,
                        icon: "success",

                    });
                } else {
                    swal({
                        title: msg,
                        icon: "warning",
                        timer: 6500
                    });
                }
                console.log(data)
            })

    })



    function getWaterMeters() {

        fetch('getUnpaidWaterMeters', {
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
                    status,
                    token,
                    meters
                } = data
                // if (status == 1) {
                // }
                document.querySelector('.token').value = token
                document.querySelector('#unpaidMeters').innerHTML = meters
                calculateTotalAmount()
            })
    }






    function generateFields() {
        const actualVolume = document.querySelector('#actualVolume').value
        const quantity = document.querySelector('#quantity').value
        let fields = ''
        for (let index = 0; index < quantity - 1; index++) {
            fields += /*html*/ `
             <tr>
               <td> <input type="text" name="serialNumber[]" id="serialNumber[]" class="form-control" data-required></td>
               <td> <input type="number" name="initialReading[]" id="initialReading[]" oninput="calculateError(this)"  step="any" class="form-control" data-required></td>
               <td> <input type="number" name="finalReading[]" id="initialReading[]" oninput="calculateError(this)"  step="any" class="form-control" data-required></td>
               <td> <input type="text" name="indicatedVolume[]" id="indicatedVolume[]" step="any" class="form-control" data-required readonly></td>
               <td> <input type="number" name="actualVolume[]" id="actualVolume[]" value="${actualVolume}" class="form-control" readonly data-required></td>
               <td> <input type="text" name="error[]" id="error[]" class="form-control" data-required readonly></td>
               <td> <input type="text" name="decision[]" id="decision[]" class="form-control" data-required readonly></td>
          
               
             </tr>

            
            `

        }


        document.querySelector('#fields').innerHTML = fields
        $('#fields').append( /*html*/ `
        <tr>
               <td> <input type="text" name="serialNumber[]" id="serialNumber[]" class="form-control" data-required></td>
               <td> <input type="number" name="initialReading[]" id="initialReading[]" oninput="calculateError(this)" step="any" class="form-control" data-required></td>
               <td> <input type="number" name="finalReading[]" id="initialReading[]" oninput="calculateError(this)" step="any" class="form-control" data-required></td>
               <td> <input type="text" name="indicatedVolume[]" id="indicatedVolume[]" step="any" class="form-control" data-required readonly></td>
               <td> <input type="number" name="actualVolume[]" id="actualVolume[]" value="${actualVolume}" class="form-control" readonly data-required></td>
               <td> <input type="text" name="error[]" id="error[]" class="form-control" data-required readonly></td>
               <td> <input type="text" name="decision[]" id="decision[]" class="form-control" data-required  readonly></td>
             <td> <button type="button" class="btn btn-primary btn-sm" onclick="addField()"><i class="fas fa-plus"></i></button></td>
               
             </tr>
             
        `)


    }

    function addField() {
        const actualVolume = document.querySelector('#actualVolume').value
        $('#fields').append( /*html*/ `
        <tr>
               <td> <input type="text" name="serialNumber[]" id="serialNumber[]" class="form-control" data-required></td>
               <td> <input type="number" name="initialReading[]" id="initialReading[]" oninput="calculateError(this)" step="any" class="form-control" data-required></td>
               <td> <input type="number" name="finalReading[]" id="initialReading[]" oninput="calculateError(this)" step="any" class="form-control" data-required></td>
               <td> <input type="text" name="indicatedVolume[]" id="indicatedVolume[]" step="any" class="form-control" data-required readonly></td>
               <td> <input type="number" name="actualVolume[]" id="actualVolume[]" value="${actualVolume}" class="form-control" readonly data-required></td>
               <td> <input type="text" name="error[]" id="error[]" class="form-control" data-required readonly></td>
               <td> <input type="text" name="decision[]" id="decision[]" class="form-control" data-required readonly></td>
               <td> <button type="button" class="btn btn-dark btn-sm" onclick="javascript: this.parentNode.parentNode.remove()"><i class="fas fa-ban"></i></button></td>
            
             </tr>

        `)
    }

    function roundNumber(num) {
        return +(Math.round(num + "e+3") + "e-3");
    }


    function calculateError(input) {


        const parent = input.parentNode.parentNode
        const entered = input.value
        const initialReading = parent.children[1].children[0].value
        const finalReading = parent.children[2].children[0].value
        const indicatedVolume = parent.children[3].children[0]
        const actualVolume = parent.children[4].children[0].value
        const error = parent.children[5].children[0]
        const decision = parent.children[6].children[0]
        if (initialReading != '' && finalReading != '') {
            indicatedVolume.value = roundNumber(+(finalReading - initialReading))
            error.value = roundNumber(((+indicatedVolume.value - +actualVolume) / +actualVolume) * 100)
            decision.value = (+error.value >= -2 && +error.value <= 2) ? "PASS" : "FAIL"

        }

        // const netQuantity = parent.children[2].children[0]
        // const comment = parent.children[3].children[0]
        // const status = parent.children[4].children[0]
    }




    function calculateTotalAmount() {
        const itemAmount = document.querySelectorAll('.itemAmount')
        let total = 0
        for (amount of itemAmount) {
            total += Number(amount.value)
        }
        document.querySelector('#totalAmount').value = total

    }

    const waterMeterBillForm = document.querySelector('#waterMeterBillForm')
    waterMeterBillForm.addEventListener('submit', (e) => {
        e.preventDefault()
        const formData = new FormData(waterMeterBillForm)
        formData.append('csrf_hash', document.querySelector('.token').value)
        formData.append('customerId', document.querySelector('#customerId').value)
        fetch('publishWaterMeterData', {
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
                    msg,
                    data1
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
                    document.querySelector('#unpaidMeters').innerHTML = ''
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
                console.log(data1)
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
</script>

<?= $this->endSection(); ?>