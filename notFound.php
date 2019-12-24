<!DOCTYPE html>
<html lang="en">
<head>
	<?php include($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/links.php") ?>
	<link rel="stylesheet" href="/camagru/assets/css/notFound.css">
	<title>Camagru - 404</title>
	<script src="/camagru/assets/js/themeSwitcher.js"></script>
</head>
<body>
	<?php include($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/navbar.php") ?>
	<div class="everything">
		<div class="back"></div>
		<div class='container'>
			<div class="jumbotron">
			<h1 class="display-4 oops text-break">Oops! Page not found</h1>
			<p class="lead paragraph text-break"> This is not the web page you are looking for.</p>
			<img class="image" src="/camagru/assets/images/not-found.png" alt="404">
			</div>
		</div>
	</div>
	<div class="loading-container" id="loading" style="display: flex;">
		<div class="spinner-border m-auto" style="color: white;"></div>	
	</div>
</body>
</html>