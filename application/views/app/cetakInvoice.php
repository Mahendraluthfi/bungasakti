<!-- Start Content-->
<div class="container-xxl">

    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Cetak Invoice</h4>
        </div>

        <div class="text-end">
            <nav class="breadcrumb">
                <a class="breadcrumb-item" href="<?php echo base_url('appHome') ?>">Dashboard</a>
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
                                        <?php echo $getInvoiceById->username ?><br>
                                        <strong><?php echo $getInvoiceById->companyName ?></strong><br>
                                        <?php echo $getInvoiceById->address ?><br>
                                        <?php echo $getInvoiceById->contactNumber ?><br>
                                        <?php echo $getInvoiceById->email ?><br>

                                    </address>
                                </div>
                                <div class="float-end">
                                    <h3 class="fs-28 text-primary mb-3">INVOICE</h3>
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
                                            <tr>
                                                <td colspan="7" class="fst-italic fw-bold">
                                                    Terbilang : <?php echo $terbilang ?> Rupiah
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    Account No. / Nomor Rekening :<br>
                                    <b>Bank Mandiri 136-00-1719093-2 an CV. BUNGA SAKTI</b><br>
                                    <b>Bank BCA 0095011166 an AFFENDY HERMANU</b><br><br>
                                    <i class="text-danger">Note: Maximum payment of 7 days after this invoice is received</i><br><br>
                                    <i class="mdi mdi-email"></i> percetakan@bungasakti.com<br>
                                    <i class="mdi mdi-phone"></i> (0294) 572108 <br>
                                    <i class="mdi mdi-cellphone"></i> 085 727 741 082
                                    <p></p>
                                    <div class="row mx-3">
                                        <div class="col-6">
                                            <p class="pb-0 m-0">Kendal, <?php echo date('d F Y') ?></p>
                                            <p class="pb-3">Hormat Kami</p>
                                            <div style="height: 30px;"></div>
                                            <p class="pt-3">CV. BUNGA SAKTI</p>
                                            <?php echo $this->session->userdata('sessionName'); ?>
                                        </div>
                                        <div class="col-6 text-end">
                                            <p class="pb-0 m-0"></p>
                                            <p class="pb-3">Received by / Diterima Oleh</p>
                                            <div style="height: 30px;"></div>
                                            <p class="py-3 mx-3">(<span class="mx-5"></span>)</p>
                                        </div>
                                    </div>
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