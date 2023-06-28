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
                        <h4>Finished <span>Projects</span></h4>
                        <p>Check out our finished projects</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- // End Breadcrump -->

    <!-- Projects -->
    <div class="projects">
        <div class="container">
            <div class="row">
                <?php if ($projects) : ?>
                    <?php foreach ($projects as $project) : ?>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="card">
                                <img src="<?= base_url('assets/web/uploads/projects/' . $project['edbanner']) ?>" alt="Project" class="img-fluid">
                                <div class="card-overlay">
                                    <div class="overlay-text">
                                        <h6><?= ucwords($project['edname']) ?></h6>
                                        <?php if($project['edstatus'] == 0): ?>
                                            <a href="#" class="btn btn-white">View Results</a>
                                        <?php elseif($project['edstatus'] == 3): ?>
                                            <a href="#" class="btn btn-white">View Results</a>
                                        <?php else: ?>
                                            <a href="<?= site_url('projects/results/' . $project['edslug']) ?>" class="btn btn-white">View Results</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-12">
                        <div class="card py-4">
                            <h5 class="text-center"><b>No Projects Found at the Moment!</b></h5>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="pagination-links">
                        <div class="text-center">
                            <?= $pager->links() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //End Projects -->

</div>
<?= $this->endSection() ?>