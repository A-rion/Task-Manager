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
if(isset($_POST['issue_upload'])) {
    $docket=$_POST['docket'];
    $issues=$_POST['issues'];
    $date= date('d-M-y');
    $about_issue=$_POST['about_issue'];
    $file=$_POST['file'];
    $target_dir="uploads/";
    $close=$_SESSION['assign'];
    $status="1";
    $file = basename($_FILES["file"]["name"]);
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$file)) {
        $go="INSERT INTO `issue` (`employee_id`, `docket_num`, `reason`, `about`,`issue_date`, `file`, `close_by`, `status`) VALUES ('{$_SESSION['id']}','{$docket}','{$issues}','{$about_issue}','{$date}','{$file}','{$close}','{$status}')";
      $uquery=mysqli_query($conn,$go);
      }
      ?>
<script type="text/javascript">
window.location.href = "issues.php";
</script>
<?php
}
?>
<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">F.E Issue Report</h4>
</div>
<div class="container p-3" style="max-width: 700px;">
    <div class="border border-3 smooth p-3" style="background-color: #fd9292;">
        <form class="p-3" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="row">

                <div class="col-md-5" style="text-align: center;">
                    <label for="docket" class="form-label ms-2"><strong>Docket Number</strong></label>
                    <input type="text" name="docket" class="form-control" aria-label="Docket Number" id="docket"
                        required>
                </div></br>
                <div class="col-md-7" style="text-align: center;">
                    <label class="form-label ms-2"><strong>Types Of Issues</strong></label>
                    <select class="form-select" aria-label="Default select example" name="issues">
                        <option selected></option>
                        <option value="SFP Issue">SFP Issue</option>
                        <option value="Switch Issue">Switch Issue</option>
                        <option value="Plan Change">Plan Change</option>
                        <option value="New Plan">New Plan</option>
                        <option value="OTT Issue">OTT Issue</option>
                    </select>
                </div>
                <div class="col-md-12 mt-2">
                    <div class="form-floating">
                        <textarea class="form-control" name="about_issue" placeholder="Description"
                            id="floatingTextarea2" style="height: 100px" required></textarea>
                        <label for="floatingTextarea2">Description</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <input class="form-control mt-2" type="file" name="file" id="formFile1" max-size="5000"
                        accept="image/png, image/jpeg, application/pdf">
                    <span class="notranslate ms-2" style="color:#FF5147;font-size:11px;">File format: .jpeg/ .png/ ./pdf Max
                        file size limit: 5MB </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: center;">
                    <input type="submit" name="issue_upload" value="Upload" class="btn btn-outline-success m-2">
                </div>
            </div>
        </form>
    </div>
</div>
</body>
<script>
        function validateForm() {
            var fileInput = document.getElementById('formFile1');

            // Check if a file is selected
            if (fileInput.files.length === 0) {
                alert('Please select a file before submitting the form.');
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
</script>
</html>