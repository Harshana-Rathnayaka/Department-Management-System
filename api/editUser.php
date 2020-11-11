<?php

session_start();

require_once '../includes/dbOperations.php';

$response = array();

if (!isset($_POST['editUserBtn'])) {
    // some fields are missing
    $_SESSION['missing'] = "Please fill in all the details.";
    $response['error'] = true;
    $response['message'] = "Please fill in all the details";
    header("location:../admin/users.php");

} else {

    // getting the values
    $user_id = $_POST['editUserId'];
    $user_status = $_POST['editUserStatus'];

    $response['id'] = $user_id = $_POST['editUserId'];
    $response['status'] = $_POST['editUserStatus'];

    // db object
    $db = new DbOperations();

    $result = $db->updateUserStatus($user_id, $user_status);

    if ($result == 1) {
        // some error
        $_SESSION['error'] = "Something went wrong, please try again.";
        $response['error'] = true;
        $response['message'] = "Something went wrong, please try again.";
        header("location:../admin/users.php");

    } elseif ($result == 0) {
        // success
        $_SESSION['success'] = "User account updated successfully!";
        $response['error'] = false;
        $response['message'] = "User account updated successfully";
        header("location:../admin/users.php");
    }
}

echo json_encode($response);
