<?php
	session_start();
	unset($_SESSION['userLoggedIn']);
	session_unset();
	session_destroy();
	header("Location: index.php");