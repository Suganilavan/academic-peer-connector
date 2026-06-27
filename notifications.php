<?php
session_start();
include("includes/config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

/* Mark all notifications as read */
if (isset($_GET["read"])) {
    mysqli_query($conn, "
        UPDATE notifications
        SET status='Read'
        WHERE user_id='$user_id'
    ");

    header("Location: notifications.php");
    exit();
}

/* Fetch notifications */
$result = mysqli_query($conn, "
    SELECT *
    FROM notifications
    WHERE user_id='$user_id'
    ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Notifications</title>

<link rel="stylesheet" href="css/notifications.css">

</head>

<body>

<div class="container">

<h1>🔔 Notifications</h1>

<?php

if(mysqli_num_rows($result)==0)
{
    echo "<p class='empty'>No Notifications Found.</p>";
}

while($row=mysqli_fetch_assoc($result))
{
?>

<div class="notification <?php echo strtolower($row['status']); ?>">

<div>

<h3>

<?php echo $row['message']; ?>

</h3>

<p>

<?php echo $row['created_at']; ?>

</p>

</div>

<span>

<?php echo $row['status']; ?>

</span>

</div>

<?php
}
?>

<div class="buttons">

<a href="?read=1">

Mark All Read

</a>

<a href="dashboard.php">

Back Dashboard

</a>

</div>

</div>

</body>

</html>