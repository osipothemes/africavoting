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
                        <h4>Login/Register to Vote</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- // End Breadcrump -->

    <div class="auth-form">
        <div class="container">
            <div class="row">
                <div class="col-12 py-5">
                    <p class="text-center">Login/Register below to start voting with AfricaVoting. By registering or logging in, you accept our <a href="<?= site_url('terms') ?>">terms</a> and <a href="<?= site_url('privacy-policy') ?>">Privacy Policy</a></p>
                    <form action="#" method="post">
                        <?= csrf_field() ?>
                        <div class="row">
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

                            <div class="col-lg-12">
                                <?php if (isset($googleButton)) : ?>
                                    <a href="<?= $googleButton ?>" class="btn btn-danger btn-block g-recaptcha"
                                    data-sitekey="6Lcibo0mAAAAAMMMP1GL-fPj19swFFPByJ5LZyWs"
                                    data-callback='onSubmit'
                                    data-action='submit'><i class="fab fa-google-plus" aria-hidden="true"></i> Login/Register With Google</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>