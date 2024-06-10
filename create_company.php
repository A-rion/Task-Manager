<?php
if(isset($_POST['company_save'])) {
    $cname=$_POST['cname'];
    $sqlcname="INSERT INTO `company_master` (`company_name`,`admin_id`) VALUES ('{$cname}','{$_SESSION['id']}')";
    $querycname=mysqli_query($conn,$sqlcname);
?>
<script>
window.location.href = "dashboard.php";
</script>
<?php
}
?>

<!-- Modal -->
<div class="modal fade" id="creatcompany" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #fd9292;">
            <div class="modal-header" style="background-color: #ffc2c2;">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create Company</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="cname" class="form-control" placeholder="Company Name"
                                    aria-label="Company Name" autocomplete="off">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" name="company_save" class="btn btn-primary" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>