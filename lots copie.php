<?php
session_start();
if (!isset($_SESSION["session"]) || $_SESSION["status"] < 2) header("Location: /");

error_reporting(E_ALL & ~E_NOTICE);

include 'var/sql.php';
include 'lib/GOBDD.php';
include 'lib/debug.php';

$Debug = true;


$erreur = '';

//Création d'une instance de la classe GOBDD
$bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password, $Debug);


//Récupération du post 
$lastname = $_POST["lastname"];
$firstname = $_POST["firstname"];
$user = $_POST["username"];
$email = $_POST["email"];
$status = $_POST["status"];

debugPrintVariablePOST();

//Récupération des valeurs rentrées dans la table si bouton = submit
if (isset($_POST["submit"])) {
  // modif d'un user : seuls les champs email et status sont modifiables
  if ($_POST["submit"]=="modif"){
    if ($bdd->updateUser($user, $email, $status)) 
      echo "<script>window.onload = function() {alert('L'utilisateur a bien été modifié !','success');};</script>";
    else 
      echo "<script>window.onload = function() {alert('Modification non effectuée !','failure');};</script>";

  } else if (isset($_POST["lastname"]) && isset($_POST["firstname"]) && isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["status"])) {
    echo "<script>window.onload = function() {alert('Le formulaire a bien été envoyé','success');};</script>";

    //Crée un mdp random ( a revoir avec greg)
    function random_password($length = 8)
    {
      $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&?";
      $password = substr(str_shuffle($chars), 0, $length);
      return $password;
    }

    $pswd = random_password(8);

    //Appel méthode createUser pour envoyer les données dans la BDD

    $creation = $bdd->createUser($user, $pswd, $firstname, $lastname, $status, $email);
  } else {
      echo "Il y a une erreur dans le code";
    }
} else if (isset($_POST["btn-supp"])) {
  if ($bdd->deleteUser($_POST["btn-supp"])){
    echo "<script>window.onload = function() {alert('L'utilisateur a bien été supprimé !','success');};</script>";
  } else if (isset($_POST["Classe"])){
      echo "Post Classe<br>";
  
    } else echo "<script>window.onload = function() {alert('Problème lors de la suppression !','failure');};</script>";
} 

$Classes = $bdd->classesQuery();  //Pour peupler le champ select du formulaire

?>

<!DOCTYPE html>
<html lang="fr">

<?php include "var/header.html" ?>
<title>Profils</title>


<body>
  <div id="alertPlaceholder" class="position-fixed bottom-0 end-0 p-3"></div>

  <?php include "var/navbar.html" ?>


  <div class="container-fluid pb-5">
    <div class="table-responsive-lg">
      <p class="text-center"><b>TRAITEMENT EN LOTS</b></p>
    </div>
    <form action="" method="post" class="needs-validation" novalidate>
      <div class="statsUserData d-flex p-3">
      <?php // debugPrintVariable(Classes); ?>
        <select name="classes" class="form-control col" required>
            <option disabled selected value="">Selectionnez la classe</option>
            <?php 
            foreach ($Classes as $clss) {  
                echo '<option name="Classe" value="'.$clss["Classe"].'">'.$clss["Classe"].'</option>';
            }?>
        </select>
      </div>
      <button class="btn btn-danger float-end" type="submit" name="delete"value="submit">Supprimer</button>
      <button class="btn btn-primary float-end" type="submit" name="passwd" value="submit">Generate passwords</button>
    </form>
    <form action="" method="post" id="usersGO">
      <div class="table-responsive-lg scroll pt-5" style="max-height : 600px">
          <table id="myTable" class="table table-light table-striped">
            <tr>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Nom Utilisateur</th>
              <th>Classe</th>
              <th>Password</th>
            </tr>

            <?php
              //$res = $bdd->studentsByClasse($);
              foreach ($res as $r) {
              ?>
                <!-- On affiche depuis la BDD : Nom, Prénom, Nom utilisateur, email, status-->
                <tr>
                  <td><?php echo $r['lastname'] ?></td>
                  <td><?php echo $r['firstname'] ?></td>
                  <td><?php echo $r['username'] ?></td>
                  <td><?php echo $r['email'] ?></td>
                  <td><?php echo $r['status'] ?></td>
                  <td>
                    <?php echo "<input type='radio' name='btn-supp' value=".$r["username"].">"; ?> 
                  </td>
                </tr>
              <?php
              }
              ?>
          </table> 
      </div>
    </form>
  </div>

  <?php include "var/js.html" ?>
</body>

</html>
