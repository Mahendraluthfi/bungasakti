<div class="container-xxl mt-3">
    <div class="row">
        <div class="col-12">

            <div class="card d-block">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4>Edit Pembelian - ID <?php echo $idPembelian ?></h4>
                        <nav class="breadcrumb">
                            <a class="breadcrumb-item" href="<?php echo base_url() ?>">Dashboard</a>
                            <a class="breadcrumb-item" href="<?php echo base_url('Order') ?>">Pembelian</a>
                            <span class="breadcrumb-item active" aria-current="page">Edit Pembelian</span>
                        </nav>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <div class="table-responsive">
                        <table class="table table-light table-bordered table-sm">
                            <form id="frmPurchase">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold table-secondary" width="13%">Toko</td>
                                        <td width="37%"></td>
                                        <td class="fw-bold table-secondary">User</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold table-secondary">Tanggal Pembelian</td>
                                        <td></td>
                                        <td class="fw-bold table-secondary">Remark</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold table-secondary">Ref. Nota</td>
                                        <td></td>
                                        <td class="fw-bold table-secondary">Created At</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </form>
                        </table>
                        <button type="button" class="btn btn-primary btn-sm my-3" onclick="addBarang()"><i class="mdi mdi-plus"></i>Tambah Barang Pembelian</button>

                        <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap table-sm">
                            <thead>
                                <tr class="fw-bold">
                                    <td>No</td>
                                    <td>Barang</td>
                                    <td>Mat.Code</td>
                                    <td>Tipe</td>
                                    <td>Qty Order</td>
                                    <td>Sisa</td>
                                    <td>Price</td>
                                    <td>Total</td>
                                    <td>Stock Take</td>
                                    <td>Status</td>
                                    <td>#</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div
        class="modal-dialog"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Modal title
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Body</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Close </button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    let base_url = '<?php echo base_url() ?>';
</script>