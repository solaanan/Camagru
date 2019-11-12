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
	<link rel="stylesheet" href="/camagru/assets/css/animations.css">
	<title>Camagru - Edit profile</title>
	<script src="/camagru/assets/js/editEmail.js"></script>
</head>
<body id="body">
	<?php include_once("includes/navbar.php"); ?>
	<div class="container">
		<div class="jumbotron">
			<a href="javascript:history.back()" class="goback">
				<img src="/camagru/assets/images/goback.png" alt="go back" width="30" height="30">
			</a>
			<h1 class="display-4"> Enter a new email address:</h1>
			<p class="lead">A confirmation of your new email address will be needed!</p>
			<form method="POST" action="editEmail.php" id="form">
				<input id="email1" name="newEmail" class="form-control form-control-lg inputt" type="text" placeholder="New email" required>
				<input id="email2" name="newEmail2" class="form-control form-control-lg inputt" type="text" placeholder="Re-type the new email" required>
				<button id="botona" name="editEmailButton" class="btn btn-primary botona"> 
					<div id="spinner" class="spinner-border"></div>
					<span id="save"> Save changes </span>
				</button>
			</form>
		</div>
	</div>
</body>
</html>