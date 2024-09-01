<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4>Master Invoice</h4>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Customer</th>
                                <th>No.Invoice</th>
                                <th>PO Vendor</th>
                                <th>ID_MasterOrder</th>
                                <th>Tanggal</th>
                                <th>Tempo</th>
                                <th>Total</th>
                                <th>Tgl Bayar</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($getAllInvoice as $data) {
                                $date = date('Y-m-d');
                            ?>
                                <tr class="<?php echo ($data->dueDate < $date && $data->status == "PENDING") ? 'table-danger' : '' ?>">
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data->companyName ?></td>
                                    <td><?php echo $data->idInvoice ?></td>
                                    <td><?php echo $data->poRefrence ?></td>
                                    <td>
                                        <button type="button" class="btn btn-light btn-sm" onclick="viewOrder('<?php echo $data->idMasterOrder ?>')">
                                            <?php echo $data->idMasterOrder ?>
                                        </button>
                                    </td>
                                    <td><?php echo date('Y-m-d', strtotime($data->createdAt)) ?></td>
                                    <td><?php echo $data->dueDate ?></td>
                                    <td><?php echo number_format($data->sumTotal->totalBayar) ?></td>
                                    <td><?php echo ($data->paymentDate == '0000-00-00') ? '' : $data->paymentDate ?></td>
                                    <td><?php echo $data->status ?></td>
                                    <td>
                                        <a href="<?php echo base_url('invoice/editInvoice/' . $data->idInvoice) ?>" class="btn btn-success btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Edit Invoice" tabindex="0"><i class="mdi mdi-pencil"></i></a>
                                        <a href="<?php echo base_url('invoice/cetakInvoice/' . $data->idInvoice) ?>" class="btn btn-primary btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Cetak Invoice" tabindex="0"><i class="mdi mdi-invoice-list-outline"></i></a>
                                        <a href="<?php echo base_url('invoice/cetakSuratJalan/' . $data->idInvoice) ?>" class="btn btn-warning btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Cetak Surat Jalan" tabindex="0"><i class="mdi mdi-truck-delivery"></i></a>
                                        <?php if ($data->status != "LUNAS") { ?>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Hapus Invoice" tabindex="0" onclick="hapusInvoice('<?php echo $data->idInvoice ?>')"><i class="mdi mdi-delete"></i></button>
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

<div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-light table-bordered table-sm">
                        <tbody>
                            <tr>
                                <td class="fw-bold table-secondary" width="13%">Customer</td>
                                <td width="37%"><span class="companyName"></span></td>
                                <td class="fw-bold table-secondary">id PR</td>
                                <td><span class="idPR"></span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold table-secondary">E-mail</td>
                                <td><span class="email"></span></td>
                                <td class="fw-bold table-secondary">Status</td>
                                <td><span class="status"></span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold table-secondary">Contact Number</td>
                                <td><span class="contactNumber"></span></td>
                                <td class="fw-bold table-secondary">Created At</td>
                                <td><span class="createdAt"></span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold table-secondary">PO Refrence</td>
                                <td><span class="poRefrence"></span></td>
                                <td class="fw-bold table-secondary">Updated At</td>
                                <td><span class="updatedAt"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table class="table table-striped w-100 nowrap table-sm">
                    <thead>
                        <tr class="fw-bold">
                            <td>No</td>
                            <td>Barang</td>
                            <td>Mat.Code</td>
                            <td>Tipe</td>
                            <td>Qty Order</td>
                            <td>Sisa Order</td>
                            <td>Price</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody id="showTab"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    let base_url = '<?php echo base_url(); ?>';
    const viewOrder = (idMasterOrder) => {
        $.ajax({
            url: base_url + 'invoice/viewOrder',
            type: 'POST',
            data: {
                idMasterOrder: idMasterOrder
            },
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                $('.companyName').text(data.getOrderById.companyName);
                $('.email').text(data.getOrderById.email);
                $('.idPR').text(data.getOrderById.idPR);
                $('.status').text(data.getOrderById.status);
                $('.createdAt').text(data.getOrderById.createdAt);
                $('.updatedAt').text(data.getOrderById.updatedAt);
                $('.contactNumber').text(data.getOrderById.contactNumber);
                $('.poRefrence').text(data.getOrderById.poRefrence);
                $('#modalTitleId').text('Master Order ' + idMasterOrder);

                let html;
                let no = 1;
                for (let i = 0; i < data.getListOrderById.length; i++) {
                    let sisa = (data.getListOrderById[i].getQtyInvoice) ? data.getListOrderById[i].getQtyInvoice.qtyInvoice : 0;
                    let limit = data.getListOrderById[i].qtyOrder - sisa;

                    html += `
                    <tr>
                        <td>${no++}</td>
                        <td>${data.getListOrderById[i].description}</td>                        
                        <td>${data.getListOrderById[i].mcRefrence}</td>                        
                        <td>${data.getListOrderById[i].type}</td>                        
                        <td>${data.getListOrderById[i].qtyOrder}</td>                                                             
                        <td>${limit}</td>                                                             
                        <td>${formatNumberWithCommas(data.getListOrderById[i].fixedPrice)}</td>                        
                        <td>${formatNumberWithCommas(data.getListOrderById[i].total)}</td>                        
                    </tr>
                    `;
                }

                $('#showTab').html(html);
                $('#modalId').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function formatNumberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    const hapusInvoice = (idInvoice) => {
        let x = confirm('Apakah anda yakin akan mengahapus data ini ?');
        if (x) {
            $.ajax({
                url: base_url + 'invoice/hapusInvoice',
                type: 'POST',
                data: {
                    idInvoice: idInvoice
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