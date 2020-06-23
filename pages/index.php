
<?php

	require_once __DIR__ . '/../bootstrap.php';
	
	if (isset($_COOKIE['token'])) {
		$token = $_COOKIE['token'];
		if (isset($_COOKIE['msg'])) {
			$msg = $_COOKIE['msg'];
		}
	}

	function All_Advertising() {
		$data = [
			'fileds' => ['title' => true, 'price' => true, 'images' => true, 'UID'=>true]
		];
		$agahis = cockpit('collections')->find('agahi', $data);
		// $agahis = cockpit('collections')->find('agahi', $data);
		return $agahis;
	}

	function show_images($img_str, $token, $title) {
		$path = "../srcs/upload_img/$token/$title/$img_str";
		echo "<img src='$path' alt=$title style="."width:150px;height:150px;".">";

	}



?>








<html>
<header>
	<title>index</title>
</header>
<body>
	<div class="main">
		<?php
			if (isset($token)) {
				if (isset($msg)) {
					echo "<h3>$msg</h3>";
				}
			} else {
				echo "<a href="."./login.php".">login</a>";
			}
		?>
		<br>
		<br>
		<br>
		<hr>
		<br>
		<br>
		<?php
			if (isset($token)) {
				echo "<a href="."profile.php".">Profile</a><br>";
			}
		?>
		<br>
		<br>
		<hr>
		<h2>All Advertising</h2>
		<br>
		<br>
		<?php
			$agahis = All_Advertising();
			foreach ($agahis as $agahi) {
				echo "<hr>";
				$title = $agahi['title'];
				$price = $agahi['price'];
				$img   = $agahi['images'];
				$UID   = $agahi['UID'];
				echo "<span>title : </span>$title<br>";
				echo "<span>price : </span>$price<br>";
				// echo "<span>images : </span>$img<br>";
				show_images($img, $UID, $title);
			}
		?>

	</div>
</body>
</html>