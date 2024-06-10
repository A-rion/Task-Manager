<?php session_start();
include("conn.php");
include("header.php");
if(!$_SESSION['id']){
?>
<script>
window.location.href = "index.php";
</script>
<?php
}
?>
<?php
    $edit_t=$_REQUEST['edit_t'];
    $edit_ta=$_REQUEST['edit_ta'];
    $edit_te=$_REQUEST['edit_te'];
    if($edit_t || $edit_ta || $edit_te) {
        $sqledit="SELECT * FROM `manager` WHERE `manager_id`='{$edit_t}'";
        $queryedit=mysqli_query($conn,$sqledit);
        $fetchedit=mysqli_fetch_array($queryedit);
    
    
        $sqledita="SELECT * FROM `assistant` WHERE `assistant_id`='{$edit_ta}'";
        $queryedita=mysqli_query($conn,$sqledita);
        $fetchedita=mysqli_fetch_array($queryedita);
    
    
        $sqledite="SELECT * FROM `employee` WHERE `employee_id`='{$edit_te}'";
        $queryedite=mysqli_query($conn,$sqledite);
        $fetchedite=mysqli_fetch_array($queryedite);
    }
?>
<?php
if(isset($_POST['update'])) {
    $fname=$_POST['fname'];
    $m_cname=$_POST['m_cname'];
    $role=$_POST['role'];
    $role1=$_POST['role1'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $checkQuery = "SELECT email FROM reg WHERE email = '{$email}'
  UNION
  SELECT email FROM manager WHERE email = '{$email}' AND manager_status='1' AND NOT manager_id='{$edit_t}'
  UNION
  SELECT email FROM assistant WHERE email = '{$email}' AND assistant_status='1' AND NOT assistant_id='{$edit_ta}'
  UNION
  SELECT email FROM employee WHERE email = '{$email}' AND employee_status='1' AND NOT employee_id='{$edit_te}'";
  $checke=mysqli_query($conn,$checkQuery);
  $resulte=mysqli_num_rows($checke);
  if($resulte>0) {
    ?>
<script>
alert("Email is Already in Use.");
</script>
<?php
    } else {
    if($edit_t) {
    if($_SESSION['role']=='admin') {
    $sql="UPDATE `manager` SET `company_id`='{$m_cname}',`manager_name`='{$fname}',`email`='{$email}',`phone`='{$phone}' 
    WHERE `manager_id`='{$edit_t}'";
    $query=mysqli_query($conn,$sql);
?>
<script>
window.location.href = "team_member.php";
</script>
<?php } else {
    $sql="UPDATE `manager` SET `manager_name`='{$fname}',`email`='{$email}',`phone`='{$phone}' 
    WHERE `manager_id`='{$edit_t}'";
    $query=mysqli_query($conn,$sql);
?>
<script>
window.location.href = "team_member.php";
</script>
<?php
}
} else if($edit_ta) {
    if($_SESSION['role']=='admin') {
    $sql="UPDATE `assistant` SET `company_id`='{$m_cname}',`manager_id`='{$role}',`assistant_name`='{$fname}',`email`='{$email}',`phone`='{$phone}' 
    WHERE `assistant_id`='{$edit_ta}'";
    $query=mysqli_query($conn,$sql);
?>
<script>
window.location.href = "team_member.php";
</script>
<?php } else {
    $sql="UPDATE `assistant` SET `assistant_name`='{$fname}',`email`='{$email}',`phone`='{$phone}' 
    WHERE `assistant_id`='{$edit_ta}'";
    $query=mysqli_query($conn,$sql);
?>
<script>
window.location.href = "team_member.php";
</script>
<?php
}
} else if($edit_te) {
    if($_SESSION['role']=='admin') {
    $sql="UPDATE `employee` SET `company_id`='{$m_cname}',`assistant_id`='{$role1}',`employee_name`='{$fname}',`email`='{$email}',`phone`='{$phone}' 
    WHERE `employee_id`='{$edit_te}'";
    $query=mysqli_query($conn,$sql);
?>
<script>
window.location.href = "team_member.php";
</script>
<?php } else {
    $sql="UPDATE `employee` SET `employee_name`='{$fname}',`email`='{$email}',`phone`='{$phone}' 
    WHERE `employee_id`='{$edit_te}'";
    $query=mysqli_query($conn,$sql);
?>
<script>
window.location.href = "team_member.php";
</script>
<?php
}
}
}
}
?>
<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">Update Team Members</h4>
</div>
<div class="container p-5" style="max-width: 750px;">
    <div class="border border-3 smooth p-3" style="background-color: #fd9292;">
        <form class="p-3" method="post">
            <div class="row">
                <?php if($edit_t) { ?>
                <div class="col-md-6">
                    <label for="firstname" class="form-label ms-2"><strong>Full name</strong></label>
                    <input type="text" name="fname" class="form-control" aria-label="First name" id="firstname"
                        value="<?php echo $fetchedit['manager_name']; ?>">
                </div>
                <?php } else if($edit_ta){ ?>
                <div class="col-md-6">
                    <label for="firstname" class="form-label ms-2"><strong>Full name</strong></label>
                    <input type="text" name="fname" class="form-control" aria-label="First name" id="firstname"
                        value="<?php echo $fetchedita['assistant_name']; ?>">
                </div>
                <?php } else if($edit_te){ ?>
                <div class="col-md-6">
                    <label for="firstname" class="form-label ms-2"><strong>Full name</strong></label>
                    <input type="text" name="fname" class="form-control" aria-label="First name" id="firstname"
                        value="<?php echo $fetchedite['employee_name']; ?>">
                </div>
                <?php } ?>
                <?php if($_SESSION['role']=='admin') {
                $sqlcid="SELECT `company_name`, `company_id` FROM `company_master` WHERE `admin_id`='{$_SESSION['id']}'";
                $querycid=mysqli_query($conn,$sqlcid);
                if($edit_t) {
                ?>
                <div class="col-md-6">
                    <label class="form-label ms-2"><strong>Company Name</strong></label>
                    <select class="form-select" aria-label="Default select example" name="m_cname">
                        <?php while($fetch=mysqli_fetch_array($querycid)) { ?>
                        <option value="<?php echo $fetch['company_id']; ?>"
                            <?php if($fetchedit['company_id']==$fetch['company_id']){echo"selected";}?>>
                            <?php echo $fetch['company_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php } else if($edit_ta) {?>
                <div class="col-md-6">
                    <label class="form-label ms-2"><strong>Company Name</strong></label>
                    <select class="form-select" aria-label="Default select example" name="m_cname">
                        <?php while($fetch=mysqli_fetch_array($querycid)) { ?>
                        <option value="<?php echo $fetch['company_id']; ?>"
                            <?php if($fetchedita['company_id']==$fetch['company_id']){echo"selected";}?>>
                            <?php echo $fetch['company_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php } else if($edit_te) {?>
                <div class="col-md-6">
                    <label class="form-label ms-2"><strong>Company Name</strong></label>
                    <select class="form-select" aria-label="Default select example" name="m_cname">
                        <?php while($fetch=mysqli_fetch_array($querycid)) { ?>
                        <option value="<?php echo $fetch['company_id']; ?>"
                            <?php if($fetchedite['company_id']==$fetch['company_id']){echo"selected";}?>>
                            <?php echo $fetch['company_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php } ?>
                <?php if($edit_ta) {
                    $keep="SELECT manager.manager_id, manager.manager_name FROM manager
                    INNER JOIN company_master ON manager.company_id=company_master.company_id
                    INNER JOIN reg ON company_master.admin_id=reg.admin_id
                    WHERE reg.admin_id='{$_SESSION['id']}' AND  manager.manager_status='1'";
                    $give=mysqli_query($conn,$keep);
                ?>
                <div class="col-md-6">
                    <label class="form-label ms-2"><strong>Manager Name</strong></label>
                    <select class="form-select" name="role">
                        <option value="0">Select Manager</option>
                        <?php while($mana=mysqli_fetch_array($give)) { ?>
                        <option value="<?php echo $mana['manager_id']; ?>"
                            <?php if($fetchedita['manager_id']==$mana['manager_id']){echo"selected";}?>>
                            <?php echo $mana['manager_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php } else if($edit_te) {
                    $keep1="SELECT assistant.assistant_name, assistant.assistant_id FROM `assistant`
                    INNER JOIN company_master ON assistant.company_id=company_master.company_id
                    INNER JOIN reg ON company_master.admin_id=reg.admin_id
                    WHERE reg.admin_id='{$_SESSION['id']}' AND assistant.assistant_status='1'";
                    $give1=mysqli_query($conn,$keep1);
                ?>
                <div class="col-md-6">
                    <label class="form-label ms-2"><strong>Assistant Manager Name</strong></label>
                    <select class="form-select" name="role1">
                        <option value="0">Select Assistant Manager</option>
                        <?php while($take1=mysqli_fetch_array($give1)) { ?>
                        <option value="<?php echo $take1['assistant_id']; ?>"
                            <?php if($fetchedite['assistant_id']==$take1['assistant_id']){echo"selected";}?>>
                            <?php echo $take1['assistant_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php } } ?>
                <?php if($edit_t) { ?>
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label ms-2"><strong>Email</strong></label>
                    <input type="email" name="email" class="form-control" id="inputEmail4"
                        value="<?php echo $fetchedit['email']; ?>">
                </div>
                <?php } else if($edit_ta) {?>
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label ms-2"><strong>Email</strong></label>
                    <input type="email" name="email" class="form-control" id="inputEmail4"
                        value="<?php echo $fetchedita['email']; ?>">
                </div>
                <?php } else if($edit_te) {?>
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label ms-2"><strong>Email</strong></label>
                    <input type="email" name="email" class="form-control" id="inputEmail4"
                        value="<?php echo $fetchedite['email']; ?>">
                </div>
                <?php } ?>
                <?php if($edit_t) {?>
                <div class="col-md-6">
                    <label for="phone" class="form-label ms-2"><strong>Contact Info.</strong></label>
                    <input type="text" name="phone" class="form-control" id="phone"
                        value="<?php echo $fetchedit['phone']; ?>">
                </div>
                <?php } else if($edit_ta) { ?>
                <div class="col-md-6">
                    <label for="phone" class="form-label ms-2"><strong>Contact Info.</strong></label>
                    <input type="text" name="phone" class="form-control" id="phone"
                        value="<?php echo $fetchedita['phone']; ?>">
                </div>
                <?php } else if($edit_te) { ?>
                <div class="col-md-6">
                    <label for="phone" class="form-label ms-2"><strong>Contact Info.</strong></label>
                    <input type="text" name="phone" class="form-control" id="phone"
                        value="<?php echo $fetchedite['phone']; ?>">
                </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-md-12 mt-2" style="text-align: center;">
                    <input type="submit" name="update" value="Update" class="btn btn-outline-success m-2">
                </div>
            </div>
        </form>
    </div>
</div>