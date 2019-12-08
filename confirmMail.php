<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include("includes/links.php") ?>
	<link rel="stylesheet" href="/camagru/assets/css/confirmMail.css">
	<script src="/camagru/assets/js/themeSwitcher.js"></script>
	<title>Camagru - Confirm your email address</title>
</head>
<body>
	<div class="back">
		<?php include("includes/navbar.php") ?>
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
</body>
</html>