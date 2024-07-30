<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4>Master Barang</h4>
                        <button type="button" class="btn btn-primary" onclick="add()"><span class="mdi mdi-plus"></span> Tambah Barang
                        </button>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                        <thead>
                            <th>No</th>
                            <th>Deskripsi</th>
                            <th>Barcode</th>
                            <th>MC</th>
                            <th>Uom</th>
                            <th>Stock</th>
                            <th>Type</th>
                            <th>Harga</th>
                            <th>#</th>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($getAllBarang as $data) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data->description ?></td>
                                    <td><?php echo $data->barcode ?></td>
                                    <td><?php echo $data->mcRefrence ?></td>
                                    <td><?php echo $data->uom ?></td>
                                    <td><?php echo $data->totalStock ?></td>
                                    <td><?php echo $data->type ?></td>
                                    <td><?php echo $data->basePrice ?></td>
                                    <td>
                                        <button type="button" tabindex="0" onclick="get('<?php echo $data->idBarang ?>')" class="btn btn-info btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Edit Barang"><span class="mdi mdi-pencil"></span></button>
                                        <button type="button" tabindex="0" onclick="viewKartuStok('<?php echo $data->idBarang ?>')" class="btn btn-secondary btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Lihat Detail Stock"><span class="mdi mdi-barcode-scan"></span></button>
                                        <button type="button" tabindex="0" onclick="deleteBarang('<?php echo $data->idBarang ?>')" class="btn btn-danger btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Hapus Barang"><span class="mdi mdi-trash-can"></span></button>

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

<div class="modal fade" id="modalId" tabindex="-1" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmBarang">
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="description" required placeholder="Nama Barang" id="floatingDescription"></textarea>
                        <label for="floatingDescription">Nama Barang / Deskripsi</label>
                        <input type="hidden" name="idBarang">
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
                            <option selected="">Pilih</option>
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
                <button type="button" class="btn btn-primary" onclick="save()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    let base_url = '<?php echo base_url() ?>';
    let save_method;
    let form = document.getElementById('frmBarang');
    const add = () => {
        $('#modalId').modal('show');
        $('#modalTitleId').text('Tambah Barang');
        $('#frmBarang')[0].reset();
        save_method = 'addBarang';
    }

    const save = () => {
        if (form.checkValidity() == true) {
            $.ajax({
                url: base_url + 'barang/' + save_method,
                type: 'POST',
                data: $('#frmBarang').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    (data === true) ? location.reload(): alert('Error menyimpan data');
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

    const get = (idBarang) => {
        $.ajax({
            url: base_url + 'barang/getBarangById',
            type: 'POST',
            data: {
                idBarang: idBarang
            },
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                $('#modalId').modal('show');
                $('#modalTitleId').text('Edit Barang');
                $('#floatingDescription').val(data.description);
                $('#floatingBarcode').val(data.barcode);
                $('#floatingMC').val(data.mcRefrence);
                $('#floatingUom').val(data.uom);
                $('#floatingType').val(data.type);
                $('#floatingType').trigger('change');
                $('#floatingBasePrice').val(data.basePrice);
                save_method = 'updateBarang';
                $('[name="idBarang"]').val(data.idBarang);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    const deleteBarang = (idBarang) => {
        if (confirm('Apakah anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: base_url + 'barang/deleteBarang',
                type: 'POST',
                data: {
                    idBarang: idBarang
                },
                dataType: 'JSON',
                success: function(data) {
                    (data === true) ? location.reload(): alert('Error menghapus data');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    }
</script>