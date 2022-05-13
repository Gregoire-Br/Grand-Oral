<?php
session_start();
if (!isset($_SESSION["session"]) || $_SESSION["status"] != 0) header("Location: /");

include 'var/sql.php';
include 'lib/GOBDD.php';
include 'lib/debug.php';

$Debug=false;

$bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password,$Debug);

error_reporting(E_ALL & ~E_NOTICE);

if ($_POST["submit"]) {
    debugPrintVariablePOST();   
    if ($_POST["ens1"] && $_POST["spec1"] && $_POST["q1"] && $_POST["ens2"] && $_POST["spec2"] && $_POST["q2"]) {
        echo "<script>window.onload = function() {alert('Le formulaire a bien été envoyé','success');};</script>";
        $bdd->updateForm($_SESSION["username"],  $_POST["ens1"], $_POST["ens2"], $_POST["q1"], $_POST["q2"], $_POST["spec1"], $_POST["spec1b"], $_POST["spec2"], $_POST["spec2b"]);
    }
}

$userinfo = $bdd->userQuery($_SESSION["username"]);
$studentinfo = $bdd->studentQuery($_SESSION["username"]);
$forminfo = $bdd->formQuery($_SESSION["username"]);
$specinfo = $bdd->specQuery();
$listProfsSpe = $bdd->listProfsQuery();

debugPrintVariable(listProfsSpe);

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
                <!-- ?php echo "<input type='text' name='ens1' maxlength='100' class='form-control' value='".$studentinfo[0]['ens1']."' required />"; ?> 
                <div class="invalid-feedback">
                    Nom de l'enseignant requis
                </div>
                -->
                <select name="ens1" class="form-control col" required>
                        <option disabled <?php if ($studentinfo[0]["ens1"] == "") echo "selected" ?> value>Selectionnez l'enseignant de spécialité 1</option>
                        <?php 
                        foreach ($listProfsSpe as $lst) {  
                            if ($studentinfo[0]["ens1"] == $lst["username"]) echo '<option selected value="'.$lst["username"].'">'.$lst["lastname"].'</option>';
                            else echo '<option value="'.$lst["username"].'">'.$lst["lastname"].'</option>';
                        }
                        ?>
                </select>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="spec1" class="text-info">Spécialité n°1 :</label>
                    </div>
                    <div class="col">
                        <label for="spec1b" class="text-info">Spécialité secondaire :</label>
                    </div>
                </div>
                <div class="row ps-2 pe-2">
                    <select name="spec1" class="form-control col" required>
                        <option disabled <?php if ($studentinfo[0]["spec1"] == "") echo "selected" ?> value>Selectionnez une spécialité</option>
                        <?php 
                        foreach ($specinfo as $spe) {  
                            if ($studentinfo[0]["spec1"] == $spe["spec"]) echo '<option selected value="'.$spe["spec"].'">'.$spe["spec"].'</option>';
                            else echo '<option value="'.$spe["spec"].'">'.$spe["spec"].'</option>';
                        }
                        ?>
                    </select>
                    <select name="spec1b" class="form-control col">
                    <option  <?php if ($forminfo[0]["spec1b"] == "") echo "selected" ?> value>Selectionnez une spécialité</option>
                        <?php 
                       foreach ($specinfo as $spe) {  
                            if ($forminfo[0]["spec1b"] == $spe["spec"]) echo '<option selected value='.$spe["spec"].'>'.$spe["spec"].'</option>';
                            else echo '<option value="'.$spe["spec"].'">'.$spe["spec"].'</option>';
                       }
                        ?>
                    </select>
                </div>

                <div class="invalid-feedback">
                    Spécialité requise
                </div>
            </div>


            <div class="form-group">
                <label for="q1" class="text-info">Question 1 :</label>
                <textarea type="text" name="q1" maxlength="300" required class="form-control"><?php echo $forminfo[0]["q1"] ?></textarea>
                <div class="invalid-feedback">
                    Question requise
                </div>
            </div>

            <hr />

            <div class="form-group">
                <label for="ens2" class="text-info">Nom de l'enseignant n°2 :</label>
                <select name="ens2" class="form-control col" required>
                        <option disabled <?php if ($studentinfo[0]["ens2"] == "") echo "selected" ?> value>Selectionnez l'enseignant de spécialité 2</option>
                        <?php 
                        foreach ($listProfsSpe as $lst) {  
                            if ($studentinfo[0]["ens2"] == $lst["username"]) echo '<option selected value="'.$lst["username"].'">'.$lst["lastname"].'</option>';
                            else echo '<option value="'.$lst["username"].'">'.$lst["lastname"].'</option>';
                        }
                        ?>
                    </select>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="spec2" class="text-info">Spécialité n°2 :</label>
                    </div>
                    <div class="col">
                        <label for="spec2b" class="text-info">Spécialité secondaire :</label>
                    </div>
                </div>
                <div class="row ps-2 pe-2">
                    <select name="spec2" class="form-control col" required>
                        <option disabled <?php if ($studentinfo[0]["spec2"] == "") echo "selected" ?> value>Selectionnez une spécialité</option>
                        <?php 
                       foreach ($specinfo as $spe) {  
                            if ($studentinfo[0]["spec2"] == $spe["spec"]) echo '<option selected value="'.$spe["spec"].'">'.$spe["spec"].'</option>';
                            else echo '<option value="'.$spe["spec"].'">'.$spe["spec"].'</option>';
                       }
                        ?>
                    </select>
                    <select name="spec2b" class="form-control col">
                    <option  <?php if ($forminfo[0]["spec2b"] == "") echo "selected" ?> value>Selectionnez une spécialité</option>
                        <?php 
                       foreach ($specinfo as $spe) {  
                            if ($forminfo[0]["spec2b"] == $spe["spec"]) echo '<option selected value="'.$spe["spec"].'">'.$spe["spec"].'</option>';
                            else echo '<option value="'.$spe["spec"].'">'.$spe["spec"].'</option>';
                       }
                        ?>
                    </select>
                </div>

                <div class="invalid-feedback">
                    Spécialité requise
                </div>
            </div>

            <div class="form-group">
                <label for="q2" class="text-info">Question 2 :</label>
                <textarea type="text" name="q2" maxlength="300" required class="form-control"><?php echo $forminfo[0]["q2"] ?></textarea>
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
