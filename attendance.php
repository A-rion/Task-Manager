<?php session_start();
include("conn.php");
include("header.php");
include("pagination.php");
if (!$_SESSION['id']) {
?>
<script>
window.location.href = "index.php";
</script>
<?php
}
?>
<style>
@media screen and (max-width:450px) {
    .curb {
        width: 100%;
    }
}
</style>
<?php
date_default_timezone_set('Asia/Kolkata');
?>
<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">Attendance List</h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <nav class="navbar navbar-light bg-light smooth mb-3">
            <div class="container-fluid">
                <?php if ($_SESSION['role'] == 'manager') {
                    $curdate = date('d-M-y');
                    $val = "SELECT a_time, a_timeout FROM `attendance` WHERE manager_id='{$_SESSION['id']}' AND a_date='{$curdate}' AND a_status='Present'";
                    $valSQL = mysqli_query($conn, $val);
                    $valFetch = mysqli_fetch_assoc($valSQL);
                ?>
                <div class="p-2">
                    <button type="button" id="punch_in" style="font-size: 10px;" class="btn btn-outline-success me-2"
                        <?php echo $valFetch['a_time'] == '' ? '' : 'disabled'; ?>>Punch In</button>
                    <button type="button" id="punch_out" style="font-size: 10px;" class="btn btn-outline-danger ou me-2"
                        <?php echo $valFetch['a_timeout'] == '' ? '' : 'disabled'; ?>>Punch Out</button>
                </div>
                <?php } else if ($_SESSION['role'] == 'assistant') {
                    $curdate = date('d-M-y');
                    $val = "SELECT a_time, a_timeout FROM attendance WHERE assistant_id='{$_SESSION['id']}' AND a_date='{$curdate}' AND a_status='Present'";
                    $valSQL = mysqli_query($conn, $val);
                    $valFetch = mysqli_fetch_assoc($valSQL);
                ?>
                <div class="p-1">
                    <button type="button" id="punch_in" style="font-size: 10px;" class="btn btn-outline-success me-2"
                        <?php echo $valFetch['a_time'] == '' ? '' : 'disabled'; ?>>Punch In</button>
                    <button type="button" id="punch_out" style="font-size: 10px;" class="btn btn-outline-danger me-2"
                        <?php echo $valFetch['a_timeout'] == '' ? '' : 'disabled'; ?>>Punch Out</button>
                </div>
                <?php } else if ($_SESSION['role'] == 'employee') {
                    $curdate = date('d-M-y');
                    $val = "SELECT a_time, a_timeout FROM `attendance` WHERE employee_id='{$_SESSION['id']}' AND a_date='{$curdate}' AND a_status='Present'";
                    $valSQL = mysqli_query($conn, $val);
                    $valFetch = mysqli_fetch_assoc($valSQL);
                ?>
                <div class="p-1">
                    <button type="button" id="punch_in" style="font-size: 10px;" class="btn btn-outline-success me-2"
                        <?php echo $valFetch['a_time'] == '' ? '' : 'disabled'; ?>>Punch In</button>
                    <button type="button" id="punch_out" style="font-size: 10px;" class="btn btn-outline-danger me-2"
                        <?php echo $valFetch['a_timeout'] == '' ? '' : 'disabled'; ?>>Punch Out</button>
                </div>
                <?php } ?>

                <div class="curb">
                    <form class="d-flex" method="post">
                        <input class="form-control me-1" type="text" name="attendance_search" id="attendance_search"
                            placeholder="Search By Date" autocomplete="off">
                        <button class="btn btn-outline-success">Clear</button>
                    </form>
                </div>
            </div>
        </nav>
        <?php
        $sql1 = "SELECT * FROM `attendance` WHERE `manager_id`='{$_SESSION['id']}' ORDER BY a_date DESC";
        $query1 = mysqli_query($conn, $sql1);
        $sql2 = "SELECT * FROM `attendance` WHERE `assistant_id`='{$_SESSION['id']}' ORDER BY a_date DESC";
        $query2 = mysqli_query($conn, $sql2);
        $sql3 = "SELECT * FROM `attendance` WHERE `employee_id`='{$_SESSION['id']}' ORDER BY a_date DESC";
        $query3 = mysqli_query($conn, $sql3);
        ?>
        <div class="table-responsive smooth p-2" style="background-color: beige;">
            <table id="myAttendance" class="table table-striped-columns smooth cus-td p-2">
                <thead>
                    <tr class="cus-td">
                        <th style="min-width: 100px;">Date</th>
                        <th style="min-width: 120px;">Login Time</th>
                        <th style="min-width: 120px;">Logout Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <?php if ($_SESSION['role'] == 'manager') {
                    while ($content1 = mysqli_fetch_array($query1)) { ?>
                <tr>
                    <td><?php echo $content1['a_date']; ?></td>
                    <td><?php echo $content1['a_time']; ?></td>
                    <td><?php echo $content1['a_timeout']; ?></td>
                    <td><?php echo $content1['a_status']; ?></td>
                </tr>
                <?php }
                } ?>
                <?php if ($_SESSION['role'] == 'assistant') {
                    while ($content2 = mysqli_fetch_array($query2)) { ?>
                <tr>
                    <td><?php echo $content2['a_date']; ?></td>
                    <td><?php echo $content2['a_time']; ?></td>
                    <td><?php echo $content2['a_timeout']; ?></td>
                    <td><?php echo $content2['a_status']; ?></td>
                </tr>
                <?php }
                } ?>
                <?php if ($_SESSION['role'] == 'employee') {
                    while ($content3 = mysqli_fetch_array($query3)) { ?>
                <tr>
                    <td><?php echo $content3['a_date']; ?></td>
                    <td><?php echo $content3['a_time']; ?></td>
                    <td><?php echo $content3['a_timeout']; ?></td>
                    <td><?php echo $content3['a_status']; ?></td>
                </tr>
                <?php }
                } ?>
            </table>
        </div>
    </div>
