<?= $this->extend('admin/layouts/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="row clearfix">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card state_w1">
            <div class="body d-flex justify-content-between">
                <div>
                    <h5>
                        <?php if($projects): ?>
                            <?= number_format($projects) ?>
                        <?php else: ?>
                            0
                        <?php endif; ?>
                    </h5>
                    <span><i class="zmdi zmdi-eye col-amber"></i> Projects</span>
                </div>
                <div class="sparkline" data-type="bar" data-width="97%" data-height="55px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#FFC107">5,2,3,7,6,4,8,1</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card state_w1">
            <div class="body d-flex justify-content-between">
                <div>                                
                    <h5>
                        <?php if($editions): ?>
                            <?= number_format($editions) ?>
                        <?php else: ?>
                            0
                        <?php endif; ?>
                    </h5>
                    <span><i class="zmdi zmdi-thumb-up col-blue"></i> Editions</span>
                </div>
                <div class="sparkline" data-type="bar" data-width="97%" data-height="55px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#46b6fe">8,2,6,5,1,4,4,3</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card state_w1">
            <div class="body d-flex justify-content-between">
                <div>
                    <h5>
                        <?php if($organizers): ?>
                            <?= number_format($organizers) ?>
                        <?php else: ?>
                            0
                        <?php endif; ?>
                    </h5>
                    <span><i class="zmdi zmdi-comment-text col-red"></i> Organizers</span>
                </div>
                <div class="sparkline" data-type="bar" data-width="97%" data-height="55px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#ee2558">4,4,3,9,2,1,5,7</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card state_w1">
            <div class="body d-flex justify-content-between">
                <div>                            
                    <h5>
                        <?php if($users): ?>
                            <?= number_format($users) ?>
                        <?php else: ?>
                            0
                        <?php endif; ?>
                    </h5>
                    <span><i class="zmdi zmdi-account text-success"></i> Users</span>
                </div>
                <div class="sparkline" data-type="bar" data-width="97%" data-height="55px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#04BE5B">7,5,3,8,4,6,2,9</div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-md-12 col-lg-4">
        <div class="card">
            <div class="body">
                <h3 class="mt-0 mb-0">
                    <?php if($sumBoosts): ?>
                        <?= number_format($sumBoosts->cboost) ?>
                    <?php else: ?>
                        0
                    <?php endif; ?>
                </h3>
                <p class="text-muted">Total Boosts</p>
                <div class="progress">
                    <div class="progress-bar l-amber" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                </div>
                <small>Entire Projects Boosts</small>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card">
            <div class="body">
                <h3 class="mt-0 mb-0">
                    <?php if($sumVotes): ?>
                        <?= number_format($sumVotes->cvotes) ?>
                    <?php else: ?>
                        0
                    <?php endif; ?>
                </h3>
                <p class="text-muted">Total Votes</p>
                <div class="progress">
                    <div class="progress-bar l-pink" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                </div>
                <small>Entire Projects Votes</small>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card">
            <div class="body">
                <h3 class="mt-0 mb-0">
                    <?php if($sumViews): ?>
                        <?= number_format($sumViews->edviews) ?>
                    <?php else: ?>
                        0
                    <?php endif; ?>
                </h3>
                <p class="text-muted">Total Views</p>
                <div class="progress">
                    <div class="progress-bar l-green" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                </div>
                <small>Entire Projects Views</small>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Exportable</strong> Examples </h2>
            </div>
            <?php
            $db = \Config\Database::connect();
            $query = $db->query("SELECT * FROM 0z2aay19hqmgsf4 WHERE voted_participant=".$db->escape('xFomZs7WcMKE0be')." ORDER BY votingid DESC")->getResult();

            ?>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>C.reference</th>
                                <!--<th>C.Names</th>-->
                                <th>Voter Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; ?>
                            <?php foreach($query as $data): ?>
                                <?php $no++; ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $data->voted_participant ?></td>
                                <!--<td><= $data->cnames ?></td>-->
                                <td><?= $data->voter_email ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>