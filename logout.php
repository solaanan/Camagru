<?php
	session_start();
	if (!isset($_SESSION) || !isset($_SESSION['userLoggedIn']))
		header('Location: /camagru/index.php');
	unset($_SESSION['userLoggedIn']);
	session_unset();
	session_destroy();
	header("Location: index.php");