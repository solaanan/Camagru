<?php
	session_start();
	if (!isset($_SESSION) || !isset($_SESSION['userLoggedIn']))
		header('Location: /camagru/index.php');
	if (isset($_GET['id']) && $_GET['id'] === session_id()) {
		unset($_SESSION['userLoggedIn']);
		session_unset();
		session_destroy();
		header("Location: index.php");
	} else {
		header('Location: /camagru/gallery');
	}