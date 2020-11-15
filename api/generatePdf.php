<?php

session_start();
require_once '../includes/dbOperations.php';

$response = array();

if (isset($_POST['btnGeneratePdf'])) {

    // db object
    $db = new DbOperations();

    // setting the timezone and getting today and yesterday dates
    date_default_timezone_set("Asia/Colombo");
    $today_object = new DateTime();
    $today_date = $today_object->format('Y-m-d');
    $yesterday_object = date_sub($today_object, date_interval_create_from_date_string("1 days"));
    $yesterday_date = $yesterday_object->format('Y-m-d');

    $response['today_object'] = $today_object;
    $response['today_date'] = $today_date;
    $response['yesterday_object'] = $yesterday_object;
    $response['yesterday_date'] = $yesterday_date;

    $result = $db->getOrdersByDate($today_date, $yesterday_date);

    // $response['num_rows'] = mysqli_num_rows($result);

    // while ($row = mysqli_fetch_array($result)):

        
    //        echo  $row['item'];
    //     //    echo  $row['order_details'];
        
    // endwhile;

    // // $response['result'] = $result;
}

// json output
// echo json_encode($response);
