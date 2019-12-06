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
		$stickerIndex = isset($_POST['index']) ? $_POST['index'] : 0;

		if ($id = $post->post($un, $pub, $base64, $stickerIndex)) {
			echo 'All good';
			try {
				$query = 'SELECT username, profilePic, picture, publication, post_id, signUpDate FROM users INNER JOIN posts ON users.id = posts.user_id WHERE post_id=:post_id';
				$stmt = $pdo->prepare($query);
				$stmt->bindValue(':post_id', $id);
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOException $e) {
				die ('There was an error communicating with the databases ' . $e);
			}
			$array = $stmt->fetch();
			$post->putPost($array);
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
		$index = isset($_POST['index']) ? $_POST['index'] : 0;
		if ($base64 === 'error') {
			echo Constants::$imageCannotBeFound;
		} else {
			if ($id = $post->post($_SESSION['userLoggedIn'], $pub, $base64, $index)) {
				echo 'All good';
				try {
					$query = 'SELECT username, profilePic, picture, publication, post_id, signUpDate FROM users INNER JOIN posts ON users.id = posts.user_id WHERE post_id=:post_id';
					$stmt = $pdo->prepare($query);
					$stmt->bindValue(':post_id', $id);
					$stmt->execute();
					if ($stmt === false)
						return false;
				} catch (PDOException $e) {
					die ('There was an error communicating with the databases ' . $e);
				}
				$array = $stmt->fetch();
				$post->putPost($array);
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