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
  $sqld="DELETE FROM holiday_list WHERE holiday_id='{$deleteid}'";
  $queryd=mysqli_query($conn,$sqld);
  ?>
<script>
window.history.replaceState({}, document.title, window.location.pathname);
</script>
<?php
}
?>
<?php
if(isset($_POST['hsubmit'])) {
    $cname=$_POST['cname'];
    $hname=$_POST['hname'];
    $hdate=$_POST['hdate'];
    $sqlh="INSERT INTO holiday_list (`company_id`,`admin_id`,`holiday_date`,`holiday_name`)
    VALUES ('{$cname}','{$_SESSION['id']}','{$hdate}','{$hname}')";
    $queryh=mysqli_query($conn,$sqlh);
    $sql_at="INSERT INTO attendance (manager_id, assistant_id, employee_id, a_date, a_status)
    SELECT manager.manager_id, NULL, NULL, '{$hdate}', 'Holiday'
    FROM holiday_list
    INNER JOIN manager ON holiday_list.company_id = manager.company_id
    WHERE manager.company_id = '{$cname}' AND manager.manager_status='1'
    UNION
    SELECT NULL, assistant.assistant_id, NULL, '{$hdate}', 'Holiday'
    FROM holiday_list
    INNER JOIN assistant ON holiday_list.company_id = assistant.company_id
    WHERE assistant.company_id = '{$cname}' AND assistant.assistant_status='1'
    UNION
    SELECT NULL, NULL,employee.employee_id, '{$hdate}', 'Holiday'
    FROM holiday_list
    INNER JOIN employee ON holiday_list.company_id = employee.company_id
    WHERE employee.company_id = '{$cname}' AND employee.employee_status='1'";
    $query_at=mysqli_query($conn,$sql_at);
    ?>
<script>
window.location.href = "holidaylist.php";
</script>
<?php
}
?>
<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">Holiday List</h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <nav class="navbar navbar-light bg-light smooth mb-3">
            <div class="container-fluid">
                <a data-bs-toggle="modal" data-bs-target="#addholiday">
                    <button type="button" class="btn btn-outline-primary m-1">Add Holiday</button>
                </a>
                <!-- Modal -->
                <div class="modal fade" id="addholiday" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="background-color: #fd9292;">
                            <div class="modal-header" style="background-color: #ffc2c2;">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Holiday</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <form method="post">
                                        <div class="row p-2">
                                            <?php
                                        $sqlcb="SELECT `company_name`, `company_id` FROM `company_master` WHERE `admin_id`='{$_SESSION['id']}'";
                                        $querycb=mysqli_query($conn,$sqlcb);
                                        ?>
                                            <div class="col-md-12">
                                                <select class="form-select" aria-label="Default select example"
                                                    name="cname" required>
                                                    <option selected disabled>Company Name</option>
                                                    <?php while($fetch=mysqli_fetch_array($querycb)) {?>
                                                    <option value="<?php echo $fetch['company_id']; ?>">
                                                        <?php echo $fetch['company_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control mt-2" placeholder="Holiday Name"
                                                    name="hname" aria-label="Holiday Name" autocomplete="off" required>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <input class="form-control" type="text" name="hdate" id="hdate"
                                                    placeholder="Holiday Date" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <input type="submit" name="hsubmit" value="ADD" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" id="holidayXsearch" name="holiday_search"
                        id="holiday_search" placeholder="Type in Holiday Date" autocomplete="off">
                    <button class="btn btn-outline-success">Clear</button>
                </form>
            </div>
        </nav>
        <div class="table-responsive smooth p-2" style="background-color: beige;">
            <table id="holidayTable" class="table table-striped-columns cus-td smooth p-2">
                <thead>
                    <tr class="cus-td">
                        <th style="min-width: 120px;">Company Name</th>
                        <th style="min-width: 120px;">Holiday Date</th>
                        <th>Holiday Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlho="SELECT holiday_list.*, company_master.company_name FROM `holiday_list`
                    INNER JOIN company_master ON holiday_list.company_id=company_master.company_id
                    WHERE holiday_list.admin_id='{$_SESSION['id']}' ORDER BY holiday_id DESC";
                    $queryho=mysqli_query($conn,$sqlho);
                    while($fetcho=mysqli_fetch_array($queryho)) {
                    ?>
                    <tr>
                        <td><?php echo $fetcho['company_name']; ?></td>
                        <td><?php echo $fetcho['holiday_date']; ?></td>
                        <td><?php echo $fetcho['holiday_name']; ?></td>
                        <td><a style="text-decoration: none; font-size: 10px;"
                                href="holidaylist.php?deleteid=<?php echo $fetcho['holiday_id']; ?>"
                                onClick='return confirm("Confirm to Delete the listed holiday.")'
                                class="btn btn-outline-danger">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var picker = new Pikaday({
        field: document.getElementById('hdate'),
        format: 'DD-MMM-YY',
        yearRange: [moment().subtract(100, 'years').year(), moment().year()]
    });
});
document.addEventListener('DOMContentLoaded', function() {
    var picker = new Pikaday({
        field: document.getElementById('holiday_search'),
        format: 'DD-MMM-YY',
        yearRange: [moment().subtract(100, 'years').year(), moment().year()]
    });
});
$(document).ready(function() {
    // Initialize DataTables
    var table = $('#holidayTable').DataTable({
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
    $('#holidayXsearch').on('keyup change', function() {
        // Filter table data on input value change
        table.columns(2).search($(this).val()).draw();
    });
});
</script>

</html>