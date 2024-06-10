<?php
include("conn.php");
if(!$_SESSION['id']){
?>
<script>
window.location.href = "index.php";
</script>
<?php
}
?>
<!DOCTYPE html>

<html>

<head>
    <title>Task Manager</title>
    <link rel="icon" href="https://multireach.in/wp-content/themes/digicable/images/favicon.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="./assets/style.css">
    <link rel="stylesheet" href="./assets/style1.css">
    <link rel="stylesheet" href="./assets/style2.css">
    <!-- <link rel="stylesheet" href="./assets/style3.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/css/pikaday.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <?php date_default_timezone_set('Asia/Kolkata'); ?>
    <style>
    .abc {
        display: none !important;
    }

    .bcd {
        display: block !important;
    }

    .find {
        display: block !important;
    }

    .menu {
        display: block !important;
    }

    .p-search {
        display: none !important;
    }

    .modal-backdrop {
        width: unset;
    }

    <?php if($_SESSION['role']=='admin') {
        ?>@media screen and (max-width:1150px) {
            .bcd {
                display: none !important;
            }

            .menu {
                display: none !important;
            }

            .find {
                display: none !important;
            }

            .abc {
                display: block !important;
            }

            .p-search {
                display: block !important;
            }
        }

        <?php
    }

    else {
        ?>@media screen and (max-width:900px) {
            .bcd {
                display: none !important;
            }

            .menu {
                display: none !important;
            }

            .find {
                display: none !important;
            }

            .abc {
                display: block !important;
            }

            .p-search {
                display: block !important;
            }
        }

        <?php
    }

    ?>
    </style>
</head>

