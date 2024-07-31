<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4>Stock - <?php echo $getNamaToko ?></h4>
                        <nav class="breadcrumb">
                            <a class="breadcrumb-item" href="<?php echo base_url() ?>">Dashboard</a>
                            <a class="breadcrumb-item" href="<?php echo base_url('Stock') ?>">Stock Toko</a>
                            <span class="breadcrumb-item active" aria-current="page"><?php echo $getNamaToko ?></span>
                        </nav>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mb-2" onclick="addStock()"><i class="mdi mdi-plus"></i> Tambah Stock Barang</button>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Deskripsi</th>
                                <th>Satuan Unit</th>
                                <th>Qty Stock</th>
                                <th>Tipe</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <hr>
                    <h4>History Pembelian Barang - <?php echo $getNamaToko ?></h4>
                    <table id="scroll-horizontal-datatable2" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>idPembelian</th>
                                <th>Tanggal</th>
                                <th>Refrensi Nota</th>
                                <th>Keterangan</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div><!-- end card body -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="modalId" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmStock">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Place to the bottom of scripts -->
<script>
    let base_url = '<?php echo base_url() ?>';
    let save_method;
    let form = document.getElementById('frmStock');

    const addStock = () => {
        $('#modalId').modal('show');
        form.reset();
        save_method = 'addStock';
        $('#modalTitleId').text('Tambah Stock Barang');
    }

    const save = () => {
        if (form.checkValidity == true) {
            $.ajax({
                url: base_url + 'stock/' + save_method,
                type: 'POST',
                dataType: 'JSON',
                success: function(data) {},
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        } else {
            form.reportValidity();
        }
    }

    const get = (idStock) => {
        $.ajax({
            url: base_url + 'stock/getStockById',
            type: 'POST',
            data: {
                idStock: idStock,
            },
            dataType: 'JSON',
            success: function(data) {},
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const deleteStock = (idStock) => {
        let x = confirm('Yakin hapus data ini ?');
        if (x) {
            $.ajax({
                url: base_url + 'stock/deleteStock',
                type: 'POST',
                data: {
                    idStock: idStock,
                },
                dataType: 'JSON',
                success: function(data) {},
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    }
</script>