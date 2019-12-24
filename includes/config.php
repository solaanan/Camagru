<?php
	date_default_timezone_set('Europe/Paris');
	$DB_DSN = 'mysql:dbname=camagru;host=10.12.2.2;port:8080';
	$DB_USER = 'root';
	$DB_PASSWORD = 'tiger';

	try 
	{
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e) {
		echo 'Erreur de connection: ' . $e->getMessage();
	}
