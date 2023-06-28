<div class="modal fade boost-modal" id="boostModal<?= $participant->cid ?>" tabindex="-1" role="dialog" aria-labelledby="myModal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="myModalTitle">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $db = \Config\Database::connect();
                $query = $db->query("SELECT * FROM contestants WHERE cid=" . $db->escape($participant->cid) . "")->getRow();
                ?>
                <div class="vote-info">
                    <p>You Can Boost Your Favourite Contestant With either Mobile Money, Apple Pay, Google Pay ,Bank, 1Voucher Or Any Visa Card</p>
                    <h5>Boost <?= $participant->cnames ?> : <?= ucwords($participant->country_name) ?></h5>
                </div>

                <form action="" method="post">
                    <div class="form-container">
                        <input type="text" id="userid" name="userid" value="<?= $participant->cid ?>" hidden>
                        <input type="text" id="userref" name="userref" value="<?= $participant->cref ?>" hidden>
                        <input type="text" id="edref" name="edref" value="<?= $participant->edref ?>" hidden>
                        <input type="text" id="project" name="project" value="<?= $participant->cproject ?>" hidden>
                        <?php if (auth()->loggedIn()) : ?>
                            <input type="text" id="email" name="email" value="<?= auth()->user()->email ?>" hidden>
                        <?php endif; ?>
                        <div class="form-group">
                            <select class="custom-select" name="amount" id="amount">
                                <option selected>Select Votes</option>
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
                            <select class="custom-select" name="currency" id="currency">
                                <option selected>Select Currency</option>
                                <option value="UGX">UGX</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="button" onclick="makePayment()" class="btn btn-primary b-block">Boost Now</button>
                    </div>
                </form>

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
                logo: "<?= base_url('assets/web/uploads/template/logo-gold.svg') ?>",
            },
        });

    }
</script>