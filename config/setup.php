<?php
	require('database.php');

		try {
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if (file_exists('Camagru.sql')) {
			$sql = file_get_contents('Camagru.sql');
			$pdo->exec($sql);
		} else {
			die('<h1>Error !</h1>');
		}
	} catch (PDOException $e) {
		die('Error: ' . $e->getMessage());
	}
	echo '<h1>Database created successfully !</h1>';
	// header('Location: ../index');