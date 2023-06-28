<?= $this->extend('admin/layouts/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2><strong>Project</strong> Form</h2>
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
                <form id="form_validation" method="POST" action="<?= site_url('admin/projects/add-project') ?>">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Project Creators</label>
                                <select class="form-control show-tick ms select2" name="creators" data-placeholder="Select">
                                    <option value="" selected>--Select One--</option>
                                    <?php foreach($organizers as $organizer): ?>
                                        <option value="<?= $organizer->or_id ?>"><?= $organizer->or_firstname." ".$organizer->or_lastname ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Project Name</label>
                                <input type="text" class="form-control" placeholder="Name" name="name" value="<?= set_value('name') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <label>Slug <span class="text-primary">Auto-generated</span></label>
                        <input type="text" class="form-control" disabled>
                    </div>
                    <div class="form-group form-float">
                        <label>Project Description</label>
                        <textarea name="description" id="ckeditor" placeholder="Description" required><?= set_value('description') ?></textarea>
                    </div>
                    <button class="btn btn-raised btn-primary waves-effect" type="submit">Create Project</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>