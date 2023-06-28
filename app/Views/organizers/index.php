<?= $this->extend('organizers/layouts/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong><i class="zmdi zmdi-chart"></i></strong> Reports</h2>
                <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    </li>
                </ul>
            </div>
            <div class="body mb-2">
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="state_w1 mb-1 mt-1">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>
                                        <?php if ($projects) : ?>
                                            <?= number_format($projects) ?>
                                        <?php else : ?>
                                            0
                                        <?php endif; ?>
                                    </h5>
                                    <span><i class="zmdi zmdi-balance"></i> Projects</span>
                                </div>
                                <div class="sparkline" data-type="bar" data-width="97%" data-height="55px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#868e96">5,2,3,7,6,4,8,1</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="state_w1 mb-1 mt-1">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>
                                        <?php if ($count_participants) : ?>
                                            <?= $count_participants ?>
                                        <?php else : ?>
                                            0
                                        <?php endif; ?>
                                    </h5>
                                    <span><i class="zmdi zmdi-accounts"></i> Participants</span>
                                </div>
                                <div class="sparkline" data-type="bar" data-width="97%" data-height="55px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#2bcbba">8,2,6,5,1,4,4,3</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="state_w1 mb-1 mt-1">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>
                                        <?php if ($boosts) : ?>
                                            Ugx<?= number_format($boosts->cboost) ?>
                                        <?php else : ?>
                                            Ugx0
                                        <?php endif; ?>
                                    </h5>
                                    <span><i class="zmdi zmdi-balance-wallet"></i> Total Boosts</span>
                                </div>
                                <div class="sparkline" data-type="bar" data-width="97%" data-height="55px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#82c885">4,4,3,9,2,1,5,7</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="state_w1 mb-1 mt-1">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>
                                        <?php if ($views) : ?>
                                            <?= number_format($views->edviews) ?>
                                        <?php else : ?>
                                            0
                                        <?php endif; ?>
                                    </h5>
                                    <span><i class="zmdi zmdi-eye"></i> Total Views</span>
                                </div>
                                <div class="sparkline" data-type="bar" data-width="97%" data-height="55px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#45aaf2">7,5,3,8,4,6,2,9</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="body">
                <h5>Recent Participants</h5>
                <div class="table-responsive">
                    <table class="table table-hover c_table theme-color dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Ref</th>
                                <th style="width:50px;">Profile</th>
                                <th>Names</th>
                                <th>Rank</th>
                                <th>Project</th>
                                <th>Year</th>
                                <th>Country</th>
                                <th>Votes</th>
                                <th>Views</th>
                                <th>Boost</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; ?>
                            <?php foreach ($participants as $participant) : ?>
                                <?php $no++; ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $participant->cref; ?></td>
                                    <td>
                                        <img class="rounded avatar" src="<?= base_url('assets/web/uploads/participants/' . $participant->cimage) ?>" alt="Profile" width="40" height="45">
                                    </td>
                                    <td>
                                        <a class="single-user-name" href="javascript:void(0);"><?= substr($participant->cnames, 0, 30) . "..."; ?></a><br>
                                    </td>
                                    <td>
                                        <b>#<?= $no; ?></b>
                                    </td>
                                    <td>
                                        <?= $participant->edname; ?>
                                    </td>
                                    <td>
                                        <?= date('Y', strtotime($participant->cyear)); ?>
                                    </td>
                                    <td>
                                        <?= substr($participant->country_name, 0, 10) . "..."; ?>
                                    </td>
                                    <td>
                                        <?= number_format($participant->cvotes); ?>
                                    </td>
                                    <td>
                                        <?= number_format($participant->cviews); ?>
                                    </td>
                                    <td>
                                        Ugx<?= number_format($participant->cboost); ?>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('organizer/participants/edit-participant/' . $participant->cid) ?>" class="btn btn-warning btn-sm" title="Edit"><i class="zmdi zmdi-edit"></i></a>
                                    </td>
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