<?php
include '../var/sql.php';
include 'GOBDD.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);

$bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password,1);
error_reporting(E_ALL & ~E_NOTICE);

echo "<b><i>Nettoyage</i></b><br>";
	$bdd->deleteUser('uteleve'); // supprimer l'étudiant
	$bdd->deleteUser('utens1'); // supprimer le prof
echo "<br>";

echo "<h2>Comptes utilisateur</h2><br>";

	$bdd->ut('createUser','uteleve','mdp','UT','Eleve',0,'email'); // créer utilisateur (étudiant)
	$bdd->ut('updateUser', 'uteleve','email@gmail.com',0); // mise à jour des infos
	$bdd->ut('userQuery','uteleve'); // infos utilisateur
	//$bdd->ut('homonyms','uteleve'); // nom unique
	$bdd->ut('allUsers'); // tous les utilisateurs
	$bdd->ut('changePassword','uteleve','pswd'); // changer son mdp
	$bdd->ut('checkCredentials','uteleve','pswd'); // vérifier son mdp

echo "<h2>Etudiant</h2><br>";

	$bdd->ut('createStudent','uteleve','123456789UT','Terminale UT'); // créer son compte étudiant
	$bdd->ut('studentQuery','uteleve'); // infos étudiant
	$bdd->ut('INEquery','123456789UT'); // chercher infos par INE
	$bdd->ut('allStudents');

echo "<h2>Formulaire</h2><br>";

	$bdd->ut('updateForm','uteleve','Question 1','Question 2','utens1','utens2',1,0,1,2); // créer formulaire
	$bdd->ut('formQuery','uteleve'); // infos formulaire
	$bdd->ut('formByINE','123456789UT'); // chercher formulaire par INE
	$bdd->ut('updateForm','uteleve','Question 1 MODIFIEE','Question 2','utens1','utens2',1,0,1,2); // créer formulaire
	$bdd->ut('formHistoryQuery','uteleve'); // historique formulaire
	$bdd->ut('allLastForms'); //tous les derniers formulaires

echo "<h2>Enseignant, validation</h2><br>";

	$bdd->ut('createUser','utens1','pswd','UT','Enseignant',1,'email@proton.me'); // créer utilisateur (prof)
	$bdd->ut('listProfsQuery'); // lister les profs
	$bdd->ut('relatedForms','utens1'); // formulaires lié au prof
	$bdd->ut('validate','utens1','uteleve'); // validation du formulaire par le prof
	$bdd->ut('createUser','utens2','pswd','UT','Professeur',1,'email@protonmail.com'); // créer utilisateur (prof 2)
	$bdd->ut('createUser','utprovi','pswd','UT','Proviseur',2,'provi@protonmail.com'); //créer utilisateur (proviseur)
	$bdd->ut('validate','utens2','uteleve'); // validation du formulaire par le prof
	$bdd->ut('validate','utprovi','uteleve'); // validation du formulaire par le prof
	$bdd->ut('formQuery','uteleve'); // infos formulaire

echo "<h2>Misc.</h2><br>";

	$bdd->ut('specQuery'); // lister les spécialités
	$bdd->ut('classesQuery'); // lister les classes
	$bdd->ut('studentsByClasseQuery','Terminale UT'); // lister les élèves de la classe de l'étudiant

echo "<h2>Suppression</h2><br>";

	echo "<br><b>Ajout de 2 formulaires</b><br>";
	$bdd->ut('updateForm','uteleve','Ceci est','un test','utens1','utens2',1,0,1,2); // créer formulaire
	$bdd->ut('updateForm','uteleve','Ceci est','un test','utens1','utens2',1,0,1,2); // créer formulaire
	$f = $bdd->formQuery("uteleve");

	$bdd->ut('cleanFormHistory','uteleve'); // nettoyage de l'historique
	$bdd->ut('formHistoryQuery','uteleve');

	$fh = $bdd->formHistoryQuery("uteleve");
	$bdd->ut('deleteForm',$fh[0]["id"]); //supprimer le formulaire
	$bdd->ut('deleteForm',$fh[1]["id"]); //supprimer le formulaire
	$bdd->ut('deleteForm',$fh[2]["id"]); //supprimer le formulaire
	$bdd->ut('formHistoryQuery','uteleve');

	$bdd->ut('deleteUser','uteleve'); // supprimer l'étudiant
	$bdd->ut('deleteUser','utens1'); // supprimer le prof
	$bdd->ut('deleteUser','utens2'); // supprimer le prof 2
	$bdd->ut('deleteUser','utprovi'); // supprimer le provi
	$bdd->ut('userQuery','uteleve'); // étudiant supprimé
	$bdd->ut('userQuery','utens1'); // prof supprimé
	$bdd->ut('userQuery','utens2'); // prof2 supprimé
	$bdd->ut('userQuery','utprovi'); // provi supprimé
?>
