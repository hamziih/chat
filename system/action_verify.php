<?php
require('config_session.php');

if(isset($_POST['send_verification'], $_POST['verify']) && boomAllow(1)){
	if(okVerify()){
		echo sendActivation($data);
		die();
	}
	else {
		echo 3;
		die();
	}
}
if(isset($_POST['valid_code'], $_POST['verify_code'])){
	$code = escape($_POST['valid_code']);
	echo checkCode($code);
}
if(isset($_POST['open_verify']) && canVerify()){
	if($data['valid_key'] == ''){
		$test_activation = sendActivation($data);
		if($test_activation == 1){
			echo boomTemplate('element/verify_account');
		}
		else {
			echo 0;
		}
	}
	else {
		echo boomTemplate('element/verify_account');
	}
}
if(isset($_POST['new_verification_email']) && boomAllow(1)){
	$email = escape($_POST['new_verification_email']);
	if($email == $data['user_email']){
		echo 0;
		die();
	}
	if (!validEmail($email)){
		echo 2;
		die();
	}
	if(!checkEmail($email)){
		echo 3;
		die();
	}
	$mysqli->query("UPDATE boom_users SET user_email = '$email' WHERE user_id = '{$data['user_id']}'");
	echo 1;
}
?>