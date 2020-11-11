<?php

session_start();
require_once '../includes/dbOperations.php';

$response = array();

// checks the method call
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['username']) and isset($_POST['password'])) {

        // db object
        $db = new DbOperations();

        if ($db->userLogin($_POST['username'], $_POST['password'])) {

            // getting user data
            $user = $db->getUserByUsername($_POST['username']);

            // checks if the user is active
            if ($user['status'] == 1) {

                // session and reroute
                $_SESSION['UserName'] = $_POST['username'];
                $_SESSION['FullName'] = $user['fullname'];
                $_SESSION['Email'] = $user['email'];
                $_SESSION['Id'] = $user['id'];
                $_SESSION['UserType'] = $user['user_type'];

                $response['error'] = false;
                $response['message'] = "Logged in successfully!";
                $response['user_type'] = $user['user_type'];

                // admin account
                if ($user['user_type'] == 0) {
                    header("location:../admin/index.php");

                    // team leader account
                } elseif ($user['user_type'] == 0) {
                    header("location:../leader/index.php");

                    // department manager account
                } elseif ($user['user_type'] == 2) {
                    header("location:../department/index.php");

                    // finance manager account
                } elseif ($user['user_type'] == 3) {
                    header("location:../finance/index.php");

                } else {
                    $_SESSION['error'] = "Your account is not valid.";
                    header("location:../signin.php");

                    $response['error'] = true;
                    $response['message'] = "Your account is not of a valid type.";
                }
            } else {
                $_SESSION['error'] = "Your account is deleted. Please create a new account or contact the administrator.";
                header("location:../signin.php");

                $response['error'] = true;
                $response['message'] = "Your request hasn't been approved yet. Please try again later.";
            }
        } else {
            $_SESSION['error'] = "The username or password you entered is incorrect. Please check again.";
            header("location:../signin.php");

            $response['error'] = true;
            $response['message'] = "Invalid username or password";
        }
    } else {
        header("location:../signin.php");
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }
} else {
    // wrong method
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

// json output
echo json_encode($response);
