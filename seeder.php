<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"
        integrity="sha512-3P8rXCuGJdNZOnUx/03c1jOTnMn3rP63nBip5gOP2qmUh5YAdVAvFZ1E+QLZZbC1rtMrQb+mah3AfYW11RUrWA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Seeder</title>
</head>

<body>
<li></li>
    <div id="name"></div>

    <button type="button" onclick="getData()">Get Data</button>


    <script>
       

            async function getData() {
                let url = 'http://localhost/vipimo/visitors';
                try {
                    let res = await fetch(url);
                    return await res.json();
                } catch (error) {
                    console.log(error);
                }
            }


            // fetch

            // $.ajax({
            //     type: "get",
            //     url: "http://localhost/vipimo/visitors",
            //     // data: "data",
            //     dataType: "json",
            //     success: function (response) {
            //         console.log(response)   
            //     }
            // });

            const ul = html`<ul>
                
                </ul>`
        
    </script>

</body>

</html>