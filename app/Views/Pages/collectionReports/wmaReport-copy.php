<?= $this->extend('layouts/corelayout'); ?>
<?= $this->section('content'); ?>
<script>
    // const fetchReportParams = (id) => {
    //     const logDownload = document.querySelector('#downloadReport')
    //     
    // }
</script>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark"><?= $page['heading'] ?></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/Dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?= $page['heading'] ?></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">

        <?= csrf_field() ?>

        <div class="card">
            <div class="card-header">
                <form id="reportForm">
                    <div class="row">
                        <div class=" <?= ($role == 3 || $role == 7) ? 'col-md-4' : 'col-md-3' ?>">
                            <div class="form-group">
                                <label for="my-select">Activity</label>
                                <select id="activities" class="form-control" name="">
                                    <option value="All">All Activities</option>
                                    <option value="vtc">Vehicle Tank Calibration</option>
                                    <option value="sbl">Sandy & Ballast Lorries</option>
                                    <option value="water">Water Meters</option>
                                    <option value="prePackage">Pre Package</option>
                                </select>
                            </div>
                        </div>



                        <div class=" <?= ($role == 3 || $role == 7) ? 'col-md-4' : 'col-md-3' ?> ">
                            <div class="form-group">
                                <label for="">Task </label>
                                <select class="form-control" name="task" id="task">
                                    <option selected disabled value="All">--Select Task--</option>
                                    <option value="Verification">Verification</option>
                                    <option value="Reverification">Reverification</option>
                                    <option value="Inspection">Inspection</option>
                                    <option value="All">All</option>
                                </select>
                            </div>
                        </div>
                        <div class=" <?= ($role == 3 || $role == 7) ? 'col-md-4' : 'col-md-3' ?> ">
                            <div class="form-group">
                                <label for="">Payment</label>
                                <select class="form-control" name="payment" id="payment">
                                    <option selected disabled value="All">--Select Payment--</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Pending">Pending</option>
                                    <option value="All">All</option>
                                </select>
                            </div>
                        </div>
                        <?php if ($role == 3 || $role == 7) : ?>
                            <div class="col-md-6 col-sm-12">
                                <label for="enableRegion"><input class="check" style="transform:scale(1.3); margin-right:5px" type="checkbox" id="enableRegion">Region</label>
                                <select id="region" class="form-control select2bs4" disabled style="width:100% !important;">
                                    <?php foreach (renderRegions() as $region) : ?>
                                        <option value="<?= $region['region'] ?>"><?= $region['region'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>

                        <?php endif; ?>
                        <div class=" <?= ($role == 3 || $role == 7) ? 'col-md-6' : 'col-md-3' ?> ">
                            <div class="form-group">
                                <label for="my-select">Year</label>
                                <select id="year" class="form-control" name="">
                                    <!-- <option value="<?= date('Y') ?>"><?= date('Y') ?></option> -->
                                    <?php for ($i = date('Y'); $i >= 2015; $i--) : ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2  col-xs-12">
                            <div class="form-group">
                                <label for="my-select"><input class="check" style="transform:scale(1.3); margin-right:5px" type="checkbox" name="" id="enableQuarter">Quarter/Annual</label>
                                <select id="quarter" class="form-control" disabled>
                                    <option value="Q1">Quarter One</option>
                                    <option value="Q2">Quarter Two</option>
                                    <option value="Q3">Quarter Three</option>
                                    <option value="Q4">Quarter Four</option>
                                    <option value="Annually">Annually</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2  col-xs-12">
                            <div class="form-group">
                                <label for="my-select"><input class="check" style="transform:scale(1.3); margin-right:5px" type="checkbox" name="" id="enableMonth">Month</label>
                                <select id="month" class="form-control" disabled>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4  col-xs-12">
                            <div class="form-group">
                                <label for="my-input"> <input class="check" style="transform:scale(1.3); margin-right:5px" type="checkbox" name="" id="enableDateFilter">Custom Date</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="dateFrom" class="form-control" type="date" name="" disabled>

                                    </div>
                                    <div class="col-md-6">
                                        <input id="dateTo" class="form-control" type="date" name="" disabled>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">

                            <label for=""><span style="color:transparent">search</span></label>
                            <input class="btn btn-primary  col-sm-12" type="submit" value="Generate">
                        </div>




                    </div>
            </div>

            </form>
        </div>
        <div class="card">
            <div class="card-header">

                <h6 class="text-center" style="font-weight: bold;" id="reportTitle"></h6>

            </div>


            <div class="card-body">

                <table class="table table-sm" id="reportContainer">

                </table>
                <br>
                <div id="summary"></div>

            </div>
            <div class="card-footer">
                <a id="downloadReport" target="_blank" class="btn btn-success btn-sm"><i class="far fa-download" aria-none="true"></i>Download</a>
            </div>
        </div>
        <input type="text" value="<?= $userLocation ?>" id="userLocation" hidden>
    </div>


    <script>
        function formatNumber(number) {
            return new Intl.NumberFormat().format(number)
        }
        const reportForm = document.querySelector('#reportForm')


        const enableRegion = document.querySelector('#enableRegion')
        const enableMonth = document.querySelector('#enableMonth')
        const enableQuarter = document.querySelector('#enableQuarter')
        const enableDateFilter = document.querySelector('#enableDateFilter')

        const dateFrom = document.querySelector('#dateFrom')
        const dateTo = document.querySelector('#dateTo')
        const region = document.querySelector('#region')



        //=================##################=====================


        const enableInput = (checkBox, input, inputTwo = '') => {
            checkBox.addEventListener('click', (e) => {
                if (e.target.checked == true) {
                    if (input.hasAttribute('disabled')) {
                        input.removeAttribute('disabled')
                        inputTwo.removeAttribute('disabled')
                    }
                } else {
                    input.setAttribute('disabled', 'disabled')
                    inputTwo.setAttribute('disabled', 'disabled')
                    input.value = null
                    inputTwo.value = null
                }
            })
        }
        enableInput(enableMonth, month)
        enableInput(enableQuarter, quarter)
        enableInput(enableDateFilter, dateFrom, dateTo)

        <?php if ($role == 3 || $role == 7) : ?>
            enableInput(enableRegion, region)
        <?php endif; ?>
        //=================################====================
        reportForm.addEventListener('submit', (e) => {
            e.preventDefault()

            const year = document.querySelector('#year').value
            const quarter = document.querySelector('#quarter')
            const month = document.querySelector('#month')
            const activity = document.querySelector('#activities').value
            const task = document.querySelector('#task').value
            const payment = document.querySelector('#payment').value

            function warningPopup() {
                return swal({
                    title: 'Please Choose One  Category',
                    icon: "warning",
                    timer: 4500
                });
            }

            if (!month.hasAttribute('disabled') && !quarter.hasAttribute('disabled') && !dateFrom.hasAttribute(
                    'disabled') && !dateTo.hasAttribute('disabled')) {

                warningPopup()
                return false
            } else if (!month.hasAttribute('disabled') && !quarter.hasAttribute('disabled')) {
                warningPopup()
            } else if (!month.hasAttribute('disabled') && !dateFrom.hasAttribute('disabled') && !dateTo
                .hasAttribute('disabled')) {
                warningPopup()
            } else if (!quarter.hasAttribute('disabled') && !dateFrom.hasAttribute('disabled') && !dateTo
                .hasAttribute('disabled')) {
                warningPopup()
            } else {


                if (!quarter.hasAttribute('disabled')) {


                    switch (quarter.value) {
                        case 'Q1':
                            getDataForQuarter(7, 9, year, activity, task, payment)
                            break;
                        case 'Q2':
                            getDataForQuarter(10, 12, year, activity, task, payment)
                            break;
                        case 'Q3':
                            getDataForQuarter(1, 3, year, activity, task, payment)
                            break;
                        case 'Q4':
                            getDataForQuarter(4, 6, year, activity, task, payment)
                            break;
                        case 'Annually':
                            getDataForQuarter(1, 12, year, activity, task, payment)
                            break;
                    }

                }

                //=====================================
                if (!month.hasAttribute('disabled')) {


                    switch (month.value) {
                        case '1':
                            getDataForMonth(month.value, year, activity, task, payment)
                            break;
                        case '2':
                            getDataForMonth(month.value, year, activity, task, payment)
                            break;
                        case '3':
                            getDataForMonth(month.value, year, activity, task, payment)
                            break;
                        case '4':
                            getDataForMonth(month.value, year, activity, task, payment)
                            break;
                        case '5':
                            getDataForMonth(month.value, year, activity, task, payment)
                            break;
                        case '6':
                            getDataForMonth(month.value, year, activity, task, payment)
                            break;
                        case '7':
                            getDataForMonth(month.value, year, activity, task, payment)
                            break;
                        case '8':
                            getDataForMonth(month.value, year, activity, task, payment)
                            break;
                        case '9':
                            getDataForMonth(month.value, year, activity, task, payment)
                            break;
                        case '10':
                            getDataForMonth(month.value, year, activity, task, payment)
                            break;
                        case '11':
                            getDataForMonth(month.value, year, activity, task, payment)
                            break;
                        case '12':
                            getDataForMonth(month.value, year, activity, task, payment)
                            break;
                        default:
                    }

                } else {

                }
                //=====================================


                if (!dateFrom.hasAttribute('disabled') && !dateFrom.hasAttribute('disabled') && quarter
                    .hasAttribute('disabled')) {

                    getDataFromDateRange(dateFrom.value, dateTo.value, activity, task, payment)
                }


            }



        })

        //=================check if user wants to use a region filter====================

        <?php if ($role == 3 || $role == 7) : ?>

            function checkRegionValue() {
                if (region.hasAttribute('disabled')) {
                    return 'Tanzania'
                } else {
                    return region.value
                }
            }
        <?php endif; ?>





        function getDataForQuarter(monthFrom, monthTo, year, activity, task, payment) {


            if (!dateFrom.hasAttribute('disabled') && !dateTo.hasAttribute('disabled')) {



                //  =================################====================

                const params = {
                    monthFrom: monthFrom,
                    monthTo: monthTo,
                    dateFrom: dateFrom.value,
                    dateTo: dateTo.value,
                    year: year,
                    activity: activity,
                    task: task,
                    payment: payment
                }
                const url = "getQuarterReportWithDateRange"
                //=================function call to render a report ====================
                renderReport(params, url)


            } else {

                <?php if ($role == 3 || $role == 7) : ?>
                    const params = {
                        monthFrom: monthFrom,
                        monthTo: monthTo,
                        dateFrom: dateFrom.value,
                        dateTo: dateTo.value,
                        year: year,
                        activity: activity,
                        task: task,
                        payment: payment,
                        region: checkRegionValue()

                    }
                <?php else : ?>
                    const params = {
                        monthFrom: monthFrom,
                        monthTo: monthTo,
                        dateFrom: dateFrom.value,
                        dateTo: dateTo.value,
                        year: year,
                        activity: activity,
                        task: task,
                        payment: payment,
                        // region: checkRegionValue()

                    }
                <?php endif; ?>

                const url = "getQuarterReport"

                //console.log(params)
                //=================function call to render a report ====================
                renderReport(params, url)

                const reportDownload = document.querySelector('#downloadReport')

            }

            // console.log('selected from ' + from + ' To ' + to + ' - ' + year)
        }

        function getDataForMonth(month, year, activity, task, payment) {


            <?php if ($role == 3 || $role == 7) : ?>
                const params = {

                    month: month,
                    year: year,
                    activity: activity,
                    task: task,
                    payment: payment,
                    region: checkRegionValue(),

                }
            <?php else : ?>
                const params = {

                    month: month,
                    year: year,
                    activity: activity,
                    task: task,
                    payment: payment,


                }
            <?php endif; ?>
            const url = "getMonthlyReport"
            //=================function call to render a report ====================
            renderReport(params, url)
            const reportDownload = document.querySelector('#downloadReport')



        }

        //=================render report based on custom date range====================
        function getDataFromDateRange(dateFrom, dateTo, activity, task, payment) {


            <?php if ($role == 3 || $role == 7) : ?>
                const params = {

                    dateFrom: dateFrom,
                    dateTo: dateTo,
                    activity: activity,
                    task: task,
                    payment: payment,
                    region: checkRegionValue(),

                }
            <?php else : ?>
                const params = {

                    dateFrom: dateFrom,
                    dateTo: dateTo,
                    activity: activity,
                    task: task,
                    payment: payment,
                    // region: checkRegionValue(),

                }
            <?php endif; ?>


            const url = "customDateReport"
            //=================function call to render a report ====================
            renderReport(params, url)


        }


        //=================render a report based on parameters====================

        function renderReport(reportParams, urlEndpoint) {
            function stringToInteger(str) {
                const toInt = str.replaceAll(',', '')
                return parseInt(toInt)
            }
            // reportParams.csrf_hash = document.querySelector('.token').value
            $.ajax({
                type: "POST",
                url: urlEndpoint,
                data: reportParams,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    // console.log(response.data.title);
                    // document.querySelector('.token').value = response.data.token
                    const reportDownload = document.querySelector('#downloadReport')
                    reportDownload.setAttribute('href', response.url)
                    document.querySelector('#reportTitle').textContent = response.title
                    $('#reportContainer').html('')
                    $('#summary').html('')
                    if (response.data.category == 'all') {
                        $('#statusCheck').css('display', 'none')
                        console.log(response)
                        const totalVtc = stringToInteger(response.data.vtc.totalVtc)
                        const totalSbl = stringToInteger(response.data.sbl.totalSbl)
                        const totalWaterMeter = stringToInteger(response.data.waterMeter.totalWaterMeter)
                        const totalPrePackage = (response.data.prePackage.totalPrePackage)

                        const vtcPaid = stringToInteger(response.data.vtc.paidVtc)
                        const sblPaid = stringToInteger(response.data.sbl.paidSbl)
                        const waterMeterPaid = stringToInteger(response.data.waterMeter.paidWaterMeter)
                        const prePackagePaid = (response.data.prePackage.paidPrePackage)

                        const vtcPending = stringToInteger(response.data.vtc.pendingVtc)
                        const sblPending = stringToInteger(response.data.sbl.pendingSbl)
                        const waterMeterPending = stringToInteger(response.data.waterMeter.pendingWaterMeter)
                        const prePackagePending = (response.data.prePackage.pendingPrePackage)



                        const totalAmount = totalVtc + totalSbl + totalWaterMeter + totalPrePackage
                        const totalPaid = vtcPaid + sblPaid + waterMeterPaid + prePackagePaid
                        const totalPending = vtcPending + sblPending + waterMeterPending + prePackagePending


                        //<h5 class="text-center">${response.data.title.toUpperCase()}</h5>
                        $('#reportContainer').append(
                            `
                        <thead class="thead-light">
                            <tr>
                                <th>Activity</th>
                                <th>Total Amount</th>
                                <th>Paid</th>
                                <th>Pending</th>
                                <th>Total Items</th>
                                <th>Items Paid</th>
                                <th>Items Pending</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr class="theRow">
                                <td>Vehicle Tank Calibration</td>
                                <td>Tsh ${response.data.vtc.totalVtc}</td>
                                <td>Tsh ${response.data.vtc.paidVtc}</td>
                                <td>Tsh ${response.data.vtc.pendingVtc}</td>
                                <td>${response.data.vtc.vtcQuantity} Vehicle(s)</td>
                                <td>${response.data.vtc.vtcPaidQuantity} Vehicle(s)</td>
                                <td>${response.data.vtc.vtcPendingQuantity} Vehicle(s)</td>
                            </tr>
                            <tr>
                                <td>Sandy And Ballast Lorries</td>
                                <td>Tsh ${response.data.sbl.totalSbl}</td>
                                <td>Tsh ${response.data.sbl.paidSbl}</td>
                                <td>Tsh ${response.data.sbl.pendingSbl}</td>
                                <td>${response.data.sbl.sblQuantity} Vehicle(s)</td>
                                <td>${response.data.sbl.sblPaidQuantity} Vehicle(s)</td>
                                <td>${response.data.sbl.sblPendingQuantity} Vehicle(s)</td>
                            </tr>
                            <tr>
                                <td>Water Meters</td>
                                <td>Tsh ${response.data.waterMeter.totalWaterMeter}</td>
                                <td>Tsh ${response.data.waterMeter.paidWaterMeter}</td>
                                <td>Tsh ${response.data.waterMeter.pendingWaterMeter}</td>
                                <td>${response.data.waterMeter.waterMeterQuantity} Meter(s)</td>
                                <td>${response.data.waterMeter.waterMeterPaidQuantity} Meter(s)</td>
                                <td>${response.data.waterMeter.waterMeterPendingQuantity} Meter(s)</td>
                            </tr>
                            <tr>
                                <td>Pre Package</td>
                                <td>Tsh ${formatNumber(response.data.prePackage.totalPrePackage)}</td>
                                <td>Tsh ${formatNumber(response.data.prePackage.paidPrePackage)}</td>
                                <td>Tsh ${formatNumber(response.data.prePackage.pendingPrePackage)}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>



                        </tfoot>
                        <br>


                            `
                        )

                        $('#summary').append(`

                        <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                        <h5 class="txt-center"><b>Collection Summary</b></h5>
                         <table class="table table-sm">
                         <tr class="paidAmount">
                         <td><b>Paid Amount</b></td>
                         <td>Tsh ${formatNumber(totalPaid)}</td>
                         </tr>
                         <tr class="pendingAmount">
                         <td><b>Pending Amount</b></td>
                         <td>Tsh ${formatNumber(totalPending)}</td>
                         </tr>
                         <tr class="totalAmount">
                         <td><b>Total Amount</b></td>
                         <td>Tsh ${formatNumber(totalAmount)}</td>
                         </tr>
                         </table>
                        </div>
                        </div>
                        `)
                    }
                    //=================rendering vtc data====================
                    else if (response.data.category == 'vtcOnly') {
                        $('#statusCheck').css('display', 'block')

                        console.log(response)

                        let vtcRow = ''
                        for (let vtc of response.data.vtcDetails) {
                            vtcRow += `
                            <tr class="theRow">
                                <td>${vtc.name}  </td>
                                <td>${vtc.phone_number}</td>
                                <td>${vtc.vehicle_brand}</td>
                                <td>${vtc.plate_number}</td>
                                <td>${vtc.capacity} Liters</td>
                                <td>${formatNumber(vtc.vehicle_amount)}</td>
                                <td>${vtc.control_number}</td>
                                <td class="status">${vtc.payment}</td>
                                <?php if ($role == 2 || $role == 3 || $role == 7) : ?>
                                    <td>${vtc.fName}  ${vtc.lName}</td>
                                <?php endif; ?>
                            </tr>
                            `

                        }

                        let fullTable = `
                        <thead class="thead-light">
                            <tr>
                                <th>Owner's Name</th>
                                <th>Phone Number</th>
                                <th>Vehicle Brand</th>
                                <th>Plate Number</th>
                                <th>Capacity</th>
                                <th>Amount</th>
                                <th>Control Number</th>
                                <th>Payment Status</th>
                                <?php if ($role == 2 || $role == 3 || $role == 7) : ?>
                                    <th>Officer</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                        ${vtcRow}

                        </tbody>
                        <tfoot>
                        </tfoot>`

                        $('#summary').append(`

                        <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                        <h5 class="txt-center"><b>Collection Summary</b></h5>
                         <table class="table table-sm">
                         <tr class="paidAmount">
                         <td><b>Paid Amount</b></td>
                         <td>Tsh ${response.data.paidVtc}</td>
                         <td> ${response.data.vtcPaidQuantity} Vehicle(s)</td>
                         </tr>
                         <tr class="pendingAmount">
                         <td><b>Pending Amount</b></td>
                         <td>Tsh ${response.data.pendingVtc}</td>
                         <td>${response.data.vtcPendingQuantity} Vehicle(s)</td>
                         </tr>
                         <tr class="totalAmount">
                         <td><b>Total Amount</b></td>
                         <td>Tsh ${response.data.totalVtc}</td>
                         <td> ${response.data.vtcQuantity} Vehicle(s)</td>
                         </tr>
                         </table>
                        </div>
                        </div>
                        `)



                        $('#reportContainer').append(fullTable)
                        // function renderOnlyPaid() {
                        // }
                    } else if (response.data.category == 'sblOnly') {

                        console.log(response)
                        $('#statusCheck').css('display', 'block')

                        let sblRow = ''
                        for (let sbl of response.data.sblDetails) {
                            sblRow += `
                            <tr class="theRow">
                               <td>${sbl.name}  </td>
                                <td>${sbl.phone_number}</td>
                                <td>${sbl.vehicle_brand}</td>
                                <td>${sbl.plate_number}</td>
                                <td>${sbl.capacity} m <sup>3</sup></td>
                                <td>${formatNumber(sbl.vehicle_amount)}</td>
                                <td>${sbl.control_number}</td>
                                <td class="status">${sbl.payment}</td>
                                <?php if ($role == 2 || $role == 3 || $role == 7) : ?>
                                    <td>${sbl.fName}  ${sbl.lName}</td>
                                <?php endif; ?>

                            </tr>
                            `

                        }



                        let fullTable = `
                        <thead class="thead-light">
                        <tr>
                                <th>Owner's Name</th>
                                <th>Phone Number</th>
                                <th>Vehicle Brand</th>
                                <th>Plate Number</th>
                                <th>Capacity</th>
                                <th>Amount</th>
                                <th>Control Number</th>
                                <th>Payment Status</th>
                                <?php if ($role == 2 || $role == 3 || $role == 7) : ?>
                                <th>Officer</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                        ${sblRow}

                        </tbody>
                        <tfoot>
                        </tfoot>`

                        $('#summary').append(`

                        <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                        <h5 class="txt-center"><b>Collection Summary</b></h5>
                         <table class="table table-sm">
                         <tr class="paidAmount">
                         <td><b>Paid Amount</b></td>
                         <td>Tsh ${response.data.paidSbl}</td>
                         <td> ${response.data.sblPaidQuantity} Vehicle(s)</td>
                         </tr>
                         <tr class="pendingAmount">
                         <td><b>Pending Amount</b></td>
                         <td>Tsh ${response.data.pendingSbl}</td>
                         <td>${response.data.sblPendingQuantity} Vehicle(s)</td>
                         </tr>
                         <tr class="totalAmount">
                         <td><b>Total Amount</b></td>
                         <td>Tsh ${response.data.totalSbl}</td>
                         <td> ${response.data.sblQuantity} Vehicle(s)</td>
                         </tr>
                         </table>
                        </div>
                        </div>
                        `)



                        $('#reportContainer').append(fullTable)
                        // function renderOnlyPaid() {
                        // }
                    } else if (response.data.category == 'waterMeterOnly') {
                        $('#statusCheck').css('display', 'none')
                        $('#statusCheck').css('display', 'block')
                        console.log(response)

                        let waterMeterRow = ''
                        for (let waterMeter of response.data.waterMeterDetails) {
                            waterMeterRow += `
                            <tr class="theRow">
                                <td>${waterMeter.name} </td>
                                <td>${waterMeter.phone_number}</td>
                                <td>${waterMeter.brand}</td>
                                <td>${waterMeter.meter_size} mm</td>
                                <td>${waterMeter.flow_rate} m<sup>3</sup>/h </td>
                                <td>${waterMeter.class} </td>
                                <td>${waterMeter.quantity} </td>
                                <td>${formatNumber(waterMeter.amount)}</td>
                                <td>${waterMeter.control_number}</td>
                                <td class="status">${waterMeter.payment}</td>
                                <?php if ($role == 2 || $role == 3 || $role == 7) : ?>
                                    <td>${waterMeter.fName}  ${waterMeter.lName}</td>
                                <?php endif; ?>
                            </tr>
                            `

                        }

                        let fullTable = `
                        <thead class="thead-light">
                            <tr>
                                <th>Customer</th>
                                <th>Phone Number</th>
                                <th>Meter Brand</th>
                                <th>Meter Size</th>
                                <th>flow Rate</th>
                                <th>Class</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Control Number</th>
                                <th>Payment Status</th>
                                <?php if ($role == 2 || $role == 3 || $role == 7) : ?>
                                    <th>Officer</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                        ${waterMeterRow}

                        </tbody>
                        <tfoot>
                        </tfoot>`

                        $('#summary').append(`

                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                        <h5 class="txt-center"><b>Collection Summary</b></h5>
                         <table class="table table-sm">
                         <tr class="paidAmount">
                         <td><b>Paid Amount</b></td>
                         <td>Tsh ${response.data.paidWaterMeter}</td>
                         <td> ${response.data.waterMeterPaidQuantity} Meter(s)</td>
                         </tr>
                         <tr class="pendingAmount">
                         <td><b>Pending Amount</b></td>
                         <td>Tsh ${response.data.pendingWaterMeter}</td>
                         <td>${response.data.waterMeterPendingQuantity} Meter(s)</td>
                         </tr>
                         <tr class="totalAmount">
                         <td><b>Total Amount</b></td>
                         <td>Tsh ${response.data.totalWaterMeter}</td>
                         <td> ${response.data.waterMeterQuantity} Meter(s)</td>
                         </tr>
                         </table>
                        </div>
                        </div>
                        `)



                        $('#reportContainer').append(fullTable)
                        // function renderOnlyPaid() {
                        // }
                    } else if (response.data.category == 'prePackageOnly') {
                        function renderProducts(product) {


                            let tr = ` `
                            product.forEach(product => {

                                // console.log(product.commodity);
                                tr += `
                              <tr>
                                <td data-payment="${product.payment}">${product.commodity}</td>
                              </tr>
                             `
                            })

                            return tr
                        }

                        function renderProductStatus(product) {
                            let tr = ` `
                            product.forEach(product => {


                                tr += `
                              <tr>
                                <td data-payment="${product.payment}" style="border-left:0; style="border-right:0;">${product.status}</td>
                              </tr>
                             `
                            })

                            return tr
                        }

                        function renderOfficerName(product) {
                            let tr = ` `
                            namesArray = product.map(officer => {
                                return officer.officer
                            })
                            let uniqueName = [...new Set(namesArray)]

                            uniqueName.forEach(name => {



                                tr += `
                              <tr>
                                <td >${name}</td>
                              </tr>
                             `
                            })
                            // product.forEach(product => {


                            //     tr += `
                            //   <tr>
                            //     <td style="border-left:0; style="border-right:0;">${product.officer}</td>
                            //   </tr>
                            //  `
                            // })

                            return tr
                        }

                        function renderControlNumber(product) {
                            let tr = ` `
                            let cArr = []

                            product.forEach(p => {
                                cArr.push(p.controlNumber)
                            })

                            let dataset = cArr.reduce((a, c) => {
                                    if (a.has(c)) a.set(c, a.get(c) + 1);
                                    else a.set(c, 1);
                                    return a;
                                }, new Map())
                                .forEach((value, key, map) => {

                                    tr += `
                                      <tr >
                                        <td rowspan="" >${key}</td>
                                      </tr>
                                      `
                                    console.log(key);
                                    console.log(value);
                                    //   keys.push(key);
                                    //   values.push(value);
                                });


                            // let unique = [...new Set(cArr)]
                            // let tr = ` `
                            // unique.forEach(controlNumber1 => {



                            //     tr += `
                            //   <tr>
                            //     <td>${controlNumber1}</td>
                            //   </tr>
                            //  `
                            // })

                            return tr
                        }

                        function renderProductFee(product) {
                            let tr = ` `
                            product.forEach(product => {


                                tr += `
                              <tr>
                                <td data-payment="${product.payment}">Tsh ${formatNumber(product.amount)}</td>
                              </tr>
                             `
                            })

                            return tr
                        }

                        function renderPaymentStatus(product) {
                            let tr = ` `
                            product.forEach(product => {


                                tr += `
                              <tr class="pay">
                                <td >${product.payment}</td>
                              </tr>
                             `
                            })

                            return tr
                        }

                        function renderBatch(product) {


                            let tr = ` `
                            product.forEach(product => {


                                tr += `
                              <tr>
                                <td >${product.batchNumber}</td>
                              </tr>
                             `
                            })


                            return tr
                        }

                        let table = `
        <table cellspacing="0" class=" table table-bordered table-sm" border="" style="width: 100%; margin:0;padding:0;">
              
                 <thead class="thead-light">
                    <tr>
                        <th>Date</th>
                        <th>Name Of Client</th>
                        <th>Region</th>
                        <th>Location</th>
                        <th>Product</th>
                        <th>Batch Number</th>
                        <th>Results</th>
                        <th>Fees</th>
                        <th>Control Number</th>
                        <?php if ($role == 2 || $role == 3 || $role == 7) : ?>
                            <th>Officer</th>
                        <?php endif; ?>
                        <th>Payment Status</th>
                        <th>Measures Taken</th>
                    </tr>
                </thead>
                <tbody>
        `;


                        response.data.prePackage.forEach(data => {

                            // console.log(data);


                            table += `
                        <tr>
                            
                            <td style="margin:0;padding:0;">${data.date}</td>
                            <td style="margin:0;padding:0;">${data.customer}</td>
                            <td style="margin:0;padding:0;">${data.region}</td>
                            <td style="margin:0;padding:0;">${data.location}</td>
                            <td style="margin:0;padding:0;">

                                <table cellspacing="0" border="0" style="width: 100%;">
                                   ${renderProducts(data.productData)}
                                </table>

                            </td>
                            <td style="margin:0;padding:0;">

                                <table cellspacing="0" border="0" style="width: 100%;">
                                   ${renderBatch(data.productData)}
                                </table>

                            </td>
                       
                           <td style="margin:0;padding:0;">

                                <table cellspacing="0" border="0" style="width: 100%;">
                                    ${renderProductStatus(data.productData)}

                                </table>

                            </td>
                            <td style="margin:0;padding:0;">

                                <table cellspacing="0" border="0" style="width: 100%;">
                                     ${renderProductFee(data.productData)}
                                </table>

                            </td>

                            <td style="margin:0;padding:0;" >
                          <table cellspacing="0" border="0" style="width: 100%;">
                                     ${renderControlNumber(data.productData)}
                                </table>
                                </td>

                                <?php if ($role == 2 || $role == 3 || $role == 7) : ?>
                                <td style="margin:0;padding:0;" >
                                <table cellspacing="0" border="0" style="width: 100%;">
                                     ${renderOfficerName(data.productData)}
                                </table>
                                </td>
                               <?php endif; ?>
                        
                                <td class="" style="margin:0;padding:0;">
                          <table cellspacing="0" border="0" style="width: 100%;">
                                     ${renderPaymentStatus(data.productData)}
                                </table>
                            </td>
                            <td style="margin:0;padding:0;"> - </td>
                        </tr>

                        `;

                        });

                        table += `
                       </tbody>
                </table>
                    `
                        $('#summary').append(`

                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                        <h5 class="txt-center"><b>Collection Summary</b></h5>
                         <table class="table table-sm">
                         <tr class="paidAmount">
                         <td><b>Paid Amount</b></td>
                         <td>Tsh ${formatNumber(response.data.paidPrePackage)}</td>
                         <td> </td>
                         </tr>
                         <tr class="pendingAmount">
                         <td><b>Pending Amount</b></td>
                         <td>Tsh ${formatNumber(response.data.pendingPrePackage)}</td>
                         <td></td>
                         </tr>
                         <tr class="totalAmount">
                         <td><b>Total Amount</b></td>
                         <td>Tsh ${formatNumber(response.data.totalPrePackage)}</td>
                         <td> </td>
                         </tr>
                         </table>
                        </div>
                        </div>
                        `)

                        $('#reportContainer').append(table)

                    }



                }
            });
        }
    </script>
</section>
<?= $this->endSection(); ?>