<?php
	session_start();
	if (!isset($_SESSION) || !isset($_SESSION['userLoggedIn'])) {
		header('Location: /camagru');
	}
	include_once('config.php');
	include_once('classes/Post.class.php');
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
	$post = new Post($pdo);
	if ($result) {
		foreach ($result as $element) {
			$post->putPost($element);
		}
	} else {
		// echo '<img class="nothing" src="/camagru/assets/images/nothing.png">';
	}