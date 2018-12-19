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
function getIp(){
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $cloud =   @$_SERVER["HTTP_CF_CONNECTING_IP"];
    $remote  = $_SERVER['REMOTE_ADDR'];
    if(filter_var($cloud, FILTER_VALIDATE_IP)) {
        $ip = $cloud;
    }
    else if(filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    }
    else{
        $ip = $remote;
    }
    return escape($ip);
}
function boomTemplate($getpage, $boom = '') {
	global $data, $lang, $mysqli, $boom_config;
    $page = __DIR__ . '/' . $getpage . '.php';
    $structure = '';
    ob_start();
    require($page);
    $structure = ob_get_contents();
    ob_end_clean();
    return $structure;
}
function calHour($h){
	return time() - ($h * 3600);
}
function calWeek($w){
	return time() - ( 3600 * 24 * 7 * $w);
}
function calmonth($m){
	return time() - ( 3600 * 24 * 30 * $m);
}
function calDay($d){
	return time() - ($d * 86400);
}
function calMinutes($min){
	return time() - ($min * 60);
}
function calHourUp($h){
	return time() + ($h * 3600);
}
function calWeekUp($w){
	return time() + ( 3600 * 24 * 7 * $w);
}
function calmonthUp($m){
	return time() + ( 3600 * 24 * 30 * $m);
}
function calDayUp($d){
	return time() + ($d * 86400);
}
function calMinutesUp($min){
	return time() + ($min * 60);
}
function myavatar($a){
	global $data;
	$path =  '/avatar/';
	if(stripos($a, 'default') !== false){
		$path =  '/default_images/';
	}
	if(linkAvatar($a)){
		return $a;
	}
	else {
		return $data['domain'] . $path . $a;
	}
}
function profileAvatar($a){
	global $data;
	$path =  '/avatar/';
	if(stripos($a, 'default') !== false){
		$path =  '/default_images/';
	}
	if(linkAvatar($a)){
		return 'href="' . $a . '" src="'. $a . '"';
	}
	else{
		return 'href="' . $data['domain'] . $path  . $a . '" src="' . $data['domain'] . $path  . $a . '"';
	}
}
function linkAvatar($a){
	if(preg_match('@^https?://@i', $a)){
		return true;
	}
}
function escape($t){
	global $mysqli;
	return $mysqli->real_escape_string(trim(htmlspecialchars($t, ENT_QUOTES)));
}
function boomSanitize($t){
	global $mysqli;
	$t = str_replace(array('\\', '/', '.', '<', '>', '%', '#'), '', $t);
	return $mysqli->real_escape_string(trim(htmlspecialchars($t, ENT_QUOTES)));
}
function softEscape($t){
	global $mysqli;
	$atags = '<a><p><h1><h2><h3><h4><img><b><strong><br><ul><li><div><i><span><u><th><td><tr><table><strike><small><ol><hr><font><center><blink><marquee>';
	$t = strip_tags($t, $atags);
	return $mysqli->real_escape_string(trim($t));
}
function systemReplace($text){
	global $lang;
	$text = str_replace('%bcquit%', $lang['leave_message'], $text);
	$text = str_replace('%bcjoin%', $lang['join_message'], $text);
	$text = str_replace('%bcclear%', $lang['clear_message'], $text);
	$text = str_replace('%spam%', $lang['spam_content'], $text);
	return $text;
}
function systemSpecial($content, $type, $delete = 1){
	global $data;
	$system = userDetails($data['system_id']);
	$template = array(
		'content'=> $content,
		'type'=> $type,
		'delete'=> $delete,
		'name'=> $system['user_name'],
		'avatar'=> $system['user_tumb'],
	);
	return boomTemplate('element/system_log', $template);
}
function userDetails($id){
	global $mysqli;
	$user = array();
	$getuser = $mysqli->query("SELECT * FROM boom_users WHERE user_id = '$id'");
	if($getuser->num_rows > 0){
		$user = $getuser->fetch_assoc();
	}
	return $user;
}
function ownAvatar($i){
	global $data;
	if($i == $data['user_id']){
		return 'glob_av';
	}
	return '';
}
function systemSay($room, $message, $type = 'system'){
	global $mysqli, $lang, $data;
	$dsystem = array(
		'color'=> 'chat_system',
		'type'=> $type,
		'bot'=> 1,
	);
	postChat($data['system_id'], $room, $message, $dsystem);
}
function postChat($from, $room, $content, $pdat = array()){
	global $mysqli;
	$lact = calMinutes(5);
	$def = array(
		'color'=> '',
		'snum'=> '',
		'type'=> 'public',
		'bot'=> '0',
	);
	$d = array_merge($def, $pdat);
	$mysqli->query("INSERT INTO `boom_chat` (post_date, user_id, post_message, post_roomid, type, snum, post_bot, tcolor) VALUES ('" . time() . "', '$from', '$content', '$room', '{$d['type']}', '{$d['snum']}', '{$d['bot']}', '{$d['color']}')");
	$mysqli->query("UPDATE boom_users SET caction = caction + 1 WHERE user_roomid = '$room' and last_action > '$lact'");	
	return true;
}
function postPrivate($from, $to, $content, $d = array()){
	global $mysqli;
	$mysqli->query("INSERT INTO `boom_private` (time, target, hunter, message) VALUES ('" . time() . "', '$to', '$from', '$content')");
	if($to != $from){
		$mysqli->query("UPDATE boom_users SET pcount = pcount + 1 WHERE user_id = '$to'");
	}
}
function systemNotify($user, $type, $custom, $custom2 = ''){
	global $mysqli, $data;
	$mysqli->query("INSERT INTO boom_notification ( notifier, notified, notify_type, notify_date, notify_source, notify_custom, notify_custom2) VALUE ('{$data['system_id']}', '$user', '$type', '" . time() . "', 'system', '$custom', '$custom2')");
	updateNotify($user);
}
function updateNotify($id){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET naction = naction + 1 WHERE user_id = '$id'");
}
function updateDualNotify($id1, $id2){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET naction = naction + 1 WHERE user_id = '$id1' OR user_id = '$id2'");
}
function updateGroupNotify($list){
	global $mysqli;
	if(empty($list)){
		return false;
	}
	$list = implode(", ", $list);
	$mysqli->query("UPDATE boom_users SET naction = naction + 1 WHERE user_id IN ($list)");
}
function updateFriendsNotify($id){
	global $mysqli, $data;
	$list = listFriends($id);
	if(empty($list)){
		return false;
	}
	$list = implode(", ", $list);
	$mysqli->query("UPDATE boom_users SET naction = naction + 1 WHERE user_id IN ($list)");
}
function updateStaffNotify(){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET naction = naction + 1 WHERE user_rank > 7");
}
function updateAllNotify(){
	global $mysqli;
	$delay = calMinutes(5);
	$mysqli->query("UPDATE boom_users SET naction = naction + 1 WHERE user_id > 0 AND last_action > '$delay'");
}
function isIgnored($id){
	global $boom_config;
	if(strpos($_SESSION[$boom_config['prefix'] . 'ignore'], 'u' . $id . 'x') !== false){
		return true;
	}
}
function createLog($data, $post, $type = 0){
	global $lang;
	$add_clear = '';
	$add_av = '';
	if(isIgnored($post['user_id'])){
		return false;
	}
	$message = uprocess($data['user_name'], strtolower($data['user_name']),$post['post_message'], $post['user_id']);
	$message = mb_convert_encoding(systemReplace($message), 'UTF-8', 'auto');
	if(boomAllow(1)){
		if(boomAllow(8) || boomRole(4) ){
			$add_clear = '<span class="delete_log" value="' . $post['post_id'] . '"><i class="fa fa-times"></i></span>';
		}
		else {
			if($post['post_bot'] < 1){
				$add_clear = '<span class="report report_log" onclick="openReport(' . $post['post_id'] . ', 1)"><i class="fa fa-flag"></i></span>';
			}
		}
	}
	if(notMe($post['user_id'])){
		$add_av = 'onclick="openAvMenu(this, \''.$post['user_name'].'\','.$post['user_id'].','.$post['user_rank'].');"';
	}
	return  '<li id="log' . $post['post_id'] . '" data="' . $post['post_id'] . '" class="ch_logs ' . $post['type'] . '">
				<div class="my_avatar chat_avatar_wrap" ' . $add_av . '>
					<img class="avatar_chat ' . ownAvatar($post['user_id']) . '" src="' . myavatar($post['user_tumb']) . '"/>
				</div>
				<div class="my_text">
					<p class="username ' . $post['user_color'] . '">' . $post['user_name'] . '</p>
					<div class="chat_message ' . $post['tcolor'] . '">' . $message . '</div>
					<span class="logs_date">' . displayDate($post['post_date']) . $add_clear . '</span>
				</div>
			</li>';	
}
function privateLog($post, $type){
	$message = systemReplace($post['message']);
	switch($type){
		case 1:
			return '<li id="priv' . $post['id'] . '">
						<div class="private_logs">
							<div class="private_avatar">
								<img data="' . $post['user_id'] . '" class="get_info avatar_private" src="' . myavatar($post['user_tumb']) . '"/>
							</div>
							<div class="private_content">
								<div class="hunter_private">' . $message . '</div>
								<p class="pdate">' . displayDate($post['time']) . '</p>
							</div>
						</div>
					</li>';
		case 2:
			return '<li id="priv' . $post['id'] . '">
						<div class="private_logs">
							<div class="private_content">
								<div class="target_private">' . $message . '</div>
								<p class="ptdate">' . displayDate($post['time']) . '</p>
							</div>
							<div class="private_avatar">
								<img data="' . $post['user_id'] . '" class="get_info avatar_private" src="' . myavatar($post['user_tumb']) . '"/>
							</div>
						</div>
					</li>';
	}
}
function displayDate($date){
	return date("j/m G:i", $date);
}
function longDate($date){
	return date("Y-m-d ", $date);
}
function uprocess($me, $me2, $string, $sender) {
	if($sender != $me){
		if (preg_match('/http/',$string)){
			$string = $string;
		}
		else {
			$string = str_replace(array($me, $me2), '<span class="my_notice">' . $me . '</span>', $string);
		}
	}
	return $string;
}
function boomAllow($rank){
	global $data;
	if($data['user_rank'] >= $rank){
		return true;
	}
}
function boomRole($role){
	global $data;
	if($data['user_role'] >= $role){
		return true;
	}
}
function isGreater($rank){
	global $data;
	if($data['user_rank'] > $rank){
		return true;
	}
}
function notMe($id){
	global $data;
	if($id != $data['user_id']){
		return true;
	}
}
function isBot($user){
	if($user > 0){
		return true;
	}
}
function systemBot($user){
	if($user == 9){
		return true;
	}
}
function getTopic(){
	global $mysqli, $lang, $data;
	$room_topic = '';
	$get_topic = $mysqli->query("SELECT topic FROM boom_rooms WHERE room_id = '{$data['user_roomid']}'");
	if($get_topic->num_rows > 0){
		$topic = $get_topic->fetch_assoc();
		if ($topic['topic'] != ''){
			$room_topic = $topic['topic'];
		}
	}
	return $room_topic;
}
function muted(){
	global $data;
	if($data['user_mute'] > 0 || $data['user_word_mute'] > 0 || $data['ureg_mute'] > 0){
		return true;
	}
}
function roomMuted(){
	global $data;
	if($data['room_mute'] > 0){
		return true;
	}
}
function joinRoom(){
	global $lang, $data;
	if(allowLogs() && isVisible()){
		systemSay($data['user_roomid'], str_replace('%user%', $data['user_name'], $lang['system_join_room']));
	}
}
function processUserData($t){
	global $data;
	return str_replace(array('%user%'), array($data['user_name']), $t);
}
function leaveRoom(){
	global $data, $lang;
	if(allowLogs()){
		if(isVisible() && $data['user_roomid'] != 0 && $data['last_action'] > time() - 30 ){
			systemSay($data['user_roomid'], str_replace('%user%', $data['user_name'], $lang['quit_room']));
		}
	}
}
function allowLogs(){
	global $data;
	if($data['allow_logs'] == 1){
		return true;
	}
}
function isVisible(){
	global $data;
	if($data['user_status'] != 6){
		return true;
	}
}
function isGuest($rank){
	if($rank == 0){
		return true;
	}
}
function userVisible($s){
	if($s != 6){
		return true;
	}
}
function boomRecaptcha(){
	global $data;
	if($data['use_recapt'] > 0){
		return true;
	}
}
function encrypt($d){
	global $encryption;
	return sha1(str_rot13($d . $encryption));
}
function installEncrypt($d, $encr){
	return sha1(str_rot13($d . $encr));
}
function getDelay(){
	return time() - 35;
}
function getMinutes($t){
	return $t / 60;
}
function isOwner(){
	global $data;
	if($data['owner'] == 1 && boomAllow(10)){
		return true;
	}
}
function userOwner($user){
	if($user['owner'] == 1 || $user['user_rank'] == 10){
		return true;
	}
}
function fullOwner($user){
	if($user['owner'] == 1){
		return true;
	}
}
function isStaff($rank){
	if($rank > 7){
		return true;
	}
}
function genKey(){
	return md5(rand(10000,99999) . rand(10000,99999));
}
function genCode(){
	return rand(111111,999999);
}
function genSnum(){
	global $data;
	return $data['user_id'] . rand(1111111, 9999999);
}
function canUpload(){
	global $data;
	if(boomAllow($data['allow_image'])){
		return true;
	}
}
function canPrivate(){
	global $data;
	if(boomAllow($data['allow_private'])){
		return true;
	}
}
function allowRoom(){
	global $data;
	if(boomAllow($data['allow_room'])){
		return true;
	}
}
function emoPlus(){
	global $data;
	if(boomAllow($data['emo_plus'])){
		return true;
	}
}
function allowGuest(){
	global $data;
	if($data['allow_guest'] == 1){
		return true;
	}
}
function canDirect(){
	global $data;
	if(boomAllow($data['allow_direct'])){
		return true;
	}
}
function canColor(){
	global $data;
	if(boomAllow($data['allow_color'])){
		return true;
	}
}
function roomName(){
	global $mysqli, $data;
	$groom = $mysqli->query("SELECT room_name FROM boom_rooms WHERE room_id = '{$data['user_roomid']}'");
	$r = $groom->fetch_assoc();
	return $r['room_name'];
}
function wordUnmute($d){
	global $data, $mysqli;
	$unmute = calMinutes($data['word_delay']);
	if($d['user_word_mute'] <= $unmute){
		$mysqli->query("UPDATE boom_users SET user_word_mute = 0 WHERE user_id = '{$d['user_id']}'");
		clearMuteNotify($d['user_id']);
		systemNotify($d['user_id'], 'system_unmute', '');
	}
}
function regUnmute($d){
	global $data, $mysqli;
	$unmute = calMinutes($data['reg_mute']);
	if($d['ureg_mute'] <= $unmute){
		$mysqli->query("UPDATE boom_users SET ureg_mute = 0 WHERE user_id = '{$d['user_id']}'");
		clearMuteNotify($d['user_id']);
		systemNotify($d['user_id'], 'system_unmute', '');
	}
}
function boomMerge($a, $b){
	$c = $a . '_' . $b;
	return trim($c);
}
function clearMuteNotify($id){
	global $mysqli;
	usleep(100000);
	$mysqli->query("DELETE FROM boom_notification WHERE notified = '$id' AND notify_type IN ('bad_word', 'system_mute', 'system_unmute', 'flood_abuse')");
	usleep(100000);
}
function setToken(){
	global $boom_config;
	if(!empty($_SESSION[$boom_config['prefix'] . 'token'])){
		$_SESSION[$boom_config['prefix'] . 'token'] = $_SESSION[$boom_config['prefix'] . 'token'];
		return $_SESSION[$boom_config['prefix'] . 'token'];
	}
	else {
		$session = md5(rand(000000,999999));
		$_SESSION[$boom_config['prefix'] . 'token'] = $session;
		return $session;
	}
}
function checkToken() {
	global $boom_config;
    if (!isset($_POST['token']) || !isset($_SESSION[$boom_config['prefix'] . 'token']) || empty($_SESSION[$boom_config['prefix'] . 'token'])) {
        return false;
    }
	if($_POST['token'] == $_SESSION[$boom_config['prefix'] . 'token']){
		return true;
	}
    return false;
}
function userState($state){
	if(!empty($state)){
		return '<p class="bustate bellips">' . $state . '</p>';
	}
}

