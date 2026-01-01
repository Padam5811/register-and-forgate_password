<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Verify OTP</title>
  <style>
    .body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #00c6ff, #0072ff);
      height: 70vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .verify-box {
      background-color: white;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      max-width: 400px;
      width: 90%;
    }

    .verify-box h2 {
      margin-bottom: 20px;
      color: #333;
    }

    .verify-box input[type="number"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0 20px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    .verify-box button {
      background-color: #0072ff;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .verify-box button:hover {
      background-color: #005ec2;
    }

    .message {
      margin-top: 20px;
      font-size: 16px;
      color: red;
    }

    .message.success {
      color: green;
    }

    a {
      color: #0072ff;
      text-decoration: none;
      font-weight: bold;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
<div class="body">
  <form action="" method="post" class="verify-box">
    <h2>Verify OTP</h2>
    <input type="number" name="otp" placeholder="Enter OTP" required>
    <button type="submit">Verify OTP</button>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if ($_POST['otp'] == $_SESSION['otp']) {
            echo "<div class='message success'>✅ OTP Verified. <br><a href='reset_password.php'>Click here to reset password</a></div>";
        } else {
            echo "<div class='message'>❌ Invalid OTP. Please try again.</div>";
        }
    }
    ?>
  </form>
  </div>
</body>
</html>
