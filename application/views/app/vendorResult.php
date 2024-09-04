<div class="row">
    <div class="col-12">
        <h4 class="text-center">Laporan Sales Vendor - <?php echo date('d M Y', strtotime($dateFrom)) ?> s/d <?php echo date('d M Y', strtotime($dateTo)) ?></h4>
        <div class="mt-2">
            <h5><u>Laporan Order</u></h5>
            <table class="table table-sm table-bordered fs-12">
                <thead>
                    <tr>
                        <th>ID_Order</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Refrensi PO</th>
                        <th>Status</th>
                        <th>Total Order</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($getAllOrder as $data) { ?>
                        <tr>
                            <td><?php echo $data->idMasterOrder ?></td>
                            <td><?php echo date('d-m-Y', strtotime($data->createdAt)) ?></td>
                            <td><?php echo $data->companyName . ' / ' . $data->username ?></td>
                            <td><?php echo $data->poRefrence ?></td>
                            <td><?php echo $data->status ?></td>
                            <td>Rp. <?php echo number_format($data->totalOrder->totalOrder) ?></td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
            <h5><u>Laporan Invoice</u></h5>
            <table class="table table-bordered table-sm fs-12">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No.Invoice</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>PO Vendor</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $no = 1;
                    foreach ($getAllInvoice as $data) {
                        $date = date('Y-m-d');
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data->idInvoice ?></td>
                            <td><?php echo date('Y-m-d', strtotime($data->createdAt)) ?></td>
                            <td><?php echo $data->companyName . ' / ' . $data->username ?></td>
                            <td><?php echo $data->poRefrence ?></td>
                            <td><?php echo number_format($data->sumTotal->totalBayar) ?></td>
                            <td>
                                <?php echo ($data->dueDate <= $date && $data->status == "PENDING") ? 'JATUH TEMPO' : $data->status ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <h5><u>Ringkasan</u></h5>
            <table class="table table-sm table-bordered w-50 mt-3">
                <tr>
                    <th width="40%">Omzet Order</th>
                    <td>Rp. <?php echo number_format($omzetOrder->omzet) ?></td>
                </tr>
                <tr>
                    <th>Invoice Release</th>
                    <td>Rp. <?php echo number_format($invoiceRelease->omzet_invoice) ?></td>
                </tr>
                <tr>
                    <th>Piutang</th>
                    <td class="text-danger">Rp. <?php echo number_format($piutangPeriode->kredit_invoice) ?></td>
                </tr>
                <tr>
                    <th>Debit Invoice</th>
                    <td class="text-success">Rp. <?php echo number_format($debitPeriode->debit_invoice) ?></td>
                </tr>
            </table>
        </div>
        <div class="d-print-none">
            <div class="float-end">
                <a href="javascript:window.print()" class="btn btn-dark border-0"><i
                        class="mdi mdi-printer me-1"></i>Print</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>