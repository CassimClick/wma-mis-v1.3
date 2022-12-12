<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css" integrity="sha512-gMjQeDaELJ0ryCI+FtItusU9MkAifCZcGq789FrzkiM49D8lbDhoaUaIX4ASU187wofMNlgBJ4ckbrXM9sE6Pg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Document</title>
</head>

<body>
    <button type="button" class="btn btn-primary" onclick="addRevenueSource()">Add</button>
    <form id="form">

        <div class="billItems"></div>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>

    <script>
        function addRevenueSource() {
            $('.billItems').append(`
         <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Select Revenue Source <span class="text-danger">*</span></label>
                        <select class="form-control" name="GfsCode[]" id="">
                            <option value="14210121">Receipts from Weighs & Measure Implements</option>
                            <option value="14220104">Receipt from Vehicle Tank Calibration</option>
                            <option value="14220208">Fines, Penalties and Forfeitures</option>
                            <option value="14220161">Miscellaneous Receipts</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="number" name="BillItemAmt[]" id="" oninput="calcTotal()" min="1" class="form-control itemAmount" placeholder="">
                        <!-- <small id="helpId" class="text-muted">Help text</small> -->
                    </div>
                </div>
                <div class="col-md-1">

                    <button type="button" class="btn btn-dark btn-sm" onclick="removeItem(this)" style="margin-top: 2rem;"><i class="far fa-minus"></i></button>
                </div>
                <input type="text" name="BillItemRef[]" id="" value="123456789" class="form-control" placeholder="" hidden>

            </div>
        
        `)


        }

        const form = document.querySelector('#form')
        form.addEventListener('submit', e => {
            e.preventDefault()
            const formData = new FormData(form)
            // formData.append('csrf_hash', document.querySelector('.token').value)
            fetch('domAjax', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8',
                        "X-Requested-With": "XMLHttpRequest"
                    },

                    body: formData,

                }).then(response => response.json())
                .then(data => {
                    //document.querySelector('.token').value = data.token
                    console.log(data)
                })
        })
        /*
        
        Bill submission response: http://training.wma.go.tz:7882/control_number
        Payment Notification: http://training.wma.go.tz:7882/bill_payment
        Bill reconciliation:   http://training.wma.go.tz:7882/bill_reconciliation
        */
    </script>

</body>

</html>