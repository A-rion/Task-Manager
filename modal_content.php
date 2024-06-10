<div class="modal fade" id="attendance" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered m-5">
        <div class="modal-content">
            <div class="modal-header cus-td p-2" style="background-color: #0C2D57; display: block;">
                <h5 class="modal-title text-white">Attendance</h5>
            </div>
            <div class="modal-body" style="background-color: #cedbe4;">
                <?php if($_SESSION['role']!='admin') { ?>
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="attendance.php">
                    <div class="m-2">
                        <strong>
                            My Attendance
                        </strong>
                    </div>
                </a>
                <hr>
                <?php } if($_SESSION['role']!='employee') { ?>
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="team_attendance.php">
                    <div class="m-2">
                        <strong>
                            Team Attendance
                        </strong>
                    </div>
                </a>
                <hr>
                <?php } if($_SESSION['role']!='admin') { ?>
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="myleave.php">
                    <div class="m-2">
                        <strong>
                            My Leaves
                        </strong>
                    </div>
                </a>
                <hr>
                <?php } if($_SESSION['role']!='employee') { ?>
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="team_leaves.php">
                    <div class="m-2">
                        <strong>
                            Team Leaves
                        </strong>
                    </div>
                </a>
                <?php } ?>
            </div>
            <div class="modal-footer" style="background-color: #0C2D57;">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="manage" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered m-5">
        <div class="modal-content">
            <div class="modal-header p-2" style="background-color: #0C2D57; display: block;">
                <h5 class="modal-title cus-td text-white">Manage</h5>
            </div>
            <div class="modal-body" style="background-color: #cedbe4;">
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="team_member.php">
                    <div class="m-2">
                        <strong>
                            Team Member
                        </strong>
                    </div>
                </a>
                <hr>
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="team.php">
                    <div class="m-2">
                        <strong>
                            Team List
                        </strong>
                    </div>
                </a>
                <hr>
                <?php if($_SESSION['role']=='admin') { ?>
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="bucket.php">
                    <div class="m-2">
                        <strong>
                            Bucket List
                        </strong>
                    </div>
                </a>
                <hr>
                <?php } ?>
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="task_list.php">
                    <div class="m-2">
                        <strong>
                            Task List
                        </strong>
                    </div>
                </a>
            </div>
            <div class="modal-footer" style="background-color: #0C2D57;">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="settings" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered m-5">
        <div class="modal-content">
            <div class="modal-header p-2" style="background-color: #0C2D57; display: block;">
                <h5 class="modal-title cus-td text-white">Settings</h5>
            </div>
            <div class="modal-body" style="background-color: #cedbe4;">
                <?php if($_SESSION['role']=='manager' || $_SESSION['role']=='assistant') { ?>
                <a class="isDisabled" style="text-decoration: none; color: rgb(2, 28, 59);">
                    <div class="m-2">
                        <strong>
                            Holiday List
                        </strong>
                    </div>
                </a>
                <hr>
                <?php } if($_SESSION['role']=='admin') { ?>
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="holidaylist.php">
                    <div class="m-2">
                        <strong>
                            Holiday List
                        </strong>
                    </div>
                </a>
                <hr>
                <?php } ?>
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="leave.php">
                    <div class="m-2">
                        <strong>
                            Leave Notification
                        </strong>
                    </div>
                </a>
            </div>
            <div class="modal-footer" style="background-color: #0C2D57;">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="onboarding" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered m-5">
        <div class="modal-content">
            <div class="modal-header p-2" style="background-color: #0C2D57; display: block;">
                <h5 class="modal-title cus-td text-white">BroadBand Onboarding</h5>
            </div>
            <div class="modal-body" style="background-color: #cedbe4;">
                <?php if($_SESSION['role']=='employee') { ?>
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="application.php">
                    <div class="m-2">
                        <strong>
                            Submit Application
                        </strong>
                    </div>
                </a>
                <hr>
                <?php } else { ?>
                <a class="isDisabled" style="text-decoration: none; color: rgb(2, 28, 59);">
                    <div class="m-2">
                        <strong>
                            Submit Application
                        </strong>
                    </div>
                </a>
                <hr>
                <?php } if($_SESSION['role']!='employee') { ?>
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="broadband_application.php">
                    <div class="m-2">
                        <strong>
                            Application List
                        </strong>
                    </div>
                </a>
                <?php } else { ?>
                <a class="isDisabled" style="text-decoration: none; color: rgb(2, 28, 59);">
                    <div class="m-2">
                        <strong>
                            Application List
                        </strong>
                    </div>
                </a>
                <?php } ?>
            </div>
            <div class="modal-footer" style="background-color: #0C2D57;">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="issue" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered m-5">
        <div class="modal-content">
            <div class="modal-header p-2" style="background-color: #0C2D57; display: block;">
                <h5 class="modal-title cus-td text-white">Daily Issue Report</h5>
            </div>
            <div class="modal-body" style="background-color: #cedbe4;">
                <?php if($_SESSION['role']=='employee') { ?>
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="issues.php">
                    <div class="m-2">
                        <strong>
                            Submit Report
                        </strong>
                    </div>
                </a>
                <hr>
                <?php } else { ?>
                <a class="isDisabled" style="text-decoration: none; color: rgb(2, 28, 59);">
                    <div class="m-2">
                        <strong>
                            Submit Report
                        </strong>
                    </div>
                </a>
                <hr>
                <?php } if($_SESSION['role']!='employee') { ?>
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="issue_report.php">
                    <div class="m-2">
                        <strong>
                            Report List
                        </strong>
                    </div>
                </a>
                <?php } else { ?>
                <a class="isDisabled" style="text-decoration: none; color: rgb(2, 28, 59);">
                    <div class="m-2">
                        <strong>
                            Report List
                        </strong>
                    </div>
                </a>
                <?php } ?>
            </div>
            <div class="modal-footer" style="background-color: #0C2D57;">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="comp" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered m-5">
        <div class="modal-content">
            <div class="modal-header p-2" style="background-color: #0C2D57; display: block;">
                <h5 class="modal-title cus-td text-white">Company Management</h5>
            </div>
            <div class="modal-body" style="background-color: #cedbe4;">
                <a style="text-decoration: none; color: rgb(2, 28, 59);" data-bs-toggle="modal"
                    data-bs-target="#creatcompany">
                    <div class="m-2">
                        <strong>
                            Create Company
                        </strong>
                    </div>
                </a>
                <hr>
                <a style="text-decoration: none; color: rgb(2, 28, 59);" href="company_management.php">
                    <div class="m-2">
                        <strong>
                            Company Under Management
                        </strong>
                    </div>
                </a>
            </div>
            <div class="modal-footer" style="background-color: #0C2D57;">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="timeLocation" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="map"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#timeLocation').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var timeLat = button.data('timeLat');
        var timeLong = button.data('timeLong');

        var modal = $(this);
        modal.find('#map').html(""); // Clear previous map
        var mapOptions = {
            center: {
                lat: timeLat,
                lng: timeLong
            },
            zoom: 10
        };
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        // Optionally add a marker
        var marker = new google.maps.Marker({
            position: {
                lat: timeLat,
                lng: timeLong
            },
            map: map
        });
    });
});
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg">
</script>

<div class="modal fade" id="timeOutLocation" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>