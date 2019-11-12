<?php
	session_start();
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
			$paragraph = "You may now <a class='login' href='/camagru/login.php'>log in</a> to your account.";
		}
	}