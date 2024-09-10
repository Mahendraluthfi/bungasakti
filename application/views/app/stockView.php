<style>
    .range-container {
        position: relative;
        width: 300px;
        margin: 10px auto;
    }

    .range-input {
        width: 100%;
        -webkit-appearance: none;
        background: #ddd;
        outline: none;
        height: 6px;
        border-radius: 3px;
    }

    .range-input::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #4CAF50;
        cursor: pointer;
    }

    .range-input::-moz-range-thumb {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #4CAF50;
        cursor: pointer;
    }

    .range-value {
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #4CAF50;
        color: white;
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 14px;
    }
</style>
<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4>Stock - <?php echo $getNamaToko ?></h4>
                        <nav class="breadcrumb">
                            <a class="breadcrumb-item" href="<?php echo base_url() ?>">Dashboard</a>
                            <a class="breadcrumb-item" href="<?php echo base_url('Stock') ?>">Stock Toko</a>
                            <span class="breadcrumb-item active" aria-current="page"><?php echo $getNamaToko ?></span>
                        </nav>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary btn-sm mb-2" onclick="addStock()"><i class="mdi mdi-plus"></i> Tambah Stock Barang</button>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Deskripsi</th>
                                <th>Satuan Unit</th>
                                <th>Qty Stock</th>
                                <th>Tipe</th>
                                <th>Last_Update</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($getStockByToko as $data) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data->description ?></td>
                                    <td><?php echo $data->uom ?></td>
                                    <td><?php echo $data->qtyStock ?></td>
                                    <td><?php echo $data->type ?></td>
                                    <td><?php echo $data->updatedAt ?></td>
                                    <td>
                                        <button type="button" onclick="historyPembelian('<?php echo $data->idStock ?>')" class="btn btn-warning btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="History Pembelian" tabindex="0"><i class="mdi mdi-history"></i></button>
                                        <button type="button" onclick="detailStock('<?php echo $data->idBarang ?>')" class="btn btn-success btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Detail Barang" tabindex="0"><i class="mdi mdi-details"></i></button>
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Transfer Stok Barang" tabindex="0" onclick="transferBarang('<?php echo $data->idStock ?>')"><i class="mdi mdi-truck"></i></button>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <hr>
                    <h4>History Pembelian Barang - <?php echo $getNamaToko ?></h4>
                    <table id="scroll-horizontal-datatable2" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>idPembelian</th>
                                <th>Tanggal</th>
                                <th>Refrensi Nota</th>
                                <th>Keterangan</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div><!-- end card body -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalId" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmStock">
                    <div class="row mb-3">
                        <label for="inputIdBarang" class="col-sm-3 col-form-label">Barang</label>
                        <div class="col-sm-9">
                            <select name="idBarang" required id="select-beast">
                                <option value="">Pilih</option>
                                <?php foreach ($getAllBarang as $data) { ?>
                                    <option value="<?php echo $data->idBarang ?>"><?php echo $data->description . ' / ' . $data->mcRefrence ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="qtyStock" class="col-sm-3 col-form-label">Qty Stock</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="idToko" value="<?php echo $this->uri->segment(3) ?>">
                            <input type="number" required min="1" name="qtyStock" class="form-control" placeholder="Qty Stock">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="save()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTransfer" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Transfer Barang ke Toko Lain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmTransfer" method="POST" action="<?php echo  base_url('stock/transferStock') ?>">
                    <div class="row mb-3">
                        <label for="inputIdBarang" class="col-sm-3 col-form-label">Barang</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="idStock">
                            <input type="hidden" name="stockFrom" value="<?php echo $this->uri->segment(3) ?>">
                            <input type="text" disabled class="form-control" name="description">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="qtyStock" class="col-sm-3 col-form-label">Qty Stock</label>
                        <div class="col-sm-9">
                            <div class="range-container">
                                <input type="range" name="qtyTransfer" min="1" value="1" class="range-input" id="myRange">
                                <div class="range-value" id="rangeValue">1</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="qtyStock" class="col-sm-3 col-form-label">Tujuan Toko</label>
                        <div class="col-sm-9">
                            <select name="tokoTujuan" class="form-control" id="" required>
                                <option value="">Pilih Toko</option>
                                <?php foreach ($tokoDestination as $data) { ?>
                                    <option value="<?php echo $data->idToko ?>"><?php echo $data->namaToko ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="qtyStock" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Detail Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td class="fw-bold table-secondary">Desckripsi</td>
                            <td><span class="description"></span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold table-secondary">Barcode</td>
                            <td><span class="barcode"></span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold table-secondary">Mat. Code</td>
                            <td><span class="mcRefrence"></span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold table-secondary">UoM</td>
                            <td><span class="uom"></span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold table-secondary">Tipe</td>
                            <td><span class="type"></span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold table-secondary">Harga</td>
                            <td><span class="basePrice"></span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold table-secondary">Total Stock</td>
                            <td><span class="qtyTotal"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    let base_url = '<?php echo base_url() ?>';
    let save_method;
    let form = document.getElementById('frmStock');
    let formTransfer = document.getElementById('frmTransfer');

    const addStock = () => {
        $('#modalId').modal('show');
        form.reset();
        save_method = 'addStock';
        $('#modalTitleId').text('Tambah Stock Barang');
    }

    const save = () => {
        if (form.checkValidity() == true) {
            $.ajax({
                url: base_url + 'stock/' + save_method,
                type: 'POST',
                data: $('#frmStock').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    location.reload();
                    // console.log(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        } else {
            form.reportValidity();
        }
    }

    const detailStock = (idBarang) => {
        $.ajax({
            url: base_url + 'stock/detailStock',
            type: 'POST',
            data: {
                idBarang: idBarang
            },
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                $('.description').text(data.data.description);
                $('.uom').text(data.data.uom);
                $('.type').text(data.data.type);
                $('.basePrice').text(data.data.basePrice);
                $('.mcRefrence').text(data.data.mcRefrence);
                $('.barcode').text(data.data.barcode);
                $('.qtyTotal').text(data.qty.qty);

                $('#modalDetail').modal('show');

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const transferBarang = (idStock) => {
        $.ajax({
            url: base_url + 'stock/getIdStock',
            type: 'POST',
            data: {
                idStock: idStock
            },
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                $('[name="description"]').val(data.description);
                $('[name="idStock"]').val(data.idStock);
                $('[name="qtyTransfer"]').attr('max', data.qtyStock);
                $('#modalTransfer').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const range = document.getElementById('myRange');
    const rangeValue = document.getElementById('rangeValue');

    function updateValue() {
        const value = range.value;
        rangeValue.textContent = value;
        const percent = (value - range.min) / (range.max - range.min) * 100;
        rangeValue.style.left = `${percent}%`;
    }

    range.addEventListener('input', updateValue);
    updateValue(); // Initialize the value display
</script>