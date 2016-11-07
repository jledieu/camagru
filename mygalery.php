<?php include("header.php");
?>
<body>
	<div class="content">
		<div class="galerie">
			<?php
			$loggued_on_user = $_SESSION['loggued_on_user'];
			$user = $DB->query("SELECT login FROM Photos");
			while ($users = $user->fetch()) {
				if ($users['login'] == $loggued_on_user) {
					$mygalery = $DB->query("SELECT id, link FROM Photos WHERE login = '$loggued_on_user'");
					while ($photo = $mygalery->fetch()) { ?>
						<a href="photo.php?id=<?php echo $photo['id'];?>"><img class="imagegalerie" src="<?php echo $photo['link']; ?>"/></a>
					<?php } break; } }?>
		</div>
	</div>
</body>
<?php include("footer.php"); ?>
