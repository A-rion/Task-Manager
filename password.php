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
if(isset($_POST['passu'])){
    $newpass=password_hash($_POST['newpass'],PASSWORD_BCRYPT);
    $conpass=$_POST['conpass'];
    if(password_verify($conpass,$newpass)){
        if($_SESSION['role']=='admin') {
        $sqlpas="UPDATE `reg` SET `password`='{$newpass}' WHERE `admin_id`='{$_SESSION['id']}'";
        $querypas=mysqli_query($conn,$sqlpas);
    ?>
<script>
alert("Your Password has been Updated!.");
window.location.href = "password.php";
</script>
<?php
    } else if($_SESSION['role']=='manager') {
        $sqlpas="UPDATE `manager` SET `password`='{$newpass}' WHERE `manager_id`='{$_SESSION['id']}'";
        $querypas=mysqli_query($conn,$sqlpas);
    ?>
<script>
alert("Your Password has been Updated!.");
window.location.href = "password.php";
</script>
<?php
    } else if($_SESSION['role']=='assistant') {
        $sqlpas="UPDATE `assistant` SET `password`='{$newpass}' WHERE `assistant_id`='{$_SESSION['id']}'";
        $querypas=mysqli_query($conn,$sqlpas);
      ?>
<script>
alert("Your Password has been Updated!.");
window.location.href = "password.php";
</script>
<?php
    } else if($_SESSION['role']=='employee') {
        $sqlpas="UPDATE `employee` SET `password`='{$newpass}' WHERE `employee_id`='{$_SESSION['id']}'";
        $querypas=mysqli_query($conn,$sqlpas);
      ?>
<script>
alert("Your Password has been Updated!.");
window.location.href = "password.php";
</script>
<?php
    }
} else {
    ?>
<script>
alert("Check Your Password!.");
</script>
<?php
      }
  }
?>

<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">Change Password</h4>
</div>
<div class="container p-3" style="max-width: 600px;">
    <div class="border border-3 smooth p-3" style="background-color: #fd9292;">
        <form class="p-3" method="post">
            <div class="row">
                <div class="col-md-12 m-1">
                    <label for="newpass" class="form-label ms-2"><strong>New Password</strong></label>
                    <input type="password" class="form-control" id="newpass" name="newpass" placeholder="********"
                        minlength="8" required>
                </div>
                <div class="col-md-12 m-1">
                    <label for="conpass" class="form-label ms-2"><strong>Confirm Password</strong></label>
                    <input type="password" class="form-control" id="conpass" name="conpass" placeholder="********"
                        minlength="8" required>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2" style="text-align: center;">
                        <input type="submit" name="passu" class="btn btn-outline-success m-2" value="Update">
                    </div>
                </div>
        </form>
    </div>
</div>
</body>

</html>