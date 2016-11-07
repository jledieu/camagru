<?php
session_start();
if ($_SESSION['loggued_on_user'] != "")
	$connexion = true;
else
	$connexion = false;
require_once ('config/setup.php');
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style/style.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="js/webcam.js"></script>
		<script src="js/deletephoto.js"></script>
	</head>

	<div <?php if($connexion == true) { ?> style="height:175px;" <?php } ?>class="header">
		<div class="title">Camagru</div>
		<div class="log">
			<?php if ($_GET['go'] == "" && $connexion == false) { ?>
				<form method="POST" action="connexion.php">
					Connexion :<br /><br />
					Identifiant* : <input type="text" name="login" value=""/><br /><br />
					Mot de passe* : <input type="password" name="passwd" value=""/>
					<input type="submit" name="submit" value="OK"/><br /><br />
					<input type="submit" name="submit" value="Mot de passe oublié"/>
					<input type="submit" name="submit" value="S'inscrire"/>
				</form>
			<?php } ?>
			<?php if ($_GET['go'] == "passlost" && $connexion == false) { ?>
				<form method="POST" action="index.php">
					Mot de passe oublié :<br /><br />
					Identifiant* : <input type="text" name="login" value="" />
					<input type="submit" name="passwdlost" value="Envoyer"/><br /><br />
					<input type="submit" name="submitreturn" value="Retour"/>
				</form>
			<?php } ?>
			<?php if ($_GET['go'] == "inscpt" && $connexion == false) { ?>
				<form method="POST" action="register.php">
					Inscription :<br /><br />
					Identifiant* : <input type="text" name="login" value="" /><br /><br />
					Mot de passe* : <input type="password" name="passwd" value=""/><br /><br />
					Email* : <input type="email" name="email" value=""/>
					<input type="submit" name="inscript" value="Inscription"/><br />
					<input type="submit" name="return" value="Retour"/>
				</form>
			<?php } ?>
			<?php if ($connexion == true) { ?>
				<form style="height:75px;" method="POST" action="logout.php">
					Bonjour <?php echo $_SESSION['loggued_on_user'] ?><br /><br />
					<a href="mygalery.php"><input type="button" value="Ma galerie"/></a>
					<input type="submit" name="logout" value="Déconnexion"/><br />
				</form>
			<?php } ?>
		</div>
		<?php if ($connexion == true) { ?>
		<div class="navigationbar">
			<ul>
				<li><a href="index.php">Galerie</a></li>
				<li><a href="mounting.php">Montage</a></li>
			</ul>
		</div>
		<div class="navigationbarmobile">
			<a href="mounting.php"><div class="link">Montage</div></a>
			<a href="index.php"><div class="link">Galerie</div></a>
		</div> <?php } ?>
	</div>
