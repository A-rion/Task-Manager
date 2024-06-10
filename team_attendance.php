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
if(isset($_POST['team_sub'])){
$team_at=$_POST['team_at'];
$t_at="AND (manager.manager_name LIKE '%$team_at%')";
$t_at1="AND (assistant.assistant_name LIKE '%$team_at%')";
$t_at2="AND (employee.employee_name LIKE '%$team_at%')";
}
?>

<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">Team Attendance</h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <nav class="navbar navbar-light bg-light smooth mb-3">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" name="team_at" id="team_at" placeholder="Search"
                        aria-label="Search">
                    <button class="btn btn-outline-success">Clear</button>
                </form>
            </div>
        </nav>
        <div class="table-responsive smooth p-2" style="background-color: beige;">
            <table id="teamAttendance" class="table table-striped-columns smooth p-2">
                <thead>
                    <tr class="cus-td">
                        <th class="w-max-content">Name</th>
                        <th class="w-max-content">Last 5 Days of Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($_SESSION['role']=='admin'){
                        $sqlat="SELECT manager.manager_id, manager.manager_name, manager.manager_status FROM manager 
                        INNER JOIN company_master ON manager.company_id=company_master.company_id 
                        WHERE company_master.admin_id='{$_SESSION['id']}'".$t_at;
                        $queryat=mysqli_query($conn,$sqlat);
                        while($takeat=mysqli_fetch_array($queryat)) {
                        $sqlat1="SELECT a_status FROM attendance WHERE manager_id='{$takeat['manager_id']}' ORDER BY a_date DESC LIMIT 5";
                        $queryat1=mysqli_query($conn,$sqlat1);
                        ?>
                    <tr class="cus-td">
                        <td class="w-max-content <?php echo ($takeat['manager_status'] == 0) ? "closed-task" : ""; ?>">
                            <a style="text-decoration: none; color: #021c3b;"
                                href="detail_attendance.php?detail_m=<?php echo $takeat['manager_id']; ?>">
                                <div><?php echo $takeat['manager_name']; ?></div>
                            </a></td>
                        <td class="w-max-content">
                            <?php while($takeat1=mysqli_fetch_array($queryat1)) { ?>
                            <?php if($takeat1['a_status']=='Absent'){ ?>
                            <img src="assets/images/logos/a.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat1['a_status']=='Present') { ?>
                            <img src="assets/images/logos/letter-p.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat1['a_status']=='Holiday') { ?>
                            <img src="assets/images/logos/icons8-h-67.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat1['a_status']=='Leave') { ?>
                            <img src="assets/images/logos/icons8-xbox-l-80.png"
                                style="height: 25px; border-radius: 50%;">
                            <?php } } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php $sqlat2="SELECT assistant.assistant_id, assistant.assistant_name, assistant.assistant_status FROM assistant 
                        INNER JOIN company_master ON assistant.company_id=company_master.company_id 
                        WHERE company_master.admin_id='{$_SESSION['id']}'".$t_at1;
                        $queryat2=mysqli_query($conn,$sqlat2);
                        while($takeat2=mysqli_fetch_array($queryat2)) {
                        $sqlat12="SELECT a_status FROM attendance WHERE assistant_id='{$takeat2['assistant_id']}' ORDER BY a_date DESC LIMIT 5";
                        $queryat12=mysqli_query($conn,$sqlat12);
                        ?>
                    <tr class="cus-td">
                        <td
                            class="w-max-content <?php echo ($takeat2['assistant_status'] == 0) ? "closed-task" : ""; ?>">
                            <a style="text-decoration: none; color: #021c3b;"
                                href="detail_attendance.php?detail_a=<?php echo $takeat2['assistant_id']; ?>">
                                <div><?php echo $takeat2['assistant_name']; ?></div>
                            </a></td>
                        <td class="w-max-content">
                            <?php while($takeat12=mysqli_fetch_array($queryat12)) { ?>
                            <?php if($takeat12['a_status']=='Absent'){ ?>
                            <img src="assets/images/logos/a.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat12['a_status']=='Present') { ?>
                            <img src="assets/images/logos/letter-p.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat12['a_status']=='Holiday') { ?>
                            <img src="assets/images/logos/icons8-h-67.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat12['a_status']=='Leave') { ?>
                            <img src="assets/images/logos/icons8-xbox-l-80.png"
                                style="height: 25px; border-radius: 50%;">
                            <?php } } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php $sqlat3="SELECT employee.employee_id, employee.employee_name, employee.employee_status FROM employee 
                        INNER JOIN company_master ON employee.company_id=company_master.company_id 
                        WHERE company_master.admin_id='{$_SESSION['id']}'".$t_at2;
                        $queryat3=mysqli_query($conn,$sqlat3);
                        while($takeat3=mysqli_fetch_array($queryat3)) {
                        $sqlat13="SELECT a_status FROM attendance WHERE employee_id='{$takeat3['employee_id']}' ORDER BY a_date DESC LIMIT 5";
                        $queryat13=mysqli_query($conn,$sqlat13);
                        ?>
                    <tr class="cus-td">
                        <td
                            class="w-max-content <?php echo ($takeat3['employee_status'] == 0) ? "closed-task" : ""; ?>">
                            <a style="text-decoration: none; color: #021c3b;"
                                href="detail_attendance.php?detail_e=<?php echo $takeat3['employee_id']; ?>">
                                <div><?php echo $takeat3['employee_name']; ?></div>
                            </a></td>
                        <td class="w-max-content">
                            <?php while($takeat13=mysqli_fetch_array($queryat13)) { ?>
                            <?php if($takeat13['a_status']=='Absent'){ ?>
                            <img src="assets/images/logos/a.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat13['a_status']=='Present') { ?>
                            <img src="assets/images/logos/letter-p.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat13['a_status']=='Holiday') { ?>
                            <img src="assets/images/logos/icons8-h-67.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat13['a_status']=='Leave') { ?>
                            <img src="assets/images/logos/icons8-xbox-l-80.png"
                                style="height: 25px; border-radius: 50%;">
                            <?php } } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <?php if($_SESSION['role']=='manager'){
                        $sqlat="SELECT assistant.assistant_id, assistant.assistant_name, assistant_status FROM assistant 
                        WHERE (assistant.manager_id='{$_SESSION['id']}' OR assistant.company_id='{$_SESSION['company']}')".$t_at1;
                        $queryat=mysqli_query($conn,$sqlat);
                        while($takeat=mysqli_fetch_array($queryat)) {
                        $sqlat1="SELECT a_status FROM attendance WHERE assistant_id='{$takeat['assistant_id']}' ORDER BY a_date DESC LIMIT 5";
                        $queryat1=mysqli_query($conn,$sqlat1);
                        ?>
                    <tr class="cus-td">
                        <td
                            class="w-max-content <?php echo ($takeat['assistant_status'] == 0) ? "closed-task" : ""; ?>">
                            <a style="text-decoration: none; color: #021c3b;"
                                href="detail_attendance.php?detail_a=<?php echo $takeat['assistant_id']; ?>">
                                <div><?php echo $takeat['assistant_name']; ?></div>
                            </a></td>
                        <td class="w-max-content">
                            <?php while($takeat1=mysqli_fetch_array($queryat1)) { ?>
                            <?php if($takeat1['a_status']=='Absent'){ ?>
                            <img src="assets/images/logos/a.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat1['a_status']=='Present') { ?>
                            <img src="assets/images/logos/letter-p.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat1['a_status']=='Holiday') { ?>
                            <img src="assets/images/logos/icons8-h-67.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat1['a_status']=='Leave') { ?>
                            <img src="assets/images/logos/icons8-xbox-l-80.png"
                                style="height: 25px; border-radius: 50%;">
                            <?php } } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php $sqlat3="SELECT employee.employee_id, employee.employee_name, employee_status FROM employee 
                        INNER JOIN assistant ON employee.assistant_id=assistant.assistant_id
                        WHERE (assistant.manager_id='{$_SESSION['id']}' OR assistant.company_id='{$_SESSION['company']}')".$t_at2;
                        $queryat3=mysqli_query($conn,$sqlat3);
                        while($takeat3=mysqli_fetch_array($queryat3)) {
                        $sqlat13="SELECT a_status FROM attendance WHERE employee_id='{$takeat3['employee_id']}' ORDER BY a_date DESC LIMIT 5";
                        $queryat13=mysqli_query($conn,$sqlat13);
                        ?>
                    <tr class="cus-td">
                        <td
                            class="w-max-content <?php echo ($takeat3['employee_status'] == 0) ? "closed-task" : ""; ?>">
                            <a style="text-decoration: none; color: #021c3b;"
                                href="detail_attendance.php?detail_e=<?php echo $takeat3['employee_id']; ?>">
                                <div><?php echo $takeat3['employee_name']; ?></div>
                            </a></td>
                        <td class="w-max-content">
                            <?php while($takeat13=mysqli_fetch_array($queryat13)) { ?>
                            <?php if($takeat13['a_status']=='Absent'){ ?>
                            <img src="assets/images/logos/a.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat13['a_status']=='Present') { ?>
                            <img src="assets/images/logos/letter-p.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat13['a_status']=='Holiday') { ?>
                            <img src="assets/images/logos/icons8-h-67.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat13['a_status']=='Leave') { ?>
                            <img src="assets/images/logos/icons8-xbox-l-80.png"
                                style="height: 25px; border-radius: 50%;">
                            <?php } } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <?php if($_SESSION['role']=='assistant'){
                        $sqlat3="SELECT employee.employee_id, employee.employee_name, employee_status FROM employee 
                        WHERE employee.assistant_id='{$_SESSION['id']}'".$t_at2;
                        $queryat3=mysqli_query($conn,$sqlat3);
                        while($takeat3=mysqli_fetch_array($queryat3)) {
                        $sqlat13="SELECT a_status FROM attendance WHERE employee_id='{$takeat3['employee_id']}' ORDER BY a_date DESC LIMIT 5";
                        $queryat13=mysqli_query($conn,$sqlat13);
                        ?>
                    <tr class="cus-td">
                        <td
                            class="w-max-content <?php echo ($takeat3['employee_status'] == 0) ? "closed-task" : ""; ?>">
                            <a style="text-decoration: none; color: #021c3b;"
                                href="detail_attendance.php?detail_e=<?php echo $takeat3['employee_id']; ?>">
                                <div><?php echo $takeat3['employee_name']; ?></div>
                            </a></td>
                        <td class="w-max-content">
                            <?php while($takeat13=mysqli_fetch_array($queryat13)) { ?>
                            <?php if($takeat13['a_status']=='Absent'){ ?>
                            <img src="assets/images/logos/a.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat13['a_status']=='Present') { ?>
                            <img src="assets/images/logos/letter-p.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat13['a_status']=='Holiday') { ?>
                            <img src="assets/images/logos/icons8-h-67.png" style="height: 20px; border-radius: 50%;">
                            <?php } else if($takeat13['a_status']=='Leave') { ?>
                            <img src="assets/images/logos/icons8-xbox-l-80.png"
                                style="height: 25px; border-radius: 50%;">
                            <?php } } ?>
                        </td>
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
    var table = $('#teamAttendance').DataTable({
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