<?php
session_start();
if (!isset($_SESSION["session"]) || $_SESSION["status"] != 2) header("Location: /www/");

error_reporting(E_ALL & ~E_NOTICE);

include 'var/sql.php';
include 'lib/GOBDD.php';


$erreur = '';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "var/header.html" ?>
<title>Import XML/CSV</title>

<body>
	<?php include "var/navbar.html" ?>
    <div class="container d-flex flex-column">
        <form method="post" enctype="multipart/form-data">
        <label for="formFileMultiple" class="form-label">IMPORT Élèves (Base Siècle) - Format XML UNIQUEMENT (1 Go MAX):</label>

            <div class="mb-3 d-flex">
                <input class="form-control" type="file" id="fileToUpload" name="userfile" multiple>
                <button type="submit" class="btn btn-primary" name="submit">UPLOAD</button>

            </div>

        <label for="formFileMultiple" class="form-label">IMPORT Enseignants - Format CSV UNIQUEMENT :</label>
    
            <div class="mb-3 d-flex">
                <input class="form-control" type="file" id="formFileMultiple" multiple>
                <button type="submit" class="btn btn-primary" name="csvsubmit">UPLOAD</button>
            </div>
            
        </form>
    </div>

<?php

if(isset($_POST['submit']))
{
    $file = $_FILES['userfile'];
    $fileName = $_FILES['userfile']['name'];
    $fileError = $_FILES['userfile']['error'];
    $fileSize = $_FILES['userfile']['size'];

    print_r($file);
    
    $fileExt= explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('xml');
    $feed = file_get_contents($fileName);

    if(in_array($fileActualExt, $allowed)){
         //if($fileError === 0){
           // if($fileSize < 1000000){
               
            //file_get_content associé à Load_sring . Ne pas utiliser load_file car interprète un objet "Cannot create object"
                $xml = simplexml_load_string($feed) or die("Error: Cannot create object");

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

                    if(!$bdd->createUser($username, $password, $firstname, $lastname, $status, $email)) {
                        echo "Echec à l'import de $username<br>";
                    } else {
                        echo "Import des utilisateurs OK <br>";
                    }
                }

            /* } else {
                echo "File too big";
            } */

        /* } else {
            echo " You got an error ";
        } */

    } else {
        echo "Wrong file type";
    }

}

?>


        <?php include "var/js.html" ?>
	</body>
</html>
