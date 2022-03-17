<?php

include 'lib/phpqrcode/qrlib.php';
include "var/encrypt_info.php";

$ine = '123456789AB';
$ine_encrypt = openssl_encrypt($ine, $cipher, $key, $options=0, $iv);

QRcode::png($ine_encrypt, null, QR_ECLEVEL_H, 4);