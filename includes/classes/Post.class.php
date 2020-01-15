<?php
	if (!isset($_SESSION))
		session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/classes/Like.class.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/classes/Mail.class.php');

	$mail = new Mail();

	class Post extends Like {
		private		$pdo;
		private		$errorArray;
		public		$username;

		public function		__construct($pdo) {
			parent::__construct($pdo);
			$this->pdo = $pdo;
			$this->errorArray = array();
			$this->username = isset($_SESSION['userLoggedIn']) ? $_SESSION['userLoggedIn'] : '';
		}

		public function	post($un, $pub, $base64, $stickerIndex) {
			$stickerfileName = '../../assets/images/stickers/sticker-' . $stickerIndex. '.png';
			$sticker = imagecreatefrompng($stickerfileName);
			$data = $this->validateImage($base64);
			$pub = $this->validatePub($pub);
			if (empty($this->errorArray) && $data !== false && $pub !== false) {
				if (!file_exists('../../assets/images/posts'))
					mkdir('../../assets/images/posts');
				$picture = 'assets/images/posts/' . uniqid('IMG_POST_') . '.png';
				// file_put_contents('../../' .  $picture, $data);
				$final = imagecreatefromstring($data);
				$finalX = imagesx($final);
				$finalY = imagesy($final);
				$stickerX = imagesx($sticker);
				$stickerY = imagesy($sticker);
				if (imagecopyresized($final, $sticker, 0, 0, 0, 0, $finalX,  $finalX * $stickerY / $stickerX, $stickerX, $stickerY)) {
					if (!imagepng($final, '../../' . $picture))
					return false;
					$picture = '/camagru'. '/' . $picture;
					try {
						$query = "SELECT id FROM users WHERE username=:username";
						$stmt = $this->pdo->prepare($query);
						$stmt->bindValue(':username', $un);
						$stmt->execute();
						if ($stmt === false)
							return false;
					} catch (PDOException $e) {
						die(Constants::$databasesProblem . $e);
						return false;
					}
					$id = $stmt->fetch()['id'];
					try {
						$query = "INSERT INTO posts (`user_id`, picture, publication, dateOfPub) VALUES (:id_user, :picture, :publication, NOW())";
						$stmt = $this->pdo->prepare($query);
						$stmt->bindValue(':id_user', $id);
						$stmt->bindValue(':picture', $picture);
						$stmt->bindValue(':publication', $pub);
						$stmt->execute();
						if ($stmt === false)
							return false;
					} catch (PDOException $e) {
						die(Constants::$databasesProblem . $e);
						return false;
					}
				} else {
					return false;
				}
				return $this->pdo->lastInsertId();
			}
			return false;
		}

		public function			putPost($array) {
			$iconTheme = (isset($_COOKIE) && isset($_COOKIE['theme']) && $_COOKIE['theme'] === '1') ? 'icons-light' : 'icons-dark';
			$username = $array['username'];
			$profilePic = $array['profilePic'];
			$picture = $array['picture'];

			$date = $array['signUpDate'];
			$today = date('Y-m-d');
			$diff = abs(strtotime($today) - strtotime($date));
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

			$publication = str_replace("\n", "<br>", $array['publication']);
			$post_id = $array['post_id'];
			$isliked = $this->likeChecker($post_id) ? '1' : '0';
			try {
				$query = 'SELECT username FROM likes INNER JOIN users ON users.id=likes.id_user WHERE id_post=:id_post';
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':id_post', $post_id);
				$stmt->execute();
			} catch (PDOException $e) {
				die('There was an error communicating with the databases: ' . $e);
			}
			$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$tooltip = NULL;
			if ($arr)
				foreach($arr as $user) {
					$tooltip .= $user['username'] . '<br>';
				}
			echo '
			<div class="jumbotron py-3 px-3 mx-auto post" id="post_'. $post_id .'">
				<a class="text-decoration-none text-reset click" href="/camagru/profile?username='. $username .'">
					<div class="profilepic" style="background-image:url(\''. $profilePic .'\')" class="d-inline-block align-top" alt=""></div>
					<span class="text username" style="vertical-align:middle">'. $username .'</span>';
				// if ($days < 7)
				// 	echo '<span class="badge badge-secondary new-badge">New</span>';
				if ($username === 'holk')
					echo '<span class="badge badge-secondary admin-badge">Creator</span>';
				echo '</a>';
				if ($username === $this->username)
					echo '<img id="delete_'. $post_id .'" src="/camagru/assets/images/delete.png" class="delete float-right my-auto" width="20" height="20" alt="delete">';
				echo '<hr class="separator">';
				if ($publication !== '')
				echo ' <p class="text-break publicationn">'. $publication .'</p>';
				echo '<div class="heartContainer" id="heart_'. $post_id .'"></div>';
				echo '<img class="postImg" src="'. $picture .'">';
				if (isset($_SESSION) && isset($_SESSION['userLoggedIn'])) {
					echo '<hr class="separator">
					<div class="tooltip-holder">';
					if ($tooltip)
						echo '<span id="tooltip_'. $post_id .'" class="tooltipp">'. $tooltip .'</span>';
					echo '</div>
					<img class="like" id="like_'. $post_id .'" src="/camagru/assets/images/'. $iconTheme .'/	like-'. $isliked .'.png" width="33" height="30" alt="like">'. '<span class="likeCounter">' . $this->likeCounter($post_id) . '</span>' .'
					<img  id="comment_'. $post_id .'" class="comment click" src="/camagru/assets/images/'. $iconTheme .'/comment_0.png" width="33" height="30" alt="comment">' . '<span id="commentsCounter_'. $post_id .'" class="likeCounter">' . $this->commentCounter($post_id) . '</span>' .
					'<img id="share_'. $post_id .'" class="share click" src="/camagru/assets/images/'. $iconTheme .'/share.png" width="33" height="30" alt="share">
					<div class="commentsContainer" id="commentsContainer_'. $post_id .'">
					<form class="commentForm" method="POST" action="gallery">
						<div class="input-group mb-3">
							<textarea id="newComment_'. $post_id .'" type="text" class="form-control inpot" placeholder="Write a comment"></textarea>
							<div class="input-group-append">
								<button class="btn btn-outline-secondary comantir click" type="button" id="newCommentButton_'. $post_id .'" name="newCommentButton">Send</button>
							</div>
						</div>
					</form>
					';
					$this->putComments($post_id);
					if ((int)$this->commentCounter($post_id) > 2)
						echo '
						<a class="showMore" id="show_'. $post_id .'"> Show more </a>
						';
					echo'
					</div>';
				}
				echo '
				<div class="shareContainer" id="shareContainer_'. $post_id .'">
						<textarea class="shareLink" id="shareLink_'. $post_id .'" readonly> '. $_SERVER['SERVER_NAME'] .'/camagru/post?id='. $post_id .'</textarea>
						<div class="shareButtons">
							<a class="copy botona coppy" id="copy_'. $post_id .'"><img src="/camagru/assets/images/copy.png" width="20" height="20"> Copy </a>
							<a class="copy botona tweet" href="https://www.twitter.com/intent/tweet?text=view%20'. $username .'%27s%20publication%20on%20Camagru%3A%0A'. $_SERVER['SERVER_NAME'] .'%2Fcamagru%2Fpost%3Fid%3D'. $post_id .'" target="_blank"><img src="/camagru/assets/images/twitter.png" width="20" height="20"> Tweet </a>
						</div>
				</div>
				</div>';
		}

		public function			insertNewComment($comment, $post_id) {
			$comment = trim($comment);
			$comment = htmlspecialchars($comment);
			$comment = str_replace("\n", '<br>', $comment);
			$comment = str_replace(' ', '&nbsp;', $comment);
			if (strlen($comment) > 500)
				return false;
			if (isset($comment) && $comment !== '') {
				try {
					$query = "SELECT * FROM users WHERE username=:username";
					$stmt = $this->pdo->prepare($query);
					$stmt->bindValue(':username', $this->username);
					$stmt->execute();
					if ($stmt === false)
						return false;
				} catch (PDOException $e) {
					die(Constants::$databasesProblem . $e);
				}
				$userData = $stmt->fetch();
				try {
					$query = 'INSERT INTO comments (post_id, `user_id`, comment_body, dateOfCom) VALUES (:post_id, :user_id, :comment_body, NOW())';
					$stmt = $this->pdo->prepare($query);
					$stmt->bindValue(':post_id', $post_id);
					$stmt->bindValue(':user_id', $userData['id']);
					$stmt->bindValue(':comment_body', $comment);
					$stmt->execute();
					if ($stmt === false)
						return false;
				} catch (PDOException $e) {
					die (Constants::$databasesProblem . $e);
				}
			} else {
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
			if ($arrr['username'] !== $this->username && $this->notifStatus($arrr['username']) === '1')
			$this->someone_commented($this->username, $arrr['username'], $arrr['publication'], $comment, $arrr['email'], $post_id);
			try {
				$query = 'SELECT comment_id FROM comments WHERE post_id=:post_id AND `user_id`=:user_id AND comment_body=:comment_body';
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':post_id', $post_id);
				$stmt->bindValue(':user_id', $userData['id']);
				$stmt->bindValue(':comment_body', $comment);
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOEXception $e) {
				die (Constants::$databasesProblem . $e);
			}
			$newCommentId = $stmt->fetch()['comment_id'];
			$comment = str_replace("\n", '<br>', $comment);
			$ret = '
				<div class="media commentt" id="comment_'. $newCommentId .'">
					<a class="text-decoration-none text-reset" href="/camagru/profile?username='. $this->username .'">
						<img class="profilepic d-inline-block align-top" src="'. $userData['profilePic'] .'" width="30" height="30" alt="">
					</a>
					<div class="media-body comment-body">'
					. '<img id="delCom_'. $newCommentId .'" src="/camagru/assets/images/delete.png" class="deleteComment float-right my-auto" width="10" height="10" alt="delete">'
					. '<span class="text mt-0 comment-head">'. $this->username .'</span>
						<br><span class="text text-break comment-text d-block">'. $comment .'</span>
					</div>
				</div>
			';
			return $ret;
		}

		public function			putComments($post_id) {
			try {
				$query = 'SELECT comment_id, post_id, user_id, comment_body, username, profilePic FROM comments JOIN users ON users.id=comments.user_id WHERE post_id=:post_id ORDER BY dateOfCom DESC';
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':post_id', $post_id);
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOException $e) {
				die (Constants::$databasesProblem . $e);
			}
			$array = $stmt->fetchAll();
			$username = '';
			foreach($array as $arr) {
				$commentId = $arr['comment_id'];
				$profilePic = $arr['profilePic'];
				$commentBody = $arr['comment_body'];
				$username = $arr['username'];
				echo '
				<div class="media commentt" id="comment_'. $commentId .'">
					<a class="text-decoration-none text-reset" href="/camagru/profile?username='. $username .'">
						<div class="profilepic" style="background-image: url(\''. $profilePic .'\')" width="30" height="30" class="d-inline-block align-top"></div>
					</a>
					<div class="media-body comment-body">';
					if ($username === $this->username)
						echo '<img id="delCom_'. $commentId .'" src="/camagru/assets/images/delete.png" class="deleteComment float-right my-auto" width="10" height="10" alt="delete">';
					echo	'<span class="text mt-0 comment-head username">'. $username .'</span>
						<br><span class="text text-break comment-text d-block">'. $commentBody .'</span>
					</div>
				</div>';
			}
		}

		public function		commentCounter($post_id) {
			try {
				$query = 'SELECT COUNT(*) AS `counter` FROM comments WHERE post_id=:post_id';
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':post_id', $post_id);
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOException $e) {
				die(Constants::$databasesProblem . $e);
			}
			$array = $stmt->fetch();
			if ($array['counter'] === '0')
				return '';
			return ($array['counter']);
		}
		

		public function			deleteComment($postId, $commentId) {
			try {
				$query = 'DELETE FROM comments WHERE post_id=:post_id AND comment_id=:comment_id AND `user_id` IN (SELECT id FROM users WHERE username=:username)';
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':post_id', $postId);
				$stmt->bindValue(':comment_id', $commentId);
				$stmt->bindValue(':username', $this->username);
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOExeption $e) {
				die(Constants::$databasesProblem . $e);
			}
			return true;
		}

		public function			deletePost($post_id) {
			try {
				$query = "SELECT * FROM posts WHERE post_id=:post_id AND `user_id` IN (SELECT id FROM users WHERE username=:username)";
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':post_id', $post_id);
				$stmt->bindValue(':username', $this->username);
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOException $e) {
				die(Constants::$databasesProblem . $e);
			}
			if ($stmt->rowCount() === 0)
				return false;
			$path = $stmt->fetch()['picture'];
			if (file_exists(str_replace('/camagru', '../..', $path)))
				unlink(str_replace('/camagru', '../..', $path));
			try {
				$query = "DELETE FROM posts WHERE post_id=:post_id AND `user_id` IN (SELECT id FROM users WHERE username=:username)";
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':post_id', $post_id);
				$stmt->bindValue(':username', $this->username);
				$stmt->execute();
				if ($stmt === false)
					return false;
			} catch (PDOException $e) {
				die(Constants::$databasesProblem . $e);
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
			$pub = htmlspecialchars($pub);
			$pub = str_replace("\n", '<br>', $pub);
			$pub = str_replace(" ", '&nbsp;', $pub);
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

		public function getErrors() {
			foreach ($this->errorArray as $error)
				echo $error . "\n";
		}
	}
