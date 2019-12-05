<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include("includes/links.php") ?>
	<link rel="stylesheet" href="/camagru/assets/css/login.css">
	<link rel="stylesheet" href="/camagru/assets/css/gallery.css">
	<link rel="stylesheet" href="/camagru/assets/css/animations.css">
	<script src="/camagru/assets/js/postManagement.js"></script>
	<title>Camagru - Gallery</title>
</head>
<body id='body'>
	<?php include("includes/navbar.php"); ?>
	<div class="container">
		<?php if (isset($_SESSION) && isset($_SESSION['userLoggedIn'])) { ?>
		<div class="jumbotron top-jumbotron text-center mx-auto">
			<a class="btn btn-primary btn-lg botona m-1 text-break click" href="/camagru/camera" role="button">
				<img src="/camagru/assets/images/snap.png" alt="take a photo" width="25" height="20">
				Take a photo
			</a>
			<a class="btn btn-primary btn-lg botona m-1 text-break click" href="/camagru/uploadImage" role="button">
				<img src="/camagru/assets/images/upload_file.png" alt="upload" width="20" height="20">
				Upload a photo
			</a>
		<?php } ?>
		</div>
		<div id="postsContainer">
		</div>
	</div>
	<div class="alert-container" id="alert-container">
		<div class="container" id="alert-body">
			<div class="alert-card jumbotron text-center m-auto">
				<h1 class="text-break">Are you sure ?</h1>
				<hr>
				<p class="lead text-break">Do you really want to delete this post?<br>This action is irreversible!</p>
				<button class="btn btn-lg botona my-2 mx-4 click" id="delete">
					<img src="/camagru/assets/images/good.png" alt="yes" width="30" height="30">
					Delete
				</button>
				<button class="btn btn-lg botona m-0 mx-4 click" id="cancel">
					<img src="/camagru/assets/images/bad.png" alt="no" width="30" height="30">
					Cancel
				</button>
			</div>
		</div>
	</div>
</body>
</html>