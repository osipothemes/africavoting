<?= $this->extend('organizers/layouts/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2><strong>Participant</strong> Form</h2>
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
                
                <form id="form_validation" method="POST" action="<?= site_url('organizer/participants/add-participants') ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="form-group form-float">
                        <label>Full Names</label>
                        <textarea type="text" class="form-control" placeholder="Name" name="name" rows="2" required><?= set_value('name') ?></textarea>
                    </div>
                    <div class="form-group form-float">
                        <label>Slug <span class="text-primary">Auto-generated</span></label>
                        <input type="text" class="form-control" disabled>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Country</label>
                                <select name="country" class="form-control show-tick ms select2" data-placeholder="Select" required>
                                    <option value="" selected>Select Country</option>
                                    <?php foreach ($countries as $country) : ?>
                                        <option value="<?= $country->shortname ?>"><?= $country->country_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Project</label>
                                <select name="edition" class="form-control show-tick ms select2" data-placeholder="Select" required>
                                    <option value="" selected>Select Project</option>
                                    <?php foreach ($editions as $edition) : ?>
                                        <option value="<?= $edition->edref ?>"><?= $edition->edname ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Profile Image</label>
                                <input type="file" class="form-control-file" name="profile" required>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-raised btn-primary waves-effect" type="submit">Create Participant</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>