<!DOCTYPE html>
<html lang="fr">

<?php

include 'var/sql.php';
include 'var/encrypt_info.php';

header('Content-Type: text/html; charset=utf-8');
//error_reporting(E_ALL & ~E_NOTICE);

$erreur = '';

if ($_POST["submit"]) {
    $ine = $deciphertext = openssl_decrypt(strip_tags($_POST["ine"]), $cipher, $key, $options=0, $iv);

    try {
        $bdd = new PDO('mysql:host=' . $sql_ip . ';dbname=' . $sql_db . ';charset=utf8', $sql_login, $sql_password);
        $requete = $bdd->prepare("SELECT * FROM students WHERE ine = \"$ine\"");
        $requete->execute();
        $reponse = $requete->fetch(PDO::FETCH_ASSOC);

        if (!$reponse) {
            die('INE non reconnu');
        }
    } catch (Exception $e) {
        die("Connexion impossible : " . mb_convert_encoding($e->getMessage(), 'utf8', 'Windows-1252'));
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="/style/style.css">
    <link rel="icon" type="image/png" href="/img/favicon.png" />
    <title>Scan</title>
</head>

<body>
    <p>INE : <?php echo $reponse['ine'] ?></p><br>
    <br>
    <p>Spécialité 1 : <?php echo $reponse['spec1'] ?></p><br>
    <p>Professeur attitré : <?php echo $reponse['ens1'] ?></p><br>
    <p>Question : <?php echo $reponse['q1'] ?></p><br>
    <br>
    <p>Spécialité 2 : <?php echo $reponse['spec2'] ?></p><br>
    <p>Professeur attitré : <?php echo $reponse['ens2'] ?></p><br>
    <p>Question : <?php echo $reponse['q2'] ?></p><br>
</body>

</html>