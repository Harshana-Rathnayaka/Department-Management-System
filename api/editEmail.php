<?php

session_start();

require_once '../includes/dbOperations.php';

$response = array();

// db object
$db = new DbOperations();

// if the button was clicked
if (isset($_POST['editEmailBtn'])) {

    // getting the values
    $senior_manager_id = $_POST['editSeniorManagerId'];
    $senior_manager_name = trim($_POST['editName']);
    $senior_manager_email = trim($_POST['editEmail']);

    $result = $db->updateEmail($senior_manager_id, $senior_manager_name, $senior_manager_email);

    if ($result == 1) {

        // some error
        $_SESSION['error'] = "Something went wrong, please try again.";
        $response['error'] = true;
        $response['message'] = "Something went wrong, please try again.";
        header("location:../admin/send-reports.php");

    } elseif ($result == 0) {

        // success
        $_SESSION['success'] = "Senior Manager account updated successfully!";
        $response['error'] = false;
        $response['message'] = "Senior Manager account updated successfully";
        header("location:../admin/send-reports.php");
    }

} else {

    // some fields are missing
    $_SESSION['missing'] = "Please fill in all the details";
    $response['error'] = true;
    $response['message'] = "Please fill in all the details";
    header("location:../admin/send-reports.php");

}

echo json_encode($response);
