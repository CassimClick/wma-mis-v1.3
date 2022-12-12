<?= $this->extend('layouts/coreLayout'); ?>
<?= $this->section('content'); ?>
<?php
$pageSession = \CodeIgniter\Config\Services::session();
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark"><?= $page['heading'] ?></h4>
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
            <?= csrf_field() ?>
            <div class="row">




                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6 flex">
                                    <button type="button" class="btn btn-primary btn-sm" id="addVtcButton"><i class="far fa-plus"></i> Add Vehicle</button>
                                    <button type="button" class="btn btn-success btn-sm" onclick="syncVehicles()"><i class="far fa-list"></i>
                                        List Vehicles</button>

                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input class="form-control" type="text" placeholder="Search by plate number" id="licensePlate" oninput="this.value = this.value.toUpperCase().replaceAll(/\s/g,'')">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary btn-sm" id="plateSearch"><i class="far fa-search"></i>
                                                Search</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->



                        <!-- Modal -->
                        <div class="modal fade" id="addChart" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Calibration Chart</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="calibrationForm">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label for="">Select Compartment</label>
                                                            <select class="form-control" name="compNumber" id="compNumber">

                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Tank Top</label>
                                                        <input type="text" name="tankTop" min="0" id="tankTop" class="form-control" placeholder="Tank Top">

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Stamp Number</label>
                                                        <input type="text" name="stampNumber" min="0" id="stampNumber" class="form-control" placeholder="Stamp Number">

                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Litre</th>
                                                        <th>mm</th>
                                                        <th style="text-align:right;padding-right:1.4rem">
                                                            <button type="button" class="btn btn-primary btn-sm" onclick="addRow()">
                                                                <i class="far fa-plus"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="dataRows">



                                                </tbody>

                                            </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group" id="noCompartments">


                            </div>
                            <div id="vehicleDetails"></div>

                            <ul class="list-group" id="customerVehicles">


                            </ul>

                            <?= $this->include('Components/vtc/vtcTechnicalDetails'); ?>
                        </div>
                        <!-- /.card-body -->

                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>

            </div>
            </form>
        </div>



        <!-- /.card -->


    </div>
    <!-- /.card -->

    </div>
    </div>

    <script>
        //adding a row
        function addRow() {
            $('#dataRows').append(`
             <tr>
                 <td>
                     <input type="number" name="litres[]" min="0" id="litre" class="form-control litre" ">
                 </td>
                 <td>
                     <input type="number" name="millimeters[]" min="0" id="mm" class="form-control mm">
                 </td>
                 <td>
                
                     <button type="button" class="btn btn-primary btn-sm" onclick="removeRow(this)">
                         <i class="far fa-minus"></i>
                     </button>
                 </td>
            </tr>
            `)
            dataRows

        }

        //calc total litters
        function calculateTotalLitres() {

            let total = 0

            const litres = document.querySelectorAll('.litre')

            for (liter of litres) {
                total += Number(liter.value)
            }

        }




        //remove row from the dom
        function removeRow(row) {
            row.parentElement.parentElement.remove();
            calculateTotalLitres()

        }

        const calibrationForm = document.querySelector('#calibrationForm')
        calibrationForm.addEventListener('submit', (e) => {
            e.preventDefault()
            const formData = new FormData(calibrationForm)
            formData.append('csrf_hash', document.querySelector('.token').value)
            formData.append('vehicleId', document.querySelector('#vehicleId').value)
            formData.append('totalCompartments', document.querySelector('#totalCompartments').value)
            fetch('createChart', {
                    method: 'POST',
                    headers: {
                        // 'Content-Type': 'application/json;charset=utf-8',
                        "X-Requested-With": "XMLHttpRequest"
                    },

                    body: formData,

                }).then(response => response.json())
                .then(data => {
                    const {
                        token,
                        chart,
                        compartmentsMenu,
                        status,
                        msg
                    } = data
                    document.querySelector('.token').value = token

                    if (status == 1) {

                        // document.querySelector('#dataRows').remove()
                        document.querySelector('#dataRows').innerHTML = ''

                        document.querySelector('#compNumber').innerHTML = compartmentsMenu
                        processChartDetails(chart)
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




                    // console.log(data)
                })
        })



        function processChartDetails(chart) {
            const chartResults = document.querySelector('#chartResults')
            if (chart != '') {
                chartResults.style.display = 'block'

                const chartDownload = document.querySelector('#chartDownload')
                if (chart.complete) {
                    $('#addChart').modal('hide')
                    chartDownload.setAttribute('href', chart.link)

                } else {
                    chartDownload.removeAttribute('href', chart.link)
                }

                document.querySelector('#upperChart').innerHTML = chart.upperChart
                document.querySelector('#lowerChart').innerHTML = chart.lowerChart
                document.querySelector('#fillOrder').textContent = chart.fillOrder
                document.querySelector('#emptyOrder').textContent = chart.emptyOrder

                document.querySelector('#plateNumber').textContent = chart.plateNumber
                document.querySelector('#customer').textContent = chart.customer
                document.querySelector('#chartNumber').textContent = chart.chartNumber
                document.querySelector('#nextVerification').textContent = chart.nextVerification
            } else {
                chartResults.style.display = 'none'
            }

        }

        function calculateTotalAmount() {
            const vehicleAmount = document.querySelectorAll('.vehicleAmount')
            let total = 0
            for (amount of vehicleAmount) {
                total += Number(amount.value)
            }
            document.querySelector('#totalAmount').value = total

        }

        function removeItem(button) {
            const parent = button.parentNode.parentNode
            parent.remove()
            calculateTotalAmount()
        }

        window.addEventListener('afterprint', (event) => {
            location.reload
        });
    </script>

</section>

<?= $this->endSection(); ?>