const resetBtn = document.getElementById('reset-btn');
const genReportBtn = document.getElementById('gen-report-btn'); // Changed the ID to gen-report-btn
const radios = document.querySelectorAll('.radio-inputs');
const selectMenu = document.getElementById('select-menu');
const textarea = document.getElementById('textarea');

let mode = 'letter';
let category = 'letters';

const addEventListeners = () => {
    radios.forEach(radio => {
        radio.addEventListener('click', (e) => {
            if (e.target.value === 'word') {
                mode = 'word';
                selectMenu.disabled = true;
            } else {
                mode = 'letter';
                selectMenu.disabled = false;
            }
        });
    });

    selectMenu.addEventListener('change', () => {
        category = selectMenu.value;
    });

    resetBtn.addEventListener('click', () => {
        textarea.value = '';
    });

    genReportBtn.addEventListener('click', () => {
        submitData();
    });
}

const submitData = () => {
    const inputData = textarea.value;
    const filteredData = filterData(inputData); // Filter the data before submission
    const data = {
        inputData: filteredData, // Use the filtered data
        mode: mode,
        category: category
    };

    // Send AJAX request to PHP script
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'A2server.php', true); // Change name of .php file as needed
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Data successfully submitted to server');
            console.log(xhr.responseText); // Log the response from the server
        } else {
            console.error('Error submitting data to server');
        }
    };
    xhr.send(JSON.stringify(data));
}

const filterData = (inputData) => {
    let filteredData = '';

    switch (category) {
        case 'all':
            filteredData = inputData.replace(/[^a-z]/ig, '');
            break;
        case 'consonants':
            filteredData = inputData.replace(/[aeiou]/ig, '');
            break;
        case 'vowels':
            filteredData = inputData.replace(/[^aeiou]/ig, '');
            break;
        default:
            filteredData = inputData;
    }

    return filteredData;
}

addEventListeners();

