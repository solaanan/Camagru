<?php
	session_start();
	if (isset($_SESSION) && isset($_SESSION['userLoggedIn'])) {
		header('Location: /camagru/gallery');
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include("includes/links.php") ?>
		<title>Camagru - Home</title>
		<script src="/camagru/assets/js/themeSwitcher.js"></script>
	</head>
	<body>
		<div class="back" id="bg"></div>
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