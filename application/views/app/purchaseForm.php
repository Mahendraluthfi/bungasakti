<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4>Form - PR No. <?php echo strtoupper($getCurrentPurchase->idPR) ?></h4>
                        <nav class="breadcrumb">
                            <a class="breadcrumb-item" href="<?php echo base_url() ?>">Dashboard</a>
                            <a class="breadcrumb-item" href="<?php echo base_url('Purchase') ?>">Purchase Request</a>
                            <span class="breadcrumb-item active" aria-current="page">Form</span>
                        </nav>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <div class="table-responsive">
                        <table class="table table-light table-bordered table-sm">
                            <form id="frmPurchase">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold table-secondary" width="10%">Customer</td>
                                        <td><?php echo $getCurrentPurchase->companyName ?></td>
                                        <td class="fw-bold table-secondary">PR Status</td>
                                        <td><?php echo $getCurrentPurchase->status ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold table-secondary">Contact No</td>
                                        <td><?php echo $getCurrentPurchase->contactNumber ?></td>
                                        <td class="fw-bold table-secondary">Tanggal PR</td>
                                        <td><input type="date" name="datePR" value="<?php echo $getCurrentPurchase->datePR ?>" class="form-control form-control-sm">
                                            <input type="hidden" name="idPR" value="<?php echo $getCurrentPurchase->idPR ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold table-secondary">E-mail</td>
                                        <td><?php echo $getCurrentPurchase->email ?></td>
                                        <td class="fw-bold table-secondary">Prioritas</td>
                                        <td>
                                            <select name="priority" class="form-control" id="">
                                                <option value="">Pilih</option>
                                                <option <?php echo ($getCurrentPurchase->priority == "Urgent") ? "selected=''" : ""; ?> value="Urgent">Urgent</option>
                                                <option <?php echo ($getCurrentPurchase->priority == "Normal") ? "selected=''" : ""; ?> value="Normal">Normal</option>
                                                <option <?php echo ($getCurrentPurchase->priority == "Low") ? "selected=''" : ""; ?> value="Low">Low</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold table-secondary">Alamat</td>
                                        <td><?php echo $getCurrentPurchase->address ?></td>
                                        <td class="fw-bold table-secondary">Keterangan</td>
                                        <td><textarea name="remark" class="form-control" id=""><?php echo $getCurrentPurchase->remark ?></textarea></td>
                                    </tr>
                                </tbody>
                            </form>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <button type="button" class="btn btn-primary" onclick="addBarang()"><i class="mdi mdi-plus"></i> Tambah Barang</button>
                        <button type="button" class="btn btn-success" onclick="update()"><i class="mdi mdi-check"></i> Update</button>
                    </div>
                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Barang</td>
                                <td>Mat.Code</td>
                                <td>Custom Request</td>
                                <td>Qty</td>
                                <td>Tipe</td>
                                <td>Keterangan</td>
                                <td>#</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;

                            foreach ($getDetailPurchase as $data) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data->description ?></td>
                                    <td><?php echo $data->mcRefrence ?></td>
                                    <td><?php echo $data->descriptionCustom ?></td>
                                    <td><?php echo $data->qtyOrder ?></td>
                                    <td><?php echo $data->type ?></td>
                                    <td><?php echo $data->remark ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="get(<?php echo $data->idDetPR ?>)"><i class="mdi mdi-pencil"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteBarang(<?php echo $data->idDetPR ?>)"><i class="mdi mdi-trash-can"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <a href="<?php echo base_url('purchase/submitPR/' . $getCurrentPurchase->idPR) ?>" class="btn btn-dark mt-2" onclick="return confirm('Apakah anda yakin untuk Submit PR ini ?')">Submit PR</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
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
                                <option value="CUSTOM">Lainnya / Custom Barang</option>
                                <?php foreach ($getAllBarang as $data) { ?>
                                    <option value="<?php echo $data->idBarang ?>"><?php echo $data->description ?> / <?php echo $data->mcRefrence ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div id="contentCustom">
                        <div class="row mb-3">
                            <label for="customRequest" class="col-sm-3 col-form-label">Custom Request</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="idPR" value="<?php echo $getCurrentPurchase->idPR ?>">
                                <input type="hidden" name="idDetPR">
                                <textarea name="descriptionCustom" class="form-control" id="customRequest" placeholder="Masukan Custom Request"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputQty" class="col-sm-3 col-form-label">Qty</label>
                        <div class="col-sm-9">
                            <input type="number" name="qtyOrder" required class="form-control" min="0" id="inputQty" placeholder="Masukan Qty">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputRemark" class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-9">
                            <textarea name="remark" class="form-control" id="inputRemark" placeholder="Masukan Keterangan"></textarea>
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


<script>
    let base_url = '<?php echo base_url(); ?>';
    let save_method;
    let form = document.getElementById('frmAddBarang');

    // Get the select element and the content custom div
    let selectElement = document.getElementById('select-beast');
    let contentCustom = document.getElementById('contentCustom');
    contentCustom.style.display = 'none';
    selectElement.addEventListener('change', function() {
        if (this.value === 'CUSTOM') {
            contentCustom.style.display = 'block';
            $('[name="descriptionCustom"]').attr('required', 'required');
        } else {
            contentCustom.style.display = 'none';
            $('[name="descriptionCustom"]').removeAttr('required', 'required');
        }
    });

    const addBarang = () => {
        $('#modalTitleId').text('Tambah Data Barang');
        save_method = 'addDetBarang';
        $('#frmAddBarang')[0].reset();
        $('#modalId').modal('show');
    }

    const save = () => {
        if (form.checkValidity() == true) {
            $.ajax({
                url: base_url + 'purchase/' + save_method,
                type: 'POST',
                data: $('#frmAddBarang').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    // console.log(data);
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

    const get = (idDetPR) => {
        $.ajax({
            url: base_url + 'purchase/getDetPRbyID',
            type: 'POST',
            data: {
                idDetPR: idDetPR
            },
            dataType: 'JSON',
            success: function(data) {
                $('#frmAddBarang')[0].reset();
                $('#modalTitleId').text('Edit Data Barang');
                save_method = 'updateDetBarang';
                let selectElement = document.getElementById('select-beast');

                // Check if TomSelect instance already exists
                let selectInstance = selectElement.tomselect;
                if (!selectInstance) {
                    // Initialize TomSelect plugin
                    selectInstance = new TomSelect(selectElement, {
                        create: false,
                        sortField: {
                            field: 'text',
                            direction: 'asc'
                        }
                    });
                }

                // Set the selected value in the TomSelect plugin
                selectInstance.setValue((data.idBarang == null) ? 'CUSTOM' : data.idBarang);
                if (data.idBarang == null) {
                    contentCustom.style.display = 'block';
                    $('[name="descriptionCustom"]').attr('required', 'required');
                } else {
                    contentCustom.style.display = 'none';
                    $('[name="descriptionCustom"]').removeAttr('required', 'required');
                }
                $('[name="idDetPR"]').val(idDetPR);
                $('[name="descriptionCustom"]').val(data.descriptionCustom);
                $('#inputQty').val(data.qtyOrder);
                $('#inputRemark').val(data.remark);
                $('#modalId').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const deleteBarang = (idDetPR) => {
        let x = confirm('Hapus data ini ?');
        if (x) {
            $.ajax({
                url: base_url + 'purchase/deleteDetPR',
                type: 'POST',
                data: {
                    idDetPR: idDetPR
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

    const update = () => {
        $.ajax({
            url: base_url + 'purchase/updateForm',
            type: 'POST',
            data: $('#frmPurchase').serialize(),
            dataType: 'JSON',
            success: function(data) {
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
</script>