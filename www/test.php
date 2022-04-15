<?php
	echo "Hello world<br>";
	include 'var/sql.php';
	include 'lib/GOBDD.php';
	echo "fichiers chargés<br>";
	$bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password);
	if($bdd) { echo "connexion réussie<br>";}
	var_dump($bdd->allUsers())
 ?>
