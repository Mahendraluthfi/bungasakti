<!-- Start Content-->
<div class="container-xxl">

    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Cetak Quotation</h4>
        </div>

        <div class="text-end">
            <nav class="breadcrumb">
                <a class="breadcrumb-item" href="<?php echo base_url() ?>">Dashboard</a>
                <a class="breadcrumb-item" href="<?php echo base_url('purchase') ?>">Master PR</a>
                <a class="breadcrumb-item" href="javascript:history.back()">Purchase Form</a>
                <span class="breadcrumb-item active" aria-current="page">Print Quotation</span>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-start">
                                    <img src="<?php echo base_url() ?>assets/logo/flatlogo.png" class="me-2" alt="logo" height="40">
                                    <address class="mt-2">
                                        Perihal: <strong>Penawaran Harga</strong><br>
                                        Kepada: <strong><?php echo $getPRbyId->username ?></strong><br>
                                        <?php echo $getPRbyId->companyName ?><br>
                                        <?php echo $getPRbyId->address ?><br>
                                        <?php echo $getPRbyId->contactNumber ?><br>
                                        <?php echo $getPRbyId->email ?><br>

                                    </address>
                                </div>
                                <div class="float-end">
                                    <h4 class="fs-18 mb-3">Quotation #<?php echo strtoupper($getPRbyId->idPR) ?></h4>
                                    <p class="mb-0"><strong>Date: </strong><?php echo date('d/m/Y', strtotime($getPRbyId->createdAt)) ?></p>
                                    <!-- <p class="mb-0"><strong>ID PR: </strong> <span class="label label-pink"><?php echo ($getPRbyId->idPR) ? $getPRbyId->idPR : '-' ?></span></p> -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive rounded-2">
                                    <table class="table mt-4 mb-4 table-centered border">
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
                                        <tbody>
                                            <?php $no = 1;
                                            $total = 0;
                                            foreach ($getDetailPurchase as $data) {
                                                $total = $total + ($data->qtyOrder * $data->estimatedPrice);
                                            ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $data->description ? $data->description : $data->descriptionCustom  ?></td>
                                                    <td><?php echo $data->mcRefrence ?></td>
                                                    <td><?php echo $data->uom ?></td>
                                                    <td><?php echo $data->qtyOrder ?></td>
                                                    <td class="align-items-end text-end"><?php echo number_format($data->estimatedPrice) ?></td>
                                                    <td class="text-end"><?php echo number_format($data->qtyOrder * $data->estimatedPrice) ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="5"></td>
                                                <td class="fw-bold text-end">Total IDR</td>
                                                <td class="fs-16 fw-bold text-end"><?php echo number_format($total) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="fw-bold mb-3">
                                        Note : <?php echo $getPRbyId->remark ?>
                                    </div>
                                    <p class="pb-0 m-0">Kendal, <?php echo date('d F Y') ?></p>
                                    <p class="pb-3">Hormat Kami</p>
                                    <div style="height: 30px;"></div>
                                    <p class="pt-3">CV. BUNGA SAKTI</p>
                                    <?php echo $this->session->userdata('sessionName'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="d-print-none">
                            <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-dark border-0"><i
                                        class="mdi mdi-printer me-1"></i>Print</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div> <!-- container-fluid -->