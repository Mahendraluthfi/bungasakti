<div class="container mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4>Master Toko</h4>
                        <button type="button" class="btn btn-primary" onclick="add()"><span class="mdi mdi-plus"></span> Tambah Toko
                        </button>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Toko</th>
                                <th>Toko</th>
                                <th>Alamat</th>
                                <th>Last Active</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($getAllToko as $data) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data->idToko ?></td>
                                    <td><?php echo $data->namaToko ?></td>
                                    <td><?php echo $data->address ?></td>
                                    <td><?php echo $data->lastActive ?></td>
                                    <td>
                                        <button type="button" onclick="get('<?php echo $data->idToko ?>')" class="btn btn-success btn-sm">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </button>
                                        <button type="button" onclick="deleteToko('<?php echo $data->idToko ?>')" class="btn btn-danger btn-sm">
                                            <i class="mdi mdi-delete"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div><!-- end card body -->
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
                <form id="frmToko">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" required name="namaToko" id="floatingNama" placeholder="Username">
                        <input type="hidden" name="idToko">
                        <label for="floatingNama">Nama Toko</label>
                    </div>
                    <div class="form-floating">
                        <textarea class="form-control" name="address" required placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                        <label for="floatingTextarea">Alamat</label>
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

<!-- Optional: Place to the bottom of scripts -->
<script>
    let base_url = '<?php echo base_url() ?>';
    let save_method;

    const form = document.getElementById('frmToko');

    const add = () => {
        save_method = 'saveToko';
        $('#modalTitleId').text('Tambah Toko Baru');
        $('#modalId').modal('show');
        form.reset();
    }

    const save = () => {
        if (form.checkValidity()) {
            $.ajax({
                url: base_url + 'toko/' + save_method,
                type: 'POST',
                data: $('#frmToko').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    (data === true) ? location.reload(): alert("Error menyimpan data");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        } else {
            form.reportValidity();
        }
    }

    const get = (idToko) => {
        $.ajax({
            url: base_url + 'toko/getTokoById',
            type: 'POST',
            data: {
                idToko: idToko
            },
            dataType: 'JSON',
            success: function(data) {
                $('[name="idToko"]').val(data.idToko);
                $('#floatingTextarea').val(data.address);
                $('#floatingNama').val(data.namaToko);
                save_method = 'updateToko';
                $('#modalTitleId').text('Edit Data Toko');
                $('#modalId').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const deleteToko = ($idToko) => {
        let x = confirm('Anda yakin menghapus data ini ?');
        if (x) {
            $.ajax({
                url: base_url + 'toko/deleteToko',
                type: 'POST',
                data: {
                    idToko: $idToko
                },
                dataType: 'JSON',
                success: function(data) {
                    (data === true) ? location.reload(): alert("Error menghapus data");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    }
</script>