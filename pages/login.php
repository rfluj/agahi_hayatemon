
<?php

	if (isset($_COOKIE['token'])) {
		header('location: ./index.php');
		exit();
	}
	
	if (isset($_POST['login'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$url      = "http://127.0.0.1/sarv/controller/login.php?login=ok&username=" . $username . "&password=" . $password;
		$client   = curl_init($url);
		curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
		$response = curl_exec($client);
		curl_close($client);
		$result   = json_decode($response);
		// var_dump($result);
		// echo $result->{'ok'};
		// echo $result->{'login_msg'};
		if ($result->{'ok'} === 'ok') {
			setcookie('token', $result->{'id'}, 0, '/');
			setcookie('msg', 'wellcome back', 0, '/');
			header('location: ./index.php');
			exit();
		} else {
			$login_msg = $result->{'login_msg'};
		}
	} elseif (isset($_POST['register'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email    = $_POST['email'];
		$url      = "http://127.0.0.1/sarv/controller/register.php?username=" . $username . "&password=" . $password . "&email=" . $email . "&register=ok";
		$client   = curl_init($url);
		curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
		$response = curl_exec($client);
		curl_close($client);
		$result   = json_decode($response);
		if ($result->{'ok'} === 'ok') {
			setcookie('token', $result->{'id'}, 0, '/');
			setcookie('msg', 'wellcome', 0, '/');
			header('location: ./index.php');
			exit();
		} else {
			$register_msg = $result->{'login_msg'};
		}

		// echo $result->{'id'};
	}

?>



<html>
<header>
	<title>login</title>
</header>
<body>
	<?php
		if (isset($_GET['msg'])) {
			echo "<span>first login</span><br>";
		}
	?>
	<div class="form">
		<?php
			if (isset($login_msg)) {
				echo "<span>$login_msg</span><br>";
			}
		?>
		<form action="#" method="post">
			<span>username</span>
			<br>
			<input type="text" name="username" placeholder="Username">
			<br>
			<span>password</span>
			<br>
			<input type="password" name="password" placeholder="Password">
			<br>
			<input type="submit" name="login" value="Login">
		</form>
		<hr>
		<?php
			if (isset($register_msg)) {
				echo "<span>$register_msg</span><br>";
			}
		?>
		<form action="#" method="post">
			<span>username - more than 4</span>
			<br>
			<input type="text" name="username" placeholder="Username">
			<br>
			<span>email</span>
			<br>
			<input type="email" name="email" placeholder="Email">
			<br>
			<span>password - more than 8</span>
			<br>
			<input type="password" name="password" placeholder="Password">
			<br>
			<input type="submit" name="register" value="register">
		</form>
	</div>
</body>
</html>