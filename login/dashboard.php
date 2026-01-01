<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-box">
    <h2>Welcome Dashboard</h2>
    <p style="text-align:center;font-size:18px;">
    </p>
    <br>
    <a href="logout.php">
        <button>Logout</button>
    </a>
</div>

</body>
</html>
