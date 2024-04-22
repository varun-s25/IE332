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

// Try to execute query and handle errors
$query = "SELECT COUNT(*) FROM inventory_management";  // No change needed here as it already targets the correct table
$result = $conn->query($query);

if (!$result) {
    die("Error occurred: " . $conn->error);
} else {
    $maxEntries = $result->fetch_row()[0];  // Corrected variable name for consistency
}
// Generate synthetic data for the returns table

// Generate synthetic data for membership_management table
$membershipData = generateMembershipData();

// Insert data into the membership_management table
insertDataIntoTable($conn, "membership_management", $membershipData);

// Generate synthetic data for marketing_communication_channels table
$marketingData = generateMarketingData();

// Insert data into the marketing_communication_channels table
insertDataIntoTable($conn, "marketing_communication_channels", $marketingData);

// Generate synthetic data for customer_service table
$serviceData = generateServiceData();

// Insert data into the customer_service table
insertDataIntoTable($conn, "customer_service", $serviceData);

// Generate synthetic data for order_management table
$orderData = generateOrderData($maxEntries);

// Insert data into the order_management table
insertDataIntoTable($conn, "order_management", $orderData);

// Generate synthetic data for transportation_management table
$transportationData = generateTransportationData();

// Insert data into the transportation_management table
insertDataIntoTable($conn, "transportation_management", $transportationData);

// Generate synthetic data for human_resources table
$hrData = generateHRData();

// Insert data into the human_resources table
insertDataIntoTable($conn, "human_resources", $hrData);

// Generate synthetic data for the exchanges table
$exchangeData = generateExchangeData();

// Insert data into the exchanges table
insertDataIntoTable($conn, "exchanges", $exchangeData);

// Generate synthetic data for the returns table
$returnData = generateReturnData();

// Insert data into the returns table
insertDataIntoTable($conn, "returns", $returnData);


$inventoryData = generateInventoryData();

// Insert data into the returns table
insertDataIntoTable($conn, "inventory_management", $inventoryData);

$salesData = generateSalesData();

// Insert data into the returns table
insertDataIntoTable($conn, "sales", $salesData);





// Close connection
$conn->close();

// JavaScript code for the pop-up message and redirection
echo "<script>alert('Data successfully added to database');</script>";
echo "<script>setTimeout(function(){ window.location.href = 'login_design.php'; }, 1000);</script>"; // Redirect after 2 seconds



function generateInventoryData() {
    global $maxEntries;
    $data = array();
    $rowCount = rand(7, 15); // Generate a random number of rows between 7 and 15

    $productTypes = array("Fresh Produce", "Packaged Foods", "Frozen Foods", "Bakery Items", "Meat And Seafood", "Dairy And Eggs", "Beverages", "Health And Beauty", 
    "Clothing And Footwear", "Electronics", "Home Appliances", "Furniture", "Sports And Fitness Equipment", "Automotive Supplies", "Office Supplies");

    for ($i = 0; $i < $rowCount; $i++) {
        // Generate random values for each column
        $productID = $maxEntries;
        $productType = $productTypes[array_rand($productTypes)]; // Randomly select
        $quantity = rand(1, 99999); // Generate random quantity
        $storeID = rand(1, 25); // Generate random store ID from 1 to 25

        // Add generated data to the array
        $data[] = array(
            'Product_ID' => $productID,
            'Product_Type' => $productType,
            'Quantity' => $quantity,
            'Store_ID' => $storeID
        );

        $maxEntries++;
    }

    return $data;
}

// Function to generate synthetic data for membership_management table
function generateMembershipData() {
    $data = array();
    $rowCount = rand(7, 15); // Generate a random number of rows between 7 and 15

    // List of Tier statuses
    $tierStatuses = array("Platinum", "Gold", "Silver", "Bronze");

    for ($i = 0; $i < $rowCount; $i++) {
        // Generate random values for each column
        $memberID = rand(1000000, 9999999);
        $firstName = generateRandomString(10); // Generate random first name
        $lastName = generateRandomString(10); // Generate random last name
        $email = $firstName . "." . $lastName . "@example.com"; // Generate email based on first and last name
        $phone = rand(1000000000, 9999999999); // Generate random phone number
        $tier = $tierStatuses[array_rand($tierStatuses)]; // Randomly select

        // Add generated data to the array
        $data[] = array(
            'Member_ID' => $memberID,
            'Member_First_Name' => $firstName,
            'Member_Last_Name' => $lastName,
            'Member_Email' => $email,
            'Member_Phone' => $phone,
            'Member_Tier' => $tier
        );
    }
    return $data;
}

