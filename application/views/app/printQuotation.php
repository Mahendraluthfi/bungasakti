<!-- Start Content-->
<div class="container-xxl">

    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Cetak Quotation</h4>
        </div>

        <div class="text-end">
            <nav class="breadcrumb">
                <a class="breadcrumb-item" href="<?php echo base_url() ?>">Dashboard</a>
                <a class="breadcrumb-item" href="<?php echo base_url('Order/editOrder/' . $this->uri->segment('3')) ?>">Order</a>
                <span class="breadcrumb-item active" aria-current="page">Edit Order</span>
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
                                        Kepada: <strong><?php echo $getOrderById->username ?></strong><br>
                                        <?php echo $getOrderById->companyName ?><br>
                                        <?php echo $getOrderById->address ?><br>
                                        <?php echo $getOrderById->contactNumber ?><br>
                                        <?php echo $getOrderById->email ?><br>

                                    </address>
                                </div>
                                <div class="float-end">
                                    <h4 class="fs-18 mb-3">Quotation #<?php echo strtoupper($getOrderById->idMasterOrder) ?></h4>
                                    <p class="mb-0"><strong>Date: </strong><?php echo date('d/m/Y', strtotime($getOrderById->createdAt)) ?></p>
                                    <p class="mb-0"><strong>ID PR: </strong> <span class="label label-pink"><?php echo ($getOrderById->idPR) ? $getOrderById->idPR : '-' ?></span></p>
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
                                                <th>Type</th>
                                                <th>Uom</th>
                                                <th>Qty</th>
                                                <th>Unit Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            $total = 0;
                                            foreach ($getListOrderById as $data) {
                                                $total = $data->total + $total ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $data->description ?></td>
                                                    <td><?php echo $data->mcRefrence ?></td>
                                                    <td><?php echo $data->type ?></td>
                                                    <td><?php echo $data->uom ?></td>
                                                    <td><?php echo $data->qtyOrder ?></td>
                                                    <td class="align-items-end"><?php echo number_format($data->fixedPrice) ?></td>
                                                    <td><?php echo number_format($data->total) ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="6"></td>
                                                <td colspan="2">
                                                    <table
                                                        class="table table-sm text-nowrap mb-0 table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <p class="mb-0">Sub-total :</p>
                                                                </td>
                                                                <td>
                                                                    <p class="mb-0 fw-medium fs-15">IDR <?php echo number_format($total) ?></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">
                                                                    <p class="mb-0">PPN <span
                                                                            class="text-danger">(11%)</span>
                                                                        :</p>
                                                                </td>
                                                                <td>
                                                                    <p class="mb-0 fw-medium fs-15">
                                                                        $472.80</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">
                                                                    <p class="mb-0 fs-14">Total :</p>
                                                                </td>
                                                                <td>
                                                                    <p
                                                                        class="mb-0 fw-medium fs-16 text-success">
                                                                        IDR <?php echo number_format($total) ?></p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
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