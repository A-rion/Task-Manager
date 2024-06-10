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
if(isset($_POST['leavesub'])){
$leavesearch=$_POST['leavesearch'];
if($_SESSION['role']=='assistant') {
$le=" AND (employee.employee_name LIKE '%$leavesearch%' OR assistant.assistant_name LIKE '%$leavesearch%')";
}
if($_SESSION['role']=='manager') {
    $lee=" AND (employee.employee_name LIKE '%$leavesearch%' OR assistant.assistant_name LIKE '%$leavesearch%' OR manager.manager_name LIKE '%$leavesearch%')";
    }
if($_SESSION['role']=='admin') {
    $leee=" AND (employee.employee_name LIKE '%$leavesearch%' OR assistant.assistant_name LIKE '%$leavesearch%' OR manager.manager_name LIKE '%$leavesearch%')";
    }
}
?>
<?php
$leave_update=$_REQUEST['leave_update'];
if($leave_update){
  $sqlsel="UPDATE `myleave` SET `l_status`='Declined' WHERE `leave_id`='{$leave_update}'";
  $querysel=mysqli_query($conn,$sqlsel);
  ?>
<script>
window.history.replaceState({}, document.title, window.location.pathname);
</script>
<?php
  } 

$leave_edit=$_REQUEST['leave_edit'];
if($leave_edit){
  $sqledit="UPDATE `myleave` SET `l_status`='Approved' WHERE `leave_id`='{$leave_edit}'";
  $queryedit=mysqli_query($conn,$sqledit);
  ?>
<script>
window.history.replaceState({}, document.title, window.location.pathname);
</script>
<?php
  } 
?>

