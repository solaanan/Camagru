<?php
	session_start();

	if (isset($_SESSION['userLoggedIn']))
		header('Location: gallery')
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/links.php'); ?>
	<link rel="stylesheet" href="/camagru/assets/css/login.css">
	<script src="/camagru/assets/js/themeSwitcher.js"></script>
	<title>Document</title>
</head>
<body>
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/navbar.php'); ?>
	<div class="everything">
		<div class="back"></div>
		<div class="container">
			<div class="jumbotron">
				<h1 class="display-4">Session expired!</h1>
				<hr>
				<p class="lead">Please re-login to renew your session.</p>
				<a class="btn-lg botona" href="/camagru/login" style="text-decoration:none; margin:auto; margin-top:20px; display:inline-block">Login</a>
			</div>
		</div>
	</div>
	<div class="loading-container" id="loading" style="display: flex;">
		<div class="spinner-border m-auto" style="color: white;"></div>	
	</div>
</body>
</html>