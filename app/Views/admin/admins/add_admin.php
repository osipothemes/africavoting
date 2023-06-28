<?= $this->extend('admin/layouts/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2><strong>Admin</strong> Form</h2>
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
                <form id="form_validation" method="POST" action="<?= site_url('admin/add-admin') ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="form-group form-float">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="Email" name="email" value="<?= set_value('email') ?>" required>
                    </div>
                    <div class="form-group form-float">
                        <label>Username <span class="text-danger">(Required)</span></label>
                        <input type="text" name="username" class="form-control" value="<?= set_value('username') ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Password <span class="text-danger">(Required)</span></label>
                                <input type="password" name="password" class="form-control" value="<?= set_value('password') ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Confirm Password <span class="text-danger">(Required)</span></label>
                                <input type="password" name="cpassword" class="form-control" value="<?= set_value('password') ?>" required>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-raised btn-primary waves-effect" type="submit">Create Admin</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>