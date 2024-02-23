import { createChart } from "./createChart.js"; 
import { sortFrequencies, calculateFrequencies } from "./calculateFrequencies.js";
import { clearTable, populateTable } from "./populateTable.js";
const resetBtn = document.getElementById('reset-btn');
const reportBtn = document.getElementById('gen-report-btn');
const updateBtn = document.getElementById('update-btn');
const radios = document.getElementsByClassName('radio-inputs');
const letterRadio = document.getElementById('letter-radio');
const wordRadio = document.getElementById('word-radio');
const selectMenu = document.getElementById('select-menu');
const textArea = document.getElementById('textarea');
textArea.setAttribute('maxlength', '5000'); // Set the maximum length to 5000 characters
const reportForm = document.getElementById('report-form');

let mode = 'letter';
let category = 'letters';


let chart = createChart([], []); // Initialize chart with empty data arrays
// Function to add event listeners
const addEventListeners = () => {
    // Loop through radio buttons
    for (let i = 0 ; i < radios.length ; i++) {
        // Add click event listener to each radio button
        radios[i].addEventListener('click', (e) => {
            // Check if the clicked radio button is for 'word' mode
            if (e.target.defaultValue === 'word') {
                mode = 'word';// Set mode to 'word'
                selectMenu.disabled = true; // Disable select menu
                selectMenu.classList.add('hide-select'); // Hide select menu
            }
            else {
            // If not 'word' mode, assume letter mode was selected
                mode = 'letter'; // Set mode to 'letter'
                selectMenu.disabled = false; // Enable the dropdown menu
                selectMenu.classList.remove('hide-select'); // hide the'select' option
            }
        // Send an HTTP request to the PHP page with the selected mode
        })
    }
    // Add event listener to the report button
    reportBtn.addEventListener('click', () => {
        // Prevent the default action of the event (typically form submission)
        event.preventDefault();
        // Retrieve the mode, category, and text from their respective functions
        const mode = getMode();
        const category = getCategory();
        const text = getText();

        // Construct the query string with encoded parameters
        const queryString = `?mode=${encodeURIComponent(mode)}&category=${encodeURIComponent(category)}&text=${encodeURIComponent(text)}`;

        // Log the mode, category, and text to the console (for debugging)
        console.log(mode, category, text);

        // Redirect to the report.php page with the constructed query string
        window.location.href = 'report.php?reload=' + queryString;
        
    })

    // Add event listener to the updateBtn element
    updateBtn.addEventListener('click', () => {
        // Retrieve the mode, category, and text from their respective functions
        const mode = getMode();
        const category = getCategory();
        const text = getText();

         // Check if mode is 'none' or category is empty
        if(mode === 'none' || category === '') {
            // If either mode or category is not chosen, display an alert message
            alert("Please choose both mode and if applicable, a category.");
            // Return to exit the function without further execution
            return;
        }
        // Calculate frequencies based on mode, category, and text
        const frequencies = calculateFrequencies(mode, category, text);
        // Sort frequencies
        const sorted = sortFrequencies(frequencies);
        // Get the top 10 labels
        const labels = Object.keys(sorted).slice(0, 10);
        // Get the top 10 values
        const values = Object.values(sorted).slice(0, 10);
        // Destroy the existing chart
        chart.destroy();
        // Create a new chart with the updated data
        chart = createChart(labels, values);
        // Clear the existing table
        clearTable();
        // Populate the table with the top 10 frequencies
        populateTable(labels, values);
    })


    // Add event listener to the resetBtn element
    resetBtn.addEventListener('click', () => {
        // Reset text area value
        textArea.value = '';
        // Uncheck radio buttons
        radios[0].checked = false;
        radios[1].checked = false;
        // Reset select menu value and disable it
        selectMenu.value = 'All Letters';
        selectMenu.disabled = true;
        // Hide select menu
        selectMenu.classList.add('hide-select');
        // Clear the table
        clearTable();
        // Destroy the chart if it exists
        if (chart) chart.destroy();
    })

    // Add event listener to the selectMenu element    
    selectMenu.addEventListener('change', () => {
        // Update category based on select menu value
        category = selectMenu.value;
    });
}

addEventListeners();


// returns the chosen mode
const getMode = () => {
    if (radios[0].checked) {
        return 'letter';
    }
    else if (radios[1].checked) {
        selectMenu.disabled = true;
        return 'word';
    }
    else return 'none';
}

// gets the category if the mode is letter
const getCategory = () => {
    const mode = getMode();
    if (mode === 'word') {
        return undefined;
    }
    else {
        return selectMenu.value;
    }
}

// get whatever is in the textarea.
const getText = () => {
    return textArea.value;
}
