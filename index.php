<?php include("header.php"); ?>
<body>
	<div class="content">
		<div class="galerie">
			<?php
				$img = $DB->query("SELECT id, link FROM Photos");
				while ($images = $img->fetch()) { ?>
					<a href="photo.php?id=<?php echo $images['id'];?>"><img class="imagegalerie" src="<?php echo $images['link']; ?>"/></a>
				<?php } ?>
		</div>
	</div>
</body>
<?php include("footer.php"); ?>
