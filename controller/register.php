
<?php

	require_once "../config/config_pruject.php";
	require_once __DIR__ . '/../bootstrap.php';

	function register($username, $password, $email) {
		$obj      = [
			'fields' => ['username'=> true,'_id'=>false],
			'filter' => ['username'=> $username]
		];
		$find_usr = cockpit('collections')->find('User', $obj);

		if (count($find_usr) >= 1) {
			return false;
		} else {
			// $ivlen    = openssl_cipher_iv_length($GLOBALS['algoritm']);
			// $iv       = openssl_random_pseudo_bytes($ivlen);
			$id       = openssl_encrypt($GLOBALS['str_usr_crt'] . $username, $GLOBALS['algoritm'], $GLOBALS['key'], 0, $GLOBALS['iv']);
			$password = openssl_encrypt($password, $GLOBALS['algoritm'], $GLOBALS['key'], 0, $GLOBALS['iv']);
			$data     = [
				"username" => $username,
				"password" => $password,
				"email"    => $email,
				"id"       => $id
			];
			$saveUser = cockpit('collections')->save("User", $data);
			return $saveUser;
		}

	}


	header('Content-Type: application/json');

	if (isset($_GET['register'])) {
		if (isset($_GET['username']) and !empty($_GET['username']) and isset($_GET['email']) and !empty($_GET['email']) and isset($_GET['password']) and !empty($_GET['password']) ) {
			$username = $_GET['username'];
			$password = $_GET['password'];
			$email    = $_GET['email'];
			if (strlen($username) >= 4) {
				if (strlen($password) >= 8) {
					$user = register($username, $password, $email);
					if ($user) {
						$result = array(
							'ok'        => "ok",
							'login_msg' => "success",
							'id'        => $user['id']
						);
						echo json_encode($result);
						exit();
					} else {
						$result = array(
							'ok'        => "error",
							'login_msg' => "in user gablan gerefte shode ast"
						);
						echo json_encode($result);
						exit();
					}
				}
				else {
					$result = array(
						'ok'        => 'error',
						'login_msg' => 'please enter longer password'
					);
					echo json_encode($result);
					exit();
				}
			}
			else {
				$result = array(
					'ok'        => 'error',
					'login_msg' => 'please enter longer username'
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
		
	}
	else {
		$result = array(
			'ok'        => 'error',
			'login_msg' => 'request invalid'
		);
		echo json_encode($result);
		exit();
	}


?>