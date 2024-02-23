<?php
// Encryption 
function encryptText($plaintext, $key) {
    // Initialization vector
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    
    // Encrypt plaintext
    $ciphertext = openssl_encrypt($plaintext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    
    // Combine the initialization vector and ciphertext
    $encryptedText = base64_encode($iv . $ciphertext);
    
    return $encryptedText;
}

// Decryption 
function decryptText($encryptedText, $key) {
    // Decode
    $encryptedData = base64_decode($encryptedText);
    
    // Get the initialization vector and ciphertext
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($encryptedData, 0, $ivLength);
    $ciphertext = substr($encryptedData, $ivLength);
    
    // Decrypt ciphertext 
    $plaintext = openssl_decrypt($ciphertext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    
    return $plaintext;
}

// Define secret key
$key = "SecretKey"; 

// Text to encrypt
$plaintext = "Input Text to Main Page";

// Encrypt text
$encryptedText = encryptText($plaintext, $key);
echo "Encrypted text: " . $encryptedText . "\n";

// Decrypt text
$decryptedText = decryptText($encryptedText, $key);
echo "Decrypted text: " . $decryptedText . "\n";

