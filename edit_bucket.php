<?php
if(isset($_POST['bucket_edit'])) {
    $editID=$_POST['editID'];
    $editName=$_POST['editName'];
    $sql_b="UPDATE `bucket` SET `bucket_name`='{$editName}' WHERE `b_id`='{$editID}'";
    $query_b=mysqli_query($conn,$sql_b);
?>
<script>
    window.location.href="bucket.php";
</script>
<?php
}
?>

<div class="modal fade" id="editBucket" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: #fd9292;">
            <div class="modal-header" style="background-color: #ffc2c2;">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Bucket</h1>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-12 p-2">
                                <input type="text" class="form-control" id="editName" name="editName">
                            </div>
                        </div>
                        <input type="hidden" id="editID" name="editID">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="bucket_edit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
// Use jQuery's noConflict() method to avoid conflicts
var $j = jQuery.noConflict();
// Update modal content when Edit button is clicked
$j(document).ready(function() {
    $j('#editBucket').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');

        var modal = $(this);
        // modal.find('.modal-title').text('Edit Item ' + id);
        modal.find('#editID').val(id);
        modal.find('#editName').val(name);
    });
});
</script>