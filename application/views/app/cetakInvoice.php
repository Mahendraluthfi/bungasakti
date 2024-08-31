<!-- Start Content-->
<div class="container-xxl">

    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Cetak Invoice</h4>
        </div>

        <div class="text-end">
            <nav class="breadcrumb">
                <a class="breadcrumb-item" href="<?php echo base_url() ?>">Dashboard</a>
                <a class="breadcrumb-item" href="<?php echo base_url('invoice') ?>">Invoice</a>
                <span class="breadcrumb-item active" aria-current="page">Cetak Invoice</span>
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
                                        Invoice To:<br>
                                        <strong><?php echo $getInvoiceById->companyName ?></strong><br>
                                        <?php echo $getInvoiceById->address ?><br>
                                        <?php echo $getInvoiceById->contactNumber ?><br>
                                        <?php echo $getInvoiceById->email ?><br>

                                    </address>
                                </div>
                                <div class="float-end">
                                    <h3 class="fs-18 mb-3">INVOICE</h3>
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="fst-italic">INVOICE NO</td>
                                            <td class="fw-bold"><?php echo strtoupper($getInvoiceById->idInvoice) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fst-italic">PO NO</td>
                                            <td class="fw-bold"><?php echo $getInvoiceById->poRefrence ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fst-italic">DATE</td>
                                            <td class="fw-bold"><?php echo date('d/m/Y', strtotime($getInvoiceById->createdAt)) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fst-italic">SJ / DO No.</td>
                                            <td class="fw-bold"><?php echo strtoupper($getInvoiceById->idSuratJalan) ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive rounded-2">
                                    <table class="table mt-4 mb-4 table-centered border table-bordered">
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
                                            foreach ($getInvoiceItemById as $data) {
                                                $total = ($data->qtyInvoice * $data->fixedPrice) + $total ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $data->description ?></td>
                                                    <td><?php echo $data->mcRefrence ?></td>
                                                    <td><?php echo $data->uom ?></td>
                                                    <td><?php echo $data->qtyInvoice ?></td>
                                                    <td class="text-end"><?php echo number_format($data->fixedPrice) ?></td>
                                                    <td class="text-end"><?php echo number_format($data->qtyInvoice * $data->fixedPrice) ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr class="text-right">
                                                <td colspan="5"></td>
                                                <td>
                                                    <p class="mb-0 fs-14 fw-bold">Total IDR</p>
                                                </td>
                                                <td>
                                                    <p class="mb-0 fw-medium fs-16 text-success text-end">
                                                        <?php echo number_format($total) ?></p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <i class="text-danger">* Pembayaran max. 30 hari sejak tanggal invoice</i>
                                    <p></p>
                                    <p class="pb-0 m-0">Kendal, <?php echo date('d F Y') ?></p>
                                    <p class="pb-3">Hormat Kami</p>
                                    <div style="height: 30px;"></div>
                                    <p class="py-3">CV. BUNGA SAKTI</p>
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