// Function to generate synthetic data for marketing_communication_channels table
function generateMarketingData() {
    $data = array();
    $rowCount = rand(7, 15); // Generate a random number of rows between 7 and 15

    // List of platforms
    $platforms = array("Social Media", "Cable", "Email", "Billboard", "Publication");

    for ($i = 0; $i < $rowCount; $i++) {
        // Generate random values for each column
        $marketingID = rand(1000000, 9999999);
        $platformType = $platforms[array_rand($platforms)]; // Randomly select a platform from the list
        $marketingTime = rand(1, 999); // Generate random marketing time
        $engagementRating = rand(1, 99); // Generate random engagement rating
        $marketingPrice = rand(100, 99999) / 100; // Generate random marketing price (convert to decimal)
        $storeID = rand(1, 25); // Generate random store ID from 1 to 25

        // Add generated data to the array
        $data[] = array(
            'Marketing_ID' => $marketingID,
            'Platform_Type' => $platformType,
            'Marketing_Time' => $marketingTime,
            'Engagement_Rating' => $engagementRating,
            'Marketing_Price' => $marketingPrice,
            'Store_ID' => $storeID
        );
    }
    return $data;
}

// Function to generate synthetic data for customer_service table
function generateServiceData() {
    $data = array();
    $rowCount = rand(7, 15); // Generate a random number of rows between 7 and 15

    // List of service types
    $serviceTypes = array("Technical Support", "Billing Inquiry", "Product Assistance", "Complaint Resolution");

    for ($i = 0; $i < $rowCount; $i++) {
        // Generate random values for each column
        $serviceID = rand(1000000, 9999999);
        $serviceType = $serviceTypes[array_rand($serviceTypes)]; // Randomly select a service type from the list
        $serviceRating = rand(1, 10); // Generate random service rating (1 to 10)
        $storeID = rand(1, 25); // Generate random store ID from 1 to 25

        // Add generated data to the array
        $data[] = array(
            'Service_ID' => $serviceID,
            'Service_Type' => $serviceType,
            'Service_Rating' => $serviceRating,
            'Store_ID' => $storeID
        );
    }
    return $data;
}

// Function to generate synthetic data for order_management table
function generateOrderData() {
    global $maxEntries;
    $data = array();
    $rowCount = rand(7, 15); // Generate a random number of rows between 7 and 15

    $productTypes = array("Fresh Produce", "Packaged Foods", "Frozen Foods", "Bakery Items", "Meat And Seafood", "Dairy And Eggs", "Beverages", "Health And Beauty", 
    "Clothing And Footwear", "Electronics", "Home Appliances", "Furniture", "Sports And Fitness Equipment", "Automotive Supplies", "Office Supplies");

    for ($i = 0; $i < $rowCount; $i++) {
        // Generate random values for each column
        $orderID = rand(1000000, 9999999);
        $quantity = rand(1, 100); // Generate random quantity
        $placementDate = date('Y-m-d', strtotime('-' . rand(1, 30) . ' days')); // Generate random placement date within last 30 days
        $arrivalDate = date('Y-m-d', strtotime('+' . rand(1, 30) . ' days')); // Generate random arrival date within next 30 days
        $storeID = rand(1, 25); // Generate random store ID from 1 to 25
        $productID = rand(1,$maxEntries);
        $productPrice = number_format(rand(100, 10000) / 100, 2);
        $productType = $productTypes[array_rand($productTypes)]; // Randomly select


        // Add generated data to the array
        $data[] = array(
            'Order_ID' => $orderID,
            'Quantity' => $quantity,
            'Placement_Date' => $placementDate,
            'Arrival_Date' => $arrivalDate,
            'Store_ID' => $storeID,
            'Product_ID' => $productID,
            'Product_Order_Price' => $productPrice,
            'Product_Type' => $productType

        );
    }
    return $data;
}

// Function to generate synthetic data for transportation_management table
function generateTransportationData() {
    $data = array();
    $rowCount = rand(7, 15); // Generate a random number of rows between 7 and 15
    
    // List of shipment methods
    $shipmentMethods = array("Air", "Land", "Sea");

    for ($i = 0; $i < $rowCount; $i++) {
        // Generate random values for each column
        $shipmentID = rand(1000000, 9999999);
        $shipmentMethod = $shipmentMethods[array_rand($shipmentMethods)]; // Randomly select a shipment method from the list
        $transportationPrice = number_format((float)rand(100, 99999), 2, '.', ''); // Generate random transportation price with 2 decimal places
        $storeID = rand(1, 25); // Generate random store ID from 1 to 25

        // Add generated data to the array
        $data[] = array(
            'Shipment_ID' => $shipmentID,
            'Shipment_Method' => $shipmentMethod,
            'Product_Transportation_Price' => $transportationPrice,
            'Store_ID' => $storeID
        );
    }
    return $data;
}

