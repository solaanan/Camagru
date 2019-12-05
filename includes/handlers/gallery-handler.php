<?php
	session_start();
	include_once('../config.php');
	include_once('../classes/Post.class.php');

	$post = new Post($pdo);

	if (isset($_POST['username']) && $_POST['username'] !== '' && $_POST['username'] !== 'undefined') 
		$un = $_POST['username'];
	else
		$un = $_SESSION['userLoggedIn'];
	$subquery = '';
	if (isset($_POST['loggedin']))
		$subquery = 'WHERE username=:username';
	if (isset($_POST['getData'])) {
		$start = $_POST['start'];
		$limit = $_POST['limit'];
		try {
			$query = "SELECT username, profilePic, picture, publication, post_id, signUpDate FROM users INNER JOIN posts ON users.id = posts.user_id " . $subquery . " ORDER BY dateOfPub DESC LIMIT :startt, :limitt";
			$stmt = $pdo->prepare($query);
			if (isset($_POST['loggedin']))
			$stmt->bindValue(':username', $un);
			$stmt->bindValue(':startt', (int)$start, PDO::PARAM_INT);
			$stmt->bindValue(':limitt', (int)$limit, PDO::PARAM_INT);
			$stmt->execute();
			if ($stmt === false)
				die('An error occured communicating with the databases');
		} catch (PDOException $e) {
			die('An error occured communicating with the databases');
		}
		if ($stmt->rowCount() > 0)
		{
			$reponse = "";
			$array = $stmt->fetchAll();
			foreach ($array as $element) {
				$reponse .= $post->putPost($element);
			}
			exit($reponse);
		} else {
			exit('reachedLimit');
		}
	}