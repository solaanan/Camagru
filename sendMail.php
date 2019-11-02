<?php
	$to = 'piyim45846@mail8app.com';
	$from = 'slaanani.camagru@gmail.com';
	$fromName = 'Camagru';
	
	$subject = "Camagru - Please verify your email address";
	
	$htmlContent = '
	<!DOCTYPE html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="http://localhost/Camagru/assets/frameworks/bootstrap/css/bootstrap.css">
		<link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
		<style>
			* {
		margin: 0;
		padding: 0;
		outline: 0;
		}

		#brand {
			font-family: "Lobster", cursive;
			font-size: 30px;
		}

		body
		{
			background: #1c2444;
			font-family: Montserrat, sans-serif;
			width: 100%;
			height: 100%;
		}

		.jumbotron
		{
			margin-top: 100px;
			background-color: #272f51E5;
			color: white;
		}

		.navbar {
			background-color: #272f51;
			color: white;
			line-height: 30px;
		}

		.navbar-brand {
			margin: auto;
		}
		</style>
		<title>Camagru - Verify your email</title>
	</head>
	<body>
		<div class="container">
			<div class="jumbotron">
			<h1 class="display-4">Thank you for joining Camagru!</h1>
				<p class="lead">Please confirm your email address by clicking the link below.</p>
				<hr class="my-4">
				<a class="btn btn-primary btn-lg botona" href="http://localhost/camagru/register.php" role="button">Confirm your email</a>
			</div>
		</div>
	</body>
	</html>';
	
	// Set content-type header for sending HTML email
	$subject = "Confirmation mail";
	$headers = "From: " . $from . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	// Send email
	if(mail($to, $subject, $htmlContent, $headers)){
		echo 'Email has sent successfully.';
	}else{
	echo 'Email sending failed.';
	}
?>
