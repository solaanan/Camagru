<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/config.php');
	session_start();
	include_once('includes/session_expiry.php');
	if (isset($_SESSION) && isset($_SESSION['userLoggedIn'])) {
		header('Location: notFound.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/links.php') ?>
	<link rel="stylesheet" href="/camagru/assets/css/login.css">
	<link rel="stylesheet" href="/camagru/assets/css/animations.css">
	<style>
		.good {
			margin: auto;
			display: block;
			margin-bottom: 30px;
			text-align: center;
		}
	</style>
	<script src="/camagru/assets/js/resetPassword.js"></script>
	<title>Camagru - Reset your password</title>
	<script src="/camagru/assets/js/themeSwitcher.js"></script>
</head>
<body id="body">
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/navbar.php') ?>
	<div class="everything">
		<div class="back"></div>
		<div id="messages"></div>
		<div class="container">
			<div class="jumbotron" id="form">
				<?php
					if (!isset($_GET['token']) || empty($_GET['token']))
						echo '<h1 class="display-4">Reset your password !</h1>
						<p class="lead">Enter your email address to send you a password reset link.</p>
						<input id="resetEmail" type="email" name="resetEmail" class="form-control form-control-lg inputt" placeholder="Email address" required>
						<button name="resetEmailButton" id="emailButton" class="btn-lg botona">Send</button>';
					else {
						$token = $_GET['token'];
						try {
							$query = 'SELECT tokens.token, username, id FROM tokens INNER JOIN users ON users.id=tokens.user_id WHERE tokens.token=:token';
							$stmt = $pdo->prepare($query);
							$stmt->bindValue(':token', $token);
							$stmt->execute();
							if ($stmt === false)
								return ;
						} catch (PDOException $e) {
							die('There was an error communicating with the databases: ' . $e);
						}
						$arr = $stmt->fetch();
						$res = $arr;
						$username = $arr['username'];
						$id = $arr['id'];
						if ($res)
							echo '
							<a href="javascript:history.back()" class="goback">
								<img src="/camagru/assets/images/icons-dark/goback.png" alt="go back" width="30" height="30">
							</a>
							<h1 class="display-4">Reset your password !</h1>
							<p class="lead">Enter a new password for the user: <span id="username">'. $username .'</span></p>
							<input type="password" name="newPassword1" id="newPassword1" class="form-control form-control-lg inputt" placeholder="New password" required>
							<input type="password" name="newPassword2" id="newPassword2" class="form-control form-control-lg inputt" placeholder="Re-type new password" required>
							<button name="newPasswordButton" id="newPasswordButton" class="btn-lg botona">Save changes</button>';
						else
							echo '<img class="good" src="/camagru/assets/images/icons-dark/bad.png" width="200" height="200" alt="error">
							<h1 class="display-4 good">Something went wrong</h1>
							<hr>
							<p class="lead good">An error has occured during the process of your operation.</p>';
					}
				?>
			</div>
			<div class="jumbotron" id="success">
				<img class="good" src="/camagru/assets/images/icons-dark/good.png" width="200" height="200" alt="error">
				<h1 class="display-4 good">Success !</h1>
				<hr>
				<p class="lead good">Your password has been changed successfully, <a href="/camagru/login">Login</a> to your account.</p>
			</div>
		</div>
	</div>
	<div class="loading-container" id="loading" style="display: flex;">
		<!-- <div class="spinner-border m-auto" style="color: white;"></div> -->
		<svg class="logo-svg" width="142" height="142" viewBox="0 0 142 142" fill="none" xmlns="http://www.w3.org/2000/svg">
			<rect x="0.5" y="0.5" width="141" height="141" rx="25.5" stroke="white"/>
			<circle cx="71.0001" cy="71" r="42.5656" stroke="white"/>
			<circle cx="70.9999" cy="71" r="33.2541" stroke="white"/>
			<circle cx="120.602" cy="19.3398" r="7.06557" stroke="white"/>
			<rect x="0.5" y="33.0901" width="8.31148" height="75.8197" rx="4.15574" stroke="white"/>
		</svg>
	</div>
</body>
</html>