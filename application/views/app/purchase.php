<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4>Purchase Request</h4>
                        <button type="button" class="btn btn-primary btn-sm mb-3" onclick="openModal()"><i class="mdi mdi-plus"></i> Tambah Data</button>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <table id="scroll-horizontal-datatable-zero" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th>ID_PR</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Last_Update</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($getAllPurchase as $data) { ?>
                                <tr>
                                    <td><?php echo $data->idPR ?></td>
                                    <td><?php echo $data->datePR ?></td>
                                    <td><?php echo $data->companyName ?></td>
                                    <td><?php echo $data->remark ?></td>
                                    <td><?php echo $data->status ?></td>
                                    <td><?php echo $data->updatedAt ?></td>
                                    <td>
                                        <button type="button" onclick="get('<?php echo $data->idPR ?>')" class="btn btn-info btn-sm mr-1" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Detail Barang" tabindex="0"><i class="mdi mdi-eye"></i></button>
                                        <?php if ($data->status == "PENDING" || $data->status == "SUBMIT") { ?>
                                            <a href="<?php echo base_url('purchase/formEdit/' . $data->idPR) ?>" class="btn btn-warning btn-sm mr-1" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Edit Barang" tabindex="0"><i class="mdi mdi-pencil"></i></a>
                                        <?php } ?>
                                        <button type="button" onclick="hapus('<?php echo $data->idPR ?>','<?php echo $data->status ?>')" class="btn btn-danger btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Hapus Barang" tabindex="0"><i class="mdi mdi-delete"></i></button>
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


<!-- Modal -->
<div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Purchase Request Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-2">
                        <label for="inputCustomer" class="col-sm-2 col-md-3 col-form-label">Customer</label>
                        <div class="col-sm-9 col-md-9">
                            <select name="idCustomer" id="select-beast" onchange="pickCustomer(this)">
                                <option value="">Pilih Customer</option>
                                <?php foreach ($getAllCustomer as $data) { ?>
                                    <option value="<?php echo $data->idCustomer ?>"><?php echo $data->companyName ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
                <div class="page-content"></div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title-text" id="modalTitleId"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-light table-bordered table-sm">
                        <form id="frmPurchase">
                            <tbody>
                                <tr>
                                    <td class="fw-bold table-secondary" width="10%">Customer</td>
                                    <td><span class="companyName"></span></td>
                                    <td class="fw-bold table-secondary">PR Status</td>
                                    <td><span class="status"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold table-secondary">Contact No</td>
                                    <td><span class="contactNumber"></span></td>
                                    <td class="fw-bold table-secondary">Tanggal PR</td>
                                    <td><span class="datePR"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold table-secondary">E-mail</td>
                                    <td><span class="email"></span></td>
                                    <td class="fw-bold table-secondary">Prioritas</td>
                                    <td><span class="priority"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold table-secondary">Alamat</td>
                                    <td><span class="address"></span></td>
                                    <td class="fw-bold table-secondary">Keterangan</td>
                                    <td><span class="remark"></span></td>
                                </tr>
                            </tbody>
                        </form>
                    </table>
                    <hr class="my-1">
                    <table class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Barang</td>
                                <td>Custom Request</td>
                                <td>Qty</td>
                                <td>Keterangan</td>
                            </tr>
                        </thead>
                        <tbody id="showData"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Place to the bottom of scripts -->
<script>
    const myModal = new bootstrap.Modal(
        document.getElementById("modalId"),
        options,
    );
</script>


<script>
    let base_url = '<?php echo base_url(); ?>';

    const openModal = () => {
        $('#modalId').modal('show');
    }

    const pickCustomer = (select) => {
        let idCustomer = select.value;
        // let customerName = select.options[select.selectedIndex].text;
        window.location.href = '<?php echo base_url('purchase/form/'); ?>' + idCustomer;
    }

    const get = (idPR) => {
        $.ajax({
            url: base_url + 'purchase/getDetailPR',
            type: 'POST',
            data: {
                idPR: idPR,
            },
            dataType: 'JSON',
            success: function(data) {
                console.log(data);
                $('.title-text').text('Detail PR ' + data.getPRbyId.idPR);
                $('.companyName').text(data.getPRbyId.companyName);
                $('.email').text(data.getPRbyId.email);
                $('.contactNumber').text(data.getPRbyId.contactNumber);
                $('.datePR').text(data.getPRbyId.datePR);
                $('.status').text(data.getPRbyId.status);
                $('.remark').text(data.getPRbyId.remark);
                $('.priority').text(data.getPRbyId.priority);
                $('.address').text(data.getPRbyId.address);
                let html;
                let no = 1;
                for (let i = 0; i < data.getDetailPurchase.length; i++) {
                    let namaBarang = data.getDetailPurchase[i].description ? data.getDetailPurchase[i].description : '';
                    let namaBarangCustom = data.getDetailPurchase[i].descriptionCustom ? data.getDetailPurchase[i].descriptionCustom : '';
                    html += '<tr>' +
                        '<td>' + no++ + '</td>' +
                        '<td>' + namaBarang + '</td>' +
                        '<td>' + namaBarangCustom + '</td>' +
                        '<td>' + data.getDetailPurchase[i].qtyOrder + '</td>' +
                        '<td>' + data.getDetailPurchase[i].remark + '</td>' +
                        '</tr>';
                }
                $('#showData').html(html);
                $('#modalDetail').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const hapus = (idPR, status) => {
        let confirmDelete = confirm('Anda yakin ingin menghapus PR ini?');
        if (confirmDelete) {
            $.ajax({
                url: base_url + 'purchase/hapusPR',
                type: 'POST',
                data: {
                    idPR: idPR,
                    status: status,
                },
                dataType: 'JSON',
                success: function(data) {
                    // alert('Data PR berhasil dihapus');
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    }
</script>