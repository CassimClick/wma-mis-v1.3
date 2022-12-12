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

.<div class="container-fluid">



    <div class="card">
        <div class="card-header">
            <form action="post" id="searchInterface">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <!-- <label for="my-select">Text</label> -->
                            <select id="activity" class="form-control" name="">
                                <option value="vtc">Vehicle Tank Verification <i class="far fa-user"></i></option>
                                <option value="sbl">Sand & Ballast lorries</option>
                                <option value="waterMeter">Water Meters</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <!-- <label for="my-input">Activity</label> -->
                            <input id="keyword" class="form-control" type="text" placeholder="Search keyword...">
                        </div>
                    </div>

                </div>
            </form>
            <button type="button" id="searchBtn" class="btn btn-primary">Search</button>
        </div>
        <div class="card-body">
            <div class="searchResponse">
            </div>

        </div>

    </div>
</div>

<script>
$(document).ready(function() {
    $('#searchBtn').click(function() {
        $('.searchResponse').html('');
        const searchField = document.querySelector('#keyword').value
        const regex = new RegExp(searchField, 'i');
        $.getJSON('searchExistingCustomer', function(data) {
            $.each(data, function(key, customer) {
                if (customer.first_name.search(regex) != -1 || customer.last_name
                    .search(regex) != -1) {
                    $('.searchResponse').append(`
                        <div class="dropdown-divider"></div>
                        <p style="cursor:pointer" data-dismiss="modal" onclick="selectCustomer('${customer.hash}')">${customer.first_name}  ${customer.last_name} | ${customer.region} | ${customer.ward} | ${customer.phone_number}</p>
                         <div class="dropdown-divider"></div>
                  `);
                }
            });
        })
    })
});
</script>

<?= $this->endSection(); ?>