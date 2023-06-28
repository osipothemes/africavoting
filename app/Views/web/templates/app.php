<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-74PFB2WWNF"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-74PFB2WWNF');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Africavoting | <?= $this->renderSection('page_title') ?></title>
    <?php include('seo_header.php') ?>
    <link rel="shortcut icon" href="<?= base_url('assets/web/uploads/template/logo-africavoting.png') ?>" type="image/x-icon">
    <!-- CSS Links -->
    <link rel="stylesheet" href="<?= base_url('assets/web/vendors/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/web/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/web/css/style.css?v=1.8') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/web/css/responsive.css') ?>">

    <script src="<?= base_url('assets/web/js/jquery.min.js') ?>"></script>
    <script  src="https://www.google.com/recaptcha/enterprise.js?render=6Lcibo0mAAAAAMMMP1GL-fPj19swFFPByJ5LZyWs"></script>
    <script>
      grecaptcha.enterprise.ready(async () => {
        const token = await grecaptcha.enterprise.execute('6Lcibo0mAAAAAMMMP1GL-fPj19swFFPByJ5LZyWs', {action: 'homepage'});
        // IMPORTANT: The 'token' that results from execute is an encrypted response sent by
        // reCAPTCHA Enterprise to the end user's browser.
        // This token must be validated by creating an assessment.
        // See https://cloud.google.com/recaptcha-enterprise/docs/create-assessment
      });
    </script>
  
</head>

