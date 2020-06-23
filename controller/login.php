
<?php
	
	require_once "../config/config_pruject.php";
	require_once __DIR__ . '/../bootstrap.php';

	// tarif func baraye login kardan
	function login($username, $password) {
		// echo $GLOBALS['iv'];
		// $ivlen    = openssl_cipher_iv_length($GLOBALS['algoritm']);
		// $iv       = openssl_random_pseudo_bytes($ivlen);
		// var_dump($iv);
		// var_dump($ivlen);
		// $passwords = openssl_encrypt($password, $GLOBALS['algoritm'], $GLOBALS['key'], 0, $GLOBALS['iv']);
		// echo $passwords;
		// echo "----------string----------";
		$password = openssl_encrypt($password, $GLOBALS['algoritm'], $GLOBALS['key'], 0, $GLOBALS['iv']);
		// echo $passwordsd;
		$obj = [
			'fields' => ['id'=> true,'_id'=>false],
			'filter' => ['username'=>$username, 'password'=>$password],
			'limit'  => 1
		];
		$user = cockpit('collections')->find('User', $obj);

		// var_dump($user);
		if (count($user) == 1) {
			return $user[0]['id'];
		} else {
			return false;
		}
	}
	// $user = login('user1', '12345678');
	// echo $user;


	// baraye api
	header('Content-Type: application/json');

	// controller request
	if (isset($_GET['login'])) {
		if (isset($_GET['username']) and !empty($_GET['username']) and isset($_GET['password']) and !empty($_GET['password'])) {
			$username = $_GET['username'];
			$password = $_GET['password'];
			$user     = login($username, $password);
			if ($user) {
				$result = array(
					'ok'        => 'ok',
					'login_msg' => 'success',
					'id'        => $user
				);
				echo json_encode($result);
				exit();
			} else {
				$result = array(
					'ok'        => 'error',
					'login_msg' => 'user not found'
				);
				echo json_encode($result);
				exit();
			}
		}
		else {
			$result = array(
				'ok'        => 'error',
				'login_msg' => 'Please fill all fields'
			);
			echo json_encode($result);
			exit();
		}
	} else {
		$result = array(
			'ok'        => 'error',
			'login_msg' => 'request invalid'
		);
		echo json_encode($result);
		exit();
	}






?>