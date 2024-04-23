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

// function for generating data
function addData() {
    var startDate = prompt("Enter start date (YYYY-MM-DD):");
    var endDate = prompt("Enter end date (YYYY-MM-DD):");

    // checks for valid data entry
    if (startDate && endDate) {
        // redirects to PHP script to generate and insert synthetic data
        window.location.href = "generate_data.php?start_date=" + startDate + "&end_date=" + endDate;
    } else {
        // displays notification about invalid date entry
        alert("Data not added. Start/End date not entered.");
        // refreshes login page after date is not added correctly
        window.location.href = "login_design.php";
    }
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
                header("Location: head_office.php?storeID=$storeID");
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
