<?= $this->extend('layouts/coreLayout'); ?>
<?= $this->section('content'); ?>
<?php
$pageSession = \CodeIgniter\Config\Services::session();
?>

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



    <!-- Modal -->
    <div class="modal fade" id="detailsModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> -->
                <div class="modal-body" id="details">
                    <table class="table table-sm table-striped table-inverse">
                        <thead class="thead-inverse" id="itemDetails">



                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary btn-sm">Save</button> -->
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <?= csrf_field() ?>
        <div class="card-header">
            <form id="searchingForm">
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <!-- <label for="my-select">Text</label> -->
                            <select name="activity" class="form-control">
                                <option value="vtv">Vehicle Tank Verification <i class="far fa-user"></i></option>
                                <option value="sbl">Sand & Ballast lorries</option>
                                <option value="waterMeters">Water Meters</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <!-- <label for="my-input">Activity</label> -->

                            <div class="input-group">
                                <input id="keyword" name="keyword" class="form-control" type="text" placeholder="Search keyword...">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"> <i class="far fa-search"></i>
                                        Search</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>


    </div>
    <div class="card searchCard" id="ItemBlock" style="display: none;">

        <div class="card-body">
            <table class="table table-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Item</th>
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody id="searchResults">



                </tbody>
            </table>
        </div>

    </div>



    <!-- ------------------------ -->
    <div class="card card-primary col-md-12 p-0" id="instrumentDetails" style="display: none;">
        <div class="card-header border-transparent">
            <h3 class="card-title">FULL DETAILS</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool ctn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool ctn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- <div class="dropdown-divider"></div> -->

        <div class="card-body" id="instrumentFullDetails">

        </div>

    </div>

</div>
</div>

<script>
    const keyword = document.querySelector('#keyword').value


    const searchingForm = document.querySelector('#searchingForm')

    searchingForm.addEventListener('submit', (e) => {
        e.preventDefault()



        console.log('searching....')
        const formData = new FormData(searchingForm)
        const searchResults = document.querySelector('#searchResults')



        fetch('searchItem', {
                method: 'POST',

                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.status == 1 && data.data.length) {
                    const ItemBlock = document.querySelector('#ItemBlock')
                    const Item = data.data.map(Item => {
                        return `
                <tr style="cursor:pointer" onclick="viewItem('${Item.id}','${data.activity}')" >
                    <td>${Item.name}</td>
                    <td>${Item.phone_number}</td>
                    <td>${Item.item}</td>
                  
                   
                  
                </tr>
                `
                    }).join('')


                    $(document).ready(function() {

                    })
                    searchResults.innerHTML = ''
                    searchResults.innerHTML = Item
                    ItemBlock.style.display = 'block'





                } else {
                    ItemBlock.style.display = 'none'
                    swal({
                        title: 'No Match Found !',
                        icon: "warning",
                        timer: 2500
                    });
                }






            });
    })



    function viewItem(id, activity) {
        const itemDetails = document.querySelector('#itemDetails')
        fetch('selectItem', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify({
                    id: id,
                    activity: activity
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.status == 1 && data.data.length) {
                    $('#detailsModel').modal('show')
                    const ItemBlock = document.querySelector('#ItemBlock')
                    const Item = data.data.map(item => {
                        return `
                
                            <tr>
                                <td scope="row">Client Name </td>
                                <td>${item.name}</td>

                            </tr>
                            <tr>
                                <td scope="row">Region</td>
                                <td>${item.region}</td>

                            </tr>
                            <tr>
                                <td scope="row">Phone Number</td>
                                <td>${item.phone_number}</td>

                            </tr>
                         
                            <tr>
                                <td scope="row">Item </td>
                              <td>${item.item}</td>

                            </tr>
                          
                            <tr>
                                <td scope="row">Control Number </td>
                              <td>${item.control_number}</td>

                            </tr>
                               <tr>
                                <td scope="row">Amount</td>
                                <td>${item.amount}</td>

                            </tr>
                            <tr>
                                <td scope="row">Prepared By</td>
                              <td>${item.creator}</td>

                            </tr>
                            ${(data.activity == 'vtv' || data.activity == 'sbl')?`
                                   <tr>
                                <td scope="row">Sticker Number </td>
                              <td>${item.sticker_number}</td>

                            </tr>
                            <tr>
                                <td scope="row">Calibrated on </td>
                              <td>${item.calibratedOn}</td>

                            </tr>
                            <tr>
                                <td scope="row">Next Calibration  </td>
                              <td>${item.nextCalibration}</td>

                            </tr>
                                
                                `:''}
                           
                `
                    }).join('')


                    $(document).ready(function() {

                    })
                    itemDetails.innerHTML = ''
                    itemDetails.innerHTML = Item
                    ItemBlock.style.display = 'block'





                } else {
                    ItemBlock.style.display = 'none'
                    swal({
                        title: 'No Match Found !',
                        icon: "warning",
                        timer: 2500
                    });
                }






            });
    }
    
</script>



<?= $this->endSection(); ?>