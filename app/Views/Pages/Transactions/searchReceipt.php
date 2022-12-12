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
    <div class="card">

        <div class="card-header">

            SEARCH PAYMENT RECEIPTS
        </div>
        <div class="card-body">
            <form id="searchPaymentForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Activity</label>
                            <select class="form-control" name="activity" id="">
                                <option value="vtv">Vehicle Tank verification</option>
                                <option value="sbl">Sandy & Ballast Lorries </option>
                                <option value="waterMeters">Water Meters</option>
                                <option value="prepackage">Pre Package</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Payment Status</label>
                            <select class="form-control" name="payment" id="">

                                <option value="Paid">Paid</option>

                                <!-- <option value="All">All</option> -->

                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Search By Name</label>
                            <input type="text" name="name" id="" class="form-control" placeholder="Enter Name" aria-describedby="helpId">

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Search By Control Number</label>
                            <input type="text" name="controlNumber" id="" class="form-control control" placeholder="Enter Control Number" oninput="this.value=this.value.replace(/(?![0-9])./gmi,'')">

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Search By Phone Number</label>
                            <input type="text" name="phone" id="" class="form-control phone" placeholder="Enter Phone number" aria-describedby="helpId">

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Date</label>
                            <input type="date" name="date" id="" class="form-control phone" placeholder="Enter Phone number" aria-describedby="helpId">

                        </div>
                    </div>
                    <div class="col-md-3 mt-4">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fal fa-search"></i> Search Payment</button>
                    </div>

                </div>
                </from>
        </div>

    </div>

    <div class="card" id="PaymentBlock" style="display:none">
        <div class="card-body">
            <table class="table table-sm" id="PaymentTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Control Number</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="PaymentResults">


                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const searchPaymentForm = document.querySelector('#searchPaymentForm')

    searchPaymentForm.addEventListener('submit', (e) => {
        e.preventDefault()



        console.log('searching....')
        const formData = new FormData(searchPaymentForm)
        const PaymentResults = document.querySelector('#PaymentResults')



        fetch('searchPayment', {
                method: 'POST',

                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.status == 1) {
                    const PaymentBlock = document.querySelector('#PaymentBlock')
                    const Payment = data.PaymentData.map(Payment => {
                        return `
                <tr>
                    <td>${Payment.name}</td>
                    <td>${Payment.phoneNumber}</td>
                    <td>${Payment.controlNumber}</td>
                    <td>${Payment.total}</td>
                    <td>${Payment.payment}</td>
                    <td>${Payment.date}</td>
                    <td>
                        <button onclick="viewPayment('${Payment.controlNumber}','${data.activity}')" type="button" class="btn btn-primary btn-xs">
                            <i class="fal fa-eye"></i>
                        </button>
                       
                    </td>
                </tr>
                `
                    }).join('')


                    $(document).ready(function() {

                    })
                    PaymentResults.innerHTML = ''
                    PaymentResults.innerHTML = Payment
                    PaymentBlock.style.display = 'block'

                    // $('#PaymentTable').DataTable({
                    //     "retrieve": true,
                    //     // "cache": false,
                    //     // "destroy": true,
                    //     "responsive": true,
                    //     "autoWidth": false,
                    //     "paging": true,
                    //     "lengthChange": true,
                    //     "searching": true,
                    //     "ordering": true,
                    //     "info": true,
                    // });




                } else {
                    PaymentBlock.style.display = 'none'
                    swal({
                        title: 'No Data Found !',
                        icon: "warning",
                        timer: 2500
                    });
                }






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