<?= $this->extend('organizers/layouts/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2><strong>Profile</strong> Form</h2>
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
                <form id="form_validation" method="POST" action="<?= site_url('organizer/profile/'.$profile->info_id) ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>First Name <span class="text-danger">(Required)</span></label>
                                <input type="text" class="form-control" name="fname" value="<?= $profile->or_firstname ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Last Name <span class="text-danger">(Required)</span></label>
                                <input type="text" class="form-control" name="lname" value="<?= $profile->or_lastname ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Company Name</label>
                                <input type="text" class="form-control" value="<?= $profile->or_company_name ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Country <span class="text-danger">(Required)</span></label>
                                <select name="country" class="form-control show-tick ms select2" data-placeholder="Select">
                                    <option value="<?= $profile->shortname ?>" selected><?= $profile->country_name ?></option>
                                    <?php foreach ($countries as $country) : ?>
                                        <?php if($country->shortname !== $profile->shortname): ?>
                                            <option value="<?= $country->shortname ?>"><?= $country->country_name ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Company Address <span class="text-danger">(Required)</span></label>
                                <input type="text" name="address"  value="<?= $profile->or_company_address ?>" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Company Email</label>
                                <input type="email" class="form-control" name="email" value="<?= $profile->or_company_email ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Phone Number <span class="text-danger">(Required)</span></label>
                                <input type="number" class="form-control" name="mobile" value="<?= $profile->or_company_phone ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Company Website <span class="text-primary">(Optional)</span></label>
                                <input type="text" class="form-control" name="website" value="<?= $profile->or_website ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Twitter link <span class="text-primary">(Optional)</span></label>
                                <input type="text" class="form-control" name="twitter" value="<?= $profile->or_twitter ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Instagram link <span class="text-primary">(Optional)</span></label>
                                <input type="text" class="form-control" name="instagram" value="<?= $profile->or_instagram ?>">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group form-float">
                                <label>Company Description <span class="text-danger">(Required)</span></label>
                                <textarea name="description" class="form-control" cols="30" rows="10" required><?= $profile->or_company_desc ?></textarea>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-raised btn-primary waves-effect" type="submit">Update Info</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>