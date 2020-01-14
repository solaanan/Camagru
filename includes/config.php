<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	date_default_timezone_set('Europe/Paris');
	$DB_DSN = 'mysql:dbname=Camagru;host=localhost:3306';
	$DB_USER = 'slaanani';
	$DB_PASSWORD = 'I09m13G07o15@@';

	try 
	{
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e) {
		die('Erreur de connection: ' . $e->getMessage());
	}
