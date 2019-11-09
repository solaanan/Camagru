<?php
	class Post {
		private		$pdo;
		private		$errorArray;

		public function		__construct($pdo) {
			$this->pdo = $pdo;
			$this->errorArray = array();
		}

		public function validateImage($base64) {
			$data = str_replace('data:image/png;base64,', '');
			$data = str_replace(' ', '+');
			$data = base64_decode($data);
			$tmp = '../../assets/images/tmp';
			if (!file_exists($tmp)) {
				mkdir($tmp);
			}
			$name = $tmp . uniqid('IMG_TMP_') . '.png';
			file_put_contents($name, $data);
			if (getimagesize($name)) {
				if (filesize($name) > 8000000) {
					array_push($this->errorArray, Constants::$imageTooBig2)
				}
			} else {
				array_push($this->errorArray, Constants::$imageCannotBeFound);
				unlink($name);
				return false;
			}
		}
	}