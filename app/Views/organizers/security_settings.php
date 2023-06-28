<?= $this->extend('organizers/layouts/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2><strong>Security</strong> Form</h2>
            </div>
            <div class="body">
                <?php if (isset($validation)) : ?>
                    <div class="alert alert-danger">
                        <?= $validation->listErrors() ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getTempdata('error')) : ?>
                    <div class="alert alert-danger">
                        <strong>Oh snap!</strong> <?= session()->getTempdata('error'); ?>
                    </div>
                <?php endif; ?>
                <form id="form_validation" method="POST" action="<?= site_url('organizer/security-settings/'.$settings->user_id) ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group form-float">
                                <label>Your Email</label>
                                <input type="email" class="form-control"value="<?= $settings->secret ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>New Password <span class="text-danger">(Required)</span></label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Confirm Password <span class="text-danger">(Required)</span></label>
                                <input type="password" class="form-control" name="cpassword" required>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-raised btn-primary waves-effect" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>