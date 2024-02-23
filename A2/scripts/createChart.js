const ctx = document.getElementById("chart").getContext('2d');

export const createChart = (labels, values) => {
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

    // Configure the options
    const options = {
        responsive: false,
        legend: {
            labels: {
                fontColor: '#fff' 
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#fff' 
                },
                scaleLabel: {
                    display: true,
                    labelString: 'Count',
                    font: {
                        size: 16,
                        weight: 'bold',
                        color: '#fff'
                    }
                }
                
            },
            x: {
                ticks: {
                    color: '#fff' 
                }
            }
        }
};

    // Create the chart
    const chart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });

    return chart;
};