<?php

// $store = "wareatwt";

// // encode
// echo base64_encode($store);
// echo "<br>";

// echo base64_decode("d2FyZWF0d3Q=");

$data = "hello world";
$key = "secret1234567890";
$method = "AES-128-CTR";

// create IV
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

// encrypt
$encrypted = openssl_encrypt($data, $method, $key, 0, $iv);

// decrypt
$decrypted = openssl_decrypt($encrypted, $method, $key, 0, $iv);

// output
echo "Original: " . $data . "<br>";
echo "Encrypted: " . $encrypted . "<br>";
echo "Decrypted: " . $decrypted . "<br>";
?>