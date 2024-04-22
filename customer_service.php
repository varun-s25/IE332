<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Customer Service</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

$sql = "SELECT Store_ID, COUNT(*) as inquiry_count FROM customer_service GROUP BY Store_ID";
$result = $conn->query($sql);

$data = [];
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "[]";
}
$conn->close();


echo json_encode($data);
?>


<body>
    <canvas id="chart1"></canvas>
    <canvas id="chart2"></canvas>

    <script>
        const data = <?php echo json_encode($data); ?>;
        // Chart 1
        const ctx = document.getElementById('chart1').getContext('2d');
        const chart1 = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item=>item.Store_ID),
                datasets: [{
                    label: 'Number of Service Inquiries',
                    data: data.map(item=>item.inquiry_count),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
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
        // Chart 2
        var ctx2 = document.getElementById('chart2').getContext('2d');
        var chart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: 'Chart 2',
                    data: [5, 10, 8, 12, 6, 9],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
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
    </script>
</body>
</html>