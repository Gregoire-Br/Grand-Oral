<?php
	include "../lib/GOBDD.php";
	error_reporting(E_ALL & ~E_NOTICE);

	$bdd = new GOBDD("localhost", "grandoral", "root", "root",1);

	echo $bdd->createUser("nermal",1,"ner","mal","ner@mal.fr");
	//echo $bdd->createUser("odie",0,);
?>
