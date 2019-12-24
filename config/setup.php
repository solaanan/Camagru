<?php
	require('database.php');

		$pdo = new PDO("mysql:host=10.12.2.2;port:8080;", $DB_USER, $DB_PASSWORD);
		if (file_exists('Camagru.sql')) {
			$sql = file_get_contents('Camagru.sql');
			$pdo->exec($sql);
		}
	header('Location: ../index');