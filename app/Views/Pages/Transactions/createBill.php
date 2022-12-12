<?= $this->extend('layouts/coreLayout'); ?>
<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1 class="m-0 text-dark"></h1> -->
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

<div class="container-fluid">



    <?= view('Components/receipt') ?>



    <!-- Modal -->
    <div class="modal modal-static fade" id="cancelPayment" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Cancellation</h5>

                </div>
                <div class="modal-body">
                    <form id="cancelPaymentForm">
                        <div class="form-group">
                            <label for="">Control Number</label>
                            <input type="text" name="controlNumber" id="controlNumber" class="form-control" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea class="form-control" name="description" id="" rows="3" required></textarea>
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

    <script>
        $('#exampleModal').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            // Use above variables to manipulate the DOM

        });
    </script>
        <form id="billSubmissionRequest">
    <div class="card">

        <div class="card-header">

            BILL CREATION
        </div>
            <div class="card-body">


                <div class="row">

                  
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Payer Name</label>
                            <input type="text" name="PyrName" id="" class="form-control">

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Bill Description <span class="text-danger">*</span></label>
                            <input type="text" name="BillDesc" id="" class="form-control">

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Email Address</label>
                            <input type="text" name="PyrEmail" id="" class="form-control">

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="PyrCellNum" id="" class="form-control phone">

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Currency <span class="text-danger">*</span></label>
                            <select class="form-control" name="Ccy" id="">
                                <option value="TZS">TZS</option>
                                <option value="USD">USD</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Exchange Rate<span class="text-danger"></span></label>
                            <input type="text" id="" class="form-control">

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Expiry Date<span class="text-danger"></span></label>
                                    <input type="number" name="" id="" class="form-control" oninput="calculateDate(this.value)">

                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">(dd-mm-yyy)<span class="text-danger"></span></label>
                                    <input type="text" name="BillExprDt" id="expiryDate" readonly class="form-control">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Set Reminder<span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" name="RemFlag" type="checkbox" checked="" style="transform:scale(1.3) ; accent-color:#DB611E;cursor:pointer"> &nbsp;
                                <label class="form-check-label">Yes</label>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-3 mt-4">
                        <div class="form-group">
                            <label for="">Payment Option</label>
                            <select class="form-control" name="BillPayOpt" id="">
                                <option value="1">Full</option>
                                <option value="2">Partial</option>
                                <option value="3">Exact</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

    </div>


    <div class="card">
        <div class="card-header">REVENUE SOURCE </div>
        <div class="card-body" id="billItems">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Select Revenue Source <span class="text-danger">*</span></label>
                        <select class="form-control" name="GfsCode[]" id="">
                            <option value="14210121">Receipts from Weighs & Measure Implements</option>
                            <option value="14220104">Receipt from Vehicle Tank Calibration</option>
                            <option value="14220208">Fines, Penalties and Forfeitures</option>
                            <option value="14220161">Miscellaneous Receipts</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="number" name="BillItemAmt[]" id="" oninput="calcTotal()" min="1" class="form-control itemAmount" placeholder="">
                        <!-- <small id="helpId" class="text-muted">Help text</small> -->
                    </div>
                </div>
                <div class="col-md-1">

                    <button type="button" class="btn btn-primary btn-sm" onclick="addRevenueSource()" style="margin-top: 2rem;"><i class="far fa-plus"></i></button>
                </div>
                <input type="text" name="BillItemRef[]" id="" value="<?= randomString() ?>" class="form-control" placeholder="" hidden>

            </div>






        </div>
        <div class="card-footer row">
            <div class="form-group col-md-6">
                <label for="">Total Billed Amount</label>
                <input type="text" name="BillEqvAmt" id="BillEqvAmt" class="form-control" placeholder="Total Billed Amount" readonly>
                <!-- <small id="helpId" class="text-muted">Help text</small> -->
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">PAYMENT METHODS</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="">Method</label><br>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" style="accent-color:#DB611E;transform:scale(1.2)" type="radio" name="method" id="" value="checkedValue"> Mobile Money Or Bank
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" style="accent-color:#DB611E;transform:scale(1.25)" type="radio" name="method" id="" value="checkedValue"> Electronic Fund Transfer
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Transfer To Bank</label>
                        <select class="form-control" name="" id="">
                            <option value="NMB">National Microfinance Bank</option>
                            <option value="CRDB">CRDB Bank</option>
                            <option value="BOT">Bank Of Tanzania (BOT)</option>
                        </select>
                    </div>
                </div>
            </div>


        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </div>
    </div>
    
    
</div>
</from>

