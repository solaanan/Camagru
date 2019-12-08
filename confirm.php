<?php
	session_start();
	include_once("includes/config.php");
	include_once("includes/handlers/confirm-handler.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once("includes/links.php"); ?>
	<link rel="stylesheet" href="/camagru/assets/css/confirmMail.css">
	<script src="/camagru/assets/js/themeSwitcher.js"></script>
	<title><?php echo "Camagru - " . $header ; ?></title>
</head>
<body>
	<div class="back">
	<?php include_once("includes/navbar.php") ?>
	<div class="container">
		<div class="jumbotron">
			<img class="good" src="/camagru/assets/images/<?= $img ?>" width="200" height="200" alt="good">
			<h1 class="display-4"><?= $header ?></h1>
			<hr>
			<p class="lead"><?= $paragraph ?></p>
		</div>
	</div>
	</div>
</body>
</html>