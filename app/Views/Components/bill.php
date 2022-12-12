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
                                             <!-- <h5 class="text-center">ARUSHA COLLECTION REPORT</h5> -->
                                             <p class="text-center">Government Bill</p>
                                         </div>
                                         <div class="logo">
                                             <img class="float-right" src="<?= base_url() ?>/assets/images/wma1.png" alt="" />
                                         </div>
                                     </div>
                                     <hr>
                                     <div class="row">
                                         <div class="col-8">

                                             <table class="table table-sm table-borderless" id="billCustomer">

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
                                                 <tbody id="billItems">




                                                 </tbody>
                                             </table>




                                             <br>
                                             <table class="table table-sm table-borderless">
                                                 <tr>
                                                     <td style="width:50%;">Total Billed Amount:</b></td>
                                                     <!-- <td></td> -->
                                                     <td style="width:50%"><b id="billTotal"></b></td>
                                                 </tr>
                                                 <tr>
                                                     <td style="width:50%;">Amount In Words:</b></td>
                                                     <!-- <td></td> -->
                                                     <td style="width:50%"><span id="billTotalInWords"></span></td>
                                                 </tr>
                                                 <tr>
                                                     <td style="width:50%;">Prepared By:</b></td>
                                                     <!-- <td></td> -->
                                                     <td style="width:50%"><span id="preparedBy"></b></td>
                                                 </tr>
                                                 <tr>
                                                     <td style="width:50%;">Printed By:</b></td>
                                                     <!-- <td></td> -->
                                                     <td style="width:50%"><span id="printedBy"></b></td>
                                                 </tr>
                                                 <tr>
                                                     <td style="width:50%;">Printed On:</b></td>
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
                                     <hr>

                                     <div class="row">
                                         <div class="col-12">
                                             <h6><b>Notes, Terms and condition</b></h6>
                                             <ul>
                                                 <!-- <li>1.All cheques must be crossed and payable to above described payee</li>
                                                <li>(Hundi zote ziwe zimefungwa na zilipwe kwa aliyeainishwa)</li>
                                                 <li>2.	Please return duplicated copy of the invoice with your cheque/cash.</li>
                                                 <li>(Tafadhali rejesha nakala ya pili ya hati ya madai sambamba na malipo)</li> -->
                                                 <li>1.Where the invoice amount exceeds Tshs. 10 Million, the amount must be paid within 21 days.</li>
                                                 <li>(Ikiwa deni ni zaidi ya Tshs. 10 milioni, malipo yafanyike kwa muamala wa kibenki ndani ya siku 21)</li>
                                                 <li>2.Where the invoce is less than Tshs. 10 Million, the amount must be paid within 14 days.</li>
                                                 <li>(Ikiwa deni ni chini ya Tshs. 10 milioni malipo yafanyike ndani ya siku 14)</li>
                                                 <li>3.Where customer fails to pay billed amount on the due date the demand notice shall be served with interest charges at a rate of 5% per month of the total debt.</li>
                                                 <li>(Ikiwa mteja atashindwa kulipa deni baada ya tarehe ya kulipa , Demand Notice itatolewa kwake ikiwa na riba ya 5% kwa mwezi ya jumla ya deni lake ) </li>
                                             </ul>
                                         </div>
                                         <div class="col-6">
                                             <h6><b>How to pay</b></h6>

                                             <ul>
                                                 <li>1 Via bank visit any branch CRDB,NMB,BOT reference number: <b class="ref"></b> </li>
                                                 <!-- <li>( Kupitia Banki ,Fika tawi lolote la CRDB,NMB,BOT Na kumbukumbu : <b class="ref"></b>)</li> -->
                                                 <li>2 via Mobile network operators (MNO)</li>
                                                 <!-- <li> (Kupitia mitandao ya simu -->
                                                 <ul>
                                                     <li>Enter respective USSD menu of MNO</li>
                                                     <!-- <li>Ingia kwenye Mtandao Husika</li> -->
                                                     <li>Select 4 (Make Payments)</li>
                                                     <!-- <li>Chagua 4 (Lipa bili)</li> -->
                                                     <li>Select 5 (Government payments enter <b class="ref"></b> as reference number) </li>
                                                     <!-- <li>Chagua 5 (malipo ya serikali ingiza <b class="ref"></b> kama namba ya kumbukumbu) </li> -->


                                                 </ul>
                                                 </li>

                                             </ul>
                                             </li>

                                         </div>
                                         <div class="col-6">
                                             <h6><b>Jinsi ya kulipa</b></h6>

                                             <ul>
                                                 <!-- <li>1 Via bank visit any branch CRDB,NMB,BOT reference number: <b class="ref"></b> </li> -->
                                                 <li>( Kupitia Banki ,Fika tawi lolote la CRDB,NMB,BOT Na kumbukumbu : <b class="ref"></b>)</li>
                                                 <!-- <li>2 via Mobile network operators (MNO)</li> -->
                                                 <li> (Kupitia mitandao ya simu
                                                     <ul>
                                                         <!-- <li>Enter respective USSD menu of MNO</li> -->
                                                         <li>Ingia kwenye Mtandao Husika</li>
                                                         <!-- <li>Select 4 (Make Payments)</li> -->
                                                         <li>Chagua 4 (Lipa bili)</li>
                                                         <!-- <li>Select 5 (Government payments enter <b class="ref"></b> as reference number) </li> -->
                                                         <li>Chagua 5 (malipo ya serikali ingiza <b class="ref"></b> kama namba ya kumbukumbu) </li>


                                                     </ul>

                                             </ul>
                                             </li>

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