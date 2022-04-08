<?php
session_start();
if (!isset($_SESSION["session"])) header("Location: /form/");
else if($_SESSION["status"] == 0) header("Location: /form/form.php");
else if($_SESSION["status"] == 1) header("Location: /form/placeholder.php");
else if($_SESSION["status"] == 2) header("Location: /form/placeholder.php");
else if($_SESSION["status"] == 3) header("Location: /form/placeholder.php");
?>
