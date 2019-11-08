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
<body>
	<? include_once("includes/navbar.php") ?>
	<div class="container">
		<div class="jumbotron">
			<h1 class="display-4 text-break">Smile at the camera!</h1>
			<div class="video-container">
				<video id="video" class="video" autoplay width="800" height="800"></video>
			</div>
			<canvas id="canvas"></canvas>
			<button id="snap" class="botona"> Snap </button>
		</div>
	</div>
</body>
</html>