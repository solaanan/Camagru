<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/session_expiry.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/links.php") ?>
	<link rel="stylesheet" href="/camagru/assets/css/login.css">
	<link rel="stylesheet" href="/camagru/assets/css/gallery.css">
	<link rel="stylesheet" href="/camagru/assets/css/animations.css">
	<script src="/camagru/assets/js/postManagement.js"></script>
	<script src="/camagru/assets/js/themeSwitcher.js"></script>
	<title>Camagru - Gallery</title>
</head>
<body id='body'>
	<?php include($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/navbar.php"); ?>
	<div class="everything" style="display:none">
		<div id="messages"></div>
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
		<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/footer.php') ?>
	</div>
	<div class="loading-container" id="loading" style="display: flex;">
		<div class="container">
				<div class="jumbotron top-jumbotron text-center mx-auto loading2">
					<a class="loading btn btn-primary btn-lg botona m-1 text-break click">
						<img src="/camagru/assets/images/snap.png" alt="take a photo" width="25" height="20" style="visibility: hidden">
						<span style="visibility: hidden">Take a photo</span>
					</a>
					<a class="btn btn-primary btn-lg botona m-1 text-break click loading">
						<img src="/camagru/assets/images/upload_file.png" alt="upload" width="20" height="20"style="visibility: hidden">
						<span style="visibility: hidden">Upload a photo</span>
					</a>
				</div>
				<div>
					<div class="jumbotron py-3 px-3 mx-auto post loading2">
					<a class="text-decoration-none text-reset click">
						<img class="profilepic" src="/camagru/assets/images/icons-dark/blank-pdp.png" width="30" height="30" class="d-inline-block align-top" >
						<span class="text loading" style="width:20%; height:20px; display:inline-block;  vertical-align:middle"> </span>
						<span class="badge badge-secondary new-badge loading" style="width:50px; height:20px; display:inline-block;  vertical-align:middle; border-radius:10px; transition-duration: none"></span>
						</a>
						<hr class="separator loading">
						<p class="text-break loading" style="width:50%; height:20px; display:inline-block;  vertical-align:middle"></p>
						<div class="heartContainer"></div>
						<img class="loading postImg" src="/camagru/assets/images/icons-dark/blank-post.png">
						<hr class="loading separator">
						<img class="loading" src="/camagru/assets/images/icons-dark/blank-icon.png" width="33" height="30" style="border-radius:200px"><span class="loading" style="width:50px; height:20px; display:inline-block; margin-left:10px; vertical-align:middle"></span>
						<img class="loading" src="/camagru/assets/images/icons-dark/blank-icon.png" width="33" height="30" style="border-radius:200px"><span  class="loading" style="width:50px; height:20px; display:inline-block; margin-left:10px; vertical-align:middle"></span>
						<img class="loading" src="/camagru/assets/images/icons-dark/blank-icon.png" width="33" height="30" style="border-radius:200px">
					</div>
				</div>
			</div>
	</div>
</body>
</html>