<?php
	if (!isset($_SESSION))
		session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/session_expiry.php');
	$img = "bad.png";
	$header = "Something went wrong!";
	$paragraph = "Unexpected error was ocurred during your email confirmation process.";
	if (isset($_GET['token'])) {
		$token_get = $_GET['token'];
		try {
			$query = 'SELECT * FROM users WHERE token=:token';
			$stmt = $pdo->prepare($query);
			$stmt->bindValue(':token', $token_get);
			$stmt->execute();
			if ($stmt === false)
				die();
		} catch (PDOException $e) {
			die ('Error: ' . $e->getMessage());
		}
		$array = $stmt->fetch();
		if ($array !== false && $array["token"] === $token_get) {
			$stmt = $pdo->prepare("UPDATE users SET token='' WHERE id = :id");
			$stmt->execute([":id" => $array["id"]]);
			$img = "good.png";
			$header = "Email confirmed successfully!";
			if (isset($_SESSION['userLoggedIn']) && !empty($_SESSION['userLoggedIn']))
				$paragraph = 'Go to <a class="login" href="/camagru/gallery.php">Gallery</a>';
			else
				$paragraph = "You may now <a class='login' href='/camagru/login.php'>log in</a> to your account.";
		}
	}