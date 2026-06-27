<?php

// ==========================================
// Database Configuration
// Academic Peer Connector
// ==========================================

$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "academic_peer_connector";

// Create Connection

$conn = mysqli_connect($servername, $username, $password, $database);

// Check Connection

if (!$conn) {

    die("Database Connection Failed : " . mysqli_connect_error());

}

?>