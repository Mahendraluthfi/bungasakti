<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4>Purchase Request</h4>
                        <button type="button" class="btn btn-primary btn-sm mb-3"><i class="mdi mdi-plus"></i> Tambah Data</button>
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
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>