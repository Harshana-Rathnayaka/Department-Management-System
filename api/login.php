<?php

session_start();
require_once '../includes/dbOperations.php';
use PHPMailer\PHPMailer\PHPMailer;

$response = array();

// checks the method call
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['username']) and isset($_POST['password'])) {

        // db object
        $db = new DbOperations();

        // random values
        $activation_code = md5(rand());
        $otp = rand(100000, 999999);

        if ($db->userLogin($_POST['username'], $_POST['password'])) {

            // getting user data
            $user = $db->getUserByUsername($_POST['username']);

            // checks if the user is active
            if ($user['status'] == 1) {

                // getting user data to use in email and db updating
                $user_id = $user['id'];
                $user_email = $user['email'];

                // email and password used to send the emails
                $sender_email = 'example@gmail.com'; // add your email here
                $sender_password = '11111'; // add your email password here
                $message_body = '
                <p> Please use <strong>' . $otp . '</strong> as the OTP Verification code to login to your account.
                This OTP is valid till you logout.
                ';

                // update otp in database
                $updating_otp_result = $db->updateUserOTP($user_id, $activation_code, $otp);

                // if otp updating was successful
                if ($updating_otp_result == 0) {

                    // sending the user to the verification page
                    $_SESSION['Id'] = $user['id'];

                    require_once "../PHPMailer/PHPMailer.php";
                    require_once "../PHPMailer/SMTP.php";
                    require_once "../PHPMailer/Exception.php";

                    $mail = new PHPMailer(true);

                    $mail->IsSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = $sender_email;
                    $mail->Password = $sender_password;
                    $mail->Port = 587;

                    // email settings
                    $mail->IsHTML(true);
                    $mail->SetFrom($sender_email, 'Administrator');
                    $mail->AddAddress($user_email);
                    $mail->Subject = ('[no-reply] OTP Verification Code');
                    $mail->Body = $message_body;

                    // email sent
                    if ($mail->Send()) {

                        $_SESSION['success'] = "Please enter the code sent to your email.";
                        $response['error'] = false;
                        $response['message'] = "Email sent!";
                        header("location:../verification.php");

                        // email not sent
                    } else {

                        $_SESSION['error'] = "Something went wrong, Please try again later.";
                        $response['error'] = true;
                        $response['message'] = "Email was not sent!";
                        header("location:../signin.php");

                    }

                } elseif ($updating_otp_result == 1) {

                    $_SESSION['error'] = "Something went wrong. Could not update OTP code.";
                    header("location:../signin.php");
                    $response['error'] = true;
                    $response['message'] = "Something went wrong. Could not update OTP code.";

                }

            } else {

                $_SESSION['error'] = "Your account has been suspended. Please contact the administrator.";
                header("location:../signin.php");
                $response['error'] = true;
                $response['message'] = "Your account has been suspended. Please contact the administrator.";

            }
        } else {

            $_SESSION['error'] = "The username or password you entered is incorrect. Please check again.";
            header("location:../signin.php");
            $response["error"] = true;
            $response["message"] = "The username or password you entered is incorrect. Please check again.";

        }

    } else {

        $_SESSION['error'] = "Required fields are missing.";
        header("location:../signin.php");
        $response['error'] = true;
        $response["message"] = 'Required fields are missing.';

    }
}

// json output
echo json_encode($response);
