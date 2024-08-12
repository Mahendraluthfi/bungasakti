<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4>Edit Order - ID <?php echo $this->uri->segment(3) ?></h4>
                        <nav class="breadcrumb">
                            <a class="breadcrumb-item" href="<?php echo base_url() ?>">Dashboard</a>
                            <a class="breadcrumb-item" href="<?php echo base_url('Order') ?>">Order</a>
                            <span class="breadcrumb-item active" aria-current="page">Edit Order</span>
                        </nav>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <div class="table-responsive">
                        <table class="table table-light table-bordered table-sm">
                            <form id="frmPurchase">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold table-secondary" width="13%">Customer</td>
                                        <td width="37%"><?php echo $getOrderById->companyName ?></td>
                                        <td class="fw-bold table-secondary">id PR</td>
                                        <td><?php echo $getOrderById->idPR ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold table-secondary">E-mail</td>
                                        <td><?php echo $getOrderById->email ?></td>
                                        <td class="fw-bold table-secondary">Status</td>
                                        <td><?php echo $getOrderById->status ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold table-secondary">Contact Number</td>
                                        <td><?php echo $getOrderById->contactNumber ?></td>
                                        <td class="fw-bold table-secondary">Created At</td>
                                        <td><?php echo $getOrderById->createdAt ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold table-secondary">PO Refrence</td>
                                        <td>
                                            <form id="frmPO">
                                                <div class="input-group input-group-sm">
                                                    <input type="hidden" name="idMasterOrder" value="<?php echo $getOrderById->idMasterOrder ?>">
                                                    <input type="text" name="poRefrence" value="<?php echo $getOrderById->poRefrence ?>" class="form-control" placeholder="Masukkan PO Refrensi" aria-label="Masukkan PO Refrensi" aria-describedby="button-addon2">
                                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="updatePO()">Update</button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="fw-bold table-secondary">Updated At</td>
                                        <td><?php echo ($getOrderById->updatedAt == "0000-00-00 00:00:00") ? '' : $getOrderById->updatedAt;  ?></td>
                                    </tr>
                                </tbody>
                            </form>
                        </table>
                        <?php if ($checkBarangNotInMaster) { ?>
                            <div class="alert alert-info" role="alert">
                                <h5 class="alert-heading">List Barang belum masuk order dari PR</h5>
                            </div>
                            <table id="scroll-horizontal-datatable-zero" class="table table-striped w-100 nowrap">
                                <thead>
                                    <tr>
                                        <td>Description</td>
                                        <td>Qty Order</td>
                                        <td>Keterangan</td>
                                        <td>#</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($checkBarangNotInMaster as $data) { ?>
                                        <tr>
                                            <td><?php echo $data->descriptionCustom ?></td>
                                            <td><?php echo $data->qtyOrder ?></td>
                                            <td><?php echo $data->remark ?></td>
                                            <td>
                                                <button type="button" onclick="addNew('<?php echo $data->idDetPR ?>')" class="btn btn-info btn-sm" href="#" role="button"><i class="mdi mdi-download"></i> Tambah ke Order</button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <hr>
                        <?php } ?>
                        <div class="d-flex mb-2">
                            <div class="me-auto">
                                <h5>List Order Barang</h5>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" onclick="addBarang()"><i class="mdi mdi-plus"></i> Tambah Barang</button>
                        </div>
                        <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap table-sm">
                            <thead>
                                <tr class="fw-bold">
                                    <td>No</td>
                                    <td>Barang</td>
                                    <td>Mat.Code</td>
                                    <td>Tipe</td>
                                    <td>Qty Order</td>
                                    <td>Price</td>
                                    <td>Total</td>
                                    <td>Stock Take</td>
                                    <td>Status</td>
                                    <td>#</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($getListOrderById as $data) { ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data->description ?></td>
                                        <td><?php echo $data->mcRefrence ?></td>
                                        <td><?php echo substr($data->type, 0, 1) ?></td>
                                        <td><?php echo $data->qtyBalance . '/' . $data->qtyOrder ?></td>
                                        <td><?php echo number_format($data->fixedPrice) ?></td>
                                        <td><?php echo number_format($data->total) ?></td>
                                        <td></td>
                                        <td>
                                            <?php echo ($data->statusQty == 1) ? '<span class="badge bg-success">OK</span>' : '<span class="badge bg-danger">PENDING</span>' ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Edit Order" tabindex="0"><i class="mdi mdi-pencil"></i></button>
                                            <?php if ($data->type == "READY") { ?>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Atur Stock Order" tabindex="0" onclick="aturStock('<?php echo $data->idDetOrder ?>')"><i class="mdi mdi-store"></i></button>
                                            <?php } ?>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Hapus Item" tabindex="0"><i class="mdi mdi-delete"></i></button>
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
</div>

