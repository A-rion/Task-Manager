<?php
include("conn.php");
?>
<?php
if(isset($_POST['reset'])){
    $uemail=$_POST['email'];
    $newpassword=password_hash($_POST['new_password'],PASSWORD_BCRYPT);
    $cpassword=$_POST['c_password'];
    if(password_verify($cpassword,$newpassword)){
      $sqlr="UPDATE `reg` SET `password`='{$newpassword}' WHERE `email`='{$uemail}'";
      $out=mysqli_query($conn,$sqlr);
      $sqlr1="UPDATE `manager` SET `password`='{$newpassword}' WHERE `email`='{$uemail}' AND `manager_status`='1'";
      $out1=mysqli_query($conn,$sqlr1);
      $sqlr2="UPDATE `assistant` SET `password`='{$newpassword}' WHERE `email`='{$uemail}' AND `assistant_status`='1'";
      $out2=mysqli_query($conn,$sqlr2);
      $sqlr3="UPDATE `employee` SET `password`='{$newpassword}' WHERE `email`='{$uemail}' AND `employee_status`='1'";
      $out3=mysqli_query($conn,$sqlr3);
    ?>
<script>
alert("Your Password has been Updated!.");
window.location.href = "index.php";
</script>
<?php
      } else {
    ?>
<script>
alert("Check Your Password!.");
</script>
<?php
      }
  }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MRMPL</title>
    <link rel="shortcut icon" href="https://multireach.in/wp-content/themes/digicable/images/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-4 col-xxl-3">
                        <div class="card mb-0" style="background: #cedbe4;">
                            <div class="card-body">
                                <a class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="assets/images/logos/mrmpl_b_logo.png" width="100" alt="">
                                </a>
                                <p class="text-center">Task Manager</p>
                                <form method="post">
                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Email</label>
                                            <input type="email" name="email" placeholder="example@example.com"
                                                class="form-control" id="email" style="background: white;"
                                                aria-describedby="emailHelp">
                                        </div>
                                        <div class="mb-4 col-md-6">
                                            <label for="exampleInputPassword1" class="form-label">New Password</label>
                                            <input type="password" name="new_password" style="background: white;"
                                                placeholder="******" class="form-control" id="password">
                                        </div>
                                        <div class="mb-4 col-md-6">
                                            <label for="exampleInputPassword1" class="form-label">Confirm
                                                Password</label>
                                            <input type="password" name="c_password" style="background: white;"
                                                placeholder="******" class="form-control" id="cpassword">
                                        </div>
                                        <input type="submit" name="reset"
                                            class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2"
                                            value="Reset Password">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a class="text-primary fw-bold ms-2" href="index.php">Go Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>