<?= $this->extend('web/templates/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="content-wrapper">
    <!-- Breadcrump -->
    <div class="projects__breadcrumb" style="background-image: url(<?= base_url('assets/web/uploads/template/home-bg.png') ?>)">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb__text py-3">
                        <h4>Login to Vote</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- // End Breadcrump -->

    <div class="auth-form">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="text-center">Login below or if you dont have an account click on the "Register Here" button below to create an account with AfricaVoting. By registering you accept our <a href="<?= site_url('terms') ?>">terms</a> and <a href="<?= site_url('privacy-policy') ?>">Privacy Policy</a></p>
                    <form action="<?= url_to('login') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-12">
                                <h6>Login to Vote</h6>
                            </div>
                            <div class="col-12">
                                <?php if (session('error') !== null) : ?>
                                    <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                                <?php elseif (session('errors') !== null) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php if (is_array(session('errors'))) : ?>
                                            <?php foreach (session('errors') as $error) : ?>
                                                <?= $error ?>
                                                <br>
                                            <?php endforeach ?>
                                        <?php else : ?>
                                            <?= session('errors') ?>
                                        <?php endif ?>
                                    </div>
                                <?php endif ?>

                                <?php if (session('message') !== null) : ?>
                                    <div class="alert alert-success" role="alert"><?= session('message') ?></div>
                                <?php endif ?>
                            </div>

                            <?php if (isset($loginButton)) : ?>
                                <div class="col-lg-12">
                                    <a href="<?= $loginButton ?>" class="btn btn-primary">Google Login</a>
                                </div>
                            <?php endif; ?>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>