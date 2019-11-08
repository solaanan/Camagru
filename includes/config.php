<?php
	date_default_timezone_set('Europe/France');
	$dsn = 'mysql:dbname=Camagru;host=10.12.2.2;port:8080';
	$user = 'root';
	$password = '';
	
	try {
		$pdo = new PDO($dsn, $user, $password);
	} catch (PDOException $e) {
		die( 'Connection failed: ' . $e->getMessage());
	}