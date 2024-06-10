<?php
if(isset($_POST['company_edit'])) {
    $cname=$_POST['editName'];
    $cemail=$_POST['editEmail'];
    $cphone=$_POST['editPhone'];
    $url=$_POST['editSite'];
    $cid=$_POST['editID'];
    $sqlup="UPDATE company_master SET
    `company_name`='{$cname}',
    `c_email`='{$cemail}',
    `c_phone`='{$cphone}',
    `c_website`='{$url}'
    WHERE `company_id`='{$cid}'";
$query=mysqli_query($conn,$sqlup);
?>
<script type="text/javascript">
window.location.href="company_management.php";
</script>
<?php
}
?>

<div class="modal fade" id="editCompany" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #fd9292;">
            <div class="modal-header" style="background-color: #ffc2c2;">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Company Detail</h1>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-12 p-1">
                                <label for="editName" class="form-label ms-2"><strong>Company Name</strong></label>
                                <input type="text" class="form-control" id="editName" name="editName">
                            </div>
                            <div class="col-md-12 p-1">
                                <label for="editEmail" class="form-label ms-2"><strong>Company Email</strong></label>
                                <input type="email" name="editEmail" class="form-control" id="editEmail">
                            </div>

                            <div class="col-md-12 p-1">
                                <label for="editPhone" class="form-label ms-2"><strong>Contact Info.</strong></label>
                                <input type="text" name="editPhone" class="form-control" id="editPhone">
                            </div>
                            <div class="col-md-12 p-1">
                                <label for="editSite" class="form-label ms-2"><strong>Company Website</strong></label>
                                <input type="url" name="editSite" class="form-control" aria-label="url"
                                    placeholder="https://example.com" pattern="https://.*" id="editSite">
                            </div>
                        </div>
                        <input type="hidden" id="editID" name="editID">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="company_edit" class="btn btn-primary">Update</button>
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
// Update modal content when Edit button is clicked
$(document).ready(function() {
    $('#editCompany').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var email = button.data('email');
        var phone = button.data('phone');
        var site = button.data('site');

        var modal = $(this);
        // modal.find('.modal-title').text('Edit Item ' + id);
        modal.find('#editID').val(id);
        modal.find('#editName').val(name);
        modal.find('#editEmail').val(email);
        modal.find('#editPhone').val(phone);
        modal.find('#editSite').val(site);
    });
});
</script>