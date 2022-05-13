<?php

$dbServerIp = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "grandoral";

$conn = mysqli_connect($dbServerIp, $dbUsername, $dbPassword, $dbName);

$affectedRow = 0;

function generateRandomString( $length = 8 ) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

$xml = simplexml_load_file("base.xml") or die("Error: Cannot create object");

    $firstname = $xml->PRENOM;
    $lastname = $xml->NOM_DE_FAMILLE;
    $status = $xml->CODE_REGIME;
    $email = $xml->MEL;
    $password = random_password(8);

    $username = generateRandomString(8);

    $sql = "INSERT INTO users(username, password, firstname, lastname, status, email) 
    values ('$username', '$password', '$firstname', '$lastname', '0', '$email')";
    
    $result = mysqli_query($conn, $sql);
    
    if (!empty($result)) {
        $affectedRow ++;
    } else {
        $error_message = mysqli_error($conn) . "\n";
    }
?>
<h2>Insert XML Data to MySql Table Output</h2>
<?php
if ($affectedRow > 0) {
    $message = $affectedRow . " records inserted";
} else {
    $message = "No records inserted";
}

?>