<?php

session_start();
require_once '../includes/dbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['fullname']) and
        isset($_POST['username']) and
        isset($_POST['email']) and
        isset($_POST['password']) and
        isset($_POST['usertype']) and
        isset($_POST['department'])
    ) {

        // we can operate the data further
        $db = new DbOperations();

        $result = $db->createUser(
            $_POST['fullname'],
            $_POST['username'],
            $_POST['email'],
            $_POST['password'],
            $_POST['usertype'],
            $_POST['department']
        );

        if ($result == 1) {

            // success

            $user = $db->getUserByUsername($_POST['username']);

            $response['error'] = false;
            $response['message'] = "User created successfully!";
            $_SESSION['success'] = "User created successfully!";

            header("location:../admin/users.php");
        } elseif ($result == 2) {

            // some error
            $_SESSION['error'] = "Something went wrong, please try again later.";
            $response['error'] = true;
            $response['message'] = "Something went wrong, please try again later.";
            header("location:../admin/users.php");

        } elseif ($result == 0) {

            // user exists
            $_SESSION['error'] = "It seems that this user already exists, please choose a different email and username.";
            $response['error'] = true;
            $response['message'] = "It seems that this user already exists, please choose a different email and username";
            header("location:../admin/users.php");
        }
    } else {

        // missing fields
        $_SESSION['missing'] = "Required fields are missing.";
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
        header("location:../admin/users.php");

    }
} else {
    
    // wrong method
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

// json output
// echo json_encode($response);
