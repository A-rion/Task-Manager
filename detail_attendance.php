<?php session_start();
include("conn.php");
include("header.php");
include("pagination.php");
if(!$_SESSION['id']){
?>
<script>
window.location.href = "index.php";
</script>
<?php
}
?>
<?php
$detail_m=$_REQUEST['detail_m'];
$detail_a=$_REQUEST['detail_a'];
$detail_e=$_REQUEST['detail_e'];
    if ($detail_m) {
        $sql = "SELECT * FROM attendance WHERE `manager_id`='{$detail_m}' ORDER BY a_date DESC";
        $query = mysqli_query($conn, $sql);
    } elseif ($detail_a) {
        $sql = "SELECT * FROM attendance WHERE `assistant_id`='{$detail_a}' ORDER BY a_date DESC";
        $query = mysqli_query($conn, $sql);
    } elseif ($detail_e) {
        $sql = "SELECT * FROM attendance WHERE `employee_id`='{$detail_e}' ORDER BY a_date DESC";
        $query = mysqli_query($conn, $sql);
    }
?>

<?php
if($detail_m || $detail_a || $detail_e) {
    $sqlall="SELECT manager_name AS name FROM manager WHERE manager_id='{$detail_m}'
    UNION
    SELECT assistant_name AS name FROM assistant WHERE assistant_id='{$detail_a}'
    UNION
    SELECT employee_name AS name FROM employee WHERE employee_id='{$detail_e}'";
    $queryall=mysqli_query($conn,$sqlall);
    $fetchall=mysqli_fetch_array($queryall);
}
?>
<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">
        <?php echo $fetchall['name']; ?>
    </h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <nav class="navbar navbar-light bg-light smooth mb-3">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="text" name="atten_search" id="atten_search"
                        placeholder="Search By Date" autocomplete="off">
                    <button class="btn btn-outline-success">Clear</button>
                </form>
            </div>
        </nav>
        <div class="table-responsive smooth p-2" style="background-color: beige;">
            <table id="attendanceTable" class="table table-striped-columns smooth cus-td p-2">
                <thead>
                    <tr class="cus-td">
                        <th style="font-size: 12px; min-width: 100px;">Date</th>
                        <th style="font-size: 12px; min-width: 120px;">Login Time</th>
                        <th style="font-size: 12px; min-width: 120px;">Logout Time</th>
                        <th style="font-size: 12px;">Status</th>
                        <th style="font-size: 12px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Check if there are records to display
                        if (mysqli_num_rows($query) > 0) {
                            // Loop through the fetched records
                            while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                    <tr>
                        <td><?php echo $row['a_date']; ?></td>
                        <td <?php if($row['a_time'] == ''){}else{ ?> data-bs-toggle="modal"
                            data-bs-target="#timeLocation" data-timeLat="<?php echo $row['time_lat']; ?>"
                            data-timeLong="<?php echo $row['time_long']; ?>" <?php } ?>>
                            <?php echo $row['a_time']; ?>
                        </td>
                        <td <?php if($row['a_timeout'] == ''){}else{ ?> data-bs-toggle="modal"
                            data-bs-target="#timeOutLocation" data-timeOutLat="<?php echo $row['timeout_lat']; ?>"
                            data-timeOutLong="<?php echo $row['timeout_long']; ?>" <?php } ?>>
                            <?php echo $row['a_timeout']; ?>
                        </td>
                        <td><?php echo $row['a_status']; ?></td>
                        <td>
                            <button type="button" class="btn btn-outline-success" data-toggle="modal"
                                data-target="#editAttendance" data-id="<?php echo $row['a_id']; ?>"
                                data-time="<?php echo $row['a_time']; ?>"
                                data-timeout="<?php echo $row['a_timeout']; ?>"
                                data-status="<?php echo $row['a_status']; ?>" style="font-size: 10px;">Edit</button>
                        </td>
                    </tr>
                    <?php
                            }
                            } else {
                                // Display a message if no records found
                        ?>
                    <tr>
                    <tr>
                        <td colspan="5">No records found.</td>
                    </tr>
                    <?php
                        }
                        ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // Initialize DataTables
    var table = $('#attendanceTable').DataTable({
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
        field: document.getElementById('atten_search'),
        format: 'DD-MMM-YY',
        yearRange: [moment().subtract(100, 'years').year(), moment().year()],
        onSelect: function() {
            // Filter table data on date selection
            table.columns(0).search(this.getMoment().format('DD-MMM-YY')).draw();
        }
    });
});
</script>
<?php include("edit_attendance.php"); ?>