<?php
session_start();
if (!isset($_SESSION["session"])) header("Location: /form/");

include 'var/sql.php';
include 'lib/GOBDD.php';

error_reporting(E_ALL & ~E_NOTICE);

$erreur = '';

if ($_POST["submit"]) {
    if ($_POST["actual-pass"] && $_POST["new-pass"] && $_POST["confirm-pass"]) {

        $actual = $_POST["actual-pass"];
        $new = $_POST["new-pass"];
        $confirm = $_POST["confirm-pass"];

        $bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password);
        if ($bdd->checkCredentials($_SESSION["username"], $actual)) {
            if ($new == $confirm) {
                $bdd->changePassword($_SESSION["username"], $new);
                echo "<script>window.onload = function() {alert('Le mot de passe a été changé avec succès','success');};</script>";
            } else {
                $erreur = 'Le nouveau mot de passe n\'est pas le meme que celui de confirmation, veuillez réessayer';
            }
        } else {
            $erreur = 'Mot de passe actuel incorrect';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<?php include "var/header.html" ?>
<title>Changement de mot de passe</title>

<body>
    <div id="alertPlaceholder" class="position-fixed bottom-0 end-0 p-3"></div>

    <?php include "var/navbar.html" ?>

    <div class="container">
        <img id="logo" src="img/logo.png" class="img-fluid mx-auto d-block">

        <form id="go-form" class="form needs-validation" action="" method="post" novalidate>

            <h3 class="text-center text-info">Changement de mot de passe</h3>

            <div class="form-group">
                <label for="username" class="text-info">Mot de passe actuel:</label><br>
                <input type="password" name="actual-pass" class="form-control" required>
                <div class="invalid-feedback">
                    Mot de passe actuel requis
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="text-info">Nouveau mot de passe:</label><br>
                <input type="password" name="new-pass" class="form-control" required>
                <div class="invalid-feedback">
                    Mot de passe requis
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="text-info">Confirmez le mot de passe:</label><br>
                <input type="password" name="confirm-pass" class="form-control" required>
                <div class="invalid-feedback">
                    Confirmez le mot de passe
                </div>
            </div>

            <div class="form-group">
                <p id="error"><?php echo $erreur; ?></p>
            </div>

            <div class="d-grid gap-2 col-4 mx-auto">
                <button class="btn btn-primary" type="submit" name="submit" value="submit">Valider</button>
            </div>
        </form>
    </div>

    <?php include "var/js.html" ?>
</body>

</html>
