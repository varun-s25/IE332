<?php

// Include your database connection file
include 'db_connection.php';

// Check if the start and end dates are present in the URL parameters
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate synthetic data for Products table
    $productsData = generateProductData();
    
    // Insert data into the Products table
    insertDataIntoTable($conn, "Products", $productsData);

    // Redirect to the login screen
    header("Location: login_design.php");
    exit();
}

// Function to generate synthetic data for Products table
function generateProductData() {
    $data = array();
    $rowCount = rand(7, 15); // Generate a random number of rows between 7 and 15

    for ($i = 0; $i < $rowCount; $i++) {
        // Generate random values for each column
        $productID = rand(1000000, 9999999);
        $unitPrice = number_format(rand(100, 10000) / 100, 2);
        $unitsInStock = rand(1, 1000);
        $unitsOnOrder = rand(0, 100);
        $discontinued = rand(0, 1) == 1 ? 'Y' : 'N'; // Randomly choose 'Y' or 'N'

        // Add generated data to the array
        $data[] = array(
            'ProductID' => $productID,
            'UnitPrice' => $unitPrice,
            'UnitsInStock' => $unitsInStock,
            'UnitsOnOrder' => $unitsOnOrder,
            'Discontinued' => $discontinued
        );
    }
    return $data;
}
$table = "Products";
// Function to insert data into a table
function insertDataIntoTable($conn, $table, $data) {
    // Check if data is not empty and the connection is valid
    if (!empty($data) && $conn) {
        // Construct and execute SQL INSERT query
        foreach ($data as $row) {
            $sql = "INSERT INTO $table (ProductID, UnitPrice, UnitsInStock, UnitsOnOrder, Discontinued) 
                    VALUES ('{$row['ProductID']}', '{$row['UnitPrice']}', '{$row['UnitsInStock']}', '{$row['UnitsOnOrder']}', '{$row['Discontinued']}')";

            if ($conn->query($sql) !== TRUE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error: Data array is empty or connection is invalid.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Data</title>
</head>
<body>
    <h2>Generate Synthetic Data</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="submit" name="submit" value="Generate Data">
    </form>
</body>
</html>