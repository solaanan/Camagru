<?php 
	include("includes/config.php");
	include ("includes/classes/Account.class.php");
	include ("includes/classes/Constants.class.php");
	$account = new Account($pdo);
	include ("includes/handlers/register-handler.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="icon" href="./assets/images/logo.ico">
		<link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="http://localhost/Camagru/assets/frameworks/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="http://localhost/Camagru/assets/css/global.css">
		<link rel="stylesheet" href="http://localhost/Camagru/assets/css/login.css">
		<title>Camagru - Sign up</title>
	</head>
<body>
	<div class="back"></div>
	<?php include("includes/navbar.php"); ?>
	<div class="container">
		<div class="jumbotron">
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
				<button name="registerButton" type="submit" class="btn-lg login-btn">Sign Up</button>
			</form>
		  </div>
	</div>
</body>
</html>
