<?php
header('Location:photo.php?id='.$_POST['id']);
include("header.php");
if ($_POST['submit'] == "Envoyer")
{
	if (strlen($_POST['comment']) > 255)
	{
		?><script>alert("Commentaire trop long !")</script> <?php
	}
	else if ($_SESSION['loggued_on_user'] === "")
	{
		?><script>alert("Vous devez être connecté pour pouvoir mettre un commentaire !")</script> <?php
	}
	else
	{
		$comment = $DB->prepare("INSERT INTO Comments (ID_photo, loginphoto, login, comment, datecom) VALUES (:ID_photo, :loginphoto, :login, :comment, :datecom)");
		$comment->execute(array(':ID_photo' => $_POST['id'], ':loginphoto' => $_POST['loginphoto'], ':login' => $_SESSION['loggued_on_user'], ':comment' => $_POST['comment'], ':datecom' => date("Y-m-j")));
	}
}

if ($_POST['submit'] == "Like")
{
	if ($_SESSION['loggued_on_user'] === "")
	{
		?><script>alert("Vous devez être connecté pour pouvoir like !")</script> <?php
	}
	else
	{
		$delete = false;
		$searchlike = $DB->query("SELECT ID_photo, login FROM Love");
		while ($onelike = $searchlike->fetch()) {
			if ($_POST['id'] == $onelike['ID_photo'] && $_SESSION['loggued_on_user'] == $onelike['login']) {
				$deletelike = $DB->prepare("DELETE FROM Love WHERE ID_photo = :ID_photo AND login = :login");
				$deletelike->execute(array(':ID_photo' => $_POST['id'], ':login' => $_SESSION['loggued_on_user']));
				$delete = true;
			}
		}
		if ($delete == false)
		{
			$like = $DB->prepare("INSERT INTO Love (ID_photo, login) VALUES (:ID_photo, :login)");
			$like->execute(array(':ID_photo' => $_POST['id'], ':login' => $_SESSION['loggued_on_user']));
		}
	}
}
?>
