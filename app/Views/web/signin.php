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
                        <h4>Organizer Login</span></h4>
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
                    <p class="text-center">Login Here. By logging in, you accept our <a href="<?= site_url('terms') ?>">terms</a> and <a href="<?= site_url('privacy-policy') ?>">Privacy Policy</a></p>
                    <form action="<?= url_to('login') ?>" method="post">
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

                            <!--<div class="col-lg-6">-->
                            <!--    <php if (isset($googleButton)) : ?>-->
                            <!--        <a href="<= $googleButton ?>" class="btn btn-danger btn-block"><i class="fab fa-google-plus" aria-hidden="true"></i> Login/Register With Google</a>-->
                            <!--    <php endif; ?>-->
                            <!--</div>-->

                            <!--<div class="col-12 text-center m-3">-->
                            <!--    <b class="text-center m-3">OR</b>-->
                            <!--</div>-->

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" inputmode="text" autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>" required />
                                </div>
                            </div>
                            <div class="col-12">
                                <!-- Remember me -->
                                <?php if (setting('Auth.sessionConfig')['allowRemembering']) : ?>
                                    <p>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="remember" <?php if (old('remember')) : ?> checked<?php endif ?>> Remember Me
                                            </label>
                                        </div>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                            <div class="col-12">
                                <p>
                                    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                                        <a href="<?= site_url('magic-link') ?>">Forgot Password?</a>
                                    <?php endif ?>

                                    <?php if (setting('Auth.allowRegistration')) : ?>
                                        <a href="<?= site_url('register') ?>">Register Here</a>
                                    <?php endif ?>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>