<?php
require('config_session.php');

if(isset($_POST['update_status'])){
	$status = escape($_POST['update_status']);
	if($status == 6 && !boomAllow(9)){
		echo 2;
		die();
	}
	$mysqli->query("UPDATE boom_users SET user_status = '$status' WHERE user_id = '{$data['user_id']}'");
	echo 1;
	die();
}
if(isset($_POST['save_color'], $_POST['save_bold'])){
	$c = escape($_POST['save_color']);
	$b = escape($_POST['save_bold']);
	if(!boomAllow($data['allow_colors'])){
		echo 0;
		die();
	}
	if(preg_match('/^bcolor[0-9]{1,2}$/', $c) || $c == ''){
		if($b == 'bolded' || $b == ''){
			$mysqli->query("UPDATE boom_users SET bccolor = '$c', bcbold = '$b' WHERE user_id = '{$data['user_id']}'");
			echo 1;
			die();
		}
		else {
			echo 0;
			die();
		}
	}
	else {
		echo 0;
		die();
	}
}
if(isset($_POST['save_about'], $_POST['about'], $_POST['mood'])){
	$about = escape($_POST['about']);
	$mood = escape($_POST['mood']);
	if(!boomAllow($data['allow_mood'])){
		$mood = '';
	}
	if(isBadText($about) || isBadText($mood)){
		echo 2;
		die();
	}
	if(isTooLong($about, 900) || isTooLong($mood, 40)){
		echo 3;
		die();
	}
	$mysqli->query("UPDATE boom_users SET user_about = '$about', user_mood = '$mood' WHERE user_id = '{$data['user_id']}'");
	echo 1;
	die();
}
if(isset($_POST['profile_country'])){
	$this_country = escape($_POST["profile_country"]);
	require __DIR__ . '/location/country_list.php';
	if(in_array($this_country, $country_list) && array_key_exists($this_country, $regions_list)){
		$my_region = $regions_list[$this_country];
		echo '<select id="set_profile_region">';
		foreach ($my_region as $region) {
			echo '<option value="' . $region . '">' . $region . '</option>';
		}
		echo '</select>';
	}
	else {
		echo '<select id="set_profile_region" class="login_select">
				<option value="hide">' . $lang['not_shared'] . '</option>
			</select>';	
	}
}
if(isset($_POST['save_profile'], $_POST['email'], $_POST['age'], $_POST['gender'], $_POST['country'], $_POST['region'])){
	$email = escape($_POST['email']);
	$age = escape($_POST['age']);
	$gender = escape($_POST['gender']);
	$country = escape($_POST['country']);
	$region = escape($_POST['region']);
	if(!validAge($age)){
		$age = escape($data['user_age']);
	}
	if(!validGender($gender)){
		$gender = escape($data['user_sex']);
	}
	if(!validEmail($email)){
		$email = escape($data['user_email']);
	}
	if(validCountry($country, $region)) {
		$save = 1;
	}
	else if($country == 'hide' || $region == 'hide'){
		$country = 'hide';
		$region = 'hide';
	}
	else {
		$country = escape($data['country']);
		$region = escape($data['region']);
	}
	$mysqli->query("UPDATE boom_users SET user_email = '$email', user_age = '$age', user_sex = '$gender', country = '$country', region = '$region' WHERE user_id = '{$data['user_id']}'");
	echo 1;
	die();
}
if(isset($_POST['my_username_color']) && boomAllow($data['allow_name_color'])){
	$color = escape($_POST['my_username_color']);
	if(preg_match('/^bcolor[0-9]{1,2}$/', $color) || $color == 'user'){
		$mysqli->query("UPDATE boom_users SET user_color = '$color' WHERE user_id = '{$data['user_id']}'");
		echo 1;
		die();
	}
	else {
		echo 0;
		die();
	}
}
if(isset($_POST['set_private_mode'])){
	$pmode = escape($_POST['set_private_mode']);
	if(isStaff($data['user_rank']) || isGuest($data['user_rank'])){
		echo 0;
		die();
	}
	if($pmode == 0 || $pmode == 1 || $pmode == 2){
		$mysqli->query("UPDATE boom_users SET user_private = '$pmode' WHERE user_id = '{$data['user_id']}'");
		echo 1;
		die();
	}
	else {
		echo 0;
		die();
	}
}
if(isset($_POST['change_sound'])){
	$sound = escape($_POST['change_sound']);
	if($sound == 0 || $sound == 1 || $sound == 2 ){
		$mysqli->query("UPDATE boom_users SET user_sound = '$sound' WHERE user_id = '{$data['user_id']}'");
		echo 1;
		die();
	}
	else {
		echo 0;
		die();
	}
}
if(isset($_POST['reload_avatar'])){
	$profile_avatar = '<img class="fancybox avatar_profile" ' . profileAvatar($data['user_tumb']) . '/>';
	$avatar_link = myavatar($data['user_tumb']);
	echo json_encode( array( "profile_avatar" => $profile_avatar, "avatar_link"=> $avatar_link,), JSON_UNESCAPED_UNICODE);
	die();
}
if(isset($_POST['delete_avatar'])){
	$reset = resetAvatar($data);
	$profile_avatar = '<img class="fancybox avatar_profile" ' . profileAvatar($reset, $reset) . '/>';
	$avatar_link = myavatar($reset);
	echo json_encode( array( "profile_avatar" => $profile_avatar, "avatar_link"=> $avatar_link,), JSON_UNESCAPED_UNICODE);
	die();
}
if(isset($_POST['actual_pass'], $_POST['new_pass'], $_POST['repeat_pass'], $_POST['change_password'])){
	require_once("config_session.php");
	$pass = escape($_POST['actual_pass']);
	$new_pass = escape($_POST['new_pass']);
	$repeat_pass = escape($_POST['repeat_pass']);
	$actual_encrypt = encrypt($pass);
	if($actual_encrypt != $data['user_password'] && $pass != $data['temp_pass']){
		echo 5;
		die();
	}
	if($pass == '' || $new_pass == '' || $repeat_pass == ''){
		echo 2;
		die();
	}
	if($new_pass != $repeat_pass){
		echo 3;
		die();
	}
	if(strlen($new_pass) > 30 || strlen($new_pass) < 4){
		echo 4;
		die();
	}
	if($pass == '0' || $new_pass == '0' || $repeat_pass == '0'){
		echo 5;
		die();
	}
	$new_encrypted_pass = encrypt($new_pass);
	$mysqli->query("UPDATE boom_users SET user_password = '$new_encrypted_pass', temp_pass = '0' WHERE user_id = '{$data['user_id']}'");
	setBoomCookie($data['user_id'], $new_encrypted_pass);
	echo 1;
}
if(isset($_POST['edit_username'], $_POST['new_name'])){
	$new_name = escape($_POST['new_name']);
	if(!boomAllow($data['allow_name'])){
		die();
	}
	if($new_name == $data['user_name']){
		echo 1;
		die();
	}
	if(!validate_name($new_name)){
		echo 2;
		die();
	}
	if(!boomSameName($new_name, $data['user_name'])){
		if(!boomUsername($new_name)){
			echo 3;
			die();
		}
	}
	$mysqli->query("UPDATE boom_users SET user_name = '$new_name' WHERE user_id = '{$data['user_id']}'");
	echo 1;
}
?>