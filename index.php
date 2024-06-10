<?php session_start();
include("conn.php");
function authenticateUser($row, $role, $password) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['id'] = $row[$role . '_id'];
        $_SESSION['assign'] = $row['assign_id'];
        $_SESSION['role'] = $role;
        $_SESSION['name'] = $row[$role . '_name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['phone'] = $row['phone'];
        $_SESSION['company'] = $row['company_id'];
?>
<script>window.location.href = "dashboard.php";</script>
<?php
    } else {
?>
<script>
    alert("Username and/or Password is Incorrect.");
    window.location.href = "index.php";
</script>
<?php
    }
}
?>
<?php
if(isset($_POST['signin'])){
  $email=trim($_POST['email']);
  $password=trim($_POST['passwoxx']);
  $sqlc = "SELECT * FROM employee WHERE email='{$email}' AND employee_status='1'";
    $query = mysqli_query($conn, $sqlc);
    $count = mysqli_num_rows($query);

    $sqlc1 = "SELECT * FROM assistant WHERE email='{$email}' AND assistant_status='1'";
    $query1 = mysqli_query($conn, $sqlc1);
    $count1 = mysqli_num_rows($query1);

    $sqlc2 = "SELECT * FROM manager WHERE email='{$email}' AND manager_status='1'";
    $query2 = mysqli_query($conn, $sqlc2);
    $count2 = mysqli_num_rows($query2);

    $sqlc3 = "SELECT * FROM reg WHERE email='{$email}'";
    $query3 = mysqli_query($conn, $sqlc3);
    $count3 = mysqli_num_rows($query3);

    if ($count > 0) {
        $row = mysqli_fetch_assoc($query);
        authenticateUser($row, 'employee', $password);
    } else if ($count1 > 0) {
        $row1 = mysqli_fetch_assoc($query1);
        authenticateUser($row1, 'assistant', $password);
    } else if ($count2 > 0) {
        $row2 = mysqli_fetch_assoc($query2);
        authenticateUser($row2, 'manager', $password);
    } else if ($count3 > 0) {
        $row3 = mysqli_fetch_assoc($query3);
        authenticateUser($row3, 'admin', $password);
    } else {
?>
<script>   
    alert("Username and/or Password is Incorrect.");
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
    <link rel="shortcut icon" type="image/png" href="https://multireach.in/wp-content/themes/digicable/images/favicon.png" />
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
                                                aria-describedby="emailHelp" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="passwoxx" placeholder="******"
                                                class="form-control" id="password" style="background: white;" required>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input primary" type="checkbox" value=""
                                                    id="flexCheckChecked" checked>
                                                <label class="form-check-label text-dark" for="flexCheckChecked">
                                                    Remeber this Device
                                                </label>
                                            </div>
                                            <a class="text-primary fw-bold" href="forgot.php">Forgot Password ?</a>
                                        </div>
                                        <input type="submit" name="signin"
                                            class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" value="Sign In">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <p class="fs-4 mb-0 fw-bold">Don't have an Account?</p>
                                            <a class="text-primary fw-bold ms-2" href="register.php">Sign Up</a>
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