<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <title>AfricaVoting :: <?= $this->renderSection('page_title') ?></title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/bootstrap/css/bootstrap.min.css') ?>">
    <!-- JQuery DataTable Css -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/jquery-datatable/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/charts-c3/plugin.css') ?>" />

    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/morrisjs/morris.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/select2/select2.css') ?>" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/style.min.css') ?>">
    <script src="<?= base_url('assets/admin/bundles/libscripts.bundle.js') ?>"></script>
</head>

<body class="theme-blush">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img class="zmdi-hc-spin" src="<?= base_url('assets/admin/images/loader.svg') ?>" width="48" height="48" alt="Aero"></div>
            <p>Please wait...</p>
        </div>
    </div>

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <?php
    $db = \Config\Database::connect();
    $userQuery = $db->query("SELECT * FROM pomar3h6kso5ild WHERE or_id=" . $db->escape(auth()->user()->id) . "")->getRow();
    ?>
    <!-- Right Icon menu Sidebar -->
    <div class="navbar-right">
        <ul class="navbar-nav">
            <li><a href="<?= site_url('organizer/profile/' . $userQuery->info_id) ?>" class="app_group_work" title="Profile"><i class="zmdi zmdi-group-work"></i></a></li>
            <li><a href="<?= site_url('organizer/security-settings/' . auth()->user()->id) ?>" class="js-right-sidebar" title="Setting"><i class="zmdi zmdi-settings zmdi-hc-spin"></i></a></li>
            <li><a href="<?= site_url('logout') ?>" class="mega-menu" title="Sign Out"><i class="zmdi zmdi-power"></i></a></li>
        </ul>
    </div>

    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <div class="navbar-brand">
            <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
            <a href="<?= site_url('manager') ?>"><img src="<?= base_url('assets/web/uploads/template/logo-africavoting.png') ?>" width="25" alt="AfricaVoting"><span class="m-l-10">AfricaVoting</span></a>
        </div>
        <div class="menu">
            <ul class="list">
                <li>
                    <div class="user-info">
                        <a class="image" href="<?= site_url('organizer/profile/' . $userQuery->info_id) ?>"><img src="<?= base_url('assets/web/uploads/template/logo-africavoting.png') ?>" alt="User"></a>
                        <div class="detail">
                            <h4><?= auth()->user()->username ?></h4>
                            <small>Project Admin</small>
                        </div>
                    </div>
                </li>
                <li class="active open"><a href="<?= site_url('organizer') ?>"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>

                <!-- Profile -->
                <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account"></i><span>Profile</span></a>
                    <ul class="ml-menu">
                        <li><a href="<?= site_url('organizer/profile/' . $userQuery->info_id) ?>">Company</a></li>
                        <li><a href="<?= site_url('organizer/security-settings/' . auth()->user()->id) ?>">Security</a></li>
                    </ul>
                </li>

                <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>Projects</span></a>
                    <ul class="ml-menu">
                        <li><a href="<?= site_url('organizer/projects/' . auth()->user()->id) ?>">All Projects</a></li>
                        <li><a href="<?= site_url('organizer/all-editions') ?>">All Editions</a></li>
                        <li><a href="<?= site_url('organizer/running-editions') ?>">Running Editions</a></li>
                        <li><a href="<?= site_url('organizer/ended-editions') ?>">Ended Editions</a></li>
                        <li><a href="<?= site_url('organizer/add-projects') ?>">Add Project</a></li>
                        <li><a href="<?= site_url('organizer/add-edition') ?>">Add Edition</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-swap-alt"></i><span>Participants</span></a>
                    <ul class="ml-menu">
                        <li><a href="<?= site_url('organizer/participants/add-participants') ?>">Add Participants</a></li>
                        <li><a href="<?= site_url('organizer/participants/rankings') ?>">All Participants</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Dashboard</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>"><i class="zmdi zmdi-home"></i> AfricaVoting</a></li>
                        <li class="breadcrumb-item active"><?= $page_title ?></li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <?= $this->renderSection('body') ?>
        </div>
    </section>


    <!-- Jquery Core Js -->
    <script src="<?= base_url('assets/admin/bundles/vendorscripts.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/jquery-validation/jquery.validate.js') ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/ckeditor/ckeditor.js') ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/sweetalert/sweetalert.min.js') ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/select2/select2.min.js') ?>"></script>
    <script src="<?= base_url('assets/admin/bundles/jvectormap.bundle.js') ?>"></script> <!-- JVectorMap Plugin Js -->
    <script src="<?= base_url('assets/admin/bundles/sparkline.bundle.js') ?>"></script> <!-- Sparkline Plugin Js -->
    <script src="<?= base_url('assets/admin/bundles/c3.bundle.js') ?>"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="<?= base_url('assets/admin/bundles/datatablescripts.bundle.js') ?>"></script>
    <!--<script src="<?= base_url('assets/admin/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') ?>"></script>-->
    <!--<script src="<?= base_url('assets/admin/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') ?>"></script>-->
    <!--<script src="<?= base_url('assets/admin/plugins/jquery-datatable/buttons/buttons.colVis.min.js') ?>"></script>-->
    <!--<script src="<?= base_url('assets/admin/plugins/jquery-datatable/buttons/buttons.flash.min.js') ?>"></script>-->
    <!--<script src="<?= base_url('assets/admin/plugins/jquery-datatable/buttons/buttons.html5.min.js') ?>"></script>-->
    <!--<script src="<?= base_url('assets/admin/plugins/jquery-datatable/buttons/buttons.print.min.js') ?>"></script>-->

    <script src="<?= base_url('assets/admin/bundles/mainscripts.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/admin/js/pages/tables/jquery-datatable.js') ?>"></script>
    <script src="<?= base_url('assets/admin/js/pages/forms/advanced-form-elements.js') ?>"></script>
    <script src="<?= base_url('assets/admin/js/pages/forms/editors.js') ?>"></script>
    <script src="<?= base_url('assets/admin/js/pages/forms/form-validation.js') ?>"></script>
    <script src="<?= base_url('assets/admin/js/pages/index.js') ?>"></script>
    <script>
        $(document).ready(function() {
            <?php if (session()->getTempdata('success')) { ?>
                swal("Good job!", "<?= session()->getTempdata('success') ?>", "success");
            <?php } ?>

        });
    </script>
</body>

</html>