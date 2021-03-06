<?php

session_start();
require_once '../includes/dbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['Id']) && isset($_SESSION['UserDepartment']) && isset($_POST['orderDetails'])
        && isset($_POST['item']) && $_POST['quantity']) {

        // we can operate the data further
        $db = new DbOperations();

        $user_id = $_SESSION['Id'];
        $department_id = $_SESSION['UserDepartment'];
        $item = trim($_POST['item']);
        $quantity = trim($_POST['quantity']);
        $order_details = trim($_POST['orderDetails']);

        $result = $db->placeOrder($user_id, $department_id, $item, $quantity, $order_details
        );

        if ($result == 1) {

            // success
            $_SESSION['success'] = "Order placed successfully!";
            $response['error'] = false;
            $response['message'] = "Order placed successfully!";
            header("location:../leader/index.php");
        } elseif ($result == 2) {

            // some error
            $_SESSION['error'] = "Something went wrong, please try again later.";
            $response['error'] = true;
            $response['message'] = "Something went wrong, please try again later.";
            header("location:../leader/index.php");
        }
    } else {
        // missing fields
        $_SESSION['missing'] = "Required fields are missing.";
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
        header("location:../leader/index.php");
    }
} else {
    // wrong method
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

// json output
// echo json_encode($response);