<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">Leave Notification</h5>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <nav class="navbar navbar-light bg-light smooth mb-3">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" id="leaveXsearch" placeholder="Type Applicant Name"
                        aria-label="Search" name="leavesearch">
                    <button class="btn btn-outline-success">Clear</button>
                </form>
            </div>
        </nav>
        <div class="table-responsive smooth p-2" style="background-color: beige;">
            <table id="leaveXTable" class="table table-striped-columns cus-td p-2">
                <thead>
                    <tr>
                        <th style="min-width: 150px;">Applicant</th>
                        <th style="min-width: 100px;">Apply Date</th>
                        <th style="min-width: 100px;">From Date</th>
                        <th style="min-width: 100px;">To Date</th>
                        <th>Days</th>
                        <th style="min-width: 200px;">Reason For Leave</th>
                        <th style="min-width: 100px;">Status</th>
                        <th style="min-width: 200px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($_SESSION['role']=='assistant') {
                $sql1m="SELECT myleave.*, employee.employee_name, assistant.assistant_name
                FROM myleave
                LEFT JOIN employee ON myleave.employee_id = employee.employee_id 
                LEFT JOIN assistant ON myleave.assistant_id = assistant.assistant_id 
                WHERE myleave.request_to = '{$_SESSION['assign']}'
                
                UNION
                
                SELECT myleave.*, employee.employee_name, assistant.assistant_name
                FROM myleave
                LEFT JOIN employee ON myleave.employee_id = employee.employee_id 
                LEFT JOIN assistant ON myleave.assistant_id = assistant.assistant_id 
                WHERE (myleave.cc LIKE '%{$_SESSION['assign']}%') ORDER BY leave_id DESC";
                $query1m=mysqli_query($conn,$sql1m);
                while($fetch2m=mysqli_fetch_array($query1m)) {
                ?>
                    <tr>
                        <td><?php echo $fetch2m['employee_name']; ?><?php echo $fetch2m['assistant_name']; ?></td>
                        <td><?php echo $fetch2m['apply_date']; ?></td>
                        <td><?php echo $fetch2m['form_date']; ?></td>
                        <td><?php echo $fetch2m['to_date']; ?></td>
                        <?php 
                    $start_m_date = strtotime($fetch2m['form_date']);
                    $end_m_date = strtotime($fetch2m['to_date']);
                    ?>
                        <td><?php echo ($end_m_date - $start_m_date)/60/60/24; ?></td>
                        <td><?php echo $fetch2m['reason']; ?></td>
                        <td><?php echo $fetch2m['l_status']; ?></td>
                        <td><?php if($fetch2m['request_to']=="{$_SESSION['assign']}") {
                    if($fetch2m['l_status']=='Pending') {?>
                            <a href="leave.php?leave_edit=<?php echo $fetch2m['leave_id']; ?>"><button type="button"
                                    class="btn btn-outline-secondary"
                                    style="font-size: 10px;"><strong>Approve</strong></button></a>
                            &nbsp;|&nbsp;
                            <a href="leave.php?leave_update=<?php echo $fetch2m['leave_id']; ?>"><button type="button"
                                    class="btn btn-outline-danger"
                                    style="font-size: 10px;"><strong>Decline</strong></button></a>
                            <?php } else if($fetch2m['l_status']=='Approved') {?>
                            <a href="leave.php?leave_update=<?php echo $fetch2m['leave_id']; ?>"><button type="button"
                                    class="btn btn-outline-danger"
                                    style="font-size: 10px;"><strong>Decline</strong></button></a>
                            <?php } else if($fetch2m['l_status']=='Declined') {?>
                            <a href="leave.php?leave_edit=<?php echo $fetch2m['leave_id']; ?>"><button type="button"
                                    class="btn btn-outline-secondary"
                                    style="font-size: 10px;"><strong>Approve</strong></button></a>
                            <?php } } else {?>
                            <h5>CC</h5>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <?php if($_SESSION['role']=='manager') {
                $sql12="SELECT myleave.*, employee.employee_name, assistant.assistant_name, manager.manager_name
                FROM myleave
                LEFT JOIN employee ON myleave.employee_id = employee.employee_id 
                LEFT JOIN assistant ON myleave.assistant_id = assistant.assistant_id 
                LEFT JOIN manager ON myleave.manager_id = manager.manager_id 
                WHERE myleave.request_to = '{$_SESSION['assign']}'
                
                UNION
        
                SELECT myleave.*, employee.employee_name, assistant.assistant_name, manager.manager_name
                FROM myleave
                LEFT JOIN employee ON myleave.employee_id = employee.employee_id 
                LEFT JOIN assistant ON myleave.assistant_id = assistant.assistant_id 
                LEFT JOIN manager ON myleave.manager_id = manager.manager_id 
                WHERE (myleave.cc LIKE '%{$_SESSION['assign']}%') ORDER BY leave_id DESC";
                $query12=mysqli_query($conn,$sql12);
                while($fetch2=mysqli_fetch_array($query12)) {
                ?>
                    <tr>
                        <td>
                            <?php echo $fetch2['assistant_name']; ?>
                            <?php echo $fetch2['employee_name']; ?>
                            <?php echo $fetch2['manager_name']; ?>
                        </td>
                        <td><?php echo $fetch2['apply_date']; ?></td>
                        <td><?php echo $fetch2['form_date']; ?></td>
                        <td><?php echo $fetch2['to_date']; ?></td>
                        <?php 
                    $start_date = strtotime($fetch2['form_date']);
                    $end_date = strtotime($fetch2['to_date']);
                    ?>
                        <td><?php echo ($end_date - $start_date)/60/60/24; ?></td>
                        <td><?php echo $fetch2['reason']; ?></td>
                        <td><?php echo $fetch2['l_status']; ?></td>
                        <td><?php if($fetch2['request_to']=="{$_SESSION['assign']}") {
                    if($fetch2['l_status']=='Pending') {?>
                            <a href="leave.php?leave_edit=<?php echo $fetch2['leave_id']; ?>"><button type="button"
                                    class="btn btn-outline-secondary"
                                    style="font-size: 10px;"><strong>Approve</strong></button></a>
                            &nbsp;|&nbsp;
                            <a href="leave.php?leave_update=<?php echo $fetch2['leave_id']; ?>"><button type="button"
                                    class="btn btn-outline-danger"
                                    style="font-size: 10px;"><strong>Decline</strong></button></a>
                            <?php } else if($fetch2['l_status']=='Approved') {?>
                            <a href="leave.php?leave_update=<?php echo $fetch2['leave_id']; ?>"><button type="button"
                                    class="btn btn-outline-danger"
                                    style="font-size: 10px;"><strong>Decline</strong></button></a>
                            <?php } else if($fetch2['l_status']=='Declined') {?>
                            <a href="leave.php?leave_edit=<?php echo $fetch2['leave_id']; ?>"><button type="button"
                                    class="btn btn-outline-secondary"
                                    style="font-size: 10px;"><strong>Approve</strong></button></a>
                            <?php } } else {?>
                            <h5>CC</h5>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <?php if($_SESSION['role']=='admin') {
                $sql12="SELECT myleave.*, employee.employee_name, assistant.assistant_name, manager.manager_name
                FROM myleave
                LEFT JOIN employee ON myleave.employee_id = employee.employee_id 
                LEFT JOIN assistant ON myleave.assistant_id = assistant.assistant_id 
                LEFT JOIN manager ON myleave.manager_id = manager.manager_id 
                WHERE myleave.request_to = '{$_SESSION['assign']}'
                
                UNION
        
                SELECT myleave.*, employee.employee_name, assistant.assistant_name, manager.manager_name
                FROM myleave
                LEFT JOIN employee ON myleave.employee_id = employee.employee_id 
                LEFT JOIN assistant ON myleave.assistant_id = assistant.assistant_id 
                LEFT JOIN manager ON myleave.manager_id = manager.manager_id 
                WHERE (myleave.cc LIKE '%{$_SESSION['assign']}%') ORDER BY leave_id DESC";
                $query12=mysqli_query($conn,$sql12);
                while($fetch2=mysqli_fetch_array($query12)) {
                ?>
                    <tr>
                        <td>
                            <?php echo $fetch2['manager_name']; ?>
                            <?php echo $fetch2['assistant_name']; ?>
                            <?php echo $fetch2['employee_name']; ?>
                        </td>
                        <td><?php echo $fetch2['apply_date']; ?></td>
                        <td><?php echo $fetch2['form_date']; ?></td>
                        <td><?php echo $fetch2['to_date']; ?></td>
                        <?php 
                    $start_date = strtotime($fetch2['form_date']);
                    $end_date = strtotime($fetch2['to_date']);
                ?>
                        <td><?php echo ($end_date - $start_date)/60/60/24; ?></td>
                        <td><?php echo $fetch2['reason']; ?></td>
                        <td><?php echo $fetch2['l_status']; ?></td>
                        <td><?php if($fetch2['request_to']=="{$_SESSION['assign']}") {
                    if($fetch2['l_status']=='Pending') {?>
                            <a href="leave.php?leave_edit=<?php echo $fetch2['leave_id']; ?>"><button type="button"
                                    class="btn btn-outline-secondary"
                                    style="font-size: 10px;"><strong>Approve</strong></button></a>
                            &nbsp;|&nbsp;
                            <a href="leave.php?leave_update=<?php echo $fetch2['leave_id']; ?>"><button type="button"
                                    class="btn btn-outline-danger"
                                    style="font-size: 10px;"><strong>Decline</strong></button></a>
                            <?php } else if($fetch2['l_status']=='Approved') {?>
                            <a href="leave.php?leave_update=<?php echo $fetch2['leave_id']; ?>"><button type="button"
                                    class="btn btn-outline-danger"
                                    style="font-size: 10px;"><strong>Decline</strong></button></a>
                            <?php } else if($fetch2['l_status']=='Declined') {?>
                            <a href="leave.php?leave_edit=<?php echo $fetch2['leave_id']; ?>"><button type="button"
                                    class="btn btn-outline-secondary"
                                    style="font-size: 10px;"><strong>Approve</strong></button></a>
                            <?php } } else {?>
                            <h5>CC</h5>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        // Initialize DataTables
        var table = $('#leaveXTable').DataTable({
            order: [],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            columnDefs: [{
                targets: '_all',
                orderable: false // Disable sorting for all columns
            }]
        });

        // Hide default DataTable search input
        $('.dataTables_filter').hide();

        // Apply date filtering when the input value changes
        $('#leaveXsearch').on('keyup change', function() {
            // Filter table data on input value change
            table.columns(0).search($(this).val()).draw();
        });
    });
    </script>
    </body>

    </html>