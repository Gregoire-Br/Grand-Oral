<h2>Insert XML Data to MySql Table Output</h2>

<?php

/*Création de comptes utilisateurs "ELEVE" dans la BDD à l'aide un import XML*/

include "sql.php";
include "GOBDD.php";

$bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password);

function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

//Ouverture du fichier x.XML
$xml = simplexml_load_file("ElevesLTLV.xml") or die("Error: Cannot create object");

    $firstname = "";
    $lastname = "";
    $email = "";
    $status = 0;
    $username = "";
    $password = "";

    foreach($xml->DONNEES->ELEVES->ELEVE as $value) {

        $firstname = $value->PRENOM;
        $lastname = $value->NOM_DE_FAMILLE;
        $email = $value->MEL;

        $password = random_password(8);

        echo"<br>";
        echo $firstname. "\t" .$lastname. "\t" .$email;
        echo"<br>";

        echo $status;
        echo"<br>";

        /*     substr — Retourne un segment de chaîne
                strtolower - Transforme une chaine de charactères en charactères minuscules
                homonys - Méthode GOBDD qui incrémente la fin du string $username +1 si déjà existant
        */

        $username = substr($firstname, 0, 1).$lastname;

        // SELECT * FROM users WHERE username LIKE "1(firstname).lastname%"
        $dupes = $bdd->homonyms($username);
        var_dump($dupes);
        if($dupes >= 1) {
            $username = $username.$dupes;
        }
        $username = strtolower($username);

        echo $username;
        echo"<br>";

        if(!$bdd->createUser($username, $password, $firstname, $lastname, $status, $email)) {
            echo "Echec à l'import de $username<br>";
        } else {
            echo "Import des utilisateurs OK <br>";
        }
    }
?>
