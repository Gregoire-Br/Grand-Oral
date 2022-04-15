<?php
session_start();
if (!isset($_SESSION["session"]) || $_SESSION["status"] != 2) header("Location: /www/");

error_reporting(E_ALL & ~E_NOTICE);

include 'var/sql.php';
include 'lib/GOBDD.php';


$erreur = '';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "var/header.html" ?>
<title>Import XML/CSV</title>

<body>
	<?php include "var/navbar.html" ?>
    <div class="container d-flex flex-column">
        <div class="mb-3">
            <label for="formFileMultiple" class="form-label">Fichier XML :</label>
            <input class="form-control" type="file" id="formFileMultiple" multiple>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">UPLOAD</button>
        <div class="mb-3">
            <label for="formFileMultiple" class="form-label">Fichier CSV :</label>
            <input class="form-control" type="file" id="formFileMultiple" multiple>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">UPLOAD</button>
    </div>

<form action="upload.php" method="post" enctype="multipart/form-data">
    
    </form>
    

					<?php include "var/js.html" ?>
	</body>
</html>
