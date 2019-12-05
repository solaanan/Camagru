<?php
	if (!isset($_SESSION))
		session_start();
	include_once("../config.php");
	include_once("../classes/Constants.class.php");
	include_once("../classes/Post.class.php");

	$post = new Post($pdo);

	if (isset($_POST['saveButton'])) {
		$pub = $_POST['publication'];
		$base64 = $_POST['pictureData'];
		$un = $_SESSION['userLoggedIn'];
		$stickerIndex = $_POST['index'];

		if ($post->post($un, $pub, $base64, $stickerIndex)) {
			echo 'All good';
			$loggedin = true;
			include_once('../refresh_posts.php');
		} else
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

	if (isset($_POST['doubleHitLike'])) {
		$post_id = $_POST['doubleHitLike'];
		if (!$post->likeChecker($post_id)) {
			if (!$post->like($post_id))
				echo 'nah';
		}
		echo 'All good';
	}

	if (isset($_POST['picture']) && isset($_POST['publication'])) {
		$base64 = $_POST['picture'];
		$pub = $_POST['publication'];
		$index = $_POST['index'];
		if ($base64 === 'error') {
			echo Constants::$imageCannotBeFound;
		} else {
			if ($post->post($_SESSION['userLoggedIn'], $pub, $base64, $index)) {
				echo 'All good';
			} else {
				$post->getErrors();
			}
		}
	}

	if (isset($_POST['big'])) {
		echo Constants::$imageTooBig;
	}

	if (isset($_POST['delete']) && $_POST['post_id']) {
		$post_id = $_POST['post_id'];
		if ($post->deletePost($post_id)) {
			echo 'All good';
		}
	}