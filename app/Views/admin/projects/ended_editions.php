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
                            <th style="width:50px;">Banner</th>
                            <th>Edition Name</th>
                            <th>Starts On</th>
                            <th>Ends On</th>
                            <th>Votes</th>
                            <th>Boosts</th>
                            <th>Created By</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        <?php foreach ($editions as $edition) : ?>
                            <?php
                            $db = \Config\Database::connect();
                            $boostQuery = $db->query("SELECT SUM(cboost) as boosts FROM vuzpq4kzjwmgblc WHERE cedition=".$db->escape($edition->edref)."")->getRow();
                            $votesQuery = $db->query("SELECT SUM(cvotes) as votes FROM vuzpq4kzjwmgblc WHERE cedition=".$db->escape($edition->edref)."")->getRow();
                            ?>
                            <?php $no++; ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td>
                                    <img class="rounded avatar" src="<?= base_url('assets/web/uploads/projects/' . $edition->edbanner) ?>" alt="Editions" width="30" height="30">
                                </td>
                                <td>
                                    <a class="single-user-name" href="javascript:void(0);"><?= $edition->edname; ?></a><br>
                                </td>
                                <td>
                                    <?= date('d M, Y', strtotime($edition->edstart)); ?>
                                </td>
                                <td>
                                    <?= date('d M, Y', strtotime($edition->edend)); ?>
                                </td>
                                <td>
                                    <?= number_format($votesQuery->votes); ?>
                                </td>
                                <td>
                                    <?= number_format($boostQuery->boosts); ?>
                                </td>
                                <td>
                                    AfricaVotes
                                </td>
                                <td>
                                    <?php $today = date('Y-m-d'); ?>
                                    <?php if ($edition->edend >= $today) : ?>
                                        <span class="badge badge-success">Onging</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Expired</span>
                                    <?php endif; ?>
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