<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <style>
    .body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #fc6076, #ff9a44);
      height: 80vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .reset-box {
      background-color: #fff;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      max-width: 400px;
      width: 90%;
      text-align: center;
    }

    .reset-box h2 {
      margin-bottom: 20px;
      color: #333;
    }

    .reset-box input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0 20px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    .reset-box button {
      background-color: #fc6076;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .reset-box button:hover {
      background-color: #d84c63;
    }

    .message {
      margin-top: 20px;
      font-size: 16px;
      color: red;
    }

    .message.success {
      color: green;
    }
  </style>
</head>
<body>
<div class="body">
  <form action="update_password.php" method="post" class="reset-box" id="resetForm">
    <h2>Reset Your Password</h2>
    <input type="password" name="password" id="password" placeholder="New Password" required>
    <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" required>
    <button type="submit">Change Password</button>
    <div class="message" id="message"></div>
  </form>
</div>

<script>
  const form = document.getElementById('resetForm');
  const password = document.getElementById('password');
  const cpassword = document.getElementById('cpassword');
  const message = document.getElementById('message');

  form.addEventListener('submit', function(e) {
    message.textContent = '';

    // Password validation rules
    const passwordValue = password.value;
    const cpasswordValue = cpassword.value;
    const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/;

    if (!passwordPattern.test(passwordValue)) {
      e.preventDefault();
      message.textContent = "Password must be at least 8 characters, include 1 uppercase letter, 1 number, and 1 special character.";
      return;
    }

    if (passwordValue !== cpasswordValue) {
      e.preventDefault();
      message.textContent = "Passwords do not match!";
      return;
    }
  });
</script>
