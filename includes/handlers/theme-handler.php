<?php
	include_once('../classes/Theme.class.php');

	$theme = new Theme();

	if (isset($_POST['getTheme'])) {
		exit($theme->getTheme());
	}

	if (isset($_POST['setTheme'])) {
		if ($_POST['setTheme'] === '1')
			$theme->setLightTheme();
		else
			$theme->setDarkTheme(); 
	}