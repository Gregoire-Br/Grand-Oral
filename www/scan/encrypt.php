<?php

include "var/encrypt_info.php";

$ine = '123456789AB';

echo "<p>ine : " . $ine . "</p>";

$ciphertext = openssl_encrypt($ine, $cipher, $key, $options=0, $iv);
echo "<p>ine crypté : " . $ciphertext . "</p>";

$deciphertext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv);
echo "<p>ine décrypté : " . $deciphertext . "</p>";