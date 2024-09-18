<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">

            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4><?php echo ($this->uri->segment('3') ? 'Edit' : 'Tambah') ?> Pembelian - ID <?php echo $idPembelian ?></h4>
                        <nav class="breadcrumb">
                            <a class="breadcrumb-item" href="<?php echo base_url('appHome') ?>">Dashboard</a>
                            <a class="breadcrumb-item" href="<?php echo base_url('pembelian') ?>">Pembelian</a>
                            <span class="breadcrumb-item active" aria-current="page">Edit Pembelian</span>
                        </nav>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <div class="table-responsive">
                        <table class="table table-light table-bordered table-sm">
                            <form id="frmPembelian">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold table-secondary" width="13%">Toko</td>
                                        <td width="37%">
                                            <select name="idToko" class="form-control" required>
                                                <option value="">Pilih Toko</option>
                                                <?php foreach ($getAllToko as $data) { ?>
                                                    <option value="<?php echo $data->idToko ?>" <?php echo ($data->idToko == $getPending->idToko) ? 'selected' : '' ?>><?php echo $data->namaToko ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td class="fw-bold table-secondary">User</td>
                                        <td>
                                            <input type="hidden" name="idPembelian" value="<?php echo $idPembelian ?>">
                                            <input type="text" class="form-control" readonly value="<?php echo $getPending->name ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold table-secondary">Tanggal Pembelian</td>
                                        <td>
                                            <input type="date" class="form-control" required name="issuingDate" value="<?php echo $getPending->issuingDate ?>">
                                        </td>
                                        <td class="fw-bold table-secondary">Keterangan</td>
                                        <td>
                                            <textarea name="remark" class="form-control" placeholder="Keterangan"><?php echo $getPending->remark ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold table-secondary">Ref. Nota</td>
                                        <td>
                                            <input type="text" name="notaRefrence" class="form-control" placeholder="Refrensi Nota" value="<?php echo $getPending->notaRefrence ?>">
                                        </td>
                                        <td class="fw-bold table-secondary">Created At</td>
                                        <td>
                                            <?php echo date('d-m-Y H:i:s', strtotime($getPending->createdAt)) ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </form>
                        </table>
                        <button type="button" class="btn btn-primary btn-sm my-3" onclick="addBarang()"><i class="mdi mdi-plus"></i>Tambah Barang Pembelian</button>

                        <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap table-sm">
                            <thead>
                                <tr class="fw-bold">
                                    <td>No</td>
                                    <td>Barang</td>
                                    <td>Qty</td>
                                    <td class="text-end">Harga</td>
                                    <td class="text-end">Total</td>
                                    <td class="text-center">#</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($getItem as $data) { ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $data->description ?></td>
                                        <td><?php echo $data->qty ?></td>
                                        <td class="text-end"><?php echo number_format($data->price) ?></td>
                                        <td class="text-end"><?php echo number_format($data->total) ?></td>
                                        <td class="text-center">
                                            <button type="button" onclick="hapus('<?php echo $data->idDetPembelian ?>','<?php echo $data->idPembelian ?>')" class="btn btn-danger btn-sm">Hapus</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success mt-2" onclick="submitPembelian('<?php echo $idPembelian ?>')"><i class="mdi mdi-download"></i> Simpan Pembelian</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div
        class="modal-dialog"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Tambah Barang Pembelian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmItem">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Barang</label>
                        <div class="col-sm-10">
                            <select name="idBarang" id="select-beast" required>
                                <option value="">Pilih Barang</option>
                                <?php foreach ($readyBarang as $data) { ?>
                                    <option value="<?php echo $data->idBarang ?>"><?php echo $data->description ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Qty</label>
                        <div class="col-sm-10">
                            <input type="hidden" name="idPembelianItem" value="<?php echo $idPembelian ?>">
                            <input type="number" name="qty" class="form-control" required min="1" placeholder="Quantity">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-10">
                            <input type="number" name="price" class="form-control" min="1" placeholder="Harga">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addItem()">Tambah</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Tutup </button>
            </div>
        </div>
    </div>
</div>

<script>
    let base_url = '<?php echo base_url() ?>';
    let formPembelian = document.getElementById('frmPembelian');
    let formItem = document.getElementById('frmItem');

    const addBarang = () => {
        if (simpanPembelian()) {
            $('#modalId').modal('show');
        }
    }

    const addItem = () => {
        if (formItem.checkValidity()) {
            $.ajax({
                url: base_url + 'pembelian/addItem',
                type: 'POST',
                data: $('#frmItem').serialize(),
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
            formItem.reportValidity();
        }
    }

    function simpanPembelian() {
        if (formPembelian.checkValidity()) {
            $.ajax({
                url: base_url + 'pembelian/updatePembelian',
                type: 'POST',
                data: $('#frmPembelian').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    // console.log(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
            return true;
        } else {
            $('#modalId').modal('hide');
            formPembelian.reportValidity();
            return false;
        }
    }

    const submitPembelian = (idPembelian) => {
        let x = confirm('Apakah anda yakin simpan data ini ?');
        if (x) {
            simpanPembelian();
            $.ajax({
                url: base_url + 'pembelian/submitPembelian',
                type: 'POST',
                data: {
                    idPembelian: idPembelian
                },
                dataType: 'JSON',
                success: function(data) {
                    location.href = base_url + 'pembelian';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    }

    const hapus = (id, idPembelian) => {
        let x = confirm('Hapus Data ini ?');
        if (x) {
            $.ajax({
                url: base_url + 'pembelian/hapusItem',
                type: 'POST',
                data: {
                    idDetPembelian: id,
                    idPembelian: idPembelian
                },
                dataType: 'JSON',
                success: function(data) {
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    }
</script>