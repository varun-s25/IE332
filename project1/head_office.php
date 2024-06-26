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
            flex-direction: column;
            /* Align tabs vertically */
            align-items: center;
            /* Align tabs horizontally */
            margin-top: 20px;
        }

        .tabs {
            display: flex;
            /* Display tabs as flex items */
            flex-wrap: nowrap;
            /* Prevent wrapping to next line */
        }

        .tab {
            cursor: pointer;
            padding: 10px 20px;
            background-color: #99a3ad;
            /* slightly lighter color */
            color: #fff;
            border-radius: 5px;
            margin: 5px;
            transition: background-color 0.3s ease;
            text-align: center;
            /* Center-align text */
        }

        .tab:hover {
            background-color: #7f8a94;
            /* darker color on hover */
        }

        .tab.selected {
            background-color: #555;
            /* even darker color for selected tab */
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
    <select id="location" onchange="redirectToStore()">
        <?php
        // Establish connection to MySQL database
        $connection = mysqli_connect("mydb.ics.purdue.edu", "g1130865", "GroupNine", "g1130865");

        // Check connection
        if ($connection === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        // Query to retrieve locations from the database with both Store_Name and Store_ID
        $query = "SELECT Store_ID, Store_Name FROM locations";
        $result = mysqli_query($connection, $query);

        // Check if the query was successful
        if ($result) {
            // Loop through the result set and populate the dropdown options
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['Store_ID'] . "'>" . $row['Store_Name'] . "</option>";
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

<script>
    function redirectToStore() {
        // Get the selected store ID
        var storeID = document.getElementById("location").value;
        // Check if the selected store ID is not 0
        if (storeID !== "0") {
            // Redirect to the individual_store.php page with the selected store ID
            window.location.href = "individual_store.php?storeID=" + storeID;
        }
    }
</script>

        <button class="logout-button" id="logout">Log Out</button>
        <div id="datetime"></div>
    </div>
    <div class="tabs-container">
        <div class="tabs">
            <div class="tab erp-tab" data-target="erp-human-resources">Human Resources</div>
            <div class="tab erp-tab" data-target="erp-store-management">Store Management</div>
            <div class="tab crm-tab" data-target="crm-sales">Sales</div>
            <div class="tab crm-tab" data-target="crm-membership-management">Membership Management</div>
            <div class="tab crm-tab" data-target="crm-customer-service">Customer Service</div>
            <div class="tab crm-tab" data-target="crm-marketing-communication-channels">Marketing/Communication Channels
            </div>
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

            $storeID = 0;  // Initialize the storeID variable
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
        <div class="division erp-store-management" style="color:black; text-align:center;">
    <div style="width: 300px; height: 400px; margin: 0 auto; overflow-y: auto;">
        <?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $server = 'mydb.ics.purdue.edu';
        $dbname = 'g1130865';
        $username = 'g1130865';
        $password = 'GroupNine';
        $storeID = 0;

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
        <!-- Display the table with results -->
        <?php echo $tableData; ?>
    </div>
</div>

        <div class="division crm-sales" style="color:black">
    <?php
    // Establish connection to MySQL database
    $connection = mysqli_connect("mydb.ics.purdue.edu", "g1130865", "GroupNine", "g1130865");

    // Check connection
    if ($connection === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    // Query to calculate average engagement rating for a specific store
    $querySalesRating = "SELECT AVG(Sale_Price) AS avg_salesPrice FROM sales";

    // Execute the query for average service rating
    $salesRating = mysqli_query($connection, $querySalesRating);

    // Check if the query for average service rating was successful
    if ($salesRating) {
        // Fetch the result
        $rowRating = mysqli_fetch_assoc($salesRating);
        $averageRating = $rowRating['avg_salesPrice']; // Corrected column name

        // Display the average service rating with the determined color
        echo '<div class="popup-banner" style="background-color: #ffffff; padding: 10px; margin-bottom: 10px; text-align: center;">
                <span style="font-size: 2em; font-weight: bold;"> Average Transaction Value: $ </span>
                <span style="font-size: 2em; font-weight: bold; color: #000000;">' . round($averageRating, 2) . '</span>
              </div>'; // Round to two decimal places
    } else {
        // If the query fails, handle the error
        echo "Error: " . mysqli_error($connection);
    }
// Query to calculate sales per square foot for each store
$querySalesPerSqFeet = "SELECT l.Store_ID, AVG(s.Sale_Price / l.Store_Area) AS avg_salesPerSqFeet
                        FROM sales s
                        JOIN locations l ON s.Store_ID = l.Store_ID
                        GROUP BY l.Store_ID";

// Execute the query for sales per square foot
$salesPerSqFeetResult = mysqli_query($connection, $querySalesPerSqFeet);

// Check if the query for sales per square foot was successful
if ($salesPerSqFeetResult) {
    // Initialize total sales per square foot and count for averaging
    $totalSalesPerSqFeet = 0;
    $count = 0;

    // Loop through the results to calculate total sales per square foot
    while ($row = mysqli_fetch_assoc($salesPerSqFeetResult)) {
        $totalSalesPerSqFeet += $row['avg_salesPerSqFeet'];
        $count++;
    }

    // Calculate the average sales per square foot
    $averageSalesPerSqFeet = $totalSalesPerSqFeet / $count;

    // Display the average sales per square foot
    echo '<div class="popup-banner" style="background-color: #ffffff; padding: 10px; margin-bottom: 10px; text-align: center;">
            <span style="font-size: 2em; font-weight: bold;"> Average Sales Per Sq Ft of Stores: $ </span>
            <span style="font-size: 2em; font-weight: bold; color: #000000;">' . round($averageSalesPerSqFeet,6) . '</span>
          </div>'; // Round to two decimal places
} else {
    // If the query fails, handle the error
    echo "Error: " . mysqli_error($connection);
}


    // Query to calculate total sales for each store ID
    $queryTotalSales = "SELECT l.Store_ID, SUM(s.Sale_Price) AS total_sales, l.Store_Name
                        FROM sales s
                        JOIN locations l ON s.Store_ID = l.Store_ID
                        GROUP BY l.Store_ID";

    // Execute the query for total sales
    $totalSalesResult = mysqli_query($connection, $queryTotalSales);

    // Check if the query for total sales was successful
    if ($totalSalesResult) {
        // Initialize arrays to store data for chart
        $storeNames = [];
        $totalSales = [];

        // Fetch the results and populate arrays
        while ($row = mysqli_fetch_assoc($totalSalesResult)) {
            $storeNames[] = $row['Store_Name'];
            $totalSales[] = $row['total_sales'];
        }

        // Close the database connection
        mysqli_close($connection);
        
        // Encode arrays to JSON format for JavaScript
        $storeNamesJSON = json_encode($storeNames);
        $totalSalesJSON = json_encode($totalSales);
        ?>



        <!-- Display chart canvas centered -->
<div style="display: flex; justify-content: center;">
    <canvas id="salesChart" width="800" height="150"></canvas>
</div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
        <script>
            // Parse JSON data
            var storeNames = <?php echo $storeNamesJSON; ?>;
            var totalSales = <?php echo $totalSalesJSON; ?>;

            // Create bar chart
            var ctx = document.getElementById('salesChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: storeNames,
                    datasets: [{
                        label: 'Total Sales',
                        data: totalSales,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

    <?php } else {
        // If the query fails, handle the error
        echo "Error: " . mysqli_error($connection);
    } ?>

</div>
        <div class="division crm-membership-management" style="color:black">
            <?php
            $servername = "mydb.ics.purdue.edu";
            $username = 'g1130865';
            $password = 'GroupNine';
            $database = 'g1130865';

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "SELECT Member_Tier, COUNT(*) as count FROM membership_management GROUP BY Member_Tier";
            $result = $conn->query($query);

            $membershipData = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $membershipData[] = $row;
                }
            } else {
                echo "no data found";
            }

            $conn->close();


            echo "<script>";
            echo "const membershipData = ", json_encode($membershipData) . ";";
            echo "</script>";
            ?>

<div style="height: 400px; overflow-y: auto; display: flex; justify-content: center; align-items: center;">
    <canvas id="membershipChart" style="height: 1000px;"></canvas>
</div>


            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const ctx = document.getElementById('membershipChart').getContext('2d');


                    const chartData = membershipData.map(item => parseInt(item.count));
                    const chartLabels = membershipData.map(item => item.Member_Tier);

                    const membershipChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: chartLabels,
                            datasets: [{
                                label: 'Count of Members',
                                data: chartData,
                                backgroundColor: 'rgba(0, 0, 139, 0.2)',
                                borderColor: 'rgba(0, 0, 139, 1)',
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
                                    text: 'Membership Tier Distribution',
                                    padding: {
                                        top: 10,
                                        bottom: 30
                                    },
                                    font: {
                                        size: 20
                                    }
                                },
                            },
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Membership Tier',
                                        font: {
                                            size: 16
                                        }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Members',
                                        font: {
                                            size: 16
                                        }
                                    }
                                }
                            },
                            maintainAspectRatio: false,
                            responsive: true
                        }
                    });
                });

            </script>
        </div>

        <div class="division crm-customer-service" style="color:black">
        <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Customer Service</title>
    <style>
        .chart-container {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            padding: 10px;
            flex-wrap: wrap;
        }

        .scrollable-chart {
            width: 600px;
            height: 400px;
            overflow: auto;
            border: 1px solid #ccc;
            margin: 10px;
        }

        canvas {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
</head>
<body>
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

  // Query to retrieve data for chart 1
$sqlChart1 = "SELECT Store_ID, COUNT(*) as inquiry_count FROM customer_service GROUP BY Store_ID";
$resultChart1 = mysqli_query($connection, $sqlChart1);
$chart1Data = [];
if ($resultChart1) {
    while ($row = mysqli_fetch_assoc($resultChart1)) {
        $chart1Data[] = [
            'label' => $row['Store_ID'],
            'value' => $row['inquiry_count']
        ];
    }
}

// Query to retrieve data for chart 2
$sqlChart2 = "SELECT Service_Type, COUNT(*) as count FROM customer_service GROUP BY Service_Type";
$resultChart2 = mysqli_query($connection, $sqlChart2);
$chart2Data = [];
if ($resultChart2) {
    while ($row = mysqli_fetch_assoc($resultChart2)) {
        $chart2Data[] = [
            'label' => $row['Service_Type'],
            'value' => $row['count']
        ];
    }
}


    // Close the database connection
    mysqli_close($connection);
    ?>

    <div class="popup-banner"
        style="background-color: #ffffff; padding: 10px; margin-bottom: 10px; text-align: center;">
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
    <div class="popup-banner"
        style="background-color: #ffffff; padding: 10px; margin-bottom: 10px; text-align: center;">

        <div class="chart-container">
            <div class="scrollable-chart">
                <canvas id="chart1"></canvas>
            </div>
            <div class="scrollable-chart">
                <canvas id="chart2"></canvas>
            </div>
        </div>
        <script>
            // Chart 1 data
            const chart1Data = <?php echo json_encode($chart1Data); ?>;
            const ctx1 = document.getElementById('chart1').getContext('2d');
            drawChart(ctx1, chart1Data, 'Store ID', 'Number of Inquiries', 'Number of Service Inquiries by Store');

            // Chart 2 data
            const chart2Data = <?php echo json_encode($chart2Data); ?>;
            const ctx2 = document.getElementById('chart2').getContext('2d');
            drawChart(ctx2, chart2Data, 'Service Type', 'Number of Inquiries', 'Number of Service Inquiries by Type');

            function drawChart(ctx, data, xAxisLabel, yAxisLabel, title) {
                const labels = data.map(item => item.label);
                const values = data.map(item => item.value);

                const barColors = [];
                for (let i = 0; i < values.length; i++) {
                    barColors.push('lightblue'); // Pushing light blue color for all bar;
                }

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: yAxisLabel,
                            data: values,
                            backgroundColor: barColors,
                            borderColor: barColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: title,
                                padding: {
                                    top: 10,
                                    bottom: 30
                                },
                                font: {
                                    size: 20
                                }
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: yAxisLabel,
                                    color: "#666",
                                    font: {
                                        family: 'Arial',
                                        size: 16,
                                        weight: 'bold',
                                        lineHeight: 1.2
                                    }
                                }
                            },
                            x: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: xAxisLabel,
                                    color: "#666",
                                    font: {
                                        family: 'Arial',
                                        size: 16,
                                        weight: 'bold',
                                        lineHeight: 1.2
                                    }
                                }
                            }
                        }
                    }
                });
            }

            function getRandomColor() {
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
        </script>
    </div>
</body>
</html>

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

            <div class="popup-banner"
                style="background-color: #ffffff; padding: 10px; margin-bottom: 10px; text-align: center;">
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
            <div class="popup-banner"
                style="background-color: #ffffff; padding: 10px; margin-bottom: 10px; text-align: center;">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Marketing Data Visualization</title>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <style>
                        .chart-container {
                            width: 33%;
                            display: inline-block;
                            vertical-align: top;
                            /* Aligns charts to the top */
                            align-items: center;
                        }

                        /* Ensure the canvas has a definite size for Chart.js to render properly */
                        canvas {
                            width: 100%;
                            max-width: 750px;
                            height: 800px;
                            /* Fixed height for consistency */
                        }

                        /* Container for all the charts */
                        .charts-container {
                            text-align: center;
                            align-items: center;
                        }
                    </style>
                </head>
                <h1>Marketing Data Visualization</h1>

                <div class="charts-container">
                    <?php
                    // Establish connection to MySQL database
                    $connection = mysqli_connect("mydb.ics.purdue.edu", "g1130865", "GroupNine", "g1130865");

                    // Check connection
                    if ($connection === false) {
                        die("ERROR: Could not connect. " . mysqli_connect_error());
                    }

                    // Query to calculate average engagement rating for each platform
                    $engagementQuery = "SELECT Platform_Type, AVG(Engagement_Rating) AS avg_engagement FROM marketing_communication_channels GROUP BY Platform_Type";
                    $usageQuery = "SELECT Platform_Type, COUNT(*) AS platform_usage FROM marketing_communication_channels GROUP BY Platform_Type";
                    $scatterQuery = "SELECT Marketing_Time, Marketing_Price FROM marketing_communication_channels";

                    $engagementResult = mysqli_query($connection, $engagementQuery);
                    $usageResult = mysqli_query($connection, $usageQuery);
                    $scatterResult = mysqli_query($connection, $scatterQuery);

                    $engagementData = [];
                    $usageData = [];
                    $scatterData = [];

                    if ($engagementResult) {
                        while ($row = mysqli_fetch_assoc($engagementResult)) {
                            $engagementData[] = $row;
                        }
                    } else {
                        echo "Error: " . mysqli_error($connection);
                    }

                    if ($usageResult) {
                        while ($row = mysqli_fetch_assoc($usageResult)) {
                            $usageData[] = $row;
                        }
                    } else {
                        echo "Error: " . mysqli_error($connection);
                    }

                    if ($scatterResult) {
                        while ($row = mysqli_fetch_assoc($scatterResult)) {
                            $scatterData[] = $row;
                        }
                    } else {
                        echo "Error: " . mysqli_error($connection);
                    }

                    mysqli_close($connection);
                    ?>

                    <!-- Containers for the charts -->
                    <div class="chart-container">
                        <canvas id="engagementChart" width="840" height="320"
                            style="display: block; box-sizing: border-box; height: 320px; width: 640px;"></canvas>
                    </div>
                    <div class="chart-container">
                        <canvas id="usageChart" width="840" height="320"
                            style="display: block; box-sizing: border-box; height: 320px; width: 640px;"></canvas>
                    </div>
                    <div class="chart-container">
                        <canvas id="scatterChart" width="840" height="320"
                            style="display: block; box-sizing: border-box; height: 320px; width: 640px;"></canvas>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const engagementCtx = document.getElementById('engagementChart').getContext('2d');
                        const usageCtx = document.getElementById('usageChart').getContext('2d');
                        const scatterCtx = document.getElementById('scatterChart').getContext('2d');

                        const engagementData = <?php echo json_encode($engagementData); ?>;
                        const usageData = <?php echo json_encode($usageData); ?>;
                        const scatterData = <?php echo json_encode($scatterData); ?>;

                        // Chart for Average Engagement Rating
                        new Chart(engagementCtx, {
                            type: 'bar',
                            data: {
                                labels: engagementData.map(data => data.Platform_Type),
                                datasets: [{
                                    label: 'Average Engagement Rating',
                                    data: engagementData.map(data => parseFloat(data.avg_engagement)),
                                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                    borderColor: 'rgba(255, 99, 132, 0.8)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: false // This will hide the legend
                                    },
                                    title: {
                                        display: true,
                                        text: 'Engagement Rating by Platform',
                                        font: {
                                            size: 18
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Platform Type'
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Engagement Rating (1-100)'
                                        }
                                    }
                                }
                            }
                        });

                        // Chart for Platform Usage Count
                        new Chart(usageCtx, {
                            type: 'bar',
                            data: {
                                labels: usageData.map(data => data.Platform_Type),
                                datasets: [{
                                    label: 'Platform Usage Count',
                                    data: usageData.map(data => parseFloat(data.platform_usage)),
                                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                    borderColor: 'rgba(54, 162, 235, 0.8)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: false // This will hide the legend
                                    },
                                    title: {
                                        display: true,
                                        text: 'Platform Usage Count',
                                        font: {
                                            size: 18
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Platform Type'
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Usage Count'
                                        }
                                    }
                                }
                            }
                        });

                        // Scatter plot for Marketing Time vs. Price
                        new Chart(scatterCtx, {
                            type: 'scatter',
                            data: {
                                datasets: [{
                                    label: 'Marketing Time vs Price',
                                    data: scatterData.map(data => ({
                                        x: parseFloat(data.Marketing_Time),
                                        y: parseFloat(data.Marketing_Price)
                                    })),
                                    backgroundColor: 'rgba(FFFFFF, 192, 192, 0.5)',
                                    borderColor: 'rgba(FFFFFF, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: false // This will hide the legend
                                    },
                                    title: {
                                        display: true,
                                        text: 'Marketing Time vs Price Scatter Plot',
                                        font: {
                                            size: 18
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        type: 'linear',
                                        position: 'bottom',
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Marketing Time'
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Marketing Price ($)'
                                        }
                                    }
                                }
                            }
                        });
                    });
                </script>
            </div>

        </div>
        <div class="division scm-inventory-management" style="color:black">
        <div style="width: 300px; height: 400px; margin: 0 auto; overflow-y: auto;">
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
        </div>
                        </div>
        <div class="division scm-order-management" style="color:black;">
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

    // Query for number of orders per store
    $orderCounts = [];
    $result = $conn->query("SELECT Store_ID, COUNT(*) as OrderCount FROM order_management GROUP BY Store_ID");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $orderCounts[$row['Store_ID']] = $row['OrderCount'];
        }
        $result->free();
    }

    // Query for total price per store
    $totalPrices = [];
    $result = $conn->query("SELECT Store_ID, SUM(Product_Order_Price) as TotalPrice FROM order_management GROUP BY Store_ID");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $totalPrices[$row['Store_ID']] = $row['TotalPrice'];
        }
        $result->free();
    }

    $conn->close();
    ?>

    <h1 style="text-align: center;">Store Order Statistics</h1>
    <div style="display: flex; justify-content: space-around;">
        <div class="chart-container">
            <canvas id="ordersChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="pricesChart"></canvas>
        </div>
    </div>

    <script>
        const orderCounts = <?php echo json_encode($orderCounts); ?>;
        const totalPrices = <?php echo json_encode($totalPrices); ?>;

        const resizeCharts = () => {
            const canvasWidth = document.querySelector('.scm-order-management').offsetWidth * 0.20;
            const canvasHeight = 200;

            const ordersCanvas = document.getElementById('ordersChart');
            ordersCanvas.width = canvasWidth;
            ordersCanvas.height = canvasHeight;

            const pricesCanvas = document.getElementById('pricesChart');
            pricesCanvas.width = canvasWidth;
            pricesCanvas.height = canvasHeight;
        };

        window.addEventListener('resize', resizeCharts);
        resizeCharts();

        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        const pricesCtx = document.getElementById('pricesChart').getContext('2d');

        // Bar chart for number of orders per store
        new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(orderCounts),
                datasets: [{
                    label: 'Number of Orders per Store',
                    data: Object.values(orderCounts),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Number of Orders per Store'
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Orders'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Store ID'
                        }
                    }
                }
            }
        });

        // Bar chart for total product order price per store
        new Chart(pricesCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(totalPrices),
                datasets: [{
                    label: 'Total Product Order Price per Store',
                    data: Object.values(totalPrices),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Total Product Order Price per Store'
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Order Price ($)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Store ID'
                        }
                    }
                }
            }
        });
    </script>
</div>

        <div class="division scm-transportation-management" style="color:black">
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

            // Query for the count of each shipment method
            $shipmentCounts = [];
            $result = $conn->query("SELECT Shipment_Method, COUNT(*) AS MethodCount FROM transportation_management GROUP BY Shipment_Method");
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $shipmentCounts[$row['Shipment_Method']] = $row['MethodCount'];
                }
                $result->free();
            }


            $conn->close();
            ?>

<div style="display: flex; justify-content: center;">
    <h1>Transportation Management Statistics</h1>
</div>

            <div style="display: flex; justify-content: center; align-items: center; height: 300px;"> <!-- Adjust height as needed -->
    <div class="chart-container">
        <canvas id="shipmentMethodChart"></canvas>
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