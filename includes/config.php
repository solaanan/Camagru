<?php
	date_default_timezone_set('Europe/Paris');
	// $dsn = 'mysql:dbname=Camagru;host=10.12.2.2;port:8080';
	$dsn = 'mysql:dbname=Camagru;host=localhost;port:3306';
	$user = 'root';
	$password = '';
	
	try {
		$pdo = new PDO($dsn, $user, $password);
	} catch (PDOException $e) {
		die( 'Connection failed: ' . $e->getMessage());
	}