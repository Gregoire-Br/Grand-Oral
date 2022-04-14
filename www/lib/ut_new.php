<?php
include "../lib/GOBDD_2.php";
error_reporting(E_ALL & ~E_NOTICE);

$bdd = new GOBDD("localhost", "grandoral", "root", "root",1);

var_dump($bdd->userQuery("garfield"));
// O
echo "<br><br>";
var_dump($bdd->allUsers());
// O
echo "<br><br>";
var_dump($bdd->formQuery("garfield"));
// O
echo "<br><br>";
var_dump($bdd->formHistoryQuery("garfield"));
// O
echo "<br><br>";
var_dump($bdd->changePassword("garfield","abc123"));
// O
echo "<br><br>";
var_dump($bdd->checkCredentials("garfield","abc123"));
// O
echo "<br><br>";
var_dump($bdd->studentQuery("garfield"));
// O
echo "<br><br>";
var_dump($bdd->relatedForms("Jean"));
// O
echo "<br><br>";
var_dump($bdd->createUser("jon","hello","jon","arbuckle",1,"jon@gmail.com"));
// O
echo "<br><br>";
var_dump($bdd->updateForm("garfield","comment fabriquer du maasdam","qui êtes vous"));
// O
echo "<br><br>";
var_dump($bdd->scannedForm("123456789af"));
// O
echo "<br><br>";
/*var_dump($bdd->createStudent($user,));
echo "<br><br>";
var_dump($bdd->());
echo "<br><br>";*/

?>
