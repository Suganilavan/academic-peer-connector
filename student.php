<?php
session_start();
include("includes/config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: search.php");
    exit();
}

$student_id = (int) $_GET["id"];

$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$student_id'");

if (mysqli_num_rows($query) == 0) {
    die("Student not found.");
}

$student = mysqli_fetch_assoc($query);

/* Check if connection already exists */

$current_user = $_SESSION["user_id"];

$check = mysqli_query($conn,
"SELECT * FROM connections
WHERE sender_id='$current_user'
AND receiver_id='$student_id'");

$alreadySent = mysqli_num_rows($check) > 0;

/* Send Connection Request */

if (isset($_POST["connect"]) && !$alreadySent) {

    mysqli_query($conn,"
    INSERT INTO connections
    (sender_id,receiver_id,status)
    VALUES
    ('$current_user','$student_id','Pending')
    ");

    mysqli_query($conn,"
    INSERT INTO notifications
    (user_id,message)
    VALUES
    (
    '$student_id',
    '".$_SESSION["full_name"]." sent you a connection request.'
    )
    ");

    header("Location: student.php?id=".$student_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Profile</title>

<link rel="stylesheet" href="css/profile.css">

</head>

<body>

<div class="container">

<div class="profile-card">

<div class="profile-header">

<img src="uploads/<?php echo $student['profile_photo']; ?>">

<h2>

<?php echo $student['full_name']; ?>

</h2>

<p>

<?php echo $student['department']; ?>

</p>

</div>

<div class="profile-body">

<div class="info">

<label>Email</label>

<p>

<?php echo $student['email']; ?>

</p>

</div>

<div class="info">

<label>Semester</label>

<p>

<?php echo $student['semester']; ?>

</p>

</div>

<div class="info">

<label>Bio</label>

<p>

<?php
echo $student['bio'] ? $student['bio'] : "Not Updated";
?>

</p>

</div>

<div class="info">

<label>Skills</label>

<p>

<?php
echo $student['skills'] ? $student['skills'] : "Not Updated";
?>

</p>

</div>

<div class="info">

<label>Interests</label>

<p>

<?php
echo $student['interests'] ? $student['interests'] : "Not Updated";
?>

</p>

</div>

<div class="info">

<label>GitHub</label>

<p>

<?php
echo $student['github'] ? $student['github'] : "Not Updated";
?>

</p>

</div>

<div class="info">

<label>LinkedIn</label>

<p>

<?php
echo $student['linkedin'] ? $student['linkedin'] : "Not Updated";
?>

</p>

</div>

<div class="buttons">

<?php if(!$alreadySent){ ?>

<form method="POST" style="width:100%;">

<button
type="submit"
name="connect"
style="width:100%;">

Send Connection Request

</button>

</form>

<?php } else { ?>

<button
disabled
style="width:100%;background:gray;cursor:not-allowed;">

Request Sent

</button>

<?php } ?>

</div>

<br>

<div class="buttons">

<a href="search.php">

Back to Search

</a>

</div>

</div>

</div>

</div>

</body>

</html>