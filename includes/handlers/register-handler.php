<?php
	session_start();
	function	sanitizeFormUsername($un) {
		$un = trim($un);
		$un = strip_tags($un);
		return $un;
	}

	function	sanitizeFormEmail($em) {
		$em = trim($em);
		$em = strip_tags($em);
		return $em;
	}

	function	sanitizeFormPassword($p) {
		$p = strip_tags($p);
		return $p;
	}

	if (isset($_POST['registerButton'])) {
		$username = sanitizeFormUsername($_POST['registerUsername']);
		$email1 = sanitizeFormEmail($_POST['registerEmail']);
		$email2 = sanitizeFormEmail($_POST['registerEmail2']);
		$password1 = sanitizeFormPassword($_POST['registerPassword']);
		$password2 = sanitizeFormPassword($_POST['registerPassword2']);
		$status = $account->register($username, $email1, $email2, $password1, $password2);
		if ($status)
		{
			header("Location: confirmMail.php");
		}
	}