const table = document.getElementById('table');

export const populateTable = (labels, values) => {
    const size = labels.length;

    for (let i = 0 ; i < labels.length ; i++) {
        table.innerHTML += 
        `<tr>
            <td>${labels[i]}</td>
            <td>${values[i]}</td>
        </tr>
        `
    }
}

export const clearTable = () => {
    table.innerHTML = 
    `<tr>
        <th>Items</th>
        <th>Count</th>
    </tr>
    `
}