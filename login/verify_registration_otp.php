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
        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .body {
            background: linear-gradient(120deg, #00c6ff, #0072ff);
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .wrapper {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        form input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: 0.3s;
            font-size: 16px;
        }

        form input[type="number"]:focus {
            border-color: #0072ff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 114, 255, 0.4);
        }

        button[type="submit"] {
            background: #0072ff;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }

        button[type="submit"]:hover {
            background: #0056d1;
        }
    </style>
</head>
<body>
    <div class="body">

<div class="wrapper">
    <form method="post">
        <h2>Enter OTP</h2>
        <input type="number" name="otp" placeholder="Enter OTP" required>
        <button type="submit" name="verify">Verify OTP</button>
    </form>
</div>
</div>
</body>
</html>
<?php

if (isset($_POST['verify'])) {
    if (!isset($_SESSION['register_data']) || !isset($_SESSION['register_data']['otp'])) {
        echo "<script>alert('Registration data not found or OTP not set. Please register again.'); window.location.href='register.php';</script>";
        session_destroy();
        exit();
    }

    if ($_POST['otp'] == $_SESSION['register_data']['otp']) {
        $data = $_SESSION['register_data'];

      include 'db.php';


        // Check if email already exists in student_users table
        $checkStudent = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $checkStudent->bind_param("s", $data['email']);
        $checkStudent->execute();
        $resultStudent = $checkStudent->get_result();


        if ($resultStudent->num_rows > 0) {
            echo "<script>alert('This email is already registered as a student!'); window.location.href='register.php';</script>";
            session_destroy();
            exit();
        } 

        $stmt = $conn->prepare("INSERT INTO users (username, email, password,  profile_image) VALUES ( ?, ?, ?, ?)");
        $stmt->bind_param("ssss", $data['username'], $data['email'], $data['password'],  $data['image']);


        if ($stmt->execute()) {
            echo "<script>alert('Registration Successful!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error inserting into DB: " . $stmt->error . "');</script>";
        }

        $stmt->close();
        $checkStudent->close();
        $checkAlumni->close();
        $conn->close();
        session_destroy(); // Destroy session after successful registration
    } else {
        echo "<script>alert('Invalid OTP.');</script>";
    }
}
?>
