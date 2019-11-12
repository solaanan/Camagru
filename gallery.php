<?php
	session_start();
	if (!isset($_SESSION) || !isset($_SESSION['userLoggedIn']))
		header('Location: /camagru/index.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include("includes/links.php") ?>
	<link rel="stylesheet" href="/camagru/assets/css/gallery.css">
	<link rel="stylesheet" href="/camagru/assets/css/animations.css">
	<script src="/camagru/assets/js/gallery.js"></script>
	<title>Camagru - Gallery</title>
</head>
<body id='body'>
	<?php include("includes/navbar.php"); ?>
	<div class="container">
		<div class="jumbotron top-jumbotron text-center mx-auto">
			<a class="btn btn-primary btn-lg botona m-1 text-break" href="/camagru/camera" role="button">
				<img src="/camagru/assets/images/snap.png" alt="take a photo" width="25" height="20">
				Take a photo
			</a>
			<a class="btn btn-primary btn-lg botona m-1 text-break" href="/camagru/uploadImage" role="button">
				<img src="/camagru/assets/images/upload_file.png" alt="upload" width="20" height="20">
				Upload a photo
			</a>
		</div>
		<div id="postsContainer">
			<?php include_once('includes/refresh_posts.php'); ?>
		</div>
	</div>
	<div class="alert-container" id="alert-container">
		<div class="container">
			<div class="alert-card jumbotron text-center m-auto">
				<h1 class="text-break">Are you sure ?</h1>
				<hr>
				<p class="lead text-break">Do you really want to delete this post?<br>This action is irreversible!</p>
				<button class="btn btn-lg botona my-2 mx-4" id="delete">
					<img src="/camagru/assets/images/good.png" alt="yes" width="30" height="30">
					Delete
				</button>
				<button class="btn btn-lg botona m-0 mx-4" id="cancel">
					<img src="/camagru/assets/images/bad.png" alt="no" width="30" height="30">
					Cancel
				</button>
			</div>
		</div>
	</div>
</div>
</body>
</html>