<div class="modal fade" id="modalId" tabindex="-1" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang ke Master Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmBarang">
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="description" required placeholder="Nama Barang" id="floatingDescription"></textarea>
                        <label for="floatingDescription">Nama Barang / Deskripsi</label>
                        <input type="hidden" name="idDetPR">
                        <input type="hidden" name="qtyOrder">
                        <input type="hidden" name="idMasterOrderHide" value="<?php echo $this->uri->segment(3) ?>">
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="barcode" id="floatingBarcode" placeholder="Barcode">
                        <label for="floatingBarcode">Barcode</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="mcRefrence" id="floatingMC" placeholder="MC">
                        <label for="floatingMC">Material Code / Refrensi</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" required name="uom" id="floatingUom" placeholder="uom">
                        <label for="floatingUom">Satuan Unit / UOM</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="type" required id="floatingType" aria-label="Floating label select example">
                            <option value="" selected="">Pilih</option>
                            <option value="READY">READY</option>
                            <option value="CUSTOM">CUSTOM</option>
                        </select>
                        <label for="floatingType">Pilih Tipe Barang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" min="0" required class="form-control" name="basePrice" id="floatingBasePrice" placeholder="Harga">
                        <label for="floatingBasePrice">Harga Dasar</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="saveNewBarang()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalIdOrder" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmAddBarang">
                    <div class="row mb-3">
                        <label for="select-beast" class="col-sm-3 col-form-label">Pilih Barang</label>
                        <div class="col-sm-9">
                            <select name="idBarang" id="select-beast" required>
                                <option value="">Pilih</option>
                                <?php foreach ($getAllBarang as $data) { ?>
                                    <option value="<?php echo $data->idBarang ?>"><?php echo $data->description ?> / <?php echo $data->mcRefrence ?> / <?php echo $data->type ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputQty" class="col-sm-3 col-form-label">Qty</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="idMasterOrderAdd" value="<?php echo $this->uri->segment(3) ?>">
                            <input type="number" name="qtyOrder" required class="form-control" min="0" id="inputQty" placeholder="Masukan Qty">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="save()">Tambah</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalAturStock" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Atur Stock Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmAturStock">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Barang</label>
                        <div class="col-sm-9">
                            <!-- <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com"> -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Qty Order</label>
                        <div class="col-sm-9"></div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Atur Stock</label>
                        <div class="col-sm-9"></div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Ambil Qty</label>
                        <div class="col-sm-9"></div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">

                        </div>
                    </div>
                </form>
                <table class="table table-sm table-condensed py-2">
                    <thead>
                        <tr>
                            <td>Toko</td>
                            <td>Ambil Stock</td>
                            <td>Datetime</td>
                            <td>#</td>
                        </tr>
                    </thead>
                    <tbody id="tbAturStock"></tbody>
                </table>
                <button type="button" class="btn btn-secondary">Validasi Atur Stock</button>

            </div>
        </div>
    </div>
</div>


<script>
    let base_url = '<?php echo base_url(); ?>';
    let form = document.getElementById('frmBarang');
    let formOrder = document.getElementById('frmAddBarang');
    const updatePO = () => {
        let poRefrence = $('[name="poRefrence"]').val();
        let idMasterOrder = $('[name="idMasterOrder"]').val();
        $.ajax({
            url: base_url + 'order/updatePO',
            type: 'POST',
            data: {
                idMasterOrder: idMasterOrder,
                poRefrence: poRefrence,
            },
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });

    }

    const addNew = (idDetPR) => {
        $.ajax({
            url: base_url + 'order/getIdDetPR',
            type: 'POST',
            data: {
                idDetPR: idDetPR
            },
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                $('[name="description"]').val(data.descriptionCustom);
                $('[name="idDetPR"]').val(data.idDetPR);
                $('[name="qtyOrder"]').val(data.qtyOrder);
                $('#modalId').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const saveNewBarang = () => {
        if (form.checkValidity() == true) {
            $.ajax({
                url: base_url + 'order/addNewBarang',
                type: 'POST',
                data: $('#frmBarang').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        } else {
            form.reportValidity();
        }
    }

    const addBarang = () => {
        $('#modalTitleId').text('Tambah Order Barang');
        save_method = 'addOrderBarang';
        $('#frmAddBarang')[0].reset();
        $('#modalIdOrder').modal('show');
    }

    const save = () => {
        if (formOrder.checkValidity() == true) {
            $.ajax({
                url: base_url + 'order/addOrderBarang',
                type: 'POST',
                data: $('#frmAddBarang').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        } else {
            formOrder.reportValidity();
        }
    }

    const aturStock = (idDetOrder) => {
        $.ajax({
            url: base_url + 'order/aturStock',
            type: 'POST',
            data: {
                idDetOrder: idDetOrder
            },
            dataType: 'JSON',
            success: function(data) {
                console.log(data);
                $('#modalAturStock').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function showTableAturStock($idDetOrder) {

    }

    const issuedStock = () => {

    }
</script>