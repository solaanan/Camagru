<?php
	if (!isset($_SESSION))
		session_start();
	if (isset($_POST['loginButton']))
	{
		$username = $_POST['loginUsername'];
		$username = trim($username);
		$username = htmlspecialchars($username);
		$password = $_POST['loginPassword'];
		$password = trim($password);
		$password = htmlspecialchars($password);
		$result = $account->login($username, $password);
		if ($result)
		{
			$_SESSION['userLoggedIn'] = $username;
			header("Location: gallery.php");
		}
	}