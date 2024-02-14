const resetBtn = document.getElementById('reset-btn');
const reportBtn = document.getElementById('gen-report-btn');
const radios = document.getElementsByClassName('radio-inputs');
const letterRadio = document.getElementById('letter-radio');
const wordRadio = document.getElementById('word-radio');
const selectMenu = document.getElementById('select-menu');

let mode = 'letter';
let category = 'letters';

const addEventListeners = () => {
    for (let i = 0 ; i < radios.length ; i++) {
        radios[i].addEventListener('click', (e) => {
            if (e.target.defaultValue === 'word') {
                mode = 'word';
                selectMenu.disabled = true;
                selectMenu.classList.add('disable-select');
            }
            else {
                mode = 'letter';
                selectMenu.disabled = false;
                selectMenu.classList.remove('disable-select');
            }
        })
    }

    reportBtn.addEventListener('click', () => {
        console.log(mode);
    })

    selectMenu.addEventListener('change', () => {
        category = selectMenu.value;
        console.log(category);
    });
}

addEventListeners();



const getMode = (radios) => {
    if (radios[0].checked) {
        return 'letter';
    }
    else if (radios[1].checked) {
        console.log(selectMenu);
        selectMenu.disabled = true;
        return 'word';
    }
    else return 'none';
}