<?php
session_start();
if (!isset($_SESSION["session"]) || $_SESSION["status"] != 0) header("Location: /form/");

include 'var/sql.php';

error_reporting(E_ALL & ~E_NOTICE);

if ($_POST["submit"]) {
    if ($_POST["ens1"] && $_POST["spec1"] && $_POST["q1"] && $_POST["ens2"] && $_POST["spec2"] && $_POST["q2"]) {
        die($_SESSION["firstname"] . ' ' . $_SESSION["lastname"]);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/form/style/style.css">
    <link rel="icon" type="image/png" href="/form/img/favicon.png" />
    <title>Formulaire - Grand Oral</title>
</head>

<body>
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
                                <input type="text" name="ens1" maxlength="100" class="form-control" required />
                                <div class="invalid-feedback">
                                    Nom de l'enseignant requis
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="spec1" class="text-info">Spécialité n°1 :</label>
                                <select name="spec1" class="form-control" required>
                                    <option disabled selected value>Selectionnez une spécialité</option>
                                    <option value="maths">Mathématiques</option>
                                    <option value="francais ">Français </option>
                                    <option value="espagnol">Espagnol</option>
                                    <option value="anglais">Anglais</option>
                                    <option value="hist-geo">Histoire-Géographie</option>
                                    <option value="physique">Physique-Chimie</option>
                                    <option value="svt">SVT</option>
                                </select>
                                <div class="invalid-feedback">
                                    Spécialité requise
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="q1" class="text-info">Question 1 :</label>
                                <textarea type="text" name="q1" maxlength="300" required class="form-control"></textarea>
                                <div class="invalid-feedback">
                                    Question requise
                                </div>
                            </div>

                            <hr />

                            <div class="form-group">
                                <label for="ens2" class="text-info">Nom de l'enseignant n°2 :</label>
                                <input type="text" name="ens2" maxlength="100" class="form-control" required />
                                <div class="invalid-feedback">
                                    Nom de l'enseignant requis
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="spec2" class="text-info">Spécialité n°2 :</label>
                                <select name="spec2" class="form-control" required>
                                    <option disabled selected value>Selectionnez une spécialité</option>
                                    <option value="maths">Mathématiques</option>
                                    <option value="francais ">Français </option>
                                    <option value="espagnol">Espagnol</option>
                                    <option value="anglais">Anglais</option>
                                    <option value="hist-geo">Histoire-Géographie</option>
                                    <option value="physique">Physique-Chimie</option>
                                    <option value="svt">SVT</option>
                                </select>
                                <div class="invalid-feedback">
                                    Spécialité requise
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="q2" class="text-info">Question 2 :</label>
                                <textarea type="text" name="q2" maxlength="300" required class="form-control"></textarea>
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

    <script type="text/javascript" src="js/formvalidation.js"></script>
</body>

</html>