
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/styles.css">
    <title>Home Page</title>
</head>
<body>
    <div class="banner"></div>   
    <div class="primary-container">
        <div class="secondary-container">
            <div class="left column">
            <form id="report-form" method="post" action="report.php">
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
                    <div class="dropdown">
                        <select name="word-categories" id="select-menu" class="hide-select">
                            <option value="" disabled selected>Select</option>
                            <option value="letters">All Letters</option>
                            <option value="vowels">All Vowels</option>
                            <option value="consonants">All Consonants</option>
                        </select>
                    </div>
                    <textarea type="text" id="textarea" name="textarea" rows="15" cols="50"></textarea>
                    <div class="btn-container">
                        <input type="Reset" name="reset-btn"
                        value="Reset">
                        <button class="primary-btn" id="reset-btn" type="button">Reset</button>
                        <button class="primary-btn" id="update-btn" type="button">Update</button>
                        <button class="primary-btn" id="gen-report-btn" type="submit">Generate Report</button>
                    </div>
                </form>
            </div>
            
            <div class="right column">
                <div class="plot">
                    <canvas id="chart" width="485px" height="255px"></canvas>
                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module" src="./scripts/createChart.js"></script>
    <script type="module" src="./scripts/populateTable.js"></script>
    <script type="module" src="./scripts/calculateFrequencies.js"></script>
    <script type="module" src="./scripts/app.js"></script>

</body>
</html>