<?php
    include "./db_connection.php";

    $hauling_no = mysqli_real_escape_string($conn, $_POST['formnumber']);
    $hauling_date = mysqli_real_escape_string($conn, $_POST['date']);
    $hauling_deliverTo = mysqli_real_escape_string($conn, $_POST['delivername']);
    $hauling_hauledFrom = mysqli_real_escape_string($conn, $_POST['hauledfrom']);
    $hauling_quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $hauling_unit = mysqli_real_escape_string($conn, $_POST['unit']);
    $hauling_matname = mysqli_real_escape_string($conn, $_POST['articles']);
    $hauling_hauledBy = mysqli_real_escape_string($conn, $_POST['hauledby']);
    $hauling_warehouseman = mysqli_real_escape_string($conn, $_POST['warehouseman']);
    $hauling_approvedBy = mysqli_real_escape_string($conn, $_POST['approvedby']);
    $hauling_truckDetailsType = mysqli_real_escape_string($conn, $_POST['truck_type']);
    $hauling_truckDetailsPlateNo = mysqli_real_escape_string($conn, $_POST['truck_plate']);
    $hauling_truckDetailsPo = mysqli_real_escape_string($conn, $_POST['truck_po']);
    $hauling_truckDetailsHaulerDr = mysqli_real_escape_string($conn, $_POST['truck_hauler']);

    echo $hauling_truckDetailsHaulerDr;