<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: 'Verdana';
        }

        .box {
            width: 215px;
            padding-left: 15px;
            height: auto;
            /* border: 1px solid; */
            font-size: 10px;
        }

        .header {
            text-align: center;
        }

        .items {
            width: 100%;
            border: none;
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="box">
        <div class="header">
            <span style="font-size: 14px;"><?php echo $getPenjualan->namaToko ?></span><br>
            Alamat:<br>
            <?php echo $getPenjualan->address ?><br>
            <hr>
        </div>
        <table class="items">
            <tr>
                <td>Nota</td>
                <td>:</td>
                <td><?php echo $getPenjualan->idPenjualan ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><?php echo $getPenjualan->createdAt ?></td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td>:</td>
                <td><?php echo $getPenjualan->name ?></td>
            </tr>
            <tr>
                <td>Customer</td>
                <td>:</td>
                <td><?php echo $getPenjualan->customerName ?></td>
            </tr>
            <tr>
                <td>Catatan</td>
                <td>:</td>
                <td><?php echo $getPenjualan->remark ?></td>
            </tr>
        </table>

        <hr>
        <table class="items">
            <?php foreach ($getDetailTransaksi as $data) { ?>
                <tr>
                    <td colspan="4"><?php echo $data->description ?></td>
                </tr>
                <tr>
                    <td><?php echo $data->qty ?>x</td>
                    <td><?php echo $data->uom ?></td>
                    <td>@<?php echo number_format($data->price) ?></td>
                    <td style="text-align: end;">Rp.<?php echo number_format($data->price * $data->qty) ?></td>
                </tr>
            <?php } ?>
        </table>
        <hr>
        Jml Items : <?php echo $totalItems->totalQty ?>
        <hr>
        <table class="items">
            <tr>
                <td style="text-align: end;">TOTAL BAYAR: </td>
                <td style="text-align: end;">Rp.<?php echo number_format($totalBayar->totalBayar) ?></td>
            </tr>
        </table>
        <p></p>
        <p style="text-align:center; padding-top:5px;">*Terima Kasih atas kunjungan Anda*</p>


    </div>
    <script>
        function printAndClose() {
            window.print(); // Open print dialog

            // Close the tab after a delay (3000 milliseconds = 3 seconds)
            setTimeout(function() {
                window.close();
            }, 2500); // Adjust the delay as needed
        }

        // Call the function when needed
        printAndClose();
    </script>
</body>

</html>