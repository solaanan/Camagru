<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/session_expiry.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/config.php');

	try {
		$query = 'SELECT notif FROM users WHERE username=:username';
		$stmt = $pdo->prepare($query);
		$stmt->bindValue(':username', $_SESSION['userLoggedIn']);
		$stmt->execute();
		if ($stmt === false)
			return false;
	} catch (PDOException $e) {
		die ('Error: ' . $e->getMessage());
	}
	$oldnotif = $stmt->fetch()['notif'];
	$newnotif = $oldnotif === '1' ? '0' : '1';
	if (isset($_POST['notif'])) {
		try {
			$query = 'UPDATE users SET notif = :newnotif WHERE username=:username';
			$stmt = $pdo->prepare($query);
			$stmt->bindValue(':newnotif', $newnotif);
			$stmt->bindValue(':username', $_SESSION['userLoggedIn']);
			$stmt->execute();
			if ($stmt === false)
				return false;
		} catch (PDOException $e) {
			die ('Error: ' . $e->getMessage());
		}
	}