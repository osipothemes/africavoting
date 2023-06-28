<?= $this->extend('admin/layouts/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="row clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card project_list">
            <div class="body">
                <div class="basic-form">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group form-float">
                                <select name="edition" class="form-control show-tick ms select2" data-placeholder="Select" required>
                                    <option value="" selected>Select Project</option>
                                    <?php foreach ($editions as $edition) : ?>
                                        <option value="<?= $edition->edref ?>"><?= $edition->edname ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <select class="form-control show-tick ms select2" id="transactions" data-placeholder="Select" required>
                                <option value="" selected>Select Year</option>
                                <option value="2030">2030</option>
                                <option value="2029">2029</option>
                                <option value="2028">2028</option>
                                <option value="2027">2027</option>
                                <option value="2026">2026</option>
                                <option value="2025">2025</option>
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                                <option value="2020">2020</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-3">
                            <button type="button" id="filterBtn" class="btn btn-primary">Filter Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>