<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/session_expiry.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/links.php") ?>
	<link rel="stylesheet" href="/camagru/assets/css/confirmMail.css">
	<script src="/camagru/assets/js/themeSwitcher.js"></script>
	<title>Camagru - Confirm your email address</title>
</head>
<body>
	<?php include($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/navbar.php") ?>
	<div class="everything">
		<div class="back"></div>
		<div class="container">
			<div class="jumbotron">
				<img class="good" src="/camagru/assets/images/icons-dark/good.png" width="200" height="200" alt="good">
				<h1 class="display-4">One more step!</h1>
				<hr>
				<p class="lead">In order to login to your account, you need to confirm your email address, please
					click the link we've sent you.
				</p>
			</div>
		</div>
	</div>
	<div class="loading-container" id="loading" style="display: flex;">
		<div class="spinner-border m-auto" style="color: white;"></div>	
	</div>
</body>
</html>