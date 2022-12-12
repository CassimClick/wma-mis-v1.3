<?= $this->extend('layouts/CoreLayout'); ?>
<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= $page['heading'] ?></h1>
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



    <div class="card">
        <?= csrf_field() ?>
        <div class="card-header">
            COLLECTION TARGETS <span id="targetTotal"></span>

            <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#region-target-modal" style="float:right"><i class="far fa-plus-circle "></i> Add
                Target</button>
        </div>
        <div class="card-body">
            <?php if ($role == 3 || $role == 7) : ?>
                <div id="regionTargetList">
                </div>
            <?php elseif ($role == 2) : ?>
                <div id="activityTargetList">
                </div>
            <?php endif; ?>

        </div>

    </div>
    <!-- ########################################## -->
    <div id="region-target-modal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <!-- modal content -->
            <?php if ($role == 3 || $role == 7) : ?>
                <?= $this->include('Components/Target/regionTarget') ?>
            <?php elseif ($role == 2) : ?>
                <?= $this->include('Components/Target/activityTarget') ?>
            <?php endif; ?>
            <!-- modal content -->
        </div>
    </div>
    <div id="region-target-modal-update" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <!-- modal content -->
            <?php if ($role == 3 || $role == 7) : ?>
                <?= $this->include('Components/Target/regionTargetUpdate') ?>
            <?php elseif ($role == 2) : ?>
                <?= $this->include('Components/Target/activityTargetUpdate') ?>
            <?php endif; ?>
            <!-- modal content -->

        </div>
    </div>
    <!-- ########################################## -->



    <!-- <button type="button" onclick="renderTargetList()" class="btn btn-primary btn-sm">Get</button> -->
