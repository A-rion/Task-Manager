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
<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">Company Management</h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <div class="table-responsive smooth p-2" style="background-color: beige;">
            <table class="table table-striped-columns smooth cus-td p-2">
                <tr style="text-align: center;">
                    <th style="min-width: 100px;">Company Name</th>
                    <th style="min-width: 150px;">Company Email</th>
                    <th style="min-width: 120px;">Contact Number</th>
                    <th style="min-width: 200px;">Company Website</th>
                    <th style="min-width: 100px;">Action</th>
                </tr>
                <?php
                        $sqlcm="SELECT * FROM company_master WHERE admin_id='{$_SESSION['id']}'";
                        $querycm=mysqli_query($conn,$sqlcm);
                        while($fetchcm=mysqli_fetch_array($querycm)) {
                    ?>
                <tr style="text-align: center;">
                    <td><?php echo $fetchcm['company_name']; ?></td>
                    <td><?php echo $fetchcm['c_email']; ?></td>
                    <td><?php echo $fetchcm['c_phone']; ?></td>
                    <td><a style="text-decoration: none;" href="<?php echo $fetchcm['c_website']; ?>" target="_blank">
                            <?php echo $fetchcm['c_website']; ?></a></td>
                    <td>
                        <button style="font-size: 10px;" class="btn btn-outline-success" data-toggle="modal"
                            data-target="#editCompany" data-id="<?php echo $fetchcm['company_id']; ?>"
                            data-name="<?php echo $fetchcm['company_name']; ?>"
                            data-email="<?php echo $fetchcm['c_email']; ?>"
                            data-phone="<?php echo $fetchcm['c_phone']; ?>"
                            data-site="<?php echo $fetchcm['c_website']; ?>">Edit</button>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
<?php include("edit_company.php"); ?>
</body>

</html>