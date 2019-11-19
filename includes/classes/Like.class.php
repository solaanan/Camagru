<?php
	if (!isset($_SESSION))
		session_start();
	class Like {
		private $pdo;

		public function __construct($pdo) {
			$this->pdo = $pdo;
		}

		public function like($post_id) {
			if (!$this->likeChecker($post_id)) {
				try {
					$query = "INSERT INTO likes (id_post, id_user) SELECT :post_id, id FROM users WHERE username=:username";
					$stmt = $this->pdo->prepare($query);
					$stmt->bindValue(':post_id', $post_id);
					$stmt->bindValue(':username', $_SESSION['userLoggedIn']);
					$stmt->execute();
					if ($stmt === false)
						die('There was an error communicating with the databases');
					} catch (PDOException $e) {
						die('There was an error communicating with the databases: ' . $e);
					}
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
					die('There was an error communicating with the databases.');
			} catch (PDOException $e) {
				die('There was an error communicating with the databases: ' . $e);
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
					$stmt->bindValue(':username', $_SESSION['userLoggedIn']);
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
				$stmt->bindValue(':username', $_SESSION['userLoggedIn']);
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
	}