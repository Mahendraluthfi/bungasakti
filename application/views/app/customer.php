<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4>Master Customer</h4>
                        <button type="button" class="btn btn-primary" onclick="add()"><span class="mdi mdi-plus"></span> Tambah Customer
                        </button>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                        <thead>
                            <th>No</th>
                            <th>Perusahaan</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>No HP/Telp</th>
                            <th>#</th>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($getAllCustomer as $data) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data->companyName ?></td>
                                    <td><?php echo $data->username ?></td>
                                    <td><?php echo $data->email ?></td>
                                    <td><?php echo $data->address ?></td>
                                    <td><?php echo $data->contactNumber ?></td>
                                    <td>
                                        <button type="button" onclick="get('<?php echo $data->idCustomer ?>')" class="btn btn-success btn-sm">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </button>
                                        <button type="button" onclick="deleteCustomer('<?php echo $data->idCustomer ?>')" class="btn btn-danger btn-sm">
                                            <i class="mdi mdi-delete"></i> Hapus
                                        </button>
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
                <form id="frmCustomer">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" required name="companyName" id="floatingCompany" placeholder="Nama Perusahaan">
                        <label for="floatingCompany">Nama Perusahaan</label>
                        <input type="hidden" name="idCustomer">
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" required name="username" id="floatingUsername" placeholder="Username">
                        <label for="floatingUsername">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" required name="email" id="floatingEmail" placeholder="Username">
                        <label for="floatingEmail">E-mail</label>
                    </div>
                    <div class="form-floating mb-3" id="sectionPassword">
                        <input type="password" class="form-control" required name="password" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="address" required placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                        <label for="floatingTextarea">Alamat Perusahaan</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" required name="contactNumber" id="floatingContact" placeholder="Username">
                        <label for="floatingContact">No HP/Telp</label>
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
    let base_url = '<?php echo base_url(); ?>';
    let save_method;
    const form = document.getElementById('frmCustomer');
    const add = () => {
        save_method = 'addCustomer';
        $('#modalTitleId').text('Tambah Customer Baru');
        $('#sectionPassword').removeAttr('style', 'display:none');
        $('#floatingPassword').removeAttr('required');
        form.reset();
        $('#modalId').modal('show');
    }

    const save = () => {

        if (form.checkValidity() == true) {
            $.ajax({
                url: base_url + 'customer/' + save_method,
                type: 'POST',
                data: $('#frmCustomer').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    (data === true) ? location.reload(): alert("Error menyimpan data");
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

    const get = (idCustomer) => {
        $.ajax({
            url: base_url + 'customer/getCustomerById',
            type: 'POST',
            data: {
                idCustomer: idCustomer
            },
            dataType: 'JSON',
            success: function(data) {
                $('#modalTitleId').text('Ubah Data Customer');
                $('[name="idCustomer"]').val(data.idCustomer);
                $('[name="address"]').val(data.address);
                $('#floatingCompany').val(data.companyName);
                $('#floatingContact').val(data.contactNumber);
                $('#floatingUsername').val(data.username);
                $('#floatingEmail').val(data.email);
                $('#floatingPassword').removeAttr('required');
                $('#sectionPassword').attr('style', 'display: none');
                save_method = 'updateCustomer';
                $('#modalId').modal('show');

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const deleteCustomer = (idCustomer) => {
        if (confirm('Apakah anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: base_url + 'customer/deleteCustomer',
                type: 'POST',
                data: {
                    idCustomer: idCustomer
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