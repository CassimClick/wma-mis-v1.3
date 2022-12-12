<!-- adding a script to render personal details once a customer is selected -->
<?= $this->include('components/renderPersonalDetails') ?>
<!-- main  footer start here -->
<footer class="main-footer">
    <strong>Copyright &copy; <?= date('Y') ?></strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
        <?= csrf_field() ?>

    </div>
</footer>
</div>
<!-- ./wrapper -->
<!-- form Wizard -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->

<script src="<?= base_url() ?>/dist/js/timePicker.js"></script>
<script src="<?= base_url() ?>/dist/js/inputMaskLibrary.js"></script>
<script src="<?= base_url() ?>/dist/js/inputMask.js"></script>
<script src="<?= base_url() ?>/dist/js/commonTasks.js"></script>
<!-- Bootstrap -->
<script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url() ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>/dist/js/adminlte.js"></script>





<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?= base_url() ?>/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>


<!-- SummerNote -->
<script src="<?= base_url() ?>/plugins/summernote/summernote-bs4.min.js"></script>
<!-- ChartJS -->


<!-- PAGE SCRIPTS -->

<!-- Data Tables -->




<!-- Select2 -->
<script src="<?= base_url() ?>/plugins/select2/js/select2.full.min.js"></script>

<!-- ================Data Table Buttons -->







<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>

<script src="<?= base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>



<!-- <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script> -->



<!-- ADDITIONAL SCRIPTS -->



<script src="<?= base_url() ?>/dist/js/demo.js"></script>





<script src="<?= base_url() ?>/dist/js/personalDetails.js"></script>

<script src="<?= base_url() ?>/dist/js/searchCustomer.js"></script>

<?php if ($role == 2) : ?>
    <script src="<?= base_url() ?>/dist/js/chart.js"></script>

<?php endif; ?>
<?php if ($role == 3 || $role == 7) : ?>

    <script src="<?= base_url() ?>/dist/js/directorChart.js"></script>

<?php endif; ?>



<script>
    $(document).ready(function() {



        $(function() {

            $('[data-toggle="tooltip"]').tooltip()
        })

        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });



        // $(document).on("click", ".print", function() {
        //     const section = $("#printingSection");
        //     const modalBody = $("#modal-body").detach();

        //     const content = $(".printingContent").detach();
        //     section.append(modalBody);
        //     window.print();
        //     section.empty();
        //     section.append(content);
        //     $(".modal-body-wrapper").append(modalBody);
        // });




        let tableHeader = $('.head');

        let columnArray = [];
        for (let i = 0; i < tableHeader.length - 1; i++) {

            columnArray.push(i)
        }
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
        $("#example1").DataTable({

            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;


                // ================Create a dynamic index to target the column==============
                const target = document.querySelector("#amount");
                const columnIndex = Array.from(document.querySelectorAll(".head")).indexOf(target);

                function formatCurrency(amount) {
                    return new Intl.NumberFormat().format(amount)
                }


                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\Tsh,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(columnIndex)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(columnIndex, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(columnIndex).footer()).html(
                    'Tsh ' + formatCurrency(pageTotal) + ' Total'
                );

                $('.total').html('Tsh ' + formatCurrency(pageTotal));
            },
            dom: 'lBfrtip',
            buttons: [

                {
                    extend: 'print',
                    // autoPrint: true,
                    orientation: 'landscape',
                    exportOptions: {
                        columns: columnArray
                    }
                },

                {
                    extend: 'copyHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, ':visible'],
                        columns: columnArray
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: ':visible',
                        columns: columnArray
                    }
                },
                {
                    extend: 'pdfHtml5',
                    footer: true,
                    orientation: 'landscape',
                    pageSize: 'LEGAL',

                    exportOptions: {
                        columns: columnArray
                    }
                },

                'csv',
                // 'colvis'
            ],

            "responsive": true,
            "autoWidth": false,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true,

        });

    });


    setInterval(function() {
        $('#message').fadeOut(7000)
    });


    // checking session if is active
    // setInterval(function() {

    //     $.ajax({
    //         type: "POST",
    //         url: "<?= base_url() ?>/checkSession",
    //         data: {
    //             csrf_hash: document.querySelector('.token').value,

    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             console.log(response);
    //             document.querySelector('.token').value = response.token
    //             if (response.status == 0) {
    //                 window.location.replace('<?= base_url() ?>/login')
    //             }
    //         }
    //     });
    //    // console.log(document.cookie(''));

    // }, 300000);

    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    $(function() {
        // Summernote
        $('.textarea').summernote()
    })
</script>

</body>



</html>