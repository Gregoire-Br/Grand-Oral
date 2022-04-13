<?php
session_start();
if (!isset($_SESSION["session"])) header("Location: /www/");
else if($_SESSION["status"] == 0) header("Location: /www/form.php");
else if($_SESSION["status"] == 1) header("Location: /www/placeholder.php");
else if($_SESSION["status"] == 2) header("Location: /www/placeholder.php");
else if($_SESSION["status"] == 3) header("Location: /www/placeholder.php");
?>