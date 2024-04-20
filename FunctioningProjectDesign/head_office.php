<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Head Office Page</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .banner {
            background-color: #333;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .banner h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        .tabs-container {
            display: flex;
            flex-direction: column; /* Align tabs vertically */
            align-items: center; /* Align tabs horizontally */
            margin-top: 20px;
        }

        .tabs {
            display: flex; /* Display tabs as flex items */
            flex-wrap: nowrap; /* Prevent wrapping to next line */
        }
        .tab {
            cursor: pointer;
            padding: 10px 20px;
            background-color: #99a3ad; /* slightly lighter color */
            color: #fff;
            border-radius: 5px;
            margin: 5px;
            transition: background-color 0.3s ease;
            text-align: center; /* Center-align text */
        }
        .tab:hover {
            background-color: #7f8a94; /* darker color on hover */
        }
        .tab.selected {
            background-color: #555; /* even darker color for selected tab */
        }
        .content-container {
            flex-grow: 1;
            padding: 20px;
        }
        .division {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .dropdown {
            margin-right: 20px;
        }
        .dropdown select {
            padding: 10px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            background-color: #555;
            color: #fff;
            cursor: pointer;
        }
        .dropdown select:hover {
            background-color: #777;
        }
        .logout-button {
            margin-right: 20px;
            background-color: #555;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .logout-button:hover {
            background-color: #777;
        }
    </style>
</head>
<body>
    <div class="banner">
        <h1>Head Office</h1>
        <div class="dropdown">
            <select id="ribbon">
                <option value="ERP">Enterprise Resource Planning (ERP)</option>
                <option value="CRM">Customer Relationship Management (CRM)</option>
                <option value="SCM">Supply Chain Management (SCM)</option>
            </select>
        </div>
        
        <!-- Location dropdown populated from MySQL database -->
        <div class="dropdown">
            <select id="location">
                <?php
                // Establish connection to MySQL database
                $connection = mysqli_connect("mydb.ics.purdue.edu", "g1130865", "GroupNine", "g1130865");

                // Check connection
                if ($connection === false) {
                    die("ERROR: Could not connect. " . mysqli_connect_error());
                }

                // Query to retrieve locations from the database
                $query = "SELECT Store_Name FROM locations";
                $result = mysqli_query($connection, $query);

                // Check if the query was successful
                if ($result) {
                    // Loop through the result set and populate the dropdown options
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['Store_Name'] . "'>" . $row['Store_Name'] . "</option>";
                    }
                } else {
                    // If the query fails, handle the error
                    echo "Error: " . mysqli_error($connection);
                }

                // Close the database connection
                mysqli_close($connection);
                ?>
            </select>
        </div>
        
        <button class="logout-button" id="logout">Log Out</button>
        <div id="datetime"></div>
    </div>
    <div class="tabs-container">
        <div class="tabs">
            <div class="tab erp-tab" data-target="erp-accounting-financial-management">Accounting/Financial Management</div>
            <div class="tab erp-tab" data-target="erp-human-resources">Human Resources</div>
            <div class="tab erp-tab" data-target="erp-store-management">Store Management</div>
            <div class="tab erp-tab" data-target="erp-business-intelligence">Business Intelligence</div>
            <div class="tab crm-tab" data-target="crm-sales">Sales</div>
            <div class="tab crm-tab" data-target="crm-membership-management">Membership Management</div>
            <div class="tab crm-tab" data-target="crm-customer-service">Customer Service</div>
            <div class="tab crm-tab" data-target="crm-marketing-communication-channels">Marketing/Communication Channels</div>
            <div class="tab scm-tab" data-target="scm-inventory-management">Inventory Management</div>
            <div class="tab scm-tab" data-target="scm-order-management">Order Management</div>
            <div class="tab scm-tab" data-target="scm-warehouse-management">Warehouse Management</div>
            <div class="tab scm-tab" data-target="scm-transportation-management">Transportation Management</div>
        </div>
    </div>
    <div class="content-container">
        <div class="division erp-accounting-financial-management" style="display: block; color:black">
            Cash <br>(Graph/Table Placeholder)
            Accounting/Financial Management<br>(Graph/Table Placeholder)
        </div>
        <div class="division erp-human-resources" style="color:black">
            Human Resources<br>(Graph/Table Placeholderrrr)
        </div>
        <div class="division erp-store-management" style="color:black">
            Store Management<br>(Graph/Table Placeholder)
        </div>
        <div class="division erp-business-intelligence" style="color:black">
            Business Intelligence<br>(Graph/Table Placeholder)
        </div>
        <div class="division crm-sales" style="color:black">
            Sales<br>(Graph/Table Placeholder)
        </div>
        <div class="division crm-membership-management" style="color:black">
            Membership Management<br>(Graph/Table Placeholder)
        </div>
        <div class="division crm-customer-service" style="color:black">
            Customer Service<br>(Graph/Table Placeholder)
        </div>
        <div class="division crm-marketing-communication-channels" style="color:black">
            Marketing<br>(Graph/Table Placeholder)
        </div>
        <div class="division scm-inventory-management" style="color:black">
            Inventory Management<br>(Graph/Table Placeholder)
        </div>
        <div class="division scm-order-management" style="color:black">
            Order Management<br>(Graph/Table Placeholder)
        </div>
        <div class="division scm-warehouse-management" style="color:black">
            Warehouse Management<br>(Graph/Table Placeholder)
        </div>
        <div class="division scm-transportation-management" style="color:black">
            Transportation Management<br>(Graph/Table Placeholder)
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
                window.location.href = 'login_design.php';
            });
        });
    </script>
</body>
</html>
