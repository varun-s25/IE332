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

// Query for the total transportation price per store
$transportationPrices = [];
$result = $conn->query("SELECT Store_ID, SUM(Product_Transporation_Price) AS TotalPrice FROM transportation_management GROUP BY Store_ID");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $transportationPrices[$row['Store_ID']] = $row['TotalPrice'];
    }
    $result->free();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transportation Management Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 20px;
        }
        canvas {
            width: 100%;
            max-width: 600px;
        }
    </style>
</head>
<body>
    <h1>Transportation Management Statistics</h1>
    <div class="chart-container">
        <canvas id="shipmentMethodChart"></canvas>
        <canvas id="transportationPriceChart"></canvas>
    </div>

    <script>
        const shipmentCounts = <?php echo json_encode($shipmentCounts); ?>;
        const transportationPrices = <?php echo json_encode($transportationPrices); ?>;

        const methodCtx = document.getElementById('shipmentMethodChart').getContext('2d');
        const priceCtx = document.getElementById('transportationPriceChart').getContext('2d');

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

        // Bar chart for transportation prices by store
        new Chart(priceCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(transportationPrices),
                datasets: [{
                    label: 'Total Transportation Price by Store',
                    data: Object.values(transportationPrices),
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Total Product Transportation Price by Store ID'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Transportation Price ($)'
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
</body>
</html>
