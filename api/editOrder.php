<?php

session_start();

require_once '../includes/dbOperations.php';

$response = array();

// db object
$db = new DbOperations();

// check which button has been clicked
if (!isset($_POST['editOrderBtn']) && !isset($_POST['approveOrderManager'])
    && !isset($_POST['approveOrderFinance']) && !isset($_POST['rejectOrderManager'])
    && !isset($_POST['rejectOrderFinance'])) {

    // some fields are missing
    $_SESSION['missing'] = "Please fill in all the details";
    $response['error'] = true;
    $response['message'] = "Please fill in all the details";
    header("location:../leader/index.php");

} else {

    // if the leader's order edit button was clicked
    if (isset($_POST['editOrderBtn'])) {

        // getting the values
        $order_id = $_POST['orderId'];
        $item = trim($_POST['editItem']);
        $quantity = trim($_POST['editQuantity']);
        $order_details = trim($_POST['editOrderDetails']);
        $cancel = $_POST['cancelOrderCheckbox'];

        $result = $db->updateOrderByUser($order_id, $item, $quantity, $order_details, $cancel);

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

        // if the manager approves the order
    } elseif (isset($_POST['approveOrderManager'])) {

        // getting the values
        $order_id = $_POST['orderId'];

        $result = $db->updateOrderStatus($order_id, 1);

        if ($result == 1) {
            // some error
            $_SESSION['error'] = "Something went wrong, please try again.";
            $response['error'] = true;
            $response['message'] = "Something went wrong, please try again.";
            header("location:../manager/index.php");

        } elseif ($result == 0) {
            // success
            $_SESSION['success'] = "Order approved successfully!";
            $response['error'] = false;
            $response['message'] = "Order approved successfully";
            header("location:../manager/index.php");
        }

        // if the finance department approves the order
    } elseif (isset($_POST['approveOrderFinance'])) {

        // getting the values
        $order_id = $_POST['orderId'];

        $result = $db->updateOrderStatus($order_id, 2);

        if ($result == 1) {
            // some error
            $_SESSION['error'] = "Something went wrong, please try again.";
            $response['error'] = true;
            $response['message'] = "Something went wrong, please try again.";
            header("location:../finance/index.php");

        } elseif ($result == 0) {
            // success
            $_SESSION['success'] = "Order confirmed successfully!";
            $response['error'] = false;
            $response['message'] = "Order confirmed successfully";
            header("location:../finance/index.php");
        }

        // if the manager rejects the order
    } elseif (isset($_POST['rejectOrderManager'])) {

        // getting the values
        $order_id = $_POST['orderId'];

        $result = $db->updateOrderStatus($order_id, 3);

        if ($result == 1) {
            // some error
            $_SESSION['error'] = "Something went wrong, please try again.";
            $response['error'] = true;
            $response['message'] = "Something went wrong, please try again.";
            header("location:../manager/index.php");

        } elseif ($result == 0) {
            // success
            $_SESSION['success'] = "Order rejected successfully!";
            $response['error'] = false;
            $response['message'] = "Order rejected successfully";
            header("location:../manager/index.php");
        }

        // if the finance rejects department rejects the order
    } elseif (isset($_POST['rejectOrderFinance'])) {

        // getting the values
        $order_id = $_POST['orderId'];

        $result = $db->updateOrderStatus($order_id, 3);

        if ($result == 1) {
            // some error
            $_SESSION['error'] = "Something went wrong, please try again.";
            $response['error'] = true;
            $response['message'] = "Something went wrong, please try again.";
            header("location:../finance/index.php");

        } elseif ($result == 0) {
            // success
            $_SESSION['success'] = "Order rejected successfully!";
            $response['error'] = false;
            $response['message'] = "Order rejected successfully";
            header("location:../finance/index.php");
        }
    }

}

echo json_encode($response);
