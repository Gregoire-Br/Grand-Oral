<?php
session_start();
if (!isset($_SESSION["session"]) || $_SESSION["status"] != 0) header("Location: /form/");

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

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" type="image/png" href="/form/img/favicon.png" />

    <script src="js/bootstrap.js"></script>
    <script src="js/formvalidation.js"></script>
    <script src="js/alertHandler.js"></script>

    <title>Formulaire - Grand Oral</title>
</head>

<body>
    <div id="alertPlaceholder" class="position-fixed bottom-0 end-0 p-3"></div>
    <div id="go">
        <div class="container-fluid">
            <div id="go-row" class="row justify-content-center align-items-center">
                <div id="go-column" class="col-md-6">
                    <div id="go-box" class="col-md-24">
                        <img id="logo" src="img/logo.png" class="img-fluid mx-auto d-block">

                        <form id="go-form" class="form needs-validation" action="" method="post" novalidate>

                            <h3 class="text-center text-info">Formulaire</h3>

                            <div class="form-group">
                                <label for="ens1" class="text-info">Nom de l'enseignant n°1 :</label>
                                <input type="text" name="ens1" maxlength="100" class="form-control" value="<?php echo $studentinfo["ens1"]?>" required />
                                <div class="invalid-feedback">
                                    Nom de l'enseignant requis
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="spec1" class="text-info">Spécialité n°1 :</label>
                                <select name="spec1" class="form-control" required>
                                    <option disabled <?php if($studentinfo["spec1"] == "") echo "selected"?>  value>Selectionnez une spécialité</option>
                                    <option <?php if($studentinfo["spec1"] == "math") echo "selected"?> value="math">Mathématiques</option>
                                    <option <?php if($studentinfo["spec1"] == "francais") echo "selected"?> value="francais">Français </option>
                                    <option <?php if($studentinfo["spec1"] == "espagnol") echo "selected"?> value="espagnol">Espagnol</option>
                                    <option <?php if($studentinfo["spec1"] == "anglais") echo "selected"?> value="anglais">Anglais</option>
                                    <option <?php if($studentinfo["spec1"] == "histoiregeo") echo "selected"?> value="histoiregeo">Histoire-Géographie</option>
                                    <option <?php if($studentinfo["spec1"] == "physique") echo "selected"?> value="physique">Physique-Chimie</option>
                                    <option <?php if($studentinfo["spec1"] == "svt") echo "selected"?> value="svt">SVT</option>
                                </select>
                                <div class="invalid-feedback">
                                    Spécialité requise
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="q1" class="text-info">Question 1 :</label>
                                <textarea type="text" name="q1" maxlength="300" required class="form-control"><?php echo $forminfo["q1"]?></textarea>
                                <div class="invalid-feedback">
                                    Question requise
                                </div>
                            </div>

                            <hr />

                            <div class="form-group">
                                <label for="ens2" class="text-info">Nom de l'enseignant n°2 :</label>
                                <input type="text" name="ens2" maxlength="100" class="form-control" value="<?php echo $studentinfo["ens2"]?>" required />
                                <div class="invalid-feedback">
                                    Nom de l'enseignant requis
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="spec2" class="text-info">Spécialité n°2 :</label>
                                <select name="spec2" class="form-control" required>
                                <option disabled <?php if($studentinfo["spec2"] == "") echo "selected"?>  value>Selectionnez une spécialité</option>
                                    <option <?php if($studentinfo["spec2"] == "math") echo "selected"?> value="math">Mathématiques</option>
                                    <option <?php if($studentinfo["spec2"] == "francais") echo "selected"?> value="francais">Français </option>
                                    <option <?php if($studentinfo["spec2"] == "espagnol") echo "selected"?> value="espagnol">Espagnol</option>
                                    <option <?php if($studentinfo["spec2"] == "anglais") echo "selected"?> value="anglais">Anglais</option>
                                    <option <?php if($studentinfo["spec2"] == "histoiregeo") echo "selected"?> value="histoiregeo">Histoire-Géographie</option>
                                    <option <?php if($studentinfo["spec2"] == "physique") echo "selected"?> value="physique">Physique-Chimie</option>
                                    <option <?php if($studentinfo["spec2"] == "svt") echo "selected"?> value="svt">SVT</option>
                                </select>
                                <div class="invalid-feedback">
                                    Spécialité requise
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="q2" class="text-info">Question 2 :</label>
                                <textarea type="text" name="q2" maxlength="300" required class="form-control"><?php echo $forminfo["q2"]?></textarea>
                                <div class="invalid-feedback">
                                    Question requise
                                </div>
                            </div>

                            <div class="d-grid gap-2 col-8 mx-auto">
                                <button name="submit" value="submit" class="btn btn-primary">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
