<?php
// Check if the form is submitted
if (isset($_POST['m_save'])) {
    // Sanitize and retrieve form data
    $m_name = trim($_POST['m_name']);
    $m_cname = trim($_POST['m_cname']);
    $m_designation = trim($_POST['m_designation']);
    $upper_designation = trim($_POST['upper-designation']);
    $m_email = trim($_POST['m_email']);
    $m_phone = trim($_POST['m_phone']);
    $m_password = password_hash(trim($_POST['m_password']), PASSWORD_BCRYPT);
    $mstatus = "1";
    $flag = "1";

    // Check if the email is already in use
    $checkEmailQuery = "SELECT email FROM reg WHERE email = '{$m_email}'
                        UNION
                        SELECT email FROM manager WHERE email = '{$m_email}' AND manager_status='1'
                        UNION
                        SELECT email FROM assistant WHERE email = '{$m_email}' AND assistant_status='1'
                        UNION
                        SELECT email FROM employee WHERE email = '{$m_email}' AND employee_status='1'";
    $check = mysqli_query($conn, $checkEmailQuery);
    $result = mysqli_num_rows($check);
    
    // Display an alert if the email is already in use
    if ($result > 0) {
        ?>
        <script>
            alert("Email is Already in Use.");
        </script>
        <?php
    } else {
        // Insert data based on the designation
        if ($m_designation == 'manager') {
            // Insert manager data
            $m_sql = "INSERT INTO `manager` (`company_id`,`manager_name`,`email`,`phone`,`password`,`manager_status`,`flag`) VALUES ('{$m_cname}','{$m_name}','{$m_email}','{$m_phone}','{$m_password}','{$mstatus}','{$flag}')";
            $querym = mysqli_query($conn, $m_sql);
            $last_id = mysqli_insert_id($conn);
            $assign_id = "m_" . $last_id;
            $sqllast = "UPDATE manager SET `assign_id`='{$assign_id}'
                        WHERE `manager_id`='{$last_id}'";
            $querylast = mysqli_query($conn, $sqllast);
        } else if ($m_designation == 'assistant_manager') {
            // Insert assistant manager data
            $m_sql = "INSERT INTO `assistant` (`company_id`,`manager_id`,`assistant_name`,`email`,`phone`,`password`,`assistant_status`,`flag`) VALUES ('{$m_cname}','{$upper_designation}','{$m_name}','{$m_email}','{$m_phone}','{$m_password}','{$mstatus}','{$flag}')";
            $querym = mysqli_query($conn, $m_sql);
            $last_id = mysqli_insert_id($conn);
            $assign_id = "as_" . $last_id;
            $sqllast = "UPDATE assistant SET `assign_id`='{$assign_id}'
                        WHERE `assistant_id`='{$last_id}'";
            $querylast = mysqli_query($conn, $sqllast);
        } else if ($m_designation == 'employee') {
            // Insert employee data
            $m_sql = "INSERT INTO `employee` (`company_id`,`assistant_id`,`employee_name`,`email`,`phone`,`password`,`employee_status`,`flag`) VALUES ('{$m_cname}','{$upper_designation}','{$m_name}','{$m_email}','{$m_phone}','{$m_password}','{$mstatus}','{$flag}')";
            $querym = mysqli_query($conn, $m_sql);
            $last_id = mysqli_insert_id($conn);
            $assign_id = "e_" . $last_id;
            $sqllast = "UPDATE employee SET `assign_id`='{$assign_id}'
                        WHERE `employee_id`='{$last_id}'";
            $querylast = mysqli_query($conn, $sqllast);
        }

        // Refresh the page after successful submission
        echo '<script>
                window.location = window.location;
              </script>';
    }
}
?>


<!-- Modal -->
<div class="modal fade" id="maddteammember" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #fd9292;">
            <div class="modal-header" style="background-color: #ffc2c2;">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Team Member</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form method="post">
                        <div class="row">

                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Name</strong></label>
                                <input type="text" class="form-control" placeholder="Full Name" aria-label="name"
                                    name="m_name" autocomplete="off" required>
                            </div>
                            <?php
                            $sqlcid="SELECT `company_name`, `company_id` FROM `company_master` WHERE `admin_id`='{$_SESSION['id']}'";
                            $querycid=mysqli_query($conn,$sqlcid);
                            ?>
                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Company Name</strong></label>
                                <select class="form-select" aria-label="Default select example" name="m_cname" required>
                                    <option value="" selected disabled>Company Name</option>
                                    <?php while($fetch=mysqli_fetch_array($querycid)) {?>
                                    <option value="<?php echo $fetch['company_id']; ?>">
                                        <?php echo $fetch['company_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-12" id="upper_designation_container" style="display:none;">
                                <label class="form-label ms-2"><strong id="upper_designation_label"></strong></label>
                                <select class="form-select" name="upper_designation" id="upper_designation">
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Designation</strong></label>
                                <select class="form-select" aria-label="Default select example" name="m_designation"
                                    id="m_designation" required>
                                    <option selected disabled>Designation</option>
                                    <option value="manager">Manager</option>
                                    <option value="assistant_manager">Assistant Manager</option>
                                    <option value="employee">Employee</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="inputEmail4" class="form-label ms-2"><strong>Email</strong></label>
                                <input type="email" class="form-control" placeholder="example@example.com"
                                    name="m_email" autocomplete="off" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Contact Info.</strong></label>
                                <input type="tel" class="form-control" placeholder="8017******" pattern="[0-9]{10}"
                                    name="m_phone" autocomplete="off" required>
                            </div>

                            <div class="col-md-12">
                                <label for="inputEmail4" class="form-label ms-2"><strong>Password</strong></label>
                                <input type="password" class="form-control" placeholder="********" minlength="8"
                                    name="m_password" autocomplete="off" required>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" name="m_save" class="btn btn-primary" value="Save">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(document).ready(function() {
    function loadUpperDesignation(type) {
        $.ajax({
            url: './task.php',
            type: 'POST',
            data: {
                'action': 'loadUpperDesignation',
                'type': type
            },
            success: function(resp) {
                $('#upper_designation_container').show()
                $('#upper_designation_container').html('')
                $('#upper_designation_container').html(resp)
            }
        })
    }

    $(document).on('change', '#m_designation', function() {
        let designation = $(this).val();
        if (designation == '' || designation == 'manager') {
            $('#upper_designation_container').hide()
            $('#upper_designation_container').html('')
        } else {
            loadUpperDesignation(designation)
        }
    })

})
</script>