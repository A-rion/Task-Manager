<?php
if(isset($_POST['attendance_edit'])) {
    $Time=$_POST['editTime'];
    $Timeout=$_POST['editTimeout'];
    $Status=$_POST['editStatus'];
    $a_ID=$_POST['editID'];
    $sqlup="UPDATE attendance SET
    `a_time`='{$Time}',
    `a_timeout`='{$Timeout}',
    `a_status`='{$Status}'
    WHERE `a_id`='{$a_ID}'";
$query=mysqli_query($conn,$sqlup);
echo '<script>
        window.location = window.location;
    </script>';
}
?>

<div class="modal fade" id="editAttendance" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #fd9292;">
            <div class="modal-header" style="background-color: #ffc2c2;">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Attendance</h1>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-12 p-1">
                                <label for="editTime" class="form-label ms-2"><strong>Punch In</strong></label>
                                <input type="text" class="form-control timepicker" id="editTime" name="editTime"
                                    data-enable-time="true" data-no-calendar="true" data-date-format="h:i K">
                            </div>
                            <div class="col-md-12 p-1">
                                <label for="editTimeout" class="form-label ms-2"><strong>Punch Out</strong></label>
                                <input type="text" name="editTimeout" class="form-control timepicker" id="editTimeout"
                                    data-enable-time="true" data-no-calendar="true" data-date-format="h:i K">
                            </div>

                            <div class="col-md-12 p-1">
                                <label for="editStatus" class="form-label ms-2"><strong>Status</strong></label>
                                <select id="editStatus" class="form-control" aria-label="Default select example"
                                    name="editStatus">
                                    <option value="Absent">Absent</option>
                                    <option value="Present">Present</option>
                                    <option value="Leave">Leave</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="editID" name="editID">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="attendance_edit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Include Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include flatpickr JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Use jQuery's noConflict() method to avoid conflicts
    var $j = jQuery.noConflict();

    // Update modal content when Edit button is clicked
    $j(document).ready(function() {
        $j('#editAttendance').on('show.bs.modal', function(event) {
            var button = $j(event.relatedTarget);
            var id = button.data('id');
            var time = button.data('time');
            var timeout = button.data('timeout');
            var status = button.data('status');

            var modal = $j(this);
            modal.find('#editID').val(id);
            
            // Initialize flatpickr for time inputs
            var editTimePicker = flatpickr('#editTime', {
                enableTime: true,
                noCalendar: true,
                dateFormat: "h:i K",
                enableSeconds: true,
                time_24hr: false,
                touchUi: true
            });

            var editTimeoutPicker = flatpickr('#editTimeout', {
                enableTime: true,
                noCalendar: true,
                dateFormat: "h:i K",
                enableSeconds: true,
                time_24hr: false,
                touchUi: true
            });

            // Set the values
            editTimePicker.setDate(time, true);
            editTimeoutPicker.setDate(timeout, true);

            // Set the selected option for the editStatus select element
            modal.find('#editStatus option[value="' + status + '"]').prop('selected', true);
        });
    });
</script>
