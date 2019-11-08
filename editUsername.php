<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once("includes/links.php"); ?>
	<link rel="stylesheet" href="/camagru/assets/css/login.css">
	<link rel="stylesheet" href="/camagru/assets/css/animations.css">
	<title>Camagru - Edit profile</title>
	<script src="/camagru/assets/js/editUsername.js"></script>
</head>
<body id="body">
	<?php include_once("includes/navbar.php"); ?>
	<div class="container">
		<div class="jumbotron">
			<a href="javascript:history.back()" class="goback">
				<img src="/camagru/assets/images/goback.png" alt="go back" width="30" height="30">
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
</body>
</html>