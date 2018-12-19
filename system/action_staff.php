<?php
require('config_session.php');

if(isset($_POST['delete_user_account']) && boomAllow(10)){
	$target = escape($_POST['delete_user_account']);
	echo deleteAccount($target);
	die();
}
if(isset($_POST['set_user_email'], $_POST['set_user_id']) && boomAllow(10)){
	$user_email = escape($_POST['set_user_email']);
	$user_id = escape($_POST['set_user_id']);
	$add_pass = '';
	$user = userDetails($user_id);
	if(!checkEmail($user_email)){
		echo 2;
		die();
	}
	if (!validEmail($user_email)){
		echo 3;
		die();
	}
	if(isBot($user['user_bot'])){
		echo 0;
		die();
	}
	if(boomAllow(10) && isGreater($user['user_rank']) && notMe($user['user_id'])){
		$mysqli->query("UPDATE boom_users SET user_email = '$user_email' WHERE user_id = '$user_id'");
		echo 1;
		die();
	}
	else {
		echo 0;
		die();
	}
}
if(isset($_POST['user_color'], $_POST['user']) && boomAllow(9)){
	$color = escape($_POST['user_color']);
	$id = escape($_POST['user']);
	echo changeColor($color, $id);
	die();
}
if(isset($_POST['admin_reload_avatar'])){
	$target = escape($_POST['admin_reload_avatar']);
	$user = userDetails($target);
	$profile_avatar = '<img class="fancybox avatar_profile" ' . profileAvatar($user['user_tumb']) . '/>';
	$avatar_link = myavatar($user['user_tumb']);
	echo json_encode( array( "profile_avatar" => $profile_avatar, "avatar_link"=> $avatar_link,), JSON_UNESCAPED_UNICODE);
	die();
}
if(isset($_POST['clear_mood']) && boomAllow(9)){
	$id = escape($_POST['clear_mood']);
	echo clearUserMood($id);
	die();
}
if(isset($_POST['remove_avatar']) && boomAllow(9)){
	$target = escape($_POST['remove_avatar']);
	$user = userDetails($target);
	if(isBot($user['user_bot']) && !boomAllow(10)){
		echo json_encode( array( "ok_delete" => 0), JSON_UNESCAPED_UNICODE);
	}
	if(isGreater($user['user_rank']) && boomAllow(9) || boomAllow(9) && !notMe($user['user_id'])){
		$reset = resetAvatar($user);
		$profile_avatar = '<img class="fancybox avatar_profile" ' . profileAvatar($reset, $reset) . '/>';
		$avatar_link = myavatar($reset);
		echo json_encode( array( "ok_delete" => 1, "profile_avatar" => $profile_avatar, "avatar_link"=> $avatar_link), JSON_UNESCAPED_UNICODE);
		die();
	}
	else {
		echo json_encode( array( "ok_delete" => 0), JSON_UNESCAPED_UNICODE);
		die();
	}
}
if(isset($_POST['search_member']) && boomAllow(9)){
	$target = cleanSearch(escape($_POST['search_member']));
	$list_members = '';
	$add = '';
	$getmembers = $mysqli->query("SELECT * FROM boom_users WHERE user_name LIKE '$target%' $add ORDER BY user_name ASC LIMIT 500");
	if($getmembers->num_rows > 0){
		while($members = $getmembers->fetch_assoc()){
			$list_members .= boomTemplate('element/admin_user', $members);
		}
	}
	else {
		$list_members .= emptyZone($lang['empty']);
	}
	echo '<div class="page_element">' . $list_members . '</div>';
	die();
}
if(isset($_POST['search_critera']) && boomAllow(9)){
	$target = escape($_POST['search_critera']);
	$list_members = '';
	$count = 0;
	$critera = getCritera($target);
	$getmembers = $mysqli->query("SELECT * FROM boom_users WHERE $critera ORDER BY user_id ASC LIMIT 50");
	if($getmembers->num_rows > 0){
		while($members = $getmembers->fetch_assoc()){
			$list_members .= boomTemplate('element/admin_user', $members);
		}
		$get_count = $mysqli->query("SELECT user_id FROM boom_users WHERE $critera");
		$count = $get_count->num_rows;
	}
	else {
		$list_members .= emptyZone($lang['empty']);
	}
	echo '<div id="search_admin_list" class="page_element">' . $list_members . '</div>';
	if($count > 50){
		echo '<div id="search_for_more" class="page_element"><button onclick="moreAdminSearch(' . $target . ');" class="default_btn full_button set_button">' . $lang['load_more'] . '</button></div>';
	}
	die();
}
if(isset($_POST['more_search_critera'], $_POST['last_critera']) && boomAllow(9)){
	$target = escape($_POST['more_search_critera']);
	$last = escape($_POST['last_critera']);
	$list_members = '';
	$critera = getCritera($target);
	$getmembers = $mysqli->query("SELECT * FROM boom_users WHERE $critera AND user_id > '$last' ORDER BY user_id ASC LIMIT 50");
	if($getmembers->num_rows > 0){
		while($members = $getmembers->fetch_assoc()){
			$list_members .= boomTemplate('element/admin_user', $members);
		}
		echo $list_members;
		die();
	}
	else {
		echo 0;
		die();
	}
}
if(isset($_POST['mute_delay']) && boomAllow(10)){
	$action = escape($_POST['mute_delay']);
	$mysqli->query("UPDATE boom_setting SET word_delay = '$action' WHERE id = 1");
	echo 1;
	die();
}
if(isset($_POST['word_action']) && boomAllow(10)){
	$action = escape($_POST['word_action']);
	$mysqli->query("UPDATE boom_setting SET word_action = '$action' WHERE id = 1");
	echo 1;
	die();
}
if(isset($_POST['spam_action']) && boomAllow(10)){
	$action = escape($_POST['spam_action']);
	$mysqli->query("UPDATE boom_setting SET spam_action = '$action' WHERE id = 1");
	echo 1;
	die();
}
if(isset($_POST['email_filter']) && boomAllow(10)){
	$action = escape($_POST['email_filter']);
	$mysqli->query("UPDATE boom_setting SET email_filter = '$action' WHERE id = 1");
	echo 1;
	die();
}
if(isset($_POST['delete_ip']) && boomAllow(9)){
	$ip = escape($_POST['delete_ip']);
	$mysqli->query("DELETE FROM boom_banned WHERE id = '$ip'");
	echo 1;
	die();
}
if(isset($_POST['delete_player']) && boomAllow(10)){
	$delplay = escape($_POST['delete_player']);
	$mysqli->query("UPDATE boom_rooms SET room_player_id = 0 WHERE room_player_id = '$delplay'");
	$mysqli->query("DELETE FROM boom_radio_stream WHERE id = '$delplay'");
	if($delplay == $data['player_id']){
		$mysqli->query("UPDATE boom_setting SET player_id = 0 WHERE id = 1");
		echo 2;
	}
	else {
		echo 1;
	}
	die();
}
if(isset($_POST['delete_word']) && boomAllow(9)){
	$word = escape($_POST['delete_word']);
	$mysqli->query("DELETE FROM boom_filter WHERE id = '$word'");
	echo 1;
	die();
}
if(isset($_POST['add_word'], $_POST['type']) && boomAllow(9)){
	$word = escape($_POST['add_word']);
	$type = escape($_POST['type']);
	$check_word = $mysqli->query("SELECT * FROM boom_filter WHERE word = '$word' AND word_type = '$type'");
	if($check_word->num_rows > 0){
		echo 0;
		die();
	}
	if(($type == 'email' || $type == 'username') && !boomAllow(10)){
		die();
	}
	if($word != ''){
		$mysqli->query("INSERT INTO boom_filter (word, word_type) VALUE ('$word', '$type')");
		$word_added['id'] = $mysqli->insert_id;
		$word_added['word'] = $word;
		echo boomTemplate('element/word', $word_added);
		die();
	}
	else {
		echo 2;
		die();
	}
}
if(isset($_POST['player_url'], $_POST['player_alias']) && boomAllow(10)){
	$player_url = escape($_POST['player_url']);
	$player_alias = escape($_POST['player_alias']);
	if($player_url != '' && $player_alias != ''){
		$count_player = $mysqli->query("SELECT id FROM boom_radio_stream WHERE id > 0");
		$playcount = $count_player->num_rows;
		$mysqli->query("INSERT INTO boom_radio_stream (stream_url, stream_alias) VALUE ('$player_url', '$player_alias')");
		if($playcount < 1){
			$last_id = $mysqli->insert_id;
			$mysqli->query("UPDATE boom_setting SET player_id = '$last_id' WHERE id = 1");
		}
		echo 1;
	}
	else {
		echo 2;
	}
	die();
}
if(isset($_POST['new_stream_url'], $_POST['new_stream_alias'], $_POST['player_id']) && boomAllow(10)){
	$id = escape($_POST['player_id']);
	$alias = escape($_POST['new_stream_alias']);
	$url = escape($_POST['new_stream_url']);
	if(!empty($alias) && !empty($url)){
		$mysqli->query("UPDATE boom_radio_stream SET stream_url = '$url', stream_alias = '$alias' WHERE id = '$id'");
		echo 1; 
		die();
	}
	else {
		echo 0;
		die();
	}
}
if(isset($_POST['unset_report'], $_POST['type']) && boomAllow(8)){
	$report = escape($_POST['unset_report']);
	$type = escape($_POST['type']);
	$mysqli->query("DELETE FROM boom_report WHERE report_post = '$report' AND report_type = '$type'");
	$get_report = $mysqli->query("SELECT report_id FROM boom_report");
	$report = $get_report->num_rows;
	updateStaffNotify();
	echo $report;
	die();
}
if(isset($_POST['remove_report'], $_POST['type']) && boomAllow(8)){
	$report = escape($_POST['remove_report']);
	$type = escape($_POST['type']);
	if($type == 1){
		$get_report = $mysqli->query("SELECT * FROM boom_report WHERE report_post = '$report' AND report_type = 1 LIMIT 1");
		if($get_report->num_rows > 0){
			$rep = $get_report->fetch_assoc();
			$mysqli->query("DELETE FROM boom_chat WHERE post_id = '$report'");
			$mysqli->query("UPDATE boom_users SET post_delete = CONCAT(post_delete, ',$report') WHERE user_roomid = '{$rep['report_room']}'");
		}
	}
	if($type == 2){
		$get_report = $mysqli->query("SELECT * FROM boom_report WHERE report_post = '$report' AND report_type = 2 LIMIT 1");
		if($get_report->num_rows > 0){
			$mysqli->query("DELETE FROM boom_post WHERE `post_id` = '$report'");
			$mysqli->query("DELETE FROM `boom_post_reply` WHERE `parent_id` = '$report'");
			$mysqli->query("DELETE FROM `boom_notification` WHERE `notify_id` = '$report'");
			$mysqli->query("DELETE FROM `boom_post_like` WHERE `like_post` = '$report'");
			$mysqli->query("DELETE FROM boom_report WHERE report_post = '$report' AND report_type = 2");
		}
	}
	updateStaffNotify();
	$mysqli->query("DELETE FROM boom_report WHERE report_post = '$report' AND report_type = '$type'");
	$get_report = $mysqli->query("SELECT report_id FROM boom_report");
	$report = $get_report->num_rows;
	echo $report;
	die();
}
if(isset($_POST['create_user'], $_POST['create_name'], $_POST['create_password'], $_POST['create_email'], $_POST['create_age'], $_POST['create_gender']) && boomAllow(10)){
	$name = escape($_POST['create_name']);
	$pass = escape($_POST['create_password']);
	$email = escape($_POST['create_email']);
	$age = escape($_POST['create_age']);
	$gender = escape($_POST['create_gender']);
	if($name == '' || $pass == '' || $email == ''){
		echo 2;
		die();
	}
	if(!validate_name($name)){
		echo 3;
		die();
	}
	if(!boomUsername($name)){
		echo 4;
		die();
	}
	if(!validEmail($email, 1)){
		echo 5;
		die();
	}
	if(!validAge($age)){
		$age = 0;
	}
	if(!validGender($gender)){
		$gender = 1;
	}
	$enpass = encrypt($pass);

	$system_user = array(
		'name'=> $name,
		'password'=> $enpass,
		'email'=> $email,
		'language'=> $data['language'],
		'verified'=> 1,
		'cookie'=> 0,
		'gender'=> $gender,
		'age'=> $age,
	);
	$user = boomInsertUser($system_user);
	echo 1;
	die();
}
if(isset($_POST['target_name'], $_POST['user_new_name']) && boomAllow(9)){
	$new_name = escape($_POST['user_new_name']);
	$target = escape($_POST['target_name']);
	$user = userDetails($target);
	if(empty($user)){
		echo 0;
		die();
	}
	if(!isGreater($user['user_rank'])){
		echo 0;
		die();
	}
	if(!boomAllow($data['allow_name'])){
		die();
	}
	if($new_name == $user['user_name']){
		echo 1;
		die();
	}
	if(!validate_name($new_name)){
		echo 2;
		die();
	}
	if(!boomSameName($new_name, $user['user_name'])){
		if(!boomUsername($new_name)){
			echo 3;
			die();
		}
	}
	$mysqli->query("UPDATE boom_users SET user_name = '$new_name' WHERE user_id = '{$user['user_id']}'");
	if(isBot($user['user_bot'])){
		$mysqli->query("UPDATE boom_addons SET bot_name = '$new_name' WHERE bot_id = '{$user['user_id']}'");
	}
	echo 1;
}
?>