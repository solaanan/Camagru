<?php
		$error ='
				<html>
					<head>
					<link rel="stylesheet" href="/camagru/assets/css/global.css">
					</head>
					<body>
						<h1 style="text-align:center;margin-top:100px">ERROR 401: Unauthorized</h1><hr>
						<p style="text-align:center;margin-top:20px">Sir T9awed, get a fokin life.</p>
						<p style="margin:auto;text-align:center;display:block;position:absolute;bottom:0">Admin: Holk</p>
					</body>
				</html>';
	if (!isset($_SERVER['PHP_AUTH_USER'])) {
		header('WWW-Authenticate: Basic realm="My Realm"');
		header('HTTP/1.0 401 Unauthorized');
		echo $error;
		exit;
	} else {
		if ($_SERVER['PHP_AUTH_USER'] !== 'slaanani' || $_SERVER['PHP_AUTH_PW'] !== 'I09m13G07o15@@') {
			header('HTTP/1.0 401 Unauthorized');
			echo $error;
			exit;
		}
	}




	session_start();
	if (isset($_SESSION) && isset($_SESSION['userLoggedIn'])) {
		header('Location: /camagru/gallery');
	}
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