<?php session_start();
include("conn.php");
include("header.php");
include("pagination.php");
include("edit_bucket.php");
if(!$_SESSION['id']){
    ?>
<script>
window.location.href = "index.php";
</script>
<?php
    }
    ?>
<?php
$del_id=$_REQUEST['del_id'];
if($del_id){
  $sqld="DELETE FROM `bucket` WHERE `b_id`='{$del_id}'";
  $queryd=mysqli_query($conn,$sqld);
  ?>
<script>
window.history.replaceState({}, document.title, window.location.pathname);
</script>
<?php
}
?>
<?php
$sql7="SELECT bucket.*, company_master.company_name FROM `bucket`
INNER JOIN company_master ON bucket.company_id=company_master.company_id
INNER JOIN reg ON company_master.admin_id=reg.admin_id
WHERE reg.admin_id='{$_SESSION['id']}'";
$query7=mysqli_query($conn,$sql7);
?>
<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">Bucket List</h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <nav class="navbar navbar-light bg-light smooth mb-3">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" id="bucketXsearch" name="b_search"
                        placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success">Clear</button>
                </form>
            </div>
        </nav>
        <div class="table-responsive smooth p-2" style="background-color: beige;">
            <table id="bucketTable" class="table table-striped-columns smooth cus-td p-2">
                <thead>
                    <tr class="cus-td">
                        <th>Bucket</th>
                        <th>Bucket Creator</th>
                        <th style="min-width: 200px;">Company Name</th>
                        <th style="min-width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($cont7=mysqli_fetch_array($query7)) {?>
                    <tr>
                        <td><?php echo $cont7['bucket_name']; ?></td>
                        <td><?php echo $cont7['b_fname']; ?></td>
                        <td><?php echo $cont7['company_name']; ?></td>
                        <td>
                            <button style="font-size: 10px;" class="btn btn-outline-success" data-toggle="modal"
                                data-target="#editBucket" data-id="<?php echo $cont7['b_id']; ?>"
                                data-name="<?php echo $cont7['bucket_name']; ?>">Edit</button>
                            &nbsp;|&nbsp;
                            <a style="text-decoration: none;"
                                href="bucket.php?del_id=<?php echo $cont7['b_id']; ?>"><button type="submit"
                                    name="backet_del" class="btn btn-outline-danger"
                                    onClick='return confirm("Confirm to Delete the listed Bucket.")'
                                    style="font-size: 10px;">Delete</button></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // Initialize DataTables
    var table = $('#bucketTable').DataTable({
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

    // Apply date filtering when the input value changes
    $('#bucketXsearch').on('keyup change', function() {
        // Filter table data on input value change
        table.columns(0).search($(this).val()).draw();
    });
});
</script>
</body>

</html>