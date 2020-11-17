<?php

session_start();
require_once '../includes/dbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['departmentName'])) {

        $department_name = trim($_POST['departmentName']);

        // we can operate the data further
        $db = new DbOperations();

        $result = $db->createDepartment($department_name);

        if ($result == 1) {

            // success
            $_SESSION['success'] = "Department created successfully!";
            $response['error'] = false;
            $response['message'] = "Department created successfully!";
            header("location:../admin/index.php");

        } elseif ($result == 2) {

            // some error
            $_SESSION['error'] = "Something went wrong, please try again later.";
            $response['error'] = true;
            $response['message'] = "Something went wrong, please try again later.";
            header("location:../admin/index.php");

        } elseif ($result == 0) {

            // department exists
            $_SESSION['error'] = "It seems that this department has already been created.";
            $response['error'] = true;
            $response['message'] = "It seems that this department has already been created.";
            header("location:../admin/index.php");

        }
    } else {

        // missing fields
        $_SESSION['missing'] = "Required fields are missing.";
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
        header("location:../admin/index.php");

    }
} else {

    // wrong method
    $response['error'] = true;
    $response['message'] = "Invalid Request";
    
}

// json output
// echo json_encode($response);
