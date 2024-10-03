<div class="container-xxl mt-3">
    <div class="d-flex justify-content-between">
        <h4>Penjualan - <?php echo $namaToko ?></h4>
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="<?php echo base_url('appHome') ?>">Dashboard</a>
            <a class="breadcrumb-item" href="<?php echo base_url('penjualan') ?>">Penjualan</a>
            <span class="breadcrumb-item active" aria-current="page">Transaksi</span>
        </nav>
    </div>
    <div class="row">
        <div class="col-8 p-0">
            <div class="card m-1">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4>Transaksi #<?php echo $idPenjualan ?></h4>
                        <h5><?php echo date('d-m-y') ?>&nbsp;<span id="jam"></span></h5>
                    </div>
                </div>
            </div>
            <div class="card m-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div>
                                <label for="findBarcode" class="form-label">SCAN BARCODE</label>
                                <input type="text" id="findBarcode" class="form-control" autofocus>
                            </div>
                        </div>
                        <div class="col-3">
                            <div>
                                <label for="simpleinput" class="form-label">CARI BARANG</label><br>
                                <button type="button" class="btn btn-primary w-100 btn-cari">
                                    <i class="mdi mdi-text-box-search-outline"></i> Cari Barang
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card m-1">
                <div class="card-body">
                    <h5>Detail Transaksi</h5>
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <th width="1%">#</th>
                            <th>Barang</th>
                            <th>Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">SubTotal</th>
                        </thead>
                        <tbody id="showItems"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-4 p-0">
            <div class="card m-1">
                <div class="card-body">
                    <h5>Detail Informasi</h5>
                    <hr class="m-1">
                    <form id="detailForm">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Kasir</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control-plaintext" value=": <?php echo $this->session->userdata('sessionName') ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Cutomer</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="customer" value="Umum">
                                <input type="hidden" name="idPenjualan" value="<?php echo $idPenjualan ?>">
                            </div>
                        </div>
                        <div class="row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Catatan</label>
                            <div class="col-sm-9">
                                <textarea name="remark" class="form-control" placeholder="Catatan Transaksi"></textarea>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="card m-1">
                <div class="card-body">
                    <h5>Pembayaran</h5>
                    <hr class="m-1">
                    <div class="d-flex justify-content-between">
                        <h6>Jumlah Item</h6>
                        <h6 class="totalItems"></h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6>Total Bayar</h6>
                        <h4 class="totalBayar"></h4>
                    </div>
                    <button type="button" class="btn btn-dark w-100 btn-lg" onclick="printsave()">Simpan & Cetak Nota</button>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalPilih" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Pilih Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-primary" role="alert">
                    Anda mempunyai barang dengan Barcode yang sama. Silahkan pilih satu barang !
                </div>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Stock</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody id="pilihBarang"></tbody>
                </table>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalCari" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Cari Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <select name="" id="select-beast" onchange="selectBarang(this)">
                        <option value="">Pilih Barang</option>
                        <?php foreach ($getBarang as $data) { ?>
                            <option value="<?php echo $data->idStock ?>"><?php echo $data->description . ' / ' . number_format($data->basePrice) ?></option>
                        <?php } ?>
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let base_url = '<?php echo base_url() ?>';
    let idPenjualan = '<?php echo $idPenjualan ?>';
    startTime();
    showItems(idPenjualan);

    function startTime() {
        let today = new Date();
        let h = today.getHours();
        let m = today.getMinutes();
        let s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('jam').innerHTML = h + ":" + m + ":" + s;
        let t = setTimeout(function() {
            startTime()
        }, 1000);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }; // add zero in front of numbers < 10
        return i;
    }
    const barcodeEnter = document.getElementById("findBarcode");
    barcodeEnter.addEventListener("keydown", function(e) {
        if (e.key === 'Enter') {
            if (this.value) {
                checkBarcode(this.value);
            } else {
                e.preventDefault();
            }
        }
    });

    function formatNumber(num) {
        return Number(num).toLocaleString('en-US');
    }


    function showItems(idPenjualan) {
        $.ajax({
            url: base_url + 'penjualan/showItems',
            type: 'POST',
            data: {
                idPenjualan: idPenjualan,
            },
            dataType: 'JSON',
            success: function(data) {
                let html;
                for (let i = 0; i < data.listItems.length; i++) {
                    let total = parseInt(data.listItems[i].price) * parseInt(data.listItems[i].qty);
                    html += `
                        <tr class="align-middle">
                            <td><button type="button" onclick="hapusItem('${data.listItems[i].idDetPenjualan}')" class="btn btn-danger btn-sm">x</button></td>   
                            <td>${data.listItems[i].description}</td>   
                            <td class="text-center">
                                <button type="button" onclick="minusQty('${data.listItems[i].idDetPenjualan}','${data.listItems[i].qty}','${data.listItems[i].idStock}')" class="btn btn-light btn-sm mx-1">-</button>
                                ${data.listItems[i].qty}
                                <button type="button" onclick="plusQty('${data.listItems[i].idDetPenjualan}','${data.listItems[i].idStock}')" class="btn btn-light btn-sm mx-1">+</button>
                            </td>   
                            <td class="text-end">${formatNumber(data.listItems[i].price)}</td>   
                            <td class="text-end">${formatNumber(total)}</td>                                                    
                        </tr>`;
                }
                $('#showItems').html(html);
                $('.totalBayar').text(formatNumber(data.totalBayar.totalBayar));
                $('.totalItems').text(formatNumber(data.totalItems.totalQty));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const checkBarcode = (id) => {
        $.ajax({
            url: base_url + 'penjualan/checkBarcode',
            type: 'POST',
            data: {
                id: id,
                idPenjualan: idPenjualan,
            },
            dataType: 'JSON',
            success: function(data) {
                if (data.value === 0) {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false
                    })
                    barcodeEnter.value = '';
                } else if (data.value == 1) {
                    // location.reload();
                    showItems(idPenjualan);
                    barcodeEnter.value = '';
                    barcodeEnter.focus();
                } else if (data.value == 2) {
                    console.log(data.data);
                    barcodeEnter.value = '';
                    let html;
                    for (let i = 0; i < data.data.length; i++) {
                        html += `
                            <tr>
                                <td>${data.data[i].description}</td>   
                                <td>${data.data[i].qtyStock}</td>   
                                <td><button type="button" class="btn btn-primary btn-sm" onclick="pilihBarang('${data.data[i].idStock}','${data.data[i].qtyStock}','${data.data[i].basePrice}')">Pilih</button></td>                                                    
                            </tr>`;
                    }
                    $('#pilihBarang').html(html);
                    $('#modalPilih').modal('show');
                }
                // console.log(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const pilihBarang = (id, qty, price) => {
        if (qty == 0) {
            Swal.fire({
                title: 'Error',
                text: 'Stok barang kosong!',
                icon: 'error',
                timer: 2000,
                showConfirmButton: false
            })
            return;
        } else {
            $.ajax({
                url: base_url + 'penjualan/pilihBarang',
                type: 'POST',
                data: {
                    id: id,
                    idPenjualan: idPenjualan,
                    price: price
                },
                dataType: 'JSON',
                success: function(data) {
                    showItems(idPenjualan);
                    $('#modalPilih').modal('hide');
                    barcodeEnter.focus();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    }

    const minusQty = (id, qty, idStock) => {
        if (qty == 1) {
            Swal.fire({
                title: 'Error',
                text: 'Minimal quantity 1!',
                icon: 'error',
                timer: 2000,
                showConfirmButton: false
            })
            return;
        } else {
            $.ajax({
                url: base_url + 'penjualan/reduceQty',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    id: id,
                    idStock: idStock,
                },
                success: function(data) {
                    showItems(idPenjualan);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    }

    const plusQty = (id, idStock) => {
        $.ajax({
            url: base_url + 'penjualan/addQty',
            type: 'POST',
            dataType: 'JSON',
            data: {
                id: id,
                idStock: idStock,
            },
            success: function(data) {
                if (data.status == false) {

                    Swal.fire({
                        title: 'Error',
                        text: 'Stok barang habis!',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false
                    })
                } else {
                    showItems(idPenjualan);
                }
                // console.log(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    const hapusItem = (id) => {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus item ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + 'penjualan/hapusitem',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        showItems(idPenjualan);
                        barcodeEnter.focus();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error get data from ajax');
                    }
                });
            }
            // alert("OK");
        });
    }

    $('.btn-cari').on('click', function() {
        $('#modalCari').modal('show');
    });

    const selectBarang = (id) => {
        let idStock = id.value;

        // alert(idStock);
        if (idStock) {
            $.ajax({
                url: base_url + 'penjualan/selectedBarang',
                type: 'POST',
                data: {
                    idStock: idStock,
                    idPenjualan: idPenjualan
                },
                dataType: 'JSON',
                success: function(data) {
                    showItems(idPenjualan);
                    barcodeEnter.focus();
                    $('#modalCari').modal('hide');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    }

    const printsave = () => {

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Simpan dan Cetak Nota ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + 'penjualan/simpanPenjualan',
                    type: 'POST',
                    data: $('#detailForm').serialize(),
                    dataType: 'JSON',
                    success: function(data) {
                        window.open(base_url + 'penjualan/printNota/' + data, '_blank');
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error get data from ajax');
                    }
                });
            }
        });
    }
</script>