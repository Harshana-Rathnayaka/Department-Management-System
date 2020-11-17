<?php

session_start();
require_once '../includes/dbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['name']) && isset($_POST['email'])) {

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);

        // we can operate the data further
        $db = new DbOperations();

        $result = $db->createEmail($name, $email);

        if ($result == 0) {

            // success
            $_SESSION['success'] = "Email added successfully!";
            $response['error'] = false;
            $response['message'] = "Email added successfully!";
            header("location:../admin/send-reports.php");

        } elseif ($result == 1) {

            // some error
            $_SESSION['error'] = "Something went wrong, please try again later.";
            $response['error'] = true;
            $response['message'] = "Something went wrong, please try again later.";
            header("location:../admin/send-reports.php");

        }
    } else {

        // missing fields
        $_SESSION['missing'] = "Required fields are missing.";
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
        header("location:../admin/send-reports.php");

    }
} else {

    // wrong method
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

// json output
// echo json_encode($response);
