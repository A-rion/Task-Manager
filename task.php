<?php session_start();
include ("conn.php");

date_default_timezone_set('Asia/Kolkata');

if($_POST['action'] == 'loadUpperDesignation'){
    $output = '';
    if($_POST['type'] == 'assistant_manager'){
        $sqle="SELECT manager.manager_name, manager.manager_id FROM `manager`
        INNER JOIN company_master ON manager.company_id=company_master.company_id
        INNER JOIN reg ON company_master.admin_id=reg.admin_id
        WHERE reg.admin_id='{$_SESSION['id']}' AND  manager.manager_status='1'";
        $querye=mysqli_query($conn,$sqle);
        $count=mysqli_num_rows($querye);
        if($count>0){
            $output .= '<div class="col-md-12">
            <label class="form-label ms-2"><strong>Manager Name</strong></label>
            <select class="form-select" name="upper-designation" required>
                <option selected disabled>Manager Name</option>';
                while($fetch11=mysqli_fetch_array($querye)) {
                $output .= '<option value="'.$fetch11['manager_id'].'">'.$fetch11['manager_name'].'</option>';
                } 
            $output .= '</select>
        </div>';
        }


    }else if($_POST['type'] == 'employee'){
        $sqle="SELECT assistant.assistant_name, assistant.assistant_id FROM `assistant`
        INNER JOIN company_master ON assistant.company_id=company_master.company_id
        INNER JOIN reg ON company_master.admin_id=reg.admin_id
        WHERE reg.admin_id='{$_SESSION['id']}' AND assistant.assistant_status='1'";
        $querye=mysqli_query($conn,$sqle);
        $count=mysqli_num_rows($querye);
        if($count>0){
            $output .= '<div class="col-md-12">
            <label class="form-label ms-2"><strong>Assistant Manager Name</strong></label>
            <select class="form-select" name="upper-designation" required>
                <option selected disabled>Assistant Manager Name</option>';
                while($fetch11=mysqli_fetch_array($querye)) {
                $output .= '<option value="'.$fetch11['assistant_id'].'">'.$fetch11['assistant_name'].'</option>';
                } 
            $output .= '</select>
        </div>';
        }
    }
    echo $output;
}

if ($_POST['action'] == 'getUsers') {
    // Assuming you have a database connection ($conn)
    $managerUsers = fetchUsersFromTable($conn);

    $allUsers = array_merge($managerUsers);

    // Send JSON response
    echo json_encode($allUsers);
}

