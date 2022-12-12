<section style="margin:0; padding:0;" id="printingSection">
    <div class="printingContent" style="margin:0; padding:0;">
        <div>
            <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" style="padding: 0;margin:0;">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">



                        <div class="modal-body-wrapper">
                            <div class="modal-body" id="modal-body">
                                <div>
                                    <div class="bill-header">
                                        <div class="logo">
                                            <img src="<?= base_url() ?>/assets/images/emblem.png" alt="" />
                                        </div>
                                        <div class="heading">
                                            <h5 class="text-center"><b>THE UNITED REPUBLIC OF TANZANIA</b></h5>
                                            <h5 class="text-center"><b>MINISTRY OF INDUSTRIES AND TRADE </b></h5>
                                            <h5 class="text-center">WEIGHTS AND MEASURES AGENCY</h5>
                                            <h5 class="text-center">Exchequer Receipt</h5>
                                            <p class="text-center">Stakabadhi ya Malipo ya Serikali</p>
                                        </div>
                                        <div class="logo">
                                            <img class="float-right" src="<?= base_url() ?>/assets/images/wma1.png" alt="" />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">

                                            <table class="table table-sm table-borderless" id="PaymentCustomer">

                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-8">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th style="width: 50%;">Item</th>
                                                        <!-- <th>Details</th> -->
                                                        <th style="width: 50%;">Amount</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="PaymentItems">




                                                </tbody>
                                            </table>




                                            <br>
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td style="width:50%;">Total Billed Amount:</b></td>
                                                    <!-- <td></td> -->
                                                    <td style="width:50%"><b id="billedTotal"></b></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:50%;">Bill Reference</b></td>
                                                    <!-- <td></td> -->
                                                    <td style="width:50%"><b id="billReference"></b></td>
                                                </tr>

                                                <tr>
                                                    <td style="width:50%;">Payment Control Number:</b></td>
                                                    <!-- <td></td> -->
                                                    <td style="width:50%"><b class="ref"></b></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:50%;">Payment Date:</b></td>
                                                    <!-- <td></td> -->
                                                    <td style="width:50%"><span id="paymentDate"></b></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:50%;">Issued By:</b></td>
                                                    <!-- <td></td> -->
                                                    <td style="width:50%"><span id="preparedBy"></b></td>
                                                </tr>

                                                <tr>
                                                    <td style="width:50%;">Date Issued :</b></td>
                                                    <!-- <td></td> -->
                                                    <td style="width:50%"><span id="printedOn"></span></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:50%;">Signature</b></td>
                                                    <!-- <td></td> -->
                                                    <td style="width:50%"><b>.........................</b></td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                            <button type="button" id="printBtn" class="btn btn-primary print btn-sm"><i class="fal fa-print"></i> Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).on("click", ".print", function() {
        const section = $("#printingSection");
        const modalBody = $("#modal-body").detach();

        const content = $(".printingContent").detach();
        section.append(modalBody);
        window.print();
        section.empty();
        section.append(content);
        $(".modal-body-wrapper").append(modalBody);
    });
</script>