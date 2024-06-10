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
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/js/tom-select.complete.min.js"></script>

<?php
if(isset($_POST['submitleave'])){
  $applicant=$_SESSION['id'];
  $l_date=$_POST['l_date'];
  $fromdate=$_POST['fromdate'];
  $todate=$_POST['todate'];
  $requestto=$_POST['requestto'];
  $cc = implode(",",$_POST['cc']);
  $reason=$_POST['reason'];
  $l_status="Pending";
  if($_SESSION['role']=='employee') {
  $sql11="INSERT INTO `myleave` (`employee_id`,`apply_date`,`form_date`,`to_date`,`request_to`,`cc`,`reason`,`l_status`) VALUES ('{$applicant}','{$l_date}','{$fromdate}','{$todate}','{$requestto}','{$cc}','{$reason}','{$l_status}')";
  $query11=mysqli_query($conn,$sql11);
  ?>
<script type="text/javascript">
window.location.href = "myleave.php";
</script>
<?php
  } else if($_SESSION['role']=='assistant') {
    $sql11="INSERT INTO `myleave` (`assistant_id`,`apply_date`,`form_date`,`to_date`,`request_to`,`cc`,`reason`,`l_status`) VALUES ('{$applicant}','{$l_date}','{$fromdate}','{$todate}','{$requestto}','{$cc}','{$reason}','{$l_status}')";
    $query11=mysqli_query($conn,$sql11);
    ?>
<script type="text/javascript">
window.location.href = "myleave.php";
</script>
<?php
    } else if($_SESSION['role']=='manager') {
        $sql11="INSERT INTO `myleave` (`manager_id`,`apply_date`,`form_date`,`to_date`,`request_to`,`cc`,`reason`,`l_status`) VALUES ('{$applicant}','{$l_date}','{$fromdate}','{$todate}','{$requestto}','{$cc}','{$reason}','{$l_status}')";
        $query11=mysqli_query($conn,$sql11);
        ?>
<script type="text/javascript">
window.location.href = "myleave.php";
</script>
<?php
    }
}
?>
<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">My Leave</h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <nav class="navbar navbar-light bg-light smooth mb-3">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <form class="d-flex" method="post">
                    <button class="btn btn-outline-success" type="button" data-bs-toggle="modal"
                        data-bs-target="#leaveapplication">Leave Application</button>
                </form>
            </div>
        </nav>
        <?php 
    $sql10="SELECT myleave.*, reg.admin_name
    FROM myleave
    INNER JOIN reg ON myleave.request_to=reg.assign_id
    WHERE myleave.manager_id='{$_SESSION['id']}' ORDER BY `leave_id` DESC";
    $query10=mysqli_query($conn,$sql10);
    $sql20="SELECT myleave.*, reg.admin_name, manager.manager_name
    FROM myleave
    LEFT JOIN reg ON myleave.request_to = reg.assign_id
    LEFT JOIN manager ON myleave.request_to = manager.assign_id
    WHERE myleave.assistant_id ='{$_SESSION['id']}' ORDER BY `leave_id` DESC";
    $query20=mysqli_query($conn,$sql20);
    $sql21="SELECT myleave.*, assistant.assistant_name
    FROM myleave
    INNER JOIN assistant ON myleave.request_to=assistant.assign_id WHERE myleave.employee_id='{$_SESSION['id']}' ORDER BY `leave_id` DESC";
    $query21=mysqli_query($conn,$sql21);
    ?>
        <div class="table-responsive smooth p-2" style="background-color: beige;">
            <table id="myLeave" class="table table-striped-columns smooth cus-td p-2">
                <thead>
                    <tr>
                        <th style="min-width: 120px;">Request To</th>
                        <th style="min-width: 100px;">Apply Date</th>
                        <th style="min-width: 100px;">From Date</th>
                        <th style="min-width: 100px;">To Date</th>
                        <th>Days</th>
                        <th style="min-width: 200px;">Reason For Leave</th>
                        <th style="min-width: 200px;">CC</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($_SESSION['role']=='manager') {
                    while($fetch1=mysqli_fetch_array($query10)) {
                    $cc1=explode(",",$fetch1['cc']);
                    $assignIds = implode("','", $cc1);
                    $sqlcc1="SELECT * FROM manager WHERE assign_id IN ('{$assignIds}')";
                    $querycc1=mysqli_query($conn,$sqlcc1);
                    $que
                    ?>
                    <tr>
                        <td><?php echo $fetch1['admin_name']; ?></td>
                        <td><?php echo $fetch1['apply_date']; ?></td>
                        <td><?php echo $fetch1['form_date']; ?></td>
                        <td><?php echo $fetch1['to_date']; ?></td>
                        <?php 
                        $start_date = strtotime($fetch1['form_date']);
                        $end_date = strtotime($fetch1['to_date']);
                        ?>
                        <td><?php echo ($end_date - $start_date)/60/60/24; ?></td>
                        <td><?php echo $fetch1['reason']; ?></td>
                        <td>
                            <?php
                            while($fetchcc1=mysqli_fetch_array($querycc1)){
                                echo $fetchcc1['manager_name'];?>,&nbsp;
                            <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $fetch1['l_status']; ?></td>
                    </tr>
                    <?php } } ?>
                    <?php if($_SESSION['role']=='assistant') {
                    while($fetch2=mysqli_fetch_array($query20)) {
                    $cc1=explode(",",$fetch2['cc']);
                    $assignIds = implode("','", $cc1);
                    $sqlcc1="SELECT * FROM manager WHERE assign_id IN ('{$assignIds}')";
                    $querycc1=mysqli_query($conn,$sqlcc1);
                    $sqlcc2="SELECT * FROM assistant WHERE assign_id IN ('{$assignIds}')";
                    $querycc2=mysqli_query($conn,$sqlcc2);
                    $sqlcc3="SELECT * FROM reg WHERE assign_id IN ('{$assignIds}')";
                    $querycc3=mysqli_query($conn,$sqlcc3);
                    ?>
                    <tr>
                        <td>
                            <?php echo $fetch2['manager_name']; ?>
                            <?php echo $fetch2['admin_name']; ?>
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
                        <td>
                            <?php
                            while($fetchcc1=mysqli_fetch_array($querycc1)){
                                echo $fetchcc1['manager_name'];?>,&nbsp;
                            <?php
                            } while($fetchcc2=mysqli_fetch_array($querycc2)){
                                echo $fetchcc2['assistant_name'];?>,&nbsp;
                            <?php
                            } while($fetchcc3=mysqli_fetch_array($querycc3)){
                                echo $fetchcc3['admin_name'];?>,&nbsp;
                            <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $fetch2['l_status']; ?></td>
                    </tr>
                    <?php } } ?>
                    <?php if($_SESSION['role']=='employee') {
                    while($fetch3=mysqli_fetch_array($query21)) {
                        $cc1=explode(",",$fetch3['cc']);
                        $assignIds = implode("','", $cc1);
                        $sqlcc1="SELECT * FROM manager WHERE assign_id IN ('{$assignIds}')";
                        $querycc1=mysqli_query($conn,$sqlcc1);
                        $sqlcc2="SELECT * FROM assistant WHERE assign_id IN ('{$assignIds}')";
                        $querycc2=mysqli_query($conn,$sqlcc2);
                        $sqlcc3="SELECT * FROM reg WHERE assign_id IN ('{$assignIds}')";
                        $querycc3=mysqli_query($conn,$sqlcc3);
                    ?>
                    <tr>
                        <td><?php echo $fetch3['assistant_name']; ?></td>
                        <td><?php echo $fetch3['apply_date']; ?></td>
                        <td><?php echo $fetch3['form_date']; ?></td>
                        <td><?php echo $fetch3['to_date']; ?></td>
                        <?php 
                        $start_date = strtotime($fetch3['form_date']);
                        $end_date = strtotime($fetch3['to_date']);
                        ?>
                        <td><?php echo ($end_date - $start_date)/60/60/24; ?></td>
                        <td><?php echo $fetch3['reason']; ?></td>
                        <td>
                            <?php
                            while($fetchcc1=mysqli_fetch_array($querycc1)){
                                echo $fetchcc1['manager_name'];?>,&nbsp;
                            <?php
                            } while($fetchcc2=mysqli_fetch_array($querycc2)){
                                echo $fetchcc2['assistant_name'];?>,&nbsp;
                            <?php
                            } while($fetchcc3=mysqli_fetch_array($querycc3)){
                                echo $fetchcc3['admin_name'];?>,&nbsp;
                            <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $fetch3['l_status']; ?></td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // Initialize DataTables
    var table = $('#myLeave').DataTable({
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
    $('#team_at').on('keyup change', function() {
        // Filter table data on input value change
        table.columns(0).search($(this).val()).draw();
    });
});
</script>
</body>
<?php include("applyLeave.php"); ?>

</html>