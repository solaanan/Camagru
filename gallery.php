<?php
	session_start();
	if (!isset($_SESSION) || !isset($_SESSION['userLoggedIn']))
		header('Location: /camagru/index.php');
	include_once('includes/config.php');
	include_once('includes/classes/Post.class.php');
	try {
		$query = "SELECT * FROM posts, users WHERE users.id=posts.user_id ORDER BY dateOfPub DESC";
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
	<?php include("includes/links.php") ?>
	<link rel="stylesheet" href="/camagru/assets/css/gallery.css">
	<link rel="stylesheet" href="/camagru/assets/css/animations.css">
	<script src="/camagru/assets/js/gallery.js"></script>
	<title>Camagru - Gallery</title>
</head>
<body>
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
		<?php put_posts($result, $pdo); ?>
	</div>
	<!-- <div class="alert-container">
		<div class="container">
			<div class="alert-card jumbotron text-center m-auto">
				<h1 class="text-break">Are you sure ?</h1>
				<hr>
				<p class="lead text-break">This action is irreversible!</p>
				<button class="btn btn-lg botona my-2 mx-4">
					<img src="/camagru/assets/images/good.png" alt="yes" width="30" height="30">
					Delete
				</button>
				<button class="btn btn-lg botona m-0 mx-4">
					<img src="/camagru/assets/images/bad.png" alt="no" width="30" height="30">
					Cancel
				</button>
			</div>
		</div>
	</div> -->
</div>
</body>
</html>