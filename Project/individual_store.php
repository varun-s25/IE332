<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Store Page</title>
    <link rel="stylesheet" href="individual_store_styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- PHP code to retrieve store name from the database using store ID -->
    <?php
    // Database connection
    $servername = "mydb.ics.purdue.edu"; // Change this to your server name
    $usernameDB = "g1130865"; // Change this to your database username
    $passwordDB = "GroupNine"; // Change this to your database password
    $dbname = "g1130865"; // Change this to your database name
    $storeID = isset($_GET['storeID']) ? $_GET['storeID'] : null; // Get store ID from URL parameter
    
    // Create connection
    $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to retrieve store name based on store ID
    //$storeName = "Head Office"; // Default store name if store ID is not provided or not found
    if ($storeID) {
        $sql = "SELECT Store_Name FROM locations WHERE Store_ID = $storeID";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $storeName = $row['Store_Name'];
        }
    }

    // Close connection
    $conn->close();
    ?>

    <div class="banner">
        <h1><?php echo htmlspecialchars($storeName); ?></h1>
        <div class="dropdown">
            <select id="ribbon">
                <option value="ERP">Enterprise Resource Planning (ERP)</option>
                <option value="CRM">Customer Relationship Management (CRM)</option>
                <option value="SCM">Supply Chain Management (SCM)</option>
            </select>
        </div>
        <button class="logout-button" id="logout">Log Out</button>
        <div id="datetime"></div>
    </div>
    <div class="tabs-container">
        <div class="tabs">
            <div class="tab erp-tab" data-target="erp-human-resources">Human Resources</div>
            <div class="tab erp-tab" data-target="erp-store-management">Store Management</div>
            <div class="tab crm-tab" data-target="crm-sales">Sales</div>
            <div class="tab crm-tab" data-target="crm-customer-service">Customer Service</div>
            <div class="tab scm-tab" data-target="scm-inventory-management">Inventory Management</div>
            <div class="tab scm-tab" data-target="scm-order-management">Order Management</div>
            <div class="tab scm-tab" data-target="scm-transportation-management">Transportation Management</div>
        </div>
    </div>
    <div class="content-container">
        <div class="division erp-human-resources" style="color:black">
            <div style="width: 500px; height: 400px; margin: 0 auto; overflow-y: auto;">
                <?php
                ini_set('display_errors', 1);
                error_reporting(E_ALL);

                $server = 'mydb.ics.purdue.edu';
                $dbname = 'g1130865';
                $username = 'g1130865';
                $password = 'GroupNine';

                $conn = new mysqli($server, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $storeID = isset($_GET['storeID']) ? $_GET['storeID'] : null;
                $applicants = [];  // Initialize an empty array to store applicant data
                

                // Prepare and execute the SQL query
                $query = $conn->prepare("SELECT Applicant_First_Name, Applicant_Last_Name, Applicant_Phone, Application_Status FROM human_resources WHERE Store_ID = ?");
                if ($query) {
                    $query->bind_param("i", $storeID);
                    $query->execute();

                    // Bind result variables
                    $query->bind_result($firstName, $lastName, $phone, $status);

                    // Fetch values
                    while ($query->fetch()) {
                        $applicants[] = [
                            'Applicant_First_Name' => $firstName,
                            'Applicant_Last_Name' => $lastName,
                            'Applicant_Phone' => $phone,
                            'Application_Status' => $status
                        ];
                    }
                    $query->close();
                } else {
                    echo "Failed to prepare the query: " . htmlspecialchars($conn->error);
                }

                $conn->close();
                ?>

                <h1>Applicant Information Viewer</h1>

                <?php if (!empty($applicants)): ?>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Phone Number</th>
                                <th>Application Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applicants as $applicant): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($applicant['Applicant_First_Name']); ?></td>
                                    <td><?php echo htmlspecialchars($applicant['Applicant_Last_Name']); ?></td>
                                    <td><?php echo htmlspecialchars($applicant['Applicant_Phone']); ?></td>
                                    <td><?php echo htmlspecialchars($applicant['Application_Status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

            </div>
        </div>
        <div class="division erp-store-management" style="color:black">
            <div style="width: 250px; height: 400px; margin: 0 auto; overflow-y: auto;">

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

                <h1>Employee List</h1>
                <?php echo $tableData; ?>


            </div>
        </div>
        <div class="division crm-sales" style="color:black">
            Sales<br>(Graph/Table Placeholder)
        </div>
        <div class="division crm-customer-service" style="color:black">
            <?php
            // Establish connection to MySQL database
            $connection = mysqli_connect("mydb.ics.purdue.edu", "g1130865", "GroupNine", "g1130865");

            // Check connection
            if ($connection === false) {
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            // Query to calculate average service rating for a specific store
            $queryRating = "SELECT AVG(Service_Rating) AS avg_rating FROM customer_service WHERE Store_ID = $storeID";

            // Execute the query for average service rating
            $resultRating = mysqli_query($connection, $queryRating);

            // Query to calculate average service time for a specific store
            $queryTime = "SELECT AVG(Service_Time) AS avg_time FROM customer_service WHERE Store_ID = $storeID";

            // Execute the query for average service time
            $resultTime = mysqli_query($connection, $queryTime);

            $sql = "SELECT Service_Type, COUNT(*) AS Count FROM customer_service WHERE Store_ID = ? GROUP BY Service_Type";
            $query = $connection->prepare($sql);
            if ($query) {
                $query->bind_param("i", $storeID);
                $query->execute();

                // Bind variables to prepare for fetching
                $query->bind_result($serviceType, $count);

                // Fetch values and populate the array
                while ($query->fetch()) {
                    $serviceData[$serviceType] = $count;
                }

                $query->close();
            } else {
                echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            }

            // Close the database connection
            mysqli_close($connection);
            ?>

            <div class="popup-banner"
                style="background-color: #f2f2f2; padding: 10px; margin-bottom: 10px; text-align: center;">
                <span style="font-size: 2em;">
                    <span style="font-weight: bold;"> Average Service Rating (/10): </span>
                    <?php
                    // Check if the query for average service rating was successful
                    if ($resultRating) {
                        // Fetch the result
                        $rowRating = mysqli_fetch_assoc($resultRating);
                        $averageRating = $rowRating['avg_rating'];

                        // Determine the color based on the average rating
                        $colorRating = '';
                        if ($averageRating < 4) {
                            $colorRating = 'red';
                        } elseif ($averageRating >= 4 && $averageRating <= 7) {
                            $colorRating = 'orange';
                        } else {
                            $colorRating = 'green';
                        }

                        // Display the average service rating with the determined color
                        echo '<span style="font-size: 1.2em; color: ' . $colorRating . ';">' . round($averageRating, 2) . '</span>'; // Round to two decimal places
                    } else {
                        // If the query fails, handle the error
                        echo "Error: " . mysqli_error($connection);
                    }
                    ?>
                </span>
                <span style="margin-left: 20px; margin-right: 20px; font-size: 2em;">
                    <span style="font-weight: bold;"> Average Service Time (min): </span>
                    <?php
                    // Check if the query for average service time was successful
                    if ($resultTime) {
                        // Fetch the result
                        $rowTime = mysqli_fetch_assoc($resultTime);
                        $averageTime = $rowTime['avg_time'];

                        // Determine the color based on the average time
                        $colorTime = '';
                        if ($averageTime < 15) {
                            $colorTime = 'green';
                        } elseif ($averageTime >= 15 && $averageTime <= 30) {
                            $colorTime = 'orange';
                        } else {
                            $colorTime = 'red';
                        }

                        // Display the average service time with the determined color
                        echo '<span style="font-size: 1.2em; color: ' . $colorTime . ';">' . round($averageTime, 2) . '</span>'; // Round to two decimal places
                    } else {
                        // If the query fails, handle the error
                        echo "Error: " . mysqli_error($connection);
                    }
                    ?>
                </span>
            </div>
            <canvas id="serviceTypeChart"></canvas>

            <script>
                const ctx = document.getElementById('serviceTypeChart').getContext('2d');
                const serviceData = <?php echo json_encode($serviceData); ?>;
                const serviceTypes = Object.keys(serviceData);
                const serviceCounts = Object.values(serviceData);

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: serviceTypes,
                        datasets: [{
                            label: 'Number of Services',
                            data: serviceCounts,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Distribution of Service Inquiries by Type'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Inquiries'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Service Type'
                                }
                            }
                        }
                    }
                });
            </script>
        </div>
        <div class="division scm-inventory-management" style="color:black">
            <div style="width: 200px; height: 400px; margin: 0 auto; overflow-y: auto;">
                <?php
                ini_set('display_errors', 1);
                error_reporting(E_ALL);

                $server = 'mydb.ics.purdue.edu';  // Your database host
                $dbname = 'g1130865';  // Your database name
                $username = 'g1130865';  // Your database username
                $password = 'GroupNine';  // Your database password
                $storeID = isset($_GET['storeID']) ? $_GET['storeID'] : null;

                // Create connection
                $conn = new mysqli($server, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $inventory = [];

                // Prepare and execute the SQL query for inventory
                $query = $conn->prepare("SELECT Product_ID, Quantity FROM inventory_management WHERE Store_ID = ?");
                if ($query) {
                    $query->bind_param("i", $storeID);
                    $query->execute();

                    // Bind variables to the prepared statement as result variables
                    $query->bind_result($productID, $quantity);

                    // Fetch values one by one
                    while ($query->fetch()) {
                        $inventory[] = [
                            'Product_ID' => $productID,
                            'Quantity' => $quantity
                        ];
                    }
                    $query->close();
                } else {
                    echo "Failed to prepare the query: " . htmlspecialchars($conn->error);
                }

                $conn->close();
                ?>

                <h1>Inventory Viewer</h1>

                <?php if (!empty($inventory)): ?>

                    <table border="1">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inventory as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['Product_ID']); ?></td>
                                    <td><?php echo htmlspecialchars($item['Quantity']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="division scm-order-management" style="color:black">
        <div style="width: 500px; height: 400px; margin: 0 auto; overflow-y: auto;">
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

            <h1>Store Order Details</h1>

            <!-- Display the table with results if any -->
            <?php echo $tableData; ?>

        </div>
    </div>
    <div class="division scm-transportation-management" style="color:black">
        <?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $server = 'mydb.ics.purdue.edu';  // Your database host
        $dbname = 'g1130865';  // Your database name
        $username = 'g1130865';  // Your database username
        $password = 'GroupNine';  // Your database password
        $storeID = isset($_GET['storeID']) ? $_GET['storeID'] : null;
        // Create connection
        $conn = new mysqli($server, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query for the count of each shipment method
        $shipmentCounts = [];
        $query = $conn->prepare("SELECT Shipment_Method, COUNT(*) AS MethodCount FROM transportation_management WHERE Store_ID = ? GROUP BY Shipment_Method ");
        if ($query) {
            $query->bind_param("i", $storeID);
            $query->execute();

            $query->bind_result($shipmentMethod, $methodCount);

            while ($query->fetch()) {
                $shipmentCounts[$shipmentMethod] = $methodCount;
            }
        } else {
            echo "Failed to prepare the query: " . htmlspecialchars($conn->error);
        }


        $conn->close();
        ?>

        <div style="display: flex; justify-content: center; align-items: center;">
            <div>
                <h1 style="text-align: center;">Transportation Management Statistics</h1>
                <div style="display: flex; justify-content: center; align-items: center; height: 300px; width: 600px;">
                    <!-- Adjust height and width as needed -->
                    <div class="chart-container" style="width: 100%; height: 100%;">
                        <canvas id="shipmentMethodChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <script>
            const shipmentCounts = <?php echo json_encode($shipmentCounts); ?>;


            const methodCtx = document.getElementById('shipmentMethodChart').getContext('2d');

            // Bar chart for shipment method counts
            new Chart(methodCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(shipmentCounts),
                    datasets: [{
                        label: 'Number of Shipments per Method',
                        data: Object.values(shipmentCounts),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Total Number of Each Shipping Method'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Shipments'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Shipment Method'
                            }
                        }
                    }
                }
            });


        </script>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.tab');
            const divisions = document.querySelectorAll('.division');

            function updateTabs(ribbon) {
                // Hide all tabs
                tabs.forEach(tab => tab.style.display = 'none');
                divisions.forEach(division => division.style.display = 'none');

                // Show tabs based on selected ribbon
                switch (ribbon) {
                    case 'ERP':
                        document.querySelectorAll('.erp-tab').forEach(tab => tab.style.display = 'block');
                        break;
                    case 'CRM':
                        document.querySelectorAll('.crm-tab').forEach(tab => tab.style.display = 'block');
                        break;
                    case 'SCM':
                        document.querySelectorAll('.scm-tab').forEach(tab => tab.style.display = 'block');
                        break;
                    default:
                        break;
                }
            }

            // Initial update based on default ribbon value
            const defaultRibbon = 'ERP';
            updateTabs(defaultRibbon);

            // Function to handle tab clicks
            function handleTabClick(target) {
                // Hide all divisions
                divisions.forEach(division => division.style.display = 'none');

                // Remove 'selected' class from all tabs
                tabs.forEach(tab => tab.classList.remove('selected'));

                // Show the division corresponding to the clicked tab
                document.querySelector('.' + target).style.display = 'block';

                // Add 'selected' class to the clicked tab
                document.querySelector('[data-target="' + target + '"]').classList.add('selected');
            }

            // Add event listeners to tabs
            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    const target = this.getAttribute('data-target');
                    handleTabClick(target);
                });
            });

            const ribbonDropdown = document.getElementById('ribbon');
            ribbonDropdown.addEventListener('change', function () {
                const selectedRibbon = this.value;
                updateTabs(selectedRibbon);
            });

            function updateTime() {
                const now = new Date();
                const datetimeElement = document.getElementById('datetime');
                datetimeElement.innerText = now.toLocaleString();
            }

            updateTime();
            setInterval(updateTime, 1000);

            // Log out functionality
            const logoutButton = document.getElementById('logout');
            logoutButton.addEventListener('click', function () {
                window.location.href = 'login_design';
            });
        });

        // Function to redirect user to login page
        function redirectToLoginPage() {
            window.location.href = 'login_design'; // Change this to your login page URL
        }

        // Function to track user activity
        function trackUserActivity() {
            let inactiveTime = 0;
            const maxInactiveTime = 300000; // 5 minutes in milliseconds

            function resetInactiveTime() {
                inactiveTime = 0;
            }

            function incrementInactiveTime() {
                inactiveTime += 1000; // Increment by 1 second
                if (inactiveTime >= maxInactiveTime) {
                    redirectToLoginPage(); // Redirect to login page after max inactive time
                }
            }

            function handleUserActivity() {
                resetInactiveTime();
            }

            // Event listeners for user activity
            document.addEventListener('mousemove', handleUserActivity);
            document.addEventListener('keypress', handleUserActivity);

            // Track inactive time
            setInterval(incrementInactiveTime, 1000); // Update every second
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Call the function to track user activity
            trackUserActivity();
        });

    </script>
</body>

</html>