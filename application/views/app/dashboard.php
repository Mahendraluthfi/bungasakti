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
                            <div class="d-flex align-items-baseline mb-1">
                                <div class="fs-22 mb-0 me-2 fw-semibold text-danger">
                                    <button type="button" class="btn btn-danger" onclick="tempo()">
                                        <?php echo $jatuhTempo ?>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
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
                <div class="col-md-6">
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
            <!-- <div class="card">
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
            </div> -->
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

<div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Detail Invoice Jatuh Tempo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Customer</th>
                            <th>No.Invoice</th>
                            <th>PO Vendor</th>
                            <th>Tanggal</th>
                            <th>Tempo</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="showTab"></tbody>
                </table>
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
    let base_url = '<?php echo base_url(); ?>';
    const tempo = () => {
        $.ajax({
            url: base_url + 'appHome/getTempo',
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
                let html;
                let no = 1;
                for (let i = 0; i < data.length; i++) {
                    html += `
                        <tr>
                            <td>${no++}</td>
                            <td>${data[i].companyName}</td>
                            <td>${data[i].idInvoice}</td>
                            <td>${(data[i].poRefrence) ? data[i].poRefrence : ''}</td>
                            <td>${data[i].createdAt}</td>
                            <td>${data[i].dueDate}</td>
                            <td>${formatNumber(data[i].sumTotal.totalBayar)}</td>                        
                        </tr>
                    `;
                }
                $('#showTab').html(html);
                $('#modalId').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function formatNumber(num) {
        return Number(num).toLocaleString('en-US');
    }
</script>