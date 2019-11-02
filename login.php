<?php
	include("includes/config.php");
	include ("includes/classes/Account.class.php");
	include ("includes/classes/Constants.class.php");
	$account = new Account($pdo);
	include ("includes/handlers/login-handler.php");
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="icon" href="http://localhost/Camagru/assets/images/logo.ico">
		<link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="http://localhost/Camagru/assets/frameworks/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="http://localhost/Camagru/assets/css/global.css">
		<link rel="stylesheet" href="http://localhost/Camagru/assets/css/login.css">
		<title>Camagru - Login</title>
	</head>
<body>
	<div class="back"></div>
	<?php include("includes/navbar.php"); ?>
	<div class="container">
		<div class="jumbotron">
			<h1 class="display-4">login !</h1>
			<form action="login.php" method="POST">
				<?php echo $account->getError(Constants::$loginFailed); ?>
				<input name="loginUsername" class="form-control form-control-lg inputt" type="text" placeholder="Username" required>
				<input name="loginPassword" class="form-control form-control-lg inputt" type="password" placeholder="Password" required>
				<button name ="loginButton" type="submit" class="btn login-btn btn-lg">Login</button>
			</form>
		  </div>
	</div>
</body>
</html>