<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$server = 'mydb.ics.purdue.edu';
$dbname = 'g1130865';
$username = 'g1130865';
$password = 'GroupNine';
$storeID = isset($_GET['storeID']) ? $_GET['storeID'] : null;

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $conn->prepare("SELECT User_ID, First_Name, Last_Name FROM users WHERE Store_ID = ?");
$query->bind_param("i", $storeID);
$query->execute();

// Bind the result variables
$userID = $firstName = $lastName = null;
$query->bind_result($userID, $firstName, $lastName);

// Start the table
$tableData = "<table border='1'><tr><th>User ID</th><th>First Name</th><th>Last Name</th></tr>";
$resultFound = false;

// Fetch values
while ($query->fetch()) {
    $resultFound = true;
    $tableData .= "<tr><td>" . htmlspecialchars($userID) . "</td><td>" . htmlspecialchars($firstName) . "</td><td>" . htmlspecialchars($lastName) . "</td></tr>";
}

if (!$resultFound) {
    $tableData .= "<tr><td colspan='3'>0 results</td></tr>";
}

$tableData .= "</table>";

$query->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List for Store 0</title>
</head>
<body>
    <h1>User List for Store ID 0</h1>
    <!-- Display the table with results -->
    <?php echo $tableData; ?>
</body>
</html>
