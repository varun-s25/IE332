<!DOCTYPE html>
<html>
<head>
    <title>Supply Chain Management</title>
    <link rel = "stylesheet" type = "text/css" href = "styles.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="scripts.js"></script>
</head>
<body>

    <header>
        <h1>Supply Chain Management</h1>
    </header>

    <?php
        $suppliers = 100;
        $contracted = 60;
        $unlisted = 40;
        $spending = 10000;
        $savings = 3000;
        $cycleTime = 30000;

        $topSuppliers = array("Supplier 1", "Supplier 2", "Supplier 3", "Supplier 4", "Supplier 5", "Supplier 6", "Supplier 7", "Supplier 8", "Supplier 9", "Supplier 10");
    ?>


    <div class = "top">
        <div class = "top_left">
        <h2>Number of Suppliers</h2>
            <p>Number of Suppliers: <span><?php echo $suppliers; ?></span></p>
        </div>
        <div class = "top_middle">
            <h2>Contracted</h2>
            <p>Contracted: <span><?php echo $contracted; ?>%</span></p>
        </div>
        <div class = "top_right">
            <h2>Unlisted</h2>
            <p>Unlisted: <span><?php echo $unlisted; ?>%</span></p>
        </div>
    </div>

    <div class = "center">
        <div class = "center_left">
            <h2>Top Suppliers</h2>
            <ol id="topSuppliers" class="scrollable-list">
                <?php
                    foreach($topSuppliers as $supplier) {
                        echo "<li>$supplier</li>";
                    }
                ?>
            </ol>
        </div>
        <div class = "center_middle">
            <h2>Total Spending</h2>
            <p>Total Spending: <span><?php echo $spending; ?></span></p>
        </div>
        <div class = "center_right">
            <h2>Total Savings</h2>
            <p>Total Savings: <span><?php echo $savings; ?></span></p> 
        </div> 
    </div>

    <div class = "bottom">
        <div class = "bottom_left">
            <p>Average Procurement Cycle Time: <span><?php echo $cycleTime; ?></span></p>
        </div>
        <div class = "bottom_middle">
            <h2> Spending </h2>
            <canvas id = "spendingChart" width = "400" height = "200"></canvas>
        </div>
        <div class = "bottom_right">
            <h2> Savings </h2>
            <canvas id = "savingsChart" width = "400" height = "200"></canvas>
        </div>
    </div>


</body>
</html>
