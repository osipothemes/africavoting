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
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        <?php foreach ($admins as $admin) : ?>
                            <?php
                            $db = \Config\Database::connect();
                            $query = $db->query("SELECT * FROM auth_groups_users")->getRow();
                            ?>
                            <?php $no++; ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td>
                                    <?= $admin->username ?>
                                </td>
                                <td>
                                    <?= $admin->secret ?>
                                </td>
                                <td>
                                    <?php if($admin->active == 0): ?>
                                        <span class="badge badge-warning">Pending</span>
                                    <?php else: ?>
                                        <span class="badge badge-primary">Active</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= date('d M, Y', strtotime($admin->created_at)); ?>
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