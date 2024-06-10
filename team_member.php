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
$updateidae=$_REQUEST['updateidae'];
if($updateidae){
  $sqlselae="UPDATE `employee` SET `employee_status`='0' WHERE `employee_id`='{$updateidae}'";
  $queryselae=mysqli_query($conn,$sqlselae);  
  ?>
<script>
window.location.href = "team_member.php";
</script>
<?php } ?>
<?php
$editidae=$_REQUEST['editidae'];
if($editidae){
  $sqleditae="UPDATE `employee` SET `employee_status`='1' WHERE `employee_id`='{$editidae}'";
  $queryeditae=mysqli_query($conn,$sqleditae);  
  ?>
<script>
window.location.href = "team_member.php";
</script>
<?php } ?>
<?php
$updateidme=$_REQUEST['updateidme'];
if($updateidme){
  $sqlselme="UPDATE `employee` SET `employee_status`='0' WHERE `employee_id`='{$updateidme}'";
  $queryselme=mysqli_query($conn,$sqlselme);  
  ?>
<script>
window.location.href = "team_member.php";
</script>
<?php } ?>
<?php
$editidme=$_REQUEST['editidme'];
if($editidme){
  $sqleditme="UPDATE `employee` SET `employee_status`='1' WHERE `employee_id`='{$editidme}'";
  $queryeditme=mysqli_query($conn,$sqleditme);  
  ?>
<script>
window.location.href = "team_member.php";
</script>
<?php } ?>
<?php
$updateidm=$_REQUEST['updateidm'];
if($updateidm){
  $sqlselm="UPDATE `assistant` SET `assistant_status`='0' WHERE `assistant_id`='{$updateidm}'";
  $queryselm=mysqli_query($conn,$sqlselm);  
  ?>
<script>
window.location.href = "team_member.php";
</script>
<?php } ?>
<?php
$editidm=$_REQUEST['editidm'];
if($editidm){
  $sqleditm="UPDATE `assistant` SET `assistant_status`='1' WHERE `assistant_id`='{$editidm}'";
  $queryeditm=mysqli_query($conn,$sqleditm);  
  ?>
<script>
window.location.href = "team_member.php";
</script>
<?php } ?>
<?php
$e_updateid=$_REQUEST['e_updateid'];
if($e_updateid){
  $sqlsele="UPDATE `employee` SET `employee_status`='0' WHERE `employee_id`='{$e_updateid}'";
  $querysele=mysqli_query($conn,$sqlsele);  
  ?>
<script>
window.location.href = "team_member.php";
</script>
<?php } ?>
<?php
$e_editid=$_REQUEST['e_editid'];
if($e_editid){
  $sqledite="UPDATE `employee` SET `employee_status`='1' WHERE `employee_id`='{$e_editid}'";
  $queryedite=mysqli_query($conn,$sqledite);  
  ?>
<script>
window.location.href = "team_member.php";
</script>
<?php } ?>
<?php
$a_updateid=$_REQUEST['a_updateid'];
if($a_updateid){
  $sqlsela="UPDATE `assistant` SET `assistant_status`='0' WHERE `assistant_id`='{$a_updateid}'";
  $querysela=mysqli_query($conn,$sqlsela);  
  ?>
<script>
window.location.href = "team_member.php";
</script>
<?php } ?>
<?php
$a_editid=$_REQUEST['a_editid'];
if($a_editid){
  $sqledita="UPDATE `assistant` SET `assistant_status`='1' WHERE `assistant_id`='{$a_editid}'";
  $queryedita=mysqli_query($conn,$sqledita);  
  ?>
<script>
window.location.href = "team_member.php";
</script>
<?php } ?>
<?php
$updateid=$_REQUEST['updateid'];
if($updateid){
  $sqlsel="UPDATE `manager` SET `manager_status`='0' WHERE `manager_id`='{$updateid}'";
  $querysel=mysqli_query($conn,$sqlsel);  
  ?>
<script>
window.location.href = "team_member.php";
</script>
<?php } ?>
<?php
$editid=$_REQUEST['editid'];
if($editid){
  $sqledit="UPDATE `manager` SET `manager_status`='1' WHERE `manager_id`='{$editid}'";
  $queryedit=mysqli_query($conn,$sqledit);  
  ?>
<script>
window.location.href = "team_member.php";
</script>
<?php } ?>
<?php
$a_promoteid=$_REQUEST['a_promoteid'];
if($a_promoteid){
  
  // Fetch assistant data
  $sqlFetchAssistant = "SELECT assistant_name, email, phone, company_id, `password` FROM assistant WHERE assistant_id='{$a_promoteid}'";
  $queryFetchAssistant = mysqli_query($conn, $sqlFetchAssistant);
  $assistantData = mysqli_fetch_array($queryFetchAssistant);

  // Insert data into the manager table
  $a_name = $assistantData['assistant_name'];
  $a_email = $assistantData['email'];
  $a_phone = $assistantData['phone'];
  $a_company = $assistantData['company_id'];
  $a_password = $assistantData['password'];
  $a_status = '1';
  $a_flag = '1';

  $sqlInsertManager = "INSERT INTO manager (company_id, manager_name, email, phone, `password`, manager_status, `flag`) VALUES ('$a_company', '$a_name', '$a_email', '$a_phone', '$a_password', '$a_status', '$a_flag')";
  $queryInsertManager = mysqli_query($conn, $sqlInsertManager);

  $last_id=mysqli_insert_id($conn);
  $assign_id="m_".$last_id;
  $sqllast="UPDATE manager SET `assign_id`='{$assign_id}'
  WHERE `manager_id`='{$last_id}'";
  $querylast=mysqli_query($conn,$sqllast);

  $sqlpa="UPDATE assistant SET assistant_status='0', `flag`='0', `password`='', email='' WHERE assistant_id='{$a_promoteid}'";
  $querypa=mysqli_query($conn,$sqlpa);
  ?>
<script>
window.history.replaceState({}, document.title, window.location.pathname);
</script>
<?php
  } 
