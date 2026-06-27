<?php

session_start();
include("includes/config.php");

$message = "";
$messageType = "";

if (isset($_GET['registered'])) {
    $message = "Registration Successful! Please login.";
    $messageType = "success";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, trim($_POST["email"]));
    $password = $_POST["password"];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($query) == 1) {

        $user = mysqli_fetch_assoc($query);

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["full_name"] = $user["full_name"];
            $_SESSION["email"] = $user["email"];

            header("Location: dashboard.php");
            exit();

        } else {

            $message = "Invalid Password!";
            $messageType = "error";

        }

    } else {

        $message = "Email not found!";
        $messageType = "error";

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login | Academic Peer Connector</title>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/auth.css">

</head>

<body>

<div class="auth-container">

<div class="auth-card">

<div class="auth-header">

<h1>🎓 APC</h1>

<h2>Welcome Back</h2>

<p>Login to continue your learning journey.</p>

</div>

<?php
if($message!=""){
    echo "<div class='message ".$messageType."'>$message</div>";
}
?>

<form method="POST">

<div class="input-group">

<label>Email Address</label>

<input
type="email"
name="email"
required>

</div>

<div class="input-group">

<label>Password</label>

<input
type="password"
name="password"
required>

</div>

<button class="auth-btn">

Login

</button>

</form>

<div class="auth-footer">

Don't have an account?

<a href="register.php">

Register

</a>

</div>

</div>

</div>

</body>

</html>