// ranking functions

function lmIcon($t, $class = ''){
	if($t != ''){
		return '<div class="user_lm_icon ' . $class . '">' . $t . '</div>';
	}
	else {
		return '';
	}
}
function isMuted($user){
	global $lang;
	if($user['user_mute'] > 0 || $user['user_word_mute'] > 0){
		return  '<i title="' . $lang['muted'] . '" class="fa fa-hand-paper-o is_muted"></i>';
	}
	else if($user['room_mute'] == 1){
		return  '<i title="' . $lang['muted'] . '" class="fa fa-hand-paper-o is_room_muted"></i>';
	}
	else if($user['ureg_mute'] > 0){
		return '<i title="' . $lang['muted'] . '" class="fa fa-plus-circle theme_color"></i>';
	}
	else {
		return '';
	}
}
function getGender($s){
	global $lang;
	switch($s){
		case 1:
			return $lang['male'];
		case 2:
			return $lang['female'];
		default:
			return $lang['not_set'];
	}
}
function sex($s){
	global $lang;
	switch($s){
		case 1:
			return 'boy';
		case 2:
			return 'girl';
		default:
			return 'nosex';
	}
}
function getStatus($status){
	global $lang;
	switch($status){
		case 2:
			return curStatus($lang['away'], 'clock-o', 'absent');
		case 3:
			return curStatus($lang['busy'], 'minus-circle', 'gone');
		case 4:
			return curStatus($lang['gaming'], 'gamepad', 'gaming');
		case 5:
			return curStatus($lang['eating'], 'cutlery', 'eating');
		default:
			return '';
	}
}
function curStatus($txt, $icon, $color){
	return '<i title="' . $txt . '" class="fa ' . $color . ' fa-' . $icon . '"></i>';	
}
function listStatus($status){
	global $lang;
	switch($status){
		case 1:
			return statusMenu($lang['online'], 'check-circle', 'online');
		case 2:
			return statusMenu($lang['away'], 'clock-o', 'absent');
		case 3:
			return statusMenu($lang['busy'], 'minus-circle', 'gone');
		case 4:
			return statusMenu($lang['gaming'], 'gamepad', 'gaming');
		case 5:
			return statusMenu($lang['eating'], 'cutlery', 'eating');
		case 6:
			return statusMenu($lang['invisible'], 'eye-slash', 'invisible');
		default:
			return statusMenu($lang['online'], 'check-circle', 'online');
	}
}
function statusMenu($txt, $icon, $color){
	return '<span class="boom_menu_icon"><i class="fa ' . $color . ' status_icon fa-' . $icon . '"></i></span>' . $txt;
}
function listAllStatus(){
	global $lang, $data;
	$list = '';
	$list .= statusBox(1, listStatus(1));	
	$list .= statusBox(2, listStatus(2));
	$list .= statusBox(3, listStatus(3));
	$list .= statusBox(4, listStatus(4));
	$list .= statusBox(5, listStatus(5));
	if(boomAllow(9)){
		$list .= statusBox(6, listStatus(6));
	}
	return $list;
}
function statusBox($value, $content){
	return '<div class="status_option elem_in" data="' . $value . '"><div class="actual_in">' . $content . '</div></div>';
}
function getRankIcon($rank){
	$user = array(
		'user_bot'=> 0,
		'user_role'=> 0,
		'user_rank'=> $rank,
	);
	return rankIcon($user);
}
function rankIcon($list, $type = 1){
	global $lang;
	if(isBot($list['user_bot'])){
		return curRanking($lang['user_bot'], 'ico_bot', 'android');
	}
	else if($list['user_role'] > 0 && $list['user_rank'] < 8 && $type == 2){
		switch($list['user_role']){
			case 5:
				return curRanking($lang['r_admin'], 'ico_radmin', 'legal');
			case 4:
				return curRanking($lang['r_mod'], 'ico_rmod', 'legal');
		}
	}
	else {
		switch($list['user_rank']){
			case 0:
				return curRanking($lang['guest'], 'ico_guest', 'paw');
			case 1:
				return curRanking($lang['user'], 'ico_user', 'user');
			case 2:
				return curRanking($lang['vip'], 'ico_vip', 'diamond');
			case 8:
				return curRanking($lang['mod'], 'ico_mod', 'shield');
			case 9:
				return curRanking($lang['admin'], 'ico_admin', 'star');
			case 10:
				return curRanking($lang['owner'], 'ico_owner', 'trophy');
			default:
				return curRanking($lang['user'], 'ico_user', 'user');
		}
	}
}
function curRanking($txt, $color, $icon){
	return '<i title="' . $txt . '" class="' . $color . ' fa fa-' . $icon . '"></i>';
}
function listRank($current, $req = 0){
	global $lang, $data;
	$rank = '';
	if($req == 1){
		$rank .= '<option value="0" ' . selCurrent($current, 0) . '>' . $lang['guest'] . '</option>';
	}
	$rank .= '<option value="1" ' . selCurrent($current, 1) . '>' . $lang['user'] . '</option>';
	$rank .= '<option value="2" ' . selCurrent($current, 2) . '>' . $lang['vip'] . '</option>';
	$rank .= '<option value="8" ' . selCurrent($current, 8) . '>' . $lang['mod'] . '</option>';
	$rank .= '<option value="9" ' . selCurrent($current, 9) . '>' . $lang['admin'] . '</option>';
	$rank .= '<option value="10" ' . selCurrent($current, 10) . '>' . $lang['owner'] . '</option>';
	return $rank;
}
function changeRank($current){
	global $lang, $data;
	$rank = '';
	if(boomAllow(9)){
		$rank .= '<option value="1" ' . selCurrent($current, 1) . '>' . $lang['user'] . '</option>';
		$rank .= '<option value="2" ' . selCurrent($current, 2) . '>' . $lang['vip'] . '</option>';
		$rank .= '<option value="8" ' . selCurrent($current, 8) . '>' . $lang['mod'] . '</option>';
	}
	if(boomAllow(10)){
		$rank .= '<option value="9" ' . selCurrent($current, 9) . '>' . $lang['admin'] . '</option>';
	}
	return $rank;
}
function getRank($rank){
	global $lang;
	switch($rank){
		case 0:
			return $lang['guest'];
		case 1:
			return $lang['user'];
		case 2:
			return $lang['vip'];
		case 8:
			return $lang['mod'];
		case 9:
			return $lang['admin'];
		case 10:
			return $lang['owner'];
		default:
			return $lang['user'];
	}
}
function changeRoomRank($current){
	global $lang, $data;
	$rank = '';
	if(boomAllow(9) || boomRole(5)){
		$rank .= '<option value="0" ' . selCurrent($current, 0) . '>' . $lang['none'] . '</option>';
		$rank .= '<option value="4" ' . selCurrent($current, 4) . '>' . $lang['r_mod'] . '</option>';
	}
	if(boomAllow(9)){
		$rank .= '<option value="5" ' . selCurrent($current, 5) . '>' . $lang['r_admin'] . '</option>';
	}
	return $rank;
}
function roomTitle($rank){
	global $lang;
	switch($rank){
		case 5:
			return $lang['r_admin'];
		case 4:
			return $lang['r_mod'];
		case 0:
			return $lang['user'];
		default:
			return $lang['user'];
	}
}
function roomAccess($type){
	switch($type){
		case 0:
			return roomAccessIcon('globe', 'ico_public');
		case 1:
			return roomAccessIcon('user', 'ico_user');
		case 2:
			return roomAccessIcon('diamond', 'ico_vip');
		case 8:
			return roomAccessIcon('star', 'ico_admin');
		default:
			return roomAccessIcon('globe', 'ico_public');
	}
}
function roomAccessIcon($icon, $color){
	return '<i class="fa fa-' . $icon . ' ' . $color . '"></i>';	
}
?>