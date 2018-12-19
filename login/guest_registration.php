<?php
/**
* Codychat
*
* @package Codychat
* @author www.boomcoding.com
* @copyright 2017
* @terms any use of this script without a legal license is prohibited
* all the content of Codychat is the propriety of BoomCoding and Cannot be 
* used for another project.
*/
require("../system/config_session.php");

$user_ip = getIp();
if(!guestCanRegister()){
	echo 0;
	die();
}
if(isset($_POST["new_guest_name"], $_POST["new_guest_password"], $_POST["new_guest_email"])){
	$user_name = escape($_POST["new_guest_name"]);
	$user_password = escape($_POST["new_guest_password"]);
	$user_email = escape($_POST["new_guest_email"]);

	if (!validate_name($user_name)){
		echo 4;
		die();
	}
	if(!checkEmail($user_email) && $user_email != $data['user_email']){
		echo 10;
		die();
	}
	if(!validPassword($user_password)){
		echo 17;
		die();
	}
	if (!validEmail($user_email)){
		echo 6;
		die();
	}
	if(!okRegister($user_ip)){
		echo 16;
		die();
	}
	if(!boomUsername($user_name) && strtolower($user_name) != strtolower($data['user_name'])){
		echo 5;
		die();
	}
	$user_password = encrypt($user_password);
	$add_av = '';
	if($data['user_tumb'] == 'default_guest.png'){
		$add_av = ", user_tumb = 'default_avatar.png'";
	}
	$mysqli->query("UPDATE boom_users SET user_name = '$user_name', user_password = '$user_password', user_email = '$user_email', user_rank = '1' $add_av WHERE user_id = '{$data['user_id']}'");
	setBoomCookie($data['user_id'], $user_password);
	echo 1;
}
else{
	echo 2;
}
?>