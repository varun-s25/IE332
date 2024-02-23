// Get the 2D rendering context of the canvas element with id "chart"
const ctx = document.getElementById("chart").getContext('2d');

// Function to create and render a chart using provided labels and values
export const createChart = (labels, values) => {
    // Define the data structure for the chart
    const data = {
        labels: labels,
        datasets: [{
            label: "Frequency",
            textColor: '#fff',
            backgroundColor: '#CBE896',
            borderColor: '#CBE896',
            data: values,
        }]
    };

    // Configure the options for the chart
    const options = {
        responsive: false,
        legend: {
            labels: {
                fontColor: '#fff' // Color of legend labels
            }
        },
        scales: {
            y: {
                beginAtZero: true, // Start the y-axis at zero
                ticks: {
                    color: '#fff' // Color of y-axis ticks
                },
                scaleLabel: {
                    display: true,
                    labelString: 'Count', // Label for the y-axis
                    font: {
                        size: 16, // Font size
                        weight: 'bold', // Font weight
                        color: '#fff' // Color of the label
                    }
                }
            },
            x: {
                ticks: {
                    color: '#fff' // Color of x-axis ticks
                }
            }
        }
    };

    // Create and render the chart using Chart.js library
    const chart = new Chart(ctx, {
        type: 'bar', // Type of chart (bar chart)
        data: data, // Data for the chart
        options: options // Options for the chart
    });

    return chart; // Return the created chart object
};