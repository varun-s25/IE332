// Function to generate random data for the spending and savings charts
function generateChartData(numPoints, min, max) {
    var data = [];
    for (var i = 0; i < numPoints; i++) {
        data.push(Math.floor(Math.random() * (max - min + 1)) + min);
    }
    return data;
}

// Generate fake data for spending chart (example: 12 months of spending data)
var spendingData = generateChartData(12, 50000, 100000);

// Generate fake data for savings chart (example: 12 months of savings data)
var savingsData = generateChartData(12, 10000, 30000);

// Create spending chart
var spendingChartCtx = document.getElementById('spendingChart').getContext('2d');
var spendingChart = new Chart(spendingChartCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Spending',
            data: spendingData,
            borderColor: 'blue',
            fill: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Create savings chart
var savingsChartCtx = document.getElementById('savingsChart').getContext('2d');
var savingsChart = new Chart(savingsChartCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Savings',
            data: savingsData,
            borderColor: 'green',
            fill: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
