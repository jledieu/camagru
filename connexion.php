<?php
if ($_POST['submit'] == 'S\'inscrire')
	header('Location:index.php?go=inscpt');
else if ($_POST['submit'] == 'Mot de passe oublié')
	header('Location:index.php?go=passlost');
else
	header('Location:index.php');
include("header.php");
if (isset($_POST['submit']) && $_POST['submit'] == "OK")
{
	if (isset($_POST['login']) && isset($_POST['passwd']))
	{
		if ($_POST['login'] == "" || $_POST['passwd'] == "")
		{
			?><script>alert("Veuillez remplir les champs.");</script><?php
		}
		else
		{
			$login = $_POST['login'];
			$passwd = hash('whirlpool', $_POST["passwd"]);
			$res = $DB->prepare("SELECT login, passwd FROM Users WHERE login = :login AND passwd = :passwd AND confirm = :confirm");
			$res->execute(array(':login' => $login, ':passwd' => $passwd, ':confirm' => 1));
			if ($res->rowCount() == 1)
			{
				$_SESSION['loggued_on_user'] = $login;
			}
			else
			{
				?><script>alert("Login ou Mot de passe incorrect.");</script><?php
			}
		}
	}
}
?>
