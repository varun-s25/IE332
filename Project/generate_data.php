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

// Function to insert data into a table
function insertDataIntoTable($conn, $table, $data) {
    // Check if data is not empty and the connection is valid
    if (!empty($data) && $conn) {
        // Construct and execute SQL INSERT query
        $columns = implode(", ", array_keys($data[0])); // Get column names
        $values = array(); // Initialize values array
        foreach ($data as $row) {
            $rowValues = array_map(function($value) use ($conn) {
                return "'" . $conn->real_escape_string($value) . "'";
            }, $row); // Escape and quote each value
            $values[] = "(" . implode(", ", $rowValues) . ")";
        }
        $sql = "INSERT INTO $table ($columns) VALUES " . implode(", ", $values); // Construct query

        if ($conn->query($sql) !== TRUE) {
            echo "Error inserting data into $table: " . $conn->error;
        }
    } else {
        echo "No data to insert into $table.";
    }
}

// Retrieve existing Member_ID values from the membership_management table
$query = "SELECT Member_ID FROM membership_management";
$result = $conn->query($query);
if (!$result) {
    die("Error occurred while fetching Member_ID values: " . $conn->error);
}
$existingMemberIDs = array();
while ($row = $result->fetch_assoc()) {
    $existingMemberIDs[] = $row['Member_ID'];
}

// Retrieve existing Order_ID values from the order_management table
$query = "SELECT Order_ID FROM order_management";
$result = $conn->query($query);
if (!$result) {
    die("Error occurred while fetching Order_ID values: " . $conn->error);
}
$existingOrderIDs = array();
while ($row = $result->fetch_assoc()) {
    $existingOrderIDs[] = $row['Order_ID'];
}

// Retrieve existing User_ID values from the users table
$query = "SELECT User_ID FROM users";
$result = $conn->query($query);
if (!$result) {
    die("Error occurred while fetching User_ID values: " . $conn->error);
}
$existingUserIDs = array();
while ($row = $result->fetch_assoc()) {
    $existingUserIDs[] = $row['User_ID'];
}

// Find max emtries in inventory management for ProductID
$query = "SELECT COUNT(*) FROM inventory_management";  // No change needed here as it already targets the correct table
$result = $conn->query($query);
if (!$result) {
    die("Error occurred: " . $conn->error);
} else {
    $maxEntries = $result->fetch_row()[0];  // Corrected variable name for consistency
}



// Generate synthetic data for membership_management table
$membershipData = generateMembershipData();
// Generate synthetic data for marketing_communication_channels table
$marketingData = generateMarketingData();
// Generate synthetic data for order_management table
$orderData = generateOrderData();
// Generate synthetic data for transportation_management table
$transportationData = generateTransportationData();
// Generate synthetic data for human_resources table
$hrData = generateHRData();
// Generate synthetic data for inventory_management table
$inventoryData = generateInventoryData();

// Create new connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert Data first Run
insertDataIntoTable($conn, "inventory_management", $inventoryData);
insertDataIntoTable($conn, "order_management", $orderData);
insertDataIntoTable($conn, "membership_management", $membershipData);

// Close connection
$conn->close();


