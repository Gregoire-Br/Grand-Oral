<?php
session_start();
if (!isset($_SESSION["session"]) || $_SESSION["status"] != 0) header("Location: /admin-tools/");

include 'var/sql.php';
include 'lib/GOBDD.php';

$bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password);

error_reporting(E_ALL & ~E_NOTICE);


$studentinfo = $bdd->studentQuery($_SESSION["username"]);
$forminfo = $bdd->formQuery($_SESSION["username"]);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Interface superviseur</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</head>
	<body>
		<ul class="nav nav-tabs" id="tabList" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="tab-mainTab" data-toggle="tab" href="#mainTab" role="tab" aria-controls="mainTab" aria-selected="true">Tableau de bord</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="tab-forms" data-toggle="tab" href="#forms" role="tab" aria-controls="forms" aria-selected="false">Formulaires</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="tab-profiles" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profils</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="tab-imports" data-toggle="tab" href="#imports" role="tab" aria-controls="imports" aria-selected="false">Imports</a>
			</li>
		</ul>
		<div class="tab-content" id="tabContent">
			<div class="tab-pane fade show active" id="mainTab" role="tabpanel" aria-labelledby="mainTab-tab">
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
			</div>
			<div class="tab-pane fade" id="forms" role="tabpanel" aria-labelledby="forms-tab">
				  <table class="table table-hover table-sm table-striped">
					<thead>
					  <tr>
						<th scope="col">Nom</th>
						<th scope="col">Date</th>
						<th scope="col">Formulaire</th>
						<th scope="col">État</th>
					  </tr>
					</thead>
					<tbody>
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
						</tr>
					</tbody>
				  </table>
			  </div>
			<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

			</div>
			<div class="tab-pane fade" id="imports" role="tabpanel" aria-labelledby="imports-tab">

			</div>
	  	</div>
	</body>
</html>
