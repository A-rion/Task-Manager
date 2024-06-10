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
    <h4 class="aemp">Teams</h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <nav class="navbar navbar-light bg-light smooth mb-3">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" id="team_search" name="team_search"
                        placeholder="Search By Name" aria-label="Search">
                    <input class="btn btn-outline-success" type="submit" name="search_t" value="Search">
                </form>
            </div>
        </nav>
        <div class="table-responsive smooth p-2" style="background-color: beige;">
            <table id="teamTable" class="table table-striped-columns smooth p-2">
                <thead>
                    <tr>
                        <th class="cus-td" style="min-width: 200px;">Assistant Manager</th>
                        <th style="min-width: 500px;">Team Member</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($_SESSION['role']=='assistant') {
                $sql16="SELECT employee_name FROM employee WHERE assistant_id='{$_SESSION['id']}' AND employee_status='1'";
                $query16=mysqli_query($conn,$sql16);
                $count=mysqli_num_rows($query16);
                ?>
                    <tr style="font-size: 15px;">
                        <td class="cus-td"><?php echo $_SESSION['name']; ?></td>
                        <td><?php if($count>0) {
                            while($fetch5=mysqli_fetch_array($query16)) {
                        echo $fetch5['employee_name'];
                        ?>,&nbsp;<?php } } else { ?>
                            <div>No Team Member</div>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if ($_SESSION['role']=='manager') {
                $sql16="SELECT assistant_name, assistant_id, assistant_status FROM assistant WHERE manager_id='{$_SESSION['id']}'";
                $query16=mysqli_query($conn,$sql16);
                while($fetch5=mysqli_fetch_array($query16)) {
                $sql17="SELECT employee_name FROM employee WHERE assistant_id='{$fetch5['assistant_id']}' AND employee_status='1'";
                $query17=mysqli_query($conn,$sql17);
                $count=mysqli_num_rows($query17);
                ?>
                    <tr style="font-size: 15px;"
                        class="<?php echo ($fetch5['assistant_status'] == 0) ? "closed-task" : ""; ?>">
                        <td class="cus-td"><?php echo $fetch5['assistant_name']; ?></td>
                        <td><?php if($count>0) {
                            while($fetch6=mysqli_fetch_array($query17)) {
                        echo $fetch6['employee_name']; ?>,&nbsp;
                            <?php } } else { ?>
                            <div>No Team Member</div>
                            <?php } ?>
                        </td>
                    </tr><?php } } ?>
                    <?php if ($_SESSION['role']=='admin') {
                $sql16="SELECT assistant_name, assistant_id, assistant_status FROM assistant
                INNER JOIN company_master ON assistant.company_id=company_master.company_id
                INNER JOIN reg ON company_master.admin_id=reg.admin_id
                WHERE reg.admin_id='{$_SESSION['id']}'";
                $query16=mysqli_query($conn,$sql16);
                while($fetch5=mysqli_fetch_array($query16)) {
                $sql17="SELECT employee_name FROM employee WHERE assistant_id='{$fetch5['assistant_id']}' AND employee_status='1'";
                $query17=mysqli_query($conn,$sql17);
                $count=mysqli_num_rows($query17);
                ?>
                    <tr style="font-size: 15px;"
                        class="<?php echo ($fetch5['assistant_status'] == 0) ? "closed-task" : ""; ?>">
                        <td class="cus-td"><?php echo $fetch5['assistant_name']; ?></td>
                        <td><?php if($count) {
                            while($fetch6=mysqli_fetch_array($query17)) {
                        echo $fetch6['employee_name']; ?>,&nbsp;
                            <?php } } else { ?>
                            <div>No Team Member</div>
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
    var table = $('#teamTable').DataTable({
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
    $('#team_search').on('keyup change', function() {
        // Filter table data on input value change
        table.columns(0).search($(this).val()).draw();
    });
});
</script>
</body>

</html>