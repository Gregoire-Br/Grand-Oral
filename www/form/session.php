<?php
session_start();
if (!isset($_SESSION["session"])) header("Location: /form/");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="style/style.css">
    <title>Connexion</title>
</head>

<body>
    <p>Statut : <?php echo $_SESSION["status"] ?></p><br>
    <p>Username : <?php echo $_SESSION["username"] ?></p><br>
    <a href="form.php">Formulaire</a><br>
    <a href="disconnect.php">Se déconnecter</a>
</body>

</html>