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
                            <th style="width:50px;">Names</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Country</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        <?php foreach ($organizers as $organizer) : ?>
                            <?php $no++; ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td>
                                    <?= $organizer->or_firstname." ".$organizer->or_lastname ?>
                                </td>
                                <td>
                                    <a class="single-user-name" href="javascript:void(0);"><?= $organizer->or_company_name; ?></a><br>
                                </td>
                                <td>
                                    <?= $organizer->secret; ?>
                                </td>
                                <td>
                                    <?= $organizer->or_company_phone; ?>
                                </td>
                                <td>
                                    <?= $organizer->country_name; ?>
                                </td>
                                <td>
                                    <?php if($organizer->or_active == 0): ?>
                                        <span class="badge badge-warning">Pending</span>
                                    <?php else: ?>
                                        <span class="badge badge-primary">Active</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= date('d M, Y', strtotime($organizer->or_created_at)); ?>
                                </td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#activateModal<?= $organizer->or_id ?>" class="btn btn-warning btn-sm" title="Activate"><i class="zmdi zmdi-settings"></i></a>
                                    <a href="<?= site_url('admin/projects/edit-edition/' . $organizer->or_id) ?>" class="btn btn-info btn-sm" title="Edit"><i class="zmdi zmdi-eye"></i></a>
                                </td>
                            </tr>

                            <div class="modal fade" id="activateModal<?= $organizer->or_id ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="title" id="defaultModalLabel">Activate Account</h4>
                                        </div>
                                        <div class="modal-body"> 
                                            <form action="<?= site_url('admin/organizers/activate-organizer/' . $organizer->or_id) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <p>Your about to activate the account status for <b><?= $organizer->or_company_name ?></b></p>
                                            <button type="submit" class="btn btn-danger">Continue</button>
                                        </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-round" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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