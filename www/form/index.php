<?php
session_start();
if (isset($_SESSION["session"])) {
    header('Location: session.php');
}

include 'var/sql.php';

header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL & ~E_NOTICE);

$erreur = '';

if ($_POST["submit"]) {
    $username = strip_tags($_POST["username"]);
    $password = strip_tags($_POST["password"]);

    try {
        $bdd = new PDO('mysql:host=' . $sql_ip . ';dbname=' . $sql_db . ';charset=utf8', $sql_login, $sql_password);
        $requete = $bdd->prepare("SELECT * FROM users WHERE username = \"$username\" AND password = PASSWORD(\"$password\")");
        $requete->execute();
        $reponse = $requete->fetch(PDO::FETCH_ASSOC);

        if ($reponse) {
            session_start();
            $_SESSION["session"] = true;
            $_SESSION["username"] = $reponse["username"];
            $_SESSION["password"] = $reponse["password"];
            $_SESSION["firstname"] = $reponse["firstname"];
            $_SESSION["lastname"] = $reponse["lastname"];
            $_SESSION["status"] = $reponse["status"];
            $_SESSION["email"] = $reponse["email"];
            header('Location: session.php');
        } else {
            $erreur = 'Identifiant ou mot de passe incorrect';
        }
    } catch (Exception $e) {
        $erreur = "Connexion impossible : " . mb_convert_encoding($e->getMessage(), 'utf8', 'Windows-1252');
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="/form/style/style.css">
    <link rel="icon" type="image/png" href="/form/img/favicon.png" />
    <title>Connexion</title>
</head>

<body>
    <div id="go">
        <div class="container">
            <div id="go-row" class="row justify-content-center align-items-center">
                <div id="go-column" class="col-md-6">
                    <div id="go-box" class="col-md-24">
                        <img id="logo" src="img/logo.png" class="mx-auto d-block">
                        <form id="go-form" class="form" action="" method="post">

                            <h3 class="text-center text-info">Connexion</h3>

                            <div class="form-group">
                                <label for="username" class="text-info">Identifiant:</label><br>
                                <input type="text" name="username" id="username" required class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="password" class="text-info">Mot de passe:</label><br>
                                <input type="password" name="password" id="password" required class="form-control">
                            </div>

                            <div class="form-group">
                                <p id="error"><?php echo $erreur; ?></p>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-primary btn-md btn-block" value="Se connecter">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>