<div class="container-xxl mt-3">
    <h3>Welcome, <?php echo $this->session->userdata('sessionUsernameCustomer'); ?> 😊</h3>
    <div class="row mt-3">
        <div class="col-md-6 col-xl-2">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="fs-14 mb-1">Total PR</div>
                    </div>
                    <div class="d-flex align-items-baseline mb-2">
                        <div class="fs-22 mb-0 me-2 fw-semibold text-black"><?php echo $getPRbyId ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="fs-14 mb-1">Pending PR</div>
                    </div>
                    <div class="d-flex align-items-baseline mb-2">
                        <div class="fs-22 mb-0 me-2 fw-semibold text-black"><?php echo $getPRpending ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="fs-14 mb-1">Submitted PR</div>
                    </div>
                    <div class="d-flex align-items-baseline mb-2">
                        <div class="fs-22 mb-0 me-2 fw-semibold text-black"><?php echo $getPRsubmit ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>