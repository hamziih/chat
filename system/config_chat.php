<?php
/**
* Codychat
* @package Codychat
* @author www.boomcoding.com
* @copyright 2017
* @terms any use of this script without a legal license is prohibited
* all the content of Codychat is the propriety of BoomCoding and Cannot be 
* used for another project.
*/
session_start();
$boom_access = 0;
$time = time();
require("database.php");
require("variable.php");
require("function.php");
if(!checkToken() || !isset($_COOKIE[$boom_config['prefix'] . 'userid']) || !isset($_COOKIE[$boom_config['prefix'] . 'utk'])){
	echo json_encode( array("check" => 99));
	die();
}
$mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()){
	die();
}
$pass = escape($_COOKIE[$boom_config['prefix'] . 'utk']);
$ident = escape($_COOKIE[$boom_config['prefix'] . 'userid']);
$get_data = $mysqli->query("SELECT 
system_id, default_theme, domain, allow_logs, language, timezone, speed, act_time, act_delay, word_delay, reg_mute,
user_id, user_name, user_join, join_msg, last_action, user_language, user_timezone, user_status, user_color, user_rank, user_roomid, user_sound, session_id, pcount,
post_delete, user_news, ureg_mute, user_mute, user_word_mute, user_role, user_action, room_mute, owner, caction, taction, naction,
(SELECT count( DISTINCT hunter ) FROM boom_private WHERE target = '$ident' AND hunter != '$ident'  AND status = '0') as private_count
FROM boom_users, boom_setting 
WHERE user_id = '$ident' AND user_password = '$pass' AND id = '1'");
if($get_data->num_rows > 0){
	$data = $get_data->fetch_assoc();
	require("language/{$data['user_language']}/language.php");
	date_default_timezone_set($data['user_timezone']);
	$boom_access = 1;
}
else {
	echo json_encode( array("check" => 99));
	die();
}
?>