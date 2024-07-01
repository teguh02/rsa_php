<?php

// import autoload
require_once __DIR__ . '/../vendor/autoload.php';

// Import the RSA module
use Teguh02\RsaPhp\RSA;

// Define p and q
const P = 61;
const Q = 53;

// Generate the RSA public and private keys
$keys = RSA::generateKeys(P, Q);

// Print the public and private keys
// echo "Public key: (" . $keys["public"][0] . ", " . $keys["public"][1] . ")\n";
// echo "Private key: (" . $keys["private"][0] . ", " . $keys["private"][1] . ")\n";

// Define the message to be encrypted
$message = "I LOVE YOU";

// Encrypt the message using the public key
$encrypted = RSA::encrypt($message, $keys);
print("Encrypted message: " . join(",", $encrypted) . "\n");

// Decrypt the message using the private key
// $decrypted = RSA::decrypt($encrypted, $keys);
$decrypted = RSA::decrypt('286,2774,83,913,1781,155,2774,206,913,2509', $keys);
print("Decrypted message: " . $decrypted . "\n");