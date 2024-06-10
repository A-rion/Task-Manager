<?php
if(isset($_POST['bucket_save'])){
    $bucket=$_POST['bucket'];
    $cname=$_POST['cname'];
    $sql="INSERT INTO `bucket` (`company_id`,`b_fname`,`bucket_name`) VALUES ('{$cname}','{$_SESSION['name']}','{$bucket}')";
    $query=mysqli_query($conn,$sql);
    echo '<script>
            window.location = window.location;
        </script>';
  }
?>

<!-- Modal -->
<div class="modal fade" id="addbucket" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #fd9292;">
            <div class="modal-header" style="background-color: #ffc2c2;">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Bucket</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form method="post">
                        <div class="row">
                            <?php
                            $sqlcb="SELECT `company_name`, `company_id` FROM `company_master` WHERE `admin_id`='{$_SESSION['id']}'";
                            $querycb=mysqli_query($conn,$sqlcb);
                            ?>
                            <div class="col-md-12 p-2">
                                <select class="form-select" aria-label="Default select example" name="cname" required>
                                    <option selected disabled>Company Name</option>
                                    <?php while($fetch=mysqli_fetch_array($querycb)) {?>
                                    <option value="<?php echo $fetch['company_id']; ?>">
                                        <?php echo $fetch['company_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-12 p-2">
                                <input type="text" name="bucket" class="form-control" placeholder="Bucket Name" aria-label="Bucket Name" autocomplete="off">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" name="bucket_save" class="btn btn-primary" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>