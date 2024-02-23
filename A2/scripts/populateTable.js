// Get the table element from the DOM
const table = document.getElementById('table');

// Function to populate the table with provided labels and values
export const populateTable = (labels, values) => {
    // Get the size of the labels array
    const size = labels.length;

    // Iterate through the labels array
    for (let i = 0; i < labels.length; i++) {
        // Append HTML markup for each label and its corresponding value to the table
        table.innerHTML += 
        `<tr>
            <td>${labels[i]}</td>
            <td>${values[i]}</td>
        </tr>
        `;
    }
}

// Function to clear the contents of the table and reset it to its default state
export const clearTable = () => {
    // Reset the inner HTML of the table to display only the header row
    table.innerHTML = 
    `<tr>
        <th>Items</th>
        <th>Count</th>
    </tr>
    `;
}