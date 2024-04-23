<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Head Office Page</title>
    <link rel="stylesheet" href="head_office_styles1.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                $locationQuery = "SELECT Store_Name FROM locations";
                $locationResult = mysqli_query($connection, $locationQuery);

                // Initialize an array to store options for dropdown
                $locations = [];

                // Check if the query was successful
                if ($locationResult) {
                    // Loop through the result set and populate the dropdown options
                    while ($row = mysqli_fetch_assoc($locationResult)) {
                        $locations[] = $row; // Save the row for later use
                        echo "<option value='" . htmlspecialchars($row['Store_Name']) . "'>" . htmlspecialchars($row['Store_Name']) . "</option>";
                    }
                } else {
                    // If the query fails, handle the error
                    echo "Error: " . mysqli_error($connection);
                }

                // First chart: Number of customer service inquiries per store
                $queryInquiries = "SELECT Store_ID, COUNT(*) as inquiry_count FROM customer_service GROUP BY Store_ID";
                $resultInquiries = mysqli_query($connection, $queryInquiries);

                $chart1Data = [];
                if ($resultInquiries) {
                    while ($row = mysqli_fetch_assoc($resultInquiries)) {
                        $chart1Data[] = $row;
                    }
                } else {
                    echo "Error: " . mysqli_error($connection);
                }

                // Second chart: Count of different service types
                $queryServiceTypes = "SELECT Service_Type, COUNT(*) as count FROM customer_service GROUP BY Service_Type";
                $resultServiceTypes = mysqli_query($connection, $queryServiceTypes);

                $chart2Data = [];
                if ($resultServiceTypes) {
                    while ($row = mysqli_fetch_assoc($resultServiceTypes)) {
                        $chart2Data[] = $row;
                    }
                } else {
                    echo "Error: " . mysqli_error($connection);
                }

                // Close the database connection
                mysqli_close($connection);

                // Encode the data for Chart.js usage
                echo "<script>";
                echo "var locations = " . json_encode($locations) . ";";
                echo "var chart1Data = " . json_encode($chart1Data) . ";";
                echo "var chart2Data = " . json_encode($chart2Data) . ";";
                echo "</script>";
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
            <div class="tab crm-tab" data-target="crm-sales">Sales</div>
            <div class="tab crm-tab" data-target="crm-membership-management">Membership Management</div>
            <div class="tab crm-tab" data-target="crm-customer-service">Customer Service</div>
            <div class="tab crm-tab" data-target="crm-marketing-communication-channels">Marketing/Communication Channels</div>
            <div class="tab scm-tab" data-target="scm-inventory-management">Inventory Management</div>
            <div class="tab scm-tab" data-target="scm-order-management">Order Management</div>
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
        <div class="division crm-sales" style="color:black">
            Sales<br>(Graph/Table Placeholder)
        </div>
        <div class="division crm-membership-management" style="color:black">
            Membership Management<br>(Graph/Table Placeholder)
        </div>
        <div class="division crm-customer-service" style="color:black">

            <div class="chart-container">
                <canvas id="chart1"></canvas>
            </div>
        
            <div class="chart-container">
                <canvas id="chart2"></canvas>
            </div>
        
        <?php
            // Establish connection to MySQL database
            $connection = mysqli_connect("mydb.ics.purdue.edu", "g1130865", "GroupNine", "g1130865");

            // Check connection
            if ($connection === false) {
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            // Query to calculate average service rating for a specific store
            $queryRating = "SELECT AVG(Service_Rating) AS avg_rating FROM customer_service";

            // Execute the query for average service rating
            $resultRating = mysqli_query($connection, $queryRating);

            // Query to calculate average service time for a specific store
            $queryTime = "SELECT AVG(Service_Time) AS avg_time FROM customer_service";

            // Execute the query for average service time
            $resultTime = mysqli_query($connection, $queryTime);

            // Close the database connection
            mysqli_close($connection);
            ?>

            <div class="popup-banner" style="background-color: #f2f2f2; padding: 10px; margin-bottom: 10px; text-align: center;">
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
            
            <script>
                // Function to initialize charts
                function initCharts(chart1Data, chart2Data) {
                    const ctx1 = document.getElementById('chart1').getContext('2d');
                    const chart1 = new Chart(ctx1, {
                        type: 'bar',
                        data: {
                            labels: chart1Data.map(item => item.Store_ID),
                            datasets: [{
                                label: 'Number of Service Inquiries',
                                data: chart1Data.map(item => item.inquiry_count),
                                backgroundColor: 'rgba(0, 0, 139, 0.2)',
                                borderColor: 'rgba(0, 0, 139, 1)'
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    const ctx2 = document.getElementById('chart2').getContext('2d');
                    const chart2 = new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: chart2Data.map(item => item.Service_Type),
                            datasets: [{
                                label: '# of Services by Type',
                                data: chart2Data.map(item => item.count),
                                backgroundColor: 'rgba(0, 0, 139, 0.2)',
                                borderColor: 'rgba(0, 0, 139, 1)'
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }

                // Add event listeners to tabs
                tabs.forEach(tab => {
                    tab.addEventListener('click', function () {
                        const target = this.getAttribute('data-target');
                        handleTabClick(target);

                        // Check if the 'Customer Service' tab was clicked
                        if (target === 'crm-customer-service') {
                            // Call the initCharts function with the PHP-generated data
                            initCharts(chartDataInquiries, chartDataServiceTypes);
                        }
                    });
                });

            </script>
            
        
        </div>
        <div class="division crm-marketing-communication-channels" style="color:black">
            <?php
                // Establish connection to MySQL database
                $connection = mysqli_connect("mydb.ics.purdue.edu", "g1130865", "GroupNine", "g1130865");

                // Check connection
                if ($connection === false) {
                    die("ERROR: Could not connect. " . mysqli_connect_error());
                }

                // Query to calculate average engagement rating for a specific store
                $queryRating = "SELECT AVG(Engagement_Rating) AS avg_engagement FROM marketing_communication_channels";

                // Execute the query for average service rating
                $engagementRating = mysqli_query($connection, $queryRating);

                // Close the database connection
                mysqli_close($connection);
            ?>

                <div class="popup-banner" style="background-color: #f2f2f2; padding: 10px; margin-bottom: 10px; text-align: center;">
                    <span style="font-size: 2em;">
                        <span style="font-weight: bold;"> Average Engagement Rating (/100): </span> 
                        <?php
                        // Check if the query for average service rating was successful
                        if ($engagementRating) {
                            // Fetch the result
                            $rowRating = mysqli_fetch_assoc($engagementRating);
                            $averageRating = $rowRating['avg_engagement'];

                            // Determine the color based on the average rating
                            $colorRating = '';
                            if ($averageRating < 40) {
                                $colorRating = 'red';
                            } elseif ($averageRating >= 40 && $averageRating <= 70) {
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
                </div>
        </div>    
        <div class="division scm-inventory-management" style="color:black">
            Inventory Management<br>(Graph/Table Placeholder)
        </div>
        <div class="division scm-order-management" style="color:black">
            Order Management<br>(Graph/Table Placeholder)
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
