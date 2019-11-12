<?php
	session_start();
	if (!isset($_SESSION) || !isset($_SESSION['userLoggedIn']))
		header('Location: /camagru/index.php');
	include_once('includes/config.php');
	include_once('includes/classes/Like.class.php');
	include_once('includes/classes/Post.class.php');

	$like = new Like($pdo);
	$post = new Post($pdo);

	$post->deletePost($_GET['post_id']);