<?php
// Database connection parameters
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$database = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Perform SQL query to fetch user record
  $sql = "SELECT * FROM users WHERE username = '$username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // User found, verify password
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      // Password is correct, redirect to dashboard or other page
      session_start();
      $_SESSION['username'] = $username;
      header("Location: dashboard.php");
      exit();
    } else {
      // Password is incorrect
      echo "Invalid password";
    }
  } else {
    // User not found
    echo "User not found";
  }
}

// Close database connection
$conn->close();
?>