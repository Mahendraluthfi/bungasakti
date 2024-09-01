<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card d-block">
                <div class="card-body">
                    <div class="d-print-none">
                        <div class="d-flex justify-content-between">
                            <h5>Laporan Sales Vendor</h5>
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
                url: base_url + 'laporan/vendorSubmit',
                type: 'POST',
                data: $('#frmSubmit').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    $('#showResult').load(base_url + 'laporan/vendorResult/' + data.dateFrom + '/' + data.dateTo).fadeIn("slow");
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