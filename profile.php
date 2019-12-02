<?php
	session_start();
	if (!isset($_SESSION) || !isset($_SESSION['userLoggedIn']))
		header('Location: /camagru/index.php');
	include_once("includes/config.php");
	if (isset($_GET) && isset($_GET['username']))
		$un = $_GET['username'];
	else
		$un = $_SESSION['userLoggedIn'];
	$query = "SELECT * FROM users WHERE username = :userLoggedIn";
	try {
		$stmt = $pdo->prepare($query);
		$stmt->bindValue(":userLoggedIn", $un);
		$stmt->execute();
	} catch (PDOException $e) {
		die("Error communicating with the database:" . $e );
	}
	$array = $stmt->fetch();
	$em = $array["email"];
	$pcPath = $array["profilePic"];
	$date = $array['signUpDate'];
	if ($array === false) {
		header('Location: /camagru/profile?error=nouser');
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once("includes/links.php") ?>
	<link rel="stylesheet" href="/camagru/assets/css/profile.css">
	<link rel="stylesheet" href="/camagru/assets/css/gallery.css">
	<link rel="stylesheet" href="/camagru/assets/css/animations.css">
	<script src="/camagru/assets/js/updatePicOnHover.js"></script>
	<script src="/camagru/assets/js/editProfilePic.js"></script>
	<script src="/camagru/assets/js/postManagement.js"></script>
	<title>Camagru - My Profile</title>
</head>
<body id="body">
	<?php include_once("includes/navbar.php"); ?>
	<div class="container">
		<div class="jumbotron mx-auto profile" id="form">
			<?php
				if (isset($_GET) && isset($_GET['error']) && $_GET['error'] === 'nouser') {
			?>
				<img src="/camagru/assets/images/bad.png" class ="bad" alt="good" width="200" height="200">
				<h1 class="display-4">User not found !</h1>
				<hr>
				<p class="lead">We cannot find any account with this username</p>
			<?php } else { ?>
				<div id="spinner" class="spinner-border"></div>
				<a href="javascript:history.back()" class="goback">
					<img src="/camagru/assets/images/goback.png" alt="go back" width="30" height="30">
				</a>
				<div class="divini">
					<div class="absolute-div" id="absoluteDiv" style="background-image: url('<?php echo $pcPath; ?>');">
						<form method="POST" action="profile.php">
						<input type="file" name="newPicture" id="newPicture" enctype="multipart/form-data">
							<label for="newPicture" id="pdpContainer">
								<img class="update click" id="updatePic" src="/camagru/assets/images/update.png">
							</label>
						</form>
					</div>
				</div>
				<span class="label">Username:</span>
				<div class="info-container">
					<span class="info"><?php echo $un; ?></span>
					<?php
						if ($_GET['username'] === $_SESSION['userLoggedIn'] || !isset($_GET) || !isset($_GET['username']))
						echo '<a href="/camagru/editUsername.php" class="edit">
							<img class="click" src="/camagru/assets/images/edit.png" width="20" height="20" alt="edit">
						</a>';
					?>
				</div>
				<span class="label">Email Address:</span>
				<div class="info-container">
					<span class="info"><?php echo $em; ?></span>
					<?php
						if (!isset($_GET) || !isset($_GET['username']) || $_GET['username'] === $_SESSION['userLoggedIn'])
						echo '<a href="/camagru/editUsername.php" class="edit">
							<img class="click" src="/camagru/assets/images/edit.png" width="20" height="20" alt="edit">
						</a>';
					?>
				</div>
				<?php
					if (!isset($_GET) || !isset($_GET['username']) || $_GET['username'] === $_SESSION['userLoggedIn'])
						echo '<span class="label">Password:</span>
						<div class="info-container">
							<span class="info">****************</span>
							<a href="/camagru/editUsername.php" class="edit">
									<img class="click" src="/camagru/assets/images/edit.png" width="20" height="20" alt="edit">
							</a>
						</div>';
				?>
				<span class="label">Member since:</span>
				<div class="info-container">
					<span class="info"><?php echo $date; ?></span>
				</div>
			<?php } ?>
		</div>
		<?php if (!isset($_GET) || !isset($_GET['error']) || $_GET['error'] !== 'nouser') { ?>
		<div id="postsContainer">
			<?php $loggedin = true; include_once('includes/refresh_posts.php') ?>
		</div>
		<?php } ?>
	</div>
	<canvas id=canvas></canvas>
</body>
</html>