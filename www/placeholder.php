<?php
session_start();
if (!isset($_SESSION["session"])) header("Location: /www/");

include 'var/sql.php';
include 'lib/GOBDD.php';

$bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password);

error_reporting(E_ALL & ~E_NOTICE);

$userinfo = $bdd->userQuery($_SESSION["username"]);
$studentinfo = $bdd->studentQuery($_SESSION["username"]);
$forminfo = $bdd->formQuery($_SESSION["username"]);

?>

<!DOCTYPE html>
<html lang="fr">

<?php include "var/header.html" ?>

<body>
    <div id="alertPlaceholder" class="position-fixed bottom-0 end-0 p-3"></div>

    <?php include "var/navbar.html" ?>

    <?php include "var/js.html" ?>
</body>

</html>