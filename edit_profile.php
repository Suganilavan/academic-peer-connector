<?php
session_start();
include("includes/config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

/* ===========================
   UPDATE PROFILE
=========================== */

if (isset($_POST["update"])) {

    $full_name = mysqli_real_escape_string($conn, $_POST["full_name"]);
    $department = mysqli_real_escape_string($conn, $_POST["department"]);
    $semester = mysqli_real_escape_string($conn, $_POST["semester"]);
    $bio = mysqli_real_escape_string($conn, $_POST["bio"]);
    $skills = mysqli_real_escape_string($conn, $_POST["skills"]);
    $interests = mysqli_real_escape_string($conn, $_POST["interests"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
    $github = mysqli_real_escape_string($conn, $_POST["github"]);
    $linkedin = mysqli_real_escape_string($conn, $_POST["linkedin"]);

    mysqli_query($conn, "
        UPDATE users SET
        full_name='$full_name',
        department='$department',
        semester='$semester',
        bio='$bio',
        skills='$skills',
        interests='$interests',
        phone='$phone',
        github='$github',
        linkedin='$linkedin'
        WHERE id='$user_id'
    ");

    $_SESSION["full_name"] = $full_name;

    header("Location: profile.php");
    exit();
}

/* ===========================
   FETCH USER
=========================== */

$result = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Profile</title>

<link rel="stylesheet" href="css/profile.css">

</head>

<body>

<div class="container">

<div class="profile-card">

<div class="profile-header">

<h2>Edit Profile</h2>

<p>Update your academic information</p>

</div>

<div class="profile-body">

<form method="POST">

<div class="info">

<label>Full Name</label>

<input
type="text"
name="full_name"
value="<?php echo $user['full_name']; ?>"
required>

</div>

<div class="info">

<label>Department</label>

<input
type="text"
name="department"
value="<?php echo $user['department']; ?>"
required>

</div>

<div class="info">

<label>Semester</label>

<input
type="text"
name="semester"
value="<?php echo $user['semester']; ?>"
required>

</div>

<div class="info">

<label>Bio</label>

<textarea
name="bio"
rows="4"><?php echo $user['bio']; ?></textarea>

</div>

<div class="info">

<label>Skills</label>

<input
type="text"
name="skills"
value="<?php echo $user['skills']; ?>">

</div>

<div class="info">

<label>Interests</label>

<input
type="text"
name="interests"
value="<?php echo $user['interests']; ?>">

</div>

<div class="info">

<label>Phone</label>

<input
type="text"
name="phone"
value="<?php echo $user['phone']; ?>">

</div>

<div class="info">

<label>GitHub</label>

<input
type="text"
name="github"
value="<?php echo $user['github']; ?>">

</div>

<div class="info">

<label>LinkedIn</label>

<input
type="text"
name="linkedin"
value="<?php echo $user['linkedin']; ?>">

</div>

<div class="buttons">

<button type="submit" name="update">

Save Changes

</button>

<a href="profile.php">

Cancel

</a>

</div>

</form>

</div>

</div>

</div>

</body>

</html>