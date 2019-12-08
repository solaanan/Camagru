<?php
	session_start();
	if (!isset($_SESSION) || !isset($_SESSION['userLoggedIn']))
		header('Location: /camagru/index.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once("includes/links.php"); ?>
	<link rel="stylesheet" href="/camagru/assets/css/login.css">
	<title>Camagru - Edit profile</title>
	<script src="/camagru/assets/js/editPassword.js"></script>
	<script src="/camagru/assets/js/themeSwitcher.js"></script>
</head>
<body id="body">
	<?php include_once("includes/navbar.php"); ?>
	<div class="container">
		<div class="jumbotron">
			<a href="javascript:history.back()" class="goback">
				<img src="/camagru/assets/images/icons-dark/goback.png" alt="go back" width="30" height="30">
			</a>
			<h1 class="display-4">Change your password:</h1>
			<form id="form" method="POST" action="editPassword.php">
			<input id="oldpw" name="previousPasswd" class="form-control form-control-lg inputt" type="password" placeholder="Actual password" required>
			<input id="pw1" name="newPasswd" class="form-control form-control-lg inputt" type="password" placeholder="New password" required>
			<input id="pw2" name="newPasswd2" class="form-control form-control-lg inputt" type="password" placeholder="Re-type the new password" required>
			<button name="editPasswdButton" id="botona" class="btn btn-primary botona">
				<div id="spinner" class="spinner-border"></div>
				<span id="save"> Save changes </span>
			</button>
			</form>
		</div>
	</div>
</body>
</html>