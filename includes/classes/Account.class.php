<?php
	session_start();
	include ("Mail.class.php");
	class Account extends Mail {
		private $errorArray;
		private $pdo;

		public function		__construct($pdo) {
			$this->pdo = $pdo;
			$this->errorArray = array();
		}

		public function		login($username, $password) {
			$password = hash('whirlpool', Constants::$salt . $password);
			$statement = $this->pdo->query("SELECT * FROM users WHERE username='$username' AND passwd='$password'");
			if ($statement->rowCount() === 1) {
				$array = $statement->fetch();
				if ($array["token"] === '')
					return true;
				else {
					array_push($this->errorArray, Constants::$confirmationNeeded);
					return false;
				}
			}
			else
			{
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}
		}

		public function		register($username, $email, $email2, $password, $password2) {
			$this->validateUsername($username);
			$this->validatePasswords($password, $password2);
			$this->validateEmails($email, $email2);
			if (empty($this->errorArray))
				return $this->insertUserDetails($username, $email, $password);
			else
				return false;
		}

		private function	insertUserDetails($username, $email, $password) {
			$encryptedPw = hash('whirlpool', Constants::$salt . $password);
			$profilePic = "/camagru/assets/images/profilePics/default.png";
			$token = hash('sha256', $username . uniqid());
			$query = 'INSERT INTO `users`(`username`, `email`, `passwd`, `signUpDate`, `profilePic`, `token`) VALUES (:username,:email,:passwd, NOW() ,:profilePic,:token)';
			try {
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':username', $username);
				$stmt->bindValue(':email', $email);
				$stmt->bindValue(':passwd', $encryptedPw);
				$stmt->bindValue(':profilePic', $profilePic);
				$stmt->bindValue(':token', $token);	
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOException $e) {
				return false;
			}
			$this->confirm_mail($username, $email, $token);
			return true;
		}

		private function	insertNewUsername($prevUn, $un) {
			$query = "UPDATE `users` SET username = :username WHERE username = :prevusername";
			try {
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(":username", $un);
				$stmt->bindValue(":prevusername", $prevUn);
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOException $e) {
				return false;
			}
			return true;
		}

		private function	insertNewEmail($un, $em) {
			$token = hash('sha256', $un . uniqid());
			$query = "UPDATE `users` SET email = :email, token = :token WHERE username = :username";
			try {
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(":email", $em);
				$stmt->bindValue(":token", $token);
				$stmt->bindValue(":username", $un);
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOException $e) {
				return false;
			}
			$this->confirm_mail($un, $em, $token);
			return true;
		}

		private function	insertNewPassword($un, $pw) {
			$encryptedPw = hash('whirlpool', Constants::$salt . $pw);
			$query = "UPDATE `users` SET passwd = :passwd WHERE username = :username";
			try {
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(":passwd", $encryptedPw);
				$stmt->bindValue(":username", $un);
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOException $e) {
				return false;
			}
			return true;
		}

		private function insertNewProfilePic($un, $path) {
			$query = "UPDATE users SET profilePic = :newPath WHERE username = :username";
			try {
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(":newPath", $path);
				$stmt->bindValue(":username", $un);
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOException $e) {
				return false;
			}
			return true;
		}

		public function		getError($error) {
			if (!in_array($error, $this->errorArray))
			{
				$error = "";
				return ;
			}
				return "<span class='errorMessage alert alert-danger'>$error</span>";
		}
		
		private function	validateUsername($un) {
			$len = strlen($un);
			if ($len > 25 || $len < 5)
			{
				array_push($this->errorArray, Constants::$usernameCharacters);
				return ;
			}
			if (preg_match('/[^\dA-Za-z\_\-\.]/', $un))
			{
				array_push($this->errorArray, Constants::$usernameIsNotValid);
				return ;
			}
			$data = ['username' => $un];
			$query = "SELECT username FROM users WHERE username = :username";
			$stmt = $this->pdo->prepare($query);
			$stmt->execute($data);
			if ($stmt->rowCount() != 0)
			{
				array_push($this->errorArray, Constants::$usernameTaken);
				return ;
			}
		}
	
		private function	validatePasswords($p1, $p2) {
			$len = strlen($p1);
			if ($p1 !== $p2)
			{
				array_push($this->errorArray, Constants::$passwordsDoNotMatch);
				return ;
			}
			if (!preg_match('/[A-Z]+/', $p1) || !preg_match('/[a-z]/', $p1) || !preg_match('/[0-9]/', $p1) || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $p1)) {
				array_push($this->errorArray, Constants::$passwordIsNotValid);
				return ;
			}
			if ($len > 30 || $len < 8)
			{
				array_push($this->errorArray, Constants::$passwordCharacters);
				return ;
			}
		}
	
		private function	validateEmails($e1, $e2) {
			if ($e1 !== $e2)
			{
				array_push($this->errorArray, Constants::$emailsDoNotMatch);
				return ;
			}
			if (!filter_var($e1, FILTER_VALIDATE_EMAIL))
			{
				array_push($this->errorArray, Constants::$emailInvalid);
				return ;
			}
			$query = "SELECT email FROM users WHERE email=:email";
			$stmt = $this->pdo->prepare($query);
			$stmt->bindValue(":email", $e1);
			$stmt->execute();
			if ($stmt->rowCount() != 0)
			{
				array_push($this->errorArray, Constants::$emailTaken);
				return ;
			}
		}

		public function updateUsername($prevUn, $un) {
			$this->validateUsername($un);
			if (empty($this->errorArray)) {
				return $this->insertNewUsername($prevUn, $un);
			}
			return false;
		}

		public function updateEmail($un, $em, $em2) {
			$this->validateEmails($em, $em2);
			if (empty($this->errorArray)) {
				return $this->insertNewEmail($un, $em);
			}
			return false;
		}

		public function updatePassword($un, $oldpw, $pw, $pw2) {
			$encryptedPw = hash('whirlpool', Constants::$salt . $oldpw);
			try {
				$query = "SELECT * FROM users WHERE username=:username AND passwd=:passwd";
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(":username", $un);
				$stmt->bindValue(":passwd", $encryptedPw);
				$stmt->execute();
				if ($stmt->rowCount() != 1) {
					array_push($this->errorArray, Constants::$wrongOldPasswd);
					return false;
				}
			} catch (PDOException $e) {
				return false;
			}
			$this->validatePasswords($pw, $pw2);
			if (empty($this->errorArray)) {
				return $this->insertNewPassword($un, $pw);
			}
			return false;
		}

		public function updateProfilePic($un, $base64) {
			$data = str_replace("data:image/png;base64,", "", $base64);
			$data = str_replace(" ", "+", $data);
			$data = base64_decode($data);
			$name = "assets/images/profilePics/" . uniqid("IMG_PP_" . $_SESSION['userLoggedIn'] . "_") . ".png";
			file_put_contents("../../" . $name, $data);
			if (getimagesize("../../" . $name)) {
				if (filesize("../../" . $name) > 2000000 || filesize("../../" . $name) < 1) {
					array_push($this->errorArray, Constants::$imageTooBig);
					unlink("../../" . $name);
					return false;
				}
			}
			else {
				array_push($this->errorArray, Constants::$imageCannotBeFound);
				unlink("../../" . $name);
				return false;
			}
			if (empty($this->errorArray)) {
				return $this->insertNewProfilePic($un, "/camagru" . "/" . $name);
			}
			return false;
		}

		public function getErrors() {
			foreach ($this->errorArray as $error)
			{
				echo $error . "\n";
			}
		}
	}

