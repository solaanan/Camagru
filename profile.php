<?php
	session_start();
	include_once("includes/config.php");
	$username = $_SESSION['userLoggedIn'];
	$query = "SELECT * FROM users WHERE username = :userLoggedIn";
	try {
		$stmt = $pdo->prepare($query);
		$stmt->bindValue(":userLoggedIn", $username);
		$stmt->execute();
	} catch (PDOException $e) {
		die("Error communicating with the database:" . $e );
	}
	$array = $stmt->fetch();
	$email = $array["email"];
	$picPath = $array["profilePic"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once("includes/links.php") ?>
	<link rel="stylesheet" href="/camagru/assets/css/profile.css">
	<script src="/camagru/assets/js/updatePicOnHover.js"></script>
	<script src="/camagru/assets/js/editProfilePic.js"></script>
	<title>Camagru - My Profile</title>
</head>
<body id="body">
	<? include_once("includes/navbar.php"); ?>
	<div class="container">
		<div class="jumbotron" id="form">
			<div id="spinner" class="spinner-border"></div>
			<a href="javascript:history.back()" class="goback">
				<img src="/camagru/assets/images/goback.png" alt="go back" width="30" height="30">
			</a>
			<div class="absolute-div">
				<form method="POST" action="profile.php">
				<input type="file" name="newPicture" id="newPicture" enctype="multipart/form-data">
					<label for="newPicture" class="pdp-container" id="pdpContainer">
						<img class="pdp" id="pdp" src="<?= $picPath ?>" width="150" height="150">
						<img class="update" id="updatePic" src="/camagru/assets/images/update.png" width="150" height="150">
					</label>
				</form>
			</div>
			<span class="label">Username:</span>
			<div class="info-container">
				<span class="info"><?= $username ?></span>
				<a href="/camagru/editUsername.php" class="edit">
					<img src="/camagru/assets/images/edit.png" width="20" height="20" alt="edit">
				</a>
			</div>
			<span class="label">Email Address:</span>
			<div class="info-container">
				<span class="info"><?= $email ?></span>
				<a href="/camagru/editEmail.php" class="edit">
					<img src="/camagru/assets/images/edit.png" width="20" height="20" alt="edit">
				</a>
			</div>
			<span class="label">Password:</span>
			<div class="info-container">
				<span class="info">****************</span>
				<a href="/camagru/editPassword.php" class="edit">
					<img src="/camagru/assets/images/edit.png" width="20" height="20" alt="edit">
				</a>
			</div>
		</div>
	</div>
	<canvas id=canvas></canvas>
</body>
</html>