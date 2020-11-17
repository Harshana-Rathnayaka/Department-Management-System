<?php

session_start();
require_once '../includes/dbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['fullname']) &&
        isset($_POST['username']) &&
        isset($_POST['email']) &&
        isset($_POST['password']) &&
        isset($_POST['usertype']) &&
        isset($_POST['department'])) {

        $fullname = trim($_POST['fullname']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $usertype = $_POST['usertype'];
        $department = $_POST['department'];

        // we can operate the data further
        $db = new DbOperations();

        $result = $db->createUser(
            $fullname,
            $username,
            $email,
            $password,
            $usertype,
            $department
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
