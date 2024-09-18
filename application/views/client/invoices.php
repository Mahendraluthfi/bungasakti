<div class="container-xxl mt-3">
    <h3>Invoices</h3>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No.Invoice</th>
                                <th>PR No</th>
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
                            foreach ($get as $data) {
                                $date = date('Y-m-d');
                            ?>
                                <tr class="<?php echo ($data->dueDate < $date && $data->status == "PENDING") ? 'table-danger' : '' ?>">
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data->idInvoice ?></td>
                                    <td><?php echo $data->idPR ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($data->createdAt)) ?></td>
                                    <td><?php echo $data->dueDate ?></td>
                                    <td><?php echo number_format($data->sumTotal->totalBayar) ?></td>
                                    <td><?php echo ($data->paymentDate == '0000-00-00') ? '' : $data->paymentDate ?></td>
                                    <td><?php echo $data->status ?></td>
                                    <td>
                                        <button class="btn btn-success btn-sm" onclick="get('<?php echo $data->idInvoice ?>')" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Detail Invoice" tabindex="0"><i class="mdi mdi-magnify-expand"></i></button>
                                        <a href="<?php echo base_url('clientInvoices/cetakInvoice/' . $data->idInvoice) ?>" class="btn btn-primary btn-sm" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Cetak Invoice" tabindex="0"><i class="mdi mdi-invoice-list-outline"></i></a>
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
                <table class="table table-centered border table-bordered">
                    <thead class="rounded-2">
                        <tr>
                            <th>#</th>
                            <th>Deskripsi</th>
                            <th>Mat. Code</th>
                            <th>Uom</th>
                            <th>Qty</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody id="showTab"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    let base_url = '<?php echo base_url() ?>';
    const get = (idInvoice) => {
        $.ajax({
            url: `${base_url}/clientInvoices/getInvoiceItemById/${idInvoice}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                let html;
                let no = 1;
                // console.log(data);
                for (let i = 0; i < data.length; i++) {
                    let total = parseInt(data[i].fixedPrice) * parseInt(data[i].qtyInvoice);
                    html += `<tr>
                        <td>${no++}</td>
                        <td>${data[i].description}</td>
                        <td>${data[i].mcRefrence}</td>
                        <td>${data[i].uom}</td>
                        <td>${data[i].qtyInvoice}</td>                        
                        <td class="text-end">${data[i].fixedPrice}</td>                        
                        <td class="text-end">${total}</td>
                    </tr>`;

                }
                $('#showTab').html(html);
                $('#modalTitleId').text('Detail Invoice #' + idInvoice);
                $('#modalId').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
</script>