</div>
<div id="coordinates"></div>
<script>
$(document).ready(function() {

    $(document).on('click', '#punch_in', function() {
        navigator.geolocation.getCurrentPosition(position => {
            const {
                latitude,
                longitude
            } = position.coords;
            // console.log(`Latitude: ${latitude}, Longitude: ${longitude}`)
            if (latitude != '' && longitude != '') {
                $.ajax({
                    url: './task.php',
                    type: 'POST',
                    data: {
                        'action': 'addPunchInData',
                        'latitude': latitude,
                        'longitude': longitude
                    },
                    dataType: 'json',
                    success: function(resp) {
                        if (resp.status == 'success') {
                            window.location.reload()
                        } else {
                            alert(resp.message)
                        }
                    }
                })
            }

        }, error => {
            console.error('Error getting location:', error);
        });
    })
    $(document).on('click', '#punch_out', function() {
        navigator.geolocation.getCurrentPosition(position => {
            const {
                latitude,
                longitude
            } = position.coords;
            // console.log(`Latitude: ${latitude}, Longitude: ${longitude}`)
            if (latitude != '' && longitude != '') {
                $.ajax({
                    url: './task.php',
                    type: 'POST',
                    data: {
                        'action': 'addPunchOutData',
                        'latitude': latitude,
                        'longitude': longitude
                    },
                    dataType: 'json',
                    success: function(resp) {
                        if (resp.status == 'success') {
                            window.location.reload()
                        } else {
                            alert(resp.message)
                        }
                    }
                })
            }

        }, error => {
            console.error('Error getting location:', error);
        });
    })
    // Initialize DataTables
    var table = $('#myAttendance').DataTable({
        order: [0, "desc"],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        columnDefs: [{
                type: 'date',
                targets: 0
            } // Assuming the date column is the first one
        ]
    });
    // Hide default DataTable search input
    $('.dataTables_filter').hide();
    // Create Pikaday date picker
    var picker = new Pikaday({
        field: document.getElementById('attendance_search'),
        format: 'DD-MMM-YY',
        yearRange: [moment().subtract(100, 'years').year(), moment().year()],
        onSelect: function() {
            // Filter table data on date selection
            var selectedDate = this.getMoment().format('DD-MMM-YY');
            // Filter table data on date selection
            table.column(0).search(selectedDate).draw();
        }
    });
});
</script>
</body>

</html>