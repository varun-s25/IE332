<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Customer Service</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            display:flex;
            justify-content:space-around;
            align-items: flex-start;
            padding:10px;
            flex-wrap:wrap;
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

<?php
$servername = "mydb.ics.purdue.edu";
$username = 'g1130865';
$password = 'GroupNine';
$database = 'g1130865'; 

$conn = new mysqli($servername, $username, $password, $database);

if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlChart1 = "SELECT Store_ID, COUNT(*) as inquiry_count FROM customer_service GROUP BY Store_ID";
$resultChart1 = $conn->query($sqlChart1);

$chart1Data = [];
if($resultChart1->num_rows > 0) {
    while($row = $resultChart1->fetch_assoc()) {
        $chart1Data[] = $row;
    }
} else {
    echo "[]";
}

$sqlChart2 = "SELECT Service_Type, COUNT(*) as count FROM customer_service GROUP BY Service_Type";
$resultChart2 = $conn->query($sqlChart2);

$chart2Data = [];
if($resultChart2->num_rows > 0) {
    while ($row = $resultChart2->fetch_assoc())
    {
        $chart2Data[] = $row;
    }
}



$conn->close();


echo "<script>";
echo "const chart1Data =  ", json_encode($chart1Data) . ";";
echo "const chart2Data = ", json_encode($chart2Data) . ";";
echo "</script>";
?>


<body>

<div class="chart-container">
    <div class ="scrollable-chart">
        <canvas id = "chart1"></canvas>
    </div>
    <div class = "scrollable-chart">
        <canvas id = "chart2"></canvas>
    </div>
</div>
    <script>
        // Chart 1
        const ctx = document.getElementById('chart1').getContext('2d');
        const chart1 = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chart1Data.map(item=>item.Store_ID),
                datasets: [{
                    label: 'Number of Service Inquiries',
                    data: chart1Data.map(item=>item.inquiry_count),
                    backgroundColor: 'rgba(0, 0, 139, 0.2)',
                    borderColor: 'rgba(0, 0, 139, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                legend: {
                    display: false
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        title: {
                            display: true,
                            text: 'Number of Inquiries',
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
                            text: 'Store ID',
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
        // Chart 2

        var ctx2 = document.getElementById('chart2').getContext('2d');
        var chart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: chart2Data.map(item=>item.Service_Type),
                datasets: [{
                    label: '# of Services by Type',
                    data: chart2Data.map(item=>item.count),
                    backgroundColor: 'rgba(0, 0, 139, 0.2)',
                    borderColor: 'rgba(0, 0, 139, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                legend: {
                    display: false
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Inquiries',
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
                            text: 'Service Type',
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
    </script>
</body>
</html>