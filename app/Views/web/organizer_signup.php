<?= $this->extend('web/templates/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="content-wrapper">

    <!-- Breadcrump -->
    <div class="projects__breadcrumb" style="background-image: url(<?= base_url('assets/web/uploads/template/home-bg.png') ?>)">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb__text">
                        <h4>Organizers <span>Area</span></h4>
                        <h6 class="text-center"><b>NOTE:</b> ONLY FOR PROJECT ORGANIZERS</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- // End Breadcrump -->

    <div class="auth-form">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="text-center">Register below or if you already have an account click on the "Login Here" button below to login.By registering you accept our <a href="<?= site_url('terms') ?>">terms</a> and <a href="<?= site_url('privacy-policy') ?>">Privacy Policy</a></p>
                    <form action="<?= site_url('organizer/signup') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row py-2">
                            <div class="col-12">
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
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="fname" placeholder="First Name" value="<?= set_value('fname') ?>" required />
                                    <small class="text-danger">Required</small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="lname" placeholder="Last Name" value="<?= set_value('lname') ?>" required />
                                    <small class="text-danger">Required</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="cname" placeholder="Campany Name" value="<?= set_value('cname') ?>" required />
                                    <small class="text-danger">Required</small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select name="country" class="form-control show-tick ms select2" data-placeholder="Select" required>
                                        <option value="" selected>Select Country</option>
                                        <?php foreach ($countries as $country) : ?>
                                            <option value="<?= $country->shortname ?>"><?= $country->country_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-danger">Required</small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Campany Email" value="<?= set_value('email') ?>" required />
                                    <small class="text-danger">Required</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="address" placeholder="Campny Address" value="<?= set_value('address') ?>" required />
                                    <small class="text-danger">Required</small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="number" class="form-control" name="mobile" placeholder="Phone" value="<?= set_value('mobile') ?>" required />
                                    <small class="text-danger">Required</small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="website" placeholder="Website" value="<?= set_value('website') ?>" />
                                    <small class="text-primary">Optional</small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="twitter" placeholder="Twitter link" value="<?= set_value('twitter') ?>" />
                                    <small class="text-primary">Optional</small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="instagram" placeholder="Instagram Link link" value="<?= set_value('instagram') ?>" />
                                    <small class="text-primary">Optional</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea name="description" class="form-control" rows="10" placeholder="Company Description"><?= set_value('description') ?></textarea>
                                    <small class="text-danger">Required</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary px-4">Request Account</button>
                                </div>
                            </div>
                            <div class="col-12">
                                <p><a href="<?= site_url('login') ?>">Already Have an Account?</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>