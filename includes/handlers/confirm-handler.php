<?php
	if (!isset($_SESSION))
		session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/session_expiry.php');
	$img = "bad.png";
	$header = "Something went wrong!";
	$paragraph = "Unexpected error was ocurred during your email confirmation process.";
	if ($token_get = $_GET['token']) {
		$stmt = $pdo->prepare("SELECT * FROM users WHERE token=:tok");
		$stmt->execute([":tok" => $token_get]);
		$array = $stmt->fetch();
		if ($array["token"] == $token_get) {
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