<?php

session_start();
require_once '../includes/dbOperations.php';
require_once '../includes/ipAddress.php';

$response = array();

// checks the method call
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['otp'])) {

        $entered_otp = $_POST['otp'];
        $user_id = $_SESSION['Id'];

        // db object
        $db = new DbOperations();

        // getting the ip address
        $ip = new IpAddress();
        $ip_address = $ip->getIPAddress();

        // getting user data
        $user = $db->getAccountDetails($user_id);
        $user_otp = $user['otp'];
        $user_id = $user['id'];

        // if the otp entered is correct
        if ($user_otp == $entered_otp) {

            // admin account
            if ($user['user_type'] == 0) {

                // session and reroute
                $_SESSION['UserName'] = $user['username'];
                $_SESSION['FullName'] = $user['fullname'];
                $_SESSION['Email'] = $user['email'];
                $_SESSION['Id'] = $user['id'];
                $_SESSION['UserType'] = $user['user_type'];
                $_SESSION['UserDepartment'] = $user['department_id'];

                $response['error'] = false;
                $response['message'] = "Logged in successfully!";
                $response['user_type'] = $user['user_type'];
                $response['user_department'] = $user['department_id'];

                header("location:../admin/index.php");

                // team leader account
            } elseif ($user['user_type'] == 1) {

                // session and reroute
                $_SESSION['UserName'] = $user['username'];
                $_SESSION['FullName'] = $user['fullname'];
                $_SESSION['Email'] = $user['email'];
                $_SESSION['Id'] = $user['id'];
                $_SESSION['UserType'] = $user['user_type'];
                $_SESSION['UserDepartment'] = $user['department_id'];

                $response['error'] = false;
                $response['message'] = "Logged in successfully!";
                $response['user_type'] = $user['user_type'];
                $response['user_department'] = $user['department_id'];

                $db->addToLoginLog($user_id, $ip_address);

                header("location:../leader/index.php");

                // department manager account
            } elseif ($user['user_type'] == 2) {

                // session and reroute
                $_SESSION['UserName'] = $user['username'];
                $_SESSION['FullName'] = $user['fullname'];
                $_SESSION['Email'] = $user['email'];
                $_SESSION['Id'] = $user['id'];
                $_SESSION['UserType'] = $user['user_type'];
                $_SESSION['UserDepartment'] = $user['department_id'];

                $response['error'] = false;
                $response['message'] = "Logged in successfully!";
                $response['user_type'] = $user['user_type'];
                $response['user_department'] = $user['department_id'];

                $db->addToLoginLog($user_id, $ip_address);

                header("location:../manager/index.php");

                // finance manager account
            } elseif ($user['user_type'] == 3) {

                // session and reroute
                $_SESSION['UserName'] = $user['username'];
                $_SESSION['FullName'] = $user['fullname'];
                $_SESSION['Email'] = $user['email'];
                $_SESSION['Id'] = $user['id'];
                $_SESSION['UserType'] = $user['user_type'];
                $_SESSION['UserDepartment'] = $user['department_id'];

                $response['error'] = false;
                $response['message'] = "Logged in successfully!";
                $response['user_type'] = $user['user_type'];
                $response['user_department'] = $user['department_id'];

                $db->addToLoginLog($user_id, $ip_address);

                header("location:../finance/index.php");

            } else {

                $_SESSION['error'] = "Your account is not valid.";
                header("location:../index.php");
                $response['error'] = true;
                $response['message'] = "Your account is not of a valid type.";

            }

            // if the otp entered is not correct
        } else {

            $_SESSION['error'] = "The code you entered is not correct. Please try again.";
            header("location:../verify.php");
            $response['error'] = true;
            $response["message"] = 'The code you entered is not correct. Please try again.';

        }

    } else {

        $_SESSION['missing'] = "Please enter the code sent to your email address.";
        header("location:../verify.php");
        $response['error'] = true;
        $response["message"] = 'Please enter the code sent to your email address.';

    }
}

// json output
echo json_encode($response);
