<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/config.php');
	session_start();
	
	if (isset($_POST['deleteUser']) && $_POST['deleteUser'] === 'true') {
		try {
			$query = 'DELETE FROM users WHERE username=:username';
			$stmt = $pdo->prepare($query);
			$stmt->bindValue(':username', $_SESSION['userLoggedIn']);
			$stmt->execute();
			if ($stmt === false)
				return ;
		} catch (PDOException $e) {
			die ('There was a problem communicating with the databases: ' . $e->getMessage());
		}
		unset($_SESSION['userLoggedIn']);
		unset($_SESSION['LAST_ACTIVITY']);
		session_unset();
		session_destroy();
		session_start();
		exit('success');
	}