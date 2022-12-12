<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha512-3P8rXCuGJdNZOnUx/03c1jOTnMn3rP63nBip5gOP2qmUh5YAdVAvFZ1E+QLZZbC1rtMrQb+mah3AfYW11RUrWA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <title>Seeder</title>
</head>

<body>

    <div id="name"></div>

    <button type="button" onclick="getData()">Get Data</button>

    <pre>
        <h2><?= count([]); ?></h2>
        <h2><?= $date; ?></h2>
    </pre>


    <script>
        function base_url() {
            var pathparts = location.pathname.split('/');
            if (location.host == 'localhost') {
                var url = location.origin + '/' + pathparts[1].trim('/') + '/'; // http://localhost/myproject/
            } else {
                var url = location.origin; // http://stackoverflow.com
            }
            return url;
        }

        console.log(base_url())

        // function getData() {
        //     $.ajax({
        //         type: "get",
        //         url: "http://localhost/vipimo/getVisitors",
        //         // data: "data",
        //         dataType: "json",
        //         success: function(response) {
        //             console.log(response)
        //         }
        //     });
        // }
    </script>

</body>

</html>