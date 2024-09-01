<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">

            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4>Master Pembelian</h4>
                        <button type="button" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah Data</button>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Toko</th>
                                <th>User</th>
                                <th>Nota No.</th>
                                <th>Ket.</th>
                                <th>Total</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>