<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">

            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4>Transaksi Penjualan</h4>
                        <a href="<?php echo base_url('penjualan/newTrans') ?>" class="btn btn-primary"><i class="mdi mdi-plus"></i> Tambah Transaksi</a>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nota No.</th>
                                <th>Tanggal</th>
                                <th>Toko</th>
                                <th>User</th>
                                <th>Ket.</th>
                                <th>Total</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($get as $data) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data->idPenjualan ?></td>
                                    <td><?php echo $data->createdAt ?></td>
                                    <td><?php echo $data->namaToko ?></td>
                                    <td><?php echo $data->name ?></td>
                                    <td><?php echo $data->remark ?></td>
                                    <td><?php echo number_format($data->total->totalBayar) ?></td>
                                    <td>
                                        <button type="button" onclick="get('<?php echo $data->idPenjualan ?>')" class="btn btn-info btn-sm mr-1" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Detail Penjualan" tabindex="0"><i class="mdi mdi-eye"></i></button>
                                        <?php if ($this->session->userdata('sessionLevel') == "ADMIN") { ?>
                                            <button type="button" onclick="deletePenjualan('<?php echo $data->idPenjualan ?>')" class="btn btn-danger btn-sm mr-1" data-bs-custom-class="custom-popover" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Hapus Penjualan" tabindex="0"><i class="mdi mdi-delete"></i></button>
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


<div class="modal fade" id="modalId" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Detail Penjualan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <th>Barang</th>
                        <th>Qty</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">SubTotal</th>
                    </thead>
                    <tbody id="showItems"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    let base_url = '<?php echo base_url(); ?>';
    const get = (id) => {
        $.ajax({
            url: base_url + 'penjualan/getPenjualan',
            type: 'POST',
            data: {
                idPenjualan: id,
            },
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                let html;
                for (let i = 0; i < data.listItems.length; i++) {
                    let total = parseInt(data.listItems[i].price) * parseInt(data.listItems[i].qty);
                    html += `
                        <tr class="align-middle">                            
                            <td>${data.listItems[i].description}</td>   
                            <td class="text-center"> ${data.listItems[i].qty}</td>   
                            <td class="text-end">${formatNumber(data.listItems[i].price)}</td>   
                            <td class="text-end">${formatNumber(total)}</td>                                                    
                        </tr>`;
                }
                $('#showItems').html(html);
                $('#modalId').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function formatNumber(num) {
        return Number(num).toLocaleString('en-US');
    }

    const deletePenjualan = (id) => {
        let x = confirm('Apakah anda yakin menghapus transaksi ini ?');
        if (x) {
            $.ajax({
                url: base_url + 'penjualan/hapusPenjualan',
                type: 'POST',
                data: {
                    idPenjualan: id,
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