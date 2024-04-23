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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Store Order Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Store Order Statistics</h1>
    <div>
        <canvas id="ordersChart"></canvas>
        <canvas id="pricesChart"></canvas>
    </div>

    <script>
        const orderCounts = <?php echo json_encode($orderCounts); ?>;
        const totalPrices = <?php echo json_encode($totalPrices); ?>;

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
</body>
</html>
