<?php
session_start();
if (!isset($_SESSION["session"])) header("Location: /");
else if($_SESSION["status"] == 0) header("Location: /form.php");
else if($_SESSION["status"] == 1) header("Location: /board.php");
else if($_SESSION["status"] == 2) header("Location: /board.php");
else if($_SESSION["status"] == 3) header("Location: /board.php");
?>