<body>


    <av-wrapper>
        <header>
            <div class="menu-wrapper">
                <div class="container">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="<?= site_url('/') ?>">
                            <img src="<?= base_url('assets/web/uploads/template/logo-africavoting.png') ?>" alt="Africavoting" class="img-fluid">
                        </a>
                        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                        </button>
                        <div class="collapse navbar-collapse" id="collapsibleNavId">
                            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                                <li class="nav-item active">
                                    <a class="nav-link" href="<?= site_url('/') ?>">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= site_url('projects/finished') ?>">Completed</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= site_url('projects/upcoming') ?>">Upcoming</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="#contact-us" data-toggle="modal">Contact Us</a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link" href="#vote-guide" data-toggle="modal">How To Vote</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link organizer__btn" href="<?= site_url('organizer/signup') ?>">Organizers</a>
                                </li>
                            </ul>
                            <form class="form-inline right-items my-2 my-lg-0">
                                <?php if (auth()->loggedIn()) : ?>
                                    <?php if (auth()->user()->inGroup('superadmin', 'admin')) : ?>
                                        <a href="<?= site_url('admin') ?>" class="btn">Dashboard</a>
                                    <?php elseif (auth()->user()->inGroup('beta')) : ?>
                                        <a href="<?= site_url('organizer') ?>" class="btn">Project Dashboard</a>
                                    <?php else : ?>
                                        <a href="#">WELCOME <?= htmlspecialchars(auth()->user()->username); ?></a>
                                    <?php endif; ?>
                                    <a href="<?= site_url('logout') ?>" class="btn btn__register">Logout</a>
                                <?php elseif (session()->has('google_user')) : ?>
                                    <?php $uinfo = session()->get('google_user') ?>
                                    <a href="#">WELCOME <?= $uinfo["secret"] ?></a>
                                    <a href="<?= site_url('users/logout') ?>" class="btn btn__register">Logout</a>
                                <?php else : ?>
                                    <a href="<?= site_url('users/auth') ?>" class="btn">Signin</a>
                                    <a href="<?= site_url('users/auth') ?>" class="btn btn__register">SignUp</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <?= $this->renderSection('body') ?>

        <!-- Footer -->
        <div class="footer__strip">
            <img src="<?= base_url('assets/web/uploads/template/footer-strip.png') ?>" alt="Strip">
        </div>
        <footer>
            <div class="footer-wrapper">
                <div class="container">
                    <div class="row footer__top">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="first__footer">
                                <div class="brand__logo">
                                    <img src="<?= base_url('assets/web/uploads/template/logo-africavoting.png') ?>" alt="Africavoting">
                                </div>
                                <div class="brand_info">
                                    <p>Africavoting is an online, secure easy voting platform that organizers utilize for their fan voting across Africa.</p>
                                </div>
                                <div class="footer__socials">
                                    <a href="#"><i class="fab fa-facebook"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="second__footer">
                                <div class="footer__heading">
                                    <h5>Quick Links</h5>
                                </div>
                                <div class="footer__links">
                                    <ul>
                                        <li><a href="<?= site_url('/') ?>">Home</a></li>
                                        <li><a href="<?= site_url('projects/finished') ?>">Completed Projects</a></li>
                                        <li><a href="<?= site_url('projects/upcoming') ?>">Upcoming Projects</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="second__footer">
                                <div class="footer__heading">
                                    <h5>Company</h5>
                                </div>
                                <div class="footer__links">
                                    <ul>
                                        <li><a href="<?= site_url('terms') ?>">Terms & Conditions</a></li>
                                        <li><a href="<?= site_url('privacy-policy') ?>">Privacy Policy</a></li>
                                        <li><a href="#contact-us" data-toggle="modal">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row footer__bottom">
                        <div class="col-12">
                            <div class="footer__copyright text-center">
                                <p><span>&copy; 2023 AfricaVoting. All Rights Reserved.</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End footer -->

        <!-- Contact Modal -->
        <div class="modal fade" id="contact-us" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title text-center">
                            <h5 class="">Get In Touch</h5>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body contact-modal">
                        <p class="text-center">If you would want to get in touch with us about anything, please use the form below to do so. We will respond. We are always available to respond to you. Every field is necessary.</p>
                        <form action="<?= site_url('contact-us') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" name="firstname" class="form-control" placeholder="First Name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" name="lastname" class="form-control" placeholder="Last Name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Valid Email" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="number" name="mobile" class="form-control" placeholder="Mobile" required>
                                    </div>
                                </div>
                                <?php $db = \Config\Database::connect(); ?>
                                <?php $query = $db->query("SELECT * FROM countries ORDER BY country_name ASC")->getResult(); ?>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select class="custom-select" name="country">
                                            <option selected>Select Country</option>
                                            <?php foreach ($query as $country) : ?>
                                                <option value="<?= $country->country_name ?>"><?= $country->country_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" name="subject" class="form-control" placeholder="Subject">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea name="message" rows="5" class="form-control" placeholder="Your message"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Send Message</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- How to Vote Modal -->
        <div class="modal fade" id="vote-guide" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title text-center">
                            <h5 class="">HOW TO VOTE or BOOST</h5>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>To vote a contestant of choice you have to click on the image of the contestant, two options will be displayed "Vote" and "Boost"</p>
                        <hr>
                        <p>Clicking on "vote" it will prompt you to login or register incase you dont have an account with AfricaVoting, You can register or Login using Email:Password method. The system allows one vote per person everyday or Once as per voting settings</p>
                        <hr>
                        <p>The other option is "Boost", you only need to select the votes you want to boost the contestant with, after that follow the prompts from the payment window that is displayed to you, Note: You can always change the payment method at the side of the payment window to your favourite.</p>
                    </div>
                </div>
            </div>
        </div>

    </av-wrapper>

    <script src="<?= base_url('assets/web/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/web/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/admin/plugins/sweetalert/sweetalert.min.js') ?>"></script>
    <script>
        $(document).ready(function() {
            <?php if (session()->getTempdata('success')) { ?>
                swal("Good job!", "<?= session()->getTempdata('success') ?>", "success");
            <?php } ?>

            <?php if (session()->getTempdata('error')) { ?>
                swal("Opps!", "<?= session()->getTempdata('error') ?>", "error");
            <?php } ?>

        });
    </script>
    <script>
       function onSubmit(token) {
         document.getElementById("vote-form").submit();
       }
       function onBoost(token) {
         document.getElementById("boost-form").submit();
       }
    </script>
</body>

</html>