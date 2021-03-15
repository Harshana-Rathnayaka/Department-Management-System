<?php

session_start();

require_once '../includes/dbOperations.php';

$response = array();

$user_type = $_SESSION['UserType'];

if (!isset($_POST['changePasswordBtn'])) {

    // some fields are missing
    $_SESSION['missing'] = "Please fill in all the details.";
    $response['error'] = true;
    $response['message'] = "Please fill in all the details";

    if ($user_type == 0) {
        header("location:../admin/change-password.php");
    } elseif ($user_type == 1) {
        header("location:../leader/change-password.php");
    } elseif ($user_type == 2) {
        header("location:../manager/change-password.php");
    } else {
        header("location:../finance/change-password.php");
    }

} elseif (isset($_POST['userId']) && isset($_POST['currentPassword'])
    && isset($_POST['newPassword']) && isset($_POST['confirmNewPassword'])) {

    // getting the values
    $user_id = $_POST['userId'];
    $current_password = md5(trim($_POST['currentPassword']));
    $new_password = md5(trim($_POST['newPassword']));
    $confirm_new_password = md5(trim($_POST['confirmNewPassword']));

    // db object
    $db = new DbOperations();

    // getting the password from the db
    $user = $db->getAccountDetails($user_id);
    $passwordInDb = $user['password'];

    // checking if the old password match with the db
    if ($current_password == $passwordInDb) {

        // checking whether the new passwords match
        if ($new_password == $confirm_new_password) {

            // changing the password in the db
            $result = $db->changePassword($user_id, $new_password);

            if ($result == 1) {

                // some error
                $_SESSION['error'] = "Something went wrong, please try again.";
                $response['error'] = true;
                $response['message'] = "Something went wrong, please try again.";

                // sending to page according to account type
                if ($user_type == 0) {
                    header("location:../admin/change-password.php");
                } elseif ($user_type == 1) {
                    header("location:../leader/change-password.php");
                } elseif ($user_type == 2) {
                    header("location:../manager/change-password.php");
                } else {
                    header("location:../finance/change-password.php");
                }

            } elseif ($result == 0) {

                // success
                $_SESSION['success'] = "Password changed successfully!";
                $response['error'] = false;
                $response['message'] = "Password changed successfully";

                header("location:../logout.php?logout");
                // // sending to page according to account type
                // if ($user_type == 0) {
                //     header("location:../admin/change-password.php");
                // } elseif ($user_type == 1) {
                //     header("location:../leader/change-password.php");
                // } elseif ($user_type == 2) {
                //     header("location:../manager/change-password.php");
                // } else {
                //     header("location:../finance/change-password.php");
                // }

            }
        } else {

            // new passwords dont match
            $_SESSION['error'] = "The new passwords you entered do not match, please check again!";
            $response['error'] = true;
            $response['message'] = "The new passwords you entered do not match, please check again!";

            // sending to page according to account type
            if ($user_type == 0) {
                header("location:../admin/change-password.php");
            } elseif ($user_type == 1) {
                header("location:../leader/change-password.php");
            } elseif ($user_type == 2) {
                header("location:../manager/change-password.php");
            } else {
                header("location:../finance/change-password.php");
            }
        }

    } else {

        // old password doesnt match
        $_SESSION['error'] = "The old password you entered does not match, please check again!";
        $response['error'] = true;
        $response['message'] = "The old password you entered does not match, please check again!";

        // sending to page according to account type
        if ($user_type == 0) {
            header("location:../admin/change-password.php");
        } elseif ($user_type == 1) {
            header("location:../leader/change-password.php");
        } elseif ($user_type == 2) {
            header("location:../manager/change-password.php");
        } else {
            header("location:../finance/change-password.php");
        }
    }

} else {

    // some fields are missing
    $_SESSION['missing'] = "Please fill in all the details.";
    $response['error'] = true;
    $response['message'] = "Please fill in all the details";

    if ($user_type == 0) {
        header("location:../admin/change-password.php");
    } elseif ($user_type == 1) {
        header("location:../leader/change-password.php");
    } elseif ($user_type == 2) {
        header("location:../manager/change-password.php");
    } else {
        header("location:../finance/change-password.php");
    }

}

// echo json_encode($response);
