<?php
include("header.php");
$confirm = 0;
$key = 1;
$keydb = 2;
if (isset($_GET['log']) && isset($_GET['key']))
{
	$login = $_GET['log'];
	$key = $_GET['key'];
	$recup = $DB->prepare("SELECT keyconfirm, confirm FROM Users WHERE login like :login ");
	if ($recup->execute(array(':login' => $login)) && $row = $recup->fetch())
	{
		$keydb = $row['keyconfirm'];
		$confirm = $row['confirm'];
	}
}
?>
<body>
	<div class="content">
		<?php
		if ($confirm == '1')
			echo "Votre compte est déjà actif !";
		else
		{
			if($key == $keydb)
			{
				$confirm1 = $DB->prepare("UPDATE Users SET confirm = 1 WHERE login like :login ");
				$confirm1->execute(array(':login' => $login));
				$_SESSION['loggued_on_user'] = $login;
				$connexion = true;
				echo "Votre compte a bien été activé !";
			}
			else
				echo "Erreur ! Votre compte ne peut être activé...";
		}
		?>
	</div>
</body>
<?php include("footer.php"); ?>
