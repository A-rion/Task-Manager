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
if(isset($_POST['update'])){
  $fname=$_POST['fname'];
  $email=$_POST['email'];
  $phone=$_POST['phone'];
  $pimage=$_POST['pimage'];
  $target_dir = "uploads/";
  $pimage = basename($_FILES["pimage"]["name"]);
  $checkQuery = "SELECT email FROM reg WHERE email = '{$email}' AND NOT assign_id='{$_SESSION['assign']}'
  UNION
  SELECT email FROM manager WHERE email = '{$email}' AND manager_status='1' AND NOT assign_id='{$_SESSION['assign']}'
  UNION
  SELECT email FROM assistant WHERE email = '{$email}' AND assistant_status='1' AND NOT assign_id='{$_SESSION['assign']}'
  UNION
  SELECT email FROM employee WHERE email = '{$email}' AND employee_status='1' AND NOT assign_id='{$_SESSION['assign']}'";
  $checke=mysqli_query($conn,$checkQuery);
  $resulte=mysqli_num_rows($checke);
  if($resulte>0) {
    ?>
<script>
alert("Email is Already in Use.");
</script>
<?php
    } else {
  if($_SESSION['role']=='employee'){
  if (move_uploaded_file($_FILES["pimage"]["tmp_name"], $target_dir.$pimage)) {
    $inset="UPDATE `employee` SET `phone`='{$phone}',
                             `employee_name`='{$fname}',
                             `email`='{$email}',
                             `employee_pimage`='{$pimage}'
                             WHERE `employee_id`='{$_SESSION['id']}'";
  $uquery=mysqli_query($conn,$inset);
  }
  ?>
<script type="text/javascript">
window.location.href = "dashboard.php";
</script>
<?php
$inset="UPDATE `employee` SET `phone`='{$phone}',
`employee_name`='{$fname}',
`email`='{$email}'
WHERE `employee_id`='{$_SESSION['id']}'";
$uquery=mysqli_query($conn,$inset);
?>
<script type="text/javascript">
window.location.href = "dashboard.php";
</script>
<?php
  } else if($_SESSION['role']=='assistant'){
    if (move_uploaded_file($_FILES["pimage"]["tmp_name"], $target_dir.$pimage)) {
      $inset="UPDATE `assistant` SET `phone`='{$phone}',
                               `assistant_name`='{$fname}',
                               `email`='{$email}',
                               `assistant_pimage`='{$pimage}'
                               WHERE `assistant_id`='{$_SESSION['id']}'";
    $uquery=mysqli_query($conn,$inset);
    }
    ?>
<script type="text/javascript">
window.location.href = "dashboard.php";
</script>
<?php
  $inset="UPDATE `assistant` SET `phone`='{$phone}',
  `assistant_name`='{$fname}',
  `email`='{$email}'
  WHERE `assistant_id`='{$_SESSION['id']}'";
$uquery=mysqli_query($conn,$inset);
  ?>
<script type="text/javascript">
window.location.href = "dashboard.php";
</script>
<?php
  } else if($_SESSION['role']=='manager'){
    if (move_uploaded_file($_FILES["pimage"]["tmp_name"], $target_dir.$pimage)) {
      $inset="UPDATE `manager` SET `phone`='{$phone}',
                               `manager_name`='{$fname}',
                               `email`='{$email}',
                               `manager_pimage`='{$pimage}'
                               WHERE `manager_id`='{$_SESSION['id']}'";
    $uquery=mysqli_query($conn,$inset);
    }
    ?>
<script type="text/javascript">
window.location.href = "dashboard.php";
</script>
<?php
$inset="UPDATE `manager` SET `phone`='{$phone}',
`manager_name`='{$fname}',
`email`='{$email}'
WHERE `manager_id`='{$_SESSION['id']}'";
$uquery=mysqli_query($conn,$inset);
?>
<script type="text/javascript">
window.location.href = "dashboard.php";
</script>
<?php
  } else if($_SESSION['role']=='admin'){
    if (move_uploaded_file($_FILES["pimage"]["tmp_name"], $target_dir.$pimage)) {
      $inset="UPDATE `reg` SET `phone`='{$phone}',
                               `admin_name`='{$fname}',
                               `email`='{$email}',
                               `pimage`='{$pimage}'
                               WHERE `admin_id`='{$_SESSION['id']}'";
    $uquery=mysqli_query($conn,$inset);
    }
    ?>
<script type="text/javascript">
window.location.href = "dashboard.php";
</script>
<?php
      $inset="UPDATE `reg` SET `phone`='{$phone}',
      `admin_name`='{$fname}',
      `email`='{$email}'
      WHERE `admin_id`='{$_SESSION['id']}'";
$uquery=mysqli_query($conn,$inset);
?>
<script type="text/javascript">
window.location.href = "dashboard.php";
</script>
<?php
  }
}
}
?>

<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">My Profile</h4>
</div>
<div class="container w-100" style="max-width: 600px;">
    <div class="border border-3 smooth p-2" style="background-color: #fd9292;">
        <form class="p-2" method="post" enctype="multipart/form-data">
            <div class="row">

                <div class="col-md-12 mt-1">
                    <label for="inputEmail4" class="form-label ms-2"><strong>Email</strong></label>
                    <input type="email" name="email" class="form-control" id="inputEmail4"
                        value="<?php echo $_SESSION['email']; ?>">
                </div>
                <div class="col-md-6 mt-1">
                    <label for="firstname" class="form-label ms-2"><strong>Full name</strong></label>
                    <input type="text" name="fname" class="form-control" aria-label="First name" id="firstname"
                        value="<?php echo $_SESSION['name']; ?>">
                </div>

                <div class="col-md-6 mt-1">
                    <label for="phone" class="form-label ms-2"><strong>Contact Info.</strong></label>
                    <input type="text" name="phone" class="form-control" id="phone"
                        value="<?php echo $_SESSION['phone']; ?>">
                </div>
                <div class="col-md-12 mt-1">
                    <label for="formFile" class="form-label ms-2"><strong>Profile Picture</strong></label>
                    <input class="form-control" type="file" name="pimage" id="formFile" max-size="5000"
                        accept="image/png, image/jpeg">
                    <span class="notranslate ms-2" style="color:#FF5147;font-size:11px;">File format: .jpeg/ .png/ Max
                        file size limit: 5MB </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: center;">
                    <input type="submit" name="update" value="Update" class="btn btn-outline-success mt-2">
                </div>
            </div>
        </form>
    </div>
</div>
</body>

</html>