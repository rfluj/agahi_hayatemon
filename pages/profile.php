
<?php
	
	require_once __DIR__ . '/../bootstrap.php';

	if (!isset($_COOKIE['token'])) {
		header('location: ./login.php?msg=nologin');
		exit();
	} else {
		$token = $_COOKIE['token'];
	}

	function my_adversiting($token) {
		$data = [
			'fileds' => ['title' => true, 'price' => true, 'images' => true, 'UID'=>false],
			'filter' => ['UID' => $token]
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
<head>
	<title>profile</title>
</head>
<body>
	<!-- <img src="../srcs/upload_img/" alt=""> -->
	<div class="main">
		<?php
			if (isset($_GET['msg'])) {
				echo $_GET['msg'];
			}
		?>
		<span>my Advertising</span>
		<?php
			$agahis = my_adversiting($token);
			foreach ($agahis as $agahi) {
				echo "<hr>";
				$title = $agahi['title'];
				$price = $agahi['price'];
				$img   = $agahi['images'];
				echo "<span>title : </span>$title<br>";
				echo "<span>price : </span>$price<br>";
				// echo "<span>images : </span>$img<br>";
				show_images($img, $token, $title);
		?>
			<form action="./editadvertising.php" method="post">
				<input type="hidden" name="title" value=<?php echo $title; ?>>
				<input type="submit" name="edit" value="Edit">
				<input type="submit" name="delete" value="Delete">
			</form>
		<?php
				echo "<hr>";
			}
		?>
		<hr>
		<span>add Advertising</span>
		<form action="../controller/addAdvertising.php" method="post" enctype="multipart/form-data">
			<input type="text" name="title" placeholder="title">
			<br>
			<input type="number" name="price" placeholder="price">
			<br>
			<input type="file" name="file">
			<br>
			<input type="submit" name="addAdvertising" value="Add">
		</form>
		<?php

		?>
	</div>
</body>
</html>


