<?php

	class Theme {
		public function		setDarkTheme() {
				setcookie('theme', '0', time() + (60 * 60 * 24 * 30), '/', NULL, 0 );
		}

		public function		setLightTheme() {
				setcookie('theme', '1', time() + (60 * 60 * 24 * 30), '/', NULL, 0 );
		}

		public function		getTheme() {
			if (isset($_COOKIE) && isset($_COOKIE['theme'])) {
				return ($_COOKIE['theme']);
			} else {
				return '0';
			}
		}
	}