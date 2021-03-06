<?php
session_start();
if (!isset($_SESSION["session"]) || $_SESSION["status"] != 2) header("Location: /");

error_reporting(E_ALL & ~E_NOTICE);

include 'var/sql.php';
include 'lib/GOBDD.php';
include 'lib/debug.php';

$Debug = false;


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
  }
  else echo "<script>window.onload = function() {alert('Problème lors de la suppression !','failure');};</script>";
} 
?>

<!DOCTYPE html>
<html lang="fr">

<?php include "var/header.html" ?>
<title>Profils</title>


<body>
  <div id="alertPlaceholder" class="position-fixed bottom-0 end-0 p-3"></div>

  <?php include "var/navbar.html" ?>

  <div id="data" class="container-fluid">
      <form action="" method="post" class="needs-validation" novalidate>

        <div class="form-group mb-3 d-flex ">
          <span class="input-group-text">Nom</span>
          <input type="text" class="form-control" id="last" name="lastname" required>

          <span class="input-group-text ">Prénom</span>
          <input type="text" class="form-control" id="first" name="firstname" required>
        </div>

        <div class="rightUserData mb-3 d-flex">
          <span class="input-group-text">Nom utilisateur</span>
          <input type="text" class="form-control" id="username" name="username" required>

          <span class="input-group-text">E-mail</span>
          <input type="text" class="form-control" id="email" name="email" required>
        </div>

        <div class="statsUserData d-flex ">
          <select class="form-control" id="status" name="status" required>
            <option disabled selected value>Tous les utilisateurs</option>
            <option value="0">Élève</option>
            <option value="1">Enseignant</option>
            <option value="3">Secrétaire</option>
            <option value="2">Proviseur</option>
          </select>

          <button class="btn btn-primary" type="submit" name="submit" value="submit">Ajouter</button>
          <button class="btn btn-warning" type="submit" name="submit" value="modif">Modifier</button>
        </div>
      </form>
      <p id="error"><?php echo $erreur ?></p>
  </div>

  <div class="container-fluid pb-5">
    <div class="table-responsive-lg">
      <p class="text-center"><b>UTILISATEURS DE L'APPLICATION GRAND ORAL</b></p>
    </div>
    <form action="" method="post" id="usersGO">
      <div class="table-responsive-lg scroll" style="max-height : 600px">
          <table id="myTable" class="table table-light table-striped">
            <tr>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Nom Utilisateur</th>
              <th>e-mail</th>
              <th>Status</th>
            </tr>

            <?php
              $res = $bdd->allUsers();
              //print_r($res);
              // On utilise la variable $r
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
      <button type="submit" class="btn btn-danger float-end" value="submit">Supprimer</button>
    </form>
  </div>

  <?php include "var/js.html" ?>
</body>

</html>
