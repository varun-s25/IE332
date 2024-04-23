<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$server = 'mydb.ics.purdue.edu';  // Your database host
$dbname = 'g1130865';  // Your database name
$username = 'g1130865';  // Your database username
$password = 'GroupNine';  // Your database password

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$inventory = [];

// Prepare and execute the SQL query for inventory
$query = $conn->prepare("SELECT Product_ID, Quantity, Store_ID FROM inventory_management");
if ($query) {
    $query->execute();

    // Bind variables to the prepared statement as result variables
    $query->bind_result($productID, $quantity, $storeID);

    // Fetch values one by one
    while ($query->fetch()) {
        $inventory[] = [
            'Product_ID' => $productID,
            'Quantity' => $quantity,
            'Store_ID' => $storeID
        ];
    }
    $query->close();
} else {
    echo "Failed to prepare the query: " . htmlspecialchars($conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Details</title>
</head>
<body>
    <h1>Inventory Viewer</h1>

    <?php if (!empty($inventory)): ?>
    <table border="1">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Store ID</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventory as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['Product_ID']); ?></td>
                <td><?php echo htmlspecialchars($item['Quantity']); ?></td>
                <td><?php echo htmlspecialchars($item['Store_ID']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</body>
</html>
