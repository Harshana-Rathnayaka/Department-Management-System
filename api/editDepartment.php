<?php

session_start();

require_once '../includes/dbOperations.php';

$response = array();

if (!isset($_POST['editDepartmentBtn'])) {
    // some fields are missing
    $_SESSION['missing'] = "Please fill in all the details";
    $response['error'] = true;
    $response['message'] = "Please fill in all the details";
    header("location:../admin/index.php");

} else {

    // getting the values
    $department_id = $_POST['departmentId'];
    $department_name = $_POST['editDepartmentName'];

    // db object
    $db = new DbOperations();

    $result = $db->updateDepartments($department_id, $department_name);

    if ($result == 1) {
        // some error
        $_SESSION['error'] = "Something went wrong, please try again.";
        $response['error'] = true;
        $response['message'] = "Something went wrong, please try again.";
        header("location:../admin/index.php");

    } elseif ($result == 0) {
        // success
        $_SESSION['success'] = "Department updated successfully!";
        $response['error'] = false;
        $response['message'] = "Department details updated successfully";
        header("location:../admin/index.php");
    }
}

echo json_encode($response);