if ($_POST['action'] == 'loadChart') {
    $assign_id = $_POST['assign_id'];

    $open_task = "SELECT COUNT(1) as 'task', 'open_task' as 'status' FROM task WHERE assign_to='{$assign_id}' AND due_date >= 'date(`d-M-y`)' AND status='open'";
    $query_open_task = mysqli_query($conn, $open_task);
    $data4 = array();

    if ($query_open_task->num_rows > 0) {
        while ($row = $query_open_task->fetch_assoc()) {
            $data4[] = $row;
        }
    }

    $late_task = "SELECT COUNT(1) as 'task', 'late_task' as 'status' FROM task WHERE assign_to='{$assign_id}' AND due_date < 'date(`d-M-y`)' AND status='open'";
    $query_late_task = mysqli_query($conn, $late_task);
    $data1 = array();

    if ($query_late_task->num_rows > 0) {
        while ($row = $query_late_task->fetch_assoc()) {
            $data1[] = $row;
        }
    }
    
    $close_task = "SELECT COUNT(1) AS 'task', 'close_task' AS 'status'
    FROM task
    WHERE assign_to = '{$assign_id}' 
    AND STR_TO_DATE(due_date, '%d-%b-%y') >= STR_TO_DATE(close_date, '%d-%b-%y')
    AND status = 'close'";
    $query_close_task = mysqli_query($conn, $close_task);
    $data2 = array();

    if ($query_close_task->num_rows > 0) {
        while ($row = $query_close_task->fetch_assoc()) {
            $data2[] = $row;
        }
    }


    $late_close = "SELECT COUNT(1) AS 'task', 'late_close' AS 'status' 
    FROM task 
    WHERE assign_to='{$assign_id}' 
    AND STR_TO_DATE(due_date, '%d-%b-%y') < STR_TO_DATE(close_date, '%d-%b-%y') 
    AND status='close'";
    $query_late_close = mysqli_query($conn, $late_close);
    $data3 = array();

    if ($query_late_close->num_rows > 0) {
        while ($row = $query_late_close->fetch_assoc()) {
            $data3[] = $row;
        }
    }

    // Send JSON response
    $response = array(
        'assign_id' => $assign_id,
        'open_task' => $data4,
        'late_task' => $data1,
        'close_task' => $data2,
        'late_close' => $data3
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function fetchUsersFromTable($conn, $tableName='') {
    
    $query = "SELECT DISTINCT `assign_to` FROM `task`";
    $result = mysqli_query($conn, $query);

    $users = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    return $users;
}

if($_POST['action']  == 'loadAllTask'){
    $output = '';
    $search = "";
    $assginI = base64_decode($_POST['assgin']);
    if (isset($_POST['search'])) {
        $task_search = $_POST['search'];
        $search = " AND (reg.admin_name LIKE '%$task_search%' OR manager.manager_name LIKE '%$task_search%' OR assistant.assistant_name LIKE '%$task_search%' OR employee.employee_name LIKE '%$task_search%')";
    }
    $sqlopen="SELECT task.*, bucket.bucket_name, reg.admin_name, reg_close.admin_name AS close_admin, manager.manager_name, manager_close.manager_name AS close_manager, assistant.assistant_name, assistant_close.assistant_name AS close_assistant, employee.employee_name, employee_close.employee_name AS close_employee 
    FROM task
    INNER JOIN bucket ON task.t_bucket = bucket.b_id
    LEFT JOIN reg ON task.assign_by = reg.assign_id
    LEFT JOIN reg AS reg_close ON task.close_by = reg_close.assign_id
    LEFT JOIN manager ON task.assign_by = manager.assign_id
    LEFT JOIN manager AS manager_close ON task.close_by = manager_close.assign_id
    LEFT JOIN assistant ON task.assign_by = assistant.assign_id
    LEFT JOIN assistant AS assistant_close ON task.close_by = assistant_close.assign_id
    LEFT JOIN employee ON task.assign_by = employee.assign_id
    LEFT JOIN employee AS employee_close ON task.close_by = employee_close.assign_id
    WHERE task.assign_to = '{$assginI}' ".$search." ORDER BY task_id DESC";
        $queryopen=mysqli_query($conn,$sqlopen);

        
            while($fetchopen=mysqli_fetch_array($queryopen)) {
                $health = '';
                $status = '';
                $currentDate = new DateTime();
                    $dueDate = new DateTime($fetchopen['due_date']);
                    if ($currentDate > $dueDate && $fetchopen['status']=="open") {
                        $health .= '<span class="fr"></span>';
                    } else {
                        $health .= '<span class="fr5"></span>';
                    }
                    if($fetchopen['status']=='open') { 
                        $status .= '
                        <a class="closeTaskBtn" data-close="'.base64_encode($fetchopen['task_id']).'">
                        <img src="assets/images/logos/icons8-close.gif" class="image" style="border-radius: 50%;">
                        </a>';
                         } else { 
                        $status .= '<div class="tooltip"><a href="#!">
                        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                        </a>
                        <span class="tooltiptext">
                        <h6>
                        '.$fetchopen['close_admin'].'
                        '.$fetchopen['close_manager'].'
                        '.$fetchopen['close_assistant'].'
                        '.$fetchopen['close_employee'].'
                        </h6>
                        '.$fetchopen['close_date'].'
                        </span>
                      </div>';
                         } 
            
            $output .= '<tr>
                <td>
                    '.$fetchopen['admin_name'].'
                    '.$fetchopen['manager_name'].'
                    '.$fetchopen['assistant_name'].'
                    '.$fetchopen['employee_name'].'
                </td>
                <td>'.$fetchopen['t_about'].'</td>
                <td>'.$fetchopen['bucket_name'].'</td>
                <td>'.$fetchopen['assign_date'].'</td>
                <td>'.$fetchopen['due_date'].'</td>
                <td>'.$fetchopen['status'].'</td>
                <td>'.$fetchopen['t_priority'].'</td>
                <td>'.$health.'</td>
                <td>
                    <a href="./uploads/'.$fetchopen['t_file'].'" download><img
                            src="assets/images/logos/icons8-download.gif" class="image"></a>
                </td>
                <td>
                     '.$status.'
                </td>
            </tr>';
            } 

            echo $output;
} 

if($_POST['action'] == 'closeTaks'){
    $closeTask = base64_decode($_POST['closk_task']);
    $close_date=date('d-M-y');
    $sqld="UPDATE task SET status='close', close_by='{$_SESSION['assign']}', close_date='{$close_date}' WHERE task_id='{$closeTask}'";
    $queryd=mysqli_query($conn,$sqld);
    if($queryd){
        $output = array('status'=> 'success','message' => 'Task closed');
    }else{
        $output = array('status'=> 'success','message' => 'Task not close');
    }
    echo json_encode($output);
}

if($_POST['action'] == 'loadDashboardTable'){

    if (isset($_REQUEST['employeename'])) {
        $assign_search_text = $_REQUEST['employeename'];
        $ad_search = " AND (reg.admin_name LIKE '%$assign_search_text%')";
        $e_search = " AND (employee.employee_name LIKE '%$assign_search_text%')";
        $m_search = " AND (manager.manager_name LIKE '%$assign_search_text%')";
        $a_search = " AND (assistant.assistant_name LIKE '%$assign_search_text%')";
    }
    
    $output = '<table class="table table-bordered">
    <thead style="text-align: center; vertical-align: middle;">
        <tr>
            <th scope="col">Assigned To</th>
            <th scope="col">Health</th>
            <th scope="col">Bucket Name</th>
            <th scope="col" style="min-width: 250px;">Task</th>
            <th scope="col" style="min-width: 110px;">Assign Date</th>
            <th scope="col" style="min-width: 110px;">Due Date</th>
            <th scope="col">Priority</th>
            <th scope="col">Status</th>
            <th scope="col">Close Task</th>
            <th scope="col">Attachment</th>
            <th scope="col">Assigned By</th>
        </tr>
    </thead>';

    if($_SESSION['role']=='admin') {
        $link3="SELECT DISTINCT reg.assign_id, reg.admin_name FROM task
        INNER JOIN reg ON task.assign_to=reg.assign_id
        WHERE reg.admin_id='{$_SESSION['id']}'".$ad_search;
        $take3=mysqli_query($conn,$link3);
        while($give3=mysqli_fetch_array($take3)) {
            $sublink3="SELECT 
            task.*, 
            bucket.bucket_name, 
            reg_assign.admin_name AS admin_name, 
            reg_close.admin_name AS close_admin_name
            FROM 
            task
            INNER JOIN 
            bucket ON task.t_bucket = bucket.b_id
            LEFT JOIN 
            reg AS reg_assign ON task.assign_by = reg_assign.assign_id
            LEFT JOIN 
            reg AS reg_close ON task.close_by = reg_close.assign_id
            WHERE 
            task.assign_to = '{$give3['assign_id']}' ORDER BY task_id DESC LIMIT 3";
            $subtake3=mysqli_query($conn,$sublink3);
            $output .= '<tbody style="vertical-align: middle;">
            <tr>
                <td class="mytasktd" style="border-bottom: 0px;" rowspan="3">
                    <div class="mytask" style="width: 250px; height: 300px;">
                        <div class="task-pr">
                            <span>'.$give3['admin_name'].'</span>
                        </div>
                        <div style="height: 300px;" id="chartdiv_'.$give3['assign_id'].'" class="chart-container">
                            <div class="loading-spinner-container">
                                <div class="loading-spinner"></div>
                            </div>
                        </div>
                        <a style="text-decoration: none; color: black;"
                            href="user_dashboard.php?openid='.$give3['assign_id'].'">
                            <span class="pull-right xtp zoom">
                                <span class="xt bl">Show All Tasks</span>
                            </span>
                        </a>
                    </div>
                    <input type="hidden" id="chartNo'.$give3['assign_id'].'" class="chartNo" value="'.$give3['assign_id'].'">
                </td>';
                
                
                 while($subgive3=mysqli_fetch_array($subtake3)) {
                 $currentDate3 = new DateTime();
                 $dueDate3 = new DateTime($subgive3['due_date']);
                 $output4 = '';
                 if ($currentDate3 > $dueDate3 && $subgive3['status']=="open") {
                     $output4 .= '<span class="fr"></span>';
                 } else {
                     $output4 .= '<span class="fr5"></span>';
                 }
                 $taskstatus3 = '';
                  if($subgive3['status']=='open') { 
                    $taskstatus3 .= '<a href="dashboard.php?closed_id='.$subgive3['task_id'].'"
                        onClick="return confirm(`Confirm to Close This Task.`)">
                        <img src="assets/images/logos/icons8-close.gif" class="image zoom">
                    </a>';
                     } else { 
                    $taskstatus3 .= '<div class="tooltip"><a href="#!">
                    <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                    </a>
                    <span class="tooltiptext">
                    <h6>
                    '.$subgive3['close_admin_name'].'
                    </h6>
                    '.$subgive3['close_date'].'
                    </span>
                  </div>';
                     }

                 $closetask3 = $subgive3['status']=='close' ? "closed-task" : '';
                $output .= '
                <td class="text-center zoomT">
                    <span class="'.$closetask3.'">'.$output4.'</span>
                </td>
        
                <td class="text-center zoomT">
                    <span class="'.$closetask3.'">'.$subgive3['bucket_name'].'</span>
                </td>
                <td style="position: relative;">
                <span class="'.$closetask3.'">'.$subgive3['t_about'].'</span>
                </td>
                <td class="text-center zoomT">
                    <span class="'.$closetask3.'">'.$subgive3['assign_date'].'</span>
                </td>
                <td class="text-center zoomT">
                    <span class="'.$closetask3.'">'.$subgive3['due_date'].'</span>
                </td>
                <td class="text-center zoomT">
                    <span class="'.$closetask3.'">'.$subgive3['t_priority'].'</span>
                </td>
                <td class="text-center zoomT">
                    <span class="'.$closetask3.'">'.$subgive3['status'].'</span>
                </td>
                <td class="text-center">
                '.$taskstatus3.'
                </td>
                <td class="text-center">
                    <a style="text-decoration: none;" href="./uploads/'.$subgive3['t_file'].'" download="'.$give3['admin_name'].'-Task">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-paperclip zoom" viewBox="0 0 16 16">
                    <title>'.$subgive3['t_file'].'</title>
                    <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/>
                    </svg>
                    </a>
                </td>
                <td class="text-center zoomT">
                <span class="'.$closetask3.'">'.$subgive3['admin_name'].'</span>
                </td>
            </tr>';
                    }
                
        $output .= '</tbody>
        <tr class="frs1">
            <td colspan="12">
        <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="w-100" style="height: 3px;">
        </td>
        </tr>';
                }
        $link="SELECT DISTINCT manager.assign_id, manager.manager_name, manager.manager_status FROM task
        INNER JOIN manager ON task.assign_to=manager.assign_id
        INNER JOIN company_master ON manager.company_id=company_master.company_id
        WHERE company_master.admin_id='{$_SESSION['id']}'".$m_search;
        $take=mysqli_query($conn,$link);
        while($give=mysqli_fetch_array($take)) {
            $sublink="SELECT 
            task.*, 
            bucket.bucket_name, 
            reg_assign.admin_name AS admin_name, 
            manager_assign.manager_name AS manager_name,
            reg_close.admin_name AS close_admin_name,
            manager_close.manager_name AS close_manager_name
        FROM 
            task
        INNER JOIN 
            bucket ON task.t_bucket = bucket.b_id
        LEFT JOIN 
            reg AS reg_assign ON task.assign_by = reg_assign.assign_id
        LEFT JOIN 
            manager AS manager_assign ON task.assign_by = manager_assign.assign_id
        LEFT JOIN 
            reg AS reg_close ON task.close_by = reg_close.assign_id
        LEFT JOIN 
            manager AS manager_close ON task.close_by = manager_close.assign_id
        WHERE 
            task.assign_to = '{$give['assign_id']}' ORDER BY task_id DESC LIMIT 3";
            $subtake=mysqli_query($conn,$sublink);

            $rowBackgroundColor = ($give['manager_status'] == '0') ? 'background-color: #ff9999;' : '';
            $output .= '<tbody style="vertical-align: middle; ' . $rowBackgroundColor . '">
            <tr>
                <td class="mytasktd" style="border-bottom: 0px; ' . $rowBackgroundColor . '" rowspan="3">
                    <div class="mytask" style="width: 250px; height: 300px;">
                        <div class="task-pr">
                            <span>'.$give['manager_name'].'</span>
                        </div>
                        <div style="height: 300px;" id="chartdiv_'.$give['assign_id'].'" class="chart-container">
                            <div class="loading-spinner-container">
                                <div class="loading-spinner"></div>
                            </div>
                        </div>
                        <a style="text-decoration: none; color: black;"
                            href="user_dashboard.php?openid='.$give['assign_id'].'">
                            <span class="pull-right xtp zoom">
                                <span class="xt bl">Show All Tasks</span>
                            </span>
                        </a>
                    </div>
                    <input type="hidden" id="chartNo'.$give['assign_id'].'" class="chartNo" value="'.$give['assign_id'].'">
                </td>';
                
                
                 while($subgive=mysqli_fetch_array($subtake)) {
                 $currentDate = new DateTime();
                 $dueDate = new DateTime($subgive['due_date']);
                 $output1 = '';
                 if ($currentDate > $dueDate && $subgive['status']=="open") {
                     $output1 .= '<span class="fr"></span>';
                 } else {
                     $output1 .= '<span class="fr5"></span>';
                 }
                 $taskstatus = '';
                  if($subgive['status']=='open') { 
                    $taskstatus .= '<a href="dashboard.php?closed_id='.$subgive['task_id'].'"
                        onClick="return confirm(`Confirm to Close This Task.`)">
                        <img src="assets/images/logos/icons8-close.gif" class="image zoom">
                    </a>';
                     } else { 
                    $taskstatus .= '<div class="tooltip"><a href="#!">
                    <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                    </a>
                    <span class="tooltiptext">
                    <h6>
                    '.$subgive['close_admin_name'].'
                    '.$subgive['close_manager_name'].'
                    </h6>
                    '.$subgive['close_date'].'
                    </span>
                  </div>';
                     }

                 $closetask = $subgive['status']=='close' ? "closed-task" : '';
                $output .= '
                <td class="text-center zoomT" style="' . $rowBackgroundColor . '">
                        <span class="'.$closetask.'">'.$output1.'</span>
                </td>
        
                <td class="text-center zoomT" style=" ' . $rowBackgroundColor . '">
                        <span class="'.$closetask.'">'.$subgive['bucket_name'].'</span>
                </td>
                <td style="position: relative; ' . $rowBackgroundColor . '">
                    <span class="'.$closetask.'">'.$subgive['t_about'].'</span>
                </td>
                <td class="text-center zoomT" style=" ' . $rowBackgroundColor . '">
                        <span class="'.$closetask.'">'.$subgive['assign_date'].'</span>
                </td>
                <td class="text-center zoomT" style=" ' . $rowBackgroundColor . '">
                        <span class="'.$closetask.'">'.$subgive['due_date'].'</span>
                </td>
                <td class="text-center zoomT" style=" ' . $rowBackgroundColor . '">
                        <span class="'.$closetask.'">'.$subgive['t_priority'].'</span>
                </td>
                <td class="text-center zoomT" style=" ' . $rowBackgroundColor . '">
                        <span class="'.$closetask.'">'.$subgive['status'].'</span>
                </td>
                <td class="text-center" style=" ' . $rowBackgroundColor . '">
                '.$taskstatus.'
                </td>
                <td class="text-center" style=" ' . $rowBackgroundColor . '">
                    <a style="text-decoration: none;" href="./uploads/'.$subgive['t_file'].'" download="'.$give['manager_name'].'-Task">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-paperclip zoom" viewBox="0 0 16 16">
                    <title>'.$subgive['t_file'].'</title>
                    <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/>
                    </svg>
                    </a>
                </td>
                <td class="text-center zoomT" style=" ' . $rowBackgroundColor . '">
                 <span class="'.$closetask.'">'.$subgive['admin_name'].'
                 '.$subgive['manager_name'].'</span>
                </td>
            </tr>';
                    }
                
        $output .= '</tbody>
        <tr class="frs1">
            <td colspan="12">
        <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="w-100" style="height: 3px;">
        </td>
        </tr>';
                }
                $link1="SELECT DISTINCT assistant.assign_id, assistant.assistant_name, assistant.assistant_status FROM task
                INNER JOIN assistant ON task.assign_to=assistant.assign_id
                INNER JOIN company_master ON assistant.company_id=company_master.company_id
                WHERE company_master.admin_id='{$_SESSION['id']}'".$a_search;
                $take1=mysqli_query($conn,$link1);
                while($give1=mysqli_fetch_array($take1)) {
                    $sublink1="SELECT 
                    task.*, 
                    bucket.bucket_name, 
                    reg_assign.admin_name AS admin_name, 
                    manager_assign.manager_name AS manager_name,
                    assistant_assign.assistant_name AS assistant_name,
                    reg_close.admin_name AS close_admin_name,
                    manager_close.manager_name AS close_manager_name,
                    assistant_close.assistant_name AS close_assistant_name
                FROM 
                    task
                INNER JOIN 
                    bucket ON task.t_bucket = bucket.b_id
                LEFT JOIN 
                    reg AS reg_assign ON task.assign_by = reg_assign.assign_id
                LEFT JOIN 
                    manager AS manager_assign ON task.assign_by = manager_assign.assign_id
                LEFT JOIN 
                    assistant AS assistant_assign ON task.assign_by = assistant_assign.assign_id
                LEFT JOIN 
                    reg AS reg_close ON task.close_by = reg_close.assign_id
                LEFT JOIN 
                    manager AS manager_close ON task.close_by = manager_close.assign_id
                LEFT JOIN 
                    assistant AS assistant_close ON task.close_by = assistant_close.assign_id
                WHERE 
                    task.assign_to = '{$give1['assign_id']}' ORDER BY task_id DESC LIMIT 3";
                $subtake1=mysqli_query($conn,$sublink1);
                
                $rowaBackgroundColor = ($give1['assistant_status'] == '0') ? 'background-color: #ff9999;' : '';
                $output .= '<tbody style="vertical-align: middle; ' . $rowaBackgroundColor . '">
                    <tr>
                        <td class="mytasktd" style="border-bottom: 0px; '.$rowaBackgroundColor.'" rowspan="3">
                            <div class="mytask" style="width: 250px; height: 300px;">
                                <div class="task-pr">
                                    <span>'.$give1['assistant_name'].'</span>
                                </div>
                                <div style="height: 300px;" id="chartdiv_'.$give1['assign_id'].'" class="chart-container">
                                    <div class="loading-spinner-container">
                                        <div class="loading-spinner"></div>
                                    </div>
                                </div>
                                <a style="text-decoration: none; color: black;"
                                    href="user_dashboard.php?openid='.$give1['assign_id'].'">
                                    <span class="pull-right xtp zoom">
                                        <span class="xt bl">Show All Tasks</span>
                                    </span>
                                </a>
                            </div>
                            <input type="hidden" id="chartNo'.$give1['assign_id'].'" class="chartNo" value="'.$give1['assign_id'].'">
                        </td>';
                        while($subgive1=mysqli_fetch_array($subtake1)) {
                            $closeTask2 = $subgive1['status']=='close' ? "closed-task":"";
                            $output2 = '';
                            $currentDate1 = new DateTime();
                            $dueDate1 = new DateTime($subgive1['due_date']);
                            if ($currentDate1 > $dueDate1 && $subgive1['status']=="open") {
                               $output2 .= '<span class="fr"></span>';
                            } else {
                                $output2 .= '<span class="fr5"></span>';
                            }
                            $taskstatus ='';
                            if($subgive1['status']=='open') {
                                $taskstatus .= '<a href="dashboard.php?closed_id='.$subgive1['task_id'].'"
                                    onClick="return confirm(`Confirm to Close This Task.`)">
                                    <img src="assets/images/logos/icons8-close.gif" class="image zoom">
                                </a>';
                                } else {
                                $taskstatus .= '<div class="tooltip"><a href="#!">
                                <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                </a>
                                <span class="tooltiptext">
                                <h6>
                                '.$subgive1['close_admin_name'].'
                                '.$subgive1['close_manager_name'].'
                                '.$subgive1['close_assistant_name'].'
                                </h6>
                                '.$subgive1['close_date'].'
                                </span>
                              </div>';
                                }

                        $output .= '
                        <td class="text-center zoomT" style="'.$rowaBackgroundColor.'">
                                <span class="'.$closeTask2.'">'.$output2.'</span>
                        </td>

                        <td class="text-center zoomT" style="'.$rowaBackgroundColor.'">
                            <span class="'.$closeTask2.'">'.$subgive1['bucket_name'].'</span>
                        </td>
                        <td style="position: relative; '.$rowaBackgroundColor.'">
                            <span class="'.$closeTask2.'">'.$subgive1['t_about'].'</span>
                        </td>
                        <td class="text-center zoomT" style="'.$rowaBackgroundColor.'">
                            <span class="'.$closeTask2.'">'.$subgive1['assign_date'].'</span>
                        </td>
                        <td class="text-center zoomT" style="'.$rowaBackgroundColor.'">
                            <span class="'.$closeTask2.'">'.$subgive1['due_date'].'</span>
                        </td>
                        <td class="text-center zoomT" style="'.$rowaBackgroundColor.'">
                            <span class="'.$closeTask2.'">'.$subgive1['t_priority'].'</span>
                        </td>
                        <td class="text-center zoomT" style="'.$rowaBackgroundColor.'">
                            <div class="zoom">
                            <span class="'.$closeTask2.'">'.$subgive1['status'].'</span>
                        </td>
                        <td class="text-center" style="'.$rowaBackgroundColor.'">
                        '.$taskstatus.'
                        </td>
                        <td class="text-center" style="'.$rowaBackgroundColor.'">
                            <a style="text-decoration: none;" href="./uploads/'.$subgive1['t_file'].'" download="'.$give1['assistant_name'].'-Task">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-paperclip zoom" viewBox="0 0 16 16">
                                <title>'.$subgive1['t_file'].'</title>
                                <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/>
                                </svg>    
                            </a>
                        </td>
                        <td class="text-center zoomT" style="'.$rowaBackgroundColor.'">
                            <span class="'.$closeTask2.'">
                                '.$subgive1['admin_name'].'
                                '.$subgive1['manager_name'].'
                                '.$subgive1['assistant_name'].'
                            </span>
                        </td>
                    </tr>';
                    } 
                $output .= '</tbody>
                <tr class="frs1">
                    <td colspan="12">
                        <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="w-100"
                            style="height: 3px;">
                    </td>
                </tr>';
                 } 


        $link2="SELECT DISTINCT employee.assign_id, employee.employee_name, employee.employee_status FROM task
        INNER JOIN employee ON task.assign_to=employee.assign_id
        INNER JOIN company_master ON employee.company_id=company_master.company_id
        WHERE company_master.admin_id='{$_SESSION['id']}'".$e_search;
        $take2=mysqli_query($conn,$link2);
        while($give2=mysqli_fetch_array($take2)) {
        $sublink2="SELECT 
        task.*, 
        bucket.bucket_name, 
        reg_assign.admin_name AS admin_name, 
        manager_assign.manager_name AS manager_name,
        assistant_assign.assistant_name AS assistant_name,
        employee_assign.employee_name AS employee_name,
        reg_close.admin_name AS close_admin_name,
        manager_close.manager_name AS close_manager_name,
        assistant_close.assistant_name AS close_assistant_name,
        employee_close.employee_name AS close_employee_name
        FROM 
        task
        INNER JOIN 
        bucket ON task.t_bucket = bucket.b_id
        LEFT JOIN 
        reg AS reg_assign ON task.assign_by = reg_assign.assign_id
        LEFT JOIN 
        manager AS manager_assign ON task.assign_by = manager_assign.assign_id
        LEFT JOIN 
        assistant AS assistant_assign ON task.assign_by = assistant_assign.assign_id
        LEFT JOIN 
        employee AS employee_assign ON task.assign_by = employee_assign.assign_id
        LEFT JOIN 
        reg AS reg_close ON task.close_by = reg_close.assign_id
        LEFT JOIN 
        manager AS manager_close ON task.close_by = manager_close.assign_id
        LEFT JOIN 
        assistant AS assistant_close ON task.close_by = assistant_close.assign_id
        LEFT JOIN 
        employee AS employee_close ON task.close_by = employee_close.assign_id
        WHERE 
        task.assign_to = '{$give2['assign_id']}' ORDER BY task_id DESC LIMIT 3";
        $subtake2=mysqli_query($conn,$sublink2);
        $roweBackgroundColor = ($give2['employee_status'] == '0') ? 'background-color: #ff9999;' : '';
        $output .= '<tbody style="vertical-align: middle; '.$roweBackgroundColor.'">
        <tr>
            <td class="mytasktd" style="border-bottom: 0px; '.$roweBackgroundColor.'" rowspan="3">
                <div class="mytask" style="width: 250px; height: 300px;">
                    <div class="task-pr">
                        <span>'.$give2['employee_name'].'</span>
                    </div>
                    <div style="height: 300px;" id="chartdiv_'.$give2['assign_id'].'" class="chart-container">
                        <div class="loading-spinner-container">
                            <div class="loading-spinner"></div>
                        </div>
                    </div>
                    <input id="TaskChart5299" class="ChartClassmy" type="hidden" value="5299">
                    <a style="text-decoration: none; color: black;"
                        href="user_dashboard.php?openid='.$give2['assign_id'].'">
                        <span class="pull-right xtp zoom">
                            <span class="xt bl">Show All Tasks</span>
                        </span>
                    </a>
                </div>
                <input type="hidden" id="chartNo'.$give2['assign_id'].'" class="chartNo" value="'.$give2['assign_id'].'">
            </td>';
            
        while($subgive2=mysqli_fetch_array($subtake2)) {

        $closeTask3 = $subgive2['status']=='close' ? "closed-task" : "";
        $currentDate2 = new DateTime();
        $dueDate2 = new DateTime($subgive2['due_date']);
        $output3 ='';
        if ($currentDate2 > $dueDate2 && $subgive2['status']=="open") {
        $output3 .= '<span class="fr"></span>';
        } else {
        $output3 .= '<span class="fr5"></span>';
        }
        $taskstatus = '';
        if($subgive2['status']=='open') {
        $taskstatus .= '<a href="dashboard.php?closed_id='.$subgive2['task_id'].'"
            onClick="return confirm(`Confirm to Close This Task.`)">
            <img src="assets/images/logos/icons8-close.gif" class="image zoom">
        </a>';
        } else {
        $taskstatus .= '<div class="tooltip"><a href="#!">
        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
        </a>
        <span class="tooltiptext">
        <h6>
        '.$subgive2['close_admin_name'].'
        '.$subgive2['close_manager_name'].'
        '.$subgive2['close_assistant_name'].'
        '.$subgive2['close_employee_name'].'
        </h6>
        '.$subgive2['close_date'].'
        </span>
      </div>';
        }
        $output .= '
        <td class="text-center zoomT">
                <span class="'.$closeTask3.'">'.$output3.'</span>
        </td>

        <td class="text-center zoomT" style="'.$roweBackgroundColor.'">
            <span class="'.$closeTask3.'">'.$subgive2['bucket_name'].'</span>
        </td>
        <td style="position: relative; '.$roweBackgroundColor.'">
        <span class="'.$closeTask3.'">'.$subgive2['t_about'].'</span>
        </td>
        <td class="text-center zoomT" style="'.$roweBackgroundColor.'">
            <span class="'.$closeTask3.'">'.$subgive2['assign_date'].'</span>
        </td>
        <td class="text-center zoomT" style="'.$roweBackgroundColor.'">
            <span class="'.$closeTask3.'">'.$subgive2['due_date'].'</span>
        </td>
        <td class="text-center zoomT" style="'.$roweBackgroundColor.'">
            <span class="'.$closeTask3.'">'.$subgive2['t_priority'].'</span>
        </td>
        <td class="text-center zoomT" style="'.$roweBackgroundColor.'">
            <span class="'.$closeTask3.'">'.$subgive2['status'].'</span>
        </td>
        <td class="text-center zoomT" style="'.$roweBackgroundColor.'">
            '.$taskstatus.'
        </td>
        <td class="text-center" style="'.$roweBackgroundColor.'">
            <a style="text-decoration: none;" href="./uploads/'.$subgive2['t_file'].'" download="'.$give2['employee_name'].'-Task">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-paperclip zoom" viewBox="0 0 16 16">
            <title>'.$subgive2['t_file'].'</title>
            <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/>
            </svg>
            </a>
        </td>
        <td class="text-center zoomT" style="'.$roweBackgroundColor.'">
            <span class="'.$closeTask3.'">
                '.$subgive2['admin_name'].'
                '.$subgive2['manager_name'].'
                '.$subgive2['assistant_name'].'
                '.$subgive2['employee_name'].'
            </span>
        </td>
        </tr>';
        }
        $output .= '
        </tbody>
        <tr class="frs1">
        <td colspan="12">
        <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="w-100" style="height: 3px;">
        </td>
        </tr>';
    } }
    if($_SESSION['role']=='manager') {
        $link2="SELECT DISTINCT manager.assign_id, manager.manager_name, manager.manager_status FROM task
        INNER JOIN manager ON task.assign_to=manager.assign_id
        WHERE manager.manager_id='{$_SESSION['id']}'".$m_search;
        $take2=mysqli_query($conn,$link2);
        while($give2=mysqli_fetch_array($take2)) {
        $sublink2="SELECT 
        task.*, 
        bucket.bucket_name, 
        reg_assign.admin_name AS admin_name,
        manager_assign.manager_name AS manager_name,
        reg_close.admin_name AS close_admin_name,
        manager_close.manager_name AS close_manager_name
        FROM 
        task
        INNER JOIN 
        bucket ON task.t_bucket = bucket.b_id
        LEFT JOIN 
        reg AS reg_assign ON task.assign_by = reg_assign.assign_id
        LEFT JOIN
        manager AS manager_assign ON task.assign_by = manager_assign.assign_id
        LEFT JOIN 
        reg AS reg_close ON task.close_by = reg_close.assign_id
        LEFT JOIN
        manager AS manager_close ON task.close_by = manager_close.assign_id
        WHERE 
        task.assign_to = '{$give2['assign_id']}' ORDER BY task_id DESC LIMIT 3";
        $subtake2=mysqli_query($conn,$sublink2);
        $rowBackgroundColor = ($give2['manager_status'] == '0') ? 'background-color: #ff9999;' : '';
        $output .= '<tbody style="vertical-align: middle; '.$rowBackgroundColor.'">
        <tr>
            <td class="mytasktd" style="border-bottom: 0px; '.$rowBackgroundColor.'" rowspan="3">
                <div class="mytask" style="width: 250px; height: 300px;">
                    <div class="task-pr">
                        <span>'.$give2['manager_name'].'</span>
                    </div>
                    <div style="height: 300px;" id="chartdiv_'.$give2['assign_id'].'" class="chart-container">
                        <div class="loading-spinner-container">
                            <div class="loading-spinner"></div>
                        </div>
                    </div>
                    <input id="TaskChart5299" class="ChartClassmy" type="hidden" value="5299">
                    <a style="text-decoration: none; color: black;"
                        href="user_dashboard.php?openid='.$give2['assign_id'].'">
                        <span class="pull-right xtp zoom">
                            <span class="xt bl">Show All Tasks</span>
                        </span>
                    </a>
                </div>
                <input type="hidden" id="chartNo'.$give2['assign_id'].'" class="chartNo" value="'.$give2['assign_id'].'">
            </td>';
            
        while($subgive2=mysqli_fetch_array($subtake2)) {

        $closeTask3 = $subgive2['status']=='close' ? "closed-task" : "";
        $currentDate2 = new DateTime();
        $dueDate2 = new DateTime($subgive2['due_date']);
        $output3 ='';
        if ($currentDate2 > $dueDate2 && $subgive2['status']=="open") {
        $output3 .= '<span class="fr"></span>';
        } else {
        $output3 .= '<span class="fr5"></span>';
        }
        $taskstatus = '';
        if($subgive2['status']=='open') {
        $taskstatus .= '<a href="dashboard.php?closed_id='.$subgive2['task_id'].'"
            onClick="return confirm(`Confirm to Close This Task.`)">
            <img src="assets/images/logos/icons8-close.gif" class="image zoom">
        </a>';
        } else {
        $taskstatus .= '<div class="tooltip"><a href="#!">
        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
        </a>
        <span class="tooltiptext">
        <h6>
        '.$subgive2['close_admin_name'].'
        '.$subgive2['close_manager_name'].'
        </h6>
        '.$subgive2['close_date'].'
        </span>
      </div>';
        }
        $output .= '
        <td class="text-center zoomT" style=" '.$rowBackgroundColor.'">
                <span class="'.$closeTask3.'">'.$output3.'</span>
        </td>

        <td class="text-center zoomT" style=" '.$rowBackgroundColor.'">
                <span class="'.$closeTask3.'">'.$subgive2['bucket_name'].'</span>
        </td>
        <td style="position: relative; '.$rowBackgroundColor.'">
            <span class="'.$closeTask3.'">'.$subgive2['t_about'].'</span>
        </td>
        <td class="text-center zoomT" style=" '.$rowBackgroundColor.'">
                <span class="'.$closeTask3.'">'.$subgive2['assign_date'].'</span>
        </td>
        <td class="text-center zoomT" style=" '.$rowBackgroundColor.'">
                <span class="'.$closeTask3.'">'.$subgive2['due_date'].'</span>
        </td>
        <td class="text-center zoomT" style=" '.$rowBackgroundColor.'">
                <span class="'.$closeTask3.'">'.$subgive2['t_priority'].'</span>
        </td>
        <td class="text-center zoomT" style=" '.$rowBackgroundColor.'">
                <span class="'.$closeTask3.'">'.$subgive2['status'].'</span>
        </td>
        <td class="text-center" style=" '.$rowBackgroundColor.'">
            '.$taskstatus.'
        </td>
        <td class="text-center" style=" '.$rowBackgroundColor.'">
            <a style="text-decoration: none;" href="./uploads/'.$subgive2['t_file'].'" download="'.$give2['manager_name'].'-Task">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-paperclip zoom" viewBox="0 0 16 16">
            <title>'.$subgive2['t_file'].'</title>
            <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/>
            </svg>
            </a>
        </td>
        <td class="text-center zoomT" style=" '.$rowBackgroundColor.'">
            <span class="'.$closeTask3.'">
                '.$subgive2['admin_name'].'
                '.$subgive2['manager_name'].'
            </span>
        </td>
    </tr>';
    }
    $output .= '
    </tbody>
    <tr class="frs1">
    <td colspan="12">
        <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="w-100" style="height: 3px;">
    </td>
    </tr>';
    }
    $link="SELECT DISTINCT assistant.assign_id, assistant.assistant_name, assistant.assistant_status FROM task
    INNER JOIN assistant ON task.assign_to=assistant.assign_id
    WHERE assistant.company_id='{$_SESSION['company']}'".$a_search;
    $take=mysqli_query($conn,$link);
    while($give=mysqli_fetch_array($take)) {
    $sublink="SELECT 
    task.*, 
    bucket.bucket_name, 
    reg_assign.admin_name AS admin_name, 
    manager_assign.manager_name AS manager_name,
    assistant_assign.assistant_name AS assistant_name,
    reg_close.admin_name AS close_admin_name,
    manager_close.manager_name AS close_manager_name,
    assistant_close.assistant_name AS close_assistant_name
    FROM 
    task
    INNER JOIN 
    bucket ON task.t_bucket = bucket.b_id
    LEFT JOIN 
    reg AS reg_assign ON task.assign_by = reg_assign.assign_id
    LEFT JOIN 
    manager AS manager_assign ON task.assign_by = manager_assign.assign_id
    LEFT JOIN 
    assistant AS assistant_assign ON task.assign_by = assistant_assign.assign_id
    LEFT JOIN 
    reg AS reg_close ON task.close_by = reg_close.assign_id
    LEFT JOIN 
    manager AS manager_close ON task.close_by = manager_close.assign_id
    LEFT JOIN 
    assistant AS assistant_close ON task.close_by = assistant_close.assign_id
    WHERE 
    task.assign_to = '{$give['assign_id']}' ORDER BY task_id DESC LIMIT 3";
    $subtake=mysqli_query($conn,$sublink);
    $rowaBackgroundColor = ($give['assistant_status'] == '0') ? 'background-color: #ff9999;' : '';
    $output .= '<tbody style="vertical-align: middle; '.$rowaBackgroundColor.'">
            <tr>
                <td class="mytasktd" style="border-bottom: 0px; '.$rowaBackgroundColor.'" rowspan="3">
                    <div class="mytask" style="width: 250px; height: 300px;">
                        <div class="task-pr">
                            <span>'.$give['assistant_name'].'</span>
                        </div>
                        <div style="height: 300px;" id="chartdiv_'.$give['assign_id'].'" class="chart-container">
                            <div class="loading-spinner-container">
                                <div class="loading-spinner"></div>
                            </div>
                        </div>
                        <a style="text-decoration: none; color: black;"
                            href="user_dashboard.php?openid='.$give['assign_id'].'">
                            <span class="pull-right xtp zoom">
                                <span class="xt bl">Show All Tasks</span>
                            </span>
                        </a>
                    </div>
                    <input type="hidden" id="chartNo'.$give['assign_id'].'" class="chartNo" value="'.$give['assign_id'].'">
                </td>';
                
                
                 while($subgive=mysqli_fetch_array($subtake)) {
                 $currentDate = new DateTime();
                 $dueDate = new DateTime($subgive['due_date']);
                 $output1 = '';
                 if ($currentDate > $dueDate && $subgive['status']=="open") {
                     $output1 .= '<span class="fr"></span>';
                 } else {
                     $output1 .= '<span class="fr5"></span>';
                 }
                 $taskstatus = '';
                  if($subgive['status']=='open') { 
                    $taskstatus .= '<a href="dashboard.php?closed_id='.$subgive['task_id'].'"
                        onClick="return confirm(`Confirm to Close This Task.`)">
                        <img src="assets/images/logos/icons8-close.gif" class="image zoom">
                    </a>';
                     } else { 
                    $taskstatus .= '<div class="tooltip"><a href="#!">
                    <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                    </a>
                    <span class="tooltiptext">
                    <h6>
                    '.$subgive['close_admin_name'].'
                    '.$subgive['close_manager_name'].'
                    '.$subgive['close_assistant_name'].'
                    </h6>
                    '.$subgive['close_date'].'
                    </span>
                  </div>';
                     } 

                 $closetask = $subgive['status']=='close' ? "closed-task" : '';
                $output .= '
                <td class="text-center zoomT" style="'.$rowaBackgroundColor.'">
                        <span class="'.$closetask.'">'.$output1.'</span>
                </td>
        
                <td class="text-center zoomT" style="'.$rowaBackgroundColor.'">
                        <span class="'.$closetask.'">'.$subgive['bucket_name'].'</span>
                </td>
                <td style="position: relative; '.$rowaBackgroundColor.'">
                    <span class="'.$closetask.'">'.$subgive['t_about'].'</span>
                </td>
                <td class="text-center" style="'.$rowaBackgroundColor.'">
                        <span class="'.$closetask.'">'.$subgive['assign_date'].'</span>
                </td>
                <td class="text-center zoomT" style="'.$rowaBackgroundColor.'">
                        <span class="'.$closetask.'">'.$subgive['due_date'].'</span>
                </td>
                <td class="text-center zoomT" style="'.$rowaBackgroundColor.'">
                        <span class="'.$closetask.'">'.$subgive['t_priority'].'</span>
                </td>
                <td class="text-center zoomT" style="'.$rowaBackgroundColor.'">
                        <span class="'.$closetask.'">'.$subgive['status'].'</span>
                </td>
                <td class="text-center" style="'.$rowaBackgroundColor.'">
                   '.$taskstatus.'
                </td>
                <td class="text-center" style="'.$rowaBackgroundColor.'">
                    <a style="text-decoration: none;" href="./uploads/'.$subgive['t_file'].'" download="'.$give['assistant_name'].'-Task">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-paperclip zoom" viewBox="0 0 16 16">
                    <title>'.$subgive['t_file'].'</title>
                    <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/>
                    </svg>
                    </a>
                </td>
                <td class="text-center zoomT" style="'.$rowaBackgroundColor.'">
                <span class="'.$closetask.'">
                 '.$subgive['admin_name'].'
                 '.$subgive['manager_name'].'
                 '.$subgive['assistant_name'].'
                </span>
                </td>
            </tr>';
                    }
                
        $output .= '</tbody>
        <tr class="frs1">
            <td colspan="12">
        <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="w-100" style="height: 3px;">
        </td>
        </tr>';
        }
        $link1="SELECT DISTINCT employee.assign_id, employee.employee_name, employee.employee_status FROM task
                INNER JOIN employee ON task.assign_to=employee.assign_id
                WHERE employee.company_id='{$_SESSION['company']}'".$e_search;
                $take1=mysqli_query($conn,$link1);
                while($give1=mysqli_fetch_array($take1)) {
                    $sublink1="SELECT 
                    task.*, 
                    bucket.bucket_name, 
                    reg_assign.admin_name AS admin_name, 
                    manager_assign.manager_name AS manager_name,
                    assistant_assign.assistant_name AS assistant_name,
                    employee_assign.employee_name AS employee_name,
                    reg_close.admin_name AS close_admin_name,
                    manager_close.manager_name AS close_manager_name,
                    assistant_close.assistant_name AS close_assistant_name,
                    employee_close.employee_name AS close_employee_name
                FROM 
                    task
                INNER JOIN 
                    bucket ON task.t_bucket = bucket.b_id
                LEFT JOIN 
                    reg AS reg_assign ON task.assign_by = reg_assign.assign_id
                LEFT JOIN 
                    manager AS manager_assign ON task.assign_by = manager_assign.assign_id
                LEFT JOIN 
                    assistant AS assistant_assign ON task.assign_by = assistant_assign.assign_id
                LEFT JOIN 
                    employee AS employee_assign ON task.assign_by = employee_assign.assign_id
                LEFT JOIN 
                    reg AS reg_close ON task.close_by = reg_close.assign_id
                LEFT JOIN 
                    manager AS manager_close ON task.close_by = manager_close.assign_id
                LEFT JOIN 
                    assistant AS assistant_close ON task.close_by = assistant_close.assign_id
                LEFT JOIN 
                    employee AS employee_close ON task.close_by = employee_close.assign_id
                WHERE 
                    task.assign_to = '{$give1['assign_id']}' ORDER BY task_id DESC LIMIT 3";
                    $subtake1=mysqli_query($conn,$sublink1);
                    $roweBackgroundColor = ($give1['employee_status'] == '0') ? 'background-color: #ff9999;' : '';
                    $output .= '<tbody style="vertical-align: middle; '.$roweBackgroundColor.'">
                    <tr>
                        <td class="mytasktd" style="border-bottom: 0px; '.$roweBackgroundColor.'" rowspan="3">
                            <div class="mytask" style="width: 250px; height: 300px;">
                                <div class="task-pr">
                                    <span>'.$give1['employee_name'].'</span>
                                </div>
                                <div style="height: 300px;" id="chartdiv_'.$give1['assign_id'].'" class="chart-container">
                                    <div class="loading-spinner-container">
                                        <div class="loading-spinner"></div>
                                    </div>
                                </div>
                                <a style="text-decoration: none; color: black;"
                                    href="user_dashboard.php?openid='.$give1['assign_id'].'">
                                    <span class="pull-right xtp zoom">
                                        <span class="xt bl">Show All Tasks</span>
                                    </span>
                                </a>
                            </div>
                            <input type="hidden" id="chartNo'.$give1['assign_id'].'" class="chartNo" value="'.$give1['assign_id'].'">
                        </td>';
                        while($subgive1=mysqli_fetch_array($subtake1)) {
                            $closeTask2 = $subgive1['status']=='close' ? "closed-task":"";
                            $output2 = '';
                            $currentDate1 = new DateTime();
                            $dueDate1 = new DateTime($subgive1['due_date']);
                            if ($currentDate1 > $dueDate1 && $subgive1['status']=="open") {
                               $output2 .= '<span class="fr"></span>';
                            } else {
                                $output2 .= '<span class="fr5"></span>';
                            }
                            $taskstatus ='';
                            if($subgive1['status']=='open') {
                                $taskstatus .= '<a href="dashboard.php?closed_id='.$subgive1['task_id'].'"
                                    onClick="return confirm(`Confirm to Close This Task.`)">
                                    <img src="assets/images/logos/icons8-close.gif" class="image zoom">
                                </a>';
                                } else {
                                $taskstatus .= '<div class="tooltip"><a href="#!">
                                <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                                </a>
                                <span class="tooltiptext">
                                <h6>
                                '.$subgive1['close_admin_name'].'
                                '.$subgive1['close_manager_name'].'
                                '.$subgive1['close_assistant_name'].'
                                '.$subgive1['close_employee_name'].'
                                </h6>
                                '.$subgive1['close_date'].'
                                </span>
                              </div>';
                                }

                        $output .= '
                        <td class="text-center zoomT" style=" '.$roweBackgroundColor.'">
                                <span class="'.$closeTask2.'">'.$output2.'</span>
                        </td>

                        <td class="text-center zoomT" style=" '.$roweBackgroundColor.'">
                            <span class="'.$closeTask2.'">'.$subgive1['bucket_name'].'</span>
                        </td>
                        <td style="position: relative; '.$roweBackgroundColor.'">
                            <span class="'.$closeTask2.'">'.$subgive1['t_about'].'</span>
                        </td>
                        <td class="text-center zoomT" style=" '.$roweBackgroundColor.'">
                                <span class="'.$closeTask2.'">'.$subgive1['assign_date'].'</span>
                        </td>
                        <td class="text-center zoomT" style=" '.$roweBackgroundColor.'">
                                <span class="'.$closeTask2.'">'.$subgive1['due_date'].'</span>
                        </td>
                        <td class="text-center zoomT" style=" '.$roweBackgroundColor.'">
                                <span class="'.$closeTask2.'">'.$subgive1['t_priority'].'</span>
                        </td>
                        <td class="text-center zoomT" style=" '.$roweBackgroundColor.'">
                                <span class="'.$closeTask2.'">'.$subgive1['status'].'</span>
                        </td>
                        <td class="text-center" style=" '.$roweBackgroundColor.'">
                        '.$taskstatus.'
                        </td>
                        <td class="text-center" style=" '.$roweBackgroundColor.'">
                            <a style="text-decoration: none;" href="./uploads/'.$subgive1['t_file'].'" download="'.$give1['employee_name'].'-Task">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-paperclip zoom" viewBox="0 0 16 16">
                            <title>'.$subgive1['t_file'].'</title>
                            <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/>
                            </svg>
                            </a>
                        </td>
                        <td class="text-center zoomT" style=" '.$roweBackgroundColor.'">
                            <span class="'.$closeTask2.'">
                                '.$subgive1['admin_name'].'
                                '.$subgive1['manager_name'].'
                                '.$subgive1['assistant_name'].'
                                '.$subgive1['employee_name'].'
                            </span>
                        </td>
                    </tr>';
                    } 
                $output .= '</tbody>
                <tr class="frs1">
                    <td colspan="12">
                        <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="w-100"
                            style="height: 3px;">
                    </td>
                </tr>';
                 } }
                 if($_SESSION['role']=='assistant') {
                    $link2="SELECT DISTINCT assistant.assign_id, assistant.assistant_name, assistant.assistant_status FROM task
                    INNER JOIN assistant ON task.assign_to=assistant.assign_id
                    WHERE assistant.assistant_id='{$_SESSION['id']}'".$a_search;
                    $take2=mysqli_query($conn,$link2);
                    while($give2=mysqli_fetch_array($take2)) {
                        $sublink2="SELECT 
                        task.*, 
                        bucket.bucket_name, 
                        reg_assign.admin_name AS admin_name, 
                        manager_assign.manager_name AS manager_name,
                        assistant_assign.assistant_name AS assistant_name,
                        reg_close.admin_name AS close_admin_name,
                        manager_close.manager_name AS close_manager_name,
                        assistant_close.assistant_name AS close_assistant_name
                    FROM 
                        task
                    INNER JOIN 
                        bucket ON task.t_bucket = bucket.b_id
                    LEFT JOIN 
                        reg AS reg_assign ON task.assign_by = reg_assign.assign_id
                    LEFT JOIN 
                        manager AS manager_assign ON task.assign_by = manager_assign.assign_id
                    LEFT JOIN 
                        assistant AS assistant_assign ON task.assign_by = assistant_assign.assign_id
                    LEFT JOIN 
                        reg AS reg_close ON task.close_by = reg_close.assign_id
                    LEFT JOIN 
                        manager AS manager_close ON task.close_by = manager_close.assign_id
                    LEFT JOIN 
                        assistant AS assistant_close ON task.close_by = assistant_close.assign_id
                    WHERE 
                        task.assign_to = '{$give2['assign_id']}' ORDER BY task_id DESC LIMIT 3";
                        $subtake2=mysqli_query($conn,$sublink2);
                        $rowaBackgroundColor = ($give2['assistant_status'] == '0') ? 'background-color: #ff9999;' : '';
                $output .= '<tbody style="vertical-align: middle; '.$rowaBackgroundColor.'">
            <tr>
                <td class="mytasktd" style="border-bottom: 0px; '.$rowaBackgroundColor.'" rowspan="3">
                    <div class="mytask" style="width: 250px; height: 300px;">
                        <div class="task-pr">
                            <span>'.$give2['assistant_name'].'</span>
                    </div>
                    <div style="height: 300px;" id="chartdiv_'.$give2['assign_id'].'" class="chart-container">
                        <div class="loading-spinner-container">
                            <div class="loading-spinner"></div>
                        </div>
                    </div>
                    <input id="TaskChart5299" class="ChartClassmy" type="hidden" value="5299">
                    <a style="text-decoration: none; color: black;"
                        href="user_dashboard.php?openid='.$give2['assign_id'].'">
                        <span class="pull-right xtp zoom">
                            <span class="xt bl">Show All Tasks</span>
                        </span>
                    </a>
                </div>
                <input type="hidden" id="chartNo'.$give2['assign_id'].'" class="chartNo" value="'.$give2['assign_id'].'">
            </td>';
            
        while($subgive2=mysqli_fetch_array($subtake2)) {

        $closeTask3 = $subgive2['status']=='close' ? "closed-task" : "";
        $currentDate2 = new DateTime();
        $dueDate2 = new DateTime($subgive2['due_date']);
        $output3 ='';
        if ($currentDate2 > $dueDate2 && $subgive2['status']=="open") {
        $output3 .= '<span class="fr"></span>';
        } else {
        $output3 .= '<span class="fr5"></span>';
        }
        $taskstatus = '';
        if($subgive2['status']=='open') {
        $taskstatus .= '<a href="dashboard.php?closed_id='.$subgive2['task_id'].'"
            onClick="return confirm(`Confirm to Close This Task.`)">
            <img src="assets/images/logos/icons8-close.gif" class="image zoom">
        </a>';
        } else {
        $taskstatus .= '<div class="tooltip"><a href="#!">
        <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
        </a>
        <span class="tooltiptext">
        <h6>
        '.$subgive2['close_admin_name'].'
        '.$subgive2['close_manager_name'].'
        '.$subgive2['close_assistant_name'].'
        </h6>
        '.$subgive2['close_date'].'
        </span>
      </div>';
        }
        $output .= '
        <td class="text-center zoomT" style=" '.$rowaBackgroundColor.'">
                <span class="'.$closeTask3.'">'.$output3.'</span>
        </td>

        <td class="text-center zoomT" style=" '.$rowaBackgroundColor.'">
                <span class="'.$closeTask3.'">'.$subgive2['bucket_name'].'</span>
        </td>
        <td style="position: relative; '.$rowaBackgroundColor.'">
            <span class="'.$closeTask3.'">'.$subgive2['t_about'].'</span>
        </td>
        <td class="text-center zoomT" style=" '.$rowaBackgroundColor.'">
                <span class="'.$closeTask3.'">'.$subgive2['assign_date'].'</span>
        </td>
        <td class="text-center zoomT" style=" '.$rowaBackgroundColor.'">
                <span class="'.$closeTask3.'">'.$subgive2['due_date'].'</span>
        </td>
        <td class="text-center zoomT" style=" '.$rowaBackgroundColor.'">
                <span class="'.$closeTask3.'">'.$subgive2['t_priority'].'</span
        </td>
        <td class="text-center zoomT" style=" '.$rowaBackgroundColor.'">
                <span class="'.$closeTask3.'">'.$subgive2['status'].'</span>
        </td>
        <td class="text-center" style=" '.$rowaBackgroundColor.'">
            '.$taskstatus.'
        </td>
        <td class="text-center" style=" '.$rowaBackgroundColor.'">
            <a style="text-decoration: none;" href="./uploads/'.$subgive2['t_file'].'" download="'.$give2['assistant_name'].'-Task">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-paperclip zoom" viewBox="0 0 16 16">
            <title>'.$subgive2['t_file'].'</title>
            <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/>
            </svg>
            </a>
        </td>
        <td class="text-center zoomT" style=" '.$rowaBackgroundColor.'">
            <span class="'.$closeTask3.'">
                '.$subgive2['admin_name'].'
                '.$subgive2['manager_name'].'
                '.$subgive2['assistant_name'].'
            </span>
        </td>
    </tr>';
    }
    $output .= '
    </tbody>
    <tr class="frs1">
    <td colspan="12">
        <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="w-100" style="height: 3px;">
    </td>
    </tr>';
    }
    $link="SELECT DISTINCT employee.assign_id, employee.employee_name, employee.employee_status FROM task
                INNER JOIN employee ON task.assign_to=employee.assign_id
                WHERE employee.assistant_id='{$_SESSION['id']}'";
                $take=mysqli_query($conn,$link);
                while($give=mysqli_fetch_array($take)) {
                    $sublink="SELECT 
                    task.*, 
                    bucket.bucket_name, 
                    reg_assign.admin_name AS admin_name, 
                    manager_assign.manager_name AS manager_name,
                    assistant_assign.assistant_name AS assistant_name,
                    employee_assign.employee_name AS employee_name,
                    reg_close.admin_name AS close_admin_name,
                    manager_close.manager_name AS close_manager_name,
                    assistant_close.assistant_name AS close_assistant_name,
                    employee_close.employee_name AS close_employee_name
                FROM 
                    task
                INNER JOIN 
                    bucket ON task.t_bucket = bucket.b_id
                LEFT JOIN 
                    reg AS reg_assign ON task.assign_by = reg_assign.assign_id
                LEFT JOIN 
                    manager AS manager_assign ON task.assign_by = manager_assign.assign_id
                LEFT JOIN 
                    assistant AS assistant_assign ON task.assign_by = assistant_assign.assign_id
                LEFT JOIN 
                    employee AS employee_assign ON task.assign_by = employee_assign.assign_id
                LEFT JOIN 
                    reg AS reg_close ON task.close_by = reg_close.assign_id
                LEFT JOIN 
                    manager AS manager_close ON task.close_by = manager_close.assign_id
                LEFT JOIN 
                    assistant AS assistant_close ON task.close_by = assistant_close.assign_id
                LEFT JOIN 
                    employee AS employee_close ON task.close_by = employee_close.assign_id
                WHERE 
                    task.assign_to = '{$give['assign_id']}' ORDER BY task_id DESC LIMIT 3";
                    $subtake=mysqli_query($conn,$sublink);
                    $roweBackgroundColor = ($give['employee_status'] == '0') ? 'background-color: #ff9999;' : '';
                    $output .= '<tbody style="vertical-align: middle; '.$roweBackgroundColor.'">
            <tr>
                <td class="mytasktd" style="border-bottom: 0px;" rowspan="3">
                    <div class="mytask" style="width: 250px; height: 300px;">
                        <div class="task-pr">
                            <span>'.$give['employee_name'].'</span>
                        </div>
                        <div style="height: 300px;" id="chartdiv_'.$give['assign_id'].'" class="chart-container">
                            <div class="loading-spinner-container">
                                <div class="loading-spinner"></div>
                            </div>
                        </div>
                        <a style="text-decoration: none; color: black;"
                            href="user_dashboard.php?openid='.$give['assign_id'].'">
                            <span class="pull-right xtp zoom">
                                <span class="xt bl">Show All Tasks</span>
                            </span>
                        </a>
                    </div>
                    <input type="hidden" id="chartNo'.$give['assign_id'].'" class="chartNo" value="'.$give['assign_id'].'">
                </td>';
                
                
                 while($subgive=mysqli_fetch_array($subtake)) {
                 $currentDate = new DateTime();
                 $dueDate = new DateTime($subgive['due_date']);
                 $output1 = '';
                 if ($currentDate > $dueDate && $subgive['status']=="open") {
                     $output1 .= '<span class="fr"></span>';
                 } else {
                     $output1 .= '<span class="fr5"></span>';
                 }
                 $taskstatus = '';
                  if($subgive['status']=='open') { 
                    $taskstatus .= '<a href="dashboard.php?closed_id='.$subgive['task_id'].'"
                        onClick="return confirm(`Confirm to Close This Task.`)">
                        <img src="assets/images/logos/icons8-close.gif" class="image zoom">
                    </a>';
                     } else { 
                    $taskstatus .= '<div class="tooltip"><a href="#!">
                    <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                    </a>
                    <span class="tooltiptext">
                    <h6>
                    '.$subgive['close_admin_name'].'
                    '.$subgive['close_manager_name'].'
                    '.$subgive['close_assistant_name'].'
                    '.$subgive['close_employee_name'].'
                    </h6>
                    '.$subgive['close_date'].'
                    </span>
                  </div>';
                     } 

                 $closetask = $subgive['status']=='close' ? "closed-task" : '';
                $output .= '
                <td class="text-center zoomT" style=" '.$roweBackgroundColor.'">
                        <span class="'.$closetask.'">'.$output1.'</span>
                </td>
        
                <td class="text-center zoomT" style=" '.$roweBackgroundColor.'">
                        <span class="'.$closetask.'">'.$subgive['bucket_name'].'</span>
                </td>
                <td style="position: relative; '.$roweBackgroundColor.'">
                    <span class="'.$closetask.'">'.$subgive['t_about'].'</span>
                </td>
                <td class="text-center zoomT" style=" '.$roweBackgroundColor.'">
                        <span class="'.$closetask.'">'.$subgive['assign_date'].'</span>
                </td>
                <td class="text-center zoomT" style=" '.$roweBackgroundColor.'">
                        <span class="'.$closetask.'">'.$subgive['due_date'].'</span>
                </td>
                <td class="text-center zoomT" style=" '.$roweBackgroundColor.'">
                        <span class="'.$closetask.'">'.$subgive['t_priority'].'</span>
                </td>
                <td class="text-center zoomT" style=" '.$roweBackgroundColor.'">
                        <span class="'.$closetask.'">'.$subgive['status'].'</span>
                </td>
                <td class="text-center" style=" '.$roweBackgroundColor.'">
                   '.$taskstatus.'
                </td>
                <td class="text-center" style=" '.$roweBackgroundColor.'">
                    <a style="text-decoration: none;" href="./uploads/'.$subgive['t_file'].'" download="'.$give['employee_name'].'-Task">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-paperclip zoom" viewBox="0 0 16 16">
                    <title>'.$subgive['t_file'].'</title>
                    <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/>
                    </svg>
                    </a>
                </td>
                <td class="text-center zoomT" style=" '.$roweBackgroundColor.'">
                <span class="'.$closetask.'">
                 '.$subgive['admin_name'].'
                 '.$subgive['manager_name'].'
                 '.$subgive['assistant_name'].'
                 '.$subgive['employee_name'].'
                </span>
                </td>
            </tr>';
                    }
                
        $output .= '</tbody>
        <tr class="frs1">
            <td colspan="12">
        <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="w-100" style="height: 3px;">
        </td>
        </tr>';
        } }

        if($_SESSION['role']=='employee') {
            $link="SELECT DISTINCT employee.assign_id, employee.employee_name FROM task
            INNER JOIN employee ON task.assign_to=employee.assign_id
            WHERE employee.assign_id='{$_SESSION['assign']}'";
            $take=mysqli_query($conn,$link);
            while($give=mysqli_fetch_array($take)) {
                $sublink="SELECT 
                task.*, 
                bucket.bucket_name, 
                reg_assign.admin_name AS admin_name, 
                manager_assign.manager_name AS manager_name,
                assistant_assign.assistant_name AS assistant_name,
                employee_assign.employee_name AS employee_name,
                reg_close.admin_name AS close_admin_name,
                manager_close.manager_name AS close_manager_name,
                assistant_close.assistant_name AS close_assistant_name,
                employee_close.employee_name AS close_employee_name
            FROM 
                task
            INNER JOIN 
                bucket ON task.t_bucket = bucket.b_id
            LEFT JOIN 
                reg AS reg_assign ON task.assign_by = reg_assign.assign_id
            LEFT JOIN 
                manager AS manager_assign ON task.assign_by = manager_assign.assign_id
            LEFT JOIN 
                assistant AS assistant_assign ON task.assign_by = assistant_assign.assign_id
            LEFT JOIN 
                employee AS employee_assign ON task.assign_by = employee_assign.assign_id
            LEFT JOIN 
                reg AS reg_close ON task.close_by = reg_close.assign_id
            LEFT JOIN 
                manager AS manager_close ON task.close_by = manager_close.assign_id
            LEFT JOIN 
                assistant AS assistant_close ON task.close_by = assistant_close.assign_id
            LEFT JOIN 
                employee AS employee_close ON task.close_by = employee_close.assign_id
            WHERE 
                task.assign_to = '{$give['assign_id']}' ORDER BY task_id DESC LIMIT 3";
                $subtake=mysqli_query($conn,$sublink);

                $output .= '<tbody style="vertical-align: middle;">
            <tr>
                <td class="mytasktd" style="border-bottom: 0px;" rowspan="3">
                    <div class="mytask" style="width: 250px; height: 300px;">
                        <div class="task-pr">
                            <span>'.$give['employee_name'].'</span>
                        </div>
                        <div style="height: 300px;" id="chartdiv_'.$give['assign_id'].'" class="chart-container">
                            <div class="loading-spinner-container">
                                <div class="loading-spinner"></div>
                            </div>
                        </div>
                        <a style="text-decoration: none; color: black;"
                            href="user_dashboard.php?openid='.$give['assign_id'].'">
                            <span class="pull-right xtp zoom">
                                <span class="xt bl">Show All Tasks</span>
                            </span>
                        </a>
                    </div>
                    <input type="hidden" id="chartNo'.$give['assign_id'].'" class="chartNo" value="'.$give['assign_id'].'">
                </td>';
                 while($subgive=mysqli_fetch_array($subtake)) {
                 $currentDate = new DateTime();
                 $dueDate = new DateTime($subgive['due_date']);
                 $output1 = '';
                 if ($currentDate > $dueDate && $subgive['status']=="open") {
                     $output1 .= '<span class="fr"></span>';
                 } else {
                     $output1 .= '<span class="fr5"></span>';
                 }
                 $taskstatus = '';
                  if($subgive['status']=='open') { 
                    $taskstatus .= '<a href="dashboard.php?closed_id='.$subgive['task_id'].'"
                        onClick="return confirm(`Confirm to Close This Task.`)">
                        <img src="assets/images/logos/icons8-close.gif" class="image zoom">
                    </a>';
                     } else { 
                    $taskstatus .= '<div class="tooltip"><a href="#!">
                    <img src="assets/images/logos/icons8-closed-sign-50.png" class="image zoom">
                    </a>
                    <span class="tooltiptext">
                    <h6>
                    '.$subgive['close_admin_name'].'
                    '.$subgive['close_manager_name'].'
                    '.$subgive['close_assistant_name'].'
                    '.$subgive['close_employee_name'].'
                    </h6>
                    '.$subgive['close_date'].'
                    </span>
                  </div>';
                     } 

                 $closetask = $subgive['status']=='close' ? "closed-task" : '';
                $output .= '
                <td class="text-center zoomT">
                        <span class="'.$closetask.'">'.$output1.'</span>
                </td>
        
                <td class="text-center zoomT">
                        <span class="'.$closetask.'">'.$subgive['bucket_name'].'</span>
                </td>
                <td style="position: relative;">
                    <span class="'.$closetask.'">'.$subgive['t_about'].'</span>
                </td>
                <td class="text-center zoomT">
                    <span class="'.$closetask.'">'.$subgive['assign_date'].'</span>
                </td>
                <td class="text-center zoomT">
                        <span class="'.$closetask.'">'.$subgive['due_date'].'</span>
                </td>
                <td class="text-center zoomT">
                        <span class="'.$closetask.'">'.$subgive['t_priority'].'</span>
                </td>
                <td class="text-center zoomT">
                        <span class="'.$closetask.'">'.$subgive['status'].'</span>
                </td>
                <td class="text-center">
                   '.$taskstatus.'
                </td>
                <td class="text-center">
                    <a style="text-decoration: none;" href="./uploads/'.$subgive['t_file'].'" download="'.$give['employee_name'].'-Task">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-paperclip zoom" viewBox="0 0 16 16">
                    <title>'.$subgive['t_file'].'</title>
                    <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/>
                    </svg>
                    </a>
                </td>
                <td class="text-center zoomT">
                <span class="'.$closetask.'">
                 '.$subgive['admin_name'].'
                 '.$subgive['manager_name'].'
                 '.$subgive['assistant_name'].'
                 '.$subgive['employee_name'].'
                </span>
                </td>
            </tr>';
                    }
                
        $output .= '</tbody>
        <tr class="frs1">
            <td colspan="12">
        <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="w-100" style="height: 3px;">
        </td>
        </tr>';
        } }
    $output .= '</table>';
    echo $output;
}

if($_POST['action'] == 'addPunchInData')
{   
    $a_date = date('d-M-y');
    $a_time = date("h:i:s A");
    $a_status = "Present";
    $lati = $_POST['latitude'];
    $long = $_POST['longitude'];
    if ($_SESSION['role'] == 'manager') {
        $validate = "SELECT a_time FROM `attendance` WHERE manager_id='{$_SESSION['id']}' AND a_date='{$a_date}'";
        $validateSQL = mysqli_query($conn, $validate);
        $validateFetch = mysqli_fetch_assoc($validateSQL);
        if ($validateFetch['a_time'] == '') {
            $sqlat = "INSERT INTO attendance (manager_id, a_date, a_status)
        SELECT m.manager_id, DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%d-%b-%y'), 'Absent'
        FROM manager m
        LEFT JOIN attendance a ON m.manager_id = a.manager_id AND a.a_date = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%d-%b-%y')
        WHERE a.manager_id IS NULL AND m.manager_status <> '0'";
            $queryat = mysqli_query($conn, $sqlat);
            $sql = "INSERT INTO `attendance` (`manager_id`,`a_time`, time_lat, time_long, `a_date`,`a_status`) VALUES ('{$_SESSION['id']}','{$a_time}','{$lati}','{$long}','{$a_date}','{$a_status}')";
            if($query = mysqli_query($conn, $sql))
            {
                $output = array(
                    'status' => 'success',
                    'message' => 'Punch in'
                );
            }else{
                $output = array(
                    'status' => 'fail',
                    'message' => 'Try again later'
                );
            }


        }
    } else if ($_SESSION['role'] == 'assistant') {
        $validate = "SELECT a_time FROM `attendance` WHERE assistant_id='{$_SESSION['id']}' AND a_date='{$a_date}'";
        $validateSQL = mysqli_query($conn, $validate);
        $validateFetch = mysqli_fetch_assoc($validateSQL);
        if ($validateFetch['a_time'] == '') {
            $sqlat = "INSERT INTO attendance (assistant_id, a_date, a_status)
        SELECT o.assistant_id, DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%d-%b-%y'), 'Absent'
        FROM assistant o
        LEFT JOIN attendance a ON o.assistant_id = a.assistant_id AND a.a_date = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%d-%b-%y')
        WHERE a.assistant_id IS NULL AND o.assistant_status <> '0'";
            $queryat = mysqli_query($conn, $sqlat);
            $sql = "INSERT INTO `attendance` (`assistant_id`,`a_time`, time_lat, time_long, `a_date`,`a_status`) VALUES ('{$_SESSION['id']}','{$a_time}','{$lati}','{$long}','{$a_date}','{$a_status}')";
            if($query = mysqli_query($conn, $sql))
            {
                $output = array(
                    'status' => 'success',
                    'message' => 'Punch in'
                );
            }else{
                $output = array(
                    'status' => 'fail',
                    'message' => 'Try again later'
                );
            }
        }
    } else if ($_SESSION['role'] == 'employee') {
        $validate = "SELECT a_time FROM `attendance` WHERE employee_id='{$_SESSION['id']}' AND a_date='{$a_date}'";
        $validateSQL = mysqli_query($conn, $validate);
        $validateFetch = mysqli_fetch_assoc($validateSQL);
        if ($validateFetch['a_time'] == '') {
            $sqlat = "INSERT INTO attendance (employee_id, a_date, a_status)
        SELECT e.employee_id, DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%d-%b-%y'), 'Absent'
        FROM employee e
        LEFT JOIN attendance a ON e.employee_id = a.employee_id AND a.a_date = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%d-%b-%y')
        WHERE a.employee_id IS NULL AND e.employee_status <> '0'";
            $queryat = mysqli_query($conn, $sqlat);
            $sql = "INSERT INTO `attendance` (`employee_id`,`a_time`, time_lat, time_long, `a_date`,`a_status`) VALUES ('{$_SESSION['id']}','{$a_time}','{$lati}','{$long}','{$a_date}','{$a_status}')";
            if($query = mysqli_query($conn, $sql))
            {
                $output = array(
                    'status' => 'success',
                    'message' => 'Punch in'
                );
            }else{
                $output = array(
                    'status' => 'fail',
                    'message' => 'Try again later'
                );
            }
        }
    }
    echo json_encode($output);
}

if($_POST['action'] == 'addPunchOutData')
{
    $a_date = date('d-M-y');
    $a_timeout = date("h:i:s A");
    $lati = $_POST['latitude'];
    $long = $_POST['longitude'];

    if ($_SESSION['role'] == 'manager') {
        $validate = "SELECT a_timeout FROM `attendance` WHERE manager_id='{$_SESSION['id']}' AND a_date='{$a_date}'";
        $validateSQL = mysqli_query($conn, $validate);
        $validateFetch = mysqli_fetch_assoc($validateSQL);
        if ($validateFetch['a_timeout'] == '') {
            $sql6 = "UPDATE `attendance` SET `a_timeout`='{$a_timeout}', timeout_lat='{$lati}', timeout_long='{$long}' WHERE `manager_id`='{$_SESSION['id']}' AND `a_date`='{$a_date}' AND `a_status`='Present'";
            if($query6 = mysqli_query($conn, $sql6)){
                $output = array(
                    'status'  => 'success',
                    'message' => 'Punch Out successfull'
                );
            }else{
                $output = array(
                    'status'  => 'fail',
                    'message' => 'Try again later'
                );
            }
        }else{
            $output = array(
                'status'  => 'fail',
                'message' => 'Before punch out you need to punch in'
            );
        }
    }else if ($_SESSION['role'] == 'assistant') {
        $validate = "SELECT a_timeout FROM `attendance` WHERE assistant_id='{$_SESSION['id']}' AND a_date='{$a_date}'";
        $validateSQL = mysqli_query($conn, $validate);
        $validateFetch = mysqli_fetch_assoc($validateSQL);
        if ($validateFetch['a_timeout'] == '') {
            $sql6 = "UPDATE `attendance` SET `a_timeout`='{$a_timeout}', timeout_lat='{$lati}', timeout_long='{$long}' WHERE `assistant_id`='{$_SESSION['id']}' AND `a_date`='{$a_date}' AND `a_status`='Present'";
            if($query6 = mysqli_query($conn, $sql6)){
                $output = array(
                    'status'  => 'success',
                    'message' => 'Punch Out successfull'
                );
            }else{
                $output = array(
                    'status'  => 'fail',
                    'message' => 'Try again later'
                );
            }
        }else{
            $output = array(
                'status'  => 'fail',
                'message' => 'Before punch out you need to punch in'
            );
        }
    }else if ($_SESSION['role'] == 'employee') {
        $validate = "SELECT a_timeout FROM `attendance` WHERE employee_id='{$_SESSION['id']}' AND a_date='{$a_date}'";
        $validateSQL = mysqli_query($conn, $validate);
        $validateFetch = mysqli_fetch_assoc($validateSQL);
        if ($validateFetch['a_timeout'] == '') {
            $sql6 = "UPDATE `attendance` SET `a_timeout`='{$a_timeout}', timeout_lat='{$lati}', timeout_long='{$long}' WHERE `employee_id`='{$_SESSION['id']}' AND `a_date`='{$a_date}' AND `a_status`='Present'";
            $query6 = mysqli_query($conn, $sql6);
            if($query6 = mysqli_query($conn, $sql6)){
                $output = array(
                    'status'  => 'success',
                    'message' => 'Punch Out successfull'
                );
            }else{
                $output = array(
                    'status'  => 'fail',
                    'message' => 'Try again later'
                );
            }
        }else{
            $output = array(
                'status'  => 'fail',
                'message' => 'Before punch out you need to punch in'
            );
        }
    }
    echo json_encode($output);
}

?>