<?php
session_start();
include("includes/config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

/* USER INFO */
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($user_query);

/* TOTAL STUDENTS */
$total_students_q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$total_students = mysqli_fetch_assoc($total_students_q)['total'];

/* PENDING REQUESTS */
$pending_q = mysqli_query($conn, "
    SELECT COUNT(*) AS total FROM connections 
    WHERE receiver_id='$user_id' AND status='Pending'
");
$pending_requests = mysqli_fetch_assoc($pending_q)['total'];

/* ACCEPTED CONNECTIONS */
$connections_q = mysqli_query($conn, "
    SELECT COUNT(*) AS total FROM connections 
    WHERE (sender_id='$user_id' OR receiver_id='$user_id') 
    AND status='Accepted'
");
$connections = mysqli_fetch_assoc($connections_q)['total'];

/* UNREAD NOTIFICATIONS */
$notif_q = mysqli_query($conn, "
    SELECT COUNT(*) AS total FROM notifications 
    WHERE user_id='$user_id' AND status='Unread'
");
$unread = mysqli_fetch_assoc($notif_q)['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>

<link rel="stylesheet" href="css/dashboard.css">
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h2>🎓 Academic Peer Connector</h2>
    <div class="user">
        Welcome, <b><?php echo $user['full_name']; ?></b>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- DASHBOARD -->
<div class="container">

    <h1>Welcome Back, <?php echo $user['full_name']; ?> 👋</h1>

    <!-- STATS -->
    <div class="stats">

        <div class="card blue">
            <h3><?php echo $total_students; ?></h3>
            <p>👥 Total Students</p>
        </div>

        <div class="card orange">
            <h3><?php echo $pending_requests; ?></h3>
            <p>📨 Pending Requests</p>
        </div>

        <div class="card green">
            <h3><?php echo $connections; ?></h3>
            <p>🤝 Connections</p>
        </div>

        <div class="card red">
            <h3><?php echo $unread; ?></h3>
            <p>🔔 Notifications</p>
        </div>

    </div>

    <!-- QUICK ACTIONS -->
    <h2>Quick Actions</h2>

    <div class="actions">

        <a href="profile.php">👤 Profile</a>
        <a href="search.php">🔍 Find Students</a>
        <a href="requests.php">👥 Requests</a>
        <a href="notifications.php">🔔 Notifications</a>

    </div>

    <!-- ACTIVITY -->
    <div class="activity">

        <h2>Recent Activity</h2>

        <ul>
            <li>✅ Login Successful</li>
            <li>👤 Profile Updated</li>
            <li>🔍 Used Search Feature</li>
            <li>🤝 Connection System Active</li>
        </ul>

    </div>

</div>

</body>
</html>