<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/includes/session_expiry.php');
	if (!isset($_SESSION) || !isset($_SESSION['userLoggedIn']))
		header('Location: /camagru/index.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/config.php");
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
	if ($array === false && !isset($_GET['error'])) {
		header('Location: /camagru/profile?error=nouser');
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/links.php") ?>
	<link rel="stylesheet" href="/camagru/assets/css/profile.css">
	<link rel="stylesheet" href="/camagru/assets/css/gallery.css">
	<link rel="stylesheet" href="/camagru/assets/css/animations.css">
	<script src="/camagru/assets/js/updatePicOnHover.js"></script>
	<script src="/camagru/assets/js/editProfilePic.js"></script>
	<script src="/camagru/assets/js/postManagement.js"></script>
	<script src="/camagru/assets/js/deleteUser.js"></script>
	<script src="/camagru/assets/js/themeSwitcher.js"></script>
	<title>Camagru - My Profile</title>
	<script src="/camagru/assets/js/themeSwitcher.js"></script>
</head>
<body id="body">
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/navbar.php"); ?>
	<div class="everything">
		<div id="messages"></div>
		<div class="container">
			<div class="jumbotron mx-auto profile" id="form">
				<?php
					if (isset($_GET) && isset($_GET['error']) && $_GET['error'] === 'nouser') {
				?>
					<img src="/camagru/assets/images/icons-dark/bad.png" class ="bad" alt="good" width="200" height="200">
					<h1 class="display-4">User not found !</h1>
					<hr>
					<p class="lead">We cannot find any account with this username</p>
				<?php } else { ?>
					<div id="spinner" class="spinner-border"></div>
					<a href="javascript:history.back()" class="goback">
						<img src="/camagru/assets/images/icons-dark/goback.png" alt="go back" width="30" height="30">
					</a>
					<div class="divini">
						<div class="absolute-div" id="absoluteDiv" style="background-image: url('<?php echo $pcPath; ?>');">
						<?php if ( !isset($_GET) || !isset($_GET['username']) || $_GET['username'] === $_SESSION['userLoggedIn']) { ?>
							<form method="POST" action="profile.php">
							<input type="file" name="newPicture" id="newPicture" enctype="multipart/form-data">
								<label for="newPicture" id="pdpContainer">
									<img class="update click" id="updatePic" src="/camagru/assets/images/update.png">
								</label>
							</form>
						<?php } ?>
						</div>
					</div>
					<span class="label">Username:</span>
					<div class="info-container">
						<span class="info"><?php echo $un; ?></span>
						<?php
							if (!isset($_GET) || !isset($_GET['username']) || $_GET['username'] === $_SESSION['userLoggedIn'])
							echo '<a href="/camagru/editUsername.php" class="edit">
								<img class="click" src="/camagru/assets/images/icons-dark/edit.png" width="20" height="20" alt="edit">
							</a>';
						?>
					</div>
					<span class="label">Email Address:</span>
					<div class="info-container">
						<span class="info"><?php echo $em; ?></span>
						<?php
							if (!isset($_GET) || !isset($_GET['username']) || $_GET['username'] === $_SESSION['userLoggedIn'])
							echo '<a href="/camagru/editEmail.php" class="edit">
								<img class="click" src="/camagru/assets/images/icons-dark/edit.png" width="20" height="20" alt="edit">
							</a>';
						?>
					</div>
					<?php
						if (!isset($_GET) || !isset($_GET['username']) || $_GET['username'] === $_SESSION['userLoggedIn'])
							echo '<span class="label">Password:</span>
							<div class="info-container">
								<span class="info">****************</span>
								<a href="/camagru/editPassword.php" class="edit">
										<img class="click" src="/camagru/assets/images/icons-dark/edit.png" width="20" height="20" alt="edit">
								</a>
							</div>';
					?>
					<span class="label">Member since:</span>
					<div class="info-container">
						<span class="info"><?php echo $date; ?></span>
					</div>
				<?php } 
					if ((!isset($_GET) || !isset($_GET['username']) || $_GET['username'] === $_SESSION['userLoggedIn']) && !isset($_GET['error']))
					echo '<button id="deleteUserButton" class="btn btn-danger" style="margin-top: 50px"><img src="/camagru/assets/images/bad.png" width="20" height="20" style="margin-right: 10px">Delete my account</button>';
				?>
			</div>
			<?php if (!isset($_GET) || !isset($_GET['error']) || $_GET['error'] !== 'nouser') { ?>
			<div id="userPostsContainer">
			</div>
			<?php } ?>
		</div>
		<canvas id=canvas></canvas>
		<div class="alert-container" id="alert-container">
			<div class="container" id="alert-body">
				<div class="alert-card jumbotron text-center m-auto">
					<h1 class="text-break">Are you sure ?</h1>
					<hr>
					<p class="lead text-break">Do you really want to delete this post?<br>This action is irreversible!</p>
					<button class="btn btn-lg botona my-2 mx-4 click" id="delete">
						<img src="/camagru/assets/images/icons-dark/good.png" alt="yes" width="30" height="30">
						Delete
					</button>
					<button class="btn btn-lg botona m-0 mx-4 click" id="cancel">
						<img src="/camagru/assets/images/icons-dark/bad.png" alt="no" width="30" height="30">
						Cancel
					</button>
				</div>
			</div>
		</div>
		<div class="alert-container" id="alertDelete-container">
			<div class="container" id="alertDelete-body">
				<div class="alert-card jumbotron text-center m-auto">
					<h1 class="text-break">Are you sure ?</h1>
					<hr>
					<p class="lead text-break">Do you really want to delete your account?<br>This action is irreversible!</p>
					<button class="btn btn-lg botona my-2 mx-4 click" id="deleteUser">
						<img src="/camagru/assets/images/icons-dark/good.png" alt="yes" width="30" height="30">
						Delete
					</button>
					<button class="btn btn-lg botona m-0 mx-4 click" id="cancelDeleteUser">
						<img src="/camagru/assets/images/icons-dark/bad.png" alt="no" width="30" height="30">
						Cancel
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="loading-container" id="loading" style="display: block;">
		<div class="container">
			<div class="jumbotron mx-auto profile loading2">
				<div class="absolute-div loading" style="height:150px; width:150px; display:block; margin:auto; border-radius:200px"></div>
				<div class="loading" style="height:20px; width:20%; display:block; margin-top:20px"></div>
				<div class="info loading" style="height:50px; width:100%; display:block; border-radius: 10px; margin-top:10px"></div>
				<div class="loading" style="height:20px; width:20%; display:block; margin-top:20px"></div>
				<div class="info loading" style="height:50px; width:100%; display:block; border-radius: 10px; margin-top:10px"></div>
				<div class="loading" style="height:20px; width:20%; display:block; margin-top:20px"></div>
				<div class="info loading" style="height:50px; width:100%; display:block; border-radius: 10px; margin-top:10px"></div>
			</div>
			<div class="jumbotron py-3 px-3 mx-auto post loading2">
							<a class="text-decoration-none text-reset click">
								<img class="profilepic" src="/camagru/assets/images/icons-dark/blank-pdp.png" width="30" height="30" class="d-inline-block align-top" >
								<span class="text loading" style="width:20%; height:20px; display:inline-block;  vertical-align:middle"> </span>
								<span class="badge badge-secondary new-badge loading" style="width:50px; height:20px; display:inline-block;  vertical-align:middle; border-radius:10px; transition-duration: none"></span>
								</a>
								<hr class="separator loading">
								<p class="text-break loading" style="width:50%; height:20px; display:inline-block;  vertical-align:middle"></p>
								<div class="heartContainer"></div>
								<img class="loading postImg" src="/camagru/assets/images/icons-dark/blank-post.png">
								<hr class="loading separator">
								<img class="loading" src="/camagru/assets/images/icons-dark/blank-icon.png" width="33" height="30" style="border-radius:200px"><span class="loading" style="width:50px; height:20px; display:inline-block; margin-left:10px; vertical-align:middle"></span>
								<img class="loading" src="/camagru/assets/images/icons-dark/blank-icon.png" width="33" height="30" style="border-radius:200px"><span  class="loading" style="width:50px; height:20px; display:inline-block; margin-left:10px; vertical-align:middle"></span>
								<img class="loading" src="/camagru/assets/images/icons-dark/blank-icon.png" width="33" height="30" style="border-radius:200px">
							</img>
						</div>
		</div>
	</div>
</body>
</html>