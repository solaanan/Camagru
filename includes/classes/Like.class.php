<?php
	if (!isset($_SESSION))
		session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/classes/Mail.class.php');

	class Like extends Mail {
		private $pdo;
		private $un;

		public function __construct($pdo) {
			$this->pdo = $pdo;
			$this->un = isset($_SESSION['userLoggedIn']) ? $_SESSION['userLoggedIn'] : '';
		}

		public function like($post_id) {
			if (!isset($this->un) || empty($this->un))
				return false;
			if (!$this->likeChecker($post_id)) {
				try {
					$query = "INSERT INTO likes (id_post, id_user) SELECT :post_id, id FROM users WHERE username=:username";
					$stmt = $this->pdo->prepare($query);
					$stmt->bindValue(':post_id', $post_id);
					$stmt->bindValue(':username', $this->un);
					$stmt->execute();
					if ($stmt === false)
						return false;
				} catch (PDOException $e) {
					return false;
				}
				try {
					$query = "SELECT username, email, publication FROM posts INNER JOIN users ON users.id=posts.user_id WHERE post_id=:post_id";
					$stmt = $this->pdo->prepare($query);
					$stmt->bindValue(':post_id', $post_id);
					$stmt->execute();
					if ($stmt === false)
						return false;
				} catch (PDOException $e) {
					return false;
				}
				$arrr = $stmt->fetch();
				if ($arrr['username'] !== $this->un && $this->notifStatus($arrr['username']) === '1')
				$this->someone_liked($this->un, $arrr['username'], $arrr['publication'], $arrr['email'], $post_id);
			}
			return true;
		}

		public function		likeCounter($post_id) {
			try {
				$query = 'SELECT COUNT(*) AS `counter` FROM likes WHERE id_post=:post_id';
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':post_id', $post_id);
				$stmt->execute();
				if ($stmt === NULL)
					return false;
			} catch (PDOException $e) {
				return false;
			}
			$array = $stmt->fetch();
			if ($array['counter'] === '0')
				return '';
			return ($array['counter']);
		}

		public function unlike($post_id) {
			if ($this->likeChecker($post_id)) {
				try {
					$query = "DELETE FROM likes WHERE id_post=:post_id AND id_user IN (SELECT id FROM users WHERE username=:username)";
					$stmt = $this->pdo->prepare($query);
					$stmt->bindValue(':post_id', $post_id);
					$stmt->bindValue(':username', $this->un);
					$stmt->execute();
					if ($stmt === false)
						die('There was an error communicating with the databases');
					} catch (PDOException $e) {
						die('There was an error communicating with the databases: ' . $e);
					}
			}
			return true;
		}

		public function likeChecker($post_id) {
			try {
				$query = 'SELECT COUNT(*) AS "isliked" FROM likes, users WHERE id_post=:post_id AND username=:username AND id_user=users.id';
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':post_id', $post_id);
				$stmt->bindValue(':username', $this->un);
				$stmt->execute();
				if ($stmt === false)
					die('There was an error communicating with the databases');
			} catch (PDOException $e) {
				die('There was an error communicating with the databases: ' . $e);
			}
			$result = $stmt->fetch();
			if ($result['isliked'] === '0')
				return false;
			else
				return true;
		}

		public function notifStatus($username) {
			try {
				$query = 'SELECT notif FROM users WHERE username=:username';
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':username', $username);
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOException $e) {
				die ('Error: ' . $e->getMessage());
			}
			return ($stmt->fetch()['notif']);
		}
	}