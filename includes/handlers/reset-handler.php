<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/classes/Constants.class.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/classes/Account.class.php");

	$account = new Account($pdo);

	function	email_exists($pdo, $em) {
		try {
			$query = 'SELECT id FROM users WHERE email=:email';
			$stmt = $pdo->prepare($query);
			$stmt->bindValue(':email', $em);
			$stmt->execute();
			if ($stmt === false)
				return false;
		} catch(PDOException $e) {
			die('There was an error communicating with the databases: ' . $e);
		}
		$id = $stmt->fetch()['id'];
		if (empty($id))
			return false;
		return $id;
	}

	function	insertResetToken($pdo, $id, $token) {
		try {
			$query = 'SELECT token FROM tokens WHERE `user_id`=:id';
			$stmt = $pdo->prepare($query);
			$stmt->bindValue(':id', $id);
			$stmt->execute();
			if ($stmt === false)
				return false;
		} catch (PDOException $e) {
			die('There was an error communicating with the databases: ' . $e);
		}
		$res = $stmt->fetch()['token'];
		if (!$res) {
			try {
				$query = 'INSERT INTO tokens (`user_id`, token) VALUES (:id, :token)';
				$stmt = $pdo->prepare($query);
				$stmt->bindValue(':id', $id);
				$stmt->bindValue(':token', $token);
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOException $e) {
				die('There was an error communicating with the databases: ' . $e);
			}
		} else {
			try {
				$query = 'UPDATE tokens SET token=:token WHERE `user_id`=:id';
				$stmt = $pdo->prepare($query);
				$stmt->bindValue(':id', $id);
				$stmt->bindValue(':token', $token);
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOException $e) {
				die('There was an error communicating with the databases: ' . $e);
			}
		}
		return true;
	}

	if(isset($_POST['resetEmailButton'])) {
		if ($id = email_exists($pdo, $_POST['email'])) {
			$token = hash('sha256', uniqid($id));
			if (insertResetToken($pdo, $id, $token)) {
				$account->reset_password($_POST['email'], $token);
				echo 'All good';
			}
		}
		else
			echo 'nah';
	}

	if(isset($_POST['resetPasswordButton'])) {
		if ($account->resetPassword($_POST['username'], $_POST['password1'], $_POST['password2'])) {
			echo 'All good';
		} else {
			$account->getErrors();
		}
	}
