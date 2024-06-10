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
$closedu_id=$_REQUEST['closedu_id'];
if($closedu_id){
  $close_date=date('d-M-y');
  $sqld="UPDATE task SET status='close', close_by='{$_SESSION['assign']}', close_date='{$close_date}' WHERE task_id='{$closedu_id}'";
  $queryd=mysqli_query($conn,$sqld);
  ?>
<script>
window.history.replaceState({}, document.title, window.location.pathname);
</script>
<?php
}
?>
<?php
    $openid=$_REQUEST['openid'];
    if($openid){
        $sqlopen="SELECT task.*, bucket.bucket_name, reg.admin_name, manager.manager_name, assistant.assistant_name, employee.employee_name
        FROM task
        INNER JOIN bucket ON task.t_bucket = bucket.b_id
        LEFT JOIN reg ON task.assign_by = reg.assign_id
        LEFT JOIN manager ON task.assign_by = manager.assign_id
        LEFT JOIN assistant ON task.assign_by = assistant.assign_id
        LEFT JOIN employee ON task.assign_by = employee.assign_id
        WHERE task.assign_to = '{$openid}'".$search." ORDER BY task_id DESC";
        $queryopen=mysqli_query($conn,$sqlopen);
    }
?>

<?php
if($openid) {
    $sqlall="SELECT admin_name AS name FROM reg WHERE assign_id='{$openid}'
    UNION
    SELECT manager_name AS name FROM manager WHERE assign_id='{$openid}'
    UNION
    SELECT assistant_name AS name FROM assistant WHERE assign_id='{$openid}'
    UNION
    SELECT employee_name AS name FROM employee WHERE assign_id='{$openid}'";
    $queryall=mysqli_query($conn,$sqlall);
    $fetchall=mysqli_fetch_array($queryall);
}
?>
<div class="band1 w-100 mt-2" style="z-index: -1;">
    <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
    <h4 class="aemp">
        <?php echo $fetchall['name']; ?>
    </h4>
</div>
<div class="border border-3 smooth p-2" style="background-color: #fd9292;">
    <div class="p-2">
        <nav class="navbar navbar-light bg-light smooth mb-3">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" id="search-input" name="task_search"
                        placeholder="Search By Name" aria-label="Search" autocomplete="off">
                    <button class="btn btn-outline-success">Clear</button>
                </form>
            </div>
        </nav>
        <div class="table-responsive smooth">
            <table class="table table-striped-columns cus-td" method="post">
                <thead>
                    <tr class="cus-td">
                        <th style="font-size: 12px; min-width: 140px;">Assigned By</th>
                        <th style="font-size: 12px; min-width: 250px;">Task Summery</th>
                        <th style="font-size: 12px;">Bucket</th>
                        <th style="min-width: 100px; font-size: 12px;">Assign Date</th>
                        <th style="min-width: 100px; font-size: 12px;">Due Date</th>
                        <th style="font-size: 12px;">Status</th>
                        <th style="font-size: 12px;">Priority</th>
                        <th style="font-size: 12px;">Task Health</th>
                        <th style="font-size: 12px;">Document</th>
                        <th style="font-size: 12px;">Close Task</th>
                    </tr>
                </thead>
                <tbody id="load-all-task">

                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    function loadAllTask(assgin, search) {
        $.ajax({
            url: './task.php',
            type: 'POST',
            data: {
                'action': 'loadAllTask',
                'assgin': assgin,
                'search': search
            },
            success: function(resp) {
                $('#load-all-task').html('');
                $('#load-all-task').html(resp);
            }
        });
    }

    // Call loadAllTask with an empty search initially
    loadAllTask('<?= base64_encode($_GET['openid']) ?>', '');

    // Add an event listener for the search input field
    $('#search-input').on('input', function() {
        var searchValue = $(this).val();
        loadAllTask('<?= base64_encode($_GET['openid']) ?>', searchValue);
    });


    $(document).on('click', '.closeTaskBtn', function() {
        if (confirm(`Confirm to Close This Task.`) == true) {
            let close_task = $(this).attr('data-close');
            if (close_task) {
                $.ajax({
                    url: './task.php',
                    type: 'POST',
                    data: {
                        'action': 'closeTaks',
                        closk_task: close_task
                    },
                    dataType: 'json',
                    success: function(resp) {
                        if (resp.status == 'success') {
                            loadAllTask('<?= base64_encode($_GET['openid']) ?>')
                        } else {
                            alert(resp.message)
                        }
                    }
                })
            }
        }

    })
})
</script>