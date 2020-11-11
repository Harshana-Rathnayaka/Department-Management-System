<?php

require_once '../includes/dbOperations.php';
$response = array();

if (isset($_SESSION['Id'])) {

    $user_id = $_SESSION['Id'];

    // db object
    $db = new DbOperations();

    // department list
    $departments = $db->getDepartments();

    // users list
    $users = $db->getUsers();

    // orders lits
    $orders = $db->getOrdersByUserId($user_id);

} else {
    $_SESSION['error'] = "Session timed out. Please login to continue.";
    $response['error'] = true;
    $response['message'] = "Session timed out. Please login to continue.";
}

// echo json_encode($response);
