<?= $this->extend('organizers/layouts/app.php') ?>
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
                <form id="form_validation" method="POST" action="<?= site_url('organizer/edit-project/' . $project->pid) ?>">
                    <?= csrf_field() ?>
                    <div class="form-group form-float">
                        <label>Project Name</label>
                        <input type="text" class="form-control" name="name" value="<?= $project->pname ?>" required>
                    </div>
                    <div class="form-group form-float">
                        <label>Slug <span class="text-primary">Auto-generated</span></label>
                        <input type="text" value="<?= $project->pslug ?>" class="form-control" disabled>
                    </div>
                    <div class="form-group form-float">
                        <label>Project Creators</label>
                        <input type="text" class="form-control" name="creators" value="<?= ucwords($organizer->or_company_name) ?>" required>
                    </div>
                    
                    <div class="form-group form-float">
                        <label>Project Description</label>
                        <textarea name="description" id="ckeditor" required><?= $project->pdescription ?></textarea>
                    </div>
                    <button class="btn btn-raised btn-primary waves-effect" type="submit">Create Project</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>