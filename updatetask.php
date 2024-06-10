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
    $edit_tid=$_REQUEST['edit_tid'];
    if($edit_tid){
        $sqltid="SELECT * FROM `task` WHERE `task_id`='{$edit_tid}'";
        $querytid=mysqli_query($conn,$sqltid);
        $fetchtid=mysqli_fetch_array($querytid);
    }
?>

<?php
if(isset($_POST['u_task'])){
$assign_edit=$_POST['assign_edit'];
$bucket_edit=$_POST['bucket_edit'];
$u_date=$_POST['u_date'];
$u_priority=$_POST['u_priority'];
$u_file=$_POST['u_file'];
$target_dir = "uploads/";
$u_file = basename($_FILES["u_file"]["name"]);
$u_about=$_POST['u_about'];
if (move_uploaded_file($_FILES["u_file"]["tmp_name"], $target_dir.$u_file)) {
$inset="UPDATE `task` SET   `assign_to`='{$assign_edit}',
                            `t_bucket`='{$bucket_edit}',
                            `due_date`='{$u_date}',
                            `t_priority`='{$u_priority}',
                            `t_file`='{$u_file}',
                            `t_about`='{$u_about}'
                          WHERE `task_id`='{$edit_tid}'";
$query=mysqli_query($conn,$inset);
}
else{
  $inset="UPDATE `task` SET `assign_to`='{$assign_edit}',
                            `t_bucket`='{$bucket_edit}',
                            `due_date`='{$u_date}',
                            `t_priority`='{$u_priority}',
                            `t_about`='{$u_about}'
                          WHERE `task_id`='{$edit_tid}'";
$query=mysqli_query($conn,$inset); 
}
?>
<script type="text/javascript">
window.location.href = "task_list.php";
</script>
<?php
}
?>

