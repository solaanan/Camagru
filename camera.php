<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/session_expiry.php');
	if (!isset($_SESSION) || !isset($_SESSION['userLoggedIn']))
		header('Location: /camagru/index.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/classes/Post.class.php');
	try {
		$query = "SELECT * FROM users, posts WHERE users.id=posts.user_id AND username=:username ORDER BY dateOfPub DESC";
		$stmt = $pdo->prepare($query);
		$stmt->bindValue(':username', $_SESSION['userLoggedIn']);
		$stmt->execute();
		if ($stmt === false)
			die('An error occured communicating with the databases');
	} catch (PDOException $e) {
		die('An error occured communicating with the databases');
	}
	$result = $stmt->fetchAll();
	function put_posts($arr, $pdo) {
		$post = new Post($pdo);
		foreach ($arr as $element) {
			$post->putPost($element);
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/links.php") ?>
	<title>Camagru - Take a new photo</title>
	<link rel="stylesheet" href="/camagru/assets/css/animations.css">
	<link rel="stylesheet" href="/camagru/assets/css/camera.css">
	<link rel="stylesheet" href="/camagru/assets/css/gallery.css">
	<script src="/camagru/assets/js/postManagement.js"></script>
	<script src="/camagru/assets/js/themeSwitcher.js"></script>
</head>
<body id="body">
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/navbar.php") ?>
	<div class="everything">
		<div id="messages"></div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-1 col-md-1"></div>
				<div class="colona col-xs-12 col-md-5">
					<div class="element jumbotron">
						<h1 class="h2 text-break">Smile at the camera!</h1>
						<div class="stickerContainer">
							<img class="sticker" src="/camagru/assets/images/stickers/sticker-0.png" alt="sticker" id="sticker">
						</div>
						<video id="video" class="video" autoplay>yes</video>
						<img class="preview" id="img" alt="preview">
						<div class="arrowsContainer" id="arrowsContainer">
							<img src="/camagru/assets/images/icons-dark/left.png" alt="previous" width="30" height="30" class="previous" id="previous">
							<img src="/camagru/assets/images/icons-dark/right.png" alt="next" width="30" height="30" class="next" id="next">
						</div>
						<button id="snap" class="botona">
							<img src="/camagru/assets/images/snap.png" alt="snap" width="25" height="20">
							Snap
						</button>
						<button id="say" class="botona say">
							<img src="/camagru/assets/images/say.png" alt="say" width="20" height="20">
							Say something
						</button>
						<textarea id="pub" name="pub" class="inputt" placeholder="What's on your mind today?"></textarea>
						<button id="save" class="botona">
							<img src="/camagru/assets/images/save.png" alt="save" width="20" height="20">
							Save
						</button>
						<button id="retake" class="botona">
							<img src="/camagru/assets/images/retake.png" alt="retake" width="20" height="20">
							Retake
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
	<div class="container-fluid">
			<div class="row">
				<div class="col-xs-1 col-md-1"></div>
				<div class="colona col-xs-12 col-md-5 loading2">
					<div class="element jumbotron">
						<div class="h2 text-break loading" style="width:50%; height:40px; margin:auto"></div>
						<img id="dropImg" src="/camagru/assets/images/icons-dark/upload.png" alt="snap" width="60" height="60">
						<h1 class="h2 text-break" id="dropHeading">Drop your image here!</h1>
							<div class="label botona loading" style="display:table">
								<img src="/camagru/assets/images/upload_file.png" alt="snap" width="25" height="20" style="visibility:hidden">
								<span style="visibility:hidden">Upload</span>
							</div>
					</div>
				</div>
				<div class="col-xs-1 col-md-1"></div>
				<div class="colona posts col-xs-6 col-md-4">
					<div class="h2 text-break loading" style="width:50%; height:40px"></div>
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
							</img>
						</div>
					</div>
				</div>
				<div class="col-xs-1 col-md-1"></div>
			</div>
		</div>
	</div>
</body>
</html>