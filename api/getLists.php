<?php

require_once '../includes/dbOperations.php';
$response = array();

if (isset($_SESSION['Id']) && isset($_SESSION['UserDepartment'])) {

    $user_id = $_SESSION['Id'];
    $department_id = $_SESSION['UserDepartment'];

    // db object
    $db = new DbOperations();

    // lists for admin
    $departments_admin = $db->getDepartments();
    $users_admin = $db->getUsers();
    $orders_admin = $db->getOrders();
    $emails_admin = $db->getEmails();

    // lists for leader
    $pending_orders_leader = $db->getPendingOrdersByUserId($user_id);
    $cancelled_orders_leader = $db->getCancelledOrdersByUserId($user_id);
    $completed_orders_leader = $db->getCompletedOrdersByUserId($user_id);
    $all_orders_leader = $db->getAllOrdersByUserId($user_id);

    // orders for departments by department id
    $all_orders_department = $db->getAllOrdersByDepartment($department_id);
    $pending_orders_department = $db->getPendingOrdersByDepartment($department_id);
    $rejected_orders_department = $db->getRejectedOrdersByDepartment($department_id);
    $completed_orders_department = $db->getCompletedOrdersByDepartment($department_id);

    // orders for finance department
    $pending_orders_finance = $db->getPendingOrdersForFinance();
    $rejected_orders_finance = $db->getCancelledOrdersForFinance();
    $completed_orders_finance = $db->getCompletedOrdersForFinance();
    $all_orders_finance = $db->getAllOrdersForFinance();

    // get account details for all
    $account_details_all = $db->getAccountDetails($user_id);

} else {
    $_SESSION['error'] = "Session timed out. Please login to continue.";
    $response['error'] = true;
    $response['message'] = "Session timed out. Please login to continue.";
}

// echo json_encode($response);
