<?php
session_start();
if (!isset($_SESSION["session"]) || $_SESSION["status"] != 2) header("Location: /www/");

error_reporting(E_ALL & ~E_NOTICE);

include 'var/sql.php';
include 'lib/GOBDD.php';

$erreur = '';
?>

<?php
        //Création d'une instance de la classe GOBDD
        $bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password);

        //Appel méthode allUsers de la classe GOBDD
        $res = $bdd->allUsers();
        
        //Récupération des valeurs rentrées dans la table si bouton = submit
        if(isset($_POST["submit"])){
          if (isset($_POST["lastname"]) && isset($_POST["firstname"]) && isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["status"])) {
            echo "<script>window.onload = function() {alert('Le formulaire a bien été envoyé','success');};</script>";

            //Crée un mdp random ( a revoir avec greg)
            function random_password( $length = 8 ) {
              $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&?";
              $password = substr( str_shuffle( $chars ), 0, $length );
              return $password;
            }
            
            $lastname = $_POST["lastname"];
            $firstname = $_POST["firstname"];
            $user = $_POST["username"];
            $email = $_POST["email"];
            $status = $_POST["status"];
            $pswd = random_password(8);
            
            //Appel méthode createUser pour envoyer les données dans la BDD
            $creation = $bdd->createUser($user,$pswd,$firstname,$lastname,$status,$email);

          }  else {
            echo "Il y a une erreur dans le code";
          }
      }
?>

<!DOCTYPE html>
<html lang="en">

<?php include "var/header.html" ?>
<title>Profiles</title>

<body>
  <div id="alertPlaceholder" class="position-fixed bottom-0 end-0 p-3"></div>

  <?php include "var/navbar.html" ?>

  <div class="container-fluid">

    <div id="data">

    

      <form action="" method="post" class="needs-validation" novalidate>

        <div class="form-group mb-3 d-flex ">
          <span class="input-group-text">Nom</span>
          <input type="text" class="form-control" id="last" name="lastname" required>

          <span class="input-group-text ">Prénom</span>
          <input type="text" class="form-control" id="first" name="firstname" required>
        </div>

        <div class="rightUserData d-flex">
          <span class="input-group-text">Nom utilisateur</span>
          <input type="text" class="form-control" id="username" name="username" required>

          <span class="input-group-text">E-mail</span>
          <input type="text" class="form-control" id="email" name="email" required>
        </div>

        <div class="statsUserData d-flex">
          <select class="form-control" id="status" name="status" required>
            <option disabled selected value>Tout les utilisateurs</option>
            <option value="0">Élève</option>
            <option value="1">Enseignant</option>
            <option value="3">Secrétaire</option>
            <option value="2">Proviseur</option>
          </select>

          <button class="btn btn-primary" type="submit" name="submit" value="submit">Ajouter</button>
        </div>
      </form>
      <p id="error"><?php echo $erreur ?></p>
    </div>

    <?php
        $bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password);
        $res = $bdd->allUsers();
        ?>

    <div class="table-responsive-lg">
      <table id="myTable" class="table table-light table-striped">
        <tr>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Nom Utilisateur</th>
          <th>e-mail</th>
          <th>Status</th>
        </tr>

       
        <?php
            // On utilise la variable $r
          foreach($res as $r){
        ?>   

        <!-- On affiche depuis la BDD : Nom, Prénom, Nom utilisateur, email, status-->
       <tr>
      <td><?= $r['lastname'] ?></td>
      <td><?= $r['firstname'] ?></td>
      <td><?= $r['username'] ?></td> 
      <td><?= $r['email'] ?></td>
      <td><?= $r['status'] ?></td>
    </tr>

    <?php
  }
  ?>
      </table>
    </div>
  </div>

  <?php include "var/js.html" ?>
</body>

</html>