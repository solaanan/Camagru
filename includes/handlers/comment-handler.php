<?php
	if (!isset($_SESSION))
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/session_expiry.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/classes/Constants.class.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/classes/Post.class.php");

	$post = new Post($pdo);

	if (isset($_POST['newCommentButton'])) {
		$commentText = $_POST['newComment'];
		$post_id = $_POST['post_id'];
		if ($comment = $post->insertNewComment($commentText, $post_id)) {
			echo $comment;
		} else {
			echo 'nah';
		}
	}

	if (isset($_POST['deleteComment'])) {
		$comId = $_POST['commentId'];
		$postId = $_POST['postId'];
		if ($post->deleteComment($postId, $comId)) {
		} else {
			echo 'nah';
		}
	}