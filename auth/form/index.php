<?php
/*session_start();
if (!isset($_SESSION["session"])) header("Location: /form/"); */
include_once 'includes/functions.php';
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
    <title>Formulaire - Grand Oral</title>
</head>

<body>
    <div id="go">
        <div class="container-fluid">
            <div id="go-row" class="row justify-content-center align-items-center">
                <div id="go-column" class="col-md-6">
                    <div id="go-box" class="col-md-24">
                        <img id="logo" src="img/logo.png" class="mx-auto d-block">
                        <form id="go-form" class="form" action="includes/form.php" method="post">

                            <h3 class="text-center text-info">Formulaire Grand Oral</h3>

                            <div class='form-group'>
                                <label for="lastname" class="text-info">Nom :</label>
                                <input type='text' name="lastname" id="lastname" maxlength="100" placeholder='Entrez votre nom' class='form-control'/>
                            </div>

                            <div class='form-group'>
                                <label for="firstname" class="text-info">Prénom :</label>
                                <input type='text' name="firstname" id="firstname" maxlength="100" placeholder='Entrez votre prénom' class='form-control'/>
                            </div>

                            <hr />

                            <div class='form-group'>
                                <label for="ens1" class="text-info">Nom de l'enseignant n°1 :</label>
                                <input type='text' name="ens1" id="ens1" maxlength="100" class='form-control'/>
                            </div>

                            <div class='form-group'>
                                <label for="spec1" class="text-info">Spécialité n°1 :</label>
                                <select name="spec1" id="spec1" class='form-control'>
                                    <option disabled selected value>Selectionnez une spécialité</option>
                                    <option value="maths">mathématique</option>
                                    <option value="francais">français </option>
                                    <option value="espagnol">espagnol</option>
                                    <option value="anglais">anglais</option>
                                    <option value="histoire">histoire</option>
                                    <option value="geo">géographie</option>
                                    <option value="chimie">Chimie</option>
                                    <option value="Latin">Latin</option>
                                </select>
                            </div>

                            <div class='form-group'>
                                <label for="q1" class="text-info">Question 1 :</label>
                                <textarea type='text' id="q1" name="q1" maxlength="300" class="form-control"></textarea>
                            </div>

                            <hr />

                            <div class='form-group'>
                                <label for="ens2" class="text-info">Nom de l'enseignant n°2 :</label>
                                <input type='text' name="ens2" id="ens2" maxlength="100" class='form-control'/>
                            </div>

                            <div class='form-group'>
                                <label for="spec2" class="text-info">Spécialité n°2 :</label>
                                <select name="spec2" id="spec2" class='form-control'>
                                    <option disabled selected value>Selectionnez une spécialité</option>
                                    <option value="maths">mathématique</option>
                                    <option value="francais ">français </option>
                                    <option value="espagnol">espagnol</option>
                                    <option value="anglais">anglais</option>
                                    <option value="histoire">histoire</option>
                                    <option value="geo">géographie</option>
                                    <option value="chimie">Chimie</option>
                                    <option value="Latin">Latin</option>
                                </select>
                            </div>

                            <div class='form-group'>
                                <label for="q2" class="text-info">Question 2 :</label>
                                <textarea type='text' id="q2" name="q2" maxlength="300" class='form-control'></textarea>
                            </div>

                            <div class='form-input-button'>
                                <button type='submit' id='submit' class="btn btn-primary btn-md btn-block">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>