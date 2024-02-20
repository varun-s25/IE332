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
const reportForm = document.getElementById('report-form');

let mode = 'letter';
let category = 'letters';

let chart = createChart([], []);
const addEventListeners = () => {
    for (let i = 0 ; i < radios.length ; i++) {
        radios[i].addEventListener('click', (e) => {
            if (e.target.defaultValue === 'word') {
                mode = 'word';
                selectMenu.disabled = true;
                selectMenu.classList.add('hide-select');
            }
            else {
                mode = 'letter';
                selectMenu.disabled = false;
                selectMenu.classList.remove('hide-select');
            }
        })
    }

    reportBtn.addEventListener('click', () => {
        event.preventDefault();
        const mode = getMode();
        const category = getCategory();
        const text = getText();

        const queryString = `?mode=${(mode)}&category=${(category)}&text=${encodeURIComponent(text)}`;

        console.log(mode, category, text);

        window.location.href = 'report.php?reload=' + queryString;


        // send what we have to the server-side script
        
    })

    updateBtn.addEventListener('click', () => {
        const mode = getMode();
        const category = getCategory();
        const text = getText();
        if(mode === 'none' || category === '') {
            alert("Please choose both mode and if applicable, a category.");
            return;
        }
        const frequencies = calculateFrequencies(mode, category, text);
        const sorted = sortFrequencies(frequencies);
        const labels = Object.keys(sorted).slice(0, 10);
        const values = Object.values(sorted).slice(0, 10);
        chart.destroy();
        chart = createChart(labels, values);
        clearTable();
        populateTable(labels, values);
    })


    resetBtn.addEventListener('click', () => {
        textArea.value = '';
        radios[0].checked = false;
        radios[1].checked = false;
        selectMenu.value = 'All Letters';
        selectMenu.disabled = true;
        selectMenu.classList.add('hide-select');
        clearTable();
        if (chart) chart.destroy();
    })

    selectMenu.addEventListener('change', () => {
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
