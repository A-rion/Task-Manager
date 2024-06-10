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
$closeid=$_REQUEST['closeid'];
if($closeid){
  $close_date=date('d-M-y');
  $sqlclose="UPDATE `task` SET `status`='close', close_by='{$_SESSION['assign']}', close_date='{$close_date}' WHERE `task_id`='{$closeid}'";
  $queryclose=mysqli_query($conn,$sqlclose);
  ?>
<script>
window.history.replaceState({}, document.title, window.location.pathname);
</script>
<?php
  }
?>
<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">Task List</h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <nav class="navbar navbar-light bg-light smooth mb-3">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" id="taskXsearch" name="task_search"
                        placeholder="Search By Name" aria-label="Search">
                    <button class="btn btn-outline-success">Clear</button>
                </form>
            </div>
        </nav>
        <form>
            <div class="table-responsive smooth p-2" style="background-color: beige;">
                <table id="taskTable" class="table table-striped-columns smooth cus-td p-2">
                    <thead>
                        <tr class="cus-td">
                            <th style="font-size: 12px;">Task Summery</th>
                            <th style="font-size: 12px;">Bucket</th>
                            <th style="min-width: 100px; font-size: 12px;">Assign Date</th>
                            <th style="min-width: 100px; font-size: 12px;">Due Date</th>
                            <th style="font-size: 12px;">Status</th>
                            <th style="font-size: 12px;">Priority</th>
                            <th style="font-size: 12px;">Assigned To</th>
                            <th style="font-size: 12px;">Task Health</th>
                            <th style="font-size: 12px;">Document</th>
                            <th style="font-size: 12px;">Action</th>
                            <th style="font-size: 12px;">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($_SESSION['role']=='assistant') {
                            $sqltask="SELECT 
                            task.*, 
                            employee.employee_name, 
                            close_employee.employee_name AS close_employee,
                            close_assistant.assistant_name AS close_assistant,
                            close_manager.manager_name AS close_manager,
                            close_admin.admin_name AS close_admin,
                            bucket.bucket_name
                            FROM 
                            task
                            INNER JOIN 
                            bucket ON task.t_bucket = bucket.b_id
                            INNER JOIN 
                            assistant ON task.assign_by = assistant.assign_id 
                            INNER JOIN 
                            employee ON task.assign_to = employee.assign_id 
                            LEFT JOIN 
                            employee AS close_employee ON task.close_by = close_employee.assign_id
                            LEFT JOIN 
                            assistant AS close_assistant ON task.close_by = close_assistant.assign_id
                            LEFT JOIN 
                            manager AS close_manager ON task.close_by = close_manager.assign_id
                            LEFT JOIN 
                            reg AS close_admin ON task.close_by = close_admin.assign_id
                            WHERE 
                            employee.assistant_id = '{$_SESSION['id']}' ORDER BY task_id DESC";
                            $querytask=mysqli_query($conn,$sqltask);
                            $sqltask2="SELECT 
                            task.*, 
                            assistant.assistant_name, 
                            close_manager.manager_name AS close_manager,
                            close_assistant.assistant_name AS close_assistant,
                            close_admin.admin_name AS close_admin,
                            bucket.bucket_name
                            FROM 
                            task
                            INNER JOIN 
                            bucket ON task.t_bucket = bucket.b_id
                            INNER JOIN 
                            assistant ON task.assign_by = assistant.assign_id AND task.assign_to = assistant.assign_id
                            LEFT JOIN 
                            manager AS close_manager ON task.close_by = close_manager.assign_id
                            LEFT JOIN 
                            assistant AS close_assistant ON task.close_by = close_assistant.assign_id
                            LEFT JOIN 
                            reg AS close_admin ON task.close_by = close_admin.assign_id
                            WHERE 
                            assistant.assistant_id = '{$_SESSION['id']}' ORDER BY task_id DESC";
                            $querytask2=mysqli_query($conn,$sqltask2);
                            while($fetchtask2=mysqli_fetch_array($querytask2)) {
                            ?>
                        <tr>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['t_about']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['bucket_name']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['assign_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['due_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['status']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['t_priority']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['assistant_name']; ?>
                            </td>
                            <td style="font-size: 10px; text-align: center;">
                                <?php
                                $currentDate2 = new DateTime();
                                $dueDate2 = new DateTime($fetchtask2['due_date']);
                                if ($currentDate2 > $dueDate2 && $fetchtask2['status']=="open") {
                                    echo '<span class="fr"></span>';
                                } else {
                                    echo '<span class="fr5"></span>';
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo "./uploads/".$fetchtask2['t_file']; ?>" download><img
                                        src="assets/images/logos/icons8-download.gif" class="image"></a>
                            </td>
                            <td>
                                <?php if($fetchtask2['status']=='open') { ?>
                                <a href="task_list.php?closeid=<?php echo $fetchtask2['task_id']; ?>"
                                    onClick="return confirm(`Confirm to Close This Task.`)">
                                    <img src="./assets/images/logos/icons8-close.gif" class="image zoom">
                                </a>
                                <?php } else { ?>
                                <div class="tooltip">
                                    <a href="#!">
                                        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                    </a>
                                    <span class="tooltiptext">
                                        <h6>
                                            <?php echo $fetchtask2['close_admin']; ?>
                                            <?php echo $fetchtask2['close_manager']; ?>
                                            <?php echo $fetchtask2['close_assistant']; ?>
                                        </h6>
                                        <?php echo $fetchtask2['close_date']; ?>
                                    </span>
                                </div>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;">

                                <?php if($fetchtask2['status']!='close') { ?>
                                <a href="updatetask.php?edit_tid=<?php echo $fetchtask2['task_id']; ?>"><button
                                        type="button" class="btn btn-outline-success"
                                        style="font-size: 10px;">Edit</button></a>
                                <?php } else { ?>
                                <button type="button" class="btn btn-outline-success" style="font-size: 10px;"
                                    disabled>Edit</button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php while($fetchtask=mysqli_fetch_array($querytask)) {
                            ?>
                        <tr>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['t_about']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['bucket_name']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['assign_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['due_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['status']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['t_priority']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['employee_name']; ?>
                            </td>
                            <td style="font-size: 10px; text-align: center;">
                                <?php
                                $currentDate = new DateTime();
                                $dueDate = new DateTime($fetchtask['due_date']);
                                if ($currentDate > $dueDate && $fetchtask['status']=="open") {
                                    echo '<span class="fr"></span>';
                                } else {
                                    echo '<span class="fr5"></span>';
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo "./uploads/".$fetchtask['t_file']; ?>" download><img
                                        src="assets/images/logos/icons8-download.gif" class="image"></a>
                            </td>
                            <td>
                                <?php if($fetchtask['status']=='open') { ?>
                                <a href="task_list.php?closeid=<?php echo $fetchtask['task_id']; ?>"
                                    onClick="return confirm(`Confirm to Close This Task.`)">
                                    <img src="./assets/images/logos/icons8-close.gif" class="image zoom">
                                </a>
                                <?php } else { ?>
                                <div class="tooltip">
                                    <a href="#!">
                                        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                    </a>
                                    <span class="tooltiptext">
                                        <h6>
                                            <?php echo $fetchtask['close_admin']; ?>
                                            <?php echo $fetchtask['close_manager']; ?>
                                            <?php echo $fetchtask['close_assistant']; ?>
                                            <?php echo $fetchtask['close_employee']; ?>
                                        </h6>
                                        <?php echo $fetchtask['close_date']; ?>
                                    </span>
                                </div>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;">

                                <?php if($fetchtask['status']!='close') { ?> |
                                <a href="updatetask.php?edit_tid=<?php echo $fetchtask['task_id']; ?>"><button
                                        type="button" class="btn btn-outline-success"
                                        style="font-size: 10px;">Edit</button></a>
                                <?php } else { ?>
                                <button type="button" class="btn btn-outline-success" style="font-size: 10px;"
                                    disabled>Edit</button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } } ?>
                        <?php if($_SESSION['role']=='manager') {
                            $sqltask="SELECT 
                            task.*, 
                            employee.employee_name, 
                            close_employee.employee_name AS close_employee,
                            close_manager.manager_name AS close_manager,
                            close_assistant.assistant_name AS close_assistant,
                            close_admin.admin_name AS close_admin,
                            bucket.bucket_name
                            FROM 
                            task
                            INNER JOIN 
                            bucket ON task.t_bucket = bucket.b_id
                            INNER JOIN 
                            manager ON task.assign_by = manager.assign_id 
                            INNER JOIN 
                            employee ON task.assign_to = employee.assign_id 
                            INNER JOIN 
                            assistant ON employee.assistant_id = assistant.assistant_id
                            LEFT JOIN 
                            employee AS close_employee ON task.close_by = close_employee.assign_id
                            LEFT JOIN 
                            manager AS close_manager ON task.close_by = close_manager.assign_id
                            LEFT JOIN 
                            assistant AS close_assistant ON task.close_by = close_assistant.assistant_id
                            LEFT JOIN 
                            reg AS close_admin ON task.close_by = close_admin.assign_id
                            WHERE 
                            assistant.manager_id = '{$_SESSION['id']}' ORDER BY task_id DESC";
                            $querytask=mysqli_query($conn,$sqltask);
                            $sqltask1="SELECT 
                            task.*, 
                            assistant.assistant_name, 
                            close_manager.manager_name AS close_manager,
                            close_assistant.assistant_name AS close_assistant,
                            close_admin.admin_name AS close_admin,
                            bucket.bucket_name
                            FROM 
                            task
                            INNER JOIN 
                            bucket ON task.t_bucket = bucket.b_id
                            INNER JOIN 
                            manager ON task.assign_by = manager.assign_id 
                            INNER JOIN 
                            assistant ON task.assign_to = assistant.assign_id
                            LEFT JOIN 
                            manager AS close_manager ON task.close_by = close_manager.assign_id
                            LEFT JOIN 
                            assistant AS close_assistant ON task.close_by = close_assistant.assistant_id
                            LEFT JOIN 
                            reg AS close_admin ON task.close_by = close_admin.assign_id
                            WHERE 
                            assistant.manager_id = '{$_SESSION['id']}' ORDER BY task_id DESC";
                            $querytask1=mysqli_query($conn,$sqltask1);
                            $sqltask2="SELECT 
                            task.*, 
                            manager.manager_name, 
                            close_manager.manager_name AS close_manager,
                            close_admin.admin_name AS close_admin,
                            bucket.bucket_name
                            FROM 
                            task
                            INNER JOIN 
                            bucket ON task.t_bucket = bucket.b_id
                            INNER JOIN 
                            manager ON task.assign_by = manager.assign_id AND task.assign_to = manager.assign_id
                            LEFT JOIN 
                            manager AS close_manager ON task.close_by = close_manager.assign_id
                            LEFT JOIN 
                            reg AS close_admin ON task.close_by = close_admin.assign_id
                            WHERE 
                            manager.manager_id = '{$_SESSION['id']}' ORDER BY task_id DESC";
                            $querytask2=mysqli_query($conn,$sqltask2);
                            while($fetchtask2=mysqli_fetch_array($querytask2)) {
                            ?>
                        <tr>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['t_about']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['bucket_name']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['assign_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['due_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['status']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['t_priority']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['manager_name']; ?>
                            </td>
                            <td style="font-size: 10px; text-align: center;">
                                <?php
                                $currentDate2 = new DateTime();
                                $dueDate2 = new DateTime($fetchtask2['due_date']);
                                if ($currentDate2 > $dueDate2 && $fetchtask2['status']=="open") {
                                    echo '<span class="fr"></span>';
                                } else {
                                    echo '<span class="fr5"></span>';
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo "./uploads/".$fetchtask2['t_file']; ?>" download><img
                                        src="assets/images/logos/icons8-download.gif" class="image"></a>
                            </td>
                            <td>
                                <?php if($fetchtask2['status']=='open') { ?>
                                <a href="task_list.php?closeid=<?php echo $fetchtask2['task_id']; ?>"
                                    onClick="return confirm(`Confirm to Close This Task.`)">
                                    <img src="./assets/images/logos/icons8-close.gif" class="image zoom">
                                </a>
                                <?php } else { ?>
                                <div class="tooltip">
                                    <a href="#!">
                                        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                    </a>
                                    <span class="tooltiptext">
                                        <h6>
                                            <?php echo $fetchtask2['close_admin']; ?>
                                            <?php echo $fetchtask2['close_manager']; ?>
                                        </h6>
                                        <?php echo $fetchtask2['close_date']; ?>
                                    </span>
                                </div>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;">

                                <?php if($fetchtask2['status']!='close') { ?>
                                <a href="updatetask.php?edit_tid=<?php echo $fetchtask2['task_id']; ?>"><button
                                        type="button" class="btn btn-outline-success"
                                        style="font-size: 10px;">Edit</button></a>
                                <?php } else { ?>
                                <button type="button" class="btn btn-outline-success" style="font-size: 10px;"
                                    disabled>Edit</button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php while($fetchtask=mysqli_fetch_array($querytask)) {
                            ?>
                        <tr>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['t_about']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['bucket_name']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['assign_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['due_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['status']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['t_priority']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['employee_name']; ?>
                            </td>
                            <td style="font-size: 10px; text-align: center;">
                                <?php
                                $currentDate = new DateTime();
                                $dueDate = new DateTime($fetchtask['due_date']);
                                if ($currentDate > $dueDate && $fetchtask['status']=="open") {
                                    echo '<span class="fr"></span>';
                                } else {
                                    echo '<span class="fr5"></span>';
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo "./uploads/".$fetchtask['t_file']; ?>" download><img
                                        src="assets/images/logos/icons8-download.gif" class="image"></a>
                            </td>
                            <td>
                                <?php if($fetchtask['status']=='open') { ?>
                                <a href="task_list.php?closeid=<?php echo $fetchtask['task_id']; ?>"
                                    onClick="return confirm(`Confirm to Close This Task.`)">
                                    <img src="./assets/images/logos/icons8-close.gif" class="image zoom">
                                </a>
                                <?php } else { ?>
                                <div class="tooltip">
                                    <a href="#!">
                                        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                    </a>
                                    <span class="tooltiptext">
                                        <h6>
                                            <?php echo $fetchtask['close_admin']; ?>
                                            <?php echo $fetchtask['close_manager']; ?>
                                            <?php echo $fetchtask['close_assistant']; ?>
                                            <?php echo $fetchtask['close_employee']; ?>
                                        </h6>
                                        <?php echo $fetchtask['close_date']; ?>
                                    </span>
                                </div>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;">

                                <?php if($fetchtask['status']!='close') { ?>
                                <a href="updatetask.php?edit_tid=<?php echo $fetchtask['task_id']; ?>"><button
                                        type="button" class="btn btn-outline-success"
                                        style="font-size: 10px;">Edit</button></a>
                                <?php } else { ?>
                                <button type="button" class="btn btn-outline-success" style="font-size: 10px;"
                                    disabled>Edit</button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php while($fetchtask1=mysqli_fetch_array($querytask1)) { ?>
                        <tr>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask1['t_about']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask1['bucket_name']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask1['assign_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask1['due_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask1['status']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask1['t_priority']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask1['assistant_name']; ?>
                            </td>
                            <td style="font-size: 10px; text-align: center;">
                                <?php
                                $currentDate1 = new DateTime();
                                $dueDate1 = new DateTime($fetchtask1['due_date']);
                                if ($currentDate1 > $dueDate1 && $fetchtask1['status']=="open") {
                                    echo '<span class="fr"></span>';
                                } else {
                                    echo '<span class="fr5"></span>';
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo "./uploads/".$fetchtask1['t_file']; ?>" download><img
                                        src="assets/images/logos/icons8-download.gif" class="image"></a>
                            </td>
                            <td>
                                <?php if($fetchtask1['status']=='open') { ?>
                                <a href="task_list.php?closeid=<?php echo $fetchtask1['task_id']; ?>"
                                    onClick="return confirm(`Confirm to Close This Task.`)">
                                    <img src="./assets/images/logos/icons8-close.gif" class="image zoom">
                                </a>
                                <?php } else { ?>
                                <div class="tooltip">
                                    <a href="#!">
                                        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                    </a>
                                    <span class="tooltiptext">
                                        <h6>
                                            <?php echo $fetchtask1['close_admin']; ?>
                                            <?php echo $fetchtask1['close_manager']; ?>
                                            <?php echo $fetchtask1['close_assistant']; ?>
                                        </h6>
                                        <?php echo $fetchtask1['close_date']; ?>
                                    </span>
                                </div>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;">

                                <?php if($fetchtask1['status']!='close') { ?>
                                <a href="updatetask.php?edit_tid=<?php echo $fetchtask1['task_id']; ?>"><button
                                        type="button" class="btn btn-outline-success"
                                        style="font-size: 10px;">Edit</button></a>
                                <?php } else { ?>
                                <button type="button" class="btn btn-outline-success" style="font-size: 10px;"
                                    disabled>Edit</button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                        <?php if($_SESSION['role']=='admin') {
                            $sqltask="SELECT 
                            task.*, 
                            reg.admin_name, 
                            employee.employee_name, 
                            employee_close.employee_name AS close_employee, 
                            assistant_close.assistant_name AS close_assistant, 
                            manager_close.manager_name AS close_manager, 
                            reg_close.admin_name AS close_admin, 
                            bucket.bucket_name
                            FROM 
                            task
                            INNER JOIN 
                            bucket ON task.t_bucket = bucket.b_id 
                            LEFT JOIN 
                            employee AS employee_close ON task.close_by = employee_close.assign_id
                            LEFT JOIN 
                            assistant AS assistant_close ON task.close_by = assistant_close.assign_id
                            LEFT JOIN 
                            manager AS manager_close ON task.close_by = manager_close.assign_id
                            LEFT JOIN 
                            reg AS reg_close ON task.close_by = reg_close.assign_id
                            INNER JOIN 
                            employee ON task.assign_to = employee.assign_id
                            INNER JOIN 
                            reg ON task.assign_by = reg.assign_id 
                            INNER JOIN 
                            company_master ON employee.company_id = company_master.company_id
                            WHERE 
                            company_master.admin_id = '{$_SESSION['id']}' ORDER BY task_id DESC";
                            $querytask=mysqli_query($conn,$sqltask);
                            $sqltask1="SELECT 
                            task.*, 
                            assistant.assistant_name, 
                            reg.admin_name, 
                            bucket.bucket_name,
                            close_assistant.assistant_name AS close_assistant,
                            close_manager.manager_name AS close_manager,
                            close_admin.admin_name AS close_admin
                            FROM 
                            task
                            INNER JOIN 
                            bucket ON task.t_bucket = bucket.b_id
                            INNER JOIN 
                            reg ON task.assign_by = reg.assign_id 
                            INNER JOIN 
                            assistant ON task.assign_to = assistant.assign_id
                            LEFT JOIN 
                            assistant AS close_assistant ON task.close_by = close_assistant.assign_id
                            LEFT JOIN 
                            manager AS close_manager ON task.close_by = close_manager.assign_id
                            LEFT JOIN 
                            reg AS close_admin ON task.close_by = close_admin.assign_id
                            INNER JOIN 
                            company_master ON assistant.company_id = company_master.company_id
                            WHERE 
                            company_master.admin_id ='{$_SESSION['id']}' ORDER BY task_id DESC";
                            $querytask1=mysqli_query($conn,$sqltask1);
                            $sqltask2="SELECT 
                            task.*, 
                            manager.manager_name, 
                            reg.admin_name, 
                            bucket.bucket_name,
                            close_manager.manager_name AS close_manager,
                            close_admin.admin_name AS close_admin
                            FROM 
                            task
                            INNER JOIN 
                            bucket ON task.t_bucket = bucket.b_id
                            INNER JOIN 
                            reg ON task.assign_by = reg.assign_id 
                            INNER JOIN 
                            manager ON task.assign_to = manager.assign_id
                            LEFT JOIN 
                            manager AS close_manager ON task.close_by = close_manager.assign_id
                            LEFT JOIN 
                            reg AS close_admin ON task.close_by = close_admin.assign_id
                            INNER JOIN 
                            company_master ON manager.company_id = company_master.company_id
                            WHERE 
                            company_master.admin_id = '{$_SESSION['id']}' ORDER BY task_id DESC";
                            $querytask2=mysqli_query($conn,$sqltask2);
                            $sqltask3="SELECT 
                            task.*, 
                            reg.admin_name, 
                            close_admin.admin_name AS close_admin,
                            bucket.bucket_name
                            FROM 
                            task
                            INNER JOIN 
                            bucket ON task.t_bucket = bucket.b_id
                            INNER JOIN 
                            reg ON task.assign_by = reg.assign_id AND task.assign_to = reg.assign_id
                            LEFT JOIN 
                            reg AS close_admin ON task.close_by = close_admin.assign_id
                            WHERE 
                            reg.admin_id = '{$_SESSION['id']}' ORDER BY task_id DESC";
                            $querytask3=mysqli_query($conn,$sqltask3);
                            while($fetchtask3=mysqli_fetch_array($querytask3)) {
                            ?>
                        <tr>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask3['t_about']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask3['bucket_name']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask3['assign_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask3['due_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask3['status']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask3['t_priority']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask3['admin_name']; ?>
                            </td>
                            <td style="font-size: 10px; text-align: center;">
                                <?php
                                $currentDate3 = new DateTime();
                                $dueDate3 = new DateTime($fetchtask3['due_date']);
                                if ($currentDate3 > $dueDate3 && $fetchtask3['status']=="open") {
                                    echo '<span class="fr"></span>';
                                } else {
                                    echo '<span class="fr5"></span>';
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo "./uploads/".$fetchtask3['t_file']; ?>" download><img
                                        src="assets/images/logos/icons8-download.gif" class="image"></a>
                            </td>
                            <td>
                                <?php if($fetchtask3['status']=='open') { ?>
                                <a href="task_list.php?closeid=<?php echo $fetchtask3['task_id']; ?>"
                                    onClick="return confirm(`Confirm to Close This Task.`)">
                                    <img src="assets/images/logos/icons8-close.gif" class="image zoom">
                                </a>
                                <?php } else { ?>
                                <div class="tooltip"><a href="#!">
                                        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                    </a>
                                    <span class="tooltiptext">
                                        <h6>
                                            <?php echo $fetchtask3['close_admin']; ?>
                                        </h6>
                                        <?php echo $fetchtask3['close_date']; ?>
                                    </span>
                                </div>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;">

                                <?php if($fetchtask3['status']!='close') { ?>
                                <a href="updatetask.php?edit_tid=<?php echo $fetchtask3['task_id']; ?>"><button
                                        type="button" class="btn btn-outline-success"
                                        style="font-size: 10px;">Edit</button></a>
                                <?php } else { ?>
                                <button type="button" class="btn btn-outline-success" style="font-size: 10px;"
                                    disabled>Edit</button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php while($fetchtask=mysqli_fetch_array($querytask)) {
                            ?>
                        <tr>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['t_about']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['bucket_name']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['assign_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['due_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['status']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['t_priority']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask['employee_name']; ?>
                            </td>
                            <td style="font-size: 10px; text-align: center;">
                                <?php
                                $currentDate = new DateTime();
                                $dueDate = new DateTime($fetchtask['due_date']);
                                if ($currentDate > $dueDate && $fetchtask['status']=="open") {
                                    echo '<span class="fr"></span>';
                                } else {
                                    echo '<span class="fr5"></span>';
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo "./uploads/".$fetchtask['t_file']; ?>" download><img
                                        src="assets/images/logos/icons8-download.gif" class="image"></a>
                            </td>
                            <td>
                                <?php if($fetchtask['status']=='open') { ?>
                                <a href="task_list.php?closeid=<?php echo $fetchtask['task_id']; ?>"
                                    onClick="return confirm(`Confirm to Close This Task.`)">
                                    <img src="assets/images/logos/icons8-close.gif" class="image zoom">
                                </a>
                                <?php } else { ?>
                                <div class="tooltip"><a href="#!">
                                        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                    </a>
                                    <span class="tooltiptext">
                                        <h6>
                                            <?php echo $fetchtask['close_admin']; ?>
                                            <?php echo $fetchtask['close_manager']; ?>
                                            <?php echo $fetchtask['close_assistant']; ?>
                                            <?php echo $fetchtask['close_employee']; ?>
                                        </h6>
                                        <?php echo $fetchtask['close_date']; ?>
                                    </span>
                                </div>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;">

                                <?php if($fetchtask['status']!='close') { ?>
                                <a href="updatetask.php?edit_tid=<?php echo $fetchtask['task_id']; ?>"><button
                                        type="button" class="btn btn-outline-success"
                                        style="font-size: 10px;">Edit</button></a>
                                <?php } else { ?>
                                <button type="button" class="btn btn-outline-success"
                                    style="font-size: 10px;">Edit</button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php while($fetchtask1=mysqli_fetch_array($querytask1)) { ?>
                        <tr>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask1['t_about']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask1['bucket_name']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask1['assign_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask1['due_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask1['status']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask1['t_priority']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask1['assistant_name']; ?>
                            </td>
                            <td style="font-size: 10px; text-align: center;">
                                <?php
                                $currentDate1 = new DateTime();
                                $dueDate1 = new DateTime($fetchtask1['due_date']);
                                if ($currentDate1 > $dueDate1 && $fetchtask1['status']=="open") {
                                    echo '<span class="fr"></span>';
                                } else {
                                    echo '<span class="fr5"></span>';
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo "./uploads/".$fetchtask1['t_file']; ?>" download><img
                                        src="assets/images/logos/icons8-download.gif" class="image"></a>
                            </td>
                            <td>
                                <?php if($fetchtask1['status']=='open') { ?>
                                <a href="task_list.php?closeid=<?php echo $fetchtask1['task_id']; ?>"
                                    onClick="return confirm(`Confirm to Close This Task.`)">
                                    <img src="assets/images/logos/icons8-close.gif" class="image zoom">
                                </a>
                                <?php } else { ?>
                                <div class="tooltip"><a href="#!">
                                        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                    </a>
                                    <span class="tooltiptext">
                                        <h6>
                                            <?php echo $fetchtask1['close_admin']; ?>
                                            <?php echo $fetchtask1['close_manager']; ?>
                                            <?php echo $fetchtask1['close_assistant']; ?>
                                        </h6>
                                        <?php echo $fetchtask1['close_date']; ?>
                                    </span>
                                </div>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;">

                                <?php if($fetchtask1['status']!='close') { ?>
                                <a href="updatetask.php?edit_tid=<?php echo $fetchtask1['task_id']; ?>"><button
                                        type="button" class="btn btn-outline-success"
                                        style="font-size: 10px;">Edit</button></a>
                                <?php } else {?>
                                <button type="button" class="btn btn-outline-success" style="font-size: 10px;"
                                    disabled>Edit</button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } while($fetchtask2=mysqli_fetch_array($querytask2)) {
                            ?>
                        <tr>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['t_about']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['bucket_name']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['assign_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['due_date']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['status']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['t_priority']; ?>
                            </td>
                            <td style="font-size: 10px;">
                                <?php echo $fetchtask2['manager_name']; ?>
                            </td>
                            <td style="font-size: 10px; text-align: center;">
                                <?php
                                $currentDate2 = new DateTime();
                                $dueDate2 = new DateTime($fetchtask2['due_date']);
                                if ($currentDate2 > $dueDate2 && $fetchtask2['status']=="open") {
                                    echo '<span class="fr"></span>';
                                } else {
                                    echo '<span class="fr5"></span>';
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo "./uploads/".$fetchtask2['t_file']; ?>" download><img
                                        src="assets/images/logos/icons8-download.gif" class="image"></a>
                            </td>
                            <td>
                                <?php if($fetchtask2['status']=='open') { ?>
                                <a href="task_list.php?closeid=<?php echo $fetchtask2['task_id']; ?>"
                                    onClick="return confirm(`Confirm to Close This Task.`)">
                                    <img src="assets/images/logos/icons8-close.gif" class="image zoom">
                                </a>
                                <?php } else { ?>
                                <div class="tooltip"><a href="#!">
                                        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                    </a>
                                    <span class="tooltiptext">
                                        <h6>
                                            <?php echo $fetchtask2['close_admin']; ?>
                                            <?php echo $fetchtask2['close_manager']; ?>
                                        </h6>
                                        <?php echo $fetchtask2['close_date']; ?>
                                    </span>
                                </div>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;">

                                <?php if($fetchtask2['status']!='close') { ?>
                                <a href="updatetask.php?edit_tid=<?php echo $fetchtask2['task_id']; ?>"><button
                                        type="button" class="btn btn-outline-success"
                                        style="font-size: 10px;">Edit</button></a>
                                <?php } else { ?>
                                <button type="button" class="btn btn-outline-success" style="font-size: 10px;"
                                    disabled>Edit</button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function() {
    // Initialize DataTables
    var table = $('#taskTable').DataTable({
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
    $('#taskXsearch').on('keyup change', function() {
        // Filter table data on input value change
        table.columns(6).search($(this).val()).draw();
    });
});
</script>
</body>

</html>