<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$server = 'mydb.ics.purdue.edu';
$dbname = 'g1130865';
$username = 'g1130865';
$password = 'GroupNine';
$serviceData = [];

$storeID = isset($_GET['storeID']) ? $_GET['storeID'] : null;


    $conn = new mysqli($server, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT Service_Type, COUNT(*) AS Count FROM customer_service WHERE Store_ID = ? GROUP BY Service_Type";
    $query = $conn->prepare($sql);
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
    $conn->close();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service Type Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Service Type Count for Store</h1>

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
</body>
</html>
