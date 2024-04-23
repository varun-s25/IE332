<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login_design_styles.css">
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
// time update function
function updateTime() {
    const now = new Date(); // gets the current date and time
    const datetimeElement = document.getElementById('datetime'); // gets the element with the ID "datetime"
    datetimeElement.innerText = now.toLocaleString(); // sets the text content of the element to the current date and time
}

// function to validate date format
function isValidDate(dateString) {
    const dateRegex = /^\d{4}-(0[1-9]|1[0-2])-([0-2]\d|3[01])$/; // Updated regex to check month and day range
    if (!dateRegex.test(dateString)) {
        alert("Data not added. Invalid date.");
        return false;
    }
    const [year, month, day] = dateString.split('-').map(Number);
    if (month > 12) {
        alert("Data not added. Invalid date. Month should be between 01 and 12.");
        return false;
    }
    if (day > 31) {
        alert("Data not added. Invalid date. Day should be between 01 and 31.");
        return false;
    }
    return true;
}


// function to check if the given date is valid and not in the future
function isPastDate(dateString) {
    const inputDate = new Date(dateString);
    const currentDate = new Date();
    return inputDate <= currentDate;
}

// function to check if the given date is valid and not too far in the future
function isFutureDate(dateString) {
    const inputDate = new Date(dateString);
    const currentDate = new Date();
    return inputDate > currentDate; // Change the condition to check if the input date is after the current date
}

// function for generating data
function addData() {
    var startDate = prompt("Enter start date (YYYY-MM-DD):");
    var endDate = prompt("Enter end date (YYYY-MM-DD):");

    if (!isValidDate(startDate) || !isValidDate(endDate)) {
        return;
    }

    if (!isPastDate(startDate) || isFutureDate(endDate)) {
        alert("Start date should be in the past and end date should not be in the future.");
        return;
    }

    if (new Date(startDate) >= new Date(endDate)) {
        alert("Start date should be before end date.");
        return;
    }

    // redirects to PHP script to generate and insert synthetic data
    window.location.href = "generate_data.php?start_date=" + startDate + "&end_date=" + endDate;
}

updateTime();
setInterval(updateTime, 1000);

// event listener for "Add Data" button
document.querySelector('.add-data-button').addEventListener('click', function(event) {
    event.preventDefault(); // prevents default form submission
    addData(); // calls the addData function to prompt for dates
});
</script>

    <?php
    session_start();
    // connecting to mysql database
    $servername = "mydb.ics.purdue.edu";
    $usernameDB = "g1130865"; 
    $passwordDB = "GroupNine";
    $dbname = "g1130865"; 
    $tableName = "users"; 

    $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

    // checks connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // checks form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usernameInput = $_POST['username'];
        $passwordInput = $_POST['password'];

        // checks for username and password in database
        $sql = "SELECT * FROM $tableName WHERE User_Name = '$usernameInput' AND User_Pass = '$passwordInput'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // checks which store the user is associated with
            $row = $result->fetch_assoc();
            $storeID = $row['Store_ID'];

            if ($storeID == 0) {
                // if user is a head office member, redirects to head office page with all stores listed
                header("Location: head_office_g.php?storeID=$storeID");
                exit();
            } else {
                // if user is a member of a store, redirects to individual store page
                header("Location: individual_store.php?storeID=$storeID");
                exit();
            }
            
        } else {
            // error message for invalid username or password
            echo '<script>alert("Invalid username or password");</script>';
        }
    }

    // closes connection
    $conn->close();
    ?>
</body>
</html>
