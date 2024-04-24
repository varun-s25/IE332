<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Store Page</title>
    <link rel="stylesheet" href="individual_store_styles.css">
</head>
<body>
    <!-- PHP code to retrieve store name from the database using store ID -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] === "fetchHRData") {
        header('Content-Type: application/json');
        $servername = "mydb.ics.purdue.edu";
        $usernameDB = "g1130865";
        $passwordDB = "GroupNine";
        $dbname = "g1130865";
        $storeID = isset($_GET['storeID']) ? intval($_GET['storeID']) : 0;

        $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT first_name, last_name, email, phone_number FROM employees WHERE store_id = ?";
        $query = $conn->prepare($sql);
        $query->bind_param("i", $storeID);
        $query->execute();
        $result = $query->get_result();

        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }

        echo json_encode($employees);
        $query->close();
        $conn->close();
        exit();
    }

    // Rest of the initial PHP code for setting up the page
    $servername = "mydb.ics.purdue.edu";
    $usernameDB = "g1130865";
    $passwordDB = "GroupNine";
    $dbname = "g1130865";
    $storeID = isset($_GET['storeID']) ? $_GET['storeID'] : null;
    $storeName = "Unknown Store"; // Default store name

    $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($storeID) {
        $sql = "SELECT Store_Name FROM locations WHERE Store_ID = $storeID";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $storeName = $row['Store_Name'];
        }
    }
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
            <div class="tab erp-tab" data-target="erp-business-intelligence">Business Intelligence</div>
            <div class="tab crm-tab" data-target="crm-sales">Sales</div>
            <div class="tab crm-tab" data-target="crm-customer-service">Customer Service</div>
            <div class="tab scm-tab" data-target="scm-inventory-management">Inventory Management</div>
            <div class="tab scm-tab" data-target="scm-order-management">Order Management</div>
            <div class="tab scm-tab" data-target="scm-transportation-management">Transportation Management</div>
        </div>
    </div>
    <div class="content-container">
        <div class="division erp-human-resources" style="color:black">
            <!-- Data will be inserted here dynamically -->
        </div>
        <!-- Other divisions here -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.tab');
            const divisions = document.querySelectorAll('.division');

            function updateTabs(ribbon) {
                tabs.forEach(tab => tab.style.display = 'none');
                divisions.forEach(division => division.style.display = 'none');
                document.querySelectorAll('.' + ribbon.toLowerCase() + '-tab').forEach(tab => tab.style.display = 'block');
            }

            function handleTabClick(target) {
                divisions.forEach(division => division.style.display = 'none');
                tabs.forEach(tab => tab.classList.remove('selected'));
                document.querySelector('.' + target).style.display = 'block';
                document.querySelector('[data-target="' + target + '"]').classList.add('selected');
                if (target === 'erp-human-resources') {
                    fetchHumanResourcesData();
                }
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    handleTabClick(this.getAttribute('data-target'));
                });
            });

            const ribbonDropdown = document.getElementById('ribbon');
            ribbonDropdown.addEventListener('change', function () {
                updateTabs(this.value);
            });

            function fetchHumanResourcesData() {
                const storeID = <?php echo json_encode($storeID); ?>;
                fetch(`?action=fetchHRData&storeID=${storeID}`)
                    .then(response => response.json())
                    .then(data => {
                        const hrDiv = document.querySelector('.erp-human-resources');
                        hrDiv.innerHTML = '<h2>Human Resources Data</h2>';
                        data.forEach(emp => {
                            hrDiv.innerHTML += `<div>${emp.first_name} ${emp.last_name} - ${emp.email} - ${emp.phone_number}</div>`;
                        });
                    })
                    .catch(error => console.error('Error fetching HR data:', error));
            }
        

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
