<?php
ob_start();
session_start();

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database Connection
include 'db.php';

// Get email from form
$email = $_POST['email'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo showAlert("❌ Invalid email address.", false, 'forgot_password.php');
    exit;
}

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $otp = rand(100000, 999999);
    session_regenerate_id(true);
    $_SESSION['otp'] = $otp;
    $_SESSION['reset_email'] = $email;

    $mail = new PHPMailer(true);
    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'pb228594@gmail.com';     // 🔑 तपाईंको Gmail
        $mail->Password   = 'topr dava sjyb okgx';     // 🔑 App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Sender and receiver
        $mail->setFrom('pb228594@gmail.com', 'KPI System');
        $mail->addAddress($email);
        $mail->Subject = 'OTP for Password Reset';
        $mail->Body    = "Dear user,\n\nYour OTP for password reset is: $otp\n\nPlease use this OTP to reset your password.\n\nThank you.";

        $mail->send();
        echo showAlert("✅ OTP sent successfully! Redirecting to verification page...", true, 'verify_otp.php');
    } catch (Exception $e) {
        echo showAlert("❌ OTP could not be sent. Mailer Error: {$mail->ErrorInfo}", false, 'forgot_password.php');
    }
} else {
    echo showAlert("❌ Email not found in our system.", false, 'forgot_password.php');
}

// Function to show styled alert and redirect
function showAlert($message, $success = true, $redirect = '')
{
    $color = $success ? "#4CAF50" : "#f44336";
    return "
    <style>
        .alert {
            padding: 15px;
            background-color: $color;
            color: white;
            margin: 30px auto;
            width: 90%;
            max-width: 500px;
            border-radius: 8px;
            font-family: Arial, sans-serif;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            animation: fadeIn 0.5s ease-in-out;
            text-align: center;
        }
        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }
    </style>
    <div class='alert'>$message</div>
    <script>
        setTimeout(function() {
            window.location.href = '$redirect';
        }, 3000);
    </script>
    ";
}
?>
