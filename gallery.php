<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include("includes/links.php") ?>
	<link rel="stylesheet" href="/camagru/assets/css/gallery.css">
	<title>Camagru - Gallery</title>
</head>
<body>
	<?php include("includes/navbar.php"); ?>
	<div class="container">
		<div class="jumbotron top-jumbotron text-center mx-auto">
			<a class="btn btn-primary btn-lg" href="#" role="button">Add a new post</a>
		</div>
		<div class="jumbotron py-3 px-3 mx-auto">
			<a class="text-decoration-none text-reset" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img class="profilepic" src="/camagru/assets/images/profilePics/default.png" width="30" height="30" class="d-inline-block align-top" alt="">
				<span class="text"> Holk <span class="badge badge-secondary new-badge">New</span></span>
			</a>
			<hr class="separator">
			<img class="post" src="/camagru/assets/images/tmp.png" alt="">
			<hr class="separator">
			<img src="/camagru/assets/images/like-1.png" width="33" height="30" alt="like">
			<img src="/camagru/assets/images/comment.png" width="33" height="30" alt="like">
			<img src="/camagru/assets/images/share.png" width="33" height="30" alt="like">
		</div>
	</div>
</body>
</html>