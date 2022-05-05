<?php
session_start();
if (!isset($_SESSION["session"]) || $_SESSION["status"] < 1) header("Location: /");

include 'var/sql.php';
include 'lib/GOBDD.php';
include 'lib/debug.php';

$Debug=false;

$bdd = new GOBDD($sql_ip, $sql_db, $sql_login, $sql_password);

error_reporting(E_ALL & ~E_NOTICE);

$VLD = ["Non Validé","Validé"];

?>

<!DOCTYPE html>
<html lang="fr">

<?php include "var/header.html" ?>
<title>Tableau de bord</title>

<body>
	<?php include "var/navbar.html" ?>
	<div class="container-fluid">
		<h4>Fiches à valider</h4>
		<div class="scroll" style="max-height : 500px">
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

						<?php
						$res = $bdd->allLastForms();
						debugPrintVariable(res);
						foreach ($res as $r) {
							debugPrintVariable(r);
							if ($r['e1valid']==0 or $r['e2valid']==0 or $r['proValid']==0) { 
								$ens1=$bdd->userQuery($r['ens1']);	
								$ens2=$bdd->userQuery($r['ens2']);
						?>
								<tr class="list-form">
									<td scope="row"><?php echo $r['lastname'] ?></td>
									<td> <?php echo $r['date'] ?></td>
									<td>
										<b> Q°1 -  <?php echo $r['spec1'] ?></b><br>
										<p> <?php echo $r['q1'] ?></p>
										<b> Q°2 -  <?php echo $r['spec2'] ?></b><br>
										<p> <?php echo $r['q2'] ?></b>
									</td> 
									<td>
										<b> <?php echo "M.".strtoupper($ens1[0]['lastname']); echo " : ".$VLD[$r['e1valid']] ?> </b><br>
										<b> <?php echo "M.".strtoupper($ens2[0]['lastname']); echo " : ".$VLD[$r['e2valid']] ?> </b><br>
										Proviseur : à valider
									</td>
									<td>
										<button type="button" class="btn btn-success">Y</button>
										<button type="button" class="btn btn-danger">N</button>
									</td>
								</tr>
						<?php
							}
						}
						?>
				</tbody>
			</table>
		</div>

		<h4>Fiches validées</h4>
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
			<?php
				//$res = $bdd->allFormsProValid();
				debugPrintVariable(res);
				foreach ($res as $r) {
					debugPrintVariable(r);
					if ($r['e1valid']==1 and $r['e2valid']==1 and $r['proValid']==1) { 
				   		$ens1=$bdd->userQuery($r['ens1']);	
				   		$ens2=$bdd->userQuery($r['ens2']);
				?>
				   		<tr class="list-form">
							<td scope="row"><?php echo $r['lastname'] ?></td>
							<td> <?php echo $r['date'] ?></td>
							<td>
								<b> Q°1 -  <?php echo $r['spec1'] ?></b><br>
								<p> <?php echo $r['q1'] ?></p>
								<b> Q°2 -  <?php echo $r['spec2'] ?></b><br>
								<p> <?php echo $r['q2'] ?></b>
							</td> 
							<td>
								<b> <?php echo "M.".strtoupper($ens1[0]['lastname']); echo " : ".$VLD[$r['e1valid']] ?> </b><br>
								<b> <?php echo "M.".strtoupper($ens2[0]['lastname']); echo " : ".$VLD[$r['e2valid']] ?> </b><br>
								Proviseur : à valider
							</td>
							<td>
								<!--button type="button" class="btn btn-success">Y</button-->
								<button type="button" class="btn btn-danger">N</button>
							</td>
						</tr>
				<?php
					}
          		}
          		?>

			</tbody>
		</table>

		<?php
		// }
		?>

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
		<?php include "var/js.html" ?>
	</div>
</body>

</html>
