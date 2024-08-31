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
                                <th>Customer</th>
                                <th>No.Invoice</th>
                                <th>No.SJ</th>
                                <th>ID_MasterOrder</th>
                                <th>Tanggal</th>
                                <th>Tempo</th>
                                <th>Total</th>
                                <th>Tgl Bayar</th>
                                <th>Status</th>
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