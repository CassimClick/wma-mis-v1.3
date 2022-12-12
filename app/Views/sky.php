<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>sky</title>
</head>

<body>
    <h2>sky page</h2>
    <input type="" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
    <button onclick="getData('u8e4u8w5979wet4wr46')">click</button>



    <script>
        function getData(id) {
            let token = document.querySelector('.txt_csrfname').value

            $.ajax({
                type: "POST",
                url: "user",
                data: {
                    csrf_hash: document.querySelector('.txt_csrfname').value,
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                }
            });

        }
    </script>
</body>

</html>