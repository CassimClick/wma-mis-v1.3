<?= $this->extend('layouts/corelayout'); ?>
<?= $this->section('content'); ?>
<script>
const fetchTheShipId = (id) => {
    const logDownload = document.querySelector('#downloadNoteOfFactBefore')
    logDownload.setAttribute('href', '<?=base_url()?>/downloadCertificateOfQuantity/' + id)
}
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
        <?= $this->include('widgets/shipOptions.php') ?>
        <?= $this->include('components/shipDetails.php') ?>
        <?= $this->include('components/PortUnit/searchShip.php') ?>

        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#note-modal"
                    aria-pressed="false" autocomplete="off"><i class="far fa-plus-circle" aria-hidden="true"></i>Add
                    Note</button>
                <button type="button" onclick="getNoteOfFactBefore()" class="btn btn-success" id="refreshTimeLogs"><i
                        class="far fa-sync" aria-hidden="true"></i>Check
                    Note</button>

                <h4 id="selectedShip"></h4>
            </div>
            <div class="card-body">
                <div id="currenCertificate">

                </div>

            </div>
            <div class="card-footer">
                <a id="downloadNoteOfFactBefore" class="btn btn-success"><i class="far fa-download"
                        aria-hidden="true"></i>Download</a>
            </div>
        </div>


        <div id="note-modal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">ADD NOTE OF FACT BEFORE DISCHARGING</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">

                            <input id="shipId" class="form-control" type="number" name="">
                        </div>
                        <!-- ====== -->

                        <div class="row">
                            <div class="form-group col-6">
                                <label for="my-input">Bill Of Lading (MT)</label>
                                <input type="number" class="form-control " id="billOfLading1"
                                    placeholder="Bill Of Lading">
                            </div>

                            <div class="form-group col-6">
                                <label for="my-input">Vessel Figure After After Loading (MT)</label>
                                <input type="number" class="form-control " id="vesselFigAfterLoading1"
                                    placeholder="Vessel Figure After After Loading (MT)">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="my-input">Vessel Arrival Quantities (MT)</label>
                                <input type="number" class="form-control " id="arrivalQuantity1"
                                    placeholder="Vessel Arrival Quantity (MT)"
                                    oninput="calcBillOfLadingFirst(this.value)">
                            </div>
                            <div class="form-group col-6">
                                <label for="my-input">Vessel Arrival Quantities (MT)</label>
                                <input type="number" class="form-control" id="arrivalQuantity2"
                                    placeholder="Vessel Arrival Quantity (MT)"
                                    oninput="calcBillOfLadingSecond(this.value)">
                            </div>


                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="my-input">Difference</label>
                                <input type="number" class="form-control " id="Difference1" placeholder="Difference">
                            </div>
                            <div class="form-group col-6">
                                <label for="my-input">Difference</label>
                                <input type="number" class="form-control " id="Difference2" placeholder="Difference">
                            </div>


                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="my-input">% - Difference</label>
                                <input type="number" class="form-control " id="DifferencePercent1"
                                    placeholder="% - Difference">
                            </div>
                            <div class="form-group col-6">
                                <label for="my-input">% - Difference</label>
                                <input type="number" class="form-control " id="DifferencePercent2"
                                    placeholder="Difference">
                            </div>


                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-9">
                                <p>After adjusting ship's figure with the Vessel Experience Factor (VEF) </p>
                            </div>
                            <div class="col-3">
                                <input id="vesselExperienceFactor" class="form-control pull-left" type="number"
                                    oninput="vesselExperienceFactor(this.value)">
                            </div>
                        </div>
                        <p>The following is noted:</p>
                        <!-- ########################################################################## -->
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="my-input">Bill Of Lading (MT)</label>
                                <input type="number" class="form-control " id="billOfLading1_b"
                                    placeholder="Bill Of Lading">
                            </div>

                            <div class="form-group col-6">
                                <label for="my-input">Vessel Figure After After Loading (MT)</label>
                                <input type="number" class="form-control " id="vesselFigAfterLoading1_b"
                                    placeholder="Vessel Figure After After Loading (MT)">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="my-input">Vessel Arrival Quantities (MT) 1</label>
                                <input type="number" class="form-control " id="arrivalQuantity1_b"
                                    placeholder="Vessel Arrival Quantity (MT)"
                                    oninput="calcBillOfLadingFirst(this.value)">
                            </div>
                            <div class="form-group col-6">
                                <label for="my-input">Vessel Arrival Quantities (MT) 2</label>
                                <input type="number" class="form-control" id="arrivalQuantity2_b"
                                    placeholder="Vessel Arrival Quantity (MT)"
                                    oninput="calcBillOfLadingSecond(this.value)">
                            </div>


                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="my-input">Difference 1</label>
                                <input type="number" class="form-control " id="Difference1_b" placeholder="Difference">
                            </div>
                            <div class="form-group col-6">
                                <label for="my-input">Difference 2</label>
                                <input type="number" class="form-control " id="Difference2_b" placeholder="Difference">
                            </div>


                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="my-input">% - Difference</label>
                                <input type="number" class="form-control " id="DifferencePercent1_b"
                                    placeholder="% - Difference">
                            </div>
                            <div class="form-group col-6">
                                <label for="my-input">% - Difference</label>
                                <input type="number" class="form-control " id="DifferencePercent2_b"
                                    placeholder="Difference">
                            </div>


                        </div>
                        <!-- ########################################################################## -->

                        <div class="modal-footer">
                            <button type="button" id="saveNoteBefore" class="btn btn-primary">Save Note</button>
                            <button type="button" onclick="myFunction()">test</button>
                        </div>
                    </div>
                </div>
            </div>


        </div><!-- /.container-fluid -->

        <script>
        function formatNumber(number) {
            return new Intl.NumberFormat().format(number)
        }


        //=================*********====================

        //=================right side====================
        const billOfLading1 = document.querySelector('#billOfLading1')
        const DifferencePercent1 = document.querySelector('#DifferencePercent1')
        Difference1 = document.querySelector('#Difference1')

        function calcBillOfLadingFirst(arrivalQty1) {
            const diffOne = arrivalQty1 - billOfLading1.value
            Difference1.value = diffOne.toFixed(3)

            DifferencePercent1.value = ((diffOne / billOfLading1.value) * 100).toFixed(3)

        }
        //=================left side====================
        const vesselFigAfterLoading1 = document.querySelector('#vesselFigAfterLoading1')
        const DifferencePercent2 = document.querySelector('#DifferencePercent2')
        Difference2 = document.querySelector('#Difference2')

        function calcBillOfLadingSecond(arrivalQty2) {

            const diffTwo = arrivalQty2 - vesselFigAfterLoading1.value
            Difference2.value = diffTwo.toFixed(3)

            DifferencePercent2.value = ((diffTwo / vesselFigAfterLoading1.value) * 100).toFixed(3)

        }

        //=================second block====================
        const billOfLading1_b = document.querySelector('#billOfLading1_b')
        const arrivalQuantity1 = document.querySelector('#arrivalQuantity1')
        const arrivalQuantity1_b = document.querySelector('#arrivalQuantity1_b')
        const arrivalQuantity2_b = document.querySelector('#arrivalQuantity2_b')
        const vesselFigAfterLoading1_b = document.querySelector('#vesselFigAfterLoading1_b')
        const DifferencePercent1_b = document.querySelector('#DifferencePercent1_b')
        const DifferencePercent2_b = document.querySelector('#DifferencePercent2_b')
        const Difference1_b = document.querySelector('#Difference1_b')
        const Difference2_b = document.querySelector('#Difference2_b')

        function vesselExperienceFactor(vef) {
            billOfLading1_b.value = billOfLading1.value
            const ArrivalB = (arrivalQuantity1.value / vef).toFixed(3)
            arrivalQuantity1_b.value = ArrivalB

            const DifferenceB = ((arrivalQuantity1.value / vef) - billOfLading1.value).toFixed(3)

            Difference1_b.value = DifferenceB
            DifferencePercent1_b.value = ((DifferenceB / ArrivalB) * 100).toFixed(3)
            //=====================================
            vesselFigAfterLoading1_b.value = (vesselFigAfterLoading1.value / vef).toFixed(3)
            arrivalQuantity2_b.value = ArrivalB

            // const Difference2B = (arrivalQuantity2_b.value - (vesselFigAfterLoading1.value / vef)).toFixed(3)
            const Difference2B = (arrivalQuantity2_b.value - (vesselFigAfterLoading1.value / vef)).toFixed(3)
            Difference2_b.value = Difference2B
            Diff100Percent = ((Difference2B / ArrivalB) * 100).toFixed(3)
            DifferencePercent2_b.value = Diff100Percent



        }




        const saveNoteBefore = document.querySelector('#saveNoteBefore');
        saveNoteBefore.addEventListener('click', (e) => {
            e.preventDefault()



            const shipId = document.querySelector('#shipId')






            function validateInput(formInput) {

                if (formInput.value == '') {

                    formInput.style.border = '1px solid #ff6348'
                    return false
                } else {
                    formInput.style.border = '1px solid #2ed573'
                    return true
                }

            }

            if (validateInput(billOfLading1)) {
                $.ajax({
                    type: "POST",
                    url: "addNoteOfFactBefore",
                    dataType: "json",
                    data: {
                        shipId: shipId.value,

                    },
                    success: function(response) {


                        // console.log(response)
                        if (response == 'Added') {

                            getNoteOfFactBefore()
                            $('#note-modal').modal('hide');

                            swal({
                                title: 'Certificate Saved',
                                // text: "You clicked the button!",
                                icon: "success",
                                button: "Ok",
                            });

                        } else {
                            swal({
                                title: 'Something Went Wrong!',
                                // text: "You clicked the button!",
                                icon: "error",
                                button: "Ok",
                            });
                        }
                    }
                }, );
            }



        })


        function formatDate(dateInput) {
            const date = new Date(dateInput);
            const formattedDate = date.toLocaleDateString('en-GB', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            }).replace(/ /g, '-');

            return formattedDate
        }
        //=================Processing Certificate of Quantity====================
        function processNoteOfFactBefore(arr) {
            let metric_tons_in_air = 0
            let metric_tons_in_vac = 0
            let long_tons = 0
            let litres_20c = 0
            let observedVolume = 0
            let litres_15c = 0

            const density_15 = arr[0].density_15C
            const density_20 = arr[0].density_20C
            const WCFT_15 = arr[0].density_15C - 0.0011
            const WCFT_20 = arr[0].density_20C - 0.00
            const usbbls_60F = arr[0].usbbls_60F
            const us_gallons_60F = arr[0].us_gallons_60F

            arr.forEach(element => {

                metric_tons_in_air += parseFloat(element.GSV20Centigrade * WCFT_20)
                metric_tons_in_vac += parseFloat(element.GSV20Centigrade * density_20)
                observedVolume += parseFloat((element.totalObservedVolume) * 1000)
                litres_20c += parseFloat((element.GSV20Centigrade) * 1000)
                litres_15c += parseFloat((element.GSV15Centigrade) * 1000)


            });



            return `

<table class="table" border="0" style="width: 35%;">

   <tbody>

       <tr>
           <td> Metric Tons in Air</td>
           <td colspan="2"> = </td>
           <td>${metric_tons_in_air.toFixed(3)}</td>
       </tr>
       <tr>
           <td>Metric Tons in Vac.</td>
           <td colspan="2"> = </td>
           <td>${metric_tons_in_vac.toFixed(3)}</td>
       </tr>
       <tr>
           <td> Long Tons</td>
           <td colspan="2"> = </td>
           <td>${(metric_tons_in_air * 0.984206).toFixed(3)}</td>
       </tr>
       <tr>
           <td> Litres @ 20&deg;C</td>
           <td colspan="2"> = </td>
           <td>${formatNumber(litres_20c)}</td>
       </tr>
       <tr>
           <td>Observed Volume (Liters)</td>
           <td colspan="2"> = </td>
           <td>${formatNumber(observedVolume)}</td>
       </tr>
       <tr>
           <td>Litres @ 15&deg;C</td>
           <td colspan="2"> = </td>
           <td>${formatNumber(litres_15c)}</td>
       </tr>
       
       <tr>
           <td> US BBLS @ 60&deg;F</td>
           <td colspan="2"> = </td>
           <td>${formatNumber(usbbls_60F)}</td>
       </tr>
       <tr>
           <td>US GALLONS @ 60&deg;F</td>
           <td colspan="2"> = </td>
           <td>${formatNumber(us_gallons_60F)}</td>
       </tr>
       <tr>
           <td>Std density@20</td>
           <td colspan="2"> = </td>
           <td>${density_20}</td>
       </tr>
       <tr>
           <td>Std density@15</td>
           <td colspan="2"> = </td>
           <td>${density_15}</td>
       </tr>

   </tbody>
   </table>
`



        }

        function getNoteOfFactBefore() {
            $('#currenCertificate').html('')
            /// const shipId = document.querySelector('#shipId')
            $.ajax({
                type: "POST",
                url: "getNoteOfFactBefore",
                data: {
                    shipId: shipId.value
                },
                dataType: "json",
                success: function(response) {

                    console.log(response)

                    // if (response == 'nothing') {
                    //     $('#currenCertificate').html('<h3>No Certificate Found</h3>')
                    // } else {

                    //     fetchTheShipId(shipId.value)

                    //     console.log(response)
                    //     $('#currenCertificate').append(processNoteOfFactBefore(response))



                    // }




                }
            });
        }
        </script>
</section>
<?= $this->endSection(); ?>