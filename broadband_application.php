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
?>
<?php
if(isset($_POST['broad_search'])) {
    $broadband=trim($_POST['broadband']);
    $br_date=trim($_POST['br_date']);
    $ap=" AND (employee.employee_name LIKE '%$broadband%') AND (application.date LIKE '%$br_date%' OR  application.close_date LIKE '%$br_date%') ";
}
$solved=$_REQUEST["solved"];
if ($solved) {
    $close_date=date('d-M-y');
    $solve_query="UPDATE `application` SET `flag`='0', close_date='{$close_date}', close_by='{$_SESSION['assign']}' WHERE application_id='{$solved}'";
    $solve_connect=mysqli_query($conn,$solve_query);
    ?>
<script>
window.history.replaceState({}, document.title, window.location.pathname);
</script>
<?php
}
?>
<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">BroadBand Application List</h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <nav class="navbar navbar-light bg-light smooth mb-3">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <form class="d-flex" method="post">
                    <input class="form-control m-1" type="text" name="br_date" id="br_date" placeholder="Date"
                        autocomplete="off">
                    <input class="form-control m-1" type="search" name="broadband" placeholder="Name"
                        aria-label="Search">
                    <input class="btn btn-outline-success m-1" type="submit" name="broad_search" value="Search">
                </form>
            </div>
        </nav>
        <form>
            <div class="table-responsive smooth p-2" style="background-color: beige;">
                <table id="applicationTable" class="table table-striped-columns smooth p-2">
                    <thead>
                        <tr class="cus-td" style="font-size: 12px;">
                            <th style="min-width: 100px;">Applicant Name</th>
                            <th style="min-width: 80px;">Date</th>
                            <th>LCO Type</th>
                            <th style="min-width: 120px;">LCO Email</th>
                            <th style="min-width: 140px;">Name Of the Network</th>
                            <th style="min-width: 100px;">LCO Name</th>
                            <th style="min-width: 150px;">LCO Contact Number</th>
                            <th style="min-width: 200px;">LCO Address</th>
                            <th style="min-width: 100px;">LCO Area</th>
                            <th style="min-width: 100px;">LCO Pincode</th>
                            <th style="min-width: 200px;">LCO's Residence Address</th>
                            <th style="min-width: 150px;">LCO's Residence Area</th>
                            <th style="min-width: 120px;">LCO's Residence Pincode</th>
                            <th style="min-width: 150px;">LCO Aadhar Number</th>
                            <th style="min-width: 150px;">LCO PAN Number</th>
                            <th style="min-width: 100px;">Present ISP Signal</th>
                            <th style="min-width: 150px;">Total Number Of Customers</th>
                            <th>Multiple Feed</th>
                            <th>Installation Amount</th>
                            <th>Nearest Hub</th>
                            <th>Compliance</th>
                            <th>Documentation</th>
                            <th style="min-width: 100px;">LCO's Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($_SESSION['role']=='admin') {
                                $sqlb="SELECT application.*, employee.employee_name, assistant.assistant_name, manager.manager_name, reg.admin_name FROM application
                                INNER JOIN employee ON application.applicant=employee.assign_id
                                INNER JOIN company_master ON employee.company_id=company_master.company_id
                                LEFT JOIN assistant ON application.close_by=assistant.assign_id
                                LEFT JOIN manager ON application.close_by=manager.assign_id
                                LEFT JOIN reg ON application.close_by=reg.assign_id
                                WHERE company_master.admin_id='{$_SESSION['id']}'".$ap." ORDER BY application_id DESC";
                                $queryb=mysqli_query($conn,$sqlb);
                                while($collect=mysqli_fetch_array($queryb)) {
                            ?>
                        <tr class="cus-td" style="font-size: 12px;">
                            <td><?php echo $collect['employee_name']; ?></td>
                            <td><?php echo $collect['date']; ?></td>
                            <td><?php echo $collect['lco_type']; ?></td>
                            <td><?php echo $collect['lco_email']; ?></td>
                            <td><?php echo $collect['company_name']; ?></td>
                            <td><?php echo $collect['lco_name']; ?></td>
                            <td><?php echo $collect['lco_contact']; ?></td>
                            <td><?php echo $collect['lco_address']; ?></td>
                            <td><?php echo $collect['lco_area']; ?></td>
                            <td><?php echo $collect['lco_pincode']; ?></td>
                            <td><?php echo $collect['lco_residence_address']; ?></td>
                            <td><?php echo $collect['lco_residence_area']; ?></td>
                            <td><?php echo $collect['lco_residence_pincode']; ?></td>
                            <td><?php echo $collect['lco_aadhar']; ?></td>
                            <td><?php echo $collect['lco_pan']; ?></td>
                            <td><?php echo $collect['isp_signal']; ?></td>
                            <td><?php echo $collect['customar_num']; ?></td>
                            <td><?php echo $collect['multi_feed']; ?></td>
                            <td><?php echo $collect['amount']; ?></td>
                            <td><?php echo $collect['nearest_hub']; ?></td>
                            <td><?php echo $collect['compliance']; ?></td>
                            <td><a href="<?php echo "./uploads/".$collect['document']; ?>" download>
                                    <img src="assets/images/logos/icons8-download.gif" class="image">
                                </a>
                            </td>
                            <td><?php echo $collect['lco_status']; ?></td>
                            <td>
                                <?php if ($collect['flag'] == '1'){ ?>
                                <a href="broadband_application.php?solved=<?php echo $collect['application_id']; ?>"
                                    onClick="return confirm(`Confirm to Close This Task.`)">
                                    <img src="assets/images/logos/icons8-close.gif" class="image zoom">
                                </a>
                                <?php } elseif ($collect['flag'] == '0'){ ?>
                                <div class="tooltip">
                                    <a href="#!">
                                        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                    </a>
                                    <span class="tooltiptext">
                                        <h6>
                                            <?php echo $collect['assistant_name']; ?>
                                            <?php echo $collect['manager_name']; ?>
                                            <?php echo $collect['admin_name']; ?>
                                        </h6>
                                        <?php echo $collect['close_date']; ?>
                                    </span>
                                </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } } if($_SESSION['role']=='manager') {
                            $sqlb="SELECT application.*, employee.employee_name, assistant.assistant_name, manager.manager_name, reg.admin_name FROM application
                            INNER JOIN employee ON application.applicant=employee.assign_id
                            INNER JOIN assistant ON employee.assistant_id=assistant.assistant_id
                            LEFT JOIN assistant ON application.close_by=assistant.assign_id
                            LEFT JOIN manager ON application.close_by=manager.assign_id
                            LEFT JOIN reg ON application.close_by=reg.assign_id
                            WHERE assistant.manager_id='{$_SESSION['id']}'".$ap." ORDER BY application_id DESC";
                            $queryb=mysqli_query($conn,$sqlb);
                            while($collect=mysqli_fetch_array($queryb)) {
                            ?>
                        <tr class="cus-td" style="font-size: 12px;">
                            <td><?php echo $collect['employee_name']; ?></td>
                            <td><?php echo $collect['date']; ?></td>
                            <td><?php echo $collect['lco_type']; ?></td>
                            <td><?php echo $collect['lco_email']; ?></td>
                            <td><?php echo $collect['company_name']; ?></td>
                            <td><?php echo $collect['lco_name']; ?></td>
                            <td><?php echo $collect['lco_contact']; ?></td>
                            <td><?php echo $collect['lco_address']; ?></td>
                            <td><?php echo $collect['lco_area']; ?></td>
                            <td><?php echo $collect['lco_pincode']; ?></td>
                            <td><?php echo $collect['lco_residence_address']; ?></td>
                            <td><?php echo $collect['lco_residence_area']; ?></td>
                            <td><?php echo $collect['lco_residence_pincode']; ?></td>
                            <td><?php echo $collect['lco_aadhar']; ?></td>
                            <td><?php echo $collect['lco_pan']; ?></td>
                            <td><?php echo $collect['isp_signal']; ?></td>
                            <td><?php echo $collect['customar_num']; ?></td>
                            <td><?php echo $collect['multi_feed']; ?></td>
                            <td><?php echo $collect['amount']; ?></td>
                            <td><?php echo $collect['nearest_hub']; ?></td>
                            <td><?php echo $collect['compliance']; ?></td>
                            <td><a href="<?php echo "./uploads/".$collect['document']; ?>" download>
                                    <img src="assets/images/logos/icons8-download.gif" class="image">
                                </a>
                            </td>
                            <td><?php echo $collect['lco_status']; ?></td>
                            <td>
                                <?php if ($collect['flag'] == '1'){ ?>
                                <a href="broadband_application.php?solved=<?php echo $collect['application_id']; ?>"
                                    onClick="return confirm(`Confirm to Close This Task.`)">
                                    <img src="assets/images/logos/icons8-close.gif" class="image zoom">
                                </a>
                                <?php } elseif ($collect['flag'] == '0'){ ?>
                                <div class="tooltip">
                                    <a href="#!">
                                        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                    </a>
                                    <span class="tooltiptext">
                                        <h6>
                                            <?php echo $collect['assistant_name']; ?>
                                            <?php echo $collect['manager_name']; ?>
                                            <?php echo $collect['admin_name']; ?>
                                        </h6>
                                        <?php echo $collect['close_date']; ?>
                                    </span>
                                </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } } if($_SESSION['role']=='assistant') {
                            $sqlb="SELECT application.*, employee.employee_name, assistant.assistant_name, manager.manager_name, reg.admin_name FROM application
                            INNER JOIN employee ON application.applicant=employee.assign_id
                            LEFT JOIN assistant ON application.close_by=assistant.assign_id
                            LEFT JOIN manager ON application.close_by=manager.assign_id
                            LEFT JOIN reg ON application.close_by=reg.assign_id
                            WHERE employee.assistant_id='{$_SESSION['id']}'".$ap." ORDER BY application_id DESC";
                            $queryb=mysqli_query($conn,$sqlb);
                            while($collect=mysqli_fetch_array($queryb)) { 
                            ?>
                        <tr class="cus-td" style="font-size: 12px;">
                            <td><?php echo $collect['employee_name']; ?></td>
                            <td><?php echo $collect['date']; ?></td>
                            <td><?php echo $collect['lco_type']; ?></td>
                            <td><?php echo $collect['lco_email']; ?></td>
                            <td><?php echo $collect['company_name']; ?></td>
                            <td><?php echo $collect['lco_name']; ?></td>
                            <td><?php echo $collect['lco_contact']; ?></td>
                            <td><?php echo $collect['lco_address']; ?></td>
                            <td><?php echo $collect['lco_area']; ?></td>
                            <td><?php echo $collect['lco_pincode']; ?></td>
                            <td><?php echo $collect['lco_residence_address']; ?></td>
                            <td><?php echo $collect['lco_residence_area']; ?></td>
                            <td><?php echo $collect['lco_residence_pincode']; ?></td>
                            <td><?php echo $collect['lco_aadhar']; ?></td>
                            <td><?php echo $collect['lco_pan']; ?></td>
                            <td><?php echo $collect['isp_signal']; ?></td>
                            <td><?php echo $collect['customar_num']; ?></td>
                            <td><?php echo $collect['multi_feed']; ?></td>
                            <td><?php echo $collect['amount']; ?></td>
                            <td><?php echo $collect['nearest_hub']; ?></td>
                            <td><?php echo $collect['compliance']; ?></td>
                            <td><a href="<?php echo "./uploads/".$collect['document']; ?>" download>
                                    <img src="assets/images/logos/icons8-download.gif" class="image">
                                </a>
                            </td>
                            <td><?php echo $collect['lco_status']; ?></td>
                            <td>
                                <?php if ($collect['flag'] == '1'){ ?>
                                <a href="broadband_application.php?solved=<?php echo $collect['application_id']; ?>"
                                    onClick="return confirm(`Confirm to Close This Task.`)">
                                    <img src="assets/images/logos/icons8-close.gif" class="image zoom">
                                </a>
                                <?php } elseif ($collect['flag'] == '0'){ ?>
                                <div class="tooltip">
                                    <a href="#!">
                                        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                    </a>
                                    <span class="tooltiptext">
                                        <h6>
                                            <?php echo $collect['assistant_name']; ?>
                                            <?php echo $collect['manager_name']; ?>
                                            <?php echo $collect['admin_name']; ?>
                                        </h6>
                                        <?php echo $collect['close_date']; ?>
                                    </span>
                                </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var picker = new Pikaday({
        field: document.getElementById('br_date'),
        format: 'DD-MMM-YY',
        yearRange: [moment().subtract(100, 'years').year(), moment().year()]
    });
});
$(document).ready(function() {
    // Initialize DataTables
    var table = $('#applicationTable').DataTable({
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

});
</script>
</body>

</html>