<script>
    function pickCenter(center) {
        document.querySelector('#CollectionCenter').value = center
    }

    function calculateDate(days) {
        const date = new Date();

        date.setDate(date.getDate() + Number(days));
        const expiryDate = `${date.getDate()}-${date.toLocaleString('default', { month: 'long' })}-${date.getFullYear()}`

        document.querySelector('#expiryDate').value = expiryDate
    }

    function calculateItemAmount() {
        let total = 0
        const itemAmounts = document.querySelectorAll('.itemAmount')
        for (let amount of itemAmounts) {
            total += Number(amount.value)
        }
        document.querySelector('#BillEqvAmt').value = total

    }

    function calcTotal() {
        calculateItemAmount()
    }

    function addRevenueSource() {
        $('#billItems').append(`
         <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Select Revenue Source <span class="text-danger">*</span></label>
                        <select class="form-control" name="GfsCode[]" id="">
                            <option value="14210121">Receipts from Weighs & Measure Implements</option>
                            <option value="14220104">Receipt from Vehicle Tank Calibration</option>
                            <option value="14220208">Fines, Penalties and Forfeitures</option>
                            <option value="14220161">Miscellaneous Receipts</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="number" name="BillItemAmt[]" id="" oninput="calcTotal()" min="1" class="form-control itemAmount" placeholder="">
                        <!-- <small id="helpId" class="text-muted">Help text</small> -->
                    </div>
                </div>
                <div class="col-md-1">

                    <button type="button" class="btn btn-dark btn-sm" onclick="removeItem(this)" style="margin-top: 2rem;"><i class="far fa-minus"></i></button>
                </div>
                <input type="text" name="BillItemRef[]" id="" value="gsdksgmrkgriogjldkdfbdlfmbdlmfbkld" class="form-control" placeholder="" hidden>

            </div>
        
        `)


    }

    function removeItem(btn) {
        btn.parentNode.parentNode.remove()
        calculateItemAmount()
    }


    const billSubmissionRequest = document.querySelector('#billSubmissionRequest')


    billSubmissionRequest.addEventListener('submit', (e) => {
        e.preventDefault()




        const formData = new FormData(billSubmissionRequest)
        formData.append('csrf_hash', document.querySelector('.token').value)



        fetch('billSubmissionRequest', {
                method: 'POST',
                headers: {
                   ///'Content-Type': 'application/json;charset=utf-8',
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data)
                // const {
                //     status,
                //     token,
                //     res
                // } = data

                // if (data.status == 1) {


                // }



            });
    })



    function cancelPayment(controlNumber) {

        $('#cancelPayment').modal({
            open: true,
            backdrop: 'static'
        })
        const PaymentControlNumber = document.querySelector('#controlNumber')
        const description = document.querySelector('#description')
        PaymentControlNumber.value = controlNumber
        const cancelPaymentForm = document.querySelector('#cancelPaymentForm')
        cancelPaymentForm.addEventListener('submit', (e) => {
            e.preventDefault()
            console.log(controlNumber)
            if (PaymentControlNumber && description != '') {
                cancelPaymentForm.reset()
                $('#cancelPayment').modal('hide')
                swal({
                    title: 'Payment Canceled Successfully',
                    icon: "success",
                    timer: 5500
                });
            }
        })


    }

    function viewPayment(controlNumber, activity) {



        console.log(controlNumber)
        console.log(activity)

        const params = {
            controlNumber: controlNumber,
            activity
        }

        fetch('selectPayment', {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(params)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)

                if (data.status == 1) {

                    const Payment = data
                    $('#PaymentCustomer').html( /*html*/ `

                        

                    <tr>
                       <td>Receipt Number:</td>
                      <td><b>${Payment.receiptNumber}</b></td>
                      
                    <tr>
                     <tr>
                        <td>Received From:</td>
                        <td>${Payment.payer}</td>
                    </tr>
                    <tr>
                       <td>Amount</td>
                      <td><b>${Payment.PaymentTotal}</b></td>
                      
                    <tr>
                        <td>Amount In Words:</td>
                        <td>${Payment.PaymentTotalInWords}</td>
                    </tr>
                   
                    <tr>
                        <td>Outstanding Balance</td>
                        <td>${Payment.balance}</b></td>
                    </tr>
                    `)

                    let sn = 1
                    const items = Payment.products.map(item => `
                    <tr>
                     <td>${sn++}</td>
                     <td>${item.product}</td>
                     <td>${item.amount}</td>
                    </tr>

                    `)

                    $('#PaymentItems').html(items)
                    $('#PaymentTotal').html(Payment.PaymentTotal)
                    $('#PaymentTotalInWords').html(Payment.PaymentTotalInWords)
                    $('#preparedBy').html(Payment.createdBy)
                    $('#printedBy').html(Payment.printedBy)
                    $('#printedOn').html(Payment.printedOn)
                    $('#paymentDate').html(Payment.paymentDate)
                    $('#billReference').html(Payment.billReference)
                    $('#billedTotal').html(Payment.PaymentTotal)



                    const refs = document.querySelectorAll('.ref')
                    refs.forEach(r => r.textContent = Payment.controlNumber)

                    $('#printModal').modal({
                        open: true,
                        backdrop: 'static'
                    })
                }










            });








        // console.log(Payment)
        // $('#printModal').modal({
        //     open: true,
        //     backdrop: 'static'
        // })


    }
</script>
<?= $this->endSection(); ?>