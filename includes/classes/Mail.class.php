<?php
	if (!isset($_SESSION))
		session_start();
	class Mail {
		public function confirm_mail($username, $email, $token) {
			$to = $email;
			$from = 'sohbay.852@gmail.com';
			$fromName = 'Camagru Service';
			
			$subject = "Camagru - Please verify your email address";
			
			$htmlContent = '
			<html>
				<head>
					<link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
					<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&display=swap&subset=latin-ext" rel="stylesheet">
					<style>
					*{
						margin: 0;
						padding: 0;
					}
					#brand {
						font-family: "Lobster", cursive;
						font-size: 30px;
					}
					a:link {color:#FFF;}
					a:visited {color:#FFF;}
					a:active {color:#FFF;}
					.email{
						background-color: #272f51;
						width: 80%;
						max-width: 960px;
						min-width: 450px;
						margin: auto;
						font-family: "Lato", sans-serif;
						border-bottom: 2px solid #d6d6d6;
						text-align: center;
						border-radius: 5px;
						overflow: hidden;
					}
					.header{
						background-color: #272f51;
						padding: 100px 0px;
						color: white;
						display: block;
					}
					.title{
						color: white;
						padding: 30px 0px;
						font-weight: bold;
						background: #191e36;
					}
					.message{
						padding: 30px 15% 30px 15%;
						color: white;
						text-align: left;
					}
					.confirm{
						text-decoration: none;
						color: white;
						padding: 10px 50px;
						display: inline-block;
						margin-bottom: 60px;
						border-radius: 5px;
					}
				</style>
				</head>
					<body>
					<div class="bg">
						<div class="email">
							<div class="header">
								<div class="brand">
									<img src="https://i.imgur.com/M0HJEPW.png" width="30" height="30" class="d-inline-block align-top" alt="">
									<span id="brand"> Camagru </span>
								</div>
							</div>
							<h2 class="title">Email Confirmation</h2>
							<p class="message">Hey '. $username .'.<br>
							Thanks for signing up!<br>Before we get started, we just need you to confirm your email address.
							This will enhance overall<br>account security, and could help you recover your account if you forget 
							your password.<br>It’s also good for us to know that you’re not a robot :)<br>Please click the button 
							below to complete your account registration.</p>
							<a href="http://localhost/camagru/confirm.php?token='. $token .'" class="confirm">
								<img src="https://i.imgur.com/2vGe5lT.png" alt="confirmation-buttom">
							</a>
						</div>
					</div>
					</body>
				</html>
				';
			$headers = "From: " . $from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			if (mail($to, $subject, $htmlContent, $headers))
				return true;
			return false;
		}

		public function reset_password($email, $token) {
			$to = $email;
			$from = 'sohbay.852@gmail.com';
			$fromName = 'Camagru Service';
			
			$subject = "Camagru - Reset your password";
			
			$htmlContent = '
			<html>
				<head>
					<link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
					<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&display=swap&subset=latin-ext" rel="stylesheet">
					<style>
					*{
						margin: 0;
						padding: 0;
					}
					#brand {
						font-family: "Lobster", cursive;
						font-size: 30px;
					}
					a:link {color:#FFF;}
					a:visited {color:#FFF;}
					a:active {color:#FFF;}
					.email{
						background-color: #272f51;
						width: 80%;
						max-width: 960px;
						min-width: 450px;
						margin: auto;
						font-family: "Lato", sans-serif;
						border-bottom: 2px solid #d6d6d6;
						text-align: center;
						border-radius: 5px;
						overflow: hidden;
					}
					.header{
						background-color: #272f51;
						padding: 100px 0px;
						color: white;
						display: block;
					}
					.title{
						color: white;
						padding: 30px 0px;
						font-weight: bold;
						background: #191e36;
					}
					.message{
						padding: 30px 15% 30px 15%;
						color: white;
						text-align: left;
					}
					.confirm{
						text-decoration: none;
						color: white;
						padding: 10px 50px;
						display: inline-block;
						margin-bottom: 60px;
						border-radius: 5px;
					}
				</style>
				</head>
					<body>
					<div class="bg">
						<div class="email">
							<div class="header">
								<div class="brand">
									<img src="https://i.imgur.com/M0HJEPW.png" width="30" height="30" class="d-inline-block align-top" alt="">
									<span id="brand"> Camagru </span>
								</div>
							</div>
							<h2 class="title">Reset your password</h2>
							<p class="message">Hey There.<br>
							You asked to reset your account password, click the button below:</p>
							<a href="http://localhost/camagru/resetPassword?token='. $token .'" class="confirm">
								<img src="https://i.imgur.com/2vGe5lT.png" alt="confirmation-buttom">
							</a>
						</div>
					</div>
					</body>
				</html>
				';
			$headers = "From: " . $from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			if (mail($to, $subject, $htmlContent, $headers))
				return true;
			return false;
		}
	}