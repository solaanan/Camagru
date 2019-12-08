<?php

	class Theme {
		public function		setDarkTheme() {
				setcookie('theme', '0', array('expires' => time() + (60 * 60 * 24 * 30)));
		}

		public function		setLightTheme() {
				setcookie('theme', '1', array('expires' => time() + (60 * 60 * 24 * 30)));
		}

		public function		getTheme() {
			if (isset($_COOKIE) && isset($_COOKIE['theme'])) {
				return ($_COOKIE['theme']);
			} else {
				return '0';
			}
		}
	}