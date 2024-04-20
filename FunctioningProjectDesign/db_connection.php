<?php

// Start session
session_start();

// Database configuration
$servername = "mydb.ics.purdue.edu"; // Change this to your server name
$usernameDB = "g1130865"; // Change this to your database username
$passwordDB = "GroupNine"; // Change this to your database password
$dbname = "g1130865"; // Change this to your database name

// Create database connection
$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully"; // Optional feedback for successful connection
}

// Close the connection (REMEMBER TO DO THIS!)
$conn->close();
?>