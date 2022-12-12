<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background: #E7E7E7;
            font-family: sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100vh;
        }

        #box {
            background: #FFFFFF;
            padding: 3rem 2rem;
            border-radius: 5px;
            width: 500px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;

        }

        #box a {
            text-decoration: none;
            background: #CF731D;
            color: #ffffff;
            display: inline-block;
            padding: 10px;
            margin-top: 15px;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <div id="box">
        <h2>Access Denied</h1>
        <!-- <a href="<?= base_url() ?>/login">Go To Dashboard</a> -->
    </div>

</body>

</html>