// Function to generate synthetic data for human_resources table
function generateHRData() {
    $data = array();
    $rowCount = rand(7, 15); // Generate a random number of rows between 7 and 15
    $usedPhones = []; // This array will track the phone numbers that have been used

    // List of application statuses
    $applicationStatuses = array("Received", "In Progress", "Accepted", "Rejected");

    for ($i = 0; $i < $rowCount; $i++) {
        // Generate random values for each column
        $positionID = rand(1000000, 9999999);
        $firstName = generateRandomString(15); // Generate random first name
        $lastName = generateRandomString(15); // Generate random last name
        $email = generateRandomString(10) . "@example.com"; // Generate random email
        
        // Ensure unique phone number
        do {
            $phone = sprintf('%010d', rand(1000000000, 2147483646)); // Ensures the phone number has 10 digits
        } while (array_key_exists($phone, $usedPhones)); // Check if the phone number is already used
        $usedPhones[$phone] = true; // Mark this phone number as used

        $applicationStatus = $applicationStatuses[array_rand($applicationStatuses)]; // Randomly select an application status from the list
        $storeID = rand(0, 25); // Generate random store ID from 0 to 25

        // Add generated data to the array
        $data[] = array(
            'Position_ID' => $positionID,
            'Applicant_First_Name' => $firstName,
            'Applicant_Last_Name' => $lastName,
            'Applicant_Email' => $email,
            'Applicant_Phone' => $phone,
            'Application_Status' => $applicationStatus,
            'Store_ID' => $storeID
        );
    }
    return $data;
}



// Function to generate synthetic data for exchanges table
function generateExchangeData() {
    global $maxEntries;
    $data = array();
    $rowCount = rand(7, 15); // Generate a random number of rows between 7 and 15

    for ($i = 0; $i < $rowCount; $i++) {
        // Generate random values for each column
        $exchangeID = rand(1000000, 9999999); // Generate random exchange ID (7-digit number)
        $storeID = rand(1, 25); // Generate random store ID from 1 to 25
        $productID = rand(0,$maxEntries);

        // Add generated data to the array
        $data[] = array(
            'Exchange_ID' => $exchangeID,
            'Store_ID' => $storeID,
            'Product_ID' => $productID
        );
    }
    return $data;
}

// Function to generate synthetic data for returns table
function generateReturnData() {
    $data = array();
    $rowCount = rand(7, 15); // Generate a random number of rows between 7 and 15

    for ($i = 0; $i < $rowCount; $i++) {
        // Generate random values for each column
        $returnID = rand(1000000, 9999999); // Generate random return ID (7-digit number)
        $storeID = rand(1, 25); // Generate random store ID from 1 to 25

        // Add generated data to the array
        $data[] = array(
            'Return_ID' => $returnID,
            'Store_ID' => $storeID
        );
    }
    return $data;
}

// Function to generate synthetic data for the sales table
function generateSalesData() {
    $data = array();
    $rowCount = rand(7, 15); // Generate a random number of rows between 7 and 15

    for ($i = 0; $i < $rowCount; $i++) {
        $saleID = rand(1000000, 9999999); // Generate random sale ID (7-digit number)
        $quantitySold = rand(1, 100); // Generate random quantity sold
        $productSalePrice = number_format(rand(1, 9999) / 100, 2); // Generate random sale price (convert to decimal)
        $saleDate = date('Y-m-d', strtotime('-' . rand(1, 30) . ' days')); // Generate random sale date within last 30 days
        $storeID = rand(1, 25); // Generate random store ID from 1 to 25

        // Add generated data to the array
        $data[] = array(
            'Sale_ID' => $saleID,
            'Quantity_Sold' => $quantitySold,
            'Product_Sale_Price' => $productSalePrice,
            'Sale_Date' => $saleDate,
            'Store_ID' => $storeID
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
            $columns = implode(", ", array_keys($row));
            $values = "'" . implode("', '", $row) . "'";
            $sql = "INSERT INTO $table ($columns) VALUES ($values)";

            if ($conn->query($sql) !== TRUE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error: Data array is empty or connection is invalid.";
    }
}

// Function to generate a random string
function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return ucfirst($randomString); // Capitalize the first letter of the string
}
?>
