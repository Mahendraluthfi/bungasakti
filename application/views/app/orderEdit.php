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
                                        <td><?php echo $data->type ?></td>
                                        <td><?php echo '/' . $data->qtyOrder ?></td>
                                        <td><?php echo number_format($data->fixedPrice) ?></td>
                                        <td><?php echo number_format($data->total) ?></td>
                                        <td>
                                            <?php if ($data->getStockIssuedByDetOrder) {
                                                foreach ($data->getStockIssuedByDetOrder as $datarow) { ?>
                                                    <span class="badge bg-dark" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="<?php echo $datarow->namaToko ?>" tabindex="0"><?php echo $datarow->qtyIssued ?></span>
                                            <?php }
                                            } ?>
                                        </td>
                                        <td>
                                            <?php echo ($data->statusQty == 1)
                                                ? '<span class="badge bg-success">OK</span>'
                                                : (($data->statusQty == 2) ? '<span class="badge bg-warning">OVER</span>' : '<span class="badge bg-danger">PENDING</span>') ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Edit Order" tabindex="0" onclick="editOrder('<?php echo $data->idDetOrder ?>')"><i class="mdi mdi-pencil"></i></button>
                                            <?php if ($data->type == "READY") { ?>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Atur Stock Order" tabindex="0" onclick="aturStock('<?php echo $data->idDetOrder ?>')"><i class="mdi mdi-store"></i></button>
                                            <?php } ?>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Hapus Item" tabindex="0"><i class="mdi mdi-delete"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="py-2">
                            <button type="button" class="btn btn-primary"><i class="mdi mdi-offer"></i> Print Quotation</button>
                            <button type="button" class="btn btn-warning" onclick="buatInvoice()"><i class="mdi mdi-invoice-clock"></i> Generate Invoice</button>

                        </div>
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
                            <input type="text" readonly class="form-control-plaintext description">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Qty Order</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext qtyOrder">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Atur Stock</label>
                        <div class="col-sm-9">
                            <select name="pilihStock" required class="form-control"></select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Ambil Qty</label>
                        <div class="col-sm-9">
                            <input type="number" required min="0" name="ambilStock" class="form-control" placeholder="Masukkan Qty">
                            <input type="hidden" name="idDetOrder">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <button type="button" onclick="atur()" class="btn btn-dark">Atur</button>
                        </div>
                    </div>
                </form>
                <table class="table table-sm table-condensed py-2">
                    <thead>
                        <tr class="fw-bold">
                            <td>Toko</td>
                            <td>Ambil Stock</td>
                            <td>Datetime</td>
                            <td>#</td>
                        </tr>
                    </thead>
                    <tbody id="tbAturStock"></tbody>
                </table>
                <button type="button" class="btn btn-secondary" onclick="validasiStock()">Validasi Atur Stock</button>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div
        class="modal-dialog"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Edit List Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmEdit">
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="description" placeholder="Nama Barang" id="floatingDescription" readonly></textarea>
                        <label for="floatingDescription">Nama Barang / Deskripsi</label>
                        <input type="hidden" name="idDetEdit">
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" min="0" required class="form-control" name="qtyOrder" id="floatingQty" placeholder="Qty Order">
                        <label for="floatingQty">Qty Order</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" min="0" required class="form-control" name="fixedPrice" id="floatingBasePrice" placeholder="Harga">
                        <label for="floatingBasePrice">Harga</label>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpanEdit()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalInvoice" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Buat Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="">Pilih Barang yang dibuat Invoice</label>
                <form id="frmInvoice">
                    <table class="table table-striped w-100 nowrap table-sm">
                        <thead>
                            <tr class="fw-bold">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault"></label>
                                    </div>
                                </td>
                                <td>Barang</td>
                                <td>Mat.Code</td>
                                <td>Tipe</td>
                                <td>Qty Order</td>
                                <td>Price</td>
                                <td>Total</td>
                                <td>Qty Invoice</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($getListOrderById as $data) {
                                if ($data->statusQty == 1) {
                            ?>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="<?php echo $data->idDetOrder ?>" name="idDetOrder[]">
                                                <label class="form-check-label"></label>
                                            </div>
                                        </td>
                                        <td><?php echo $data->description ?></td>
                                        <td><?php echo $data->mcRefrence ?></td>
                                        <td><?php echo $data->type ?></td>
                                        <td><?php echo $data->qtyOrder ?></td>
                                        <td><?php echo number_format($data->fixedPrice) ?></td>
                                        <td><?php echo number_format($data->total) ?></td>
                                        <td>
                                            <input type="number" min="0" name="qtyInvoice[<?php echo $data->idDetOrder ?>]" class="form-control form-control-sm" max="<?php echo $data->qtyOrder ?>" value="<?php echo $data->qtyOrder ?>">
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpanInvoice()">Buat Invoice</button>
            </div>
        </div>
    </div>
</div>

<script>
    let base_url = '<?php echo base_url(); ?>';
    let idMasterOrder = '<?php echo $this->uri->segment(3) ?>';
    let form = document.getElementById('frmBarang');
    let formOrder = document.getElementById('frmAddBarang');
    let formAturStock = document.getElementById('frmAturStock');
    let maxAmbil;
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
        getAturStock(idDetOrder);
        showTableAturStock(idDetOrder);
        $('#modalAturStock').modal('show');
    }

    function getAturStock(idDetOrder) {
        $.ajax({
            url: base_url + 'order/aturStock',
            type: 'POST',
            data: {
                idDetOrder: idDetOrder
            },
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                $('.description').val(data.getDetOrderById.description);
                $('.qtyOrder').val(data.getDetOrderById.qtyOrder);
                $('[name="idDetOrder"]').val(idDetOrder);
                let html;
                html = `<option value="">Pilih</option>`;
                for (let i = 0; i < data.getStockByIdBarang.length; i++) {
                    html += `<option value="${data.getStockByIdBarang[i].idStock}" data-qty-stock="${data.getStockByIdBarang[i].qtyStock}">${data.getStockByIdBarang[i].namaToko+' ['+data.getStockByIdBarang[i].qtyStock+']'}</option>`;
                }
                $('[name="pilihStock"]').html(html);
                $('[name="pilihStock"]').on('change', function() {
                    let selectedOption = $(this).find(':selected');
                    if (selectedOption.val()) {
                        // Approach 1: Using data attributes                        
                        let qtyStock = selectedOption.data('qty-stock');
                        maxAmbil = qtyStock;
                        // console.log(maxAmbil);
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function showTableAturStock(idDetOrder) {
        $.ajax({
            url: base_url + 'order/showStockIssued',
            type: 'POST',
            data: {
                idDetOrder: idDetOrder
            },
            dataType: 'JSON',
            success: function(data) {
                let html;
                $('#tbAturStock').html('');
                for (let i = 0; i < data.length; i++) {
                    html += `<tr>
                            <td>${data[i].namaToko}</td>
                            <td>${data[i].qtyIssued}</td>
                            <td>${data[i].createdAt}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="hapusAtur('${data[i].id}','${data[i].idDetOrder}')">X</button>
                            </td>
                        </tr>`;
                }
                $('#tbAturStock').html(html);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const atur = () => {
        if (formAturStock.checkValidity() == true) {
            let inputQty = $('[name="ambilStock"]').val();
            if (inputQty > maxAmbil) {
                alert('Ambil Stock melebihi Qty yang tersedia!');
            } else {
                $.ajax({
                    url: base_url + 'order/stockIssued',
                    type: 'POST',
                    data: $('#frmAturStock').serialize(),
                    dataType: 'JSON',
                    success: function(data) {
                        // location.reload();
                        $('[name="ambilStock"]').val('');
                        showTableAturStock(data.idDetOrder);
                        getAturStock(data.idDetOrder);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error get data from ajax');
                    }
                });
            }
        } else {
            formAturStock.reportValidity();
        }
    }

    const hapusAtur = (id, idDetOrder) => {
        let x = confirm('Hapus data ini ?');
        if (x) {
            $.ajax({
                url: base_url + 'order/hapusAtur',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'JSON',
                success: function(data) {
                    // location.reload();
                    showTableAturStock(idDetOrder);
                    getAturStock(idDetOrder);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    }
    const validasiStock = () => {
        let idDetOrder = $('[name="idDetOrder"]').val();
        // alert(idDetOrder);
        $.ajax({
            url: base_url + 'order/stockValidation',
            type: 'POST',
            data: {
                idDetOrder: idDetOrder
            },
            dataType: 'JSON',
            success: function(data) {
                location.reload();
                // console.log(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const editOrder = (idDetOrder) => {
        $.ajax({
            url: base_url + 'order/getDetOrderById',
            type: 'POST',
            data: {
                idDetOrder: idDetOrder
            },
            dataType: 'JSON',
            success: function(data) {
                console.log(data);
                $('[name="description"]').val(data.description);
                $('[name="qtyOrder"]').val(data.qtyOrder);
                $('[name="fixedPrice"]').val(data.fixedPrice);
                $('[name="idDetEdit"]').val(data.idDetOrder);
                $('#modalEdit').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const simpanEdit = () => {
        let frmEdit = document.getElementById('frmEdit');
        if (frmEdit.checkValidity() == true) {
            $.ajax({
                url: base_url + 'order/simpanEditOrder',
                type: 'POST',
                data: $('#frmEdit').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        } else {
            frmEdit.reportValidity();
        }
    }

    const buatInvoice = () => {
        $('#modalInvoice').modal('show');
    }

    $("#flexCheckDefault").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    const simpanInvoice = () => {
        $.ajax({
            url: base_url + 'order/genInvoice/' + idMasterOrder,
            type: 'POST',
            data: $('#frmInvoice').serialize(),
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                if (data === true) {
                    location.reload();
                } else {
                    alert('Pilih barang untuk di checklist dahulu');
                }
                // location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
</script>