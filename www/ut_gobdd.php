<?php
include 'var/sql.php';
include 'lib/GOBDD.php';

$bdd = new GOBDD($sql_ip,$sql_db,$sql_login,$sql_password);
?>

<!DOCTYPE html>
<html lang="" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>TEST UNITAIRE</title>
	</head>
	<body>
		<?php
		echo "userQuery : ";
		var_dump($bdd->userQuery("garfield"));
		echo "<br><br>";;
		echo "changePassword : ";
		var_dump($bdd->changePassword("garfield","azerty"));
		echo "<br><br>";
		echo "studentQuery : ";
		var_dump($bdd->studentQuery("garfield"));
		echo "<br><br>";
		echo "checkCredentials : ";
		var_dump($bdd->checkCredentials("garfield","azerty"));
		echo "<br><br>";
		echo "formHistoryQuery : ";
		var_dump($bdd->formHistoryQuery("garfield"));
		echo "<br><br>";
		echo "formQuery : ";
		var_dump($bdd->formQuery("garfield"));
		echo "<br><br>";
		echo "updateForm : ";
		var_dump($bdd->updateForm("garfield","question 1","question 2"));
		echo "<br><br>";
		echo "updateStudent : ";
		var_dump($bdd->updateStudent("garfield","sciences","physique"));
		echo "<br><br>";
		echo "allUsers : ";
		var_dump($bdd->allUsers());
		echo "<br><br>";
		?>
	</body>
</html>
