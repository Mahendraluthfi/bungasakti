<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-print-none">
                        <div class="d-flex justify-content-between">
                            <h5>Laporan Sales Toko</h5>
                        </div>
                        <form class="row row-cols-lg-auto g-3 mt-2 align-items-center" id="frmSubmit">
                            <h6 class="fs-15 mt-3">Periode Tanggal</h6>
                            <div class="col-12">
                                <label class="visually-hidden" for="inlineFormInputGroupFrom">From</label>
                                <input type="date" class="form-control" name="dateFrom" required>
                            </div>
                            <h6 class="fs-15 mt-3">-</h6>
                            <div class="col-12">
                                <label class="visually-hidden" for="inlineFormInputGroupTo">To</label>
                                <input type="date" class="form-control" name="dateTo" required>
                            </div>
                            <div class="col-12">
                                <label class="visually-hidden" for="inlineFormInputGroupTo">Toko</label>
                                <select name="idToko" class="form-control" id="" required>
                                    <option value="">Pilih Toko</option>
                                    <?php foreach ($getToko as $data) { ?>
                                        <option value="<?php echo $data->idToko ?>"><?php echo $data->namaToko ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
                            </div>
                        </form>
                        <hr>
                    </div>
                    <div id="showResult"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let base_url = '<?php echo base_url(); ?>';
    let form = document.getElementById('frmSubmit');
    const submitForm = () => {
        if (form.checkValidity() == true) {
            $.ajax({
                url: base_url + 'laporan/tokoSubmit',
                type: 'POST',
                data: $('#frmSubmit').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    $('#showResult').load(base_url + 'laporan/tokoResult/' + data.dateFrom + '/' + data.dateTo + '/' + data.idToko).fadeIn("slow");
                    // console.log(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        } else {
            form.reportValidity();
        }
    }
</script>