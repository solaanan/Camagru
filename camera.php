<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once("includes/links.php") ?>
	<title>Camagru - Take a new photo</title>
	<link rel="stylesheet" href="/camagru/assets/css/camera.css">
	<script src="/camagru/assets/js/camera.js"></script>
</head>
<body id="body">
	<?php include_once("includes/navbar.php") ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col col-1 blank"></div>
			<div class="col col-6">
				<h1 class="display-4 text-break">Smile at the camera!</h1>
				<video id="video" class="video" autoplay>yes</video>
				<button id="snap" class="botona">
					<img src="/camagru/assets/images/snap.png" alt="snap" width="25" height="20">
					Snap
				</button>
				<img class="preview" id="img" alt="preview">
				<button id="save" class="botona">
					<img src="/camagru/assets/images/save.png" alt="save" width="20" height="20">
					Save
				</button>
				<button id="retake" onclick="javascript:history.go(0)" class="botona">
					<img src="/camagru/assets/images/retake.png" alt="retake" width="20" height="20">
					Retake
				</button>
			</div>
			<div class="col col-1 blank"></div>
			<div class="col col-3">
				<h1 class="display-4 text-break">Your recent posts:</h1>
			</div>
			<div class="col col-1 blank"></div>
		</div>
	</div>
		<canvas id="canvas"></canvas>
</body>
</html>