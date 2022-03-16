<?php

if (isset($_POST["submit"])) {

  require_once "dbh.php";
  require_once "functions.php";

  // On obtient les données depuis le formulaire
  $lastname = $_POST["lastname"];
  $firstname = $_POST["firstname"];
  $ens1 = $_POST["ens1"];
  $spec1 = $_POST["spec1"];
  $q1 = $_POST["q1"];
  $ens2 = $_POST["ens2"];
  $spec2 = $_POST["spec2"];
  $q2 = $_POST["q2"];

 

  // Champs vide
  // We set the functions "!== false" since "=== true" has a risk of giving us the wrong outcome
  if (emptyInput($lastname, $firstname, $ens1, $spec1, $q1, $ens2, $spec2, $q2) !== false) {
    header("location: ../index.php?error=emptyinput");
	    exit();
  }

  createForm($conn, $lastname, $firstname, $ens1, $spec1, $q1, $ens2, $spec2, $q2);
// Si tout se passe bien, on retourne au formulaire

} else {
	header("location: ../index.php");
    exit();
}
