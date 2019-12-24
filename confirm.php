<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/session_expiry.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/handlers/confirm-handler.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/links.php"); ?>
	<link rel="stylesheet" href="/camagru/assets/css/confirmMail.css">
	<script src="/camagru/assets/js/themeSwitcher.js"></script>
	<title><?php echo "Camagru - " . $header ; ?></title>
</head>
<body>
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/navbar.php") ?>
	<div class="everything">
		<div class="back"></div>
		<div class="container">
			<div class="jumbotron">
				<img class="good" src="/camagru/assets/images/<?= $img ?>" width="200" height="200" alt="good">
				<h1 class="display-4"><?= $header ?></h1>
				<hr>
				<p class="lead"><?= $paragraph ?></p>
			</div>
		</div>
	</div>
	<div class="loading-container" id="loading" style="display: flex;">
		<div class="spinner-border m-auto" style="color: white;"></div>	
	</div>
</body>
</html>