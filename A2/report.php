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
            <div class="left">
                <?php
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);
                    
                    $mode = 'word'; // Default mode
                    $textToAnalyze = ''; // Default text
                    
                    // Check if the "mode" parameter is present in the POST data
                    if (isset($_POST['mode'])) {
                        $mode = $_POST['mode'];
                    } else {
                        echo "Mode parameter not provided.<br>";
                    }

                    if (isset($_POST["textarea"])) {
                        $textToAnalyze = $_POST["textarea"]; // Get the text from POST data
                    } else {
                        echo "Text input not provided.<br>";
                    }
                ?>
                <h1>Top 10 Frequencies in <span id="modeDisplay"><?php echo htmlspecialchars($mode); ?></span> Mode</h1>
                <ul id="top10List">
                    <!-- Frequencies will be populated here by JavaScript -->
                </ul>
                <div class="btn-container">
                    <a href="main.php">
                        <button class="primary-btn" id="hmpg-btn">Back to Home Page</button>
                    </a>
                </div>
            </div>
            <div class="right">
                <!-- Right column content -->
                <div>
                   <original class= "original" id="original" name="original" rows="15" cols="50">Decrypted Text</original>
                </div>
                <div>
                    <encrypted class="encrypted" id="encrypted" name="encrypted" rows="15" cols="50">Encrytped Text</encrypted>
                </div>
            </div>
        </div>
    </div>
    <script src="./scripts/calculateFrequencies.js"></script>
    <script>
        // Define the mode and textToAnalyze variables using PHP within the script tag
        var mode = <?php echo json_encode($mode); ?>;
        var textToAnalyze = <?php echo json_encode($textToAnalyze); ?>;

        document.addEventListener('DOMContentLoaded', function() {
            // Update mode display
            document.getElementById('modeDisplay').textContent = mode.charAt(0).toUpperCase() + mode.slice(1);

            // Use the mode and textToAnalyze to calculate frequencies
            const frequencies = calculateFrequencies(mode, 'all', textToAnalyze);
            const sortedFrequencies = sortFrequencies(frequencies);

            // Select the list element
            const listElement = document.getElementById('top10List');
            listElement.innerHTML = ''; // Clear any existing content

            // Create list items for the top 10 frequencies and append them to the list
            Object.entries(sortedFrequencies).slice(0, 10).forEach(([key, value]) => {
                const listItem = document.createElement('li');
                listItem.textContent = `${key}: ${value}`;
                listElement.appendChild(listItem);
            });
        });
    </script>
</body>
</html>
