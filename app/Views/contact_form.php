<!DOCTYPE html>
<html lang="en">

<head>
    <title>CodeIgniter 4 Form Data Submit by Ajax Method</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css" rel="stylesheet" />
    <style>
        #frm-add-user label.error {
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <h4 style="text-align: center;">CodeIgniter 4 Form Data Submit by Ajax Method</h4>
        <div class="panel panel-primary">
            <div class="panel-heading">CodeIgniter 4 Form Data Submit by Ajax Method</div>
            <div class="panel-body">
                <form class="form-horizontal" action="javascript:void(0)" id="frm-add-user">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" required id="name" placeholder="Enter name" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Email:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" required id="email" placeholder="Enter email" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="mobile">Mobile:</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" required id="mobile" placeholder="Enter mobile" name="mobile">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Validation library file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<!-- Sweetalert library file -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script>

<script>
    $(function() {

        // Adding form validation
        $('#frm-add-user').validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 60
                },
                mobile: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Name is required",
                },
                email: {
                    email: "It doe not seem valid email",
                    required: "Email is required",
                    maxlength: "Upto 50 characters are allowed",
                },
                mobile: {
                    required: "Please, enter mobile",
                },
            },
        });

        // Ajax form submission with image
        $('#frm-add-user').on('submit', function(e) {

            e.preventDefault();

            var formData = new FormData(this);
            // var formData = $(this).serialize();

            //We can add more values to form data
            //formData.append("key", "value");

            $.ajax({
                url: "<?= base_url('addForm') ?>",
                type: "POST",
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(data) {
                    if (data.success == true) {
                        Swal.fire('Saved!', '', 'success')
                    }
                },
                error: function(err, x, y) {
                    console.log(x);
                }
            });
        });
    });
</script>