<?= $this->extend('admin/layouts/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="row clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card project_list">
            <div class="table-responsive">
                <table class="table table-hover c_table theme-color">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="width:50px;">Profile</th>
                            <th>Names</th>
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
                                <td>
                                    <img class="rounded avatar" src="<?= base_url('assets/web/uploads/participants/' . $participant->cimage) ?>" alt="Profile" width="40" height="45">
                                </td>
                                <td>
                                    <a class="single-user-name" href="javascript:void(0);"><?= $participant->cnames; ?></a><br>
                                </td>
                                <td>
                                    <?= $participant->edname; ?>
                                </td>
                                <td>
                                    <?= date('Y', strtotime($participant->cyear)); ?>
                                </td>
                                <td>
                                    <?= $participant->country_name; ?>
                                </td>
                                <td>
                                    <?= number_format($participant->cvotes); ?>
                                </td>
                                <td>
                                    <?= number_format($participant->cviews); ?>
                                </td>
                                <td>
                                    <?= number_format($participant->cboost); ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('admin/participants/edit-participant/' . $participant->cid) ?>" class="btn btn-warning btn-sm" title="Edit"><i class="zmdi zmdi-edit"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <ul class="pagination pagination-primary mt-4">
                <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                <!-- <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                <li class="page-item"><a class="page-link" href="javascript:void(0);">4</a></li>
                <li class="page-item"><a class="page-link" href="javascript:void(0);">5</a></li> -->
            </ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>