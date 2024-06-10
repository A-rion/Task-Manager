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
$deleteid=$_REQUEST['deleteid'];
if($deleteid){
  $closed_in=date('d-M-y');
  $sqld="UPDATE issue SET status='0', close_by='{$_SESSION['assign']}', closed_in='{$closed_in}' WHERE `issue_id`='{$deleteid}'";
  $queryd=mysqli_query($conn,$sqld);
  ?>
<script>
window.history.replaceState({}, document.title, window.location.pathname);
</script>
<?php
}
?>
<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">F.E Issue Report List</h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <nav class="navbar navbar-light bg-light smooth mb-3">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <form class="d-flex" method="post">
                    <input class="form-control m-1" type="text" id="dateXsearch" name="date_search" id="date_search"
                        placeholder="Date" autocomplete="off">
                    <input class="form-control m-1" type="search" id="issueXsearch" name="issue_search"
                        placeholder="Name" autocomplete="off">
                    <button class="btn btn-outline-success m-1">Clear</button>
                </form>
            </div>
        </nav>
        <div class="table-responsive smooth p-2" style="background-color: beige;">
            <table id="issueTable" class="table table-striped-columns cus-td smooth p-2">
                <thead>
                    <tr>
                        <th style="min-width: 100px;">Issued By</th>
                        <th style="min-width: 100px;">Issue Date</th>
                        <th style="min-width: 120px;">Docket Number</th>
                        <th style="min-width: 150px;">Reason</th>
                        <th style="min-width: 200px;">Description</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($_SESSION['role']=='assistant') {
                        $sqlissue="SELECT issue.*, employee.employee_name,  reg.admin_name, close_manager.manager_name, close_assistant.assistant_name 
                        FROM issue
                        INNER JOIN employee ON issue.employee_id=employee.employee_id
                        INNER JOIN assistant ON employee.assistant_id=assistant.assistant_id
                        LEFT JOIN reg ON issue.close_by = reg.assign_id
                        LEFT JOIN manager AS close_manager ON issue.close_by = close_manager.assign_id
                        LEFT JOIN assistant AS close_assistant ON issue.close_by = close_assistant.assign_id
                        WHERE assistant.assistant_id='{$_SESSION['id']}'";
                        $queryissue=mysqli_query($conn,$sqlissue);
                        while($fetchi=mysqli_fetch_array($queryissue)) {
                    ?>
                    <tr>
                        <td><?php echo $fetchi['employee_name']; ?></td>
                        <td><?php echo $fetchi['issue_date']; ?></td>
                        <td><?php echo $fetchi['docket_num']; ?></td>
                        <td><?php echo $fetchi['reason']; ?></td>
                        <td><?php echo $fetchi['about']; ?></td>
                        <td><a href="<?php echo "./uploads/".$fetchi['file']; ?>" download>
                                <img src="assets/images/logos/icons8-download.gif" class="image"></a>
                        </td>
                        <td>
                            <?php if($fetchi['status'] == '1') { ?>
                            <a href="issue_report.php?deleteid=<?php echo $fetchi['issue_id']; ?>"><button
                                    class="btn btn-outline-danger" style="font-size: 10px;"
                                    onClick='return confirm("Confirm to Delete this Issue.")'>Solved</button></a>
                            <?php } else { ?>
                            <div class="tooltip">
                                <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                <span class="tooltiptext">
                                    <h6>
                                        <?php 
                                        echo $fetchi['admin_name'];
                                        echo $fetchi['manager_name'];
                                        echo $fetchi['assistant_name'];
                                        ?>
                                    </h6>
                                    <?php echo $fetchi['closed_in']; ?>
                                </span>
                            </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } } ?>
                    <?php
                    if($_SESSION['role']=='manager') {
                        $sqlissue="SELECT issue.*, employee.employee_name, reg.admin_name, close_manager.manager_name, close_assistant.assistant_name 
                        FROM issue
                        INNER JOIN employee ON issue.employee_id = employee.employee_id
                        INNER JOIN assistant ON employee.assistant_id = assistant.assistant_id
                        INNER JOIN manager ON assistant.manager_id = manager.manager_id
                        LEFT JOIN reg ON issue.close_by = reg.assign_id
                        LEFT JOIN manager AS close_manager ON issue.close_by = close_manager.assign_id
                        LEFT JOIN assistant AS close_assistant ON issue.close_by = close_assistant.assign_id
                        WHERE manager.manager_id='{$_SESSION['id']}'";
                        $queryissue=mysqli_query($conn,$sqlissue);
                        while($fetchi=mysqli_fetch_array($queryissue)) {
                    ?>
                    <tr>
                        <td><?php echo $fetchi['employee_name']; ?></td>
                        <td><?php echo $fetchi['issue_date']; ?></td>
                        <td><?php echo $fetchi['docket_num']; ?></td>
                        <td><?php echo $fetchi['reason']; ?></td>
                        <td><?php echo $fetchi['about']; ?></td>
                        <td><a href="<?php echo "./uploads/".$fetchi['file']; ?>" download>
                                <img src="assets/images/logos/icons8-download.gif" class="image"></a>
                        </td>
                        <td>
                            <?php if($fetchi['status'] == '1') { ?>
                            <a href="issue_report.php?deleteid=<?php echo $fetchi['issue_id']; ?>"><button
                                    class="btn btn-outline-danger" style="font-size: 10px;"
                                    onClick='return confirm("Confirm to Delete this Issue.")'>Solved</button></a>
                            <?php } else { ?>
                            <div class="tooltip">
                                <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                <span class="tooltiptext">
                                    <h6>
                                        <?php 
                                        echo $fetchi['admin_name'];
                                        echo $fetchi['manager_name'];
                                        echo $fetchi['assistant_name'];
                                        ?>
                                    </h6>
                                    <?php echo $fetchi['closed_in']; ?>
                                </span>
                            </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } } ?>
                    <?php
                    if($_SESSION['role']=='admin') {
                        $sqlissue="SELECT issue.*, employee.employee_name, reg.admin_name, manager.manager_name, assistant.assistant_name FROM issue
                        INNER JOIN employee ON issue.employee_id=employee.employee_id
                        INNER JOIN company_master ON employee.company_id=company_master.company_id
                        LEFT JOIN reg ON issue.close_by=reg.assign_id
                        LEFT JOIN manager ON issue.close_by=manager.assign_id
                        LEFT JOIN assistant ON issue.close_by=assistant.assign_id
                        WHERE company_master.admin_id='{$_SESSION['id']}'";
                        $queryissue=mysqli_query($conn,$sqlissue);
                        while($fetchi=mysqli_fetch_array($queryissue)) {
                    ?>
                    <tr>
                        <td><?php echo $fetchi['employee_name']; ?></td>
                        <td><?php echo $fetchi['issue_date']; ?></td>
                        <td><?php echo $fetchi['docket_num']; ?></td>
                        <td><?php echo $fetchi['reason']; ?></td>
                        <td><?php echo $fetchi['about']; ?></td>
                        <td><a href="<?php echo "./uploads/".$fetchi['file']; ?>" download>
                                <img src="assets/images/logos/icons8-download.gif" class="image"></a>
                        </td>
                        <td>
                            <?php if($fetchi['status'] == '1') { ?>
                            <a href="issue_report.php?deleteid=<?php echo $fetchi['issue_id']; ?>"><button
                                    class="btn btn-outline-danger" style="font-size: 10px;"
                                    onClick='return confirm("Confirm to Delete this Issue.")'>Solved</button></a>
                            <?php } else { ?>
                            <div class="tooltip">
                                <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                <span class="tooltiptext">
                                    <h6>
                                        <?php 
                                        echo $fetchi['admin_name'];
                                        echo $fetchi['manager_name'];
                                        echo $fetchi['assistant_name'];
                                        ?>
                                    </h6>
                                    <?php echo $fetchi['closed_in']; ?>
                                </span>
                            </div>
                            <?php } ?>
                        </td>
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
    var table = $('#issueTable').DataTable({
        order: [1, 'desc'],
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

    // Create Pikaday date picker
    var picker = new Pikaday({
        field: document.getElementById('dateXsearch'),
        format: 'DD-MMM-YY',
        yearRange: [moment().subtract(100, 'years').year(), moment().year()],
        onSelect: function() {
            // Filter table data on date selection
            var selectedDate = this.getMoment().format('DD-MMM-YY');
            // Filter table data on date selection
            table.column(1).search(selectedDate).draw();
        }
    });

    // Apply date filtering when the input value changes
    $('#issueXsearch').on('keyup change', function() {
        // Filter table data on input value change
        table.columns(0).search($(this).val()).draw();
    });
});
</script>