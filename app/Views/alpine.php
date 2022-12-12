<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script defer src="https://unpkg.com/alpinejs@3.5.0/dist/cdn.min.js"></script>
    <title>Alpine</title>
</head>

<body>



    <button onclick="processData()">Click Me</button>
    <button onclick="addData()">Add Data</button>

    <table id="users" border="1" style="border-collapse: collapse;"></table>

    <form id="dataForm" enctype="multipart/form-data">
        <input type="text" name="customer"><br>
        <input type="text" name="product"><br>
        <input type="file" id="file" name="img"><br>

        <button type="submit">Save</button>
    </form>


    <script>
        function processData() {
            // main.js

            // GET request using fetch()
            fetch("http://localhost/vipimo/data")

                // Converting received data to JSON
                .then(response => response.json())
                .then(json => {

                    console.log(json)
                    // Create a variable to store HTML
                    //         let li = `<tr><th>Name</th><th>Email</th></tr>`;

                    //         // Loop through each data and add a table row
                    //         json.forEach(user => {
                    //             li += `<tr>
                    // 	<td>${user.name} </td>
                    // 	<td>${user.email}</td>		
                    // </tr>`;
                    //         });

                    //         // Display result
                    //         document.getElementById("users").innerHTML = li;
                });

        }

        const dataForm = document.querySelector('#dataForm')
        dataForm.addEventListener('submit', addData)



        function addData(e) {

            e.preventDefault()

            let formData = new FormData(dataForm)
           // formData.append("img", document.querySelector('#file').files[0]);
            // main.js


            //console.log(formData.values())
            const data = {}
            let formValues = []
            let formKeys = []
            for (const keys of formData.entries()) {
                formKeys.push(keys[0])
                formValues.push(keys[1])
            }
            formKeys.forEach((element, index) => {
                data[element] = formValues[index]
            })

            // console.log(formKeys)
            // console.log(formValues[2].files)
            console.log(data)
            // console.log(document.querySelector('#file').value)

            // POST request using fetch()
            fetch("http://localhost/vipimo/addItem", {

                    // Adding method type
                    method: "POST",

                    // Adding body or contents to send
                    body: formData,

                })

                // Converting to JSON
                .then(response => response.json())

                // Displaying results to console
                .then(json => console.log(json));


        }
    </script>

</body>

</html>