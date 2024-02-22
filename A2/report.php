
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/style_report.css">
    <title>Summary Report Page</title>
</head>
<body>
    <div class="banner"></div>   
    <div class="primary-container">
        <div class="secondary-container">
            <div class="left column">
                <?php
                    
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);
                    
                    
                    // Check if the "mode" parameter is present in the query string
                    if (isset($_POST['mode'])) {
                        // Retrieve the value of the "mode" parameter
                        $mode = $_POST['mode'];

                        // Now you can use $mode as needed
                        echo "Mode: " . $mode;
                    } else {
                        // Handle the case where "mode" parameter is not provided
                        echo "Mode parameter not provided.";
                        
                        
                    }
                    ?>
                    <div class= "title">
                        <?php
                            if (isset($_POST[""])) {
                                echo "<div>";
                                echo "{$_POST["
                    </div>      
                        <div class="list">
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                    </ul>
                </div>
                        <div class="btn-container">
                            <a href="main.php"> <!-- working now -->
                            <button class="primary-btn" id="hmpg-btn">Back to Home Page</button>
                            </a>
                         </div>
            </div>
            <div class="right column">
                <div>
                   <original class= "original" id="original" name="original" rows="15" cols="50"></original>
                </div>
                <div>
                    <encrypted class="encrypted" id="encrypted" name="encrypted" rows="15" cols="50"></encrypted>
                </div>
            </div>
        </div>
    </div> 
    <script src="./scripts/app.js"></script>
</body>
</html>