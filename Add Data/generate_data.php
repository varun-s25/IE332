<?php
// Database connection parameters
$servername = "mydb.ics.purdue.edu"; // Change this to your server name
$username = "g1130865"; // Change this to your database username
$password = "GroupNine"; // Change this to your database password
$database = "g1130865"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select database
$conn->select_db($database);

// Generate synthetic data for Products table
$productsData = generateProductData();

// Insert data into the Products table
insertDataIntoTable($conn, "Products", $productsData);

// Close connection
$conn->close();

// JavaScript code for the pop-up message and redirection
echo "<script>alert('Data successfully added to database');</script>";
echo "<script>setTimeout(function(){ window.location.href = 'login_design.php'; }, 2000);</script>"; // Redirect after 2 seconds

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
