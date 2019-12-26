<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . "/camagru/includes/config.php");
	if (isset($_SESSION['userLoggedIn'])) {
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
	}
?>

<script src="/camagru/assets/js/responsiveNavbar.js"></script>
<div class="topnav" id="navbarElements">
	<a class="navbar-brand click" href="/camagru/index.php">
	<img src="/Camagru/assets/images/logo.svg" width="30" height="30" class="d-inline-block align-top" alt="">
	<span id="brand"> Camagru </span>
	</a>
	<a id="themeSelector" class="click">
		<img class="logout" src="/Camagru/assets/images/light.png" width="25" height="25" class="d-inline-block align-top" alt="">
		<span class="text themeName"> Light mode </span>
	</a>
	<?php
		if (isset($_SESSION['userLoggedIn'])) {
		echo '
		<a class="click" href="/Camagru/logout.php">
			<img class="logout" src="/Camagru/assets/images/icons-dark/logout.png" width="25" height="25" class="d-inline-block align-top" alt="">
			<span class="text"> Log out </span>
		</a>
		<a class="click" href="/Camagru/profile.php" id="">
			<div id="imgNavbar" class="profilepic" style="background-image:url(\''. $picPath .'\')" width="30" height="30" class="d-inline-block align-top"></div>
			<span class="text" id="userLoggedIn">'. $username .'</span>
		</a>
		';
		}else{
		echo '
		<a class="click" href="/Camagru/login.php">
			<img class="logout" src="/Camagru/assets/images/icons-dark/login.png" width="25" height="25" class="d-inline-block align-top" alt="">
			<span class="text"> Log in </span>
		</a>
		<a class="click" href="/Camagru/gallery">
			<img class="logout" src="/Camagru/assets/images/icons-dark/snap.png" width="30" height="23" class="d-inline-block align-top" alt="">
			<span class="text"> Gallery </span>
		</a>
		';
		}
	?>
	<a class="bars">
		<img src="/camagru/assets/images/bars.png" width="30" height="30" id="collapsor">
	</a>
</div>
<a class="goUp" href="#" id="goUp">
		<img src="/camagru/assets/images/icons-dark/goUp.png" alt="go up" width="30" height="30">
</a>
<script>
	window.addEventListener('scroll', function() {
		var goUp = document.getElementById('goUp');
		if (document.documentElement.scrollTop > 2508) {
			goUp.style.opacity = '1';
		} else {
			goUp.style.opacity = '0';
		}
	});
</script>