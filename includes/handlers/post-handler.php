<?php
	session_start();
	include_once("../config.php");
	include_once("../classes/Constants.class.php");
	include_once("../classes/Post.class.php");

	$post = new Post($pdo);

	if (isset($_POST['saveButton'])) {
		$pub = $_POST['publication'];
		$base64 = $_POST['pictureData'];
		$un = $_SESSION['userLoggedIn'];

		if ($post->post($un, $pub, $base64))
			echo 'All good';
		else
			$post->getErrors();
	}

	if (isset($_POST['hitLike'])) {
		$post_id = $_POST['hitLike'];
		if ($post->likeChecker($post_id)) {
			if ($post->unlike($post_id)) {
				echo 'All good';
			} else {
				echo 'nah';
			}
		} else {
			if ($post->like($post_id)) {
				echo 'All good';
			} else {
				echo 'nah';
			}
		}
	}

	if (isset($_POST['picture']) && isset($_POST['publication'])) {
		$base64 = $_POST['picture'];
		$pub = $_POST['publication'];

		if ($post->post($_SESSION['userLoggedIn'], $pub, $base64)) {
			echo 'All good';
		} else {
			$post->getErrors();
		}
	}