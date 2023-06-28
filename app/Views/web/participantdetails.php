<?= $this->extend('web/templates/app.php') ?>
<?= $this->section('page_title') ?>
<?= $project->cnames ?>
<?= $this->endSection() ?>

<?= $this->section('seo_summery') ?>
<?= $project->edseo_summery ?>
<?= $this->endSection() ?>

<?= $this->section('seo_keywords') ?>
<?= $project->edseo_keywords ?>
<?= $this->endSection() ?>

<?= $this->section('twitter_summery') ?>
<?= $project->edtwitter_summery ?>
<?= $this->endSection() ?>

<?= $this->section('og_url') ?>
<?= $url ?>
<?= $this->endSection() ?>

<?= $this->section('og_title') ?>
<?= $project->cnames ?>
<?= $this->endSection() ?>

<?= $this->section('og_summery') ?>
<?= $project->edog_summery ?>
<?= $this->endSection() ?>

<?= $this->section('og_image') ?>
<?= base_url('assets/web/uploads/participants/' . $project->cimage) ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="content-wrapper">

    <!-- Projects -->
    <div class="projects project-details">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="text-center heading-text"><b><?= strtoupper($project->pname) ?></b></h5>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card deadline-card">
                        <div class="voting-info">
                            <h6>VOTING ENDS IN:</h6>
                            <?php if ($project->edcustom_date != 1) : ?>
                                <div class="clock">
                                    <p id="days"></p>
                                </div>
                            <?php else : ?>
                                VOTING DATES ARE OPEN
                            <?php endif; ?>
                            <h6>CLICK ON BOOST TO BUY YOUR VOTES</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 contestant-data">
                    <div class="media">
                        <a class="d-flex" href="#">
                            <img src="<?= base_url('assets/web/uploads/participants/' . $project->cimage) ?>" alt="Profile">
                        </a>

                        <div class="media-body my-auto">
                            <div class="body-text my-auto">
                                <?php if (auth()->loggedIn() || session()->has('google_user')) : ?>
                                    <button type="button" class="btn vote-btn" data-toggle="modal" data-target="#vote-modal<?= $project->cid ?>"><i class="fas fa-thumbs-up"></i> Vote</button>
                                    <b class="ml-1">OR</b>
                                    <a href="#boost-modal" onclick="closeCurrent()" data-toggle="modal" class="btn btn-boost"><i class="fas fa-wallet"></i> Boost</a>
                                <?php else : ?>
                                    <button type="button" class="btn vote-btn" data-toggle="modal" data-target="#authmodal"><i class="fas fa-thumbs-up"></i> Vote</button>
                                    <b class="ml-1">OR</b>
                                    <a href="#authmodal" onclick="closeCurrent()" data-toggle="modal" class="btn btn-boost"><i class="fas fa-wallet"></i> Boost</a>
                                <?php endif; ?>

                                <h5><?= ucwords($project->cnames) ?> : <?= ucwords($project->country_name) ?></h5>
                                <p><b>Project: </b><?= $project->pname ?></p>
                                <p><b>Votes: </b><?= number_format($project->cvotes) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 text-center">
                    <h6 class="py-4 text-center"><i class="fas fa-eye"></i> <b><?= number_format($project->cviews) ?> VIEW(S)</b></h6>
                    <a href="<?= site_url('projects/vote/' . $project->edslug) ?>" class="btn btn-primary-outline">View Other Contestants</a>
                </div>
            </div>
        </div>
    </div>
    <!-- //End Projects -->

</div>

