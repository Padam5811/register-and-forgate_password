<?php
ob_start();
session_start();
include 'db.php';
$message = "";
$success = false;

if (!isset($_SESSION['reset_email'])) {
    $message = "Unauthorized access.";
} else {
    $email = $_SESSION['reset_email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password === $cpassword) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password=? WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashed, $email);
        if ($stmt->execute()) {
            $message = "✅ Password successfully changed.";
            $success = true;
            session_destroy();
        } else {
            $message = "❌ Failed to update password.";
        }
    } else {
        $message = "❌ Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Password Update</title>
  <style>
    .body {
      background: linear-gradient(to right, #f81836ff, #0072ff);
      height: 80vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .message-box {
      background: #fff;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      text-align: center;
      max-width: 400px;
      width: 90%;
    }

    .message-box h2 {
      margin-bottom: 20px;
      color: #333;
    }

    .msg {
      font-size: 18px;
      margin-top: 15px;
      padding: 10px;
      border-radius: 8px;
    }

    .msg.success {
      color: #155724;
      background-color: #d4edda;
      border: 1px solid #c3e6cb;
    }

    .msg.error {
      color: #721c24;
      background-color: #f8d7da;
      border: 1px solid #f5c6cb;
    }

    a {
      text-decoration: none;
      color: #007bff;
      margin-top: 10px;
      display: inline-block;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
<div class="body">
  <div class="message-box">
    <h2>Password Reset Status</h2>
    <div class="msg <?= $success ? 'success' : 'error' ?>">
      <?= $message ?>
    </div>
    <?php if ($success): ?>
      <a href="login.php">🔐 Go to Login</a>
    <?php else: ?>
      <a href="reset_password.php">🔁 Try Again</a>
    <?php endif; ?>
  </div>
    </div>
</body>
</html>
