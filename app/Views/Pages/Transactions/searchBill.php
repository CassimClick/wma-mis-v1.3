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
    <input type="text" class="form-control" name="document" id="document" value="<?= url_is('payments') ? 'receipt' : 'bill'; ?>" hidden>

    <?php if (url_is('billManagement')) : ?>

        <?= view('Components/bill') ?>
    <?php elseif ('payments') : ?>
        <?= view('Components/receipt') ?>
    <?php endif; ?>



    <!-- Modal -->
    <div class="modal modal-static fade" id="cancelBill" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bill Cancellation</h5>

                </div>
                <div class="modal-body">
                    <form id="cancelBillForm">
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
            <?php if (url_is('billManagement')) : ?>
                SEARCH BILL
            <?php else : ?>
                SEARCH RECEIPTS
            <?php endif; ?>
        </div>
        <div class="card-body">
            <form id="searchBillForm">
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
                                <?php if (url_is('billManagement')) : ?>
                                    <option value="Pending">Pending</option>
                                    <option value="Partial">Partial</option>
                                <?php else : ?>
                                    <option value="Paid">Paid</option>
                                <?php endif; ?>

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
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fal fa-search"></i> Search Bill</button>
                    </div>

                </div>
                </from>
        </div>

    </div>

    <div class="card" id="billBlock" style="display:none">
        <div class="card-body">
            <table class="table table-sm" id="billTable">
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
                <tbody id="billResults">


                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const searchBillForm = document.querySelector('#searchBillForm')

    searchBillForm.addEventListener('submit', (e) => {
        e.preventDefault()



        console.log('searching....')
        const formData = new FormData(searchBillForm)
        const billResults = document.querySelector('#billResults')



        fetch('searchBill', {
                method: 'POST',

                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.status == 1) {
                    const billBlock = document.querySelector('#billBlock')
                    const bill = data.billData.map(bill => {
                        return `
                <tr>
                    <td>${bill.name}</td>
                    <td>${bill.phoneNumber}</td>
                    <td>${bill.controlNumber}</td>
                    <td>${bill.total}</td>
                    <td>${bill.payment}</td>
                    <td>${bill.date}</td>
                    <td>
                        <button onclick="viewBill('${bill.controlNumber}','${data.activity}')" type="button" class="btn btn-primary btn-xs">
                            <i class="fal fa-eye"></i>
                        </button>
                        <button  onclick="cancelBill('${bill.controlNumber}')" type="button" class="btn btn-dark btn-xs">
                            <i class="fal fa-ban"></i>
                        </button>
                    </td>
                </tr>
                `
                    }).join('')


                    $(document).ready(function() {

                    })
                    billResults.innerHTML = ''
                    billResults.innerHTML = bill
                    billBlock.style.display = 'block'

                    // $('#billTable').DataTable({
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
                    billBlock.style.display = 'none'
                    swal({
                        title: 'No Data Found !',
                        icon: "warning",
                        timer: 2500
                    });
                }






            });
    })



    function cancelBill(controlNumber) {

        $('#cancelBill').modal({
            open: true,
            backdrop: 'static'
        })
        const billControlNumber = document.querySelector('#controlNumber')
        const description = document.querySelector('#description')
        billControlNumber.value = controlNumber
        const cancelBillForm = document.querySelector('#cancelBillForm')
        cancelBillForm.addEventListener('submit', (e) => {
            e.preventDefault()
            console.log(controlNumber)
            if (billControlNumber && description != '') {
                cancelBillForm.reset()
                $('#cancelBill').modal('hide')
                swal({
                    title: 'Bill Canceled Successfully',
                    icon: "success",
                    timer: 5500
                });
            }
        })


    }

    function viewBill(controlNumber, activity) {



        console.log(controlNumber)
        console.log(activity)

        const params = {
            document: document.querySelector('#document').value,
            controlNumber: controlNumber,
            activity
        }

        fetch('selectBill', {
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

                    const bill = data
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
                        <td>Received From:</td>
                        <td>${bill.payer}</td>
                    </tr>
                    <tr>
                        <td>Payer Phone:</td>
                        <td>${bill.phoneNumber}</b></td>
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
                    
                    if(bill.document == 'receipt'){
                        $('#printedOn').html(bill.printedOn)

                    }

                    const refs = document.querySelectorAll('.ref')
                    refs.forEach(r => r.textContent = bill.controlNumber)

                    $('#printModal').modal({
                        open: true,
                        backdrop: 'static'
                    })
                }










            });



    }
</script>
<?= $this->endSection(); ?>