<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4>Master Order</h4>
                        <button type="button" class="btn btn-primary btn-sm mb-3" onclick="openModal()"><i class="mdi mdi-plus"></i> Tambah Data</button>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
            </div>
        </div>
    </div>
</div>