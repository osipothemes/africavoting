<?= $this->extend('web/templates/app.php') ?>


<?= $this->section('body') ?>
<div class="content-wrapper">

    <div class="auth-form">
        <div class="container pt-5">
            <div class="row">
                <div class="col-12">
                    <h5 class="text-center"><?= lang('Auth.emailActivateTitle') ?></h5>
                    <form action="<?= site_url('auth/a/verify') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-12">
                                <p><?= lang('Auth.emailActivateBody') ?></p>
                            </div>
                            <div class="col-12">
                            <?php if (session('error')) : ?>
                                <div class="alert alert-danger"><?= session('error') ?></div>
                            <?php endif ?>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                <input type="text" class="form-control" name="token" placeholder="000000" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" value="<?= old('token') ?>" required />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><?= lang('Auth.send') ?></button>
                                </div>
                            </div>
                            <div class="col-12">
                                <p>
                                    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                                        <a href="<?= site_url('magic-link') ?>">Forgot Password?</a>
                                    <?php endif ?>
                                    <b>OR</b>
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