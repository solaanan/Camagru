<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include("includes/links.php") ?>
		<link rel="stylesheet" href="/camagru/assets/css/home.css">
		<title>Camagru - Home</title>
	</head>
	<body>
		<div class="back"></div>
		<?php include("includes/navbar.php") ?>
		<div class="container">
			<div class="jumbotron">
			<h1 class="display-4 text-break">Welcome to Camagru !</h1>
			<p class="lead text-break">In 1794, Claude Chappe tried to resolve the issue of long-distance communication,
				that was limited to horse speed at that time. He set up an ingenious communication
				system of air telegraph during the French Revolution. Chappe’s “tours” (towers) were
				covered by a mobile mast that could be seen with binoculars from the nearest neighbor
				tower located at approximately 10 to 15 km.</p>
			<hr class="my-4">
			<p>Fortunately, we are in the 21st century.</p>
			<a class="btn btn-primary btn-lg botona" href="/camagru/register.php" role="button">Get Started</a>
		  </div>
	</div>
</body>
</html>