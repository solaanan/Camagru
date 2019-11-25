<?php
	if (!isset($_SESSION))
		session_start();
	// if (isset($_SESSION) && isset($_SESSION['userLoggedIn']))
	// 	header('Location: /camagru/gallery');
	include("includes/config.php");
	include ("includes/classes/Account.class.php");
	include ("includes/classes/Constants.class.php");
	$account = new Account($pdo);
	include ("includes/handlers/login-handler.php");
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include("includes/links.php") ?>
		<link rel="stylesheet" href="/camagru/assets/css/login.css">
		<title>Camagru - Login</title>
	</head>
<body>
	<div class="back"></div>
	<?php include("includes/navbar.php"); ?>
	<div class="container">
		<div class="jumbotron">
			<a href="javascript:history.back()" class="goback">
				<img src="/camagru/assets/images/goback.png" alt="go back" width="30" height="30">
			</a>
			<h1 class="display-4">login !</h1>
			<form action="login.php" method="POST">
				<?php echo $account->getError(Constants::$confirmationNeeded); ?>
				<?php echo $account->getError(Constants::$loginFailed); ?>
				<input name="loginUsername" class="form-control form-control-lg inputt" type="text" placeholder="Username" required>
				<input name="loginPassword" class="form-control form-control-lg inputt" type="password" placeholder="Password" required>
				<button name ="loginButton" type="submit" class="login-btn btn-lg botona">Login</button>
				<p class="create text-break" style="font-size:15px"> <a href="/camagru/register">Create a new account</a> if you still don't have an account.</p>
				<p class="forgot text-break" id="forgot"><a href="/camagru/resetPassword">Reset your password</a> if you have forgotten it.</p>
			</form>
		</div>
	</div>
</body>
</html>