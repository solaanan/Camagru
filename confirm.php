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
		<!-- <div class="spinner-border m-auto" style="color: white;"></div> -->
		<svg class="logo-svg" width="142" height="142" viewBox="0 0 142 142" fill="none" xmlns="http://www.w3.org/2000/svg">
			<rect x="0.5" y="0.5" width="141" height="141" rx="25.5" stroke="white"/>
			<circle cx="71.0001" cy="71" r="42.5656" stroke="white"/>
			<circle cx="70.9999" cy="71" r="33.2541" stroke="white"/>
			<circle cx="120.602" cy="19.3398" r="7.06557" stroke="white"/>
			<rect x="0.5" y="33.0901" width="8.31148" height="75.8197" rx="4.15574" stroke="white"/>
		</svg>
	</div>
</body>
</html>