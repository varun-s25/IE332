export const calculateFrequencies = (mode, category, text) => {
    if(mode === 'word') {
        const frequencies = calculateForWords(text);
        return frequencies;
    }
    else { // if the mode is letter
        const frequencies = calculateForLetters(category, text);
        return frequencies;
    }
};

const calculateForWords = (text) => {
    const cleanedText = text.replace(/[.,\/#!$%\^&\*;:{}=\-_`~()]/g, '');

    // Split the text into words 
    const words = cleanedText.split(/\s+/);

    // Create an object to store the word frequencies
    const frequencies = {};

    // Iterate through the words and count their occurrences
    for (const word of words) {
        // If the word exists in the frequencies object, increment its count
        if (frequencies[word]) {
            frequencies[word]++;
        } else {
            // Otherwise, initialize its count to 1
            frequencies[word] = 1;
        }
    }

    return frequencies;
}

const calculateForLetters = (category, text) => {
    const cleanedText = text.replace(/[.,\/#!$%\^&\*;:{}=\-_`~()]/g, '');
    // Split the text into an array of characters
    const characters = cleanedText.split('');
    // Create an object to store the letter frequencies
    const frequencies = {};

    // Iterate through the characters and count their occurrences
    for (const char of characters) {
        // Skip non-alphabetic characters
        if (!/[a-zA-Z]/.test(char)) {
            continue;
        }
        // If the character exists in the frequencies object, increment its count
        if (frequencies[char]) {
            frequencies[char]++;
        } else {
            // Otherwise, initialize its count to 1
            frequencies[char] = 1;
        }
    }

    // frequencies represents all letters
    if (category === 'vowels') {
        const vowels = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'];
        for (const char in frequencies) {
            if (!vowels.includes(char)) {
                delete frequencies[char];
            }
        }
    } else if (category === 'consonants') {
        const vowels = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'];
        for (const char of vowels) {
            delete frequencies[char];
        }
    }

    return frequencies;
}

export const sortFrequencies = (frequencies) => {
    // Convert the frequencies object into an array of key-value pairs
    const entries = Object.entries(frequencies);

    // Sort the array based on the frequency count (the second element of each pair)
    entries.sort((a, b) => b[1] - a[1]);

    // Convert the sorted array back into an object
    const sortedFrequencies = {};
    for (const entry of entries) {
        sortedFrequencies[entry[0]] = entry[1];
    }

    return sortedFrequencies;
};