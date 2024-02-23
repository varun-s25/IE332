<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character encoding and responsive design -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to external stylesheet -->
    <link rel="stylesheet" type="text/css" href="./assets/styles.css">
    <!-- Title of the page -->
    <title>Home Page</title>
</head>
<body>
    <!-- Banner section -->
    <div class="banner"></div>   
    <!-- Main content container -->
    <div class="primary-container">
        <!-- Secondary content container -->
        <div class="secondary-container">
            <!-- Left column with form -->
            <div class="left column">
                <!-- Form for submitting report -->
                <form id="report-form" method="post" action="report.php">
                    <!-- Radio buttons for selecting report type -->
                    <div class="radio-container">
                        <div class="radio">
                            <input class="radio-inputs" type="radio" id="letter-radio" name="option" value="letter">
                            <label for="letter">Letter</label>
                        </div>
                        <div class="radio">
                            <input class="radio-inputs" type="radio" id="word-radio" name="option" value="word">
                            <label for="word">Word</label>
                        </div>
                    </div>
                    <!-- Dropdown menu for word categories -->
                    <div class="dropdown">
                        <select name="word-categories" id="select-menu" class="hide-select">
                            <option value="" disabled selected>Select</option>
                            <option value="letters">All Letters</option>
                            <option value="vowels">All Vowels</option>
                            <option value="consonants">All Consonants</option>
                        </select>
                    </div>
                    <textarea type="text" id="textarea" rows="15" cols="50"></textarea>
                    <div class="btn-container">
                        <button class="primary-btn" id="reset-btn" type="button">Reset</button>
                        <button class="primary-btn" id="update-btn" type="button">Update</button>
                        <button class="primary-btn" id="gen-report-btn" name="gen-report'btn" type="button">Generate Report</button>
                    </div>

                </form>
            </div>
            <!-- Right column with chart and table -->
            <div class="right column">
                <!-- Plot section for displaying chart -->
                <div class="plot">
                    <canvas id="chart" width="485px" height="255px"></canvas>
                </div>
                <!-- Table section for displaying data -->
                <div class="table">
                    <table id="table">
                        <tr>
                            <th>Items</th>
                            <th>Count</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div> 
    <!-- JavaScript libraries and custom scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module" src="./scripts/createChart.js"></script>
    <script type="module" src="./scripts/populateTable.js"></script>
    <script type="module" src="./scripts/calculateFrequencies.js"></script>
    <script type="module" src="./scripts/app.js"></script>
</body>
</html>