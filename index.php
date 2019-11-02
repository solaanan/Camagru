<?php
	session_abort();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="icon" href="http://localhost/assets/images/logo.ico">
		<link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="http://localhost/Camagru/assets/frameworks/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="http://localhost/Camagru/assets/css/global.css">
		<link rel="stylesheet" href="http://localhost/Camagru/assets/css/home.css">
		<title>Camagru - Home</title>
	</head>
	<body>
		<div class="back"></div>
		<?php include("includes/navbar.php") ?>
		<div class="container">
			<div class="jumbotron">
			<h1 class="display-4">Welcome to Camagru !</h1>
			<p class="lead">In 1794, Claude Chappe tried to resolve the issue of long-distance communication,
				that was limited to horse speed at that time. He set up an ingenious communication
				system of air telegraph during the French Revolution. Chappe’s “tours” (towers) were
				covered by a mobile mast that could be seen with binoculars from the nearest neighbor
				tower located at approximately 10 to 15 km.</p>
			<hr class="my-4">
			<p>Fortunately, we are in the 21st century.</p>
			<a class="btn btn-primary btn-lg botona" href="http://localhost/camagru/register.php" role="button">Get Started</a>
		  </div>
	</div>
</body>
</html>