// Check if there are MemberIDs available
if (count($existingMemberIDs) > 0) {
    // Generate synthetic data for sales table
    $salesData = generateSalesData();
    // Generate synthetic data for customer_service table
    $serviceData = generateServiceData();
    // Generate synthetic data for the exchanges table
    $exchangeData = generateExchangeData();
    // Generate synthetic data for the returns table
    $returnData = generateReturnData();

    // Create new connection
    $conn = new mysqli($servername, $username, $password, $database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into tables
    
    insertDataIntoTable($conn, "marketing_communication_channels", $marketingData);
    
    insertDataIntoTable($conn, "transportation_management", $transportationData);
    insertDataIntoTable($conn, "human_resources", $hrData);
    
    insertDataIntoTable($conn, "sales", $salesData);
    insertDataIntoTable($conn, "customer_service", $serviceData);
    insertDataIntoTable($conn, "exchanges", $exchangeData);
    insertDataIntoTable($conn, "returns", $returnData);

    // Close connection
    $conn->close();
} else {
    // If no MemberIDs are available, refresh the page
    echo "<script>alert('MemberIDs have been added. Refresh the page to generate all data');</script>";
    echo "<script>setTimeout(function(){ location.reload(); }, 100);</script>"; // Reload the page after 2 seconds
}

// JavaScript code for the pop-up message and redirection
echo "<script>alert('Data successfully added to database');</script>";
echo "<script>setTimeout(function(){ window.location.href = 'login_design.php'; }, 100);</script>"; // Redirect after 2 seconds



function generateInventoryData() {
    global $maxEntries;
    $data = array();
    $rowCount = rand(15, 30); // Generate a random number of rows between 7 and 15

    $productTypes = array("Fresh Produce", "Packaged Foods", "Frozen Foods", "Bakery Items", "Meat And Seafood", "Dairy And Eggs", "Beverages", "Health And Beauty", 
    "Clothing And Footwear", "Electronics", "Home Appliances", "Furniture", "Sports And Fitness Equipment", "Automotive Supplies", "Office Supplies");

    for ($i = 0; $i < $rowCount; $i++) {
        // Generate random values for each column
        $productID = rand(1,$maxEntries);
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

// Function to generate synthetic data for membership_management table and optionally return Member IDs only
function generateMembershipData() {
    $data = array();
    $memberIDs = array(); // Array to store only Member IDs
    $usedPhones = array(); // Initialize array to track used phone numbers

    $rowCount = rand(20, 30); // Generate a random number of rows between 7 and 15

    // List of Tier statuses
    $tierStatuses = array("Platinum", "Gold", "Silver", "Bronze");

    for ($i = 0; $i < $rowCount; $i++) {
        // Generate random values for each column
        $MemberID = rand(1000000, 9999999);
        $memberIDs[] = $MemberID; // Add Member ID to the array
        $firstName = generateRandomString(10); // Generate random first name
        $lastName = generateRandomString(10); // Generate random last name
        $email = $firstName . "." . $lastName . "@example.com"; // Generate email based on first and last name
        // Ensure unique phone number
        do {
            $phone = sprintf('%010d', rand(1000000000, 2147483646)); // Ensures the phone number has 10 digits
        } while (array_key_exists($phone, $usedPhones)); // Check if the phone number is already used
        $usedPhones[$phone] = true; // Mark this phone number as used

        $tier = $tierStatuses[array_rand($tierStatuses)]; // Randomly select

        // Add generated data to the array
        $data[] = array(
            'Member_ID' => $MemberID,
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
        $marketingTime = rand(1, 30); // Generate random marketing time in days
        $engagementRating = rand(1, 99); // Generate random engagement rating
        $marketingPrice = rand(100, 99999) / 100; // Generate random marketing price (convert to decimal)

        // Add generated data to the array
        $data[] = array(
            'Marketing_ID' => $marketingID,
            'Platform_Type' => $platformType,
            'Marketing_Time' => $marketingTime,
            'Engagement_Rating' => $engagementRating,
            'Marketing_Price' => $marketingPrice
        );
    }
    return $data;
}

function generateServiceData() {
    global $existingUserIDs;
    global $existingMemberIDs;

    // Parse start_date and end_date from the URL
    $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-1 year'));
    $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

    // Convert start_date and end_date to timestamps
    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime($end_date);


    $data = array();
    $serviceTypes = array("Technical Support", "Billing Inquiry", "Product Assistance", "Complaint Resolution");

    // Shuffle existing user IDs and member IDs
    shuffle($existingUserIDs);
    shuffle($existingMemberIDs);

    // Select 8 user IDs
    $selectedUserIDs = array_slice($existingUserIDs, 0, 8);

    // Generate service data for each combination of selected user and member
    foreach ($selectedUserIDs as $userID) {
        // Select a random member ID
        $memberID = $existingMemberIDs[array_rand($existingMemberIDs)];

        // Generate random values for each service record
        $serviceID = rand(1000000, 9999999);
        $serviceType = $serviceTypes[array_rand($serviceTypes)]; // Randomly select a service type
        $serviceRating = rand(1, 10); // Generate random service rating (1 to 10)
        $serviceTime = rand(1, 45); // Generate random service time in minutes
        $storeID = rand(1, 25); // Generate random store ID from 1 to 25
        // Generate random sale date within the provided start and end dates
        $serviceDateTimestamp = mt_rand($start_timestamp, $end_timestamp);
        $serviceDate = date('Y-m-d', $serviceDateTimestamp);

        // Add generated data to the array
        $data[] = array(
            'Service_ID' => $serviceID,
            'Service_Type' => $serviceType,
            'Service_Rating' => $serviceRating,
            'Service_Time' => $serviceTime,
            'Store_ID' => $storeID,
            'Member_ID' => $memberID,
            'User_ID' => $userID,
            'Service_Date' => $serviceDate
        );

        // If 8 rows are reached, exit the loop
        if (count($data) >= 8) {
            break;
        }
    }

    return $data;
}

// Function to generate synthetic data for order_management table
function generateOrderData() {
    global $maxEntries;

    // Parse start_date and end_date from the URL
    $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-1 year'));
    $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

    // Convert start_date and end_date to timestamps
    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime($end_date);
    
    $data = array();
    $rowCount = rand(7, 15); // Generate a random number of rows between 7 and 15

    $productTypes = array("Fresh Produce", "Packaged Foods", "Frozen Foods", "Bakery Items", "Meat And Seafood", "Dairy And Eggs", "Beverages", "Health And Beauty", 
    "Clothing And Footwear", "Electronics", "Home Appliances", "Furniture", "Sports And Fitness Equipment", "Automotive Supplies", "Office Supplies");

    for ($i = 0; $i < $rowCount; $i++) {
        // Generate random values for each column
        $orderID = rand(1000000, 9999999);
        $quantity = rand(1, 100); // Generate random quantity
        $placementDateTimestamp = mt_rand($start_timestamp, $end_timestamp);
        $placementDate = date('Y-m-d', $placementDateTimestamp);        
        $arrivalDate = date('Y-m-d', strtotime($placementDate . ' +' . rand(5, 20) . ' days')); // Arrival date 5 to 20 days after placement date        $storeID = rand(1, 25); // Generate random store ID from 1 to 25
        $storeID = rand(1, 25); // Generate random store ID from 1 to 25
        if ($maxEntries > 7) {
            $productID = rand(1, $maxEntries);
        } else {
            $productIdRange = range(1, 7); // Array containing numbers from 1 to 7
            
            // Shuffle the array to randomize the order
            shuffle($productIdRange);
        
            // Select the first element from the shuffled array
            $productID = $productIdRange[0];
        }
        
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
    global $existingOrderIDs;
    $data = array();
    $rowCount = rand(7, 15); // Generate a random number of rows between 7 and 15
    
    // List of shipment methods
    $shipmentMethods = array("Air", "Land", "Sea");

    foreach($existingOrderIDs as $OrderID) {
            // Generate random values for each column

            $shipmentID = rand(1000000, 9999999); // Generate random shipment ID (7-digit number)
            $shipmentMethod = $shipmentMethods[array_rand($shipmentMethods)]; // Randomly select a shipment method from the list
            $transportationPrice = number_format((float)rand(50000, 30000), 2, '.', ''); // Generate random transportation price with 2 decimal places
            $storeID = rand(1, 25); // Generate random store ID from 1 to 25

            // Add generated data to the array
            $data[] = array(
                'Shipment_ID' => $shipmentID,
                'Shipment_Method' => $shipmentMethod,
                'Product_Transportation_Price' => $transportationPrice,
                'Store_ID' => $storeID,
                'Order_ID' => $OrderID
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
    global $existingMemberIDs;
    global $maxEntries;

    // Parse start_date and end_date from the URL
    $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-1 year'));
    $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

    // Convert start_date and end_date to timestamps
    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime($end_date);

    $data = array();
    
    // Generate a random number of rows between 7 and 15
    $rowCount = rand(7, 15);

    // Shuffle the existing member IDs to randomize selection
    shuffle($existingMemberIDs);

    // Select a subset of existing member IDs based on the row count
    $selectedMemberIDs = array_slice($existingMemberIDs, 0, $rowCount);

    // Loop through each selected member ID
    foreach($selectedMemberIDs as $MemberID) {
        // Generate random values for each column
        $exchangeID = rand(1000000, 9999999); // Generate random exchange ID (7-digit number)
        $storeID = rand(1, 25); // Generate random store ID from 1 to 25
        $productID = rand(0, $maxEntries);
        // Generate random sale date within the provided start and end dates
        $exchangeDateTimestamp = mt_rand($start_timestamp, $end_timestamp);
        $exchangeDate = date('Y-m-d', $exchangeDateTimestamp);

        // Add generated data to the array
        $data[] = array(
            'Exchange_ID' => $exchangeID,
            'Store_ID' => $storeID,
            'Member_ID' => $MemberID,
            'Product_ID' => $productID,
            'Exchange_Date' => $exchangeDate

        );
    }
    return $data;
}


// Function to generate synthetic data for returns table
function generateReturnData() {
    global $existingMemberIDs;

    // Parse start_date and end_date from the URL
    $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-1 year'));
    $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

    // Convert start_date and end_date to timestamps
    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime($end_date);


    $data = array();
    
    // Generate a random number of rows between 7 and 15
    $rowCount = rand(7, 15);

    // Shuffle the existing member IDs to randomize selection
    shuffle($existingMemberIDs);

    // Select a subset of existing member IDs based on the row count
    $selectedMemberIDs = array_slice($existingMemberIDs, 0, $rowCount);

    // Loop through each selected member ID
    foreach($selectedMemberIDs as $MemberID) {
            // Generate random values for each column
            $returnID = rand(1000000, 9999999); // Generate random return ID (7-digit number)
            $storeID = rand(1, 25); // Generate random store ID from 1 to 25
            // Generate random sale date within the provided start and end dates
            $returnDateTimestamp = mt_rand($start_timestamp, $end_timestamp);
            $returnDate = date('Y-m-d', $returnDateTimestamp);

            // Add generated data to the array
            $data[] = array(
                'Return_ID' => $returnID,
                'Store_ID' => $storeID,
                'Member_ID' => $MemberID,
                'Return_Date' => $returnDate
            );
        }    
    return $data;
}

// Generate synthetic data for sales table
function generateSalesData() {
    global $maxEntries;
    global $existingMemberIDs;

    // Parse start_date and end_date from the URL
    $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-1 year'));
    $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

    // Convert start_date and end_date to timestamps
    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime($end_date);

    $data = array();
    $rowCount = rand(7, 15); // Generate a random number of rows between 7 and 15

    // Shuffle the existing member IDs to randomize selection
    shuffle($existingMemberIDs);

    // Select a subset of existing member IDs based on the row count
    $selectedMemberIDs = array_slice($existingMemberIDs, 0, $rowCount);

    // Loop through each selected member ID
    foreach($selectedMemberIDs as $MemberID) {
        // Generate random values for each column
        $saleID = rand(1000000, 9999999); // Generate random sale ID (7-digit number)
        $quantitySold = rand(1, 20); // Generate random quantity sold
        $SalePrice = number_format(rand(1, 1000), 2); // Generate random sale price (convert to decimal)

        // Generate random sale date within the provided start and end dates
        $saleDateTimestamp = mt_rand($start_timestamp, $end_timestamp);
        $saleDate = date('Y-m-d', $saleDateTimestamp);

        $storeID = rand(1, 25); // Generate random store ID from 1 to 25
        $productID = rand(1, $maxEntries);

        // Add generated data to the array
        $data[] = array(
            'Sale_ID' => $saleID,
            'Quantity_Sold' => $quantitySold,
            'Sale_Price' => $SalePrice,
            'Sale_Date' => $saleDate,
            'Store_ID' => $storeID,
            'Member_ID' => $MemberID,
            'Product_ID' => $productID
        );
    }

    return $data;
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
