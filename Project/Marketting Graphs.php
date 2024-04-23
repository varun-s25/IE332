<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Access and Visualization</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .data-table {
            width: 45%;
            margin-bottom: 20px;
            display: inline-block;
            vertical-align: top; /* Aligns tables to the top */
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .chart-container {
            width: 45%;
            display: inline-block;
            vertical-align: top; /* Aligns charts to the top */
            margin-bottom: 20px;
        }
        /* Container for the data tables and graphs */
        .data-container {
            text-align: center;
        }
        /* Ensure the canvas has a definite size for Chart.js to render properly */
        canvas {
            width: 100%;
            max-width: 400px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Marketing Data from Database</h1>

    <div class="data-container">
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

        <!-- Table and bar chart for Average Engagement Rating -->
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>Platform Type</th>
                        <th>Average Engagement Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($engagementData as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['Platform_Type']) ?></td>
                            <td><?= htmlspecialchars($row['avg_engagement']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="chart-container">
                <canvas id="engagementChart"></canvas>
            </div>
        </div>

        <!-- Table and bar chart for Platform Usage Count -->
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>Platform Type</th>
                        <th>Usage Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usageData as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['Platform_Type']) ?></td>
                            <td><?= htmlspecialchars($row['platform_usage']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="chart-container">
                <canvas id="usageChart"></canvas>
            </div>
        </div>

        <!-- Table and scatter plot for Marketing Time vs. Marketing Price -->
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>Marketing Time</th>
                        <th>Marketing Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($scatterData as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['Marketing_Time']) ?></td>
                            <td><?= htmlspecialchars($row['Marketing_Price']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="chart-container">
                <canvas id="scatterChart"></canvas>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const engagementData = <?php echo json_encode($engagementData); ?>;
                const usageData = <?php echo json_encode($usageData); ?>;
                const scatterData = <?php echo json_encode($scatterData); ?>;

                const engagementCtx = document.getElementById('engagementChart').getContext('2d');
                const usageCtx = document.getElementById('usageChart').getContext('2d');
                const scatterCtx = document.getElementById('scatterChart').getContext('2d');

                // Chart for Engagement
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
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Chart for Usage
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
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Chart for Marketing Time vs. Price Scatter Plot
                new Chart(scatterCtx, {
                    type: 'scatter',
                    data: {
                        datasets: [{
                            label: 'Marketing Time vs. Price',
                            data: scatterData.map(data => ({
                                x: parseFloat(data.Marketing_Time),
                                y: parseFloat(data.Marketing_Price)
                            })),
                            backgroundColor: 'rgba(255, 206, 86, 0.5)',
                            borderColor: 'rgba(255, 206, 86, 0.8)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'linear',
                                position: 'bottom',
                                beginAtZero: true
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    </div>
</body>
</html>

