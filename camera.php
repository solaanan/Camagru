<?php
	session_start();
	if (!isset($_SESSION) || !isset($_SESSION['userLoggedIn']))
		header('Location: /camagru/index.php');
	include_once('includes/config.php');
	include_once('includes/classes/Post.class.php');
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
	<?php include_once("includes/links.php") ?>
	<title>Camagru - Take a new photo</title>
	<link rel="stylesheet" href="/camagru/assets/css/animations.css">
	<link rel="stylesheet" href="/camagru/assets/css/camera.css">
	<link rel="stylesheet" href="/camagru/assets/css/gallery.css">
	<script src="/camagru/assets/js/postManagement.js"></script>
</head>
<body id="body">
	<?php include_once("includes/navbar.php") ?>
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
					<div class="arrowsContainer">
						<img src="/camagru/assets/images/left.png" alt="previous" width="30" height="30" class="previous" id="previous">
						<img src="/camagru/assets/images/right.png" alt="next" width="30" height="30" class="next" id="next">
					</div>
					<button id="snap" class="botona">
						<img src="/camagru/assets/images/snap.png" alt="snap" width="25" height="20">
						Snap
					</button>
					<img class="preview" id="img" alt="preview">
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
				<div id="postsContainer">
					<?php $loggedin = true; include_once('includes/refresh_posts.php') ?>
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