<?php
if(isset($_POST['task_save'])){
  $task_bucket=$_POST['task_bucket'];
  $assign=$_POST['assign'];
  $assign_date=$_POST['assign_date'];
  $due_date=$_POST['due_date'];
  $priority=$_POST['priority'];
  $file=$_POST['file'];
  $target_dir = "uploads/";
  $about=$_POST['about'];
  $status="open";
  $file = basename($_FILES["file"]["name"]);
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$file)) {
  $sqlt="INSERT INTO `task` (`t_bucket`,`assign_by`,`assign_to`,`assign_date`,`due_date`,`t_priority`,`t_file`,`t_about`,`status`) VALUES ('{$task_bucket}','{$_SESSION['assign']}','{$assign}','{$assign_date}','{$due_date}','{$priority}','{$file}','{$about}','{$status}')";
  $queryt=mysqli_query($conn,$sqlt);
  echo '<script>
            window.location = window.location;
        </script>';
  }
}
?>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/js/tom-select.complete.min.js"></script>

<!-- Modal -->
<div class="modal fade" id="addtask" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #fd9292;">
            <div class="modal-header" style="background-color: #ffc2c2;">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Task</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <div class="row">
                            <?php if($_SESSION['role']=='admin') {
                            $sqlt2="SELECT bucket.* FROM bucket
                            INNER JOIN company_master ON bucket.company_id=company_master.company_id 
                            WHERE company_master.admin_id='{$_SESSION['id']}'";
                            $queryt2=mysqli_query($conn,$sqlt2);
                            ?>
                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Bucket</strong></label>

                                <select id="select-bucket" aria-label="Default select example" name="task_bucket">
                                    <option></option>
                                    <?php while($contentt2=mysqli_fetch_array($queryt2)){ ?>
                                    <option value="<?php echo $contentt2['b_id']; ?>">
                                        <?php echo $contentt2['bucket_name']; ?></option><?php } ?>
                                </select>

                            </div>
                            <?php
                            $sqlt3="SELECT manager.assign_id, manager.manager_name FROM manager 
                            INNER JOIN company_master ON manager.company_id=company_master.company_id 
                            WHERE company_master.admin_id='{$_SESSION['id']}' AND manager.manager_status='1'";
                            $queryt3=mysqli_query($conn,$sqlt3);
                            $sqlt31="SELECT assistant.assign_id, assistant.assistant_name FROM assistant 
                            INNER JOIN company_master ON assistant.company_id=company_master.company_id 
                            WHERE company_master.admin_id='{$_SESSION['id']}' AND assistant.assistant_status='1'";
                            $queryt31=mysqli_query($conn,$sqlt31);
                            $sqlt32="SELECT employee.assign_id, employee.employee_name FROM employee 
                            INNER JOIN company_master ON employee.company_id=company_master.company_id 
                            WHERE company_master.admin_id='{$_SESSION['id']}' AND employee.employee_status='1'";
                            $queryt32=mysqli_query($conn,$sqlt32);
                            ?>

                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Assign To</strong></label>
                                <select id="select-assign" aria-label="Default select example" name="assign"
                                    style="width: 100%;">
                                    <option value=""></option>
                                    <option value="<?php echo $_SESSION['assign']; ?>">My Self
                                    </option>
                                    <?php while($contentt3=mysqli_fetch_array($queryt3)){ ?>
                                    <option value="<?php echo $contentt3['assign_id']; ?>">
                                        <?php echo $contentt3['manager_name']; ?></option><?php } ?>
                                    <?php while($contentt31=mysqli_fetch_array($queryt31)){ ?>
                                    <option value="<?php echo $contentt31['assign_id']; ?>">
                                        <?php echo $contentt31['assistant_name']; ?></option><?php } ?>
                                    <?php while($contentt32=mysqli_fetch_array($queryt32)){ ?>
                                    <option value="<?php echo $contentt32['assign_id']; ?>">
                                        <?php echo $contentt32['employee_name']; ?></option><?php } ?>
                                </select>
                            </div>
                            <?php } else if($_SESSION['role']=='manager') {
                            $sqlt2="SELECT bucket.* FROM bucket
                            INNER JOIN manager ON bucket.company_id=manager.company_id 
                            WHERE manager.manager_id='{$_SESSION['id']}'";
                            $queryt2=mysqli_query($conn,$sqlt2);
                            ?>
                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Bucket</strong></label>
                                <select id="select-bucket" aria-label="Default select example" name="task_bucket">
                                    <option></option>
                                    <?php while($contentt2=mysqli_fetch_array($queryt2)){ ?>
                                    <option value="<?php echo $contentt2['b_id']; ?>">
                                        <?php echo $contentt2['bucket_name']; ?></option><?php } ?>
                                </select>

                            </div>
                            <?php
                            $sqlt3="SELECT assistant.assign_id, assistant.assistant_name FROM assistant
                            WHERE (company_id='{$_SESSION['company']}' OR manager_id='{$_SESSION['id']}') AND assistant_status='1'";
                            $queryt3=mysqli_query($conn,$sqlt3);
                            $sqlt31="SELECT employee.assign_id, employee.employee_name 
                            FROM employee 
                            WHERE employee.company_id = '{$_SESSION['company']}' AND employee.employee_status='1' OR 
                                  (employee.assign_id IN (SELECT employee.assign_id 
                                                          FROM employee 
                                                          INNER JOIN assistant ON employee.assistant_id = assistant.assistant_id
                                                          WHERE assistant.manager_id = '{$_SESSION['id']}')) AND employee.employee_status='1'";
                            $queryt31=mysqli_query($conn,$sqlt31);
                                ?>
                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Assign To</strong></label>
                                <select id="select-assign" aria-label="Default select example" name="assign">
                                    <option value=""></option>
                                    <option value="<?php echo $_SESSION['assign']; ?>">My Self
                                    </option>
                                    <?php while($contentt3=mysqli_fetch_array($queryt3)){ ?>
                                    <option value="<?php echo $contentt3['assign_id']; ?>">
                                        <?php echo $contentt3['assistant_name']; ?></option><?php } ?>
                                    <?php while($contentt31=mysqli_fetch_array($queryt31)){ ?>
                                    <option value="<?php echo $contentt31['assign_id']; ?>">
                                        <?php echo $contentt31['employee_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php } else if($_SESSION['role']=='assistant') {
                            $sqlt2="SELECT bucket.* FROM bucket
                            INNER JOIN assistant ON bucket.company_id=assistant.company_id 
                            WHERE assistant.assistant_id='{$_SESSION['id']}'";
                            $queryt2=mysqli_query($conn,$sqlt2);
                            ?>
                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Bucket</strong></label>
                                <select id="select-bucket" aria-label="Default select example" name="task_bucket">
                                    <option></option>
                                    <?php while($contentt2=mysqli_fetch_array($queryt2)){ ?>
                                    <option value="<?php echo $contentt2['b_id']; ?>">
                                        <?php echo $contentt2['bucket_name']; ?></option><?php } ?>
                                </select>

                            </div>
                            <?php
                            $sqlt3="SELECT employee.assign_id, employee.employee_name FROM employee WHERE assistant_id='{$_SESSION['id']}' AND employee_status='1'";
                            $queryt3=mysqli_query($conn,$sqlt3);
                                ?>
                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Assign To</strong></label>
                                <select id="select-assign" aria-label="Default select example" name="assign">
                                    <option value=""></option>
                                    <option value="<?php echo $_SESSION['assign']; ?>">My Self
                                    </option>
                                    <?php while($contentt3=mysqli_fetch_array($queryt3)){ ?>
                                    <option value="<?php echo $contentt3['assign_id']; ?>">
                                        <?php echo $contentt3['employee_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php } else if($_SESSION['role']=='employee') {
                            $sqlt2="SELECT bucket.* FROM bucket
                            INNER JOIN employee ON bucket.company_id=employee.company_id 
                            WHERE employee.employee_id='{$_SESSION['id']}'";
                            $queryt2=mysqli_query($conn,$sqlt2);
                            ?>
                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Bucket</strong></label>
                                <select id="select-bucket" aria-label="Default select example" name="task_bucket">
                                    <option></option>
                                    <?php while($contentt2=mysqli_fetch_array($queryt2)){ ?>
                                    <option value="<?php echo $contentt2['b_id']; ?>">
                                        <?php echo $contentt2['bucket_name']; ?></option><?php } ?>
                                </select>

                            </div>
                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Assign To</strong></label>
                                <select id="select-assign" aria-label="Default select example" name="assign">
                                    <option value="<?php echo $_SESSION['assign']; ?>">My Self
                                    </option>
                                </select>
                            </div>
                            <?php } ?>
                            <div class="col-md-6">
                                <label class="form-label ms-2"><strong>Assign Date</strong></label>
                                <input type="text" class="form-control me-2" name="assign_date"
                                    value="<?php echo date('d-M-y'); ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label ms-2"><strong>Due Date</strong></label>
                                <input class="form-control" type="text" id="due_date" name="due_date" autocomplete="off"
                                    required>
                            </div>

                            <div class="col-md-12 m-2">
                                <label class="form-label pe-3"><strong>Priority</strong></label>
                                <input type="radio" class="btn-check" name="priority" value="low" id="option1"
                                    autocomplete="off">
                                <label class="btn btn-outline-success" for="option1">Low</label>

                                <input type="radio" class="btn-check" name="priority" value="medium" id="option2"
                                    autocomplete="off">
                                <label class="btn btn-outline-primary ms-1" for="option2">Medium</label>

                                <input type="radio" class="btn-check" name="priority" value="high" id="option3"
                                    autocomplete="off">
                                <label class="btn btn-outline-danger ms-1" for="option3">High</label>
                            </div>

                            <div class="col-md-12">
                                <label for="formFile" class="form-label ms-2"><strong>Upload</strong></label>
                                <input class="form-control" type="file" name="file" id="formFile" max-size="5000"
                                    accept="image/png, image/jpeg, image/jpg, application/pdf" capture="camera/">
                                <span class="notranslate ms-2" style="color:#FF5147;font-size:11px;">File format: .jpeg/
                                    .png/ .jpg/ .pdf/ Max file size limit: 5MB </span>
                            </div>

                            <div class="col-md-12 mt-2">
                                <div class="form-floating">
                                    <textarea class="form-control" name="about" placeholder="Description"
                                        id="floatingTextarea2" style="height: 100px"></textarea>
                                    <label for="floatingTextarea2">Description</label>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" name="task_save" class="btn btn-primary" value="Save">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
function validateForm() {
    var fileInput = document.getElementById('formFile');

    // Check if a file is selected
    if (fileInput.files.length === 0) {
        alert('Please select a file before submitting the form.');
        return false; // Prevent form submission
    }

    return true; // Allow form submission
}
</script>
<script>
new TomSelect("#select-assign", {
    create: false,
    sortField: {
        field: "text",
        direction: "asc"
    }
});
new TomSelect("#select-bucket", {
    create: false,
    sortField: {
        field: "text",
        direction: "asc"
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var picker = new Pikaday({
        field: document.getElementById('due_date'),
        format: 'DD-MMM-YY',
        yearRange: [moment().subtract(100, 'years').year(), moment().year()]
    });
});
</script>