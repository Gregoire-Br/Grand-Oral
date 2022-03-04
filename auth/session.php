<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="style.css">
    <title>Connexion</title>
</head>

<body>
    <?php 
        session_start(); 
        if($_SESSION["status"] != true) header('Location: /auth/');
    ?>

    <p>Nom d'utilisateur : <?php echo $_SESSION["username"] ?></p><br>
    <p>Mot de passe : <?php echo $_SESSION["password"] ?></p>
</body>

</html>