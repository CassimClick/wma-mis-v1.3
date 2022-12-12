<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
</head>


<body>



    <pre>
    <?php
    //print_r($info);
    ?>
    </pre>

    <table border="1">
        <tr>
            <th>City</th>
            <th>Paid</th>
            <th>Pending</th>
            <th>Total</th>
            <th>view</th>
        </tr>


        <?php foreach ($info as  $report) : ?>
        <tr>

            <td>
                <?= $report['region'] ?>

            </td>
            <td>
                <?= $report['paid'] ?>

            </td>
            <td>
                <?= $report['pending'] ?>

            </td>
            <td>
                <?= 'Tsh ' . number_format($report['total']) ?>

            </td>
            <td>
                <a href="<?= base_url() ?>/viewRegion/<?= $report['region'] ?>">View</a>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

    <pre>
<?php
//print_r($money);
?>
</pre>
    <pre>
<?php
//print_r($cities);
?>
</pre>
    <pre>
<?php
//print_r($combine);
?>
</pre>

</body>

</html>