?>
<?php
$e_promoteid=$_REQUEST['e_promoteid'];
if($e_promoteid){
  
  // Fetch assistant data
  $sqlFetchEmployee = "SELECT employee_name, email, phone, company_id, `password` FROM employee WHERE employee_id='{$e_promoteid}'";
  $queryFetchEmployee = mysqli_query($conn, $sqlFetchEmployee);
  $employeeData = mysqli_fetch_array($queryFetchEmployee);

  // Insert data into the manager table
  $e_name = $employeeData['employee_name'];
  $e_email = $employeeData['email'];
  $e_phone = $employeeData['phone'];
  $e_company = $employeeData['company_id'];
  $e_password = $employeeData['password'];
  $e_status = '1';
  $e_flag = '1';

  $sqlInsertAssistant = "INSERT INTO assistant (company_id, assistant_name, email, phone, `password`, assistant_status, `flag`) VALUES ('$e_company', '$e_name', '$e_email', '$e_phone', '$e_password', '$e_status', '$e_flag')";
  $queryInsertAssistant = mysqli_query($conn, $sqlInsertAssistant);

  $last_eid=mysqli_insert_id($conn);
  $assign_eid="as_".$last_eid;
  $sqlelast="UPDATE assistant SET `assign_id`='{$assign_eid}'
  WHERE `assistant_id`='{$last_eid}'";
  $queryelast=mysqli_query($conn,$sqlelast);

  $sqlpe="UPDATE employee SET employee_status='0', `flag`='0', `password`='', email='' WHERE employee_id='{$e_promoteid}'";
  $querype=mysqli_query($conn,$sqlpe);
  ?>
<script>
window.history.replaceState({}, document.title, window.location.pathname);
</script>
<?php
  } 
