<?php

session_start();
include("includes/config.php");

if(!isset($_SESSION["user_id"]))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$query = mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'");

$user = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Profile | Academic Peer Connector</title>

<link rel="stylesheet" href="css/profile.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<div class="profile-card">

<div class="profile-header">

<img src="uploads/<?php echo $user['profile_photo']; ?>" alt="Profile">

<h2>

<?php echo $user['full_name']; ?>

</h2>

<p>

Student Member

</p>

</div>

<div class="profile-body">

<div class="info">

<label>Email</label>

<p>

<?php echo $user['email']; ?>

</p>

</div>

<div class="info">

<label>Department</label>

<p>

<?php echo $user['department']; ?>

</p>

</div>

<div class="info">

<label>Semester</label>

<p>

<?php echo $user['semester']; ?>

</p>

</div>

<div class="info">

<label>Bio</label>

<p>

<?php echo !empty($user['bio']) ? $user['bio'] : "Not Updated"; ?>

</p>

</div>

<div class="info">

<label>Skills</label>

<p>

<?php echo !empty($user['skills']) ? $user['skills'] : "Not Updated"; ?>

</p>

</div>

<div class="info">

<label>Interests</label>

<p>

<?php echo !empty($user['interests']) ? $user['interests'] : "Not Updated"; ?>

</p>

</div>

<div class="info">

<label>Phone</label>

<p>

<?php echo !empty($user['phone']) ? $user['phone'] : "Not Updated"; ?>

</p>

</div>

<div class="info">

<label>GitHub</label>

<p>

<?php echo !empty($user['github']) ? $user['github'] : "Not Updated"; ?>

</p>

</div>

<div class="info">

<label>LinkedIn</label>

<p>

<?php echo !empty($user['linkedin']) ? $user['linkedin'] : "Not Updated"; ?>

</p>

</div>

<div class="buttons">

<a href="edit_profile.php">

Edit Profile

</a>

<a href="dashboard.php">

Dashboard

</a>

</div>

</div>

</div>

</div>

</body>

</html>