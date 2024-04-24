<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$server = 'mydb.ics.purdue.edu';
$dbname = 'g1130865';
$username = 'g1130865';
$password = 'GroupNine';
$tableData = "";

$storeID = isset($_GET['storeID']) ? $_GET['storeID'] : null;

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Placement_Date, Arrival_Date, Product_ID, Product_Order_Price, Order_ID FROM order_management WHERE Store_ID = ?";
$query = $conn->prepare($sql);
if ($query) {
    $query->bind_param("i", $storeID);
    $query->execute();

    // Bind the result variables
    $query->bind_result($placementDate, $arrivalDate, $productID, $productOrderPrice, $orderID);

    // Start the table
    $tableData = "<table border='1'><tr><th>Placement Date</th><th>Arrival Date</th><th>Product ID</th><th>Product Order Price</th><th>Order ID</th></tr>";
    $hasResults = false;

    // Fetch values
    while ($query->fetch()) {
        $hasResults = true;
        $tableData .= "<tr><td>" . htmlspecialchars($placementDate) . "</td><td>" . htmlspecialchars($arrivalDate) . "</td><td>" . htmlspecialchars($productID) . "</td><td>" . htmlspecialchars($productOrderPrice) . "</td><td>" . htmlspecialchars($orderID) . "</td></tr>";
    }
    if (!$hasResults) {
        $tableData .= "<tr><td colspan='5'>0 results</td></tr>";
    }
    $tableData .= "</table>";
    $query->close();
} else {
    $tableData = "Error preparing statement: " . htmlspecialchars($conn->error);
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Details by Store</title>
</head>

<body>
    <h1>Lookup Order Details by Store ID</h1>

    <!-- Display the table with results if any -->
    <?php echo $tableData; ?>
</body>

</html>