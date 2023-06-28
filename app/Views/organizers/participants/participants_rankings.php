<?= $this->extend('organizers/layouts/app.php') ?>
<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="row clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card project_list">
            <div class="body">
                <div class="basic-form">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group form-float">
                                <select name="edition" class="form-control show-tick ms select2" data-placeholder="Select" id="project" required>
                                    <option value="" selected>Select Project</option>
                                    <?php foreach ($editions as $edition) : ?>
                                        <option value="<?= $edition->edref ?>"><?= $edition->edname ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <select class="form-control show-tick ms select2" id="year" data-placeholder="Select" required>
                                <option value="" selected>Select Year</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-3">
                            <button type="button" id="filterBtn" class="btn btn-primary">Filter Data</button>
                        </div>
                    </div>
                </div>

                <!-- Ranking table -->
                <h5 style="display: none;margin-top:20px;" id="table-heading">Participants Ranking Table</h5>
                <div class="table-responsive" id="participant-table" style="display: none;">
                    <table class="table table-hover c_table theme-color dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Names</th>
                                <th>Rank</th>
                                <th>Year</th>
                                <th>Country</th>
                                <th>Votes</th>
                                <th>Views</th>
                                <th>Boost</th>
                            </tr>
                        </thead>
                        <tbody id="participant-data">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#filterBtn').click(function() {
            var project = $("#project").val();
            var projectyear = $("#year").val();

            if (project == "") {
                alert("Please select project");
            } else if (projectyear == "") {
                alert("Please select project year");
            } else {
                document.getElementById("table-heading").style.display = "block";
                document.getElementById("participant-table").style.display = "block";

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('organizer/participants/rankings/report') ?>",
                    data: {
                        project: project,
                        projectyear: projectyear
                    },
                    dataType: "json",
                    success: function(data) {
                        var table = $("#participant-data");
                        table.empty();
                        var no = 0
                        $.each(data, function(index, item) {
                            no++;
                            table.append("<tr><td>" + no + "</td><td>" + item.cnames + "</td><td>#" + no + "</td><td>" + item.cyear + "</td><td>" + item.country_name + "</td><td>" + item.cvotes + "</td><td>" + item.cviews + "</td><td>" + item.cboost + "</td></tr>");
                        });
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>