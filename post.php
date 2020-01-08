<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/session_expiry.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/classes/Post.class.php');
	
	$post = new Post($pdo);

	if (isset($_GET)) {
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			try {
				$query = 'SELECT username, profilePic, picture, publication, post_id, signUpDate FROM users INNER JOIN posts ON users.id = posts.user_id WHERE post_id=:id';
				$stmt = $pdo->prepare($query);
				$stmt->bindValue(':id', $id);
				$stmt->execute();
				if ($stmt === false)
					header('Location: /camagru/post?error=nopost');
		} catch (PDOException $e) {
			die ('There was an error communicating with the databases ' . $e);
		}
		if ($stmt->rowCount() < 1)
			header('Location: /camagru/post?error=nopost');
		$arroy = $stmt->fetch();
		} else
			header('Location /camagru/post?error=nopost');
	}
	?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/links.php') ?>
		<link rel="stylesheet" href="/camagru/assets/css/login.css">
		<link rel="stylesheet" href="/camagru/assets/css/gallery.css">
		<link rel="stylesheet" href="/camagru/assets/css/animations.css">
		<script src="/camagru/assets/js/postManagement.js"></script>
		<title>Document</title>
		<script src="/camagru/assets/js/themeSwitcher.js"></script>
	</head>
	<body id="body">
		<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/navbar.php') ?>
		<div class="everything">
			<div id="messages"></div>
			<div class="container">
				<?php 
				if (!isset($_GET['error']) && isset($_GET['id']))
				$post->putPost($arroy);
				else { ?>
				<div class="jumbotron mx-auto" style="text-align:center">
				<img src="/camagru/assets/images/icons-dark/bad.png" class ="bad" alt="error" width="200" height="200">
					<h1 class="display-4">Post not found !</h1>
					<hr>
					<p class="lead">We cannot find any post for you</p>
				</div>
				<?php } ?>
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
		<div class="loading-container" id="loading" style="display: flex;">
			<!-- <div class="spinner-border m-auto" style="color: white;"></div> -->
			<svg class="logo-svg" width="142" height="142" viewBox="0 0 142 142" fill="none" xmlns="http://www.w3.org/2000/svg">
				<rect x="0.5" y="0.5" width="141" height="141" rx="25.5" stroke="white"/>
				<circle cx="71.0001" cy="71" r="42.5656" stroke="white"/>
				<circle cx="70.9999" cy="71" r="33.2541" stroke="white"/>
				<circle cx="120.602" cy="19.3398" r="7.06557" stroke="white"/>
				<rect x="0.5" y="33.0901" width="8.31148" height="75.8197" rx="4.15574" stroke="white"/>
			</svg>
		</div>
	</body>
</html>