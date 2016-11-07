<?php include("header.php");

function base64_encode_image ($filename, $filetype) {
    if ($filename) {
        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
    }
}

$image = $_POST['image'];
$checkbox = $_POST['checkbox'];
if (isset($image)) {
	define('UPLOAD_DIR', 'images/');
	$img = $image;
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.png';
	$success = file_put_contents($file, $data);

	$largeur = 320;
	$hauteur = 240;
	$rendu = imagecreatetruecolor($largeur, $hauteur);
	$fond = imagecolorallocatealpha($rendu,  0, 128, 255, 0);
	imagefill($rendu, 0, 0, $fond);
	$image1 = imagecreatefrompng($file);
	unlink($file);
	$image2 = imagecreatefrompng('images/'.$checkbox.'.png');
	imagecopy($rendu, $image1, 0, 0, 0,0, $largeur, $hauteur);
	imagecopy($rendu, $image2, 10, 10, 0,0, 320, 240);
	imagesavealpha($rendu, true);
	imagepng($rendu, 'image.png');

	imagedestroy($dest);
	imagedestroy($src);

	$image = base64_encode_image('image.png','png');

	$saveimage = $DB->prepare("INSERT INTO Photos (login, link) VALUES(:login, :image)");
	$saveimage->execute(array(':login' => $_SESSION['loggued_on_user'], ':image' => $image));
}
if ($_SESSION['loggued_on_user'] != "")
{ ?>
	<body>
		<div class="content">
			<div class="article">
				<div class="titlearticle">
					Cheese !
				</div>
				<div class="filtres">
					<img class="filtre" src="images/none.png">
					<img class="filtre" src="images/armure1.png">
					<img class="filtre" src="images/armure2.png">
					<img class="filtre" src="images/armure3.png">
					<img class="filtre" src="images/armure4.png">
					<form name = "armures">
						<input onclick="displayImage('none');" style="margin-left:75px;" type="radio" name="armure" value="none" checked>
						<input onclick="displayImage('armure1');" style="margin-left:120px;" type="radio" name="armure" value="filtre1">
						<input onclick="displayImage('armure2');" style="margin-left:120px;" type="radio" name="armure" value="filtre2">
						<input onclick="displayImage('armure3');" style="margin-left:110px;"type="radio" name="armure" value="filtre3">
						<input onclick="displayImage('armure4');" style="margin-left:120px;" type="radio" name="armure" value="filtre4">
					</form>
				</div>
				<div class="camera">
					<video id="video"></video>
					<img id="filtreactive" src="">
					<button id="startbutton">Prendre une photo</button>
					<img id="photo">
				</div>
				<canvas id="canvas"></canvas>
			</div>
			<div class="photos">
				<div class="titlephotos">
					Les photos !
				</div>
				<div class="images">
					<?php
						$nbimage = 0;
						$img = $DB->query("SELECT id, link FROM Photos");
						while ($images = $img->fetch()) { ?>
							<a href="photo.php?id=<?php echo $images['id'];?>"><img class="image" src="<?php echo $images['link']; ?>"/></a>
						<?php $nbimage++; if ($nbimage > 19) { break; } } ?>
				</div>
			</div>
		</div>
	</body>
<?php }
else
{ ?>
	<body>
		<div class="content">
			<p>Erreur, vous devez être connecté pour pouvoir accéder à cette page.</p>
		</div>
	</body>
<?php }
?>
<?php include("footer.php"); ?>
