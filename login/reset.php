<?php
include 'db.php';
$email = $_GET['email'];

if(isset($_POST['reset'])){
    $code = $_POST['code'];
    $newpass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn,
        "SELECT * FROM users WHERE email='$email' AND reset_code='$code'"
    );

    if(mysqli_num_rows($check)==1){
        mysqli_query($conn,
            "UPDATE users SET password='$newpass', reset_code=NULL WHERE email='$email'"
        );
        echo "Password updated! <a href='login.php'>Login</a>";
    }else{
        echo "Wrong code!";
    }
}
?>

<form method="POST">
    <h2>Reset Password</h2>
    <input name="code" placeholder="Reset code" required><br><br>
    <input type="password" name="password" placeholder="New password" required><br><br>
    <button name="reset">Update</button>
</form>
