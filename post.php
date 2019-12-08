<?php
	session_start();
	include_once('includes/config.php');
	include_once('includes/classes/Post.class.php');
	
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
		<?php include_once('includes/links.php') ?>
		<link rel="stylesheet" href="/camagru/assets/css/login.css">
		<link rel="stylesheet" href="/camagru/assets/css/gallery.css">
		<link rel="stylesheet" href="/camagru/assets/css/animations.css">
		<script src="/camagru/assets/js/postManagement.js"></script>
		<title>Document</title>
		<script src="/camagru/assets/js/themeSwitcher.js"></script>
	</head>
	<body>
		<?php include_once('includes/navbar.php') ?>
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
</body>
</html>