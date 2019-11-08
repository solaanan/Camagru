<?php 
	session_start();
	include_once ("includes/config.php");
	include_once ("includes/classes/Account.class.php");
	include_once ("includes/classes/Constants.class.php");
	$account = new Account($pdo);
	include_once ("includes/handlers/register-handler.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include("includes/links.php") ?>
		<link rel="stylesheet" href="/camagru/assets/css/login.css">
		<title>Camagru - Sign up</title>
	</head>
<body>
	<div class="back"></div>
	<?php include("includes/navbar.php"); ?>
	<div class="container">
		<div class="jumbotron">
			<a href="javascript:history.back()" class="goback">
				<img src="/camagru/assets/images/goback.png" alt="go back" width="30" height="30">
			</a>
			<h1 class="signup display-3">Sign up !</h1>
			<form action="register.php" method="POST">
				<?php echo $account->getError(Constants::$usernameCharacters); ?>
				<?php echo $account->getError(Constants::$usernameTaken); ?>
				<input name="registerUsername" class="form-control form-control-lg inputt" type="text" placeholder="Username" required>
				<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
				<?php echo $account->getError(Constants::$emailInvalid); ?>
				<?php echo $account->getError(Constants::$emailTaken); ?>
				<input name="registerEmail" class="form-control form-control-lg inputt" type="email" placeholder="Email" required>
				<input name="registerEmail2" class="form-control form-control-lg inputt" type="email" placeholder="Re-type Email" required>
				<?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
				<?php echo $account->getError(Constants::$passwordIsNotAlphanumeric); ?>
				<?php echo $account->getError(Constants::$passwordCharacters); ?>
				<input name="registerPassword" class="form-control form-control-lg inputt" type="password" placeholder="Password" required>
				<input name="registerPassword2" class="form-control form-control-lg inputt" type="password" placeholder="Re-type Password" required>
				<button name="registerButton" type="submit" class="btn-lg login-btn botona">Sign Up</button>
			</form>
		  </div>
	</div>
</body>
</html>
