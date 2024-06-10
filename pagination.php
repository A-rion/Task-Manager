<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- DataTables.js JavaScript -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js">
</script>
<style>
/* Custom styles for DataTables pagination */
.dataTables_paginate .paginate_button {
    padding: 5px 10px;
    /* Adjust padding */
    margin-right: 5px;
    /* Adjust margin between buttons */
    border: 1px solid #ccc;
    /* Add border */
    background-color: #fff;
    /* Background color */
    color: #333;
    /* Text color */
    border-radius: 20px!important;
    /* Border radius for all page links */
}

/* Custom styles for DataTables pagination */
.dataTables_paginate .paginate_button.previous,
/* Target previous button */
.dataTables_paginate .paginate_button.next {
    /* Target next button */
    padding: 5px 10px;
    /* Adjust padding */
    margin-right: 5px;
    /* Adjust margin between buttons */
    border: 1px solid #ccc;
    /* Add border */
    background-color: #fff;
    /* Background color */
    color: #333;
    /* Text color */
    border-radius: 20px;
    /* Border radius */
}

/* Style the active page button */
.dataTables_paginate .paginate_button.current {
    background-color: #007bff;
    /* Active button background color */
    color: #fff;
    /* Active button text color */
    border-radius: 30px;
}

/* Style hover effect */
.dataTables_paginate .paginate_button:hover {
    background-color: #007bff;
    /* Hover background color */
    color: #fff;
    /* Hover text color */
    border-radius: 20px;
}

.dataTables_length label {
    font-weight: bold;
    margin-right: 10px;
}

.dataTables_wrapper .dataTables_length select {
    background-color: #ffcaca;
}

.dataTables_info {
    font-weight: bold;
    margin-right: 10px;
}
</style>