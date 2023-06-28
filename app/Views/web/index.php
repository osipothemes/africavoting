<?= $this->extend('web/templates/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>
<?= $this->section('seo_summery') ?>
Africavoting is an online, secure easy voting platform that organizers utilize for their fan voting across Africa.
<?= $this->endSection() ?>

<?= $this->section('seo_keywords') ?>
Online Voting, AfricaVoting, Pageant Voting, Casual Voting, Beauty Pageants, Africa, global voting, secure voting
<?= $this->endSection() ?>

<?= $this->section('twitter_summery') ?>
Africavoting is an online, secure easy voting platform that organizers utilize for their fan voting across Africa.
<?= $this->endSection() ?>

<?= $this->section('og_url') ?>
<?= site_url('/') ?>
<?= $this->endSection() ?>

<?= $this->section('og_title') ?>
Africavoting
<?= $this->endSection() ?>

<?= $this->section('og_summery') ?>
Africavoting is an online, secure easy voting platform that organizers utilize for their fan voting across Africa.
<?= $this->endSection() ?>

<?= $this->section('og_image') ?>
<?= base_url('assets/web/uploads/template/logo-africavoting.png') ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="content-wrapper">
    <!-- Home Banner -->
    <div class="home-banner" style="background-image: linear-gradient(to right, rgba(0,0,0,0.0), rgba(0,0,0,0.0)), url('<?= base_url('assets/web/uploads/template/home-bg.png') ?>');">
        <div class="container">
            <div class="banner-container">
                <div class="row">
                    <div class="col-lg-6 my-auto">
                        <div class="banner-info">
                            <h1>AfricaVoting</h1>
                            <p>Africavoting is an online, secure easy voting platform that organizers utilize for their fan voting across the globe.</p>
                            <a href="<?= site_url('projects/finished') ?>" class="btn btn-outline">Browse Projects</a>
                        </div>
                    </div>
                    <div class="col-lg-6 my-auto">
                        <div class="banner-img">
                            <img src="<?= base_url('assets/web/uploads/template/map-africa.png') ?>" alt="Africa Votes">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="home-strip">
            <img src="<?= base_url('assets/web/uploads/template/strip.png') ?>" alt="Africa Votes">
        </div>
    </div>
    <!-- //End Banner -->

    <!-- Projects -->
    <div class="projects">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="projects__header">
                        <h4 class="text-center">Current <span>Projects</span></h4>
                        <p class="text-center">Check out the current project on our Platform</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($projects as $project) : ?>
                    <?php if ($project->edstatus != 3) : ?>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="card">
                                <img src="<?= base_url('assets/web/uploads/projects/' . $project->edbanner) ?>" alt="Project" class="img-fluid">
                                <div class="card-overlay">
                                    <div class="overlay-text">
                                        <?php
                                        $currentDateTime = new DateTime();
                                        $endDateTime = new DateTime($project->edvotingend);
                                        ?>
                                        <h6><?= ucwords($project->edname) ?></h6>
                                        <?php if($project->edcustom_date == 0): ?>
                                            <?php if ($endDateTime >= $currentDateTime) : ?>
                                                <?php if ($project->edstatus == 1) : ?>
                                                    <a href="<?= site_url('projects/vote/' . $project->edslug) ?>" id="updateEd" class="btn btn-white">Vote Here</a>
                                                <?php else : ?>
                                                    <a href="#" class="btn btn-white">Vote Here</a>
                                                <?php endif; ?>
                                            <?php elseif($project->edcustom_date == 1): ?>
                                                <a href="<?= site_url('projects/vote/' . $project->edslug) ?>" id="updateEd" class="btn btn-white">Vote Here</a>
                                            <?php else : ?>
                                                <?php if ($project->edstatus == 1) : ?>
                                                    <a href="<?= site_url('projects/results/' . $project->edslug) ?>" class="btn btn-white">View Results</a>
                                                <?php elseif($project->edref == 'XFkGh0uDJPsnrfZ'): ?>
                                                    <a href="<?= site_url('projects/results/' . $project->edslug) ?>" class="btn btn-white">View Results</a>
                                                <?php else : ?>
                                                    <a href="#" class="btn btn-white">View Results</a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <a href="<?= site_url('projects/results/' . $project->edslug) ?>" class="btn btn-white">View Results</a>
                                        <?php endif; ?>
                                        <input type="text" id="edid" value="<?= $project->edref ?>" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- //End Projects -->

</div>
<!--<script>-->
<!--    $(document).ready(function() {-->
<!--        $('#updateEd').click(function() {-->
<!--            var edid = $("#edid").val();-->

<!--            $.ajax({-->
<!--                type: "POST",-->
<!--                url: "<= base_url('projects/update-project') ?>",-->
<!--                data: {-->
<!--                    edid: edid,-->
<!--                },-->
<!--                success: function(data) {-->
<!--                    console.log(data);-->
<!--                }-->
<!--            });-->
<!--        });-->
<!--    });-->
<!--</script>-->
<?= $this->endSection() ?>