</div>
<script>
    //"use strict"
    <?php if ($role == 3 || $role == 7) : ?>
        renderTargetList("getRegionTargets")
    <?php elseif ($role == 2) : ?>
        renderTargetList("getActivityTargets")
    <?php endif; ?>


    <?php if ($role == 3 || $role == 7) : ?>
        const targetForm = document.querySelector('#targetForm')



        targetForm.addEventListener('submit', (e) => {
            e.preventDefault()
            let formData = new FormData(targetForm);
            // formData.append('csrf_hash', document.querySelector('.token').value);

            $('#targetForm').validate({
                rules: {
                    vtc: {
                        required: true
                    },
                    sbl: {
                        required: true
                    },
                }
            })



            $.ajax({
                type: "POST",
                url: 'saveRegionalTarget',
                cache: false,
                processData: false,
                contentType: false,
                data: formData,
                dataType: "json",
                success: function(response) {
                    // document.querySelector('.token').value = response.token
                    clearInputs()
                    console.log(response);
                    if (response.status == 1) {
                        targetForm.reset()
                        swal({
                            title: 'Collection Target Created',
                            icon: "success",
                            //    timer: 4500
                        });
                        $('#region-target-modal').modal('hide')

                        <?php if ($role == 3 || $role == 7) : ?>
                            renderTargetList("getRegionTargets")
                        <?php elseif ($role == 2) : ?>
                            renderTargetList("getActivityTargets")
                        <?php endif; ?>
                    } else {
                        swal({
                            title: 'Something Went Wrong',
                            icon: "warning",
                            timer: 2500
                        });
                    }



                }
            });
        })
    <?php endif; ?>


    function saveTarget(url, data) {

        // data.csrf_hash = document.querySelector('.token').value;

        console.log(data);


    }

    function editRegionTarget(id) {
        $.ajax({
            type: "POST",
            url: "editRegionTarget",
            data: {
                // csrf_hash: document.querySelector('.token').value,
                id: id
            },
            dataType: "json",
            success: function(response) {
                // document.querySelector('.token').value = response.token
                console.log(response);
                $('#region-target-modal-update').modal('show')
                $('#targetId').val(response.data.id);
                $('#targetMonth').val(response.data.month).change();
                $('#targetRegion').val(response.data.region).change();
                $('#targetYear').val(response.data.year).change();
                $('#vtc').val(response.data.vtc_qty);
                $('#vtcAmt').val(response.data.vtc_amt);
                $('#sbl').val(response.data.sbl_qty);
                $('#sblAmt').val(response.data.sbl_amt);
                $('#waterMeter').val(response.data.water_meters_qty);
                $('#waterMeterAmt').val(response.data.water_meters_amt);

            }
        });
    }


    const targeFormUpdate = document.querySelector('#targeFormUpdate')
    targeFormUpdate.addEventListener('submit', function(e) {
        e.preventDefault()

        let formData = new FormData(targeFormUpdate)
        // formData.append('csrf_hash', document.querySelector('.token').value)

        $.ajax({
            type: "POST",
            url: "updateRegionTarget",
            cache: false,
            processData: false,
            contentType: false,
            data: formData,
            dataType: "json",
            success: function(response) {
                // document.querySelector('.token').value = response.token
                console.log(response);
                if (response.status == 1) {
                    // console.log('updated');
                    renderTargetList(this)
                    $('#region-target-modal-update').modal('hide')
                    swal({
                        title: 'Collection Target Updated',
                        icon: "success",
                        // timer: 2500
                    });

                }

            }
        });
    })









    function renderTargetList() {

        $.ajax({
            url: 'getRegionTargets',
            type: "GET",


            // data: {
            //     csrf_hash: document.querySelector('.token').value
            // },
            dataType: "json",
            success: function(targets) {
                // document.querySelector('.token').value = target.token
                console.log(targets);

                let table = `
      <table class="table">

                    <thead>
                    <?php if ($role == 3 || $role == 7) : ?>
                        <tr>
                            <th>Region</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    <?php elseif ($role == 2 ) : ?>

                         <tr>
                            
                            <th>Month</th>
                            <th>Year</th>
                            <th>Amount</th>
                           
                            <th>Action</th>
                        </tr>
                    <?php endif; ?>


                    </thead>
      `
                let targetTotal = 0
                for (let target of targets) {
                    <?php if ($role == 3 || $role == 7) : ?>
                        table += `

                        <tr>
                            <td>${target.region}</td>
                            <td>${monthFormatter(+target.month)}</td>
                            <td>${target.year}</td>
                            <td>${formatNumber(target.amount)}</td>
                            <td><button type="button" onclick="editRegionTarget('${target.id}')" class="btn btn-success btn-sm"><i class="far fa-pen"></i></button></td>
                        </tr> `
                    <?php elseif ($role == 2) : ?>

                        function activityName(activity) {
                            switch (activity) {
                                case 'vtc':
                                    return 'Vehicle Tank Verification'
                                    break
                                case 'sbl':
                                    return 'Sandy & Ballast Lorries'
                                    break
                                case 'waterMeter':
                                    return 'Water Meters'
                                    break
                            }
                        }
                        targetTotal += +target.amount
                        $('#targetTotal').html(`<span style=""><b>Total ${formatNumber(targetTotal) }</b></span>`)
                        table += `

                        <tr>
                           
                            <td>${monthFormatter(+target.month)}</td>
                            <td>${target.year}</td>
                            <td>${formatNumber(target.amount)}</td>
                         
                            <td><button type="button" onclick="editActivityTarget('${target.id}')" class="btn btn-success btn-sm"><i class="far fa-pen"></i></button></td>
                        </tr> `

                    <?php endif; ?>



                }


                <?php if ($role == 3 || $role == 7) : ?>
                    $('#regionTargetList').html('')
                    $('#regionTargetList').append(table)
                <?php elseif ($role == 2) : ?>
                    $('#activityTargetList').html('')
                    $('#activityTargetList').append(table)
                <?php endif; ?>

            }
        });



    }
</script>


<?= $this->endSection(); ?>