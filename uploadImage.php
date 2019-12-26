<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/session_expiry.php');
	if (!isset($_SESSION) || !isset($_SESSION['userLoggedIn']))
		header('Location: /camagru/index');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/classes/Post.class.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/links.php'); ?>
	<link rel="stylesheet" href="/camagru/assets/css/animations.css">
	<link rel="stylesheet" href="/camagru/assets/css/camera.css">
	<link rel="stylesheet" href="/camagru/assets/css/gallery.css">
	<script src="/camagru/assets/js/postManagement.js"></script>
	<title>Camagru - Upload a new Image</title>
	<script src="/camagru/assets/js/themeSwitcher.js"></script>
</head>
<body id='body'>
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/navbar.php'); ?>
	<div class="everything">
		<div id="messages"></div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-1 col-md-1"></div>
				<div class="colona col-xs-12 col-md-5">
					<div class="element jumbotron" id="element">
						<h1 class="h2 text-break" id="uploadHeading">Upload a new image!</h1>
						<div id="spinner" class="spinner-border m-auto"></div>
						<img id="dropImg" src="/camagru/assets/images/icons-dark/upload.png" alt="snap" width="60" height="60">
						<h1 class="h2 text-break" id="dropHeading">Drop your image here!</h1>
						<form action="uploadImage.php" id="form" method="post">
							<input type="file" name="imageFile" id="fileInput" enctype="multipart/form-data" accept="image/*">
							<label for="fileInput" class="label botona" id="uploadBotona">
								<img id="upload_img" src="/camagru/assets/images/upload_file.png" alt="snap" width="25" height="20">
								Upload
							</label>
						</form>
						<div class="stickerContainer">
							<img class="sticker" src="/camagru/assets/images/stickers/sticker-0.png" alt="sticker" id="sticker">
						</div>
						<img class="preview" id="preview" alt="preview">
						<div id="arrowsContainer" class="arrowsContainer" style="display:none">
							<img src="/camagru/assets/images/icons-dark/left.png" alt="previous" width="30" height="30" class="previous" id="previous">
							<img src="/camagru/assets/images/icons-dark/right.png" alt="next" width="30" height="30" class="next" id="next">
						</div>
						<button id="say" class="botona say">
							<img src="/camagru/assets/images/say.png" alt="say" width="20" height="20">
							Say something
						</button>
						<textarea id="pub" name="pub" class="inputt" placeholder="What's on your mind today?"></textarea>
						<button id="save" class="botona">
							<img src="/camagru/assets/images/save.png" alt="save" width="20" height="20">
							Save
						</button>
						<button id="cancell" class="botona">
							<img src="/camagru/assets/images/retake.png" alt="retake" width="20" height="20">
							Cancel
						</button>
					</div>
				</div>
				<div class="col-xs-1 col-md-1"></div>
				<div class="colona posts col-xs-6 col-md-4">
					<h1 class="h2 text-break">Your recent posts:</h1>
					<div id="userPostsContainer">
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
						<img src="/camagru/assets/images/icons-dark/good.png" alt="yes" width="30" height="30">
						Delete
					</button>
					<button class="btn btn-lg botona m-0 mx-4" id="cancel">
						<img src="/camagru/assets/images/icons-dark/bad.png" alt="no" width="30" height="30">
						Cancel
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="loading-container" id="loading" style="display: flex;">
		<div class="spinner-border m-auto" style="color: white;"></div>	
	</div>
</body>
</html>