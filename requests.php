<?php
session_start();
include("includes/config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

/* ======================
   ACCEPT REQUEST
====================== */

if(isset($_GET['accept']))
{
    $id = (int)$_GET['accept'];

    mysqli_query($conn,"
        UPDATE connections
        SET status='Accepted'
        WHERE id='$id'
    ");

    header("Location: requests.php");
    exit();
}

/* ======================
   REJECT REQUEST
====================== */

if(isset($_GET['reject']))
{
    $id = (int)$_GET['reject'];

    mysqli_query($conn,"
        UPDATE connections
        SET status='Rejected'
        WHERE id='$id'
    ");

    header("Location: requests.php");
    exit();
}

/* ======================
   FETCH REQUESTS
====================== */

$query = mysqli_query($conn,"
SELECT
connections.*,
users.full_name,
users.department,
users.semester,
users.profile_photo

FROM connections

INNER JOIN users
ON users.id = connections.sender_id

WHERE receiver_id='$user_id'

ORDER BY created_at DESC
");

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Connection Requests</title>

<link rel="stylesheet" href="css/requests.css">

</head>

<body>

<div class="container">

<h1>

Connection Requests

</h1>

<?php

if(mysqli_num_rows($query)==0)
{

echo "<h3>No Requests Found.</h3>";

}

while($row=mysqli_fetch_assoc($query))
{

?>

<div class="request-card">

<img src="uploads/<?php echo $row['profile_photo']; ?>">

<div class="details">

<h2>

<?php echo $row['full_name']; ?>

</h2>

<p>

Department :
<?php echo $row['department']; ?>

</p>

<p>

Semester :
<?php echo $row['semester']; ?>

</p>

<p>

Status :

<strong>

<?php echo $row['status']; ?>

</strong>

</p>

</div>

<div class="buttons">

<?php

if($row['status']=="Pending")
{

?>

<a class="accept"
href="?accept=<?php echo $row['id']; ?>">

Accept

</a>

<a class="reject"
href="?reject=<?php echo $row['id']; ?>">

Reject

</a>

<?php

}

else
{

echo "<span>".$row['status']."</span>";

}

?>

</div>

</div>

<?php

}

?>

<br>

<a class="back"

href="dashboard.php">

← Back to Dashboard

</a>

</div>

</body>

</html>