<?php

include("includes/config.php");

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = mysqli_real_escape_string($conn, trim($_POST["full_name"]));
    $email = mysqli_real_escape_string($conn, trim($_POST["email"]));
    $department = mysqli_real_escape_string($conn, trim($_POST["department"]));
    $semester = mysqli_real_escape_string($conn, trim($_POST["semester"]));
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check Password

    if ($password != $confirm_password) {

        $message = "Passwords do not match!";
        $messageType = "error";

    } else {

        // Check Email Exists

        $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

        if (mysqli_num_rows($checkEmail) > 0) {

            $message = "Email already registered!";
            $messageType = "error";

        } else {

            // Encrypt Password

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert Data

            $sql = "INSERT INTO users(full_name,email,department,semester,password)
                    VALUES('$full_name','$email','$department','$semester','$hashedPassword')";

            if (mysqli_query($conn, $sql)) {

                header("Location: login.php?registered=1");
                exit();

            } else {

                $message = "Registration Failed!";

                $messageType = "error";

            }

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register | Academic Peer Connector</title>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/auth.css">

</head>

<body>

<div class="auth-container">

<div class="auth-card">

<div class="auth-header">

<h1>🎓 APC</h1>

<h2>Create Your Account</h2>

<p>

Join thousands of students learning together.

</p>

</div>

<?php

if($message!=""){

echo "<div class='message ".$messageType."'>$message</div>";

}

?>

<form method="POST">

<div class="input-group">

<label>Full Name</label>

<input
type="text"
name="full_name"
required>

</div>

<div class="input-group">

<label>Email Address</label>

<input
type="email"
name="email"
required>

</div>

<div class="input-group">

<label>Department</label>

<input
type="text"
name="department"
required>

</div>

<div class="input-group">

<label>Semester</label>

<select name="semester" required>

<option value="">Select Semester</option>

<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>

</select>

</div>

<div class="input-group">

<label>Password</label>

<input
type="password"
name="password"
required>

</div>

<div class="input-group">

<label>Confirm Password</label>

<input
type="password"
name="confirm_password"
required>

</div>

<button class="auth-btn">

Create Account

</button>

</form>

<div class="auth-footer">

Already have an account?

<a href="login.php">

Login

</a>

</div>

</div>

</div>

</body>

</html>