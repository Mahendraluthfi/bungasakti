<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4>Master Invoice</h4>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Customer</th>
                                <th>No.Invoice</th>
                                <th>No.Surat Jalan</th>
                                <th>ID_MasterOrder</th>
                                <th>Tanggal</th>
                                <th>Tempo</th>
                                <th>Total</th>
                                <th>Tgl Bayar</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($getAllInvoice as $data) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data->companyName ?></td>
                                    <td><?php echo $data->idInvoice ?></td>
                                    <td><?php echo $data->idSuratJalan ?></td>
                                    <td><?php echo $data->idMasterOrder ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($data->createdAt)) ?></td>
                                    <td><?php echo $data->dueDate ?></td>
                                    <td><?php echo number_format($data->sumTotal->totalBayar) ?></td>
                                    <td><?php echo ($data->paymentDate == '0000-00-00') ? '' : $data->paymentDate ?></td>
                                    <td><?php echo $data->status ?></td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>