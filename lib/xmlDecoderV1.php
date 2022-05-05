<h2>Insert XML Data to MySql Table Output</h2>

<?php

include "sql.php";
include "GOBDD.php";


$bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password);

$affectedRow = 0;
$message= "";

function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

$xml = simplexml_load_file("ElevesLTLV.xml") or die("Error: Cannot create object");

$firstname = "";
$lastname = "";
$email = "";
$status = 0;
$username = "";
$password = "";

foreach($xml->DONNEES->ELEVES->ELEVE as $value) {

    $username = "";
    $firstname = $value->PRENOM;
    echo $firstname;
    echo"<br>";
    $lastname = $value->NOM_DE_FAMILLE;
    echo $lastname;
    echo"<br>";
    $email = $value->MEL;
    echo $email;
    echo"<br>";

     /*  substr — Retourne un segment de chaîne
        strtolower - Transforme une chaine en charactères minuscules
    */
    $username = substr($firstname, 0, 1). "." .$lastname;
    // SELECT * FROM users WHERE username LIKE "j.claude%"
    $dupes = $bdd->homonyms($username);
    var_dump($dupes);
    if($dupes >= 1) {
        $username = $username.$dupes;
    }
    $username = strtolower($username);
    echo $username;

    echo "<br>";
    echo $status;
    echo "<br>";

    $password = random_password(8);

    if(!$bdd->createUser($username, $password, $firstname, $lastname, $status, $email)) {
        echo "Echec à l'import de $username<br>";
    } else {
        echo "OK";
    }
}

?>
