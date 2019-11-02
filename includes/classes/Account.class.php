<?php
	class Account {
		private $errorArray;
		private $pdo;

		public function		__construct($pdo) {
			$this->pdo = $pdo;
			$this->errorArray = array();
		}

		public function		login($username, $password) {
			$password = hash('whirlpool', $password);
			$statement = $this->pdo->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
			if ($statement->rowCount() === 1)
			return true;
			else
			{
				echo '<div class="alert alert-success"> yes babe </div>';
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
			$encryptedPw = hash('whirlpool', $password);
			$profilePic = "assets/images/profile-pics/default.png";
			$date = date("Y-m-d");
			$data = [
				'username' => $username,
				'email' => $email,
				'password' => $password,
				'signUpDate' => $date,
				'profilePic' => $profilePic
			];
			$query = "INSERT INTO users (username, email, password, signUpDate, profilePic) VALUES (?,?,?,?,?)";
			try {
				$stmt = $this->pdo->prepare($query);
				$stmt->execute([$username,$email,$encryptedPw,$date,$profilePic]);
				if ($result === false)
					return false;
			} catch (PDOException $e) {
				return false;
			}
			return $result;
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
			$data = ['username' => $un];
			$query = "SELECT username FROM users WHERE username=:username";
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
			if (preg_match('/[^A-Za-z0-9.-_]/', $p1))
			{
				array_push($this->errorArray, Constants::$passwordIsNotAlphanumeric);
				return ;
			}
			if ($len > 30 || $len < 5)
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
			$data = ['email' => $em];

			$query = "SELECT email FROM users WHERE email=':email'";
			$stmt = $this->pdo->prepare($query);
			$stmt->execute($data);
			if ($stmt->rowCount() != 0)
			{
				array_push($this->errorArray, Constants::$emailTaken);
				return ;
			}
		}
	}