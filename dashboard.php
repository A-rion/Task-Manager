<?php session_start();
include("conn.php");
include("header.php");
if (!$_SESSION['id']) {
?>
<script>
window.location.href = "index.php";
</script>
<?php
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>

<style>
.chart-container {
    position: relative;
    height: 300px;
    /* Set the height of the container */
}

.loading-spinner-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>

<?php
if (isset($_REQUEST['assign_search'])) {
    $assign_search_text = $_REQUEST['assign_search_text'];
    $e_search = " AND (employee.employee_name LIKE '%$assign_search_text%')";
    $m_search = " AND (manager.manager_name LIKE '%$assign_search_text%')";
    $a_search = " AND (assistant.assistant_name LIKE '%$assign_search_text%')";
}
?>

<?php
$closed_id = $_REQUEST['closed_id'];
if ($closed_id) {
    $close_date = date('d-M-y');
    $sqld = "UPDATE task SET status='close',close_by='{$_SESSION['assign']}', close_date='{$close_date}' WHERE task_id='{$closed_id}'";
    $queryd = mysqli_query($conn, $sqld);
    ?>
<script>
window.history.replaceState({}, document.title, window.location.pathname);
</script>
<?php
}
?>
<html>

<body>
    <div class="band1 w-100 mt-2" style="z-index: -1;">
        <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
        <h3 class="aemp">Dashboard</h3>
    </div>

    <div class="table-responsive" id="load_dash_tbl"></div>
    
    <script src="./assets/js/anychart-base.min.js"></script>
    <script>
    function loadDashboardTable(employeename = '') {
        $.ajax({
            url: './task.php',
            type: 'POST',
            data: {
                'action': 'loadDashboardTable',
                'employeename': employeename
            },
            success: function(resp) {
                $('#load_dash_tbl').html('');
                $('#load_dash_tbl').html(resp);
                // fetchAndCreateCharts()
            }
        })
    }
    loadDashboardTable()

    function loadInput() {
        var hiddenInputs = document.querySelectorAll('.chartNo');

        // Iterate through the selected elements and retrieve their values
        hiddenInputs.forEach(function(input) {
            var value = input.value;
            var chartdiv = "chartdiv_" + value;
            var target = document.getElementById(chartdiv);
            var spinnerContainer = target.querySelector('.loading-spinner-container');

            // Create spinner options
            var spinnerOpts = {
                lines: 12,
                length: 7,
                width: 5,
                radius: 10,
                color: '#007bff',
                speed: 1,
                trail: 60,
                className: 'spinner' // Add spinner class
            };

            // Create and start the spinner
            var spinner = new Spinner(spinnerOpts).spin(spinnerContainer);
            // Do something with the value, for example, store it in an array
            $.ajax({
                url: './task.php',
                type: 'POST',
                data: {
                    'action': 'loadChart',
                    'assign_id': value
                },
                dataType: 'json',
                success: function(resp) {
                    setTimeout(function() {
                        spinner.stop();
                        data = [{
                                x: "Open",
                                value: resp.open_task[0].task,
                                //state:"selected",
                                normal: {
                                    fill: "#800080"
                                }
                            },
                            {
                                x: "Late",
                                value: resp.late_task[0].task,
                                //state:"selected",
                                normal: {
                                    fill: "#ff0000"
                                }
                            },
                            {
                                x: "Closed",
                                value: resp.close_task[0].task,
                                //state:"selected",
                                normal: {
                                    fill: "#28a745"
                                }
                            },
                            {
                                x: "Closed But Late",
                                value: resp.late_close[0].task,
                                //state:"selected",
                                normal: {
                                    fill: "#FFA500"
                                }
                            },
                        ];

                        newData = data.slice(0, 5);
                        chart = anychart.pie(newData);
                        chart.innerRadius("50%");

                        //ADD LEGENDS HORIZONTALLY
                        var legend = chart.legend();
                        //legend.itemsLayout('vertical');
                        legend.itemsLayout("horizontal-expandable");
                        legend.align('left');

                        // var label = anychart.standalones.label();

                        var chartdiv = "chartdiv_" + value;
                        chart.container(chartdiv).height(300);

                        // label.text("Performance");

                        // label.width("100%");

                        // label.height("100%");

                        // // label.adjustFontSize(true);

                        // label.fontColor("#1976d2");

                        // label.hAlign("center");

                        // label.vAlign("middle");

                        // // set the label as the center content

                        // chart.center().content(label);



                        chart.draw();

                        var currentLabels = chart.labels();
                        // format the number
                        currentLabels.format(function() {
                            return anychart.format.number(this.value, 3, ".", ",");
                        });
                    }, 1000);
                }
            })
        });
    }
    setTimeout(() => {
        loadInput()
    }, 1000);

    $(document).on('submit', '#search_emp_form', function(e) {
        e.preventDefault();

        let search_val = $('#assign_search_text').val();


        loadDashboardTable(search_val)
        setTimeout(() => {
            loadInput()
        }, 1000);

    })

    $(document).on('submit', '#search_from', function(e) {
        e.preventDefault();

        let search_val1 = $('#assign_text').val();


        loadDashboardTable(search_val1)
        setTimeout(() => {
            loadInput()
        }, 1000);

    })
    </script>
</body>

</html>