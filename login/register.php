<?php
session_start();
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'db.php';

if(isset($_POST['register'])) {
    // Correct keys matching HTML form
    $username = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $image = $_FILES['Image']['name'];
    $tmp = $_FILES['Image']['tmp_name'];
    $otp = rand(100000, 999999);

    // Upload file
    if($image) {
        move_uploaded_file($tmp, "uploads/" . $image);
    }

    // Store data in session temporarily
    $_SESSION['register_data'] = [
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'image' => $image,
        'otp' => $otp
    ];

    // Send OTP via email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username   = 'pb228594@gmail.com'; // 🔑 Gmail
        $mail->Password   = 'topr dava sjyb okgx'; // App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('pb228594@gmail.com', 'KPI System');
        $mail->addAddress($email); // Correct email from form
        $mail->Subject = 'Email Verification OTP';
        $mail->Body = "Your OTP for email verification is: $otp";

        $mail->send();
        echo "<script>alert('OTP sent to your email'); window.location.href='verify_registration_otp.php';</script>";
    } catch (Exception $e) {
        echo "❌ Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-box">
    <h2>Register</h2>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="file" name="Image" required>
        <button type="submit" name="register">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</div>

</body>
</html>
