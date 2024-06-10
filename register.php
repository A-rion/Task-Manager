<?php
include("conn.php");
?>
<?php
if(isset($_POST['signup'])){
  $phone=$_POST['phone'];
  $fname=$_POST['fname'];
  $email=$_POST['email'];
  $password=password_hash($_POST['password'],PASSWORD_BCRYPT);
  $checkEmailQuery = "SELECT email FROM reg WHERE email = '{$email}'
  UNION
  SELECT email FROM manager WHERE email = '{$email}' AND manager_status='1'
  UNION
  SELECT email FROM assistant WHERE email = '{$email}' AND assistant_status='1'
  UNION
  SELECT email FROM employee WHERE email = '{$email}' AND employee_status='1'";
  $check=mysqli_query($conn,$checkEmailQuery);
  $result=mysqli_num_rows($check);
  if($result>0) {
    ?>
      <script type="text/javascript">
      alert("Email is Already in Use.");
      window.location.href = "register.php";
      </script>
      <?php
  } else {
  $sql="INSERT INTO `reg` (`phone`,`admin_name`,`email`,`password`) VALUES ('{$phone}','{$fname}','{$email}','{$password}')";
  $query=mysqli_query($conn,$sql);
  $last_id=mysqli_insert_id($conn);
  $assign_id="admin_".$last_id;
  $sql1="UPDATE reg SET `assign_id`='{$assign_id}'
  WHERE `admin_id`='{$last_id}'";
  $query1=mysqli_query($conn,$sql1);
  ?>
<script type="text/javascript">
window.location.href = "index.php";
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
                                    <div class="mb-3">
                                        <label for="exampleInputtext1" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="fname" name="fname"
                                            aria-describedby="textHelp" style="background: white;" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            aria-describedby="emailHelp" style="background: white;"
                                            placeholder="example@example.com" required>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="exampleInputtext1" class="form-label">Phone No.</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                aria-describedby="textHelp" style="background: white;" required>
                                        </div>
                                        <div class="mb-4 col-md-6">
                                            <label for="exampleInputPassword1" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                style="background: white;" placeholder="********" required>
                                        </div>
                                    </div>
                                    <input type="submit" name="signup"
                                        class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" value="Signup">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                                        <a class="text-primary fw-bold ms-2" href="index.php">Sign In</a>
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