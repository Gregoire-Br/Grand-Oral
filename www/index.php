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
        if ($bdd->checkCredentials($username, $password)) {
            $res = $bdd->userQuery($username);
            session_start();
            $_SESSION["session"] = true;
            $_SESSION["username"] = $res["username"];
            $_SESSION["firstname"] = $res["firstname"];
            $_SESSION["lastname"] = $res["lastname"];
            $_SESSION["status"] = $res["status"];

            header('Location: session.php');
        } else {
            $erreur = 'Identifiant ou mot de passe incorrect';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<?php include "var/header.html" ?>
<title>Connexion</title>

<body>
    <div class="container">
        <img id="logo" src="img/logo.png" class="img-fluid mx-auto d-block">

        <form id="go-form" class="form needs-validation" action="" method="post" novalidate>

            <h3 class="text-center text-info user-select-none">Connexion</h3>

            <div class="form-group">
                <label for="username" class="text-info user-select-none">Identifiant:</label><br>
                <input type="text" name="username" class="form-control" required>
                <div class="invalid-feedback">
                    Identifiant requis
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="text-info user-select-none">Mot de passe:</label><br>
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

    <?php include "var/js.html" ?>
</body>

</html>