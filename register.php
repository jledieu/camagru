<?php
include("header.php");
if (isset($_POST['inscript']) && $_POST['inscript'] == "Inscription")
{
	if (isset($_POST['login']) && isset($_POST['passwd']) && isset($_POST['email']))
	{
		if ($_POST['login'] == "" || $_POST['passwd'] == "" || $_POST['email'] == "")
		{
			?><script>alert("Veuillez remplir les champs.");</script><?php
			$inscript = true;
		}
		else
		{
			$login = $_POST['login'];
			$passwd = hash('whirlpool', $_POST["passwd"]);
			$email = $_POST['email'];
			$res = $DB->prepare("SELECT login FROM Users WHERE login = :login");
			$res->execute(array(':login' => $login));
			if ($res->rowCount() == 1)
			{
				?><script>alert("Login déjà utilisé.");</script><?php
				$inscript = true;
			}
			else
			{
				$mysqlQuery = "INSERT INTO Users (login, passwd, email) VALUES('$login', '".$passwd."', '".$email."')";
				$DB->query($mysqlQuery);
				?><script>alert("Inscription faite.");</script><?php

				$key = md5(microtime(TRUE)*100000);
				$ins = $DB->prepare("UPDATE Users SET keyconfirm = :key WHERE login like :login");
				$ins->execute(array(':key' => $key, ':login' => $login));

				$subject = 'Confirmation de votre inscription';
				$message = 'Bienvenue sur Camagru,

Pour activer votre compte, veuillez cliquer sur le lien ci dessous
ou copier/coller dans votre navigateur internet.

http://localhost:8080/camagru2/activation.php?log='.urlencode($login).'&key='.urlencode($key).'


---------------
Ceci est un mail automatique, Merci de ne pas y répondre.';

				$headers = 'From: inscription@camagru.fr' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
				mail($email, $subject, $message, $headers);
			}
		}
	}
}
?>
