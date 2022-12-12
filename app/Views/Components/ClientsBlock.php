<div class="clientsBlock">
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="customerForm" name="customerForm">
                        <?= regionsAndDistricts(6) ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Search</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="searchForm" name="searchForm">
                        <div class="input-group">
                            <input class="form-control" name="keyword" type="text" placeholder="Search here..." id="keyword" required>
                            <button class="btn btn-success btn-flat" type="submit">Search</button>
                        </div>
                    </form>

                    <ul class="list-group mt-2" id="searchResults">



                    </ul>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary btn-sm">Save</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- /.content-header -->
    <div class="container">

        <div class="card">
            <div class="card-header">

                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#searchModal">
                    <i class="fal fa-search"></i> Search Customer
                </button>

                <!-- visible only for add prepackage page -->

                <?php if (url_is('registeredPrepackages')) : ?>
                <?php else : ?>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                        <i class="fal fa-plus"></i> Add Customer
                    </button>
                <?php endif; ?>




            </div>
            <div class="card-body">
                <input class="form-control mb-1" type="text" id="customerId" name="customerId" hidden>
                <table class="table table-sm">

                    <tbody id="customerInfo">


                    </tbody>
                </table>
            </div>
            <!-- <div class="card-footer text-muted">
            Footer
        </div> -->
        </div>



    </div>
</div>

<script>
    //get customer info based on hash value
    function getCustomerInfo(hash) {

        // let lotSizes = []


        let url = 'selectClient'


        $.ajax({
            type: "post",
            url: url,
            data: {
                hash: hash
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $('#searchModal').modal('hide')


                const customer = response.customer
                document.querySelector('#customerId').value = customer.hash
                // console.log(response.products);




                $('#customerInfo').html(`
               
                  <tr>
                        <td> <b>Name</b></td>
                        <td>${customer.name}</td>
                    </tr>
                    <tr>
                        <td> <b>Region </b></td>
                        <td>${customer.region}</td>
                    </tr>
                    <tr>
                        <td> <b>District </b></td>
                        <td>${customer.district}</td>
                    </tr>
                    <tr>
                        <td> <b>Ward </b></td>
                        <td>${customer.ward}</td>
                    </tr>
                    <tr>
                        <td> <b>Physical Address </b></td>
                        <td>${customer.physical_address}</td>
                    </tr>
                    <tr>
                        <td> <b>Location </b></td>
                        <td>${customer.location}</td>
                    </tr>
                    
                    <tr>
                        <td><b>Postal Code</b></td>
                        <td>${customer.postal_code}</td>
                    </tr>
                    <tr>
                        <td><b>Postal Address</b></td>
                        <td>${customer.postal_address}</td>
                    </tr>
                    <tr>
                        <td><b>Phone Number</b></td>
                        <td>${customer.phone_number}</td>
                    </tr>


                `)
            }
        });
    }

    //saving customer info
    $('#customerForm').validate()
    customerForm.addEventListener('submit', (e) => {
        e.preventDefault()
        const data = {

        }
        const formData = new FormData(customerForm)
        formData.append('csrf_hash', document.querySelector('.token').value)

        if ($('#customerForm').valid()) {

            $.ajax({
                type: "POST",
                url: 'addCustomer',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",

                success: function(response) {

                    console.log(response)
                    const {
                        status,
                        msg,
                        hash,
                        token
                    } = response
                    if (status == 1) {
                        $('#addModal').modal('hide')
                        // $('#customerForm')[0].reset();
                        swal({
                            title: msg,
                            icon: "success",
                            timer: 4500
                        });
                        getCustomerInfo(response.hash)
                    } else {
                        swal({
                            title: 'Something Went Wrong',
                            icon: "warning",
                            timer: 4500
                        });
                    }





                },
                error: function(err) {
                    // console.log(err);
                }

            });
        }



    })


    // searching customer
    searchForm.addEventListener('submit', (e) => {
        e.preventDefault()
        const data = {
            url: 'searchCustomer',
            formData: new FormData(searchForm)
        }
        $.ajax({
            type: "POST",
            url: data.url,
            data: data.formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",

            success: function(response) {

                console.log(response)

                renderSearchResults(response)




            },
            error: function(err) {
                // console.log(err);
            }

        });



    })


    // rendering search results
    function renderSearchResults(res) {
        $('#searchResults').html('')
        console.log(res.data.length);

        let list = ``
        if (res.data.length == 0) {
            $('#searchResults').html('<h6>No Match Found!</h6>');
            console.log('no match');
        } else {
            res.data.forEach(customer => {
                list += `
           <li onclick="getCustomerInfo('${customer.hash}')" class="list-group-item d-flex justify-content-between align-items-center " style="cursor:pointer">
             ${customer.name}|  ${customer.physical_address} |  ${customer.phone_number}
           </li>
          `
            });


            $('#searchResults').append(list)
        }




    }
</script>