<div class="container mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4>Master User</h4>
                        <button type="button" class="btn btn-primary" onclick="add()"><span class="mdi mdi-plus"></span> Tambah User
                        </button>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Toko</th>
                                <th>Level</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($getAllUsers as $data) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data->name ?></td>
                                    <td><?php echo $data->username ?></td>
                                    <td><?php echo $data->namaToko ?></td>
                                    <td><?php echo $data->level ?></td>
                                    <td>
                                        <button type="button" onclick="get('<?php echo $data->idUser ?>')" class="btn btn-success btn-sm">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </button>
                                        <button type="button" onclick="deleteUser('<?php echo $data->idUser ?>')" class="btn btn-danger btn-sm">
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
                <form id="frmUser">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" required name="name" id="floatingNama" placeholder="Username">
                        <label for="floatingNama">Nama Lengkap</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" required name="username" id="floatingUsername" placeholder="Username">
                        <input type="hidden" name="idUser">
                        <label for="floatingUsername">Username</label>
                    </div>
                    <p id="error-message" class="text-danger"></p>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" required name="password" id="floatingPassword" placeholder="Username">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="level" required id="floatingSelect" aria-label="Floating label select example">
                            <option selected="">Pilih</option>
                            <option value="KASIR">KASIR</option>
                            <option value="ADMIN">ADMIN</option>
                        </select>
                        <label for="floatingSelect">Pilih Level User</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="idToko" id="floatingToko" aria-label="Floating label select example">
                            <option selected value="">Pilih</option>
                            <?php foreach ($getAllToko as $data) { ?>
                                <option value="<?php echo $data->idToko ?>"><?php echo $data->namaToko ?></option>
                            <?php } ?>
                        </select>
                        <label for="floatingToko">Pilih Lokasi Toko</label>
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

    let userId;
    const form = document.getElementById('frmUser');

    const add = () => {
        save_method = 'saveUser';
        $('#modalTitleId').text('Tambah User Baru');
        $('#floatingPassword').removeAttr('disabled', 'disabled');
        $('#modalId').modal('show');
        form.reset();
    }

    const save = () => {
        if (form.checkValidity()) {
            $.ajax({
                url: base_url + 'user/' + save_method,
                type: 'POST',
                data: $('#frmUser').serialize(),
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

    const get = (idUser) => {
        $.ajax({
            url: base_url + 'user/getUserById',
            type: 'POST',
            data: {
                idUser: idUser
            },
            dataType: 'JSON',
            success: function(data) {
                $('[name="idUser"]').val(data.idUser);
                $('#floatingUsername').val(data.username);
                $('#floatingNama').val(data.name);
                $('#floatingPassword').attr('disabled', 'disabled');
                $('#floatingSelect').val(data.level);
                $('#floatingSelect').trigger('change');
                $('#floatingToko').val(data.idToko);
                $('#floatingToko').trigger('change');
                save_method = 'editUser';
                $('#modalTitleId').text('Edit Data User');
                $('#modalId').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const deleteUser = ($idUser) => {
        let x = confirm('Anda yakin menghapus data ini ?');
        if (x) {
            $.ajax({
                url: base_url + 'user/deleteUser',
                type: 'POST',
                data: {
                    idUser: $idUser
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