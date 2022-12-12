<?= $this->extend('layouts/corelayout'); ?>
<?= $this->section('content'); ?>
<script>
// const fetchReportParams = (id) => {
//     const logDownload = document.querySelector('#downloadReport')
//     logDownload.setAttribute('href', '<?=base_url()?>/downloadCertificateOfQuantity/' + id)
// }
</script>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= $page['heading'] ?></h1>
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


        <div class="card">
            <div class="card-header">
                <form id="reportForm">
                    <div class="row">
                        <div class=" <?=($role == 3) ? 'col-md-4' : 'col-md-6' ?> col-sm-12">
                            <div class="form-group">
                                <label for="my-select">Activity</label>
                                <select id="activities" class="form-control" name="">
                                    <option value="All">All Activities</option>
                                    <option value="vtc">Vehicle Tank Calibration</option>
                                    <option value="sbl">Sandy & Ballast Lorries</option>
                                    <option value="water">Water Meters</option>
                                </select>
                            </div>
                        </div>
                        <?php if ($role == 3) : ?>
                        <div class="col-md-4 col-sm-12">
                            <label for="enableRegion"><input style="transform:scale(1.3); margin-right:5px"
                                    type="checkbox" id="enableRegion">Region</label>
                            <select id="region" class="form-control select2bs4" disabled>
                                <?php foreach (renderRegions() as $region) : ?>
                                <option value="<?= $region['region'] ?>"><?= $region['region'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <?php endif; ?>
                        <div class=" <?=($role == 3) ? 'col-md-4' : 'col-md-6' ?> col-sm-12">
                            <div class="form-group">
                                <label for="my-select">Year</label>
                                <select id="year" class="form-control" name="">
                                    <option value="<?= date('Y') ?>"><?= date('Y') ?></option>
                                    <?php for($i = 2020; $i >= 2018 ; $i-- ): ?>
                                    <option value="<?=$i ?>"><?=$i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2  col-xs-12">
                            <div class="form-group">
                                <label for="my-select"><input style="transform:scale(1.3); margin-right:5px"
                                        type="checkbox" name="" id="enableQuarter">Quarter/Annual</label>
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
                                <label for="my-select"><input style="transform:scale(1.3); margin-right:5px"
                                        type="checkbox" name="" id="enableMonth">Month</label>
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
                                <label for="my-input"> <input style="transform:scale(1.3); margin-right:5px"
                                        type="checkbox" name="" id="enableDateFilter">Custom Date</label>
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
        <div class="card-body">

            <select class="form-control" id="statusCheck">
                <option selected disabled>Filter Payment</option>
                <option value="Paid">Paid</option>
                <option value="Pending">Pending</option>
                <option value="All">All</option>
            </select>

            <table class="table" id="reportContainer">


            </table>
            <br>
            <div id="summary"></div>




        </div>
        <div class="card-footer">
            <a id="downloadReport" class="btn btn-success"><i class="far fa-download" aria-none="true"></i>Download</a>
        </div>
    </div>


    <script>
    const statusCheck = document.querySelector('#statusCheck')
    statusCheck.addEventListener('change', (e) => {
        hideShowSummary(e.target.value)
        const reportDownload = document.querySelector('#downloadReport')
        const statusTd = document.querySelectorAll('.status')
        for (let td of statusTd) {
            if (td.innerHTML == e.target.value) {

                td.parentNode.style.display = 'table-row'


            } else if (e.target.value == 'All') {
                const tableRows = document.querySelectorAll('.theRow')
                for (let tr of tableRows) {
                    tr.style.display = 'table-row'
                }
            } else {
                td.parentNode.style.display = 'none'
            }


        }




        const link = sessionStorage.getItem('downloadLink')
        if (e.target.value == 'Paid') {

            reportDownload.setAttribute('href', link + '/' + e.target.value + '/' + checkRegionValue())


        } else if (e.target.value == 'Pending') {

            reportDownload.setAttribute('href', link + '/' + e.target.value + '/' + checkRegionValue())


        } else {
            reportDownload.setAttribute('href', link + '/total' + '/' + checkRegionValue())
        }

    })

    function hideShowSummary(option) {
        const paidAmount = document.querySelector('.paidAmount')
        const pendingAmount = document.querySelector('.pendingAmount')
        const totalAmount = document.querySelector('.totalAmount')
        if (option == 'Paid') {
            paidAmount.style.display = 'table-row'
            pendingAmount.style.display = 'none'
            totalAmount.style.display = 'none'
        } else if (option == 'Pending') {
            pendingAmount.style.display = 'table-row'
            paidAmount.style.display = 'none'
            totalAmount.style.display = 'none'
        } else if (option == 'All') {
            paidAmount.style.display = 'table-row'
            pendingAmount.style.display = 'table-row'
            totalAmount.style.display = 'table-row'
        }
    }

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
    enableInput(enableRegion, region)

    //=================check if user wants to use a region filter====================
    function checkRegionValue() {
        if (region.hasAttribute('disabled')) {
            return 'Tanzania'
        } else {
            return region.value
        }
    }

    //=================################====================
    reportForm.addEventListener('submit', (e) => {
        e.preventDefault()

        const year = document.querySelector('#year').value
        const quarter = document.querySelector('#quarter')
        const month = document.querySelector('#month')
        const activity = document.querySelector('#activities').value

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
                        getDataForQuarter(7, 9, year, activity)
                        break;
                    case 'Q2':
                        getDataForQuarter(10, 12, year, activity)
                        break;
                    case 'Q3':
                        getDataForQuarter(1, 3, year, activity)
                        break;
                    case 'Q4':
                        getDataForQuarter(4, 6, year, activity)
                        break;
                    case 'Annually':
                        getDataForQuarter(1, 12, year, activity)
                        break;
                }

            }

            //=====================================
            if (!month.hasAttribute('disabled')) {


                switch (month.value) {
                    case '1':
                        getDataForMonth(month.value, year, activity)
                        break;
                    case '2':
                        getDataForMonth(month.value, year, activity)
                        break;
                    case '3':
                        getDataForMonth(month.value, year, activity)
                        break;
                    case '4':
                        getDataForMonth(month.value, year, activity)
                        break;
                    case '5':
                        getDataForMonth(month.value, year, activity)
                        break;
                    case '6':
                        getDataForMonth(month.value, year, activity)
                        break;
                    case '7':
                        getDataForMonth(month.value, year, activity)
                        break;
                    case '8':
                        getDataForMonth(month.value, year, activity)
                        break;
                    case '9':
                        getDataForMonth(month.value, year, activity)
                        break;
                    case '10':
                        getDataForMonth(month.value, year, activity)
                        break;
                    case '11':
                        getDataForMonth(month.value, year, activity)
                        break;
                    case '12':
                        getDataForMonth(month.value, year, activity)
                        break;
                    default:
                }

            } else {

            }
            //=====================================


            if (!dateFrom.hasAttribute('disabled') && !dateFrom.hasAttribute('disabled') && quarter
                .hasAttribute('disabled')) {

                getDataFromDateRange(dateFrom.value, dateTo.value, activity)
            }


        }



    })






    function getDataForQuarter(monthFrom, monthTo, year, activity) {


        if (!dateFrom.hasAttribute('disabled') && !dateTo.hasAttribute('disabled')) {



            //  =================################====================

            const params = {
                monthFrom: monthFrom,
                monthTo: monthTo,
                dateFrom: dateFrom.value,
                dateTo: dateTo.value,
                year: year,
                activity: activity,
                //status: ''
            }
            const url = "getQuarterReportWithDateRange"
            //=================function call to render a report ====================
            renderReport(params, url)


        } else {
            const params = {
                monthFrom: monthFrom,
                monthTo: monthTo,

                year: year,
                activity: activity,
                // region: checkRegionValue()

            }
            const url = "getQuarterReport"

            console.log(params)
            //=================function call to render a report ====================
            renderReport(params, url)

            const reportDownload = document.querySelector('#downloadReport')
            reportDownload.setAttribute('href', '<?=base_url()?>/downloadQuarterReport/' + activity + '/' +
                monthFrom + '/' +
                monthTo + '/' +
                year + '/total' + '/' + checkRegionValue())
            sessionStorage.setItem('downloadLink', '<?=base_url()?>/downloadQuarterReport/' + activity + '/' +
                monthFrom + '/' +
                monthTo + '/' +
                year);
        }

        // console.log('selected from ' + from + ' To ' + to + ' - ' + year)
    }

    function getDataForMonth(month, year, activity) {


        const params = {

            month: month,
            year: year,
            activity: activity,
            region: checkRegionValue,

        }
        const url = "getMonthlyReport"
        //=================function call to render a report ====================
        renderReport(params, url)
        const reportDownload = document.querySelector('#downloadReport')
        reportDownload.setAttribute('href', '<?=base_url()?>/downloadMonthlyReport/' + activity + '/' +
            month + '/' + year + '/total' + '/' + checkRegionValue())
        sessionStorage.setItem('downloadLink', '<?=base_url()?>/downloadMonthlyReport/' + activity + '/' +
            month + '/' + year);
    }

    //=================render report based on custom date range====================
    function getDataFromDateRange(dateFrom, dateTo, activity) {


        const params = {

            dateFrom: dateFrom,
            dateTo: dateTo,
            activity: activity,
            region: checkRegionValue,

        }


        const url = "customDateReport"
        //=================function call to render a report ====================
        renderReport(params, url)
        const reportDownload = document.querySelector('#downloadReport')
        reportDownload.setAttribute('href', '<?=base_url()?>/downloadCustomDateReport/' + activity + '/' +
            dateFrom + '/' +
            dateTo + '/total' + '/' + checkRegionValue())
        sessionStorage.setItem('downloadLink', '<?=base_url()?>/downloadCustomDateReport/' + activity + '/' +
            dateFrom + '/' +
            dateTo);
    }


    //=================render a report based on parameters====================

    function renderReport(reportParams, urlEndpoint) {
        function stringToInteger(str) {
            const toInt = str.replaceAll(',', '')
            return parseInt(toInt)
        }
        $.ajax({
            type: "GET",
            url: urlEndpoint,
            data: reportParams,
            dataType: "json",
            success: function(response) {

                $('#reportContainer').html('')
                $('#summary').html('')
                if (response.category == 'all') {
                    $('#statusCheck').css('display', 'none')
                    console.log(response)
                    const totalVtc = stringToInteger(response.vtc.totalVtc)
                    const totalSbl = stringToInteger(response.sbl.totalSbl)
                    const totalWaterMeter = stringToInteger(response.waterMeter.totalWaterMeter)

                    const vtcPaid = stringToInteger(response.vtc.paidVtc)
                    const sblPaid = stringToInteger(response.sbl.paidSbl)
                    const waterMeterPaid = stringToInteger(response.waterMeter.paidWaterMeter)

                    const vtcPending = stringToInteger(response.vtc.pendingVtc)
                    const sblPending = stringToInteger(response.sbl.pendingSbl)
                    const waterMeterPending = stringToInteger(response.waterMeter.pendingWaterMeter)



                    const totalAmount = totalVtc + totalSbl + totalWaterMeter
                    const totalPaid = vtcPaid + sblPaid + waterMeterPaid
                    const totalPending = vtcPending + sblPending + waterMeterPending


                    //<h5 class="text-center">${response.title.toUpperCase()}</h5>
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
                                <td>Tsh ${response.vtc.totalVtc}</td>
                                <td>Tsh ${response.vtc.paidVtc}</td>
                                <td>Tsh ${response.vtc.pendingVtc}</td>
                                <td>${response.vtc.vtcQuantity} Vehicle(s)</td>
                                <td>${response.vtc.vtcPaidQuantity} Vehicle(s)</td>
                                <td>${response.vtc.vtcPendingQuantity} Vehicle(s)</td>
                            </tr>
                            <tr>
                                <td>Sandy And Ballast Lorries</td>
                                <td>Tsh ${response.sbl.totalSbl}</td>
                                <td>Tsh ${response.sbl.paidSbl}</td>
                                <td>Tsh ${response.sbl.pendingSbl}</td>
                                <td>${response.sbl.sblQuantity} Vehicle(s)</td>
                                <td>${response.sbl.sblPaidQuantity} Vehicle(s)</td>
                                <td>${response.sbl.sblPendingQuantity} Vehicle(s)</td>
                            </tr>
                            <tr>
                                <td>Water Meters</td>
                                <td>Tsh ${response.waterMeter.totalWaterMeter}</td>
                                <td>Tsh ${response.waterMeter.paidWaterMeter}</td>
                                <td>Tsh ${response.waterMeter.pendingWaterMeter}</td>
                                <td>${response.waterMeter.waterMeterQuantity} Meter(s)</td>
                                <td>${response.waterMeter.waterMeterPaidQuantity} Meter(s)</td>
                                <td>${response.waterMeter.waterMeterPendingQuantity} Meter(s)</td>
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
                         <table class="table">
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
                else if (response.category == 'vtcOnly') {
                    $('#statusCheck').css('display', 'block')

                    console.log(response)

                    let vtcRow = ''
                    for (let vtc of response.vtcDetails) {
                        vtcRow += `
                            <tr class="theRow">
                                <td>${vtc.first_name}  ${vtc.last_name}</td>
                                <td>${vtc.phone_number}</td>
                                <td>${vtc.vehicle_brand}</td>
                                <td>${vtc.plate_number}</td>
                                <td>${vtc.capacity} Liters</td>
                                <td>${formatNumber(vtc.vehicle_amount)}</td>
                                <td>${vtc.control_number}</td>
                                <td class="status">${vtc.payment}</td>
                                <?php if ($role == 2 || $role == 3) : ?>
                                    <td>${vtc.fName}  ${vtc.lName}</td>
                                <?php endif; ?>
                            </tr>
                            `

                    }

                    let fullTable = `
                        <thead class="thead-light">
                            <tr>
                                <th>Owner</th>
                                <th>Phone Number</th>
                                <th>Vehicle Brand</th>
                                <th>Plate Number</th>
                                <th>Capacity</th>
                                <th>Amount</th>
                                <th>Control Number</th>
                                <th >Status</th>
                                <?php if ($role == 2 || $role == 3) : ?>
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
                         <table class="table">
                         <tr class="paidAmount">
                         <td><b>Paid Amount</b></td>
                         <td>Tsh ${response.vtc.paidVtc}</td>
                         <td> ${response.vtc.vtcPaidQuantity} Vehicle(s)</td>
                         </tr>
                         <tr class="pendingAmount">
                         <td><b>Pending Amount</b></td>
                         <td>Tsh ${response.vtc.pendingVtc}</td>
                         <td>${response.vtc.vtcPendingQuantity} Vehicle(s)</td>
                         </tr>
                         <tr class="totalAmount">
                         <td><b>Total Amount</b></td>
                         <td>Tsh ${response.vtc.totalVtc}</td>
                         <td> ${response.vtc.vtcQuantity} Vehicle(s)</td>
                         </tr>
                         </table>
                        </div>
                        </div>
                        `)



                    $('#reportContainer').append(fullTable)
                    // function renderOnlyPaid() {
                    // }
                } else if (response.category == 'sblOnly') {

                    console.log(response)
                    $('#statusCheck').css('display', 'block')

                    let sblRow = ''
                    for (let sbl of response.sblDetails) {
                        sblRow += `
                            <tr class="theRow">
                               <td>${sbl.first_name}  ${sbl.last_name}</td>
                                <td>${sbl.phone_number}</td>
                                <td>${sbl.vehicle_brand}</td>
                                <td>${sbl.plate_number}</td>
                                <td>${sbl.capacity} m <sup>3</sup></td>
                                <td>${formatNumber(sbl.vehicle_amount)}</td>
                                <td>${sbl.control_number}</td>
                                <td class="status">${sbl.payment}</td>
                                <?php if ($role == 2 || $role == 3) : ?>
                                    <td>${sbl.fName}  ${sbl.lName}</td>
                                <?php endif; ?>

                            </tr>
                            `

                    }



                    let fullTable = `
                        <thead class="thead-light">
                        <tr>
                                <th>Owner</th>
                                <th>Phone Number</th>
                                <th>Vehicle Brand</th>
                                <th>Plate Number</th>
                                <th>Capacity</th>
                                <th>Amount</th>
                                <th>Control Number</th>
                                <th>Status</th>
                                <?php if ($role == 2 || $role == 3) : ?>
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
                         <table class="table">
                         <tr class="paidAmount">
                         <td><b>Paid Amount</b></td>
                         <td>Tsh ${response.sbl.paidSbl}</td>
                         <td> ${response.sbl.sblPaidQuantity} Vehicle(s)</td>
                         </tr>
                         <tr class="pendingAmount">
                         <td><b>Pending Amount</b></td>
                         <td>Tsh ${response.sbl.pendingSbl}</td>
                         <td>${response.sbl.sblPendingQuantity} Vehicle(s)</td>
                         </tr>
                         <tr class="totalAmount">
                         <td><b>Total Amount</b></td>
                         <td>Tsh ${response.sbl.totalSbl}</td>
                         <td> ${response.sbl.sblQuantity} Vehicle(s)</td>
                         </tr>
                         </table>
                        </div>
                        </div>
                        `)



                    $('#reportContainer').append(fullTable)
                    // function renderOnlyPaid() {
                    // }
                } else if (response.category == 'waterMeterOnly') {
                    $('#statusCheck').css('display', 'none')
                    $('#statusCheck').css('display', 'block')
                    console.log(response)

                    let waterMeterRow = ''
                    for (let waterMeter of response.waterMeterDetails) {
                        waterMeterRow += `
                            <tr class="theRow">
                                <td>${waterMeter.first_name}  ${waterMeter.last_name}</td>
                                <td>${waterMeter.phone_number}</td>
                                <td>${waterMeter.brand}</td>
                                <td>${waterMeter.meter_size}</td>
                                <td>${waterMeter.flow_rate} </td>
                                <td>${waterMeter.class} </td>
                                <td>${waterMeter.quantity} </td>
                                <td>${formatNumber(waterMeter.meter_amount)}</td>
                                <td>${waterMeter.control_number}</td>
                                <td class="status">${waterMeter.payment}</td>
                                <?php if ($role == 2 || $role == 3) : ?>
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
                                <th>Status</th>
                                <?php if ($role == 2 || $role == 3) : ?>
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
                         <table class="table">
                         <tr class="paidAmount">
                         <td><b>Paid Amount</b></td>
                         <td>Tsh ${response.waterMeter.paidWaterMeter}</td>
                         <td> ${response.waterMeter.waterMeterPaidQuantity} Meter(s)</td>
                         </tr>
                         <tr>
                         <td class="pendingAmount"><b>Pending Amount</b></td>
                         <td>Tsh ${response.waterMeter.pendingWaterMeter}</td>
                         <td>${response.waterMeter.waterMeterPendingQuantity} Meter(s)</td>
                         </tr>
                         <tr class="totalAmount2">
                         <td><b>Total Amount</b></td>
                         <td>Tsh ${response.waterMeter.totalWaterMeter}</td>
                         <td> ${response.waterMeter.waterMeterQuantity} Meter(s)</td>
                         </tr>
                         </table>
                        </div>
                        </div>
                        `)



                    $('#reportContainer').append(fullTable)
                    // function renderOnlyPaid() {
                    // }
                }


            }
        });
    }
    </script>
</section>
<?= $this->endSection(); ?>