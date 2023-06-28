<?= $this->extend('admin/layouts/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2><strong>Edition</strong> Form</h2>
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
                <form id="form_validation" method="POST" action="<?= site_url('admin/projects/add-edition') ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="form-group form-float">
                        <label>Edition Name</label>
                        <input type="text" class="form-control" placeholder="Name" name="name" value="<?= set_value('name') ?>" required>
                    </div>
                    <div class="form-group form-float">
                        <label>Slug <span class="text-primary">Auto-generated</span></label>
                        <input type="text" class="form-control" disabled>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Project</label>
                                <select name="project" class="form-control show-tick ms select2" data-placeholder="Select" required>
                                    <option value="" selected>Select Project</option>
                                    <?php foreach ($projects as $project) : ?>
                                        <option value="<?= $project->pref ?>"><?= $project->pname ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Project Creators</label>
                                <select class="form-control show-tick ms select2" name="creators" data-placeholder="Select" required>
                                    <option value="" selected>--Select One--</option>
                                    <?php foreach($organizers as $organizer): ?>
                                        <option value="<?= $organizer->or_id ?>"><?= $organizer->or_firstname." ".$organizer->or_lastname ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Host Venues</label>
                                <input type="text" class="form-control" placeholder="Name" name="venues" value="<?= set_value('venues') ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Start Date</label>
                                <input type="date" class="form-control" name="sdate" value="<?= set_value('sdate') ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>End Date</label>
                                <input type="date" class="form-control" name="edate" value="<?= set_value('edate') ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Voting Closes On</label>
                                <input type="date" class="form-control" name="vend" value="<?= set_value('vend') ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Status</label>
                                <select class="form-control show-tick ms select2" name="status" data-placeholder="Select" required>
                                    <option value="" selected>--Select One--</option>
                                    <option value="1">Live</option>
                                    <option value="3">Upcoming</option>
                                    <option value="0">Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Edition Banner</label>
                                <input type="file" class="form-control-file" name="banner" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Share Image <span class="text-primary">(Optional)</span></label>
                                <input type="file" class="form-control-file" name="sbanner">
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-raised btn-primary waves-effect" type="submit">Create Edition</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>