<div class="container-xxl mt-3">
    <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-20 fw-semibold m-0">Dashboard - <?php echo $toko->namaToko ?></h4>
            <small><?php echo $this->session->userdata('sessionName'); ?></small>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6 col-xl-2">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="fs-14 mb-1">Omzet Toko Hari ini</div>
                    </div>
                    <div class="d-flex align-items-baseline mb-2">
                        <div class="fs-22 mb-0 me-2 fw-semibold text-success"><?php echo number_format($omzetTokoToday->omzet) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="fs-14 mb-1">Omzet Toko Bulan ini</div>
                    </div>
                    <div class="d-flex align-items-baseline mb-2">
                        <div class="fs-22 mb-0 me-2 fw-semibold text-success"><?php echo number_format($omzetTokoMonth->omzet) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="fs-14 mb-1">#Transaksi Toko Hari ini</div>
                    </div>
                    <div class="d-flex align-items-baseline mb-1">
                        <div class="fs-22 mb-0 me-2 fw-semibold"><?php echo number_format($transaksiTokoToday) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="fs-14 mb-1">#Transaksi Toko Bulan ini</div>
                    </div>
                    <div class="d-flex align-items-baseline mb-1">
                        <div class="fs-22 mb-0 me-2 fw-semibold"><?php echo number_format($transaksiTokoMonth) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>