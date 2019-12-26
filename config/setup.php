<?php
	require('database.php');

		try {
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if (file_exists('Camagru.sql')) {
			$sql = file_get_contents('Camagru.sql');
			$pdo->exec($sql);
		}
	} catch (PDOException $e) {
		die('Error: ' . $e->getMessage());
	}
	// header('Location: ../index');