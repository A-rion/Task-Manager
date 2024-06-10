<?php session_start();
include("conn.php");
if(!$_SESSION['id']){
?>
<script>
window.location.href = "index.php";
</script>
<?php
}
?>
<?php include("header.php"); ?>
<div class="band1 w-100">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h3 class="aemp">Administrator Access</h3>
</div>
<div class="p-3">
    <div class="border border-3 p-3" style="background-color: #fd9292;">
        <div class="row p-4">
            <nav class="navbar navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand"></a>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </nav>
        </div>
        <form class="p-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="30%">Name</th>
                    <th width="40%">Designation</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql_ad="SELECT manager.manager_name FROM manager
                INNER JOIN company_master ON manager.company_id=company_master.company_id
                WHERE company_master.admin_id='{$_SESSION['id']}'";
                $query_ad=mysqli_query($conn,$sql_ad);
                while($collect=mysqli_fetch_array($query_ad)) {
                ?>
                <tr>
                    <td><?php echo $collect['manager_name']; ?></td>
                    <td>Manager</td>
                    <td><button type="button" class="btn btn-outline-success"  style="font-size: 10px;"><strong>Grant Access</strong></button>&nbsp;|&nbsp;<button type="button" class="btn btn-outline-danger" style="font-size: 10px;"><strong>Access Revoke</strong></button></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        </form>
    </div>
</div>