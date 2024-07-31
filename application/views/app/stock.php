<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4>Stock Toko</h4>
                        <nav class="breadcrumb">
                            <a class="breadcrumb-item" href="<?php echo base_url() ?>">Dashboard</a>
                            <span class="breadcrumb-item active" aria-current="page">Stock Toko</span>
                        </nav>
                    </div>
                    <h5>Pilih Toko</h5>
                    <div class="row">
                        <?php foreach ($getAllToko as $data) { ?>
                            <div class="col-3">
                                <div class="card border">
                                    <div class="card-body">
                                        <h5><?php echo $data->namaToko ?></h5>
                                        <small><?php echo $data->address ?></small>
                                        <hr class="my-2">
                                        <a href="<?php echo base_url('stock/toko/' . $data->idToko) ?>" class="btn btn-primary w-100 btn-sm">Pilih</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
    </div>
</div>