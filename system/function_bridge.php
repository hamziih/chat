<?php
function createBridgeUser($provider, $info){
	global $bmysqli, $bdata;
	$bridge_user = array();
	
	if(empty($info) || empty($provider)){
		return false;
	}
	$bridge_default = array(
		'id'=> '',
		'name'=> '',
		'age'=> 0,
		'gender'=> 0,
		'email'=> '',
		'password'=> bridgeRandomPass(),
		'language'=> bridgeLanguage(),
		'avatar'=> '',
		'ip'=> bridgeGetIp(),
	);
	$bridge = array_merge($bridge_default, $info);
	
	// secure data for insert 
	$provider = bridgeEscape($provider);
	$bridge['id'] = bridgeEscape($bridge['id']);
	$bridge['name'] = bridgeEscape($bridge['name']);
	$bridge['age'] = bridgeEscape($bridge['age']);
	$bridge['gender'] = bridgeEscape($bridge['gender']);
	$bridge['email'] = bridgeEscape($bridge['email']);
	$bridge['password'] = bridgeEscape($bridge['password']);
	$bridge['language'] = bridgeEscape($bridge['language']);
	$bridge['avatar'] = bridgeEscape($bridge['avatar']);
	
	if(empty($bridge['id']) || empty($bridge['name'])){
		return false;
	}
	
	// define bridge identity
	$bridge['identity'] = $provider . '_' . $bridge['id'];
	
	// process general information
	if(empty($bridge['email'])){
		$bridge['email'] = $provider . $bridge['id'] . '@' . $provider . '.com';
	}
	if(!is_numeric($bridge['age'])){
		$bridge['age'] = 0;
	}
	switch(strtolower($bridge['gender'])){
		case 'female':
			$bridge['gender'] = 2;
			break;
		case 'male':
			$bridge['gender'] = 1;
			break;
		default:
			$bridge['gender'] = 0;
			break;
	}
	if(stripos($bridge['avatar'], 'http') === false){
		$bridge['avatar'] = '';
	}
	
	// check if bridge user exist
	$bridge_exist = $bmysqli->query("SELECT * FROM `boom_users` WHERE `sub_id` = '{$bridge['identity']}' AND `sub_id` != '' LIMIT 1");
	
	if($bridge_exist->num_rows > 0){
		$bridge_user = $bridge_exist->fetch_assoc();
		$bmysqli->query("UPDATE boom_users SET user_ip = '{$bridge['ip']}' WHERE user_id = '{$bridge_user['user_id']}'");
	}
	else {
		$bridge['name'] = getBridgeName($bridge['name'], $bmysqli);
		$bmysqli->query("INSERT INTO boom_users 
		(user_name, sub_id, user_password, user_email, user_ip, user_join, last_action,
		user_theme, user_sex, user_age, user_language, user_timezone, user_roomid, verified)
		VALUES 
		('{$bridge['name']}', '{$bridge['identity']}', '{$bridge['password']}', '{$bridge['email']}', '{$bridge['ip']}',
		'" . time() . "', '" . time() . "', '{$bdata['default_theme']}', '{$bridge['gender']}', '{$bridge['age']}', '{$bridge['language']}', '{$bdata['timezone']}', '0', 1)");
		$bridge_user = bridgeUserDetails($bmysqli->insert_id);
	}
	
	// download avatar for bridged user
	if($bridge['avatar'] != ''){
		$add_bridge_avatar = downloadBridgeAvatar($bridge_user, $bridge['avatar'], $provider);
	}
	
	// create bridge user session
	setBoomCookie($bridge_user['user_id'], $bridge_user['user_password']);
	return $bridge_user;
}

// bridge functions
function bridgeRandomPass(){
	$text = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890++--';
	$text = substr(str_shuffle($text), 0, 10);
	return bridgeEncrypt($text);
}
function bridgeGetIp(){
	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
	  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}
	return bridgeEscape($_SERVER['REMOTE_ADDR']);	
}
function cleanBridgeName($name){
	return str_replace(
		array(' ', "'", '"', '<', '>', ",",")","("),
		array('_', '', '', '', '', '', '', ''),
		$name
	);
}
function bridgeEncrypt($d){
	global $encryption;
	return sha1(str_rot13($d . $encryption));
}
function bridgeEscape($t){
	global $bmysqli;
	return $bmysqli->real_escape_string(trim(htmlspecialchars($t, ENT_QUOTES)));
}
function bridgeLanguage(){
	global $bdata, $boom_config;
	$l = $bdata['language'];
	if(isset($_COOKIE[$boom_config['prefix'] . 'lang'])){
		$test_lang = bridgeEscape($_COOKIE[$boom_config['prefix'] . 'bc_lang']);
		if(file_exists(__DIR__ . '/language/' . $test_lang . '/language.php')){
			$l = $test_lang;
		}
	}
	return $l;
}
function bridgeUserDetails($id){
	global $bmysqli;
	$user = array();
	$getuser = $bmysqli->query("SELECT * FROM boom_users WHERE user_id = '$id'");
	if($getuser->num_rows > 0){
		$user = $getuser->fetch_assoc();
	}
	return $user;
}
function downloadBridgeAvatar($user, $url, $prefix){
	global $bmysqli;
	$url = bridgeEscape($url);
	if($user['user_tumb'] == 'default_avatar.png' || stripos($user['user_tumb'], $prefix) !== false){
		$img = $prefix . '_' . md5(time() . $user['user_id']).'.jpg';
		$path = __DIR__ . '/../avatar/' . $img;
		$fh = fopen($path, 'wb');
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_FILE, $fh);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 1);
		curl_exec($curl);
		curl_close($curl);
		fclose($fh);
		if(file_exists($path)){
			$info = getimagesize($path);
			if ($info !== false) {
				$unlink = unlinkBridgeAvatar($user['user_tumb']);
				$bmysqli->query("UPDATE boom_users SET user_tumb = '$img' WHERE user_id = '{$user['user_id']}'");
			}
			else {
				$unlink_fail = unlinkBridgeAvatar($img);
			}
		}
	}
}
function unlinkBridgeAvatar($file){
	if(stripos($file, 'default') === false){
		$delete =  __DIR__ . '/../avatar/' . $file;
		if(file_exists($delete)){
			unlink($delete);
		}
	}
	return true;
}
function getBridgeName($name, $connection){
	$t = 0;
	$tcount = 0;
	$try = cleanBridgeName($name);
	while($t == 0){
		$tdouble = $connection->query("SELECT * FROM boom_users WHERE user_name = '$try'");
		if($tdouble->num_rows > 0){
			$tcount++;
			$try = $name . $tcount;
		}
		else{
			$t = 1;
		}
	}
	return $try;
}
?>