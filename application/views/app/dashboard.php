<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<div class="container-xxl mt-3">
    <div class="py-1 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-20 fw-semibold m-0">Dashboard Bunga Sakti</h4>
            <small>ADMIN</small>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6 col-xl-2">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="fs-14 mb-1">#PR <?php echo date('F') ?></div>
                    </div>
                    <div class="d-flex align-items-baseline mb-2">
                        <div class="fs-22 mb-0 me-2 fw-semibold text-black"><?php echo $PRofMonth ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="fs-14 mb-1">#PO <?php echo date('F') ?></div>
                    </div>
                    <div class="d-flex align-items-baseline mb-2">
                        <div class="fs-22 mb-0 me-2 fw-semibold text-black"><?php echo $POofMonth ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="fs-14 mb-1">#Omzet Vendor <?php echo date('F') ?></div>
                    </div>
                    <div class="d-flex align-items-baseline mb-2">
                        <div class="fs-22 mb-0 me-2 fw-semibold text-warning"><?php echo number_format($omzetofMonth->omzet) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="fs-14 mb-1">#Invoice Release <?php echo date('F') ?></div>
                    </div>
                    <div class="d-flex align-items-baseline mb-2">
                        <div class="fs-22 mb-0 me-2 fw-semibold text-primary"><?php echo number_format($invoiceofMonth->omzet_invoice) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="fs-14 mb-1">#Piutang <?php echo date('F') ?></div>
                    </div>
                    <div class="d-flex align-items-baseline mb-2">
                        <div class="fs-22 mb-0 me-2 fw-semibold text-danger"><?php echo number_format($kreditofMonth->kredit_invoice) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="fs-14 mb-1">#Debit <?php echo date('F') ?></div>
                    </div>
                    <div class="d-flex align-items-baseline mb-2">
                        <div class="fs-22 mb-0 me-2 fw-semibold text-success"><?php echo number_format($debitofMonth->debit_invoice) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-center">
                                <div class="fs-14 mb-1">#PO Complete</div>
                            </div>
                            <div class="d-flex align-items-baseline mb-2">
                                <div class="fs-22 mb-0 me-2 fw-semibold text-info"><?php echo $poComplete ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-center">
                                <div class="fs-14 mb-1">#Piutang Cummulative</div>
                            </div>
                            <div class="d-flex align-items-baseline mb-2">
                                <div class="fs-22 mb-0 me-2 fw-semibold text-danger"><?php echo number_format($kreditCum->kredit_invoice) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-center">
                                <div class="fs-14 mb-1">#PO Pending</div>
                            </div>
                            <div class="d-flex align-items-baseline mb-2">
                                <div class="fs-22 mb-0 me-2 fw-semibold text-danger"><?php echo $poPending ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-center">
                                <div class="fs-14 mb-1">#Invoice Lewat Tempo</div>
                            </div>
                            <div class="d-flex align-items-baseline mb-2">
                                <div class="fs-22 mb-0 me-2 fw-semibold text-danger"><?php echo $jatuhTempo ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header p-1">Barang low Stock</div>
                <div class="card-body">
                    <table id="scroll-vertical-datatable"
                        class="table table-bordered dt-responsive table-sm w-100">
                        <thead>
                            <tr>
                                <th>Deskripsi</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lowStock as $data) { ?>
                                <tr>
                                    <td><?php echo $data->description ?></td>
                                    <td><?php echo $data->total ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-8">
            <div class="card">
                <div class="card-body p-2">
                    <div id="container"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Data retrieved https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature
    Highcharts.chart('container', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Trend Sales Vendor 2024'
        },
        xAxis: {
            categories: [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                'Oct', 'Nov', 'Dec'
            ]
        },
        yAxis: {
            title: {
                text: 'Rupiah IDR'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series: [{
                name: 'Order',
                data: [
                    <?php echo $chartOrder->January ?>,
                    <?php echo $chartOrder->February ?>,
                    <?php echo $chartOrder->March ?>,
                    <?php echo $chartOrder->April ?>,
                    <?php echo $chartOrder->May ?>,
                    <?php echo $chartOrder->June ?>,
                    <?php echo $chartOrder->July ?>,
                    <?php echo $chartOrder->August ?>,
                    <?php echo $chartOrder->September ?>,
                    <?php echo $chartOrder->October ?>,
                    <?php echo $chartOrder->November ?>,
                    <?php echo $chartOrder->December ?>,
                ]
            },
            {
                name: 'Invoice',
                data: [
                    <?php echo $chartInvoice->January ?>,
                    <?php echo $chartInvoice->February ?>,
                    <?php echo $chartInvoice->March ?>,
                    <?php echo $chartInvoice->April ?>,
                    <?php echo $chartInvoice->May ?>,
                    <?php echo $chartInvoice->June ?>,
                    <?php echo $chartInvoice->July ?>,
                    <?php echo $chartInvoice->August ?>,
                    <?php echo $chartInvoice->September ?>,
                    <?php echo $chartInvoice->October ?>,
                    <?php echo $chartInvoice->November ?>,
                    <?php echo $chartInvoice->December ?>,
                ]
            },
            {
                name: 'Piutang',
                data: [
                    <?php echo $chartPiutang->January ?>,
                    <?php echo $chartPiutang->February ?>,
                    <?php echo $chartPiutang->March ?>,
                    <?php echo $chartPiutang->April ?>,
                    <?php echo $chartPiutang->May ?>,
                    <?php echo $chartPiutang->June ?>,
                    <?php echo $chartPiutang->July ?>,
                    <?php echo $chartPiutang->August ?>,
                    <?php echo $chartPiutang->September ?>,
                    <?php echo $chartPiutang->October ?>,
                    <?php echo $chartPiutang->November ?>,
                    <?php echo $chartPiutang->December ?>,
                ],
                color: 'red',
            },
            {
                name: 'Debit',
                data: [
                    <?php echo $chartDebit->January ?>,
                    <?php echo $chartDebit->February ?>,
                    <?php echo $chartDebit->March ?>,
                    <?php echo $chartDebit->April ?>,
                    <?php echo $chartDebit->May ?>,
                    <?php echo $chartDebit->June ?>,
                    <?php echo $chartDebit->July ?>,
                    <?php echo $chartDebit->August ?>,
                    <?php echo $chartDebit->September ?>,
                    <?php echo $chartDebit->October ?>,
                    <?php echo $chartDebit->November ?>,
                    <?php echo $chartDebit->December ?>,
                ],
                color: 'green',
            }
        ]
    });
</script>