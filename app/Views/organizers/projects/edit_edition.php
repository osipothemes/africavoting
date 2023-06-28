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
                <form id="form_validation" method="POST" action="<?= site_url('organizer/edit-edition/'.$edition->edid) ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="form-group form-float">
                        <label>Edition Name</label>
                        <input type="text" class="form-control" name="name" value="<?= $edition->edname ?>" required>
                    </div>
                    <div class="form-group form-float">
                        <label>Slug <span class="text-primary">Auto-generated</span></label>
                        <input type="text" value="<?= $edition->edslug ?>" class="form-control" disabled>
                    </div>
                    <div class="form-group form-float">
                        <label>Host Venues</label>
                        <input type="text" class="form-control" name="venues" value="<?= $edition->edvenues ?>" required>
                    </div>
                    <div class="form-group form-float">
                        <label>SEO Summery</label>
                        <textarea type="text" class="form-control" name="edseo_summery" required><?= $edition->edseo_summery ?></textarea>
                    </div>
                    <div class="form-group form-float">
                        <label>SEO Keywords</label>
                        <textarea type="text" class="form-control" name="edseo_keywords" required><?= $edition->edseo_keywords ?></textarea>
                    </div>
                    <div class="form-group form-float">
                        <label>Twitter Summery</label>
                        <textarea type="text" class="form-control" name="edtwitter_summery" required><?= $edition->edtwitter_summery ?></textarea>
                    </div>
                    <div class="form-group form-float">
                        <label>Social Summery</label>
                        <textarea type="text" class="form-control" name="edog_summery" required><?= $edition->edog_summery ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Start Date</label>
                                <input type="date" class="form-control" name="sdate" value="<?= $edition->edstart ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>End Date</label>
                                <input type="date" class="form-control" name="edate" value="<?= $edition->edend ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Project</label>
                                <select name="project" class="form-control show-tick ms select2" data-placeholder="Select">
                                    <option value="<?= $edition->edproject ?>" selected><?= $edition->pname ?></option>
                                    <?php foreach ($projects as $project) : ?>
                                        <option value="<?= $project->pref ?>"><?= $project->pname ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Voting Closes On</label>
                                <input type="date" class="form-control" name="vend" value="<?= $edition->edvotingend ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Edition Banner <span class="text-primary">(Optional)</span></label>
                                <input type="file" class="form-control-file" name="banner">
                                <input type="text" class="form-control" value="<?= $edition->edbanner ?>" name="old_image" hidden>
                                <br>
                                <img src="<?= base_url('assets/web/uploads/projects/'.$edition->edbanner) ?>" alt="Banner" width="100" class="thumbnail">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-float">
                                <label>Share Image <span class="text-primary">(Optional)</span></label>
                                <input type="file" class="form-control-file" name="sbanner">
                                <input type="text" class="form-control" value="<?= $edition->edsimage ?>" name="old_simage" hidden>
                                <br>
                                <img src="<?= base_url('assets/web/uploads/projects/'.$edition->edsimage) ?>" alt="Banner" width="100" class="thumbnail">
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-raised btn-primary waves-effect" type="submit">Update Edition</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>