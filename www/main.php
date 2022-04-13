<?php
session_start();
if (!isset($_SESSION["session"])) header("Location: /www/");

include 'var/sql.php';
include 'lib/GOBDD.php';

$bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password);

error_reporting(E_ALL & ~E_NOTICE);

?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Tableau de bord</title>
	</head>
	<body>
		<?php if($_SESSION["status"] != 0) {
			
				<h4>Fiches à valider</h4>
				<table class="table table-hover table-sm table-striped">
					<thead>
					<tr>
						<th scope="col">Nom</th>
						<th scope="col">Date</th>
						<th scope="col">Formulaire</th>
						<th scope="col">État</th>
						<th scope="col">Valider ?</th>
					</tr>
					</thead>
					<tbody>
				
				foreach ($a as $key => $value) {
				
						<tr class="list-form">
						<th scope="row">Garfield</td>
						<td>21/10/2022, 10h34</td>
						<td><b>Q°1 - Sciences et Vie de la Terre</b><br>
								<p>Comment est-ce que les plantes respirent?</p><br>
							<b>Q°2 - Sciences et Vie de la Terre/Physiques & Chimie</b><br>
								<p>Qu'est-ce qui est contenu dans l'air ?</p>
						</td>
						<td>
							<b>M.DUPOND : Validé</b><br>
							<b>M.HADDOCK : Validé</b><br>
							Proviseur : à valider
						</td>
						<td>
							<button type="button" class="btn btn-success">Y</button>
							<button type="button" class="btn btn-danger">N</button>
						</td>
					</tr>
					<tr class="list-form">
						<th scope="row">Garfield</td>
						<td>21/10/2022, 10h34</td>
						<td><b>Q°1 - Sciences et Vie de la Terre</b><br>
								<p>Comment est-ce que les plantes respirent?</p><br>
							<b>Q°2 - Sciences et Vie de la Terre/Physiques & Chimie</b><br>
								<p>Qu'est-ce qui est contenu dans l'air ?</p>
						</td>
						<td>
							<b>M.DUPOND : Validé</b><br>
							<b>M.HADDOCK : Validé</b><br>
							Proviseur : à valider
						</td>
						<td>
							<button type="button" class="btn btn-success">Y</button>
							<button type="button" class="btn btn-danger">N</button>
						</td>
					</tr>
					<tr class="list-form">
						<th scope="row">Garfield</td>
						<td>21/10/2022, 10h34</td>
						<td><b>Q°1 - Sciences et Vie de la Terre</b><br>
								<p>Comment est-ce que les plantes respirent?</p><br>
							<b>Q°2 - Sciences et Vie de la Terre/Physiques & Chimie</b><br>
								<p>Qu'est-ce qui est contenu dans l'air ?</p>
						</td>
						<td>
							<b>M.DUPOND : Validé</b><br>
							<b>M.HADDOCK : Validé</b><br>
							Proviseur : à valider
						</td>
						<td>
							<button type="button" class="btn btn-success">Y</button>
							<button type="button" class="btn btn-danger">N</button>
						</td>
					</tr>
					</tbody>
				</table>
				END;
			} } else {
		}?>

		<h4>Activités des fiches</h4>
		<table class="table table-hover table-sm table-striped">
			<thead>
			<tr>
				<th scope="col">Date</th>
				<th scope="col">Description</th>
			</tr>
			</thead>
			<tbody>
				<tr class="act act-bad bg-danger text-white">
					<td>21/10/2022, 10h34</td>
					<td><b>M.DUPOND</b> a refusé la fiche de <b>Jean</b></td>
				</tr>
				<tr class="act act-good bg-success text-white">
					<td>21/10/2022, 10h32</td>
					<td><b>Proviseur</b> a validé la fiche de <b>Jean</b></td>
				</tr>
				<tr class="act act-neut">
					<td>21/10/2022, 10h30</td>
					<td><b>Jean</b> a mis à jour sa fiche</td>
				</tr>
			</tbody>
		</table>

	</body>
</html>
