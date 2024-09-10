<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4>Detail Invoice</h4>
                        <nav class="breadcrumb">
                            <a class="breadcrumb-item" href="<?php echo base_url() ?>">Dashboard</a>
                            <a class="breadcrumb-item" href="<?php echo base_url('invoice') ?>">Invoice</a>
                            <span class="breadcrumb-item active" aria-current="page">Detail Invoice</span>
                        </nav>
                    </div>
                    <table class="table table-light table-bordered table-sm">
                        <tbody>
                            <tr>
                                <td rowspan="2" class="fw-bold table-secondary align-middle" width="13%">Customer</td>
                                <td rowspan="2" class="align-middle" width="37%"><?php echo $getInvoiceById->companyName . ' / ' . $getInvoiceById->username ?></td>
                                <td class="fw-bold table-secondary">Total Bayar</td>
                                <td>IDR <?php echo number_format($total->totalBayar) ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold table-secondary">Tgl Invoice</td>
                                <td><?php echo date('d-m-Y', strtotime($getInvoiceById->createdAt)) ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold table-secondary" width="13%">PO Refrence</td>
                                <td width="37%"><?php echo $getInvoiceById->poRefrence ?></td>
                                <td class="fw-bold table-secondary">Tgl Tempo</td>
                                <td><?php echo date('d-m-Y', strtotime($getInvoiceById->dueDate)) ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold table-secondary">Invoice No.</td>
                                <td><?php echo strtoupper($getInvoiceById->idInvoice) ?></td>
                                <td class="fw-bold table-secondary">Tgl Bayar</td>
                                <td>
                                    <?php echo ($getInvoiceById->paymentDate == '0000=00=00') ? '<span class="text-danger fw-bold">Belum Bayar</span>' : $getInvoiceById->paymentDate ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold table-secondary">SuratJalan No.</td>
                                <td><?php echo strtoupper($getInvoiceById->idSuratJalan) ?></td>
                                <td class="fw-bold table-secondary">Status</td>
                                <td><?php echo $getInvoiceById->status ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold table-secondary">Master Order</td>
                                <td><?php echo strtoupper($getInvoiceById->idMasterOrder) ?></td>
                                <td class="fw-bold table-secondary">Ket Pembayaran</td>
                                <td><?php echo $getInvoiceById->paymentRemark ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" onclick="openKonfirmasi()" class="btn btn-primary mb-2">Konfirmasi Invoice</button>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <hr>
                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap table-sm">
                        <thead>
                            <tr class="fw-bold">
                                <td>No</td>
                                <td>Barang</td>
                                <td>Mat.Code</td>
                                <td>Tipe</td>
                                <td>Qty</td>
                                <td>Price</td>
                                <td>Total</td>
                                <td>Ket.</td>
                                <td>#</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($getInvoiceItemById as $data) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data->description ?></td>
                                    <td><?php echo $data->mcRefrence ?></td>
                                    <td><?php echo $data->type ?></td>
                                    <td><?php echo $data->qtyInvoice ?></td>
                                    <td><?php echo number_format($data->fixedPrice) ?></td>
                                    <td><?php echo number_format($data->qtyInvoice * $data->fixedPrice) ?></td>
                                    <td><?php echo $data->remark ?></td>
                                    <td>
                                        <?php if ($getInvoiceById->status == "PENDING") { ?>
                                            <button onclick="editItem('<?php echo $data->idDetInvoice ?>')" type="button" class="btn btn-success btn-sm"><i class="mdi mdi-pencil"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="hapusItem('<?php echo $data->idDetInvoice ?>')"><i class="mdi mdi-delete"></i></button>
                                        <?php } ?>
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

<div class="modal fade" id="modalKonfirmasi" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('invoice/konfirmasiInvoice/' . $this->uri->segment('3')) ?>" method="POST">
                    <div class="row mb-3">
                        <label for="dateInvoice" class="col-sm-3 col-form-label">Tgl Invoice</label>
                        <div class="col-sm-9">
                            <input type="date" name="createdAt" class="form-control" id="dateInvoice" value="<?php echo date('Y-m-d', strtotime($getInvoiceById->createdAt)) ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="paymentDate" class="col-sm-3 col-form-label">Tgl Tempo</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="paymentDate" value="<?php echo $getInvoiceById->dueDate ?>" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="paymentDate" class="col-sm-3 col-form-label">Tgl Bayar</label>
                        <div class="col-sm-9">
                            <input type="date" name="paymentDate" class="form-control" id="paymentDate" value="<?php echo $getInvoiceById->paymentDate ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="paymentDate" class="col-sm-3 col-form-label">Ket. Pembayaran</label>
                        <div class="col-sm-9">
                            <textarea name="paymentRemark" class="form-control" placeholder="Keterangan Pembayaran"><?php echo $getInvoiceById->paymentRemark ?></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="paymentDate" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" onclick="confirm('Konfirmasi invoice ini ?')">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('invoice/editItemInvoice') ?>" method="POST">
                    <div class="row mb-3">
                        <label for="dateInvoice" class="col-sm-3 col-form-label">Qty Item</label>
                        <div class="col-sm-9">
                            <input type="range" class="form-range" min="1" name="qtyInvoiceEdit" oninput="this.nextElementSibling.value = this.value" style="width: 80%;">
                            <output for="rangeInput" class="form-control-plaintext txtValue"></output>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <label for="dateInvoice" class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="idDetInvoice">
                            <input type="hidden" name="idInvoice">
                            <textarea name="remark" class="form-control" id="" placeholder="Keterangan Item"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let base_url = '<?php echo base_url() ?>';
    const openKonfirmasi = () => {
        $('#modalKonfirmasi').modal('show');
    }

    const editItem = (id) => {
        $.ajax({
            url: base_url + 'invoice/getItemById',
            type: 'POST',
            data: {
                IdDetInvoice: id
            },
            dataType: 'JSON',
            success: function(data) {
                console.log(data);
                $('#modalEdit').modal('show');
                $('#modalTitleId').text('Edit Item Invoice');
                $('[name="remark"]').text(data.datas.remark);
                $('[name="idDetInvoice"]').val(id);
                $('[name="idInvoice"]').val(data.datas.idInvoice);
                $('[name="qtyInvoiceEdit"]').attr("max", data.sisaMaxOrder);
                $('[name="qtyInvoiceEdit"]').val(data.datas.qtyInvoice);
                $('.txtValue').text(data.datas.qtyInvoice);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });

    }

    const hapusItem = (idDetInvoice) => {
        let x = confirm('Hapus item Invoice ?');
        if (x) {
            $.ajax({
                url: base_url + 'invoice/hapusItem',
                type: 'POST',
                data: {
                    idDetInvoice: idDetInvoice
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