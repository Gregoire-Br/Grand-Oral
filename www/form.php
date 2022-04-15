<?php
session_start();
if (!isset($_SESSION["session"]) || $_SESSION["status"] != 0) header("Location: /www/");

include 'var/sql.php';
include 'lib/GOBDD.php';

$bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password);

error_reporting(E_ALL & ~E_NOTICE);

if ($_POST["submit"]) {
    if ($_POST["ens1"] && $_POST["spec1"] && $_POST["q1"] && $_POST["ens2"] && $_POST["spec2"] && $_POST["q2"]) {
        echo "<script>window.onload = function() {alert('Le formulaire a bien été envoyé','success');};</script>";
        $bdd->updateForm($_SESSION["username"], $_POST["q1"], $_POST["q2"]);
        $bdd->updateStudent($_SESSION["username"], $_POST["spec1"], $_POST["spec2"]);
    }
}


$studentinfo = $bdd->studentQuery($_SESSION["username"]);
$forminfo = $bdd->formQuery($_SESSION["username"]);

?>

<!DOCTYPE html>
<html lang="fr">

<?php include "var/header.html" ?>
<title>Formulaire</title>

<body>
    <div id="alertPlaceholder" class="position-fixed bottom-0 end-0 p-3"></div>

    <?php include "var/navbar.html" ?>

    <div class="container-fluid">
        <img id="logo" src="img/logo.png" class="img-fluid mx-auto d-block">

        <form id="go-form" class="form needs-validation" action="" method="post" novalidate>

            <h3 class="text-center text-info">Formulaire</h3>

            <div class="form-group">
                <label for="ens1" class="text-info">Nom de l'enseignant n°1 :</label>
                <input type="text" name="ens1" maxlength="100" class="form-control" value="<?php echo $studentinfo["ens1"] ?>" required />
                <div class="invalid-feedback">
                    Nom de l'enseignant requis
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="spec1" class="text-info">Spécialité n°1 :</label>
                    </div>
                  <div class="col">
                        <label for="spec1" class="text-info">Spécialité secondaire :</label>
                    </div>
                </div>
                <div class="row ps-2 pe-2">
                    <select name="spec1a" class="form-control col" required>
                        <option disabled <?php if ($studentinfo["spec1"] == "") echo "selected" ?> value>Selectionnez une spécialité</option>
                        <option <?php if ($studentinfo["spec1"] == "math") echo "selected" ?> value="math">Mathématiques</option>
                        <option <?php if ($studentinfo["spec1"] == "francais") echo "selected" ?> value="francais">Français </option>
                        <option <?php if ($studentinfo["spec1"] == "espagnol") echo "selected" ?> value="espagnol">Espagnol</option>
                        <option <?php if ($studentinfo["spec1"] == "anglais") echo "selected" ?> value="anglais">Anglais</option>
                        <option <?php if ($studentinfo["spec1"] == "histoiregeo") echo "selected" ?> value="histoiregeo">Histoire-Géographie</option>
                        <option <?php if ($studentinfo["spec1"] == "physique") echo "selected" ?> value="physique">Physique-Chimie</option>
                        <option <?php if ($studentinfo["spec1"] == "svt") echo "selected" ?> value="svt">SVT</option>
                    </select>
                    <!--    <select name="spec1b" class="form-control col">
                        <option <?php //if ($studentinfo["spec1b"] == "") echo "selected" ?> value="">Aucun(e)</option>
                        <option <?php //if ($studentinfo["spec1b"] == "math") echo "selected" ?> value="math">Mathématiques</option>
                        <option <?php //if ($studentinfo["spec1b"] == "francais") echo "selected" ?> value="francais">Français </option>
                        <option <?php //if ($studentinfo["spec1b"] == "espagnol") echo "selected" ?> value="espagnol">Espagnol</option>
                        <option <?php //if ($studentinfo["spec1b"] == "anglais") echo "selected" ?> value="anglais">Anglais</option>
                        <option <?php //if ($studentinfo["spec1b"] == "histoiregeo") echo "selected" ?> value="histoiregeo">Histoire-Géographie</option>
                        <option <?php //if ($studentinfo["spec1b"] == "physique") echo "selected" ?> value="physique">Physique-Chimie</option>
                        <option <?php //if ($studentinfo["spec1b"] == "svt") echo "selected" ?> value="svt">SVT</option>
                    </select> -->
                </div>

                <div class="invalid-feedback">
                    Spécialité requise
                </div>
            </div>


            <div class="form-group">
                <label for="q1" class="text-info">Question 1 :</label>
                <textarea type="text" name="q1" maxlength="300" required class="form-control"><?php echo $forminfo["q1"] ?></textarea>
                <div class="invalid-feedback">
                    Question requise
                </div>
            </div>

            <hr />

            <div class="form-group">
                <label for="ens2" class="text-info">Nom de l'enseignant n°2 :</label>
                <input type="text" name="ens2" maxlength="100" class="form-control" value="<?php echo $studentinfo["ens2"] ?>" required />
                <div class="invalid-feedback">
                    Nom de l'enseignant requis
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="spec2" class="text-info">Spécialité n°2 :</label>
                    </div>
                    <div class="col">
                        <label for="spec2" class="text-info">Spécialité secondaire :</label>
                    </div>
                </div>
                <div class="row ps-2 pe-2">
                    <select name="spec2a" class="form-control col" required>
                        <option disabled <?php if ($studentinfo["spec2"] == "") echo "selected" ?> value>Selectionnez une spécialité</option>
                        <option <?php if ($studentinfo["spec2"] == "math") echo "selected" ?> value="math">Mathématiques</option>
                        <option <?php if ($studentinfo["spec2"] == "francais") echo "selected" ?> value="francais">Français </option>
                        <option <?php if ($studentinfo["spec2"] == "espagnol") echo "selected" ?> value="espagnol">Espagnol</option>
                        <option <?php if ($studentinfo["spec2"] == "anglais") echo "selected" ?> value="anglais">Anglais</option>
                        <option <?php if ($studentinfo["spec2"] == "histoiregeo") echo "selected" ?> value="histoiregeo">Histoire-Géographie</option>
                        <option <?php if ($studentinfo["spec2"] == "physique") echo "selected" ?> value="physique">Physique-Chimie</option>
                        <option <?php if ($studentinfo["spec2"] == "svt") echo "selected" ?> value="svt">SVT</option>
                    </select>
                   <!-- <select name="spec2b" class="form-control col">
                        <option <?php //if ($studentinfo["spec2b"] == "") echo "selected" ?> value="">Aucun(e)</option>
                        <option <?php //if ($studentinfo["spec2b"] == "math") echo "selected" ?> value="math">Mathématiques</option>
                        <option <?php //if ($studentinfo["spec2b"] == "francais") echo "selected" ?> value="francais">Français </option>
                        <option <?php //if ($studentinfo["spec2b"] == "espagnol") echo "selected" ?> value="espagnol">Espagnol</option>
                        <option <?php //if ($studentinfo["spec2b"] == "anglais") echo "selected" ?> value="anglais">Anglais</option>
                        <option <?php //if ($studentinfo["spec2b"] == "histoiregeo") echo "selected" ?> value="histoiregeo">Histoire-Géographie</option>
                        <option <?php //if ($studentinfo["spec2b"] == "physique") echo "selected" ?> value="physique">Physique-Chimie</option>
                        <option <?php //if ($studentinfo["spec2b"] == "svt") echo "selected" ?> value="svt">SVT</option>
                    </select> -->
                </div>

                <div class="invalid-feedback">
                    Spécialité requise
                </div>
            </div>

            <div class="form-group">
                <label for="q2" class="text-info">Question 2 :</label>
                <textarea type="text" name="q2" maxlength="300" required class="form-control"><?php echo $forminfo["q2"] ?></textarea>
                <div class="invalid-feedback">
                    Question requise
                </div>
            </div>

            <div class="d-grid gap-2 col-8 mx-auto">
                <button name="submit" value="submit" class="btn btn-primary" id="sendbtn">Envoyer</button>
            </div>
        </form>
    </div>

    <?php include "var/js.html" ?>
</body>

</html>
