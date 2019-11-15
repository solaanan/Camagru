<?php
	if (!isset($_SESSION))
		session_start();
	include_once("../config.php");
	include_once("../classes/Constants.class.php");
	include_once("../classes/Account.class.php");
	$account = new Account($pdo);
	/* ******************************************************* */
	/*                          USERNAME                       */
	/* ******************************************************* */
	if (isset($_POST['editUsernameButton']))
	{
		$un = $_POST['newUsername'];
		$status = $account->updateUsername($_SESSION['userLoggedIn'], $un);
		if ($status)
		{
			echo "All good";
			$_SESSION['userLoggedIn'] = $un;
		}
		else
			$account->getErrors();
	}

	/* ******************************************************* */
	/*                            EMAIL                        */
	/* ******************************************************* */
	if (isset($_POST['editEmailButton']))
	{
		$em = $_POST['newEmail'];
		$em2 = $_POST['newEmail2'];
		$status = $account->updateEmail($_SESSION['userLoggedIn'], $em, $em2);
		if ($status)
			echo "All good";
		else
			$account->getErrors();
	}

	/* ******************************************************* */
	/*                           PASSWD                        */
	/* ******************************************************* */
	if (isset($_POST['editPasswdButton']))
	{
		$old = $_POST['previousPasswd'];
		$pw = $_POST['newPasswd'];
		$pw2 = $_POST['newPasswd2'];
		$status = $account->updatePassword($_SESSION['userLoggedIn'], $old, $pw, $pw2);
		if ($status)
			echo "All good";
		else
			$account->getErrors();
	}

	/* ******************************************************* */
	/*                          PICTURE                        */
	/* ******************************************************* */
	if (isset($_POST['newPicture']))
	{
		$base64 = $_POST["newPicture"];
		$status = $account->updateProfilePic($_SESSION['userLoggedIn'], $base64);
		if ($status)
			echo "All good";
		else
			$account->getErrors();
	}

	if (isset($_POST['imageError'])) {
		echo Constants::$imageCannotBeFound;
	}

	if (isset($_POST['big'])) {
		echo Constants::$imageTooBig;
	}