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

<div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Tambah Order Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo form_open('order/addNewOrder') ?>
                <div class="row mb-2">
                    <label for="inputCustomer" class="col-sm-2 col-md-3 col-form-label">Customer</label>
                    <div class="col-sm-9 col-md-9">
                        <select name="idCustomer" required id="select-beast" onchange="pickCustomer(this)">
                            <option value="">Pilih Customer</option>
                            <?php foreach ($getAllCustomer as $data) { ?>
                                <option value="<?php echo $data->idCustomer ?>"><?php echo $data->companyName ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-2 col-md-3 col-form-label">PO Refrence</label>
                    <div class="col-sm-9 col-md-9">
                        <input type="text" class="form-control" name="poRefrence" placeholder="Masukkan PO Client">
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-2 col-md-3 col-form-label"></label>
                    <div class="col-sm-9 col-md-9">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
    let base_url = '<?php echo base_url(); ?>';
    const deleteData = (idMasterOrder) => {
        //
    }

    const openModal = () => {
        $('#modalId').modal('show');
    }
</script>