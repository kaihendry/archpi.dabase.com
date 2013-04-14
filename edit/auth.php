<?php
$cc = dirname(__DIR__) . '/cookies/'; // cookie collective

function setAdmin($token) {
	global $cc;
	//error_log("cc: " . $cc);
	if (empty($token)) return;
	// if (! is_file($token)) return;
	$uniquser = json_encode($_SERVER);
	//error_log($cc . $token);
	file_put_contents($cc . $token, $uniquser);
	setCookie('wordsister', $token, time() + 1576800000, '/'); // 50 years
}

function getAdmin() {
	global $cc;
	if (isset($_COOKIE['wordsister'])) {
		$cookie_var = $_COOKIE['wordsister'];
	} elseif (isset($_REQUEST['wordsister'])) {
		$cookie_var = $_REQUEST['wordsister'];
	} else { return false; }
	$path = $cc . $cookie_var;
	//error_log("got: " . $path);
	if ( is_file($path) ) {
		setAdmin($cookie_var);
		return true;
	} else {
		// Destroy cookie, I assume
		setCookie('wordsister', '', time() - 86400);
		return false;
	}
}

function is_dir_empty($dir) {
	if (!is_readable($dir)) return NULL;
	return (count(scandir($dir)) == 2);
}



?>