<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">Update Task</h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <form class="p-3" method="post" enctype="multipart/form-data">
        <div class="row">
            <?php if($_SESSION['role']=='admin') { ?>
            <div class="col-md-4">
                <?php 
                        $sqltid1="SELECT manager.assign_id, manager.manager_name FROM manager 
                        INNER JOIN company_master ON manager.company_id=company_master.company_id 
                        WHERE company_master.admin_id='{$_SESSION['id']}' AND manager.manager_status='1'";
                        $querytid1=mysqli_query($conn,$sqltid1);
                        $sqltid2="SELECT assistant.assign_id, assistant.assistant_name FROM assistant 
                        INNER JOIN company_master ON assistant.company_id=company_master.company_id 
                        WHERE company_master.admin_id='{$_SESSION['id']}' AND assistant.assistant_status='1'";
                        $querytid2=mysqli_query($conn,$sqltid2);
                        $sqltid3="SELECT employee.assign_id, employee.employee_name FROM employee 
                        INNER JOIN company_master ON employee.company_id=company_master.company_id 
                        WHERE company_master.admin_id='{$_SESSION['id']}' AND employee.employee_status='1'";
                        $querytid3=mysqli_query($conn,$sqltid3);
                        ?>
                <label class="form-label ms-2" style="font-size: 13px;"><strong>Assigned To</strong></label>
                <select class="form-select" aria-label="Default select example" name="assign_edit">
                    <option value="<?php echo $_SESSION['assign']; ?>"
                        <?php if($fetchtid['assign_to']==$_SESSION['assign']){echo"selected";}?>>My Self</option>
                    <?php while($taketid1=mysqli_fetch_array($querytid1)) {?>
                    <option value="<?php echo $taketid1['assign_id']; ?>"
                        <?php if($fetchtid['assign_to']==$taketid1['assign_id']){echo"selected";}?>>
                        <?php echo $taketid1['manager_name']; ?>
                    </option><?php } ?>
                    <?php while($taketid2=mysqli_fetch_array($querytid2)) {?>
                    <option value="<?php echo $taketid2['assign_id']; ?>"
                        <?php if($fetchtid['assign_to']==$taketid2['assign_id']){echo"selected";}?>>
                        <?php echo $taketid2['assistant_name']; ?>
                    </option><?php } ?>
                    <?php while($taketid3=mysqli_fetch_array($querytid3)) {?>
                    <option value="<?php echo $taketid3['assign_id']; ?>"
                        <?php if($fetchtid['assign_to']==$taketid3['assign_id']){echo"selected";}?>>
                        <?php echo $taketid3['employee_name']; ?>
                    </option><?php } ?>
                </select>
            </div>
            <?php
                $sqltb="SELECT bucket.* FROM bucket
                INNER JOIN company_master ON bucket.company_id=company_master.company_id 
                WHERE company_master.admin_id='{$_SESSION['id']}'";
                $querytb=mysqli_query($conn,$sqltb);
                ?>
            <div class="col-md-4">
                <label class="form-label ms-2"><strong>Bucket</strong></label>
                <select id="select-bucket" class="form-select" aria-label="Default select example" name="bucket_edit">
                    <?php while($contenttb=mysqli_fetch_array($querytb)){ ?>
                    <option value="<?php echo $contenttb['b_id']; ?>"
                        <?php if($fetchtid['t_bucket']==$contenttb['b_id']){echo"selected";}?>>
                        <?php echo $contenttb['bucket_name']; ?></option><?php } ?>
                </select>
            </div>
            <?php } else if($_SESSION['role']=='manager') { ?>
            <div class="col-md-4">
                <?php
                    $sqltid2="SELECT assistant.assign_id, assistant.assistant_name FROM assistant
                    WHERE (company_id='{$_SESSION['company']}' OR manager_id='{$_SESSION['id']}') AND assistant_status='1'";
                    $querytid2=mysqli_query($conn,$sqltid2);
                    $sqltid3="SELECT employee.assign_id, employee.employee_name 
                    FROM employee 
                    WHERE employee.company_id = '{$_SESSION['company']}' AND employee.employee_status='1' OR 
                          (employee.assign_id IN (SELECT employee.assign_id 
                                                  FROM employee 
                                                  INNER JOIN assistant ON employee.assistant_id = assistant.assistant_id
                                                  WHERE assistant.manager_id = '{$_SESSION['id']}')) AND employee.employee_status='1'";
                    $querytid3=mysqli_query($conn,$sqltid3);
                    ?>
                <label class="form-label ms-2" style="font-size: 13px;"><strong>Assigned To</strong></label>
                <select class="form-select" aria-label="Default select example" name="assign_edit">
                    <option value="<?php echo $_SESSION['assign']; ?>"
                        <?php if($fetchtid['assign_to']==$_SESSION['assign']){echo"selected";}?>>My Self</option>
                    <?php while($taketid2=mysqli_fetch_array($querytid2)) {?>
                    <option value="<?php echo $taketid2['assign_id']; ?>"
                        <?php if($fetchtid['assign_to']==$taketid2['assign_id']){echo"selected";}?>>
                        <?php echo $taketid2['assistant_name']; ?>
                    </option><?php } ?>
                    <?php while($taketid3=mysqli_fetch_array($querytid3)) {?>
                    <option value="<?php echo $taketid3['assign_id']; ?>"
                        <?php if($fetchtid['assign_to']==$taketid3['assign_id']){echo"selected";}?>>
                        <?php echo $taketid3['employee_name']; ?>
                    </option><?php } ?>
                </select>
            </div>
            <?php
                $sqltb="SELECT bucket.* FROM bucket
                INNER JOIN manager ON bucket.company_id=manager.company_id 
                WHERE manager.manager_id='{$_SESSION['id']}'";
                $querytb=mysqli_query($conn,$sqltb);
                ?>
            <div class="col-md-4">
                <label class="form-label ms-2"><strong>Bucket</strong></label>
                <select class="form-select" aria-label="Default select example" name="bucket_edit">
                    <?php while($contenttb=mysqli_fetch_array($querytb)){ ?>
                    <option value="<?php echo $contenttb['b_id']; ?>"
                        <?php if($fetchtid['t_bucket']==$contenttb['b_id']){echo"selected";}?>>
                        <?php echo $contenttb['bucket_name']; ?></option><?php } ?>
                </select>
            </div>
            <?php } else if($_SESSION['role']=='assistant') { ?>
            <div class="col-md-4">
                <?php
                        $sqltid3="SELECT employee.assign_id, employee.employee_name FROM employee WHERE assistant_id='{$_SESSION['id']}' AND employee_status='1'";
                        $querytid3=mysqli_query($conn,$sqltid3);
                    ?>
                <label class="form-label ms-2" style="font-size: 13px;"><strong>Assigned To</strong></label>
                <select class="form-select" aria-label="Default select example" name="assign_edit">
                    <option value="<?php echo $_SESSION['assign']; ?>"
                        <?php if($fetchtid['assign_to']==$_SESSION['assign']){echo"selected";}?>>My Self</option>
                    <?php while($taketid3=mysqli_fetch_array($querytid3)) {?>
                    <option value="<?php echo $taketid3['assign_id']; ?>"
                        <?php if($fetchtid['assign_to']==$taketid3['assign_id']){echo"selected";}?>>
                        <?php echo $taketid3['employee_name']; ?>
                    </option><?php } ?>
                </select>
            </div>
            <?php
                    $sqltb="SELECT bucket.* FROM bucket
                    INNER JOIN assistant ON bucket.company_id=assistant.company_id 
                    WHERE assistant.assistant_id='{$_SESSION['id']}'";
                    $querytb=mysqli_query($conn,$sqltb);
                    ?>
            <div class="col-md-4">
                <label class="form-label ms-2"><strong>Bucket</strong></label>
                <select class="form-select" aria-label="Default select example" name="bucket_edit">
                    <?php while($contenttb=mysqli_fetch_array($querytb)){ ?>
                    <option value="<?php echo $contenttb['b_id']; ?>"
                        <?php if($fetchtid['t_bucket']==$contenttb['b_id']){echo"selected";}?>>
                        <?php echo $contenttb['bucket_name']; ?></option><?php } ?>
                </select>
            </div>
            <?php } ?>
            <div class="col-md-4">
                <label class="form-label ms-2" style="font-size: 13px;"><strong>Assigned Date</strong></label>
                <input class="form-control" type="text" value="<?php echo $fetchtid['assign_date']; ?>"
                    aria-label="Disabled input example" disabled readonly>
            </div>

            <div class="col-md-4">
                <label class="form-label ms-2" style="font-size: 13px;"><strong>Due Date</strong></label>
                <input class="form-control" type="text" id="u_date" name="u_date"
                    value="<?php echo $fetchtid['due_date']; ?>" autocomplete="off">
            </div>
            <div class="col-md-4">
                <label class="form-label ms-2" style="font-size: 13px;"><strong>Priority</strong></label>
                <select class="form-select" aria-label="Default select example" name="u_priority">
                    <option value="low" <?php if($fetchtid['t_priority']=="low"){echo"selected";}?>>Low</option>
                    <option value="medium" <?php if($fetchtid['t_priority']=="medium"){echo"selected";}?>>Medium
                    </option>
                    <option value="high" <?php if($fetchtid['t_priority']=="high"){echo"selected";}?>>High
                    </option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label ms-2" style="font-size: 13px;"><strong>Assigned By</strong></label>
                <input class="form-control" type="text" value="<?php echo $_SESSION['name']; ?>"
                    aria-label="Disabled input example" disabled readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label ms-2" style="font-size: 13px;"><strong>Status</strong></label>
                <input class="form-control" type="text" value="<?php echo $fetchtid['status']; ?>"
                    aria-label="Disabled input example" disabled readonly>
            </div>
            <div class="col-md-4">
                <label for="formFile" class="form-label ms-2"
                    style="font-size: 13px;"><strong>Attachment</strong></label>
                <input class="form-control" type="file" name="u_file" id="formFile" max-size="5000"
                    accept="image/png, image/jpeg, image/jpg, application/pdf">
                <span class="notranslate ms-2" style="color:#FF5147;font-size:11px;">File format: .jpeg/ .png/
                    .jpg/
                    .pdf/ Max file size limit: 5MB </span>
            </div>
            <div class="col-md-12">
                <label class="form-label ms-2" style="font-size: 13px;"><strong>Task
                        Description</strong></label>
                <div class="form-floating">
                    <textarea class="form-control" name="u_about" placeholder="Description" id="floatingTextarea2"
                        value="<?php echo $fetchtid['t_about']; ?>"
                        style="height: 100px"><?php echo $fetchtid['t_about']; ?></textarea>
                    <label for="floatingTextarea2">Description</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="text-align: center;">
                <input type="submit" name="u_task" value="Update Task" class="btn btn-outline-success mt-2">
            </div>
        </div>
    </form>
</div>
<script>
$(document).ready(function() {
    // Create Pikaday date picker
    var picker = new Pikaday({
        field: document.getElementById('u_date'),
        format: 'DD-MMM-YY',
        yearRange: [moment().subtract(100, 'years').year(), moment().year()],
        onSelect: function() {
            // Filter table data on date selection
            table.columns(0).search(this.getMoment().format('DD-MMM-YY')).draw();
        }
    });
});
</script>
</body>

</html>