<?php
session_start();
if (!isset($_SESSION["session"]) || $_SESSION["status"] < 2) header("Location: /");

error_reporting(E_ALL & ~E_NOTICE);

include 'var/sql.php';
include 'lib/GOBDD.php';
include 'lib/debug.php';

$Debug = false;
$erreur = '';
$students=array();

//Création d'une instance de la classe GOBDD
$bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password, $Debug);

debugPrintVariablePOST();

// Traitement du GET pour Ajax (pas d'affichage dans cette section, sortie via return)
if (isset($_GET["Classe"])) {
  $students = $bdd->studentsByClasseQuery($_GET["Classe"]);  //Pour peupler le champ select du formulaire
  echo "<table id='myTable' class='table table-light table-striped'>";
  echo "<tr>";
  echo "  <th>Nom</th>";
  echo "  <th>Prénom</th>";
  echo "  <th>Nom Utilisateur</th>";
  echo "  <th>INE</th>";
  echo "  <th>Classe</th>";
  echo "  <th>Password</th>";
  echo "</tr>";

    foreach ($students as $st) {

      // On affiche depuis la BDD : Nom, Prénom, Nom utilisateur, email, status-->
      echo "<tr>";
      echo "  <td>".$st['lastname']."</td>";
      echo "  <td>".$st['firstname']."</td>";
      echo "  <td>".$st['username']."</td>";
      echo "  <td>".$st['ine']."</td>";
      echo "  <td>".$st['Classe']."</td>";
      echo "  <td>".$st['Password']."</td>";
      echo "</tr>";
    }
  echo "</table>";

  return;  //Permets de traiter lots.php comme deux codes différents selon qu'on est GET ou POST
}

// Traitement du POST pour affichage page 
//Récupération des valeurs rentrées dans la table si bouton = submit
if (isset($_POST["submit"])) {
  // modif d'un user : seuls les champs email et status sont modifiables
  if($_POST["submit"]=="passwd") {

        //Crée un mdp random ( a revoir avec greg)
        function random_password($length = 8)
        {
          $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
          $password = substr(str_shuffle($chars), 0, $length);
          return $password;
        }

        $students = $bdd->studentsByClasseQuery($_POST["classe"]);  //Pour peupler le champ select du formulaire
        foreach ($students as &$st) {
          $st["password"]=random_password(8);
        }
        //debugPrintVariable(students);

  } else if ($_POST["submit"]=="delete") {

  } else {
      echo "Il y a une erreur dans le code";
    }
}  

$Classes = $bdd->classesQuery();

?>

<!DOCTYPE html>
<html lang="fr">

<?php include "var/header.html" ?>
<title>Profils</title>


<body>

<script> 
/**  
* @brief  Ajax pour afficher éléments de la classe en temps réel selon le choix sélectionné
*  la table est renvoyée dans le traitement du Get et affichée par document.getElementById("tableStudents").innerHTML=this.responseText
* @param str - le nom de la classe de l'élève
____________________________________________________________________________________________________*/
function showClasse(str) {
  var xhttp; 
  if (str == "") {
    document.getElementById("tableStudents").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("tableStudents").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "lots.php?Classe="+str, true);
  xhttp.send();
}
</script>


<!-- --------------------------- Corps de la page HTML -------------------------------- -->
  <div id="alertPlaceholder" class="position-fixed bottom-0 end-0 p-3"></div>

  <?php include "var/navbar.html" ?>


  <div class="container-fluid pb-5">
    <!--div class="table-responsive-lg"-->
      <p id="Titre" class="text-center"><b>TRAITEMENT EN LOTS</b></p>
    <!--/div-->
    <form action="" method="post" class="needs-validation" novalidate>
      <div class="statsUserData d-flex p-3">
        <?php // debugPrintVariable(students); ?>
        <select name="classe" id="classe" class="form-control col" onchange=showClasse(this.value) required>
            <?php 
            if (!isset($students[0])) echo '<option disabled selected value="">Selectionnez la classe</option>';
            foreach ($Classes as $clss) {  
                if ($students[0]['Classe']==$clss['Classe']) echo '<option selected name="Classe" value="'.$clss["Classe"].'">'.$clss["Classe"].'</option>';
                else echo '<option name="Classe" value="'.$clss["Classe"].'">'.$clss["Classe"].'</option>';
            }?>
        </select>
      </div>
      <div class="btn-group float-end">
        <button class="btn btn-danger" type="submit" name="submit" value="delete">Supprimer</button>
        <button class="btn btn-primary" type="submit" name="submit" value="passwd">Générer les mots de passe</button>
      </div>
    </form>
        <div class="table-responsive-lg pt-5" id="tableStudents" >
          <?php 
          if (isset($_POST["classe"])){
            
            echo "<table id='myTable' class='table table-light table-striped'>";
            echo "<tr>";
            echo "  <th>Nom</th>";
            echo "  <th>Prénom</th>";
            echo "  <th>Nom Utilisateur</th>";
            echo "  <th>INE</th>";
            echo "  <th>Classe</th>";
            echo "  <th>Password</th>";
            echo "</tr>";

              debugPrintVariable(students);
              foreach ($students as $st) {
                debugPrintVariable(st);
                // On affiche depuis la BDD : Nom, Prénom, Nom utilisateur, email, ine et password-->
                echo "<tr>";
                echo "  <td>".$st['lastname']."</td>";
                echo "  <td>".$st['firstname']."</td>";
                echo "  <td>".$st['username']."</td>";
                echo "  <td>".$st['ine']."</td>";
                echo "  <td>".$st['Classe']."</td>";
                echo "  <td>".$st['password']."</td>";
                echo "</tr>";
                
                // Appel à changePassword() pour changement ou initialisation dans la bdd du mot de passe
                $bdd->changePassword($st['username'], $st['password']);
              }
            echo "</table>";
            }
          ?>
        </div>
  </div>

  <?php include "var/js.html" ?>
</body>

</html>
