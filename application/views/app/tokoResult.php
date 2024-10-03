<div class="row">
    <div class="col-12">
        <h4 class="text-center">Laporan Sales - <?php echo $namaToko ?> - <?php echo date('d M Y', strtotime($dateFrom)) ?> s/d <?php echo date('d M Y', strtotime($dateTo)) ?></h4>
        <div class="mt-2">
            <h5><u>Ringkasan</u></h5>
            <table class="table table-sm table-bordered w-50 mt-3">
                <tr>
                    <th width="40%">Total Penjualan</th>
                    <td>Rp. <?php echo number_format($getTotalPenjualan->totalPenjualan) ?></td>
                </tr>
                <tr>
                    <th>Total Transaksi</th>
                    <td><?php echo $getTotalTransaksi ?></td>
                </tr>
                <tr>
                    <th>Total Item Terjual</th>
                    <td><?php echo $getTotalItems->totalItems ?></td>
                </tr>
                <tr>
                    <th>5 Barang terlaris</th>
                    <td>
                        <?php foreach ($topFive as $data) {
                            echo $data->description . ' (' . $data->qtyJual . ')<br>';
                        } ?>
                    </td>
                </tr>

            </table>
        </div>
        <div class="d-print-none">
            <div class="float-end">
                <a href="javascript:window.print()" class="btn btn-dark border-0"><i class="mdi mdi-printer me-1"></i>Print</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>