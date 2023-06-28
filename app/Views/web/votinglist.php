<?= $this->extend('web/templates/app.php') ?>
<?= $this->section('page_title') ?>
<?= $project->edname ?>
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
<?= $project->edname ?>
<?= $this->endSection() ?>

<?= $this->section('og_summery') ?>
<?= $project->edog_summery ?>
<?= $this->endSection() ?>

<?= $this->section('og_image') ?>
<?= base_url('assets/web/uploads/projects/' . $project->edsimage) ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="content-wrapper">

    <div class="projects__breadcrumb" style="background-image: url(<?= base_url('assets/web/uploads/template/home-bg.png') ?>)">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb__text">
                        <?php
                        $startDateTime = new DateTime($project->edstart);
                        $endDateTime = new DateTime($project->edvotingend);
                        $interval = $startDateTime->diff($endDateTime);
                        $days = $interval->days;
                        $hours = $interval->h;
                        $minutes = $interval->i;
                        ?>
                        <?php
                        $currentDate = new DateTime($project->edvotingend);
                        $yestDay = $currentDate->sub(new DateInterval('P1D'));
                        $yesterday = $yestDay->format('Y-m-d h:i:s');
                        ?>
                        <h5><?= ucwords($project->edname) ?></h5>
                        <p class="pl-lg-5 pr-lg-5">
                            <?php if ($project->edcustome != "") : ?>
                                <?= $project->edcustome ?>
                            <?php endif; ?>
                        </p>
                        <?php if ($project->edvenues != "") : ?>
                            <p><span>Venue:</span> <?= ucwords($project->edvenues) ?></p>
                        <?php else : ?>
                        <?php endif; ?>
                        <?php if ($project->edcustom_date != 1) : ?>
                            <p><span>Voting Dates:</span> <?= date('d M, Y', strtotime($project->edstart)) ?> to <?= date('d M, Y', strtotime($project->edvotingend)) ?> | <span>Grand Finale:</span> <?= date('d M, Y', strtotime($project->edend)) ?></p>
                        <?php else : ?>
                            <p><span>Voting Ends:</span> Thursday 15th, 2023. 18:00:00 </p>
                        <?php endif; ?>
                        <p><span>Participating countries :</span>
                            <?php foreach ($countries as $country) : ?>
                                <?= $country->country_name ?> |
                            <?php endforeach; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Projects -->
    <div class="projects">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card deadline-card">
                        <div class="voting-info">
                            <?php if($project->edcustom_date != 1): ?>
                            <h6>VOTING ENDS IN:</h6>
                            <div class="clock">
                                <p id="days"></p>
                            </div>
                            <?php else: ?>
                            <h6>VOTING ENDS ON:</h6>
                            <?php
                            $start_time = '10:30:00';
                            $end_time = '15:45:30';
                            $format = 'H:i:s';
                            // Convert start and end times to DateTime objects
                            $start = DateTime::createFromFormat($format, $start_time);
                            $end = DateTime::createFromFormat($format, $end_time);
                            // Calculate the time difference
                            $time_diff = $end->diff($start);
                            ?>
                            <b class="pb-3">Thursday 15th, 2023. 18:00:00 Hrs</b>
                            <!--VOTING DATES ARE OPEN-->
                            <?php endif; ?>
                            <h6 class="pt-2">CLICK ON VOTE BUTTON TO VOTE OR BOOST TO BUY VOTES, YOU ONLY VOTE ONCE EVERY DAY BUT THERE IS NO LIMIT TO BOOSTING PER DAY</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-12">
                    <h6 class="text-center">Share This Voting</h6>
                </div>
                <div class="col-12">
                    <div class="share-btns text-center">
                        <a href="https://twitter.com/intent/tweet?url=<?= site_url('projects/vote/' . $project->edslug) ?>&amp;text=<?= ucwords($project->edname) ?>, Vote by following this link&amp;via=africa_voting&amp;hashtags=AfricaVoting" target="_blank" class="twitter"><svg width="45" height="45" viewBox="0 0 24 24">
                                <path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"></path>
                            </svg></a>

                        <a href="whatsapp://send?text=<?= site_url('projects/vote/' . $project->edslug) ?>" target="_blank" class="whatsapp"><svg width="45" height="45" viewBox="0 0 24 24">
                                <path d="M20.1 3.9C17.9 1.7 15 .5 12 .5 5.8.5.7 5.6.7 11.9c0 2 .5 3.9 1.5 5.6L.6 23.4l6-1.6c1.6.9 3.5 1.3 5.4 1.3 6.3 0 11.4-5.1 11.4-11.4-.1-2.8-1.2-5.7-3.3-7.8zM12 21.4c-1.7 0-3.3-.5-4.8-1.3l-.4-.2-3.5 1 1-3.4L4 17c-1-1.5-1.4-3.2-1.4-5.1 0-5.2 4.2-9.4 9.4-9.4 2.5 0 4.9 1 6.7 2.8 1.8 1.8 2.8 4.2 2.8 6.7-.1 5.2-4.3 9.4-9.5 9.4zm5.1-7.1c-.3-.1-1.7-.9-1.9-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.1-.2.2-.3.2-.6.1s-1.2-.5-2.3-1.4c-.9-.8-1.4-1.7-1.6-2-.2-.3 0-.5.1-.6s.3-.3.4-.5c.2-.1.3-.3.4-.5.1-.2 0-.4 0-.5C10 9 9.3 7.6 9 7c-.1-.4-.4-.3-.5-.3h-.6s-.4.1-.7.3c-.3.3-1 1-1 2.4s1 2.8 1.1 3c.1.2 2 3.1 4.9 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.7-.7 1.9-1.3.2-.7.2-1.2.2-1.3-.1-.3-.3-.4-.6-.5z"></path>
                            </svg></a>

                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= site_url('projects/vote/' . $project->edslug) ?>" target="_blank" class="facebook"><svg width="45" height="45" viewBox="0 0 24 24">
                                <path d="M17,2V2H17V6H15C14.31,6 14,6.81 14,7.5V10H14L17,10V14H14V22H10V14H7V10H10V6A4,4 0 0,1 14,2H17Z"></path>
                            </svg></a>
                    </div>
                </div>
            </div>

            <div class="row contestants">
                <!-- Item -->
                <?php foreach ($participants as $participant) : ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-5">
                        <span><?= number_format($participant->cvotes) ?> Votes</span>
                        <div class="card">
                            <img src="<?= base_url('assets/web/uploads/participants/' . $participant->cimage) ?>" alt="Profile">
                            <div class="overlay-voting">
                                <?php if (auth()->loggedIn() || session()->has('google_user')) : ?>
                                    <button type="button" class="btn vote-btn" data-toggle="modal" data-target="#vote-modal<?= $participant->cid ?>"><i class="fas fa-thumbs-up"></i> Vote</button>
                                    <b class="ml-1">OR</b>
                                    <a href="<?= site_url('participants/details/' . $participant->cref) ?>" id="updatePat" class="btn btn-boost"><i class="fas fa-wallet"></i> Boost</a>
                                    <!--<php include('partials/boostModal.php') ?>-->

                                <?php else : ?>
                                    <button type="button" data-target="#authmodal" data-toggle="modal" class="btn vote-btn"><i class="fas fa-thumbs-up"></i> Vote</button>
                                    <b class="ml-1">OR</b>
                                    <a href="javascript:void(0);" data-target="#authmodal" data-toggle="modal" class="btn btn-boost"><i class="fas fa-wallet"></i> Boost</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="#"><?= ucwords($participant->cnames) ?></a>
                        <input type="text" id="cref" value="<?= $participant->cref ?>" hidden>
                    </div>

                    <!-- Vote Modal -->
                    <div class="modal fade vote-modal" id="vote-modal<?= $participant->cid ?>" tabindex="-1" role="dialog" aria-labelledby="myModal-label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!-- <h5 class="modal-title" id="myModalTitle">Modal title</h5> -->
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= site_url('projects/vote/' . $participant->edslug) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <div class="vote-info">
                                            <h5><?= ucwords($participant->cnames) ?> : <?= ucwords($participant->country_name) ?></h5>
                                            <p>Category: <?= ucwords($participant->edname) ?>: <?= ucwords($participant->country_name) ?></p>

                                            <input type="text" id="userid" name="userid" value="<?= $participant->cid ?>" hidden>
                                            <input type="text" id="userref" name="userref" value="<?= $participant->cref ?>" hidden>
                                            <input type="text" id="edref" name="edref" value="<?= $participant->edref ?>" hidden>
                                            <input type="text" id="project" name="project" value="<?= $participant->cproject ?>" hidden>
                                            <?php if (auth()->loggedIn()) : ?>
                                                <input type="text" name="email" value="<?= auth()->user()->email ?>" hidden>
                                            <?php elseif (session()->has('google_user')) : ?>
                                                <?php $uinfo = session()->get('google_user'); ?>
                                                <input type="text" name="email" value="<?= $uinfo['secret'] ?>" hidden>
                                            <?php endif; ?>
                                            
                                        </div>
                                        <div class="vote-btn">
                                            <?php if (auth()->loggedIn() || session()->has('google_user')) : ?>
                                                <button type="submit" class="btn btn-primary-outline"><i class="fas fa-thumbs-up"></i> Vote</button>
                                            <?php else : ?>
                                                <button type="button" onclick="loginAlert()" class="btn btn-primary-outline"><i class="fas fa-thumbs-up"></i> Vote</button>
                                                <a href="javascript:void(0);" onclick="loginAlert()" class="btn btn-info-outline"><i class="fas fa-wallet"></i> Boost</a>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                    <span>or share voting below</span>
                                    <div class="share-btns text-center">
                                        <a href="https://twitter.com/intent/tweet?url=<?= site_url('participants/details/' . $participant->cref) ?>&amp;text=<?= ucwords($participant->cnames) ?>, Vote by following this link&amp;via=africa_voting&amp;hashtags=AfricaVoting" target="_blank" class="twitter"><svg width="45" height="45" viewBox="0 0 24 24">
                                                <path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"></path>
                                            </svg></a>

                                        <a href="whatsapp://send?text=<?= site_url('participants/details/' . $participant->cref) ?>" data-action="<?= ucwords($participant->cnames) ?>" target="_blank" class="whatsapp"><svg width="45" height="45" viewBox="0 0 24 24">
                                                <path d="M20.1 3.9C17.9 1.7 15 .5 12 .5 5.8.5.7 5.6.7 11.9c0 2 .5 3.9 1.5 5.6L.6 23.4l6-1.6c1.6.9 3.5 1.3 5.4 1.3 6.3 0 11.4-5.1 11.4-11.4-.1-2.8-1.2-5.7-3.3-7.8zM12 21.4c-1.7 0-3.3-.5-4.8-1.3l-.4-.2-3.5 1 1-3.4L4 17c-1-1.5-1.4-3.2-1.4-5.1 0-5.2 4.2-9.4 9.4-9.4 2.5 0 4.9 1 6.7 2.8 1.8 1.8 2.8 4.2 2.8 6.7-.1 5.2-4.3 9.4-9.5 9.4zm5.1-7.1c-.3-.1-1.7-.9-1.9-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.1-.2.2-.3.2-.6.1s-1.2-.5-2.3-1.4c-.9-.8-1.4-1.7-1.6-2-.2-.3 0-.5.1-.6s.3-.3.4-.5c.2-.1.3-.3.4-.5.1-.2 0-.4 0-.5C10 9 9.3 7.6 9 7c-.1-.4-.4-.3-.5-.3h-.6s-.4.1-.7.3c-.3.3-1 1-1 2.4s1 2.8 1.1 3c.1.2 2 3.1 4.9 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.7-.7 1.9-1.3.2-.7.2-1.2.2-1.3-.1-.3-.3-.4-.6-.5z"></path>
                                            </svg></a>

                                        <a href="https://www.facebook.com/sharer/sharer.php?p[images][0]=<?= base_url('assets/web/uploads/participants/' . $participant->cimage) ?>&u=<?= site_url('participants/details/' . $participant->cref) ?>&p[title]=<?= ucwords($participant->cnames) ?>" target="_blank" class="facebook"><svg width="45" height="45" viewBox="0 0 24 24">
                                                <path d="M17,2V2H17V6H15C14.31,6 14,6.81 14,7.5V10H14L17,10V14H14V22H10V14H7V10H10V6A4,4 0 0,1 14,2H17Z"></path>
                                            </svg></a>
                                        <!-- <a href="https://www.facebook.com/sharer/sharer.php?u=<= site_url('participants/details/' . $participant->cref) ?>" target="_blank" class="facebook"><svg width="45" height="45" viewBox="0 0 24 24">
                                                <path d="M17,2V2H17V6H15C14.31,6 14,6.81 14,7.5V10H14L17,10V14H14V22H10V14H7V10H10V6A4,4 0 0,1 14,2H17Z"></path>
                                            </svg></a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

            <div class="row">
                <div class="col-12">
                    <h6 class="py-4 text-center"><i class="fas fa-eye"></i>VIEWS <b><?= number_format($views->edviews) ?></b></h6>
                </div>
            </div>
        </div>
    </div>
    <!-- //End Projects -->

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

<script>
    // Login alert
    function loginAlert() {
        alert("Please login first to Vote");
    }


    $('#updatePat').click(function() {
        var cref = $("#cref").val();

        $.ajax({
            type: "POST",
            url: "<?= base_url('participants/update-participant') ?>",
            data: {
                cref: cref,
            },
            // dataType: "json",
            success: function(data) {
                console.log(data);
            }
        });
    });

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
            document.getElementById("days").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>
<!-- Vote -->
<?= $this->endSection() ?>