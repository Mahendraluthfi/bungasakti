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
                    <table id="scroll-horizontal-datatable-zero" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>ID_PR</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th width="20%">Keterangan</th>
                                <th>Status</th>
                                <th>Last_Update</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($getAllPurchase as $data) { ?>
                                <tr>
                                    <td><?php echo $data->idPR ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($data->createdAt)) ?></td>
                                    <td><?php echo $data->companyName . ' / ' . $data->username ?></td>
                                    <td><?php echo $data->remark ?></td>
                                    <td><?php echo $data->status ?></td>
                                    <td><?php echo $data->updatedAt ?></td>
                                    <td>

                                        <button type="button" onclick="get('<?php echo $data->idPR ?>')" class="btn btn-info btn-sm mr-1" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Detail Barang / Proses Order" tabindex="0"><i class="mdi mdi-eye"></i></button>
                                        <a href="<?php echo base_url('purchase/formEdit/' . $data->idPR) ?>" class="btn btn-warning btn-sm mr-1" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Edit Barang" tabindex="0"><i class="mdi mdi-pencil"></i></a>
                                        <?php //if ($data->status == "PENDING" || $data->status == "SUBMIT") { 
                                        ?>
                                        <?php //} 
                                        ?>
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
                                    <option value="<?php echo $data->idCustomer ?>"><?php echo $data->companyName . ' / ' . $data->username ?></option>
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
                <div id="btnProcced"></div>
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
                                <td>Mat. Code</td>
                                <td>Qty</td>
                                <td>Uom</td>
                                <td>Est. Price</td>
                                <td>Tipe</td>
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
                // console.log(data);                
                $('#btnProcced').html('');
                $('#showData').html('');
                if (data.getPRbyId.status == 'SUBMIT') {
                    $('#btnProcced').html('<button type="button" onclick="procced(\'' + data.getPRbyId.idPR + '\')" class="btn btn-success mb-2"><i class="mdi mdi-cart-arrow-down"></i> Proses to Order</button>');
                } else {
                    $('#btnProcced').html('');
                }

                // $('#modalTitleId').text('Detail PR'+ data.get
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
                    let namaBarang = data.getDetailPurchase[i].description ? data.getDetailPurchase[i].description : data.getDetailPurchase[i].descriptionCustom;
                    let type = (data.getDetailPurchase[i].type) ? data.getDetailPurchase[i].type : 'REQUEST';
                    let mcCode = (data.getDetailPurchase[i].mcRefrence) ? data.getDetailPurchase[i].mcRefrence : '';
                    html += '<tr>' +
                        '<td>' + no++ + '</td>' +
                        '<td>' + namaBarang + '</td>' +
                        '<td>' + mcCode + '</td>' +
                        '<td>' + data.getDetailPurchase[i].qtyOrder + '</td>' +
                        '<td>' + data.getDetailPurchase[i].uom + '</td>' +
                        '<td>' + data.getDetailPurchase[i].estimatedPrice + '</td>' +
                        '<td>' + type + '</td>' +
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

    const procced = (idPR) => {
        let x = confirm('Proses PR ini ke transaksi Order ?');
        if (x) {
            // alert('OK');
            $.ajax({
                url: base_url + 'purchase/proccedOrder',
                type: 'POST',
                data: {
                    idPR: idPR,
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