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
<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">Leave Application List</h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <nav class="navbar navbar-light bg-light smooth mb-3">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" placeholder="Type Applicant Name" aria-label="Search"
                        id="leavesearch" name="leavesearch">
                    <button class="btn btn-outline-success">Clear</button>
                </form>
            </div>
        </nav>
        <div class="table-responsive smooth p-2" style="background-color: beige;">
            <table id="teamleaveTable" class="table table-striped-columns smooth cus-td p-2">
                <thead>
                    <tr>
                        <th style="min-width: 140px;">Applicant</th>
                        <th style="min-width: 140px;">Request To</th>
                        <th style="min-width: 100px;">Apply Date</th>
                        <th style="min-width: 100px;">From Date</th>
                        <th style="min-width: 100px;">To Date</th>
                        <th>Days</th>
                        <th style="min-width: 200px;">Reason For Leave</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($_SESSION['role']=='assistant') {
                $sql12="SELECT myleave.*, employee.employee_name, assistant.assistant_name
                FROM myleave
                INNER JOIN assistant ON myleave.request_to=assistant.assign_id 
                INNER JOIN employee ON myleave.employee_id=employee.employee_id 
                WHERE employee.assistant_id='{$_SESSION['id']}' ORDER BY leave_id DESC";
                $query12=mysqli_query($conn,$sql12);
                while($fetch2=mysqli_fetch_array($query12)) {
                ?>
                    <tr>
                        <td><?php echo $fetch2['employee_name']; ?></td>
                        <td><?php echo $fetch2['assistant_name']; ?></td>
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
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <?php if($_SESSION['role']=='manager') {
                $sql12="SELECT myleave.*, assistant.assistant_name, manager.manager_name, reg.admin_name
                FROM myleave
                LEFT JOIN reg ON myleave.request_to=reg.assign_id 
                LEFT JOIN manager ON myleave.request_to=manager.assign_id 
                INNER JOIN assistant ON myleave.assistant_id=assistant.assistant_id 
                WHERE assistant.manager_id='{$_SESSION['id']}' ORDER BY leave_id DESC";
                $query12=mysqli_query($conn,$sql12);
                $sql1m="SELECT myleave.*, employee.employee_name, assistant.assistant_name
                FROM myleave
                INNER JOIN assistant ON myleave.request_to=assistant.assign_id 
                INNER JOIN employee ON myleave.employee_id=employee.employee_id 
                WHERE employee.company_id='{$_SESSION['company']}' ORDER BY leave_id DESC";
                $query1m=mysqli_query($conn,$sql1m);
                while($fetch2=mysqli_fetch_array($query12)) {
                ?>
                    <tr>
                        <td><?php echo $fetch2['assistant_name']; ?></td>
                        <td>
                            <?php echo $fetch2['admin_name']; ?>
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
                    </tr>
                    <?php } ?>
                    <?php while($fetch2m=mysqli_fetch_array($query1m)) {
                ?>
                    <tr>
                        <td><?php echo $fetch2m['employee_name']; ?></td>
                        <td><?php echo $fetch2m['assistant_name']; ?></td>
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
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <?php if($_SESSION['role']=='admin') {
                $sql12="SELECT myleave.*, manager.manager_name
                FROM myleave
                INNER JOIN manager ON myleave.manager_id=manager.manager_id
                WHERE myleave.request_to='{$_SESSION['assign']}' ORDER BY leave_id DESC";
                $query12=mysqli_query($conn,$sql12);
                while($fetch2=mysqli_fetch_array($query12)) {
                ?>
                    <tr>
                        <td><?php echo $fetch2['manager_name']; ?></td>
                        <td><?php echo $_SESSION['name']; ?></td>
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
                    </tr>
                    <?php } ?>
                    <?php $sql1a="SELECT myleave.*, manager.manager_name, reg.admin_name, assistant.assistant_name
                FROM myleave
                LEFT JOIN manager ON myleave.request_to=manager.assign_id
                LEFT JOIN reg ON myleave.request_to=reg.assign_id
                INNER JOIN assistant ON myleave.assistant_id=assistant.assistant_id
                INNER JOIN company_master ON assistant.company_id=company_master.company_id
                WHERE company_master.admin_id='{$_SESSION['id']}' ORDER BY `leave_id` DESC";
                $query1a=mysqli_query($conn,$sql1a);
                $sql2a="SELECT myleave.*, assistant.assistant_name, employee.employee_name
                FROM myleave
                INNER JOIN assistant ON myleave.request_to=assistant.assign_id
                INNER JOIN employee ON myleave.employee_id=employee.employee_id
                INNER JOIN company_master ON employee.company_id=company_master.company_id
                WHERE company_master.admin_id='{$_SESSION['id']}' ORDER BY `leave_id` DESC";
                $query2a=mysqli_query($conn,$sql2a);
                while($fetch2a=mysqli_fetch_array($query1a)) {
                ?>
                    <tr>
                        <td><?php echo $fetch2a['assistant_name']; ?></td>
                        <td>
                            <?php echo $fetch2a['admin_name']; ?>
                            <?php echo $fetch2a['manager_name']; ?>
                        </td>
                        <td><?php echo $fetch2a['apply_date']; ?></td>
                        <td><?php echo $fetch2a['form_date']; ?></td>
                        <td><?php echo $fetch2a['to_date']; ?></td>
                        <?php 
                    $start_a_date = strtotime($fetch2a['form_date']);
                    $end_a_date = strtotime($fetch2a['to_date']);
                ?>
                        <td><?php echo ($end_a_date - $start_a_date)/60/60/24; ?></td>
                        <td><?php echo $fetch2a['reason']; ?></td>
                        <td><?php echo $fetch2a['l_status']; ?></td>
                    </tr>
                    <?php }
                while($fetch2aa=mysqli_fetch_array($query2a)) {
                ?>
                    <tr>
                        <td><?php echo $fetch2aa['employee_name']; ?></td>
                        <td><?php echo $fetch2aa['assistant_name']; ?></td>
                        <td><?php echo $fetch2aa['apply_date']; ?></td>
                        <td><?php echo $fetch2aa['form_date']; ?></td>
                        <td><?php echo $fetch2aa['to_date']; ?></td>
                        <?php 
                    $start_e_date = strtotime($fetch2aa['form_date']);
                    $end_e_date = strtotime($fetch2aa['to_date']);
                ?>
                        <td><?php echo ($end_e_date - $start_e_date)/60/60/24; ?></td>
                        <td><?php echo $fetch2aa['reason']; ?></td>
                        <td><?php echo $fetch2aa['l_status']; ?></td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // Initialize DataTables
    var table = $('#teamleaveTable').DataTable({
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
    $('#leavesearch').on('keyup change', function() {
        // Filter table data on input value change
        table.columns(0).search($(this).val()).draw();
    });
});
</script>
</body>

</html>