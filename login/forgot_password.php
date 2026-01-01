
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Send OTP</title>
  <style>
    .body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #2193b0, #6dd5ed);
      height: 70vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .otp-box {
      background-color: white;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      max-width: 400px;
      width: 90%;
    }

    .otp-box h2 {
      margin-bottom: 20px;
      color: #333;
    }

    .otp-box input[type="email"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0 20px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    .otp-box button {
      background-color: #2193b0;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .otp-box button:hover {
      background-color: #1e7c97;
    }

    @media (max-width: 500px) {
      .otp-box {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body >
  <div class="body">

  <form action="send_otp.php" method="post" class="otp-box">
    <h2>Send OTP to Email</h2>
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Send OTP</button>
  </form>
  </div>
</body>
</html>
