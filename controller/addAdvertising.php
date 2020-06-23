
<?php
	require_once "../config/config_pruject.php";
	require_once __DIR__ . '/../bootstrap.php';

	if (isset($_POST['addAdvertising'])) {
		if (isset($_POST['title']) and !empty($_POST['title']) and isset($_POST['price']) and !empty($_POST['price'])) {
			$title = $_POST['title'];
			$price = $_POST['price'];
			if (title_exists($title)) {
				if (isset($_FILES['file'])) {
					$file     = $_FILES['file'];
					$token    = $_COOKIE['token'];
					$path     = '../srcs/upload_img';
					$uploaded = upload($file, $path, $token, $title);
					if (substr($uploaded, 0, 5) == "error") {
						header('location: ../pages/profile.php?msg' . $uploaded);
						exit();
					} else {
						$save = set_Advertising($title, $price, $file['name'], $token);
						if ($save) {
							header('location: ../pages/profile.php?msg=success');
							exit();
						} else {
							header('location: ../pages/profile.php?msg=Error in save advertiding');
							exit();
						}
					}
				} else {
					header('location: ../pages/profile.php?msg=file is empty');
					exit();
				}
			} else {
				header('location: ../pages/profile.php?msg=this title is exists');
				exit();
			}
		} else {
			header('location: ../pages/profile.php?msg=empty fields');
			exit();
		}
	} else {
		header('location: ../pages/profile.php?msg=bad request');
		exit();
	}

	function title_exists($title) {
		$data = [
			'filter' => ['title' => $title]
		];

		$agahi = cockpit('collections')->find('agahi', $data);
		if (count($agahi) >= 1) {
			return false;
		} else {
			return true;
		}
	}

	function upload($file, $path, $folder_name, $title) {
		$file_type = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
		if ($file_type == 'img' or $file_type == 'png' or $file_type == 'jpg' ) {
			if ($file['size'] > 5000000) {
				return "error.file is too large. we can save file if lower 5mb";
			} else {
				$dir = "../srcs/upload_img/" . $folder_name . "/";
				if (!is_dir($dir)) {
					mkdir($dir);
				}
				$dir = $dir . $title . "/";
				if (!is_dir($dir)) {
					mkdir($dir);
				}
				$path = $dir . $file['name'];
				if (move_uploaded_file( $file["tmp_name"], $path)) {
					$msg = "success.The file has been uploaded";
					return "success.The file has been uploaded";
				} else {
					return "error.Sorry, there was an error uploading your file";
				}
			}
		} else {
			return 'error.file is not image';
		}
	}


	function set_Advertising($title, $price, $img, $token) {
		$data = [
			'title'  => $title,
			'price'  => $price,
			'images' => $img,
			'UID'    => $token
		];
		$agahi = cockpit('collections')->save('agahi', $data);
		if (count($agahi) >= 1) {
			return 'success';
		} else {
			return false;
		}
	}




?>