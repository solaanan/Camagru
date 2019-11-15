<?php
	if (!isset($_SESSION))
		session_start();
	class Constants {
			public static $usernameCharacters = "Your username must be between 5 and 25 characters.";
			public static $usernameTaken = "This username is already in use.";
			public static $passwordsDoNotMatch = "Your passwords don't match.";
			public static $passwordIsNotValid = "Your password needs to be at least 8 characters, with at lease one uppercase, one lowercase, one digit and one special character.";
			public static $passwordCharacters = "Your password must be between 5 and 30 characters.";
			public static $emailsDoNotMatch = "Your emails don't match.";
			public static $emailInvalid = "Your email is invalid.";
			public static $emailTaken = "This email is already in use.";
			public static $loginFailed = "Username or password was incorrect.";
			public static $confirmationNeeded = "You need to confirm your email address.";
			public static $salt = "bmFyaSBudGEgc2g3YWwgbTlhd2Vk";
			public static $wrongOldPasswd = "Wrong password.";
			public static $usernameIsNotValid = "Your username must only contains letters and numbers and these characters _ - .";
			public static $imageCannotBeFound = "Please upload a valid image file.";
			public static $imageTooBig = "Your image is too big.";
			public static $PublicationTooLong = "Your publication cannot exceed 1000 characters.";
		}