<?php
session_start();
if (!isset($_SESSION["session"])) header("Location: /form/");

include 'var/sql.php';
include 'lib/GOBDD.php';

$bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password);

error_reporting(E_ALL & ~E_NOTICE);

$userinfo = $bdd->userQuery($_SESSION["username"]);
$studentinfo = $bdd->studentQuery($_SESSION["username"]);
$forminfo = $bdd->formQuery($_SESSION["username"]);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" type="image/png" href="/img/favicon.png" />

    <title>Formulaire - Grand Oral</title>
</head>

<body>
    <div id="alertPlaceholder" class="position-fixed bottom-0 end-0 p-3"></div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom fixed-top ps-2 pe-2">
        <a class="navbar-brand">
            <img src="img/icon.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
            Bonjour <?php echo $userinfo["firstname"]; ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="navbar-nav">
                <?php if ($_SESSION["status"] == 0) echo
                '<li class="nav-item active">
                    <a class="nav-link" href="form.php">Formulaire</a>
                </li>'
                ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li>
                    <a class="nav-link" href="password.php">Changer de mot de passe</a>
                </li>
                <li>
                    <a class="btn btn-danger" href="disconnect.php">Se déconnecter</a>
                </li>
            </ul>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="js/formvalidation.js"></script>
    <script src="js/alertHandler.js"></script>
</body>

</html>