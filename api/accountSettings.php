<?php

session_start();

require_once '../includes/dbOperations.php';

$response = array();

if (!isset($_POST['editAccountInfoBtn'])) {

    // some fields are missing
    $_SESSION['missing'] = "Please fill in all the details.";
    $response['error'] = true;
    $response['message'] = "Please fill in all the details";
    header("location:../admin/settings.php");

} elseif (isset($_POST['userId']) && isset($_POST['fullname'])
    && isset($_POST['username']) && isset($_POST['email'])) {

    // getting the values
    $user_id = $_POST['userId'];
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    // db object
    $db = new DbOperations();

    $result = $db->updateProfile($user_id, $fullname, $username, $email);

    if ($result == 1) {

        // some error
        $_SESSION['error'] = "Something went wrong, please try again.";
        $response['error'] = true;
        $response['message'] = "Something went wrong, please try again.";
        header("location:../admin/settings.php");

    } elseif ($result == 0) {

        // success
        $_SESSION['success'] = "Profile updated successfully!";
        $response['error'] = false;
        $response['message'] = "Profile updated successfully";
        header("location:../admin/settings.php");

    }
} else {

    // some fields are missing
    $_SESSION['missing'] = "Please fill in all the details.";
    $response['error'] = true;
    $response['message'] = "Please fill in all the details";
    header("location:../admin/settings.php");

}

// echo json_encode($response);
