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

    function addData() {
        var startDate = prompt("Enter start date (YYYY-MM-DD):");
        var endDate = prompt("Enter end date (YYYY-MM-DD):");

        // Redirect to PHP script to generate and insert synthetic data
        window.location.href = "generate_data.php?start_date=" + startDate + "&end_date=" + endDate;
    }

    updateTime();
    setInterval(updateTime, 1000);

    // Add event listener to the "Add Data" button
    document.querySelector('.add-data-button').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default form submission
        addData(); // Call addData function to prompt for dates
    });
</script>


    <!-- PHP code for handling login -->
    <?php
    session_start();
    // Database connection
    $servername = "mydb.ics.purdue.edu"; // Change this to your server name
    $usernameDB = "g1130865"; // Change this to your database username
    $passwordDB = "GroupNine"; // Change this to your database password
    $dbname = "g1130865"; // Change this to your database name
    $tableName = "users"; // Change this to your table name

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
        $sql = "SELECT * FROM $tableName WHERE UserName = '$usernameInput' AND UserPass = '$passwordInput'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Fetch store ID associated with the logged-in user
            $row = $result->fetch_assoc();
            $storeID = $row['Store_ID'];

            if ($storeID == 0) {
                header("Location: head_office.php?storeID=$storeID");
                exit();
            } else {
                // Redirect to the individual store page with the store ID as a parameter
                header("Location: individual_store.php?storeID=$storeID");
                exit();
            }
            
        } else {
            // Show error message or handle invalid login
            echo '<script>alert("Invalid username or password");</script>';
        }
    }

    // Close connection
    $conn->close();
    ?>
</body>
</html>


