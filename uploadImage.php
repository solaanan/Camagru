<?php
	session_start();
	if (!isset($_SESSION) || !isset($_SESSION['userLoggedIn']))
		header('Location: /camagru/index');
	include_once('includes/config.php');
	include_once('includes/classes/Post.class.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once('includes/links.php'); ?>
	<link rel="stylesheet" href="/camagru/assets/css/gallery.css">
	<link rel="stylesheet" href="/camagru/assets/css/camera.css">
	<script src="/camagru/assets/js/imageUploader.js"></script>
	<script src="/camagru/assets/js/deleteHandlerInPersonal.js"></script>
	<title>Camagru - Upload a new Image</title>
</head>
<body id='body'>
	<?php include_once('includes/navbar.php'); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-1 col-md-1"></div>
			<div class="colona col-xs-12 col-md-5">
				<div class="element jumbotron" id="element">
					<h1 class="h2 text-break">Upload a new image!</h1>
					<div id="spinner" class="spinner-border m-auto"></div>
					<form action="uploadImage.php" id="form" method="post">
						<input type="file" name="imageFile" id="fileInput" enctype="multipart/form-data" accept="image/*">
						<label for="fileInput" class="label botona" id="botona">
							<img id="upload_img" src="/camagru/assets/images/upload_file.png" alt="snap" width="25" height="20">
							<span id="upload_text"> Upload </span>
						</label>
					</form>
					<img class="preview" id="preview" alt="preview">
					<button id="say" class="botona say">
						<img src="/camagru/assets/images/say.png" alt="say" width="20" height="20">
						Say something
					</button>
					<textarea id="pub" name="pub" class="inputt" placeholder="What's on your mind today?"></textarea>
					<button id="save" class="botona">
						<img src="/camagru/assets/images/save.png" alt="save" width="20" height="20">
						Save
					</button>
				</div>
			</div>
			<div class="col-xs-1 col-md-1"></div>
			<div class="colona posts col-xs-6 col-md-4">
				<h1 class="h2 text-break">Your recent posts:</h1>
				<div id="postsContainer">
					<?php $loggedin = true; include_once('includes/refresh_posts.php'); ?>
				</div>
			</div>
			<div class="col-xs-1 col-md-1"></div>
		</div>
	</div>
	<canvas id="canvas"></canvas>
	<div class="alert-container" id="alert-container">
		<div class="container" id="alert-body">
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
</body>
</html>