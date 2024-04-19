<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .banner {
            background-color: #333;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .banner h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        .login-form {
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 92%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .input-group button {
            padding: 10px 20px;
            background-color: #555;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .input-group button:hover {
            background-color: #444;
        }
        /* Additional style for the "Add Data" button */
        .add-data-button {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="banner">
        <h1>Login</h1>
        <div id="datetime"></div>
    </div>
    <div class="login-form">
        <form id="loginForm" method="post">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <button type="submit">Login</button>
                <button type="button" class="add-data-button">Add Data</button>
            </div>
        </form>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const datetimeElement = document.getElementById('datetime');
            datetimeElement.innerText = now.toLocaleString();
        }

        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>
</html>

<?php
session_start();
// Database connection
$servername = "mydb.ics.purdue.edu"; // Change this to your server name
$usernameDB = "g1130865"; // Change this to your database username
$passwordDB = "GroupNine"; // Change this to your database password
$dbname = "g1130865"; // Change this to your database name
$tableName = "users"; // CDatahange this to your table name

// Create connection
$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameInput = $_POST['username'];
    $passwordInput = $_POST['password'];

    // Query to check if username and password exist in the database
    $sql = "SELECT * FROM $tableName WHERE Username = '$usernameInput' AND Userpass = '$passwordInput'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Redirect to the next page if user is authenticated
        header("Location: webpage_design.php");
        exit();
    } else {
        // Show error message or handle invalid login
        echo '<script>alert("Invalid username or password");</script>';
    }
}

// Close connection
$conn->close();
?>