<!-- Vote Modal -->
<div class="modal fade vote-modal" id="vote-modal<?= $project->cid ?>" tabindex="-1" role="dialog" aria-labelledby="myModal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="myModalTitle">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('participant/vote/' . $project->edslug) ?>" method="post" id="vote-form">
                    <?= csrf_field() ?>
                    <div class="vote-info">
                        <h5><?= ucwords($project->cnames) ?> : <?= ucwords($project->country_name) ?></h5>
                        <p>Category: <?= ucwords($project->edname) ?>: <?= ucwords($project->country_name) ?></p>

                        <input type="text" name="userid" value="<?= $project->cid ?>" hidden>
                        <input type="text" name="userref" value="<?= $project->cref ?>" hidden>
                        <input type="text" name="edref" value="<?= $project->edref ?>" hidden>
                        <input type="text" name="project" value="<?= $project->cproject ?>" hidden>
                        <?php if (auth()->loggedIn()) : ?>
                            <input type="text" name="email" value="<?= auth()->user()->email ?>" hidden>
                        <?php elseif (session()->has('google_user')) : ?>
                            <?php $uinfo = session()->get('google_user'); ?>
                            <input type="text" name="email" value="<?= $uinfo['secret'] ?>" hidden>
                        <?php endif; ?>
                    </div>
                    <div class="vote-btn">
                        <?php if (auth()->loggedIn() || session()->has('google_user')) : ?>
                            <button type="submit" class="btn btn-primary-outline g-recaptcha"
                            data-sitekey="6Lcibo0mAAAAAMMMP1GL-fPj19swFFPByJ5LZyWs"
                            data-callback='onSubmit'
                            data-action='submit'><i class="fas fa-thumbs-up"></i> Vote</button>
                        <?php else : ?>
                            <button type="button" onclick="loginAlert()" class="btn btn-primary-outline"><i class="fas fa-thumbs-up"></i> Vote</button>
                            <a href="javascript:void(0);" onclick="loginAlert()" class="btn btn-info-outline"><i class="fas fa-wallet"></i> Boost</a>
                        <?php endif; ?>
                    </div>
                </form>
                <span>or share voting below</span>
                <div class="share-btns text-center">
                    <a href="https://twitter.com/intent/tweet?url=<?= site_url('participants/details/' . $project->cref) ?>&amp;text=<?= ucwords($project->cnames) ?>, Vote by following this link&amp;via=africa_voting&amp;hashtags=AfricaVoting" target="_blank" class="twitter"><svg width="45" height="45" viewBox="0 0 24 24">
                            <path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"></path>
                        </svg></a>

                    <a href="whatsapp://send?text=<?= site_url('participants/details/' . $project->cref) ?>" data-action="<?= ucwords($project->cnames) ?>" target="_blank" class="whatsapp"><svg width="45" height="45" viewBox="0 0 24 24">
                            <path d="M20.1 3.9C17.9 1.7 15 .5 12 .5 5.8.5.7 5.6.7 11.9c0 2 .5 3.9 1.5 5.6L.6 23.4l6-1.6c1.6.9 3.5 1.3 5.4 1.3 6.3 0 11.4-5.1 11.4-11.4-.1-2.8-1.2-5.7-3.3-7.8zM12 21.4c-1.7 0-3.3-.5-4.8-1.3l-.4-.2-3.5 1 1-3.4L4 17c-1-1.5-1.4-3.2-1.4-5.1 0-5.2 4.2-9.4 9.4-9.4 2.5 0 4.9 1 6.7 2.8 1.8 1.8 2.8 4.2 2.8 6.7-.1 5.2-4.3 9.4-9.5 9.4zm5.1-7.1c-.3-.1-1.7-.9-1.9-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.1-.2.2-.3.2-.6.1s-1.2-.5-2.3-1.4c-.9-.8-1.4-1.7-1.6-2-.2-.3 0-.5.1-.6s.3-.3.4-.5c.2-.1.3-.3.4-.5.1-.2 0-.4 0-.5C10 9 9.3 7.6 9 7c-.1-.4-.4-.3-.5-.3h-.6s-.4.1-.7.3c-.3.3-1 1-1 2.4s1 2.8 1.1 3c.1.2 2 3.1 4.9 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.7-.7 1.9-1.3.2-.7.2-1.2.2-1.3-.1-.3-.3-.4-.6-.5z"></path>
                        </svg></a>

                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= site_url('participants/details/' . $project->cref) ?>&p[title]=<?= ucwords($project->cnames) ?>" target="_blank" class="facebook"><svg width="45" height="45" viewBox="0 0 24 24">
                            <path d="M17,2V2H17V6H15C14.31,6 14,6.81 14,7.5V10H14L17,10V14H14V22H10V14H7V10H10V6A4,4 0 0,1 14,2H17Z"></path>
                        </svg></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade boost-modal" id="boost-modal" tabindex="-1" role="dialog" aria-labelledby="myModal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="myModalTitle">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="vote-info">
                    <p>You Can Boost Your Favourite Contestant With either Mobile Money, Apple Pay, Google Pay ,Bank, 1Voucher Or Any Visa Card</p>
                    <h5>Boost <?= $project->cnames ?> : <?= ucwords($project->country_name) ?></h5>
                </div>

                <form action="<?= site_url('process-payment') ?>" method="post" id="boost-form">
                    <?= csrf_field() ?>
                    <div class="form-container">
                        <input type="text" name="userid" value="<?= $project->cid ?>" hidden>
                        <input type="text" name="cnames" value="<?= $project->cnames ?>" hidden>
                        <input type="text" name="userref" value="<?= $project->cref ?>" hidden>
                        <input type="text" name="edref" value="<?= $project->edref ?>" hidden>
                        <input type="text" name="project" value="<?= $project->cproject ?>" hidden>
                        <?php if (auth()->loggedIn()) : ?>
                            <input type="text" name="email" value="<?= auth()->user()->email ?>" hidden>
                        <?php elseif (session()->has('google_user')) : ?>
                            <?php $uinfo = session()->get('google_user'); ?>
                            <input type="text" name="email" value="<?= $uinfo['secret'] ?>" hidden>
                        <?php endif; ?>
                        <div class="form-group">
                            <select class="custom-select" name="amount" required>
                                <option value="" selected>Select Votes</option>
                                <option value="300000">500 (300,000Ugx)</option>
                                <option value="200000">250 (200,000Ugx)</option>
                                <option value="100000">150 (100,000Ugx)</option>
                                <option value="50000">50 (50,000Ugx)</option>
                                <option value="30000">35 (30,000Ugx)</option>
                                <option value="15000">20 (15,000Ugx)</option>
                                <option value="10000">10 (10,000Ugx)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <select class="custom-select" name="currency" required>
                                <option selected>Select Currency</option>
                                <option value="UGX">UGX</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary b-block g-recaptcha"
                        data-sitekey="6Lcibo0mAAAAAMMMP1GL-fPj19swFFPByJ5LZyWs"
                        data-callback='onBoost'
                        data-action='submit'>Boost Now</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade auth-modal" id="authmodal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Authentication</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <p>Opps!! Looks like your not logged In. Please login OR create your free account to Vote</p>
                    <div class="auth-btns">
                        <a href="<?= site_url('users/auth') ?>" class="btn btn-primary">Signin</a>
                        <a href="<?= site_url('users/auth') ?>" class="btn btn-info">Register</a> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
    function closeCurrent() {
        $('#vote-modal').modal('hide')
    }

    // Login alert
    function loginAlert() {
        alert("Please login first to Vote");
    }

    // Flutterwave
    function makePayment() {
        var aid = $("#userref").val();
        var amount = $("#amount").val();
        var account_id = $("#edref").val();
        var currency = $("#currency").val();
        var email = $("#email").val();
        var project = $("#project").val();

        FlutterwaveCheckout({
            public_key: "FLWPUBK-813d0b338e89b809b88d0d8e96329916-X",
            tx_ref: "SA_" + Math.floor((Math.random() * 1000000000) + 1),
            amount: amount,
            currency: currency,
            // payment_options: "card",
            redirect_url: "<?= base_url('participants/process-payment') ?>",
            meta: {
                consumer_id: aid,
                charged_amount: amount,
                account_id: account_id,
                project: project,
            },
            customer: {
                email: email,

            },
            customizations: {
                title: "AfricaVoting",
                description: "Participant Boost",
                logo: "<?= base_url('assets/web/uploads/template/logo-africavoting.png') ?>",
            },
        });

    }

    // Set the date we're counting down to
    var countDownDate = new Date("<?= date('M d, Y', strtotime($project->edvotingend)) ?>").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24) + 2);
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("days").innerHTML = days + " <b>DAYS :</b> " + hours + " <b>HOURS : </b> " +
            minutes + " <b>MINUTES : </b> " + seconds + " s ";

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("days").innerHTML = "<b class='text-danger'>EXPIRED</b>";
        }
    }, 1000);
</script>
<?= $this->endSection() ?>