<?= $this->extend('organizers/layouts/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="row clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card project_list">
            <?php if($projects): ?>
                <div class="table-responsive">
                <table class="table table-hover c_table theme-color">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Project Name</th>
                            <th>Editions</th>
                            <th>Project Authors</th>
                            <th>Added To</th>
                            <th>Added On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        <?php foreach ($projects as $project) : ?>
                            <?php $no++; ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td>
                                    <a class="single-user-name" href="javascript:void(0);"><?= $project->pname; ?></a><br>
                                </td>
                                <td>
                                    <?= number_format($project->peditions); ?>
                                </td>
                                <td>
                                    <?= $project->pcreators; ?>
                                </td>
                                <td>
                                    AfricaVotes
                                </td>
                                <td><span class="badge badge-info"><?= date('d M, Y', strtotime($project->pcreated_at)); ?></span></td>
                                <td>
                                    <a href="<?= site_url('organizer/edit-project/' . $project->pid) ?>" class="btn btn-warning btn-sm" title="Edit"><i class="zmdi zmdi-edit"></i></a>
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
            <?php else: ?>
                <h6 class="text-center text-danger pt-5 pb-3">No Projects Found at the Moment</h6>
                <div class="text-center">
                    <a href="<?= site_url('organizer/add-projects') ?>" class="btn btn-primary">Add Projects</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>