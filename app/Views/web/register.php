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
                        <h4>Creating Voting Account</span></h4>
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
                    <p class="text-center">Register below or if you already have an account click on the "Login Here" button below to login.By registering you accept our <a href="<?= site_url('terms') ?>">terms</a> and <a href="<?= site_url('privacy-policy') ?>">Privacy Policy</a></p>
                    <form action="<?= url_to('register') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-12">
                                <h6>Register to Vote</h6>
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
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required />
                                </div>
                            </div>
                            <!--<div class="col-lg-12">-->
                            <!--    <div class="form-group">-->
                            <!--        <input type="text" class="form-control" name="username" inputmode="text" autocomplete="username" placeholder="<= lang('Auth.username') ?>" value="<= old('username') ?>" required />-->
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><?= lang('Auth.register') ?></button>
                                </div>
                            </div>
                            <div class="col-12">
                                <p><a href="<?= site_url('login') ?>">Already Have an Account?</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>