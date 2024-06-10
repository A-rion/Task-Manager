<div class="modal fade" id="leaveapplication" tabindex="-1" style="overflow:hidden;" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #fd9292;">
            <div class="modal-header" style="background-color: #ffc2c2;">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Leave Application</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form method="post">
                        <div class="row">

                            <div class="col-md-12">
                                <input class="form-control me-2" id="l_date" name="l_date"
                                    value="<?php echo date('d-M-y'); ?>" readonly>

                            </div>

                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label ms-2"><strong>From
                                        Date</strong></label>
                                <input class="form-control" type="text" name="fromdate" id="fromdate" autocomplete="off"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label ms-2"><strong>To
                                        Date</strong></label>
                                <input class="form-control" type="text" name="todate" id="todate" autocomplete="off"
                                    required>
                            </div>
                            <?php if($_SESSION['role']=='manager') {
                                            $sqlto="SELECT reg.assign_id, reg.admin_name FROM manager
                                            INNER JOIN company_master ON manager.company_id=company_master.company_id
                                            INNER JOIN reg ON company_master.admin_id=reg.admin_id
                                            WHERE manager.manager_id='{$_SESSION['id']}'";
                                            $queryto=mysqli_query($conn,$sqlto);
                                            ?>
                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Request
                                        To</strong></label>
                                <select class="form-select" aria-label="Default select example" name="requestto">
                                    <?php while($fetchto=mysqli_fetch_array($queryto)) { ?>
                                    <option value="<?php echo $fetchto['assign_id']; ?>">
                                        <?php echo $fetchto['admin_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php $sqlcc="SELECT assign_id, manager_name FROM manager
                                            WHERE NOT manager_id='{$_SESSION['id']}' AND company_id='{$_SESSION['company']}' AND manager_status='1'";
                                            $querycc=mysqli_query($conn,$sqlcc);
                                            ?>
                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>CC</strong></label>
                                <select id="select-cc" multiple autocomplete="off" placeholder="Carbon Copy"
                                    name="cc[]">
                                    <option value=""></option>
                                    <?php while($fetchcc=mysqli_fetch_array($querycc)) { ?>
                                    <option value="<?php echo $fetchcc['assign_id']; ?>">
                                        <?php echo $fetchcc['manager_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php } else if($_SESSION['role']=='assistant') {
                                            $sqlto="SELECT manager.assign_id, manager.manager_name FROM `manager`
                                            INNER JOIN assistant ON manager.manager_id=assistant.manager_id
                                            WHERE assistant.assistant_id='{$_SESSION['id']}' AND manager_status='1'";
                                            $queryto=mysqli_query($conn,$sqlto);
                                            $sqlto1="SELECT reg.assign_id, reg.admin_name FROM assistant
                                            INNER JOIN company_master ON assistant.company_id=company_master.company_id
                                            INNER JOIN reg ON company_master.admin_id=reg.admin_id
                                            WHERE assistant.assistant_id='{$_SESSION['id']}'";
                                            $queryto1=mysqli_query($conn,$sqlto1);
                                            ?>
                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Request
                                        To</strong></label>
                                <select class="form-select" name="requestto">
                                    <option selected>Select Admin/Manager For Approval</option>
                                    <?php while($fetchto1=mysqli_fetch_array($queryto1)) { ?>
                                    <option value="<?php echo $fetchto1['assign_id']; ?>">
                                        <?php echo $fetchto1['admin_name']; ?></option>
                                    <?php } ?>
                                    <?php while($fetchto=mysqli_fetch_array($queryto)) { ?>
                                    <option value="<?php echo $fetchto['assign_id']; ?>">
                                        <?php echo $fetchto['manager_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php 
                                            $sqlcc="SELECT assign_id, manager_name
                                            FROM manager
                                            WHERE company_id = '{$_SESSION['company']}' AND manager_status='1'
                                            UNION
                                            SELECT assign_id, assistant_name
                                            FROM assistant
                                            WHERE assistant_id = '{$_SESSION['id']}' AND company_id = '{$_SESSION['company']}' AND assistant_status='1'
                                            UNION
                                            SELECT reg.assign_id, reg.admin_name
                                            FROM assistant
                                            INNER JOIN company_master ON assistant.company_id = company_master.company_id
                                            INNER JOIN reg ON company_master.admin_id = reg.admin_id
                                            WHERE assistant.assistant_id = '{$_SESSION['id']}'";
                                            $querycc=mysqli_query($conn,$sqlcc);
                                            ?>
                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>CC</strong></label>
                                <select id="select-cc" multiple autocomplete="off" placeholder="Carbon Copy"
                                    name="cc[]">
                                    <option value=""></option>
                                    <?php while($fetchcc = $querycc->fetch_assoc()) { ?>
                                    <?php if (isset($fetchcc['manager_name'])) {
                                                    echo '<option value="' . $fetchcc['assign_id'] . '">' .
                                                        $fetchcc['manager_name'] . '</option>';
                                                    } elseif (isset($fetchcc['assistant_name'])) {
                                                    echo '<option value="' . $fetchcc['assign_id'] . '">' .
                                                        $fetchcc['assistant_name'] . '</option>';
                                                    } elseif (isset($fetchcc['admin_name'])) {
                                                    echo '<option value="' . $fetchcc['assign_id'] . '">' .
                                                        $fetchcc['admin_name'] . '</option>';
                                                    }
                                                    } ?>
                                </select>
                            </div>
                            <?php } else if($_SESSION['role']=='employee') {
                                            $sqlto="SELECT assistant.assign_id, assistant.assistant_name FROM assistant
                                            INNER JOIN employee ON assistant.assistant_id=employee.assistant_id
                                            WHERE employee.employee_id='{$_SESSION['id']}' AND assistant_status='1'";
                                            $queryto=mysqli_query($conn,$sqlto);
                                            ?>
                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>Request
                                        To</strong></label>
                                <select class="form-select" aria-label="Default select example" name="requestto">
                                    <?php while($fetchto=mysqli_fetch_array($queryto)) { ?>
                                    <option value="<?php echo $fetchto['assign_id']; ?>">
                                        <?php echo $fetchto['assistant_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php $sqlcc="SELECT assign_id, manager_name
                                            FROM manager
                                            WHERE company_id = '{$_SESSION['company']}' AND manager_status='1'
                                            UNION
                                            SELECT assign_id, assistant_name
                                            FROM assistant
                                            WHERE (assistant_id='{$_SESSION['A']}' OR company_id = '{$_SESSION['company']}') AND assistant_status='1'
                                            UNION
                                            SELECT reg.assign_id, reg.admin_name
                                            FROM employee
                                            INNER JOIN company_master ON employee.company_id = company_master.company_id
                                            INNER JOIN reg ON company_master.admin_id = reg.admin_id
                                            WHERE employee.employee_id = '{$_SESSION['id']}'";
                                            $querycc=mysqli_query($conn,$sqlcc);
                                            ?>
                            <div class="col-md-12">
                                <label class="form-label ms-2"><strong>CC</strong></label>
                                <select id="select-cc" multiple autocomplete="off" placeholder="Carbon Copy"
                                    name="cc[]">
                                    <option value=""></option>
                                    <?php while($fetchcc = $querycc->fetch_assoc()) { ?>
                                    <?php if (isset($fetchcc['manager_name'])) {
                                                    echo '<option value="' . $fetchcc['assign_id'] . '">' .
                                                        $fetchcc['manager_name'] . '</option>';
                                                    } elseif (isset($fetchcc['assistant_name'])) {
                                                    echo '<option value="' . $fetchcc['assign_id'] . '">' .
                                                        $fetchcc['assistant_name'] . '</option>';
                                                    } elseif (isset($fetchcc['admin_name'])) {
                                                    echo '<option value="' . $fetchcc['assign_id'] . '">' .
                                                        $fetchcc['admin_name'] . '</option>';
                                                    }
                                                    } ?>
                                </select>
                            </div>
                            <?php } ?>
                            <div class="col-md-12 mt-2">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Description" id="floatingTextarea2"
                                        name="reason" style="height: 100px"></textarea>
                                    <label for="floatingTextarea2">Reason For Leave</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" name="submitleave" class="btn btn-primary" value="Submit">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
new TomSelect('#select-cc', {
    plugins: ['caret_position', 'input_autogrow'],
});
document.addEventListener('DOMContentLoaded', function() {
    var picker = new Pikaday({
        field: document.getElementById('fromdate'),
        format: 'DD-MMM-YY',
        yearRange: [moment().subtract(100, 'years').year(), moment().year()]
    });
});
document.addEventListener('DOMContentLoaded', function() {
    var picker = new Pikaday({
        field: document.getElementById('todate'),
        format: 'DD-MMM-YY',
        yearRange: [moment().subtract(100, 'years').year(), moment().year()]
    });
});
</script>