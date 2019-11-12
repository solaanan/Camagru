<?php
	session_start();
	if (isset($_POST['loginButton']))
	{
		session_start();
		$username = $_POST['loginUsername'];
		$password = $_POST['loginPassword'];
		$result = $account->login($username, $password);
		if ($result)
		{
			$_SESSION['userLoggedIn'] = $username;
			header("Location: gallery.php");
		}
	}