<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4>Master Order</h4>
                        <button type="button" class="btn btn-primary btn-sm mb-3" onclick="openModal()"><i class="mdi mdi-plus"></i> Tambah Data</button>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <table id="scroll-horizontal-datatable-zero" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th>ID_Order</th>
                                <th>ID_PR</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Refrensi PO</th>
                                <th>Status</th>
                                <th>Total Order</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($getAllOrder as $data) { ?>
                                <tr>
                                    <td><?php echo $data->idMasterOrder ?></td>
                                    <td>
                                        <?php if ($data->idPR !== null) { ?>
                                            <button type="button" class="btn btn-light btn-sm">
                                                <?php echo $data->idPR ?>
                                            </button>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo date('d-m-Y', strtotime($data->createdAt)) ?></td>
                                    <td><?php echo $data->companyName ?></td>
                                    <td><?php echo $data->poRefrence ?></td>
                                    <td><?php echo $data->status ?></td>
                                    <td>Rp. <?php echo number_format($data->totalOrder->totalOrder) ?></td>
                                    <td>
                                        <a href="<?php echo base_url('order/editOrder/' . $data->idMasterOrder) ?>" class="btn btn-warning btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Edit Order" tabindex="0"><i class="mdi mdi-pencil"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteData('<?php echo $data->idMasterOrder ?>')" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Hapus Order" tabindex="0"><i class="mdi mdi-trash-can"></i></button>
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

<script>
    let base_url = '<?php echo base_url(); ?>';
    const deleteData = (idMasterOrder) => {
        //
    }
</script>