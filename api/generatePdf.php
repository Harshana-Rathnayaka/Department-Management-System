<?php

session_start();
require_once '../includes/dbOperations.php';
require_once '../dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;

$response = array();

if (isset($_POST['btnSendReport']) && isset($_POST['managerEmail'])) {

    $manager_email = $_POST['managerEmail'];

    // db object
    $db = new DbOperations();

    // setting the timezone and getting today and yesterday dates
    date_default_timezone_set("Asia/Colombo");
    $today_object = new DateTime();
    $today_date = $today_object->format('Y-m-d');
    $yesterday_object = date_sub($today_object, date_interval_create_from_date_string("1 days"));
    $yesterday_date = $yesterday_object->format('Y-m-d');

    $response['today_object'] = $today_object;
    $response['today_date'] = $today_date;
    $response['yesterday_object'] = $yesterday_object;
    $response['yesterday_date'] = $yesterday_date;

    // getting orders to be sent
    $result = $db->getOrdersByDate($today_date, $yesterday_date);

    // data to be sent in the pdf
    $output = '
    <html>
    <head>
    </head>
    <body>
    <br>
    <h2 align="center">List of Orders for Today<h2>
    <table align="center" border = "1" cellspacing="0" cellpadding="5">
    <thead>
      <tr>
        <th>#</th>
        <th>Ordered By</th>
        <th>Department Name</th>
        <th>Item</th>
        <th>Quantity</th>
        <th>Details</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>';

    while ($row = mysqli_fetch_array($result)) {

        $order_status;
        if ($row['order_status'] == 0) {
          $order_status = 'Pending';
        } elseif ($row['order_status'] == 1) {
          $order_status = 'Processing';
        } elseif ($row['order_status'] == 2) {
          $order_status = 'Approved';
        } elseif ($row['order_status'] == 3) {
          $order_status = 'Cancelled';
        }
        $output .= '
        <tr>
            <td>' . $row['order_id'] . '</td>
            <td>' . $row['fullname'] . '</td>
            <td>' . $row['department_name'] . '</td>
            <td>' . $row['item'] . '</td>
            <td>' . $row['quantity'] . '</td>
            <td>' . $row['order_details'] . '</td>
            <td>' . $order_status . '</td>
        </tr>
        ';
    }

    $output .= '
    </tbody>
    </table>
    </body>
    </html>
    ';

    // echo $output;

    // creating the name of the file and the data for the file
    $file_name = md5(rand()) . '.pdf';
    $html_code = $output;

    // creating the pdf and storing in the folder
    $pdf = new Dompdf();
    $pdf->load_html($html_code);
    $pdf->render();
    $file = $pdf->output();
    file_put_contents($file_name, $file);

    // sending the email
    require_once "../PHPMailer/PHPMailer.php";
    require_once "../PHPMailer/SMTP.php";
    require_once "../PHPMailer/Exception.php";

    // email and password used to send the emails
    $sender_email = ''; // add your email here
    $sender_password = ''; // add your email password here

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
    $mail->AddAddress($manager_email);
    $mail->Subject = ('[no-reply] Daily Report');
    $mail->Body = 'Please find the Daily Orders Summary in the PDF attached.';
    $mail->AddAttachment($file_name);

    // email sent
    if ($mail->Send()) {

        $_SESSION['success'] = "Daily report sent successfully!";
        $response['error'] = false;
        $response['message'] = "Daily report sent successfully!";
        header("location:../admin/send-reports.php");

        // email not sent
    } else {

        $_SESSION['error'] = "Something went wrong, Please try again later.";
        $response['error'] = true;
        $response['message'] = "Email was not sent!";
        header("location:../admin/send-reports.php");

    }

    // deleting the file from folder after sending it
    unlink($file_name);

}

// json output
// echo json_encode($response);
