<?php
	session_start();
	if (!isset($_SESSION) || !isset($_SESSION['userLoggedIn']))
		header('Location: /camagru/index.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/session_expiry.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/links.php"); ?>
	<link rel="stylesheet" href="/camagru/assets/css/login.css">
	<link rel="stylesheet" href="/camagru/assets/css/animations.css">
	<title>Camagru - Edit profile</title>
	<script src="/camagru/assets/js/editUsername.js"></script>
	<script src="/camagru/assets/js/themeSwitcher.js"></script>
</head>
<body id="body">
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/navbar.php"); ?>
	<div class="everything">
		<div class="container">
			<div class="jumbotron">
				<a href="javascript:history.back()" class="goback">
					<img src="/camagru/assets/images/icons-dark/goback.png" alt="go back" width="30" height="30">
				</a>
				<h1 class="display-4"> Enter a new username:</h1>
				<form action="editUsername.php" method="POST" id="form">
					<input id="username" name="newUsername" class="form-control form-control-lg inputt" type="text" placeholder="New Username" required>
					<button id="botona" name="editUsernameButton" type="submit" class="btn btn-primary botona">
						<div id="spinner" class="spinner-border"></div>
						<span id="save"> Save changes </span>
					</button>
				</form>
			</div>
		</div>
	</div>
	<div class="loading-container" id="loading" style="display: flex;">
		<div class="spinner-border m-auto" style="color: white;"></div>	
	</div>
</body>
</html>