<body class="m-2" style="background-image: url(./assets/images/backgrounds/back-ground.jpg);">
    <div class="sticky">
        <nav class="navbar navbar-dark" style="background: #0C2D57 !important; border-radius: 10px 10px 0 0;">
            <div class="container-fluid text-center">
                <div class="p-search pe-3">
                    <a data-bs-toggle="collapse" style="text-decoration: none;" href="#search_from" role="button"
                        aria-expanded="false" aria-controls="collapseExample">
                        <img src="assets/images/logos/icons8-search-64.png" style="width:40px; height: 40px;">
                    </a>
                </div>
                <div class="zoom">
                    <a class="ms-3" style="text-decoration:none" href="dashboard.php">
                        <img src="assets/images/logos/mrmpl_b_logo.png" class="navbar-brand img-fluid"
                            style="width:140px; height: 52.29px;">
                    </a>
                </div>
                <div class="find" style="width: 400px;">
                    <form id="search_emp_form" style="margin-block-end: 0em!important;">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="submit" class="btn btn-search pr-1 search">
                                    <i style="font-size:24px" class="fa">&#xf002;</i>
                                </button>
                            </div>
                            <input type="text" name="assign_search_text" placeholder="Search by Team Member Name"
                                class="form-control" id="assign_search_text" autocomplete="off">
                        </div>
                    </form>
                </div>
                <div>
                    <div class="btn-group dropstart bcd">
                        <div class="profile-detail me-3 dropdown-toggle manage"
                            style="text-decoration:none; background: transparent;border: transparent;"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span>
                                <?php if($_SESSION['role']=='admin') {
                            $sqlname="SELECT
                            SUBSTRING_INDEX(`admin_name`, ' ', 1) AS `admin_fname`,
                            SUBSTRING_INDEX(`admin_name`, ' ', -1) AS `admin_lname`, pimage
                            FROM reg WHERE admin_id='{$_SESSION['id']}'";
                            $queryname=mysqli_query($conn,$sqlname);
                            $fetchname=mysqli_fetch_array($queryname);
                            ?>
                                <?php if($fetchname['pimage']==null) {?>
                                <img src="https://tasktracker.in/app/upload/noimage.jpg" class="avatar-img blob">
                                <?php } else { ?>
                                <img src="<?php echo "uploads/".$fetchname['pimage']; ?>" class="avatar-img blob">
                                <?php } ?>
                                <strong class="text-white"><?php echo $fetchname['admin_fname']; ?></strong>
                                <?php } ?>
                                <?php if($_SESSION['role']=='manager') {
                            $sqlname="SELECT
                            SUBSTRING_INDEX(`manager_name`, ' ', 1) AS `manager_fname`,
                            SUBSTRING_INDEX(`manager_name`, ' ', -1) AS `manager_lname`, manager_pimage
                            FROM manager WHERE manager_id='{$_SESSION['id']}'";
                            $queryname=mysqli_query($conn,$sqlname);
                            $fetchname=mysqli_fetch_array($queryname);
                            ?>
                                <?php if($fetchname['manager_pimage']==null) {?>
                                <img src="https://tasktracker.in/app/upload/noimage.jpg" class="avatar-img blob">
                                <?php } else { ?>
                                <img src="<?php echo "uploads/".$fetchname['manager_pimage']; ?>"
                                    class="avatar-img blob">
                                <?php } ?>
                                <strong class="text-white"><?php echo $fetchname['manager_fname']; ?></strong>
                                <?php } ?>
                                <?php if($_SESSION['role']=='assistant') {
                            $sqlname="SELECT
                            SUBSTRING_INDEX(`assistant_name`, ' ', 1) AS `assistant_fname`,
                            SUBSTRING_INDEX(`assistant_name`, ' ', -1) AS `assistant_lname`, assistant_pimage
                            FROM assistant WHERE assistant_id='{$_SESSION['id']}'";
                            $queryname=mysqli_query($conn,$sqlname);
                            $fetchname=mysqli_fetch_array($queryname);
                            ?>
                                <?php if($fetchname['assistant_pimage']==null) {?>
                                <img src="https://tasktracker.in/app/upload/noimage.jpg" class="avatar-img blob">
                                <?php } else { ?>
                                <img src="<?php echo "uploads/".$fetchname['assistant_pimage']; ?>"
                                    class="avatar-img blob">
                                <?php } ?>
                                <strong class="text-white"><?php echo $fetchname['assistant_fname']; ?></strong>
                                <?php } ?>
                                <?php if($_SESSION['role']=='employee') {
                            $sqlname="SELECT
                            SUBSTRING_INDEX(`employee_name`, ' ', 1) AS `employee_fname`,
                            SUBSTRING_INDEX(`employee_name`, ' ', -1) AS `employee_lname`, employee_pimage
                            FROM employee WHERE employee_id='{$_SESSION['id']}'";
                            $queryname=mysqli_query($conn,$sqlname);
                            $fetchname=mysqli_fetch_array($queryname);
                            ?>
                                <?php if($fetchname['employee_pimage']==null) {?>
                                <img src="https://tasktracker.in/app/upload/noimage.jpg" class="avatar-img blob">
                                <?php } else { ?>
                                <img src="<?php echo "uploads/".$fetchname['employee_pimage']; ?>"
                                    class="avatar-img blob">
                                <?php } ?>
                                <strong class="text-white"><?php echo $fetchname['employee_fname']; ?></strong>
                                <?php } ?>
                            </span>
                        </div>
                        <ul class="dropdown-menu" style="background-color: #ffc2c2;">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-sm ms-3">
                                        <?php if($_SESSION['role']=='admin') {
                                    if($fetchname['pimage']==null) {?>
                                        <img src="https://tasktracker.in/app/upload/noimage.jpg"
                                            class="avatar-img blob">
                                        <?php } else { ?>
                                        <img src="<?php echo "uploads/".$fetchname['pimage']; ?>"
                                            class="avatar-img blob zoom">
                                        <?php } } ?>
                                        <?php if($_SESSION['role']=='manager') {
                                    if($fetchname['manager_pimage']==null) {?>
                                        <img src="https://tasktracker.in/app/upload/noimage.jpg"
                                            class="avatar-img blob">
                                        <?php } else { ?>
                                        <img src="<?php echo "uploads/".$fetchname['manager_pimage']; ?>"
                                            class="avatar-img blob zoom">
                                        <?php } } ?>
                                        <?php if($_SESSION['role']=='assistant') {
                                    if($fetchname['assistant_pimage']==null) {?>
                                        <img src="https://tasktracker.in/app/upload/noimage.jpg"
                                            class="avatar-img blob">
                                        <?php } else { ?>
                                        <img src="<?php echo "uploads/".$fetchname['assistant_pimage']; ?>"
                                            class="avatar-img blob zoom">
                                        <?php } } ?>
                                        <?php if($_SESSION['role']=='employee') {
                                    if($fetchname['employee_pimage']==null) {?>
                                        <img src="https://tasktracker.in/app/upload/noimage.jpg"
                                            class="avatar-img blob">
                                        <?php } else { ?>
                                        <img src="<?php echo "uploads/".$fetchname['employee_pimage']; ?>"
                                            class="avatar-img blob zoom">
                                        <?php } } ?>
                                    </div>
                                    <div class="u-text me-3">
                                        <h4><?php echo $_SESSION['name']; ?></h4>
                                        <p class="text-muted"><?php echo $_SESSION['email']; ?></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" style="text-decoration: none;" href="myprofile.php">My
                                    Profile</a>
                                <a class="dropdown-item" style="text-decoration: none;" href="password.php">Change
                                    Password</a>
                                <a class="dropdown-item" style="text-decoration: none;" href="logout.php">Logout</a>
                            </li>
                        </ul>
                    </div>
                    <div class="toggle abc">
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="offcanvas offcanvas-bottom m-2" Style="border-radius: 20px;" tabindex="-1"
                            id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
                            <div class="offcanvas-header"
                                style="background: rgb(2, 28, 59) !important;border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                <span style="color: white;">MENU</span>
                                <div class="btn-group">
                                    <div class="profile-detail dropdown-toggle manage"
                                        style="text-decoration:none; background: transparent;border: transparent;"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span>
                                            <?php if($_SESSION['role']=='admin') {
                                        if($fetchname['pimage']==null) { ?>
                                            <img src="https://tasktracker.in/app/upload/noimage.jpg"
                                                class="avatar-img blob">
                                            <?php } else { ?>
                                            <img src="<?php echo "uploads/".$fetchname['pimage']; ?>"
                                                class="avatar-img blob">
                                            <?php } ?>
                                            <strong class="text-white"><?php echo $fetchname['admin_fname']; ?></strong>
                                            <?php } ?>
                                            <?php if($_SESSION['role']=='manager') {
                                        if($fetchname['manager_pimage']==null) {?>
                                            <img src="https://tasktracker.in/app/upload/noimage.jpg"
                                                class="avatar-img blob">
                                            <?php } else { ?>
                                            <img src="<?php echo "uploads/".$fetchname['manager_pimage']; ?>"
                                                class="avatar-img blob">
                                            <?php } ?>
                                            <strong
                                                class="text-white"><?php echo $fetchname['manager_fname']; ?></strong>
                                            <?php } ?>
                                            <?php if($_SESSION['role']=='assistant') {
                                        if($fetchname['assistant_pimage']==null) {?>
                                            <img src="https://tasktracker.in/app/upload/noimage.jpg"
                                                class="avatar-img blob">
                                            <?php } else { ?>
                                            <img src="<?php echo "uploads/".$fetchname['assistant_pimage']; ?>"
                                                class="avatar-img blob">
                                            <?php } ?>
                                            <strong
                                                class="text-white"><?php echo $fetchname['assistant_fname']; ?></strong>
                                            <?php } ?>
                                            <?php if($_SESSION['role']=='employee') {
                                        if($fetchname['employee_pimage']==null) {?>
                                            <img src="https://tasktracker.in/app/upload/noimage.jpg"
                                                class="avatar-img blob">
                                            <?php } else { ?>
                                            <img src="<?php echo "uploads/".$fetchname['employee_pimage']; ?>"
                                                class="avatar-img blob">
                                            <?php } ?>
                                            <strong
                                                class="text-white"><?php echo $fetchname['employee_fname']; ?></strong>
                                            <?php } ?>
                                        </span>
                                    </div>
                                    <ul class="dropdown-menu dropdown-menu-end" style="background-color: #ffc2c2;">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-sm ms-3">
                                                    <?php if($_SESSION['role']=='admin') {
                                                if($fetchname['pimage']==null) { ?>
                                                    <img src="https://tasktracker.in/app/upload/noimage.jpg"
                                                        class="avatar-img blob">
                                                    <?php } else { ?>
                                                    <img src="<?php echo "uploads/".$fetchname['pimage']; ?>"
                                                        class="avatar-img blob zoom">
                                                    <?php } ?>
                                                    <?php } ?>
                                                    <?php if($_SESSION['role']=='manager') {
                                                if($fetchname['manager_pimage']==null) {?>
                                                    <img src="https://tasktracker.in/app/upload/noimage.jpg"
                                                        class="avatar-img blob">
                                                    <?php } else { ?>
                                                    <img src="<?php echo "uploads/".$fetchname['manager_pimage']; ?>"
                                                        class="avatar-img blob zoom">
                                                    <?php } ?>
                                                    <?php } ?>
                                                    <?php if($_SESSION['role']=='assistant') {
                                                if($fetchname['assistant_pimage']==null) {?>
                                                    <img src="https://tasktracker.in/app/upload/noimage.jpg"
                                                        class="avatar-img blob">
                                                    <?php } else { ?>
                                                    <img src="<?php echo "uploads/".$fetchname['assistant_pimage']; ?>"
                                                        class="avatar-img blob zoom">
                                                    <?php } ?>
                                                    <?php } ?>
                                                    <?php if($_SESSION['role']=='employee') {
                                                if($fetchname['employee_pimage']==null) {?>
                                                    <img src="https://tasktracker.in/app/upload/noimage.jpg"
                                                        class="avatar-img blob">
                                                    <?php } else { ?>
                                                    <img src="<?php echo "uploads/".$fetchname['employee_pimage']; ?>"
                                                        class="avatar-img blob zoom">
                                                    <?php } ?>
                                                    <?php } ?>
                                                </div>
                                                <div class="u-text me-3">
                                                    <h4><?php echo $_SESSION['name']; ?></h4>
                                                    <p class="text-muted"><?php echo $_SESSION['email']; ?></p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" style="text-decoration: none;"
                                                href="myprofile.php">My
                                                Profile</a>
                                            <a class="dropdown-item" style="text-decoration: none;"
                                                href="password.php">Change
                                                Password</a>
                                            <a class="dropdown-item" style="text-decoration: none;"
                                                href="logout.php">Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="offcanvas-body">
                                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                    <?php if($_SESSION['role']=='admin') { ?>
                                    <li class="nav-item">
                                        <a class="naLink" style="text-decoration:none" data-bs-toggle="modal"
                                            data-bs-target="#maddteammember">
                                            <img src="https://tasktracker.in/app/assets/img/icons/addteammember.png"
                                                class="image">
                                            <span class="menu-title">Add Team Member</span>
                                        </a>
                                    </li>
                                    <hr>
                                    <?php } ?>
                                    <?php if($_SESSION['role']=='admin') { ?>
                                    <li class="nav-item">
                                        <a class="naLink" style="text-decoration:none" data-bs-toggle="modal"
                                            data-bs-target="#addbucket">
                                            <img src="https://tasktracker.in/app/assets/img/icons/AddBucketIcon.svg"
                                                class="add_task image">
                                            <span class="menu-title add_task_title">Add Bucket</span>
                                        </a>
                                    </li>
                                    <hr>
                                    <?php } ?>
                                    <li class="nav-item">
                                        <a class="naLink" style="text-decoration:none" data-bs-toggle="modal"
                                            data-bs-target="#addtask">
                                            <img src="https://tasktracker.in/app/assets/img/icons/addtasknew.png"
                                                class="add_task image">
                                            <span class="menu-title add_task_title">Add Task</span>
                                        </a>
                                    </li>
                                    <hr>
                                    <li class="nav-item">
                                        <a class="naLink" style="text-decoration:none;" data-bs-toggle="modal"
                                            data-bs-target="#attendance">
                                            <img src="https://tasktracker.in/app/assets/img/icons/attendancenew.png"
                                                class="image">
                                            <span class="menu-title">Attendance</span>
                                        </a>
                                    </li>
                                    <hr>
                                    <?php if($_SESSION['role']!='employee') {?>
                                    <li class="nav-item">
                                        <a class="naLink" style="text-decoration:none;" data-bs-toggle="modal"
                                            data-bs-target="#manage">
                                            <img src="https://tasktracker.in/app/assets/img/icons/managenew.svg"
                                                class="image">
                                            <span class="menu-title">Manage</span>
                                        </a>
                                    </li>
                                    <hr>
                                    <?php } ?>
                                    <?php if($_SESSION['role']!='employee') { ?>
                                    <li class="nav-item">
                                        <a class="naLink" style="text-decoration:none;" data-bs-toggle="modal"
                                            data-bs-target="#settings">
                                            <img src="https://tasktracker.in/app/assets/img/icons/settings.png"
                                                class="image">
                                            <span class="menu-title">Settings</span>
                                        </a>
                                    </li>
                                    <hr>
                                    <?php } ?>
                                    <li class="nav-item">
                                        <a class="naLink" style="text-decoration:none;" data-bs-toggle="modal"
                                            data-bs-target="#onboarding">
                                            <img src="assets/images/logos/icons8-submit-document-64.png" class="image">
                                            <span class="menu-title">BroadBand Onboarding</span>
                                        </a>
                                    </li>
                                    <hr>
                                    <li class="nav-item">
                                        <a class="naLink" style="text-decoration:none;" data-bs-toggle="modal"
                                            data-bs-target="#issue">
                                            <img src="assets/images/logos/icons8-issue-58.png" class="image">
                                            <span class="menu-title">Daily Issue Report</span>
                                        </a>
                                    </li>
                                    <hr>
                                    <li class="nav-item">
                                        <a class="naLink" style="text-decoration:none;" href="dashboard.php">
                                            <img src="https://tasktracker.in/app/assets/img/icons/dashboard.svg"
                                                class="image">
                                            <span class="menu-title">Dashboard</span>
                                        </a>
                                    </li>
                                    <?php if($_SESSION['role']=='admin') { ?>
                                    <hr>
                                    <li class="nav-item">
                                        <a class="naLink" style="text-decoration:none;" data-bs-toggle="modal"
                                            data-bs-target="#comp">
                                            <img src="assets/images/logos/icons8-create-64.png" class="image">
                                            <span class="menu-title">Company Management</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <form id="search_from" class="collapse p-2"
            style="background: #0C2D57 !important; border-radius: 0 0 10px 10px;">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pr-1 search">
                        <i style="font: size 24px;" class="fa">&#xf002;</i>
                    </button>
                </div>
                <input type="text" name="assign_search_text" id="assign_text" placeholder="Search by Team Member Name"
                    class="form-control" autocomplete="off">
            </div>
        </form>
        <div class="menu mb-2" style="border-radius: 0 0 10px 10px;">
            <ul style="display: flex; justify-content: space-between;">
                <li class="mt-2"
                    style="display: flex; align-items: center;justify-content: center; column-gap: 40px; margin-left: 1rem;">
                    <?php if($_SESSION['role']=='admin') { ?>
                    <a class="naLink zoom" style="text-decoration:none" data-bs-toggle="modal"
                        data-title="Add Team Member" data-bs-target="#maddteammember">
                        <img src="https://tasktracker.in/app/assets/img/icons/addteammember.png" class="image">
                    </a>
                    <?php } ?>
                    <?php if($_SESSION['role']=='admin') { ?>
                    <a class="naLink zoom" style="text-decoration:none" data-bs-toggle="modal" data-title="Add Bucket"
                        data-bs-target="#addbucket">
                        <img src="https://tasktracker.in/app/assets/img/icons/AddBucketIcon.svg" class="add_task image">
                    </a>
                    <?php } ?>
                    <a class="naLink zoom" style="text-decoration:none" data-bs-toggle="modal" data-title="Add Task"
                        data-bs-target="#addtask">
                        <img src="https://tasktracker.in/app/assets/img/icons/addtasknew.png" class="add_task image">
                    </a>
                    <div class="dropdown">
                        <a class="naLink zoom dropdown-toggle p-0 manage" data-title="Attendance"
                            style="text-decoration:none; background: transparent;border: transparent;"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://tasktracker.in/app/assets/img/icons/attendancenew.png" class="image">
                        </a>
                        <ul class="dropdown-menu" style="background-color: #ffc2c2;">
                            <?php if($_SESSION['role']!='admin') { ?>
                            <li><a class="dropdown-item" style="text-decoration: none;" href="attendance.php"><strong>My
                                        Attendance</strong></a></li><?php } ?>
                            <?php if($_SESSION['role']!='employee') { ?>
                            <li><a class="dropdown-item" style="text-decoration: none;"
                                    href="team_attendance.php"><strong>Team
                                        Attendance</strong></a></li><?php } ?>
                            <?php if($_SESSION['role']!='admin') { ?>
                            <li><a class="dropdown-item" style="text-decoration: none;" href="myleave.php"><strong>My
                                        Leaves</strong></a></li><?php } ?>
                            <?php if($_SESSION['role']!='employee') { ?>
                            <li><a class="dropdown-item" style="text-decoration: none;"
                                    href="team_leaves.php"><strong>Team
                                        Leaves</strong></a></li><?php } ?>
                        </ul>
                    </div>
                    <?php if($_SESSION['role']!='employee') { ?>
                    <div class="dropdown">
                        <a class="naLink zoom dropdown-toggle p-0 manage" data-title="Manage"
                            style="text-decoration:none; background: transparent;border: transparent;"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://tasktracker.in/app/assets/img/icons/managenew.svg" class="image">
                        </a>
                        <ul class="dropdown-menu" style="background-color: #ffc2c2;">
                            <li><a class="dropdown-item" style="text-decoration: none;"
                                    href="team_member.php"><strong>Team
                                        Member</strong></a></li>
                            <li><a class="dropdown-item" style="text-decoration: none;"
                                    href="team.php"><strong>Team</strong></a></li>
                            <?php if($_SESSION['role']=='admin') { ?>
                            <li><a class="dropdown-item" style="text-decoration: none;"
                                    href="bucket.php"><strong>Bucket</strong></a></li>
                            <?php } ?>
                            <li><a class="dropdown-item" style="text-decoration: none;"
                                    href="task_list.php"><strong>Tasks</strong></a></li>
                        </ul>
                    </div>
                    <?php } ?>
                    <?php if($_SESSION['role']!='employee') { ?>
                    <div class="dropdown">
                        <a class="naLink zoom dropdown-toggle p-0 manage" data-title="Settings"
                            style="text-decoration:none; background: transparent;border: transparent;"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://tasktracker.in/app/assets/img/icons/settings.png" class="image">
                        </a>
                        <ul class="dropdown-menu" style="background-color: #ffc2c2;">
                            <?php if($_SESSION['role']=='manager' || $_SESSION['role']=='assistant') { ?>
                            <li><a class="dropdown-item isDisabled" style="text-decoration: none;"
                                    href="#!"><strong>Holiday
                                        List</strong></a></li>
                            <?php } ?>
                            <?php if($_SESSION['role']=='admin') { ?>
                            <li><a class="dropdown-item" style="text-decoration: none;"
                                    href="holidaylist.php"><strong>Holiday
                                        List</strong></a></li>
                            <?php } ?>
                            <li><a class="dropdown-item" style="text-decoration: none;" href="leave.php"><strong>Leave
                                        Notification</strong></a></li>
                        </ul>
                    </div>
                    <?php } ?>
                    <div class="dropdown">
                        <a class="naLink zoom dropdown-toggle p-0 manage" data-title="BroadBand Onboarding"
                            style="text-decoration:none; background: transparent;border: transparent;"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/images/logos/icons8-submit-document-64.png" class="image">
                        </a>
                        <ul class="dropdown-menu" style="background-color: #ffc2c2;">
                            <?php if($_SESSION['role']=='employee') { ?>
                            <li><a class="dropdown-item" style="text-decoration: none;"
                                    href="application.php"><strong>Submit
                                        Application</strong></a></li>
                            <?php } else { ?>
                            <li><a class="dropdown-item isDisabled" style="text-decoration: none;"
                                    href="#!"><strong>Submit
                                        Application</strong></a></li>
                            <?php } ?>
                            <?php if($_SESSION['role']!='employee') { ?>
                            <li><a class="dropdown-item" style="text-decoration: none;"
                                    href="broadband_application.php"><strong>Broadband
                                        Application List</strong></a></li>
                            <?php } else { ?>
                            <li><a class="dropdown-item isDisabled" style="text-decoration: none;"
                                    href="#!"><strong>Broadband Application List</strong></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a class="naLink zoom dropdown-toggle p-0 manage" data-title="Daily Issue Report"
                            style="text-decoration:none; background: transparent;border: transparent;"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/images/logos/icons8-issue-58.png" class="image">
                        </a>
                        <ul class="dropdown-menu" style="background-color: #ffc2c2;">
                            <?php if($_SESSION['role']=='employee') { ?>
                            <li><a class="dropdown-item" style="text-decoration: none;" href="issues.php"><strong>Submit
                                        Report</strong></a></li>
                            <?php } else { ?>
                            <li><a class="dropdown-item isDisabled" style="text-decoration: none;"
                                    href="#!"><strong>Submit
                                        Report</strong></a></li>
                            <?php } ?>
                            <?php if($_SESSION['role']!='employee') { ?>
                            <li><a class="dropdown-item" style="text-decoration: none;"
                                    href="issue_report.php"><strong>Team
                                        Report</strong></a></li>
                            <?php } else { ?>
                            <li><a class="dropdown-item isDisabled" style="text-decoration: none;"
                                    href="#!"><strong>Team
                                        Report</strong></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
                <li class="mt-2 me-5"
                    style="display: flex; align-items: center;justify-content: center;column-gap: 40px;">
                    <a class="naLink zoom" style="text-decoration:none" href="dashboard.php" data-title="Dashboard">
                        <img src="https://tasktracker.in/app/assets/img/icons/dashboard.svg" class="image">
                    </a>
                    <?php if($_SESSION['role']=='admin') { ?>
                    <!-- <a class="naLink me-3" style="text-decoration:none" href="administrator_access.php">
                    <img src="assets/images/logos/icons8-locked-user-48.png" class="image">
                    <span class="menu-title">Administrator Access</span>
                </a> -->
                    <div class="dropdown">
                        <a class="naLink zoom dropdown-toggle p-0 manage" data-title="Company Management"
                            style="text-decoration:none; background: transparent;border: transparent;"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/images/logos/icons8-create-64.png" class="image">
                        </a>
                        <ul class="dropdown-menu" style="background-color: #ffc2c2;">
                            <li>
                                <a class="naLink" style="text-decoration:none;" data-bs-toggle="modal"
                                    data-bs-target="#creatcompany">
                                    <span class="menu-title"><strong style="font-size: 15px;">Create
                                            Company</strong></span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" style="text-decoration: none;"
                                    href="company_management.php"><strong>Company Under
                                        Management</strong></a>
                            </li>
                        </ul>
                    </div>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </div>
    <?php include("add_team.php"); ?>
    <?php include("add_bucket.php"); ?>
    <?php include("add_task.php"); ?>
    <?php include("create_company.php"); ?>
    <?php include("modal_content.php"); ?>
</body>

</html>