<?php
session_start();
if (isset($_SESSION["session"])) {
    header('Location: session.php');
}

include 'var/sql.php';
include 'lib/GOBDD.php';

error_reporting(E_ALL & ~E_NOTICE);

$erreur = '';

if ($_POST["submit"]) {
    if ($_POST["username"] && $_POST["password"]) {
        
        $username = $_POST["username"];
        $password = $_POST["password"];

        $bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password);
        if($bdd->checkCredentials($username, $password)) {
            $res = $bdd->userQuery($username);
            session_start();
            $_SESSION["session"] = true;
            $_SESSION["username"] = $res["username"];
            $_SESSION["status"] = $res["status"];
            header('Location: session.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
                        <img id="logo" src="img/logo.png" class="img-fluid mx-auto d-block">

                        <form id="go-form" class="form needs-validation" action="" method="post" novalidate>

                            <h3 class="text-center text-info">Connexion</h3>

                            <div class="form-group">
                                <label for="username" class="text-info">Identifiant:</label><br>
                                <input type="text" name="username" class="form-control" required>
                                <div class="invalid-feedback">
                                    Identifiant requis
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="text-info">Mot de passe:</label><br>
                                <input type="password" name="password" class="form-control" required>
                                <div class="invalid-feedback">
                                    Mot de passe requis
                                </div>
                            </div>

                            <div class="form-group">
                                <p id="error"><?php echo $erreur; ?></p>
                            </div>

                            <div class="d-grid gap-2 col-4 mx-auto">
                                <button class="btn btn-primary" type="submit" name="submit" value="submit">Se connecter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/formvalidation.js"></script>
</body>

</html>