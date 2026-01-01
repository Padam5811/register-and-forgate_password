<?php
session_start();
include 'db.php'; // Database connection

if(isset($_POST['login'])) {
    $identifier = trim($_POST['email']); // username or email field
    $password = $_POST['password'];

    if(empty($identifier) || empty($password)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit();
    }

    // Check if user exists in database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? OR username=? LIMIT 1");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if(password_verify($password, $user['password'])) {
            // Check if email is verified (if you have a column like is_verified)
    

            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            // Redirect to dashboard or home
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.history.back();</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-box">
    <h2>Login</h2>

    <form method="POST">
        <input type="text" name="email" placeholder="Username or Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>

    <p style="text-align:center; margin-top:10px;">
        <a href="forgot_password.php">Forgot Password?</a>
    </p>

    <p>Don't have an account? <a href="register.php">Register</a></p>
</div>

</body>
</html>