?>
<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">Manage Team Members</h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <nav class="navbar navbar-light bg-light smooth mb-3">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" id="teamXsearch" name="team_membar_search"
                        placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success">Clear</button>
                </form>

            </div>
        </nav>
        <div class="table-responsive smooth p-2" style="background-color: beige;">
            <table id="teamMemberTable" class="table table-striped-columns smooth cus-td p-2">
                <thead>
                    <tr>
                        <th style="min-width: 140px;">Name</th>
                        <th style="min-width: 200px;">Email</th>
                        <th>Phone</th>
                        <?php if($_SESSION['role']=='admin') {?>
                        <th>Company</th>
                        <?php } ?>
                        <th>Role</th>
                        <?php if($_SESSION['role']=='admin') {?>
                        <th style="min-width: 300px;">Action</th>
                        <?php } else { ?>
                        <th style="min-width: 200px;">Action</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($_SESSION['role']=='admin') {
                $sql4="SELECT manager.*, company_master.company_name FROM `manager`
                INNER JOIN company_master ON manager.company_id=company_master.company_id
                INNER JOIN reg ON company_master.admin_id=reg.admin_id
                WHERE reg.admin_id='{$_SESSION['id']}'".$na." ORDER BY `manager_id` ASC";
                $query4=mysqli_query($conn,$sql4);
                $sql41="SELECT assistant.*, company_master.company_name FROM assistant
                INNER JOIN company_master ON assistant.company_id=company_master.company_id
                INNER JOIN reg ON company_master.admin_id=reg.admin_id
                WHERE reg.admin_id='{$_SESSION['id']}' AND assistant.flag='1'".$naa." ORDER BY `assistant_id` ASC";
                $query41=mysqli_query($conn,$sql41);
                $sql42="SELECT employee.*, company_master.company_name FROM employee
                INNER JOIN company_master ON employee.company_id=company_master.company_id
                INNER JOIN reg ON company_master.admin_id=reg.admin_id
                WHERE reg.admin_id='{$_SESSION['id']}' AND employee.flag='1'".$naaa." ORDER BY `assistant_id` ASC";
                $query42=mysqli_query($conn,$sql42);
                while($content4=mysqli_fetch_array($query4)){ ?>
                    <tr style="font-size: 15px;">
                        <td><?php echo $content4['manager_name']; ?></td>
                        <td><?php echo $content4['email']; ?></td>
                        <td><?php echo $content4['phone']; ?></td>
                        <td><?php echo $content4['company_name']; ?></td>
                        <td>Manager</td>

                        <td>
                            <a style="text-decoration: none;"
                                href="team_member_update.php?edit_t=<?php echo $content4['manager_id']; ?>"> <button
                                    type="button" class="btn btn-outline-secondary"
                                    style="font-size: 10px;"><strong>Update
                                        Profile</strong></button>
                            </a>

                            &nbsp;|&nbsp;
                            <?php if($content4['manager_status']=='0') {?>
                            <a style="text-decoration: none; font-size: 10px;"
                                href="team_member.php?editid=<?php echo $content4['manager_id']; ?>"
                                class="btn btn-outline-secondary"
                                onClick='return confirm("Confirm to Activate this account.")'>Activate</a>
                            <?php } else { ?>
                            <a style="text-decoration: none; font-size: 10px;"
                                href="team_member.php?updateid=<?php echo $content4['manager_id']; ?>"
                                class="btn btn-outline-danger"
                                onClick='return confirm("Confirm to Deactivate this account.")'>Suspend</a>
                            <?php } ?>
                        </td>

                    </tr>
                    <?php }
                while($content41=mysqli_fetch_array($query41)){ ?>
                    <tr style="font-size: 15px;">
                        <td><?php echo $content41['assistant_name']; ?></td>
                        <td><?php echo $content41['email']; ?></td>
                        <td><?php echo $content41['phone']; ?></td>
                        <td><?php echo $content41['company_name']; ?></td>
                        <td>Assistant Manager</td>

                        <td>
                            <a style="text-decoration: none;"
                                href="team_member_update.php?edit_ta=<?php echo $content41['assistant_id']; ?>"> <button
                                    type="button" class="btn btn-outline-secondary"
                                    style="font-size: 10px;"><strong>Update
                                        Profile</strong></button>
                            </a>
                            &nbsp;|&nbsp;
                            <?php if($content41['assistant_status']=='0') {?>
                            <a style="text-decoration: none; font-size: 10px;"
                                href="team_member.php?a_editid=<?php echo $content41['assistant_id']; ?>"
                                class="btn btn-outline-secondary"
                                onClick='return confirm("Confirm to Activate this account.")'>Activate</a>
                            <?php } else { ?>
                            <a style="text-decoration: none; font-size: 10px;"
                                href="team_member.php?a_updateid=<?php echo $content41['assistant_id']; ?>"
                                class="btn btn-outline-danger"
                                onClick='return confirm("Confirm to Deactivate this account.")'>Suspend</a>
                            &nbsp;|&nbsp;
                            <a style="text-decoration: none; font-size: 10px;"
                                href="team_member.php?a_promoteid=<?php echo $content41['assistant_id']; ?>"
                                class="btn btn-outline-success"
                                onClick='return confirm("Confirm to Promote this account.")'>Promote</a>
                            <?php } ?>
                        </td>

                    </tr>
                    <?php } while($content42=mysqli_fetch_array($query42)){ ?>
                    <tr style="font-size: 15px;">
                        <td><?php echo $content42['employee_name']; ?></td>
                        <td><?php echo $content42['email']; ?></td>
                        <td><?php echo $content42['phone']; ?></td>
                        <td><?php echo $content42['company_name']; ?></td>
                        <td>Employee</td>

                        <td>
                            <a style="text-decoration: none;"
                                href="team_member_update.php?edit_te=<?php echo $content42['employee_id']; ?>"><button
                                    type="button" class="btn btn-outline-secondary"
                                    style="font-size: 10px;"><strong>Update
                                        Profile</strong></button>
                            </a>
                            &nbsp;|&nbsp;
                            <?php if($content42['employee_status']=='0') {?>
                            <a style="text-decoration: none; font-size: 10px;"
                                href="team_member.php?e_editid=<?php echo $content42['employee_id']; ?>"
                                class="btn btn-outline-secondary"
                                onClick='return confirm("Confirm to Activate this account.")'>Activate</a>
                            <?php } else { ?>
                            <a style="text-decoration: none; font-size: 10px;"
                                href="team_member.php?e_updateid=<?php echo $content42['employee_id']; ?>"
                                class="btn btn-outline-danger"
                                onClick='return confirm("Confirm to Deactivate this account.")'>Suspend</a>
                            &nbsp;|&nbsp;
                            <a style="text-decoration: none; font-size: 10px;"
                                href="team_member.php?e_promoteid=<?php echo $content42['employee_id']; ?>"
                                class="btn btn-outline-success"
                                onClick='return confirm("Confirm to Promote this account.")'>Promote</a>
                            <?php } ?>
                        </td>

                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <?php if($_SESSION['role']=='manager'){
                $sql4="SELECT * FROM `assistant`
                WHERE manager_id='{$_SESSION['id']}' AND `flag`='1'".$nm." ORDER BY `assistant_id` DESC";
                $query4=mysqli_query($conn,$sql4);
                $sql41="SELECT employee.* FROM `employee`
                INNER JOIN assistant ON employee.assistant_id=assistant.assistant_id
                INNER JOIN manager ON assistant.manager_id=manager.manager_id
                WHERE manager.manager_id='{$_SESSION['id']}' AND employee.flag='1'".$nmm." ORDER BY employee.employee_id DESC";
                $query41=mysqli_query($conn,$sql41);
                while($content4=mysqli_fetch_array($query4)){ ?>
                    <tr style="font-size: 15px;">
                        <td><?php echo $content4['assistant_name']; ?></td>
                        <td><?php echo $content4['email']; ?></td>
                        <td><?php echo $content4['phone']; ?></td>
                        <td>Assistant Manager</td>

                        <td>
                            <a style="text-decoration: none;"
                                href="team_member_update.php?edit_ta=<?php echo $content4['assistant_id']; ?>"><button
                                    type="button" class="btn btn-outline-secondary"
                                    style="font-size: 10px;"><strong>Update
                                        Profile</strong></button>
                            </a>
                            &nbsp;|&nbsp;
                            <?php if($content4['assistant_status']=='0') {?>
                            <a style="text-decoration: none; font-size: 10px;"
                                href="team_member.php?editidm=<?php echo $content4['assistant_id']; ?>"
                                class="btn btn-outline-secondary"
                                onClick='return confirm("Confirm to Activate this account.")'>Activate</a>
                            <?php } else { ?>
                            <a style="text-decoration: none; font-size: 10px;"
                                href="team_member.php?updateidm=<?php echo $content4['assistant_id']; ?>"
                                class="btn btn-outline-danger"
                                onClick='return confirm("Confirm to Deactivate this account.")'>Suspend</a>
                            <?php } ?>
                        </td>

                    </tr>
                    <?php }
                    while($content41=mysqli_fetch_array($query41)){ ?>
                    <tr style="font-size: 15px;">
                        <td><?php echo $content41['employee_name']; ?></td>
                        <td><?php echo $content41['email']; ?></td>
                        <td><?php echo $content41['phone']; ?></td>
                        <td>Employee</td>

                        <td>
                            <a style="text-decoration: none;"
                                href="team_member_update.php?edit_te=<?php echo $content41['employee_id']; ?>"><button
                                    type="button" class="btn btn-outline-secondary"
                                    style="font-size: 10px;"><strong>Update
                                        Profile</strong></button>
                            </a>
                            &nbsp;|&nbsp;
                            <?php if($content41['employee_status']=='0') {?>
                            <a style="text-decoration: none; font-size: 10px;"
                                href="team_member.php?editidme=<?php echo $content41['employee_id']; ?>"
                                class="btn btn-outline-secondary"
                                onClick='return confirm("Confirm to Activate this account.")'>Activate</a>
                            <?php } else { ?>
                            <a style="text-decoration: none; font-size: 10px;"
                                href="team_member.php?updateidme=<?php echo $content41['employee_id']; ?>"
                                class="btn btn-outline-danger"
                                onClick='return confirm("Confirm to Deactivate this account.")'>Suspend</a>
                            <?php } ?>
                        </td>

                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <?php if($_SESSION['role']=='assistant'){
                $sql4="SELECT employee.* FROM `employee`
                WHERE assistant_id='{$_SESSION['id']}'".$ne." ORDER BY `employee_id` DESC";
                $query4=mysqli_query($conn,$sql4);
                while($content4=mysqli_fetch_array($query4)){ ?>
                    <tr style="font-size: 15px;"
                        class="<?php echo ($content4['employee_status'] == 0) ? "closed-task" : ""; ?>">
                        <td><?php echo $content4['employee_name']; ?></td>
                        <td><?php echo $content4['email']; ?></td>
                        <td><?php echo $content4['phone']; ?></td>
                        <td>Employee</td>

                        <td>
                            <a style="text-decoration: none;"
                                href="team_member_update.php?edit_te=<?php echo $content4['employee_id']; ?>"><button
                                    type="button" class="btn btn-outline-secondary"
                                    style="font-size: 10px;"><strong>Update
                                        Profile</strong></button>
                            </a>
                            &nbsp;|&nbsp;
                            <?php if($content4['employee_status']=='0') {?>
                            <a style="text-decoration: none; font-size: 10px;"
                                href="team_member.php?editidae=<?php echo $content4['employee_id']; ?>"
                                class="btn btn-outline-secondary"
                                onClick='return confirm("Confirm to Activate this account.")'>Activate</a>
                            <?php } else { ?>
                            <a style="text-decoration: none; font-size: 10px;"
                                href="team_member.php?updateidae=<?php echo $content4['employee_id']; ?>"
                                class="btn btn-outline-danger"
                                onClick='return confirm("Confirm to Deactivate this account.")'>Suspend</a>
                            <?php } ?>
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
    var table = $('#teamMemberTable').DataTable({
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
    $('#teamXsearch').on('keyup change', function() {
        // Filter table data on input value change
        table.columns(0).search($(this).val()).draw();
    });
});
</script>
</body>

</html>