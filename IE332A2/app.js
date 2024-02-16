document.addEventListener('DOMContentLoaded', function() {
    const updateBtn = document.getElementById('update-btn');
    const resetBtn = document.getElementById('reset-btn');
    const genReportBtn = document.getElementById('gen-report-btn');
    const radioInputs = document.querySelectorAll('.radio-inputs');
    const textarea = document.getElementById('textarea');
    let myChart = null; // Chart.js chart instance

    let currentMode = 'letter'; // Default mode

    // Function to count frequencies of letters or words
    function countFrequencies(text, mode) {
        const counts = {};
        if (mode === 'letter') {
            // Count letters
            text.replace(/\S/g, (letter) => {
                counts[letter.toLowerCase()] = (counts[letter.toLowerCase()] || 0) + 1;
            });
        } else {
            // Count words
            text.split(/\s+/).forEach((word) => {
                const wordLower = word.toLowerCase();
                counts[wordLower] = (counts[wordLower] || 0) + 1;
            });
        }
        return counts;
    }

    // Function to create or update the bar graph
    function createOrUpdateChart(labels, values) {
        const ctx = document.getElementById('myChart').getContext('2d');
        if (myChart) {
            myChart.destroy(); // Destroy the existing chart instance before creating a new one
        }
        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Frequency',
                    data: values,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
    }

    // Populate table with all frequencies
    function updateTable(data) {
        const table = document.querySelector('.table table');
        let html = `<tr><th>Items</th><th>Count</th></tr>`; // Reset table header

        Object.entries(data).sort((a, b) => b[1] - a[1]).forEach(([item, count]) => {
            html += `<tr><td>${item}</td><td>${count}</td></tr>`;
        });

        table.innerHTML = html;
    }

    // Event listeners for the radio buttons to switch modes
    radioInputs.forEach(radio => {
        radio.addEventListener('change', function() {
            currentMode = this.value;
        });
    });

    // Update button event listener
    updateBtn.addEventListener('click', function() {
        const text = textarea.value;
        const frequencies = countFrequencies(text, currentMode);
        const sortedData = Object.entries(frequencies).sort((a, b) => b[1] - a[1]);
        const labels = sortedData.map(item => item[0]);
        const values = sortedData.map(item => item[1]);

        createOrUpdateChart(labels, values.slice(0, 10)); // Update the plot with top 10 frequencies
        updateTable(frequencies); // Update the table with all frequencies
    });

    // Reset button event listener
    resetBtn.addEventListener('click', function() {
        textarea.value = '';
        if (myChart) {
            myChart.destroy(); // Reset the plot
        }
        document.querySelector('.table table').innerHTML = "<tr><th>Items</th><th>Count</th></tr>"; // Reset the table
    });

    // Ensure you have a <canvas> element with id="myChart" for the chart
});