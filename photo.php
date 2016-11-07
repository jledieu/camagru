<?php
include("header.php");
if ($_POST['submit'] == "Supprimer cette photo")
{
	$deleteimage = $DB->prepare("DELETE FROM Photos WHERE id = :id");
	$deleteimage->execute(array(':id' => $_POST['id']));
}
?>
<body>
	<div class="content" style="overflow:scroll;">
		<div class="unephoto">
			<?php
			if ($_GET['id']) {
				$loggued_on_user = $_SESSION['loggued_on_user'];
				$unephoto = $_GET['id'];
				$onephoto = $DB->query("SELECT login, link FROM Photos WHERE id = $unephoto");
				$anotherphoto = $onephoto->fetch();
				if ($anotherphoto['link'] != "")
				{
				?> <img id="onephoto" src="<?php echo $anotherphoto['link'] ?>"/>
				<p style="margin-top:10px;">Auteur : <?php echo $anotherphoto['login']?></p>
				<?php
					if ($anotherphoto['login'] == $loggued_on_user) { ?>
						<form method="POST" action="photo.php">
							<input style="display:none" name="id" value="<?php echo $unephoto ?>"></input>
							<input style="margin-top: 15px" type="submit" name="submit" value="Supprimer cette photo"></input>
						</form>
					<?php } ?>
				<form method="POST" action="likeandcomment.php">
					<input style="display:none" name="id" value="<?php echo $unephoto ?>"></input>
					<button style="border: 0px; background-color: transparent;" type="submit" name="submit" value="Like">
						<img id="like" style="margin-top:10px; height:30px;" src="images/like.png" />
					</button>
					<?php $reqnblike = $DB->query("SELECT count(ID) AS nblike FROM Love WHERE ID_photo = $unephoto");
					$nblike = $reqnblike->fetch();
					echo $nblike['nblike']; ?>
				</form>
				<br /><h1>Commentaires : </h1><br />
				<div id="comments">
					<form method="POST" action="likeandcomment.php">
						<input style="display:none" name="id" value="<?php echo $unephoto ?>"></input>
						<input style="display:none" name="loginphoto" value="<?php echo $anotherphoto['login'] ?>"></input>
						<input style="width:400px;" name="comment" type="textarea"></input>
						<input type="submit" name="submit" value="Envoyer"></input>
					</form>
					<?php $takecomment = $DB->query("SELECT login, datecom, comment FROM Comments WHERE ID_photo = $unephoto");
					while ($comment = $takecomment->fetch()) {
						?> <p style="margin-top:5px;"><strong><?php echo $comment['login'] ?></strong> le <?php echo $comment['datecom']; ?> : </br></p> <?php
						echo $comment['comment']; ?> </br> <?php
					}
				}
				else
				{
					echo "La photo n'existe pas.";
				}
			} ?>
				</div>
		</div>
	</div>
</body>
<?php
include("footer.php");
?>
