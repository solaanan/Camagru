<?php
	if (!isset($_SESSION))
		session_start();
	if (isset($_SESSION) && isset($_SESSION['userLoggedIn']))
		header('Location: /camagru/gallery');
	include($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/config.php");
	include ($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/classes/Account.class.php");
	include ($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/classes/Constants.class.php");
	$account = new Account($pdo);
	include ($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/handlers/login-handler.php");

	function getInputValue($name) {
		if (isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/links.php") ?>
		<link rel="stylesheet" href="/camagru/assets/css/login.css">
		<title>Camagru - Login</title>
		<script src="/camagru/assets/js/themeSwitcher.js"></script>
	</head>
<body>
	<?php include($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/navbar.php"); ?>
	<div class="everything">
		<div class="back" id="bg"></div>
		<div class="container">
			<div class="jumbotron">
				<a href="javascript:history.back()" class="goback">
					<img src="/camagru/assets/images/icons-dark/goback.png" alt="go back" width="30" height="30">
				</a>
				<h1 class="display-4">login !</h1>
				<form action="login.php" method="POST">
					<?php echo $account->getError(Constants::$confirmationNeeded); ?>
					<?php echo $account->getError(Constants::$loginFailed); ?>
					<input id="loginUsername" name="loginUsername" class="form-control form-control-lg inputt" type="text" value="<?php getInputValue('loginUsername') ?>" placeholder="Username" required>
					<input id="loginPassword" name="loginPassword" class="form-control form-control-lg inputt" type="password" placeholder="Password" required>
					<button id="loginButton" name ="loginButton" type="submit" class="login-btn btn-lg botona">Login</button>
					<p class="create text-break" style="font-size:15px"> <a href="/camagru/register">Create a new account</a> if you still don't have an account.</p>
					<p class="forgot text-break" id="forgot"><a href="/camagru/resetPassword">Reset your password</a> if you have forgotten it.</p>
				</form>
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