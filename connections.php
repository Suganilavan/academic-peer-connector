<?php
session_start();
include("includes/config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

/* FETCH ACCEPTED CONNECTIONS (both sides) */
$query = mysqli_query($conn, "
SELECT u.*
FROM connections c
JOIN users u 
ON (
    (c.sender_id = u.id AND c.receiver_id = '$user_id')
    OR
    (c.receiver_id = u.id AND c.sender_id = '$user_id')
)
WHERE c.status = 'Accepted'
");

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Connections</title>

<link rel="stylesheet" href="css/connections.css">
</head>

<body>

<div class="container">

    <h1>🤝 My Connections</h1>

    <?php if(mysqli_num_rows($query) == 0) { ?>

        <p class="empty">No connections yet. Start connecting with students!</p>

    <?php } ?>

    <div class="grid">

    <?php while($row = mysqli_fetch_assoc($query)) { ?>

        <div class="card">

            <img src="uploads/<?php echo $row['profile_photo']; ?>">

            <h2><?php echo $row['full_name']; ?></h2>

            <p><?php echo $row['department']; ?></p>

            <p>Semester <?php echo $row['semester']; ?></p>

            <a href="student.php?id=<?php echo $row['id']; ?>">
                View Profile
            </a>

        </div>

    <?php } ?>

    </div>

    <a class="back" href="dashboard.php">⬅ Back to Dashboard</a>

</div>

</body>
</html>