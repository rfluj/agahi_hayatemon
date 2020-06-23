
<?php
	// require_once "../config/config_pruject.php";
	// require_once __DIR__ . "/../modules/Cockpit/Controller/RestApi.php";
	// $api = new RestApi();
	// $api->authUser();
	require_once __DIR__ . '/../bootstrap.php';
	// $app = cockpit();
	// $user = $app -> module("auth") -> getUser();

	// $agahis = cockpit('collections')->find('agahi', [
	// 	// 'filter' => ['published' => true],
	// 	'fields' => ['title'=> true, '_id'=>false],
	// 	// 'limit' => 10
	// ]);

	# ['user'=>'aref', 'name'=>'aref', 'email'=>'aref@gmail.com', 'group'=>'user', 'password'=>'aref']

	// echo "string";
	// $user = cockpit('cockpit')->authenticate(['user'=>'rfluj', 'password'=>'772009|\|bt']);
	$set  = cockpit('cockpit')->setUser(['user'=>'newuser', 'password'=>'newuser', 'email'=>'newuser@gmail.com', 'group'=>'user'], false);
	// echo "string";
	var_dump($set);
	

	// // $user = cockpit('cockpit')->create();
	// var_dump($user);

	// if ($user) {
	// 	echo "true";
	// } else {
	// 	echo "false";
	// }

	// echo json_encode($agahis);
	// $app = cockpit();
	// $app->get('/', function () use ($app) {
	//     $collections = cockpit('collections:collections', []);
	//     // $galleries = cockpit('galleries:galleries', []);
	//     var_dump($collections);

	//     // return $app['twig']->render('index.html.twig', ['collections' => $collections, 'galleries' => $galleries]);
	// });
	// var_dump(json_encode($app));
	// print_r(json_encode($app));
	
	function login($username, $password) {
		$url      = "http://127.0.0.1/sarv/api/cockpit/authUser?user=" . $username . '&password=' . $password . '&token=' . $token_auth; 
		$client   = curl_init($url); 
		curl_setopt($client,CURLOPT_RETURNTRANSFER,true); 
		$response = curl_exec($client);
		$result   = json_decode($response);
		return $result;
	}

	function register($name = null, $username, $password, $email) {
		$url      = "http://127.0.0.1/sarv/api/cockpit/saveUser?user=" . $username . '&password=' . $password . '&token=' . $token_auth ; 
		$client   = curl_init($url); 
		curl_setopt($client,CURLOPT_RETURNTRANSFER,true); 
		$response = curl_exec($client); 
		$result   = json_decode($response);
		return $result;
	}

?>