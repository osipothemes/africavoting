<?= $this->extend('web/templates/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="content-wrapper">
    
    <div class="projects__breadcrumb" style="background-image: url(<?= base_url('assets/web/uploads/template/home-bg.png') ?>)">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb__text">
                        <?php
                        $currentDate = new DateTime($project->edend);
                        $yestDay = $currentDate->sub(new DateInterval('P1D'));
                        $yesterday = $yestDay->format('Y-m-d');
                        ?>
                        <h5><?= ucwords($project->edname) ?></h5>
                        <p><span>Online Host:</span> <?= ucwords($project->edvenues) ?></p>
                        <p><span>Date:</span> <?= date('d M, Y', strtotime($project->edstart)) ?> to <?= date('d M, Y', strtotime($project->edend)) ?> | <span>Grand Finale:</span> <?= date('d M, Y', strtotime($project->edend)) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects -->
    <div class="projects">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h6 class="heading-text text-center pt-0 pb-3">VOTING ENDED <?= strtoupper(date('d, M Y', strtotime($project->edvotingend))) ?> <br>VOTING RESULTS</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1 col-md-1 col-12">
                </div>
                <div class="col-lg-10 col-md-10 col-12">
                    <div class="card results-card">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Profiles</th>
                                        <th scope="col">Contestants</th>
                                        <th scope="col">Rank</th>
                                        <th scope="col">Views</th>
                                        <th>Votes (<?= number_format($votes->cvotes) ?>)</th>
                                        <th>Percentage (100%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $rank = 0; ?>
                                    <?php foreach ($contestants as $contestant) : ?>
                                        <?php $rank++; ?>
                                        <tr>
                                            <th scope="row"><img src="<?= base_url('assets/web/uploads/participants/' . $contestant->cimage) ?>" alt="Profile" class="thumbnail img-fluid participant-thumb"></th>
                                            <td>
                                                <p class="pt-3"><?= $contestant->cnames ?> - <?= ucwords($contestant->edname) ?></p>
                                            </td>
                                            <td class="pt-4">#<?= $rank ?></td>
                                            <td class="pt-4"><?= number_format($contestant->cviews) ?></td>
                                            <td class="pt-4"><?= number_format($contestant->cvotes) ?></td>
                                            <td class="pt-4">
                                                <?php $perc = ($contestant->cvotes / $votes->cvotes) * 100; ?>
                                                <div class="progress">
                                                    <div class="progress-bar pl-1 pr-5" role="progressbar" style="width: <?= number_format($perc, 1) ?>%;" aria-valuenow="<?= number_format($perc, 1) ?>" aria-valuemin="0" aria-valuemax="100"><?= number_format($perc, 1) ?>%</div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1 col-md-1 col-12">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h6 class="py-4 text-center"><i class="fas fa-eye"></i> <b><?= number_format($views->edviews) ?> VIEWS</b></h6>
                </div>
            </div>
        </div>
    </div>
    <!-- //End Projects -->

</div>
<?= $this->endSection() ?>