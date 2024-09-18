<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">

            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4>Master Pembelian</h4>
                        <a href="<?php echo base_url('pembelian/editForm') ?>" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah Data</a>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Toko</th>
                                <th>User</th>
                                <th>Nota No.</th>
                                <th>Ket.</th>
                                <th>Total</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($getAllPembelian as $data) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data->idPembelian ?></td>
                                    <td><?php echo $data->issuingDate ?></td>
                                    <td><?php echo $data->namaToko ?></td>
                                    <td><?php echo $data->name ?></td>
                                    <td><?php echo $data->notaRefrence ?></td>
                                    <td><?php echo $data->remark ?></td>
                                    <td><?php echo number_format($data->total->totalPembelian) ?></td>
                                    <td>
                                        <a href="<?php echo base_url('pembelian/editForm/' . $data->idPembelian) ?>" class="btn btn-warning btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Edit Order" tabindex="0"><i class="mdi mdi-pencil"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>