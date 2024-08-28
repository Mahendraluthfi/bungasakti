<!-- Start Content-->
<div class="container-xxl">

    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Cetak Surat Jalan</h4>
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
                                        Deliver To:<br>
                                        <strong><?php echo $getInvoiceById->companyName ?></strong><br>
                                        <?php echo $getInvoiceById->address ?><br>
                                        <?php echo $getInvoiceById->contactNumber ?><br>
                                        <?php echo $getInvoiceById->email ?><br>

                                    </address>
                                </div>
                                <div class="float-end">
                                    <h3 class="fs-18 mb-3">DELIVERY ORDER</h3>
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="fst-italic">SJ / DO No.</td>
                                            <td class="fw-bold"><?php echo strtoupper($getInvoiceById->idSuratJalan) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fst-italic">PO NO</td>
                                            <td class="fw-bold"><?php echo $getInvoiceById->poRefrence ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fst-italic">DATE</td>
                                            <td class="fw-bold"><?php echo date('d/m/Y', strtotime($getInvoiceById->createdAt)) ?></td>
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
                                                <th>Qty Order</th>
                                                <th>Deskripsi</th>
                                                <th>Qty Shipped</th>
                                                <th>Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            $total = 0;
                                            foreach ($getInvoiceItemById as $data) {
                                                $total = $data->total + $total ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $data->qtyOrder ?></td>
                                                    <td><?php echo $data->description ?></td>
                                                    <td><?php echo $data->qtyInvoice ?></td>
                                                    <td><?php echo $data->remark ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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