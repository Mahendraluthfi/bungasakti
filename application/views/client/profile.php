<div class="container-xxl mt-3">
    <h3>Profile Setting</h3>
    <div class="row mt-3">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <?php echo $this->session->flashdata('msg'); ?>
                    <?php echo form_open('profile/update') ?>
                    <div class="row mb-3">
                        <label for="inputCompany" class="col-sm-3 col-form-label">Company Name</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="idCustomer" value="<?php echo $get->idCustomer ?>">
                            <input type="text" required name="companyName" class="form-control" id="inputCompany" value="<?php echo $get->companyName ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputUsername" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                            <input type="text" required name="username" class="form-control" id="inputUsername" value="<?php echo $get->username ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modalId" class="btn btn-danger btn-sm">Change Password</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputContact" class="col-sm-3 col-form-label">Contact No</label>
                        <div class="col-sm-9">
                            <input type="text" name="contactNumber" class="form-control" id="inputContact" value="<?php echo $get->contactNumber ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail" class="col-sm-3 col-form-label">E-mail</label>
                        <div class="col-sm-9">
                            <input type="text" required name="email" class="form-control" id="inputEmail" value="<?php echo $get->email ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputAddress" class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
                            <textarea name="address" id="inputAddress" class="form-control"><?php echo $get->address ?></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo form_open('profile/changePassword') ?>
                <div class="row mb-3">
                    <label for="inputCompany" class="col-sm-4 col-form-label">Current Passowrd</label>
                    <div class="col-sm-8">
                        <input type="hidden" name="idCustomer" value="<?php echo $get->idCustomer ?>">
                        <input type="password" class="form-control" name="currentPassword" placeholder="Current Password" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputUsername" class="col-sm-4 col-form-label">New Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="newPassword" placeholder="New Password" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword" class="col-sm-4 col-form-label">Confirm Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>




<script>

</script>