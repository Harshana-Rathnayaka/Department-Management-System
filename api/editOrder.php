<?php

session_start();

require_once '../includes/dbOperations.php';

$response = array();

if (!isset($_POST['editOrderBtn'])) {

    // some fields are missing
    $_SESSION['missing'] = "Please fill in all the details";
    $response['error'] = true;
    $response['message'] = "Please fill in all the details";
    header("location:../leader/index.php");

} else {

    // getting the values
    $order_id = $_POST['orderId'];
    $order_details = $_POST['editOrderDetails'];
    $cancel = $_POST['cancelOrderCheckbox'];

    // db object
    $db = new DbOperations();

    $result = $db->updateOrderByUser($order_id, $order_details, $cancel);

    if ($result == 1) {
        // some error
        $_SESSION['error'] = "Something went wrong, please try again.";
        $response['error'] = true;
        $response['message'] = "Something went wrong, please try again.";
        header("location:../leader/index.php");

    } elseif ($result == 0) {
        // success
        $_SESSION['success'] = "Order details updated successfully!";
        $response['error'] = false;
        $response['message'] = "Order details updated successfully";
        header("location:../leader/index.php");
    }
}

echo json_encode($response);
