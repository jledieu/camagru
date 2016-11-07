<?php
header('Location:index.php');
include("header.php");
if ($_POST['logout'] == "Déconnexion")
	$_SESSION['loggued_on_user'] = "";
?>
