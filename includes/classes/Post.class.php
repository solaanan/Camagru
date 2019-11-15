<?php
	if (!isset($_SESSION))
		session_start();
	include_once('Like.class.php');
	class Post extends Like {
		private		$pdo;
		private		$errorArray;

		public function		__construct($pdo) {
			parent::__construct($pdo);
			$this->pdo = $pdo;
			$this->errorArray = array();
		}

		public function	post($un, $pub, $base64) {
			$data = $this->validateImage($base64);
			$pub = $this->validatePub($pub);
			if (empty($this->errorArray) && $data !== false && $pub !== false) {
				if (!file_exists('../../assets/images/posts'))
					mkdir('../../assets/images/posts');
				$picture = 'assets/images/posts/' . uniqid('IMG_POST_') . '.png';
				file_put_contents('../../' .  $picture, $data);
				$picture = '/camagru'. '/' . $picture;
				try {
					$query = "SELECT id FROM users WHERE username=:username";
					$stmt = $this->pdo->prepare($query);
					$stmt->bindValue(':username', $un);
					$stmt->execute();
				} catch (PDOException $e) {
					die('An error occured communicating with the databases: ' . $e);
					return false;
				}
				if ($stmt === false)
					return false;
				$id = $stmt->fetch()['id'];
				try {
					$query = "INSERT INTO posts (`user_id`, picture, publication, dateOfPub) VALUES (:id_user, :picture, :publication, NOW())";
					$stmt = $this->pdo->prepare($query);
					$stmt->bindValue(':id_user', $id);
					$stmt->bindValue(':picture', $picture);
					$stmt->bindValue(':publication', $pub);
					$stmt->execute();
				} catch (PDOException $e) {
					die('An error occured communicating with the databases: ' . $e);
					return false;
				}
				if ($stmt === false)
					return false;
				return true;
			}
			return false;
		}

		public function			putPost($array) {
			$username = $array['username'];
			$profilePic = $array['profilePic'];
			$picture = $array['picture'];
			$publication = str_replace("\n", "<br>", $array['publication']);
			$post_id = $array['post_id'];
			$isliked = $this->likeChecker($post_id) ? '1' : '0';
			echo '
			<div class="jumbotron py-3 px-3 mx-auto post" id="post_'. $post_id .'">
				<a class="text-decoration-none text-reset" href="/camagru/profile?username='. $username .'">
					<img class="profilepic" src="'. $profilePic .'" width="30" height="30" class="d-inline-block align-top" alt="">
					<span class="text">'. $username .'<span class="badge badge-secondary new-badge">New</span></span>
				</a>';
				if ($username === $_SESSION['userLoggedIn'])
					echo '<img src="/camagru/assets/images/delete.png" class="delete float-right my-auto" width="20" height="20" alt="delete">';
				echo '<hr class="separator">';
				if ($publication !== '')
				echo ' <p class="text-break">'. $publication .'</p>';
				echo '<img class="post" src="'. $picture .'" alt="">
				<hr class="separator">
				<img class="like" src="/camagru/assets/images/like-'. $isliked .'.png" width="33" height="30" alt="like">'. '<span class="likeCounter">' . $this->likeCounter($post_id) . '</span>' .'
				<img class="comment" src="/camagru/assets/images/comment.png" width="33" height="30" alt="comment">
				<img src="/camagru/assets/images/share.png" width="33" height="30" alt="share">
			</div>
			';
		}
		
		public function			deletePost($post_id) {
			$username = $_SESSION['userLoggedIn'];
			try {
				$query = "SELECT * FROM posts WHERE post_id=:post_id AND `user_id` IN (SELECT id FROM users WHERE username=:username)";
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':post_id', $post_id);
				$stmt->bindValue(':username', $username);
				$stmt->execute();
				if ($stmt === false)
					die('There was an error communicating with the databases.');
			} catch (PDOException $e) {
				die('There was an error communicating with the databases: $e');
			}
			$path = $stmt->fetch()['picture'];
			unlink(str_replace('/camagru', '../..', $path));
			try {
				$query = "DELETE FROM posts WHERE post_id=:post_id AND `user_id` IN (SELECT id FROM users WHERE username=:username)";
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':post_id', $post_id);
				$stmt->bindValue(':username', $username);
				$stmt->execute();
				if ($stmt === false)
					die('There was an error communicating with the databases.');
			} catch (PDOException $e) {
				die('There was an error communicating with the databases: $e');
			}
			return(true);
		}

		private function		validatePub($pub) {
			$len = strlen($pub);
			if ($len > 1000) {
				array_push($this->errorArray, Constants::$PublicationTooLong);
				return false;
			}
			$pub = trim($pub);
			$pub = strip_tags($pub);
			return ($pub);
		}

		private function		validateImage($base64) {
			$data = str_replace('data:image/png;base64,', '', $base64);
			$data = str_replace(' ', '+', $data);
			$data = base64_decode($data);
			$tmp = '../../assets/images/tmp/';
			if (!file_exists($tmp)) {
				mkdir($tmp);
			}
			$name = $tmp . uniqid('IMG_TMP_') . '.png';
			file_put_contents($name, $data);
			if (getimagesize($name)) {
				if (filesize($name) > 8000000) {
					array_push($this->errorArray, Constants::$imageTooBig);
					unlink($name);
					return false;
				} else {
					unlink($name);
					return ($data);
				}
			} else {
				array_push($this->errorArray, Constants::$imageCannotBeFound);
				unlink($name);
				return false;
			}
		}

		public function getErrors() {
			foreach ($this->errorArray as $error)
				echo $error . "\n";
		}
	}
