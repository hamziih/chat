<?php
function boomLogged(){
	global $boom_access;
	if($boom_access == 1){
		return true;
	}
}
function emoprocess($string) {
	$string = str_replace(array(':)',':P',':D',':(',':-O'),array(':smile:',':tongue:',':smileface:',':sad:',':omg:'), $string);
	return $string;
}
function normalise($text, $a){
	$count = substr_count($text,"http");
	if($count > $a){
		return false;
	}
	return true;
}
function burl(){
	$ht = 'http';
	if(isset($_SERVER['HTTPS'])){
		$ht = 'https';
	}
	$burl = $ht . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	return $burl;
}
function inRoom(){
	global $data;
	if($data['user_roomid'] != '0'){
		return true;
	}
}
function notVerified(){
	global $data;
	if($data['user_verify'] != 0 && !isStaff($data['user_rank']) &&  $data['activation'] == 1 ){
		return true;
	}
}
function clearBoomCache(){
	global $mysqli;
	$mysqli->query("UPDATE boom_setting SET bbfv = bbfv + 0.05");
}
function userVerified($u){
	if($u == 1){
		return true;
	}
}
function usePlayer(){
	global $data;
	if($data['player_id'] != 0){
		return true;
	}
}
function boomThisText($text){
	global $lang, $data;
	$text = str_replace(
	array(
		'%email%',
		'%user%', 
		'%cemail%',
		'%regmute%'
	),
	array(
		$data['user_email'],
		$data['user_name'],
		'<span class="theme_color">' . $data['user_email'] . '</span>',
		'<span class="theme_color bold">' . $data['reg_mute'] . '</span>'
	),
	$text);
	return $text;
}
function getUserAge($age){
	global $lang;
	if($age == 0){
		return $lang['not_set'];
	}
	else {
		return $age . ' ' . $lang['years_old'];
	}
}
function isBoomJson($res){
	if(is_string($res) && is_array(json_decode($res, true)) && (json_last_error() == JSON_ERROR_NONE)){
		return true;
	}
}
function getUserTheme($theme){
	global $data;
	if($theme == 'system'){
		return $data['default_theme'];
	}
	else {
		return $theme;
	}
}
function boomCacheUpdate(){
	global $mysqli;
	$mysqli->query("UPDATE boom_setting SET bbfv = bbfv + 0.01 WHERE id > 0");
}
function userLocation($user){
	global $lang;
	if($user['country'] == 'hide' || $user['region'] == 'hide'){
		return $lang['not_set'];
	}
	else {
		return $user['country'] . ',' . $user['region'];
	}
}
function boomSex($s){
	if($s != 0){
		return true;
	}
}
function boomAge($a){
	if($a != 0){
		return true;
	}
}
function boomLocation($user){
	if($user['country'] != 'hide' && $user['region'] != 'hide'){
		return true;
	}
}
function pageMenu($load, $icon, $txt){
	return '<li data="' . $load . '" class="get_dat pmenu"><span class="boom_menu_icon pagemenui"><i class="fa fa-' . $icon . '"></i></span>' . $txt . '</li>';
}
function pageBoxMenu($load, $icon, $txt, $type, $size = 0){
	return '<li onclick="getBox(\'' . $load . '\', \'' . $type . '\', ' . $size . ');" class="pmenu"><span class="boom_menu_icon pagemenui"><i class="fa fa-' . $icon . ' pagemenui"></i></span>' . $txt . '</li>';
}
function roomType($type){
	global $data;
	if($type >= 0 && $type <= $data['user_rank']){
		return true;
	}
}
function checkBan($ip){
	global $mysqli, $data;
	if(boomLogged()){
		$getip = $mysqli->query("SELECT * FROM boom_banned WHERE ip = '$ip'");
		if($getip->num_rows > 0 || $data['user_banned'] > 0){
			if(!boomAllow(10)){
				return true;
			}
		}
	}
}
function boomStaffContact($id){
	global $mysqli;
	$user = userDetails($id);
	if(empty($user)){
		return false;
	}
	if(isStaff($user['user_rank'])){
		return true;
	}
}
function useLobby(){
	global $data;
	if($data['use_lobby'] == 1){
		return true;
	}
}
function getBackMain($id){
	global $mysqli;
	$post = array();
	$get_back = $mysqli->query("
	SELECT boom_chat.*, boom_users.user_name, boom_users.user_color, boom_users.bccolor, boom_users.user_tumb
	FROM boom_chat
	LEFT JOIN boom_users
	ON boom_chat.user_id = boom_users.user_id
	WHERE boom_chat.user_id = '$id'
	ORDER BY `post_id` DESC LIMIT 1
	");
	if($get_back->num_rows == 1){
		$post = $get_back->fetch_assoc();
	}
	return $post;
}
function getBackPrivate($id){
	global $mysqli;
	$post = array();
	$get_back = $mysqli->query("
	SELECT boom_private.*, boom_users.user_name, boom_users.user_id, boom_users.user_color, boom_users.user_tumb
	FROM boom_private
	LEFT JOIN boom_users
	ON boom_private.hunter = boom_users.user_id
	WHERE boom_private.hunter = '$id'
	ORDER BY `id` DESC LIMIT 1
	");
	if($get_back->num_rows == 1){
		$post = $get_back->fetch_assoc();
	}
	return $post;
}
function clearPrivate($hunter, $target){
	global $mysqli;
	$mysqli->query("DELETE FROM boom_private WHERE hunter = '$hunter' AND target = '$target' OR hunter = '$target' AND target = '$hunter'");	
}
function roomRanking($rank = 0){
	global $lang;
	$room_menu = '<option value="0" ' . selCurrent($rank, 0) . '>' . $lang['public'] . '</option>';
	if(boomAllow(1)){
		$room_menu .= '<option value="1" ' . selCurrent($rank, 1) . '>' . $lang['user'] . '</option>';
	}
	if(boomAllow(2)){ 
		$room_menu .= '<option value="2" ' . selCurrent($rank, 2) . '>' . $lang['vip'] . '</option>';
	}
	if(boomAllow(8)){ 
		$room_menu .= '<option value="8" ' . selCurrent($rank, 8) . '>' . $lang['staff'] . '</option>';
	}
	return $room_menu;
}
function _isCurl(){
    return function_exists('curl_version');
}
function optionCount($sel, $min, $max, $divider, $alias = ''){
	$val = '';
	for ($n = $min; $n <= $max; $n+=$divider) {
		$val .= '<option value="' . $n . '" ' . selCurrent($sel, $n) . '>' . $n . ' ' . $alias . '</option>';
	}
	return $val;
}
function useBridge(){
	global $data;
	if($data['use_bridge'] > 0){
		return true;
	}
}
function getConfig($val){
	global $data;
	return $data[$val];
}
function sessionCleanup(){
	global $boom_config;
	unset($_SESSION['facebook_access_token']);
	unset($_SESSION[$boom_config['prefix'] . 'token']);
	unset($_SESSION[$boom_config['prefix'] . 'last']);
	unset($_SESSION[$boom_config['prefix'] . 'flood']);
	unset($_SESSION['HA::STORE']);
	unset($_SESSION['HA::CONFIG']);
	unset($_SESSION['FBRLH_state']);
	unset($_SESSION['token']);
}
function trimContent($text){
	$text = str_ireplace(array('****', 'b_o_o_m', 'my_notice', '%bcclear%', '%bcjoin%', '%bcquit%', 'cody_act', '%spam%'), '*****', $text);
	return $text;
}
function getBoomName($name, $connection){
	$t = 0;
	$tcount = 0;
	$try = $name;
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
function colorChoice($sel, $type, $min = 1, $max = 24){
	$show_c = '';
	$c = '';
	switch($type){
		case 1:
			$c = 'choice';
			break;
		case 2:
			$c = 'user_choice';
			break;
		case 3:
			$c = 'name_choice';
			break;
	}
	for ($n = $min; $n <= $max; $n++) {
		$val = 'bcolor' . $n;
		$back = 'bcback' . $n;
		if($val == $sel){
			$show_c .= '<div data="' . $val . '" class="color_switch ' . $c . ' ' . $back . '"><i class="bccheck fa fa-check"></i></div>';
		}
		else {
			$show_c .= '<div data="' . $val . '"  class="color_switch ' . $c . ' ' . $back . '"></div>';
		}
	}
	return $show_c;
}
function boldIt($sel){
	if($sel == 'bolded'){
		return 'theme_btn';
	}
	else {
		return 'default_btn';
	}
}
function boomFileSpace($f){
	return str_replace(' ', '_', $f);
}
function profileRegion(){
	global $data, $lang;
	require __DIR__ . '/location/country_list.php';
	if(array_key_exists($data['country'], $regions_list)){
		$my_region = $regions_list[$data['country']];
		foreach ($my_region as $region) {
			$list_region .= '<option ' . selCurrent($data['region'], trim($region)) . '>' . trim($region) . '</option>';
		}
	}
	$list_region .= '<option value="hide" ' . selCurrent($data['region'], 'Hide') . '>' . $lang['not_shared'] . '</option>';
	return $list_region;
}
function listCountry($c, $type){
	global $lang;
	require __DIR__ . '/location/country_list.php';
	$list_country = '';
	if($type == 1){
		$list_country .= '<option class="placeholder" selected disabled>' . $lang['country'] . '</option>';
	}
	foreach ($country_list as $country) {
		$list_country .= '<option ' . selCurrent($c, trim($country)) . ' value="' . $country . '">' . $country . '</option>';
	}
	if($type == 2){
		$list_country .= '<option value="hide" ' . selCurrent($c, 'hide') . '>' . $lang['not_shared'] . '</option>';	
	}
	return $list_country;
}
function okRegister($ip){
	global $mysqli, $data;
	$reg_delay = time() - 86400;
	$check = $mysqli->query("SELECT user_id FROM boom_users WHERE user_ip = '$ip' AND user_join >= '$reg_delay' AND user_rank != 0");
	if($check->num_rows < $data['max_reg']){
		return true;
	}
	else {
		return false;
	}
}
function guestCanRegister(){
	global $data;
	if(isGuest($data['user_rank']) && $data['registration'] == 1){
		return true;
	}
}
function okGuest($ip){
	global $mysqli, $data, $boom_config;
	$reg_delay = time() - 86400;
	$check = $mysqli->query("SELECT user_id FROM boom_users WHERE user_ip = '$ip' AND user_join >= '$reg_delay' AND user_rank = 0");
	if($check->num_rows < $boom_config['guest_per_day']){
		return true;
	}
	else {
		return false;
	}
}
function listSmilies($type){
	switch($type){
		case 1:
			$emo_act = 'document.chat_data.content';
			$closetype = 'closesmilies';
			break;
		case 2:
			$emo_act = 'document.private_form.message_content';
			$closetype = 'closesmilies_priv';
			break;
	}
	$files = scandir(__DIR__ . '/../emoticon');
	foreach ($files as $file){
		if ($file != "." && $file != ".."){
				$smile = preg_replace('/\.[^.]*$/', '', $file);
				if(strpos($file, '.png')){
					echo '<div  title=":' . $smile . ':" class="emoticon ' . $closetype . '"><img  class="lazyboom" data-img="emoticon/' . $smile . '.png" src="" onclick="emoticon(' . $emo_act . ', \':' . $smile . ':\')"/></div>';;
				}
				if(strpos($file, '.gif')){
					echo '<div  title=":' . $smile . ':" class="emoticon ' . $closetype . '"><img  class="lazyboom" data-img="emoticon/' . $smile . '.gif" src="" onclick="emoticon(' . $emo_act . ', \':' . $smile . ':\')"/></div>';;
				}
		}
	}
}
function createTumbnail($source, $path, $type, $width, $height, $sizew, $sizeh) {
	$dst    = @imagecreatetruecolor($sizew, $sizeh);
	switch ($type) {
		case 'image/gif':
			$src = @imagecreatefromgif($source);
			break;
		case 'image/png':
			$src = @imagecreatefrompng($source);
			break;
		case 'image/jpeg':
			$src = @imagecreatefromjpeg($source);
			break;
		default:
			return false;
			break;
	}
	$new_width  = $height * $sizew / $sizeh;
	$new_height = $width * $sizeh / $sizew;
	if ($new_width > $width) {
		$h = (($height - $new_height) / 2);
		@imagecopyresampled($dst, $src, 0, 0, 0, $h, $sizew, $sizeh, $width, $new_height);
	} else {
		$w = (($width - $new_width) / 2);
		@imagecopyresampled($dst, $src, 0, 0, $w, 0, $sizew, $sizeh, $new_width, $height);
	}
	switch ($type) {
		case 'image/gif':
			@imagegif($dst, $path, 80);
			break;
		case 'image/png':;
			@imagejpeg($dst, $path, 80);
			break;
		case 'image/jpeg':
			@imagejpeg($dst, $path, 80);
			break;
		default:
			return false;
			break;
	}
	if ($dst)
		@imagedestroy($dst);
	if ($src)
		@imagedestroy($src);
}
function validate_name($name){
	global $data, $mysqli;
	$lowname = mb_strtolower($name);
	$reserved = array('b_o_o_m', 'my_notice', 'cody_act');
	foreach ($reserved as $sreserve){
		if(stripos($lowname,mb_strtolower($sreserve)) !== FALSE){
			return false;
		}
	}
	$get_name = $mysqli->query("SELECT word FROM boom_filter WHERE word_type = 'username'");
	if($get_name->num_rows > 0){
		while($reject = $get_name->fetch_assoc()){
			if (stripos($lowname, mb_strtolower($reject['word'])) !== FALSE) {
				return false;
			}
		}
	}
	$regex = 'a-zA-Z0-9\p{Arabic}\p{Cyrillic}\p{Latin}\p{Han}\p{Katakana}\p{Hiragana}\p{Hebrew}';
	if(preg_match('/^[' . $regex . ']{1,}([\-\_ ]{1})?([' . $regex . ']{1,})?$/ui', $name) && mb_strlen($name, 'UTF-8') <= $data['max_username'] && !ctype_digit($name) && mb_strlen($name, 'UTF-8') >= 2){
		return true;
	}
	return false;
}
function doCurl($url, $f = array()){
	$result = '';
	if(function_exists('curl_init')){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		if(!empty($f)){
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $f);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_REFERER, burl());
		$result = curl_exec($curl);
		curl_close($curl);
	}
	return $result;
}
function trimCommand($text, $trim){
	return trim(str_replace($trim, '', $text));
}
function encodeFile($ext){
	global $data;
	$file_name = md5(rand(11,99) . time());
	$file_name = substr($file_name, 0, 12);
	return 'user' . $data['user_id'] . '_' . $file_name . "." . $ext;
}
function listAge($current, $type){
	global $data, $lang;
	$age = '';
	if($type == 1){
		$age .= '<option value="0" class="placeholder" selected disabled>' . $lang['age'] . '</option>';
	}
	for($value = $data['min_age']; $value <= 99; $value++){
		$age .=  '<option value="' . $value . '" ' . selCurrent($current, $value) . '>' . $value . '</option>';
	}
	if($type == 2){
		$age .=  '<option value="0" ' . selCurrent($current, 0) . '>' . $lang['not_shared'] . '</option>';
	}
	return $age;
}
function onOff($value){
	global $lang;
	$menu = '';
	$menu .= '<option value="1" ' . selCurrent($value, 1) . '>' . $lang['yes'] . '</option>';
	$menu .= '<option value="0" ' . selCurrent($value, 0) . '>' . $lang['no'] . '</option>';
	return $menu;
}
function activated($value){
	global $lang;
	$menu = '';
	$menu .= '<option value="1" ' . selCurrent($value, 1) . '>' . $lang['on'] . '</option>';
	$menu .= '<option value="0" ' . selCurrent($value, 0) . '>' . $lang['off'] . '</option>';
	return $menu;
}
function playerList(){
	global $mysqli, $data;
	$playlist = '';
	if(boomAllow($data['allow_player'])){
		$play_list = $mysqli->query("SELECT * FROM boom_radio_stream WHERE id > 0");
		if($play_list->num_rows > 0){
			while($player = $play_list->fetch_assoc()){
				$playlist .= '<li class="radio_element bellips add_cursor" data="' . $player['stream_url'] . '">' . $player['stream_alias'] . '</li>';
			}
		}
	}
	echo $playlist;
}
function adminPlayer($curr, $type){
	global $mysqli, $lang;
	$playlist = '';
	if($type == 1){
		$playlist .= '<option value="0">' . $lang['option_default'] . '</option>';
	}
	if($type == 2){
		$playlist .= '<option value="0">' . $lang['no_default'] . '</option>';
	}
	$play_list = $mysqli->query("SELECT * FROM boom_radio_stream WHERE id > 0");
	if($play_list->num_rows > 0){
		while($player = $play_list->fetch_assoc()){
			$playlist .= '<option  value="' . $player['id'] . '" ' . selCurrent($curr, $player['id']) . '>' . $player['stream_alias'] . '</option>';
		}
	}	
	return $playlist;
}
function getPlayer($room_player){
	global $mysqli, $data;
	$pdata['player_title'] = '';
	$pdata['player_url'] = '';
	if(usePlayer()){
		if($room_player == 0){
			$main_player = $mysqli->query("SELECT * FROM boom_radio_stream WHERE id = '{$data['player_id']}'");
			if($main_player->num_rows > 0){
				$player  = $main_player->fetch_assoc();
				$pdata['player_title'] = $player['stream_alias'];
				$pdata['player_url'] = $player['stream_url'];
			}
		}
		else {
			$get_player = $mysqli->query("SELECT * FROM boom_radio_stream WHERE id = '{$room_player}'");
			if($get_player->num_rows > 0){
				$player = $get_player->fetch_assoc();
				$pdata['player_title'] = $player['stream_alias'];
				$pdata['player_url'] = $player['stream_url'];
			}
			else {
				$main_player = $mysqli->query("SELECT * FROM boom_radio_stream WHERE id = '{$data['player_id']}'");
				if($main_player->num_rows > 0){
					$player = $main_player->fetch_assoc();
					$pdata['player_title'] = $player['stream_alias'];
					$pdata['player_url'] = $player['stream_url'];
				}
			}
		}
	}
	return $pdata;
}
function introLanguage(){
	$language_list = '';
	$dir = glob(__DIR__ . '/language/*' , GLOB_ONLYDIR);
	foreach($dir as $dirnew){
		$language = str_replace(__DIR__ . '/language/', '', $dirnew);
		$language_list .= boomTemplate('element/language', $language);
	}
	return $language_list;
}
function listLanguage($lang){
	$language_list = '';
	$dir = glob(__DIR__ . '/language/*' , GLOB_ONLYDIR);
	foreach($dir as $dirnew){
		$language = str_replace(__DIR__ . '/language/', '', $dirnew);
		$language_list .= '<option ' . selCurrent($lang, $language) . ' value="' . $language . '">' . $language . '</option>';
	}
	return $language_list;
}
function listTheme($th, $type){
	global $lang;
	$theme_list = '';
	if($type == 2){
		$theme_list .= '<option ' . selCurrent($th, 'system') . ' value="system">' . $lang['system_theme'] . '</option>';
	}
	$dir = glob(__DIR__ . '/../css/themes/*' , GLOB_ONLYDIR);
	foreach($dir as $dirnew){
		$theme = str_replace(__DIR__ . '/../css/themes/', '', $dirnew);
		$theme_list .= '<option ' . selCurrent($th, $theme) . ' value="' . $theme . '">' . $theme . '</option>';
	}
	return $theme_list;
}
function checkEmail($email){
	global $mysqli, $data;
	$check_email = $mysqli->query("SELECT * FROM `boom_users` WHERE `user_email` = '$email'");
	if($check_email->num_rows < 1 || $data['allow_email'] == 1){
		return true;
	}
}
function roomActive($w){
	if($w > calWeek(1)){
		return '<i class="fa fa-circle success"></i>';
	}
	else if($w < calWeek(1) && $w > calmonth(1)){
		return '<i class="fa fa-circle warn"></i>';
	}
	else {
		return '<i class="fa fa-circle error"></i>';
	}
}
function boomWarning($message, $type){
	$box['message'] = $message;
	$box['type'] = $type;
	return boomTemplate('element/warning_box', $box);
}
function postNotify($target, $type, $source){
	global $mysqli, $data;
	$mysqli->query("INSERT INTO boom_notification ( notifier, notified, notify_type, notify_date, notify_source, notify_id) VALUE ('{$data['user_id']}', '$target', '$type', '" . time() . "', 'post', '$source')");
	updateNotify($target);
}
function regNotify($target, $type, $custom = ''){
	global $mysqli, $data;
	$mysqli->query("INSERT INTO boom_notification ( notifier, notified, notify_type, notify_date, notify_source, notify_id) VALUE ('{$data['user_id']}', '$target', '$type', '" . time() . "', 'notify', '$custom')");
	updateNotify($target);
}
function listFriends($id){
	global $mysqli;
	$friend_list = array();
	$find_friend = $mysqli->query("SELECT target FROM boom_friends WHERE hunter = '$id' AND status = '3'");
	if($find_friend->num_rows > 0){
		while($find = $find_friend->fetch_assoc()){
			array_push($friend_list, $find['target']);
		}
	}
	return $friend_list;
}
function postFriendsNotify($source){
	global $mysqli, $data;
	$values = '';
	$list = array();
	$get_friend = $mysqli->query("SELECT target FROM boom_friends WHERE hunter = '{$data['user_id']}' AND status = '3'");
	if($get_friend->num_rows > 0){
		while($friend = $get_friend->fetch_assoc()){
			$values .= "('{$data['user_id']}', '{$friend['target']}', 'add_post', '" . time() . "', 'post', '$source'),";
			array_push($list, $friend['target']);
		}
		$values = trim($values);
		$values = rtrim($values, ',');
		$mysqli->query("INSERT INTO boom_notification ( notifier, notified, notify_type, notify_date, notify_source, notify_id) VALUES $values");
		updateFriendsNotify($data['user_id']);
	}
}
function deleteLike($post){
	global $mysqli, $data;
	$mysqli->query("DELETE FROM boom_post_like WHERE like_post = '$post' AND uid = '{$data['user_id']}'");
}
function updateLike($post, $type){
	global $mysqli, $data;
	$now = time();
	$mysqli->query("UPDATE boom_post_like SET like_type = '$type', like_date = '$now' WHERE like_post = '$post' AND uid = '{$data['user_id']}'");
}
function updateNotifyPost($who, $post, $type, $old){
	global $mysqli, $data;
	$now = time();
	$mysqli->query("UPDATE boom_notification SET notify_type = '$type', notify_date = '$now', notify_view = '0' WHERE notify_id = '$post' AND notifier = '{$data['user_id']}' AND notify_type = '$old'");
	updateNotify($who);
}
function deleteNotifyPost($who, $post, $type){
	global $mysqli, $data;
	$now = time();
	$mysqli->query("DELETE FROM boom_notification WHERE notify_id = '$post' AND notifier = '{$data['user_id']}' AND notify_type = '$type'");
	updateNotify($who);
}
function getPostData($id){
	global $mysqli;
	$user = array();
	$get_post = $mysqli->query("SELECT * FROM boom_post WHERE post_id = '$id'");
	if($get_post->num_rows > 0){
		$user = $get_post->fetch_assoc();
	}
	return $user;
}
function unlinkAvatar($file){
	if(validAvatar($file)){
		$delete =  __DIR__ . '/../avatar/' . $file;
		if(file_exists($delete)){
			unlink($delete);
		}
	}
	return true;
}
function selCurrent($cur, $val){
	if($cur == $val){
		return 'selected';
	}
}
function getTimezone($zone){
	$list_zone = '';
	require __DIR__ . '/element/timezone.php';
	foreach ($timezone as $line) {
		$list_zone .= '<option value="' . $line . '" ' . selCurrent($zone, $line) . '>' . $line . '</option>';
	}
	return $list_zone;
}
function roomExist($name, $id){
	global $mysqli;
	$check_room = $mysqli->query("SELECT room_name FROM boom_rooms WHERE room_name = '$name' AND room_id != '$id'");
	if($check_room->num_rows > 0){
		return true;
	}
}
function bValid($val){
    if(preg_match('/^[a-f0-9\-]{36}$/', $val)){
		return 1;
	}
	return 0;
}
function insideChat($p){
	if($p == 'chat'){
		return true;
	}
}
function checkName($name){
	if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $name)){
		return true;
	}
}
function freeUsername($user, $id){
	global $mysqli;
	$getuser = $mysqli->query("SELECT user_name FROM boom_users WHERE user_name = '$user' AND user_id != '$id'");
	if($getuser->num_rows < 1){
		return true;
	}
}
function validAvatar($av){
	if(stripos($av, 'default') === false){
		return true;
	}
}
function unlinkUpload($path, $file){
	$delete =  __DIR__ . '/../upload/' . $path . '/' . $file;
	if(file_exists($delete)){
		unlink($delete);
	}
}
function deleteFile($path){
	$delete =  __DIR__ . '/../' . $path;
	if(file_exists($delete)){
		unlink($delete);
	}
}
function resetAvatar($u){
	global $mysqli;
	$unlink_tumb = unlinkAvatar($u['user_tumb']);
	if($u['user_bot'] > 0){
		switch($u['user_bot']){
			case 1:
				$av = 'default_bot.png';
				break;
			case 9:
				$av = 'default_system.png';
				break;
			default:
				$av = 'default_bot.png';
		}
	}
	else {
		switch($u['user_rank']){
			case 0:
				$av = 'default_guest.png';
				break;
			case 1:
				$av = 'default_avatar.png';
				break;
			default:
				$av = 'default_avatar.png';
		}
	}
	$mysqli->query("UPDATE boom_users SET user_tumb = '$av' WHERE user_id = '{$u['user_id']}'");
	return $av;
}
function changeColor($color, $id){
	global $mysqli, $data;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!boomAllow($data['allow_name_color'])){
		return 0;
	}
	if(isGreater($user['user_rank']) && boomAllow(9) || !notMe($id) && boomAllow(9)){
		if(preg_match('/^bcolor[0-9]{1,2}$/', $color) || $color == 'user'){
			$mysqli->query("UPDATE boom_users SET user_color = '$color' WHERE user_id = '$id'");
			return 1;
		}
		else {
			return 0;
		}
	}
	else {
		return 0;
	}
}
function changeUserRank($target, $rank){
	global $mysqli, $data;
	$user = userDetails($target);
	if(empty($user)){
		return 3;
	}
	if($user['user_rank'] == $rank){
		return 2;
	}
	if(isGreater($user['user_rank']) && isGreater($rank)){
		if($user['user_rank'] > $rank){
			if($user['user_status'] == 6){
				$mysqli->query("UPDATE boom_users SET user_status = 1 WHERE user_id = '$target'");
			}
		}
		$mysqli->query("DELETE FROM boom_notification WHERE notified = '$target' AND notify_type = 'rank_change'");
		systemNotify($target, 'rank_change', $rank);
		if(isStaff($rank)){
			$mysqli->query("UPDATE boom_users SET room_mute = '0', user_private = 1, user_mute = 0, user_word_mute = 0, user_flood = 0, ureg_mute = 0 WHERE user_id = '$target'");
			$mysqli->query("DELETE FROM boom_room_action WHERE action_user = '$target'");
			$mysqli->query("DELETE FROM boom_ignore WHERE ignored = '$target'");
		}
		if($rank < $data['allow_colors']){
			resetColors($user['user_id']);
		}
		$mysqli->query("UPDATE boom_users SET  user_rank = '$rank', user_action = user_action + 1 WHERE user_id = '$target'");
		return 1;
	}
	else {
		return 0;
	}
}
function clearUserMood($target){
	global $mysqli, $data;
	$user = userDetails($target);
	if(empty($user)){
		return 3;
	}
	if(isGreater($user['user_rank']) && boomAllow(9)){
		$mysqli->query("UPDATE boom_users SET  user_mood = '' WHERE user_id = '$target'");
		return 1;
	}
	else {
		return 0;
	}
}
function deleteAccount($id){
	global $mysqli, $data;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if(isBot($user['user_bot'])){
		return 0;
	}
	if(boomAllow(10) && isGreater($user['user_rank']) && !userOwner($user) && notMe($user['user_id'])){
		clearUserData($user);
		return 1;
	}
	else {
		return 0;
	}
}
function ignore($id){
	global $mysqli, $data;
	$count_ignore = $mysqli->query("SELECT * FROM boom_ignore WHERE ignored = '$id' AND ignorer = '{$data['user_id']}'");
	if($count_ignore->num_rows < 1){
		$user = userDetails($id);
		if(empty($user)){
			return 3;
		}
		if(!isStaff($user['user_rank']) && !isBot($user['user_bot']) && notMe($user['user_id'])){
			$mysqli->query("INSERT INTO boom_ignore (ignorer, ignored) VALUES ('{$data['user_id']}', '$id')");
			$mysqli->query("DELETE FROM boom_friends WHERE hunter = '{$data['user_id']}' AND target = '$id' OR hunter = '$id' AND target = '{$data['user_id']}'");
			createIgnore();
			return 1;
		}
		else {
			return 0;
		}
	}
	else {
		return 2;
	}
}
function removeIgnore($id){
	global $mysqli, $data;
	$mysqli->query("DELETE FROM boom_ignore WHERE ignorer = '{$data['user_id']}' AND ignored = '$id'");
	createIgnore();
	return 1;
}
function muteAccount($id){
	global $mysqli, $data;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if($user['user_mute'] > 0){
		return 2;
	}
	if(isGreater($user['user_rank']) && boomAllow(8) && notMe($user['user_id']) && !isBot($user['user_bot'])){
		$mysqli->query("UPDATE boom_users SET user_mute = '" . time() . "', user_word_mute = 0, ureg_mute = 0 WHERE user_id = '$id'");
		clearMuteNotify($id);
		systemNotify($id, 'system_mute', '');
		return 1;
	}
	else {
		return 0;
	}
}
function unmuteAccount($id){
	global $mysqli, $data;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if(isGreater($user['user_rank']) && boomAllow(8) && notMe($user['user_id']) && !isBot($user['user_bot'])){
		$mysqli->query("UPDATE boom_users SET user_mute = 0, user_word_mute = 0, user_flood = 0, ureg_mute = 0 WHERE user_id = '$id'");
		clearMuteNotify($id);
		systemNotify($id, 'system_unmute', '');
		return 1;
	}
	else {
		return 0;
	}
}
function banAccount($id){
	global $mysqli, $data;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if($user['user_banned'] > 0){
		return 2;
	}
	if(isGreater($user['user_rank']) && boomAllow(9) && notMe($user['user_id']) && !isBot($user['user_bot'])){
		$mysqli->query("UPDATE boom_users SET user_banned = '" . time() . "', user_action = user_action + 1, user_roomid = '0' WHERE user_id = '$id'");
		$mysqli->query("INSERT INTO boom_banned ( ip , ban_user ) VALUES ('{$user['user_ip']}', '{$user['user_id']}')");
		return 1;
	}
	else {
		return 0;
	}
}
function systemBan($d){
	global $mysqli;
	if(!isStaff($d['user_rank']) && !isBot($d['user_bot'])){
		$mysqli->query("UPDATE boom_users SET user_banned = '" . time() . "', user_action = user_action + 1, user_roomid = '0' WHERE user_id = '{$d['user_id']}'");
		$mysqli->query("INSERT INTO boom_banned ( ip , ban_user ) VALUES ('{$d['user_ip']}', '{$d['user_id']}')");
	}
}
function systemMute($d){
	global $mysqli;
	if(!isStaff($d['user_rank']) && !isBot($d['user_bot'])){
		$mysqli->query("UPDATE boom_users SET user_mute = '" . time() . "', user_word_mute = 0 WHERE user_id = '{$d['user_id']}'");
		clearMuteNotify($d['user_id']);
		systemNotify($d['user_id'], 'system_mute', '');
	}
}
function systemWordMute($d){
	global $data, $mysqli;
	if($d['user_mute'] > 0){
		return false;
	}
	if(!isStaff($d['user_rank']) && !isBot($d['user_bot'])){
		$unmute = calMinutesUp($data['word_delay']);
		$mysqli->query("UPDATE boom_users SET user_word_mute = '" . time() . "' WHERE user_id = '{$d['user_id']}'");
		clearMuteNotify($d['user_id']);
		systemNotify($d['user_id'], 'bad_word', $data['word_delay']);
	}
}
function unbanAccount($id){
	global $mysqli, $data;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if($user['user_banned'] < 1){
		return 2;
	}
	if(isGreater($user['user_rank']) && boomAllow(9) && notMe($user['user_id']) && !isBot($user['user_bot'])){
		$mysqli->query("UPDATE boom_users SET user_banned = 0, user_action = user_action + 1 WHERE user_id = '$id'");
		$mysqli->query("DELETE FROM boom_banned WHERE ip = '{$user['user_ip']}' OR ban_user = '{$user['user_id']}'");
		return 1;
	}
	else {
		return 0;
	}
}
function userRoomDetails($id){
	global $mysqli, $data;
	$user = array();
	$getuser = $mysqli->query("SELECT *,
	(SELECT room_rank FROM boom_room_staff WHERE room_staff = '$id' AND room_id = '{$data['user_roomid']}') as room_ranking,
	(SELECT count(*) FROM boom_room_action WHERE action_muted = '1' AND action_user = '$id' AND action_room = '{$data['user_roomid']}') as is_muted,
	(SELECT count(*) FROM boom_room_action WHERE action_blocked = '1' AND action_user = '$id' AND action_room = '{$data['user_roomid']}') as is_blocked,
	(SELECT count(id) FROM boom_friends WHERE target = '{$data['user_id']}' AND hunter = '$id' ) as my_friend,
	(SELECT count(ignore_id) FROM boom_ignore WHERE ignorer = '{$data['user_id']}' AND ignored = '$id' ) as ignored
	FROM boom_users WHERE user_id = '$id'");
	if($getuser->num_rows > 0){
		$user = $getuser->fetch_assoc();
	}
	return $user;
}
function blockRoom($id){
	global $mysqli, $data;
	$user = userRoomDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canRoomAction($user, 2) || $data['user_roomid'] == 1 || !boomRole(5) && !boomAllow(9)){
		return 0;
	}
	else{
		$mysqli->query("UPDATE boom_users SET user_action = user_action + 1, user_roomid = '0' WHERE user_id = '$id'");
		$checkroom = $mysqli->query("SELECT * FROM boom_room_action WHERE action_room = '{$data['user_roomid']}' AND action_user = '$id'");
		if($checkroom->num_rows > 0){
			$mysqli->query("UPDATE boom_room_action SET action_blocked = '1' WHERE action_user = '$id' AND action_room = '{$data['user_roomid']}'");
		}
		else {
			$mysqli->query("INSERT INTO boom_room_action ( action_room , action_user, action_blocked ) VALUES ('{$data['user_roomid']}', '$id', '1')");
		}
		return 1;
	}
}
function vCheck($val){
	if(preg_match('/^[0-9a-z\-]{36}$/', $val)){
		return true;
	}
}
function muteRoom($id){
	global $mysqli, $data;
	$user = userRoomDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canRoomAction($user, 2)){
		return 0;
	}
	else {
		$mysqli->query("UPDATE boom_users SET room_mute = 1 WHERE user_id = '$id' AND user_roomid = '{$data['user_roomid']}'");
		$checkroom = $mysqli->query("SELECT * FROM boom_room_action WHERE action_room = '{$data['user_roomid']}' AND action_user = '$id'");
		if($checkroom->num_rows > 0){
			$mysqli->query("UPDATE boom_room_action SET action_muted = '1' WHERE action_user = '$id' AND action_room = '{$data['user_roomid']}'");
		}
		else {
			$mysqli->query("INSERT INTO boom_room_action ( action_room , action_user, action_muted ) VALUES ('{$data['user_roomid']}', '$id', '1')");
		}
		return 1;
	}
}
function unmuteRoom($id){
	global $mysqli, $data;
	$user = userRoomDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canRoomAction($user, 2)){
		return 0;
	}
	else{
		$mysqli->query("UPDATE boom_users SET room_mute = 0 WHERE user_id = '$id' AND user_roomid = '{$data['user_roomid']}'");
		$mysqli->query("DELETE FROM boom_room_action WHERE action_room = '{$data['user_roomid']}' AND action_user = '$id' AND action_muted = '1' AND action_blocked = '0'");
		$mysqli->query("UPDATE boom_room_action SET action_muted = '0' WHERE action_room = '{$data['user_roomid']}' AND action_user = '$id' AND action_muted = '1'");
		return 1;
	}
}
function unblockRoom($id){
	global $mysqli, $data;
	$user = userRoomDetails($id);
	if(empty($user)){
		return 3;
	}
	if(!canRoomAction($user, 2) || !boomRole(5) && !boomAllow(9)){
		return 0;
	}
	else {
		$mysqli->query("DELETE FROM boom_room_action WHERE action_room = '{$data['user_roomid']}' AND action_user = '$id' AND action_blocked = '1' AND action_muted = '0'");
		$mysqli->query("UPDATE boom_room_action SET action_blocked = '0' WHERE action_room = '{$data['user_roomid']}' AND action_user = '$id' AND action_blocked = '1'");
		return 1;
	}
}
function verifyUser($id){
	global $mysqli, $data;
	$user = userDetails($id);
	if(empty($user)){
		return 3;
	}
	if($user['verified'] == 1){
		return 2;
	}
	if(boomAllow(9) && isGreater($user['user_rank']) || boomAllow(9) && !notme($user['user_id'])){
		$mysqli->query("UPDATE boom_users SET verified = '1', user_verify = 0, email_count = '0', user_action = user_action + 1, ureg_mute = 0 WHERE user_id = '$id'");
		return 1;
	}
	else {
		return 0;
	}
}
function canRoomAction($user, $type = 1){
	global $mysqli, $data;
	if(empty($user)){
		return false;
	}
	if(!notMe($user['user_id'])){
		return false;
	}
	if(!boomRole(4) && !boomAllow(9)){
		return false;
	}
	if(isStaff($user['user_rank']) || isBot($user['user_bot'])){
		return false;
	}
	if(!betterRole($user['room_ranking']) && !boomAllow(9)){
		return false;
	}
	if($type == 2 && roomStaff($user['room_ranking'])){
		return false;
	}
	return true;
}
function roomStaff($rank){
	if($rank > 3){
		return true;
	}
}
function boomDat($val, $res = 0){
	if($val != '' || !empty($val)){
		$res = 1;
	}
	return $res;
}
function betterRole($rank){
	global $data;
	if($data['user_role'] > $rank || boomAllow(9)){
		return true;
	}
}
function checkMod($id){
	global $data, $mysqli;
	$checkmod = $mysqli->query("SELECT * FROM boom_room_staff WHERE room_id = '{$data['user_roomid']}' AND room_staff = '$id'");
	if($checkmod->num_rows < 1){
		return true;
	}
}
function listAction($user){
	global $lang, $data;
	$id = $user['user_id'];
	$menu = '<option value="no_action">' . $lang['action_none'] . '</option>';
	if(boomAllow(9)){
		$menu .= '<option value="verify_account">' . $lang['action_verify'] . '</option>';
	}
	if(boomAllow(8) && notMe($id)){
		$menu .= '<option value="unmute">' . $lang['unmute'] . '</option>';
	}
	if(boomAllow(8) && notMe($id)){
		$menu .= '<option value="mute">' . $lang['mute'] . '</option>';
	}
	if(boomAllow(9) && notMe($id)){
		$menu .= '<option value="unban">' . $lang['unban'] . '</option>';
	}
	if(boomAllow(9) && notMe($id)){
		$menu .= '<option value="ban">' . $lang['ban'] . '</option>';
	}
	return $menu;
}
function listRoomAction($user){
	global $lang, $data;
	$id = $user['user_id'];
	$menu = '<option value="no_action">' . $lang['action_none'] . '</option>';
	if(boomAllow(9) || boomRole(4)){
		$menu .= '<option value="room_unmute">' . $lang['unmute'] . '</option>';
		$menu .= '<option value="room_mute">' . $lang['mute'] . '</option>';
	}
	if(!isMainRoom()){
		if(boomAllow(9) || boomRole(5)){
			$menu .= '<option value="room_block">' . $lang['room_block'] . '</option>';
		}
	}
	return $menu;
}
function addonsLang($name){
	global $data;
	$load_lang = __DIR__ . '/../addons/' . $name . '/language/' . $data['user_language'] . '.php';
	if(file_exists($load_lang)){
		return $load_lang;
	}
	else {
		return __DIR__ . '/../addons/' . $name . '/language/Default.php';
	}
}
function addonsLangCron($name){
	global $data;
	$load_lang = __DIR__ . '/../addons/' . $name . '/language/' . $data['language'] . '.php';
	if(file_exists($load_lang)){
		return $load_lang;
	}
	else {
		return __DIR__ . '/../addons/' . $name . '/language/Default.php';
	}
}
function addonsData($this_addons){
	global $mysqli;
	$get_settings = $mysqli->query("SELECT * FROM boom_addons WHERE addons = '$this_addons'");
	if($get_settings->num_rows > 0){
		$table_data = $get_settings->fetch_assoc();
	}
	return $table_data;
}
function randomPass(){
	$text = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890++--@@@___';
	$text = substr(str_shuffle($text), 0, 10);
	return encrypt($text);
}
function alphaClear($s){
	return preg_replace('@[a-zA-Z-]@', '', $s);
}
function numsClear($s){
	return preg_replace('@[0-9-]@', '', $s);
}
function isMainRoom(){
	global $data;
	if($data['user_roomid'] == 1){
		return true;
	}
}
function elementTitle($icon, $title){
	$top_it = array(
		'icon'=> $icon,
		'title'=> $title
	);
	return boomTemplate('element/page_top', $top_it);
}
function boxTitle($icon, $title){
	$top_it = array(
		'icon'=> $icon,
		'title'=> $title
	);
	return boomTemplate('element/box_title', $top_it);
}
function findFriend($user){
	global $mysqli, $lang;
	$friend_list = '';
	$find_friend = $mysqli->query("SELECT boom_users.user_name, boom_users.user_id, boom_users.user_tumb, boom_users.user_color, boom_users.last_action, boom_users.user_rank, boom_friends.* FROM boom_users, boom_friends 
	WHERE hunter = '{$user['user_id']}' AND status = '3' AND target = boom_users.user_id ORDER BY last_action DESC, user_name ASC LIMIT 50");
	if($find_friend->num_rows > 0){
		while($find = $find_friend->fetch_assoc()){
			$friend_list .= boomTemplate('element/user_square', $find);
		}
	}
	else {
		$friend_list .= emptyZone($lang['no_data']);
	}
	return $friend_list;
}
function myFriend(){
	global $mysqli, $lang, $data;
	$friend_list = '';
	$find_friend = $mysqli->query("SELECT boom_users.user_name, boom_users.user_id, boom_users.user_tumb, boom_users.user_color, boom_users.last_action, boom_users.user_rank, boom_friends.* FROM boom_users, boom_friends 
	WHERE hunter = '{$data['user_id']}' AND status > 1 AND target = boom_users.user_id ORDER BY status DESC, user_name ASC");
	if($find_friend->num_rows > 0){
		while($find = $find_friend->fetch_assoc()){
			$friend_list .= boomTemplate('element/friend_element', $find);
		}
	}
	else {
		$friend_list .= emptyZone($lang['no_friend']);
	}
	return '<div class="ulist_container">' . $friend_list . '</div>';
}
function myIgnore(){
	global $data, $mysqli, $lang;
	$ignore_list = '';
	$find_ignore = $mysqli->query("SELECT boom_users.user_name, boom_users.user_id, boom_users.user_tumb, boom_users.user_color, boom_users.last_action, boom_users.user_rank, boom_ignore.* FROM boom_users, boom_ignore 
	WHERE ignorer = '{$data['user_id']}' AND ignored = boom_users.user_id ORDER BY boom_users.user_name ASC");
	if($find_ignore->num_rows > 0){
		while($find = $find_ignore->fetch_assoc()){
		$ignore_list .= boomTemplate('element/ignore_element', $find);
		}
	}
	else {
		$ignore_list .= emptyZone($lang['no_ignore']);
	}
	return '<div class="ulist_container">' . $ignore_list . '</div>';
}
function showPost($secret, $postid){
	global $data, $mysqli, $lang;
	$wall_content = '';	
	$wall_post = $mysqli->query("SELECT boom_post.*, boom_users.user_name, boom_users.user_id, boom_users.user_rank, boom_users.user_color, boom_users.user_tumb,
	(SELECT count( parent_id ) FROM boom_post_reply WHERE parent_id = boom_post.post_id ) as reply_count,
	(1) as post_count,
	(SELECT like_type FROM boom_post_like WHERE uid = '{$data['user_id']}' AND like_post = boom_post.post_id) as liked,
	(SELECT count(id) FROM boom_post_like WHERE like_post = boom_post.post_id AND like_type = 1 ) as like_count,
	(SELECT count(id) FROM boom_post_like WHERE like_post = boom_post.post_id AND like_type = 2 ) as unlike_count
	FROM  boom_post, boom_users 
	WHERE (boom_post.post_user = boom_users.user_id AND secret = '$secret' AND post_id = '$postid')
	ORDER BY boom_post.post_actual DESC LIMIT 1");

	if($wall_post->num_rows > 0){
		while ($wall = $wall_post->fetch_assoc()){
			$post_count = $wall['post_count'];
			$wall_content .= boomTemplate('element/wall_post',$wall);
		}
	}
	else { 
		$wall_content .= emptyZone($lang['wall_empty']);
	}
	return $wall_content;
}
function getNews(){
	global $data, $mysqli, $lang;
	$news_content = '';
	$news_add = '';
	$t = time();

	if(boomAllow(10)){
		$news_add = boomTemplate('element/news_input');
	}
	$get_news = $mysqli->query("SELECT boom_news.*, boom_users.user_name, boom_users.user_id,  boom_users.user_rank, boom_users.user_color, boom_users.user_tumb
	FROM boom_news, boom_users
	WHERE boom_news.news_poster = boom_users.user_id 
	ORDER BY news_date DESC LIMIT 16");

	if($get_news->num_rows > 0){
		while ($news = $get_news->fetch_assoc()){
			$news_content .= boomTemplate('element/news', $news);
		}
		$mysqli->query("UPDATE boom_users SET user_news = '$t' WHERE user_id = '{$data['user_id']}'");
	}
	else {
		$news_content .= emptyZone($lang['no_news']);
	}
	return 	$news_add . '<div id="container_news">' . $news_content . '</div>';
	
}
function thisNews($id){
	global $mysqli, $lang;
	$news_content = '';
	$get_news = $mysqli->query("SELECT boom_news.*, boom_users.user_name, boom_users.user_id,  boom_users.user_rank, boom_users.user_color, boom_users.user_tumb
	FROM boom_news, boom_users
	WHERE boom_news.news_poster = boom_users.user_id AND boom_news.id = '$id'
	ORDER BY news_date DESC LIMIT 1");
	while ($news = $get_news->fetch_assoc()){
		$news_content .= boomTemplate('element/news', $news);
	}
	return $news_content;
}
function wordFilter($text, $type = 0){
	global $mysqli, $data, $lang;
	$text = trimContent($text);
	$text_trim = mb_strtolower(str_replace(array(' '), '', $text));
	$take_action = 0;
	$spam_action = 0;
	if(!boomAllow(10)){
		$words = $mysqli->query("SELECT * FROM `boom_filter` WHERE word_type = 'word' OR word_type = 'spam'");
		if ($words->num_rows > 0){
			while($filter = $words->fetch_assoc()){
				if($filter['word_type'] == 'word'){
					if(stripos($text, $filter['word']) !== false){
						$text = str_ireplace($filter['word'], '****',$text);
						$take_action++;
					}
				}
				else if($filter['word_type'] == 'spam'){
					if(stripos($text_trim, $filter['word']) !== false){
						$spam_action++;
					}
				}
			}
		}
		if($take_action > 0 && $type == 1 && $spam_action == 0){
			switch($data['word_action']){
				case 2:
					systemWordMute($data);
					break;
			}
		}
		if($spam_action > 0){
			$text = '<div class="system_text">%spam%</div>';
			switch($data['spam_action']){
				case 1:
					systemMute($data);
					break;
				case 2:
					systemBan($data);
					break;
			}
		}
	}
	return $text;
}
function isBadText($text){
	global $mysqli, $data;
	$text = trimContent($text);
	$text_trim = mb_strtolower(str_replace(array(' '), '', $text));
	if(!boomAllow(10)){
		$words = $mysqli->query("SELECT * FROM `boom_filter` WHERE word_type = 'word' OR word_type = 'spam'");
		if ($words->num_rows > 0){
			while($filter = $words->fetch_assoc()){
				if($filter['word_type'] == 'word'){
					if(stripos($text, $filter['word']) !== false){
						return true;
					}
				}
				else if($filter['word_type'] == 'spam'){
					if(stripos($text_trim, $filter['word']) !== false){
						return true;
					}
				}
			}
		}
	}
}
function isTooLong($text, $max){
	if(mb_strlen($text, 'UTF-8') > $max){
		return true;
	}
}
function introActive($amount){
	global $mysqli;
	$find_last = $mysqli->query("SELECT user_tumb, user_name FROM boom_users WHERE user_bot = 0 AND user_rank > 0 ORDER BY last_action DESC LIMIT $amount");
	$active = '';
	if($find_last->num_rows > 0){
		while ($last = $find_last->fetch_assoc()){
			$active .= boomTemplate('element/active_intro', $last);
		}
	}
	return $active;
}
function embedActive($amount){
	global $mysqli;
	$find_last = $mysqli->query("SELECT user_tumb, user_name FROM boom_users WHERE user_bot = 0 AND user_rank > 0 ORDER BY last_action DESC LIMIT $amount");
	$active = '';
	if($find_last->num_rows > 0){
		while ($last = $find_last->fetch_assoc()){
			$active .= boomTemplate('element/active_embed', $last);
		}
	}
	return $active;
}
function isImage($ext){
	$ext = strtolower($ext);
	$img = array( 'image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png', 'image/JPG' );
	$img_ext = array( 'gif', 'jpeg', 'jpg', 'JPG', 'PNG', 'png', 'x-png', 'pjpeg' );
	if( in_array($_FILES["file"]["type"], $img) && in_array($ext, $img_ext)){
		return true;
	}
}
function isFile($ext){
	$ext = strtolower($ext);
	$f = array( 'application/zip', 'application/x-zip-compressed', 'application/pdf', 'application/octet-stream', 'application/x-zip-compressed' );
	$f_ext = array( 'zip', 'pdf', 'ZIP', 'PDF' );
	if( in_array($_FILES["file"]["type"], $f) && in_array($ext, $f_ext)){
		return true;
	}
}
function isMusic($ext){
	$ext = strtolower($ext);
	$f = array( 'audio/mpeg', 'audio/mp3', 'audio/x-mpeg', 'audio/x-mp3', 'audio/mpeg3',
	'audio/x-mpeg3', 'audio/mpg', 'audio/x-mpg', 'audio/x-mpegaudio' );
	$f_ext = array( 'mp3' );
	if( in_array($_FILES["file"]["type"], $f) && in_array($ext, $f_ext)){
		return true;
	}
}
function fileError($type = 1){
	global $data;
	$size = $data['file_weight'];
	if($type == 2){
		$size = $data['max_avatar'];
	}
	if($_FILES["file"]["error"] > 0 || (($_FILES["file"]["size"] / 1024)/1024) > $size ){
		return true;
	}
}
function targetExist($id){
	global $data, $mysqli;
	$get_target = $mysqli->query("SELECT user_id FROM boom_users WHERE user_id = '$id'");
	if($get_target->num_rows > 0){
		return true;
	}
}
function removeRelatedFile($id, $zone){
	global $mysqli;
	$get_file = $mysqli->query("SELECT * FROM boom_upload WHERE relative_post = '$id' AND file_zone = '$zone'");
	if($get_file->num_rows > 0){
		while ($file = $get_file->fetch_assoc()){
			unlinkUpload($zone, $file['file_name']);
		}
		$mysqli->query("DELETE FROM boom_upload WHERE relative_post = '$id' AND file_zone = '$zone'");
	}	
}
function getRoomMuted($r){
	global $mysqli, $lang;
	$muted_list = '';
	$get_muted = $mysqli->query("SELECT boom_room_action.*, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_id
				FROM boom_room_action
				LEFT JOIN boom_users
				ON boom_room_action.action_user = boom_users.user_id
				WHERE action_room = '$r' AND action_muted > 0
				ORDER BY  boom_users.user_name ASC");
	if($get_muted->num_rows > 0){
		while($muted = $get_muted->fetch_assoc()){
			$muted['action'] = 'delete_room_muted';
			$muted_list .= boomTemplate('element/room_user', $muted);
		}
	}
	else{
		$muted_list .= emptyZone($lang['no_data']);
	}
	return '<div class="staff_list">' . $muted_list . '</div>';
}
function getRoomBlocked($r){
	global $mysqli, $lang;
	$blocked_list = '';
	$get_blocked = $mysqli->query("SELECT boom_room_action.*, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_id
				FROM boom_room_action
				LEFT JOIN boom_users
				ON boom_room_action.action_user = boom_users.user_id
				WHERE action_room = '$r' AND action_blocked > 0
				ORDER BY  boom_users.user_name ASC");
	if($get_blocked->num_rows > 0){
		while($blocked = $get_blocked->fetch_assoc()){
			$blocked['action'] = 'delete_room_blocked';
			$blocked_list .= boomTemplate('element/room_user', $blocked);
		}
	}
	else{
		$blocked_list .= emptyZone($lang['no_data']);
	}
	return '<div class="staff_list">' . $blocked_list . '</div>';
}
function getRoomAdmin($r){
	global $mysqli, $lang;
	$admin_list = '';
	$get_admin = $mysqli->query("SELECT boom_room_staff.*, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_id
					FROM boom_room_staff
					LEFT JOIN boom_users
					ON boom_room_staff.room_staff = boom_users.user_id
					WHERE room_id = '$r' AND room_rank = 5
					ORDER BY  boom_users.user_name ASC");
	if($get_admin->num_rows > 0){
		while($admin = $get_admin->fetch_assoc()){
			$admin['action'] = 'delete_room_admin';
			$admin_list .= boomTemplate('element/room_user', $admin);
		}
	}
	else{
		$admin_list .= emptyZone($lang['no_data']);
	}
	return '<div class="staff_list">' . $admin_list . '</div>';
}
function getRoomMod($r){
	global $mysqli, $lang;
	$mod_list = '';
	$get_mod = $mysqli->query("SELECT boom_room_staff.*, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_id
					FROM boom_room_staff
					LEFT JOIN boom_users
					ON boom_room_staff.room_staff = boom_users.user_id
					WHERE room_id = '$r' AND room_rank = 4
					ORDER BY  boom_users.user_name ASC");
	if($get_mod->num_rows > 0){
		while($mod = $get_mod->fetch_assoc()){
			$mod['action'] = 'delete_room_moderator';
			$mod_list .= boomTemplate('element/room_user', $mod);
		}
	}
	else{
		$mod_list .= emptyZone($lang['no_data']);
	}
	return '<div class="staff_list">' . $mod_list . '</div>';
}
function sendEmail($type, $to, $item = ''){
	global $data;
	require __DIR__ . '/mailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	if(empty($type) || empty($to)){ 
		return 0;
	}
	require __DIR__ . '/language/' . $to['user_language'] . '/mail.php';
	$email['signature'] = nl2br(str_replace('%site%', $data['title'], $bmail['signature']));
	$email['content'] = nl2br(str_replace(array('%user%', '%data%', '%link%'), array($to['user_name'], $item, '<a target="_BLANK" href="' . $item . '">' . $item . '</a>'), $bmail[$type . '_content']));
	$template = boomTemplate('element/mail_template', $email);

	if($data['mail_type'] == 'smtp'){
		$mail->isSMTP();
		$mail->Host = $data['smtp_host'];
		$mail->SMTPAuth = true;
		$mail->Username = $data['smtp_username'];
		$mail->Password = $data['smtp_password'];
		$mail->SMTPSecure = $data['smtp_type'];
		$mail->Port = $data['smtp_port'];	
	}
	else {
		$mail->IsMail();
	}
	$mail->setFrom($data['site_email'], $data['email_from']);
	$mail->addAddress($to['user_email']);
	$mail->isHTML(true);
	$mail->CharSet = 'utf-8';
	$mail->Subject = $bmail[$type . '_title'];
	$mail->MsgHTML($template);
	if(!$mail->send()) {
	   return 0;
	} 
	else {
		return 1;
	}
}
function resetUserPass($user){
	global $mysqli;
	$temp_pass = tempPass();
	$temp_encrypt = encrypt($temp_pass);
	$test_reset = sendEmail('recovery', $user, $temp_pass);
	if($test_reset == 1){
		$mysqli->query("UPDATE boom_users SET temp_pass = '$temp_encrypt', temp_date = '" . time() . "' WHERE user_id = '{$user['user_id']}'");
	}
	return $test_reset;
}
function sendActivation($user){
	global $mysqli, $data;
	$key = $data['valid_key'];
	if(!is_numeric($data['valid_key']) || $data['valid_key'] == ''){
		$key = genCode();
	}
	$send_mail = sendEmail('resend_activation', $user, $key);
	if($send_mail == 1){
		$mysqli->query("UPDATE boom_users SET valid_key = '$key', email_count = email_count + 1 WHERE user_id = '{$user['user_id']}'");
	}
	return $send_mail;
}
function okVerify(){
	global $data;
	if($data['email_count'] <= 2){
		return true;
	}
}
function checkCode($code){
	global $data, $mysqli;
	if($code == $data['valid_key'] && $data['valid_key'] != ''){
		$mysqli->query("UPDATE boom_users SET verified = '1', user_verify = '0', valid_key = '', email_count = '0' WHERE user_id = '{$data['user_id']}'");
		return 1;
	}
	else {
		return 0;
	}
}
function getCritera($c){
	switch($c){
		case 1:
			return "user_rank = '0' AND user_bot = 0";
		case 2:
			return "user_rank = '1' AND user_bot = 0";
		case 3:
			return "user_rank = '2' AND user_bot = 0";
		case 4:
			return "user_rank = '8' AND user_bot = 0";
		case 5:
			return "user_rank = '9' AND user_bot = 0";
		case 6:
			return "user_bot > 0";
		case 7:
			return "user_mute > 0";
		case 8:
			return "user_banned > 0";
		default:
			return "user_rank < 0";
	}	
}
function cleanSearch($search){
	return str_replace('%', '|', $search);
}
function nameDetails($name){
	global $mysqli, $data;
	$user = array();
	$getuser = $mysqli->query("SELECT * FROM boom_users WHERE user_name = '$name'");
	if($getuser->num_rows > 0){
		$user = $getuser->fetch_assoc();
	}
	return $user;
}
function resetColors($id){
	global $mysqli;
	$mysqli->query("UPDATE boom_users SET bccolor = '', bcbold = '' WHERE user_id = '$id'");
}
function boomUsername($name){
	global $mysqli, $boom_config;
	$user = nameDetails($name);
	if(empty($user)){
		return true;
	}
	else {
		if(isGuest($user['user_rank']) && $user['last_action'] < calMinutes($boom_config['guest_delay'])){
			softGuestDelete($user);
			return true;
		}
	}
}
function boomSameName($name, $compare){
	$name1 = mb_strtolower($name);
	$name2 = mb_strtolower($compare);
	if($name1 == $name2){
		return true;
	}
}
function checkFlood(){
	global $boom_config;
	if(boomAllow(8)){
		return false;
	}
	if(isset($_SESSION[$boom_config['prefix'] . 'last'], $_SESSION[$boom_config['prefix'] . 'flood'])){
		if($_SESSION[$boom_config['prefix'] . 'last'] >= time() - 2){
			$_SESSION[$boom_config['prefix'] . 'last'] = time();
			$_SESSION[$boom_config['prefix'] . 'flood'] = $_SESSION[$boom_config['prefix'] . 'flood'] + 1;
			if($_SESSION[$boom_config['prefix'] . 'flood'] >= $boom_config['flood_limit']){
				updateMute();
				return true;
			}
			else {
				return false;
			}
		}
		else {
			$_SESSION[$boom_config['prefix'] . 'last'] = time();
			$_SESSION[$boom_config['prefix'] . 'flood'] = 0;
			return false;
		}
	}
	else {
		$_SESSION[$boom_config['prefix'] . 'last'] = time();
		$_SESSION[$boom_config['prefix'] . 'flood'] = 0;
		return false;
	}
}
function alterLogin(){
	global $data;
	if($data['social_login'] == 1){
		return true;
	}
}
function registration(){
	global $data;
	if($data['registration'] == 1){
		return true;
	}
}
function updateMute(){
	global $data, $mysqli, $boom_config;
	systemMute($data);
	clearMuteNotify($data['user_id']);
	systemNotify($data['user_id'], 'flood_abuse', '');
	$_SESSION[$boom_config['prefix'] . 'last'] = time();
	$_SESSION[$boom_config['prefix'] . 'flood'] = 0;
}
function roomSelect($r){
	global $mysqli;
	$menu = '';
	$get_rooms = $mysqli->query("SELECT * FROM boom_rooms WHERE room_id > 0");
	while($room = $get_rooms->fetch_assoc()){
		$menu .= '<option value="' . $room['room_id'] . '" ' . selCurrent($r, $room['room_id']) . '>' . $room['room_name'] . '</option>';
	}
	return $menu;
}
function getChatPath(){
	return basename(dirname(__DIR__));
}
function canVerify(){
	global $data;
	if($data['user_rank'] >= $data['allow_verify']){
		return true;
	}
}
function deleteFiles($target) {
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK);
        foreach($files as $file){
            deleteFiles($file);      
        }
        rmdir( $target );
    } 
	elseif(is_file($target)){
        unlink($target);  
    }
}
function getSocialData(){
	global $mysqli;
	$get_social = $mysqli->query("SELECT * FROM boom_social_login WHERE id = 1");
	$social_data = $get_social->fetch_assoc();
	return $social_data;
}
function boomEmbed(){
	if(isset($_GET['embed'])){
		return true;
	}
}
function boomInsertUser($pro){
	global $mysqli, $data, $boom_config;
	$user = array();
	if(!isset($pro['name'], $pro['password'], $pro['email'])){
		return $user;
	}
	$def = array(
		'gender' => 0,
		'age' => 0,
		'ip' => '0.0.0.0',
		'language' => $data['language'],
		'avatar' => 'default_avatar.png',
		'color' => 'user',
		'rank' => 1,
		'verified' => 0,
		'verify' => 0,
		'cookie' => 1,
	);
	$u = array_merge($def, $pro);
	$mysqli->query("INSERT INTO `boom_users` 
	( user_name, user_password, user_ip, user_email, user_rank, user_roomid, user_theme,
	user_join, last_action, user_language, user_timezone, verified, user_verify, user_color,
	user_sex, user_age, user_news, user_tumb )
	VALUES 
	('{$u['name']}', '{$u['password']}', '{$u['ip']}', '{$u['email']}', '{$u['rank']}', '0', 'system',
	'" . time() . "', '" . time() . "', '{$u['language']}', '{$data['timezone']}', '{$u['verified']}', '{$u['verify']}', '{$u['color']}',
	'{$u['gender']}', '{$u['age']}', '" . time() . "', '{$u['avatar']}')");
	
	$user = userDetails($mysqli->insert_id);
	if($u['cookie'] == 1 && !empty($user)){
		setBoomCookie($user['user_id'], $user['user_password']);
		if($data['reg_mute'] > 0){
			$mysqli->query("UPDATE boom_users SET ureg_mute = '" . time() . "' WHERE user_id = '{$user['user_id']}'");
		}
	}
	if($u['verify'] == 1 && !empty($user)){
		$send_mail = sendActivation($user);
	}
	return $user;
}
function textFilter($c){
	global $data;
	if(canDirect()){
		$c = linking($c);
	}
	else {
		$c = linkingReg($c);
	}
	if(boomAllow($data['emo_plus'])){
		$c = emoticon(emoprocess($c));
	}
	else {
		$c = regEmoticon(emoprocess($c));
	}
	return $c;
}
function roomDetails($type = 0){
	global $data, $mysqli;
	$muted = 0;
	$status = 0;
	$get_room = $mysqli->query("SELECT *,
	(SELECT count(id) FROM boom_room_action WHERE action_room = '{$data['user_roomid']}' AND action_user = '{$data['user_id']}' AND action_muted = 1) as is_muted,
	(SELECT room_rank FROM boom_room_staff WHERE room_staff = '{$data['user_id']}' AND room_id = '${data['user_roomid']}') as room_status
	FROM boom_rooms
	WHERE room_id = '{$data['user_roomid']}'");
	if($get_room->num_rows > 0){
		$room = $get_room->fetch_assoc();
		if($type == 1){
			if($room['is_muted'] > 0){
				$muted = 1;
			}
			if(!is_null($room['room_status'])){
				$status = $room['room_status'];
			}
			$mysqli->query("UPDATE boom_users SET room_mute = '$muted', user_role = '$status' WHERE user_id = '{$data['user_id']}'");			
		}
	}
	else {
		$room = array();
	}
	return $room;
}
function roomInfo($id){
	global $data, $mysqli;
	$room = array();
	$get_room = $mysqli->query("SELECT * FROM boom_rooms WHERE room_id = '$id'");
	if($get_room->num_rows > 0){
		$room = $get_room->fetch_assoc();
	}
	return $room;
}
function getRole($room){
	global $data, $mysqli;
	$getrole = $mysqli->query("SELECT * FROM boom_room_staff WHERE room_id = '$room' AND room_staff = '{$data['user_id']}'");
	if($getrole->num_rows > 0){
		$role = $getrole->fetch_assoc();
		return $role['room_rank'];
	}
	else {
		return 0;
	}
}
function emptyZone($text){
	return '<div class="empty_zone"><p>' . $text . '</p></div>';	
}
function tempPass(){
	$temp_pass = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz+0123456789'), 0, 10);
	return $temp_pass;
}
function listGender($sex){
	global $lang;
	$list = '';
	$list .= '<option ' . selCurrent($sex, 1) . ' value="1">' . $lang['male'] . '</option>';
	$list .= '<option ' . selCurrent($sex, 2) . ' value="2">' . $lang['female'] . '</option>';
	return $list;
}
function validGender($sex){
	if($sex > 0 && $sex < 4){
		return true;
	}
}
function useWall(){
	global $data;
	if($data['use_wall'] == 1){
		return true;
	}
}
function validPassword($pass){
	if(strlen($pass) > 3){
		return true;
	}
}
function validRoomName($name){
	global $data;
	if(strlen($name) <= $data['max_room_name'] && strlen($name) >= 4 && preg_match("/^[a-zA-Z0-9 _\-\p{Arabic}\p{Cyrillic}\p{Latin}\p{Han}\p{Katakana}\p{Hiragana}\p{Hebrew}]{4,}$/ui", $name)){
		return true;
	}
}
function areFriend($id){
	global $mysqli, $data;
	$check_friend = $mysqli->query("SELECT * FROM boom_friends WHERE target = '{$data['user_id']}' AND hunter = '$id'");
	if($check_friend->num_rows > 0){
		return true;
	}
}
function clearBreak($text){
	$text = preg_replace("/[\r\n]{2,}/", "\n\n", $text);
	return $text;
}
function removeBreak($text){
	$text = preg_replace( "/(\r|\n)/", " ", $text );
	return $text;
}
function emoItem($type){
	switch($type){
		case 1:
			$emoclass = 'emo_menu_item';
			break;
		case 2:
			$emoclass = 'emo_menu_item_priv';
			break;
	}
	$emo = '';
	$dir = glob('emoticon/*' , GLOB_ONLYDIR);
	foreach($dir as $dirnew){
		$emoitem = str_replace('emoticon/', '', $dirnew);
		$emo .= '<div data="' . $emoitem . '" class="emo_menu ' . $emoclass . '"><img class="emo_select" src="emoticon_icon/' . $emoitem . '.png"/></div>';
	}
	return $emo;
}
function validEmail($email, $type = 0){
	global $data, $mysqli;
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		return false;
	}
	if($data['email_filter'] == 1 && $type == 0){
		$get_end = explode('@', $email);
		$get_domain = explode('.', $get_end[1]);
		$allowed = $get_domain[0];
		$get_email = $mysqli->query("SELECT word FROM boom_filter WHERE word_type = 'email' AND word = '$allowed'");
		if($get_email->num_rows < 1){
			return false;
		}
	}
	return true;
}
function canEditUser($user, $rank){
	global $data;
	if(boomAllow($rank) && isGreater($user['user_rank']) && notMe($user['user_id']) && !isBot($user['user_bot']) || notMe($user['user_id']) && isOwner() && !userOwner($user)){
		return true;
	}
}
function validAge($age){
	global $data;
	if($age >= $data['min_age'] && $age != "" && $age < 100){
		return true;
	}
}
function validCountry($country, $region){
	require __DIR__ . '/location/country_list.php';
	if($country == 'hide' && $region == 'hide'){
		return true;
	}
	else {
		if(in_array($country, $country_list) && array_key_exists($country, $regions_list) && in_array($region, $regions_list[$country])){
			return true;
		}
	}
}
function getLanguage(){
	global $mysqli, $data, $boom_config;
	$l = $data['language'];
	if(boomLogged()){
		if(file_exists(__DIR__ . '/language/' . $data['user_language'] . '/language.php')){
			$l = $data['user_language'];
		}
		else {
			$mysqli->query("UPDATE boom_users SET user_language = '{$data['language']}' WHERE user_id = '{$data['user_id']}'");
		}
	}
	else {
		if(isset($_COOKIE[$boom_config['prefix'] . 'lang'])){
			$lang = boomSanitize($_COOKIE[$boom_config['prefix'] . 'lang']);
			if(file_exists(__DIR__ . '/language/' . $lang . '/language.php')){
				$l = $lang;
			}
		}
	}
	return $l;
}
function isRtl($l){
	$rtl_list = array('Arabic','Persian','Farsi','Aramaic','Azeri','Hebrew','Dhivehi','Maldivian','Kurdish','Sorani','Urdu');
	if(in_array($l, $rtl_list)){
		return true;
	}
}
function getTheme(){
	global $mysqli, $data;
	$t = $data['default_theme'];
	if(boomLogged()){
		if(boomAllow($data['allow_theme']) && $data['user_theme'] != 'system'){
			if(file_exists(__DIR__ . '/../css/themes/' . $data['user_theme'] . '/' . $data['user_theme'] . '.css')){
				$t = $data['user_theme'];
			}
			else {
				$mysqli->query("UPDATE boom_users SET user_theme = 'system' WHERE user_id = '{$data['user_id']}'");
			}
		}
	}
	return $t . '/' . $t . '.css';
}
function emoticon($emoticon){
	$folder = __DIR__ . '/../emoticon';
	if ($dir = opendir($folder)) {
		while (false !== ($file = readdir($dir))){
			if ($file != "." && $file != ".."){
					$select = preg_replace('/\.[^.]*$/', '', $file);
					if(strpos($file, '.png')){
						$emoticon = str_replace(':' . $select . ':', '<img  class="emo_chat" src="emoticon/' . $select . '.png"> ', $emoticon);
					}
					if(strpos($file, '.gif')){
						$emoticon = str_replace(':' . $select . ':', '<img  class="emo_chat" src="emoticon/' . $select . '.gif"> ', $emoticon);
					}
			}
		}
		closedir($dir);
	}
	$list = getEmo();
	foreach ($list as $value) {
		$type = 'emo_chat';
		if(stripos($value, 'sticker') !== false){
			$type = 'sticker_chat';
		}
		if(stripos($value, 'custom') !== false){
			$type = 'custom_chat';
		}
		if ($dir = opendir($folder . '/' . $value)){
			while (false !== ($file = readdir($dir))){
				if ($file != "." && $file != ".."){
					$select = preg_replace('/\.[^.]*$/', '', $file);
					if(strpos($file, '.png')){
						$emoticon = str_replace(':' . $select . ':', '<img  class="' . $type . '" src="emoticon/' . $value . '/' . $select . '.png"> ', $emoticon);
					}
					if(strpos($file, '.gif')){
						$emoticon = str_replace(':' . $select . ':', '<img  class="' . $type . '" src="emoticon/' . $value . '/' . $select . '.gif"> ', $emoticon);
					}
				}
			}
			closedir($dir);
		}
	}
	return $emoticon;
}
function regEmoticon($emoticon){
	global $data;
	$folder = __DIR__ . '/../emoticon';
	if ($dir = opendir($folder)){
		while (false !== ($file = readdir($dir))){
			if ($file != "." && $file != ".."){
				$select = preg_replace('/\.[^.]*$/', '', $file);
				if(strpos($file, '.png')){
					$emoticon = str_replace(':' . $select . ':', '<img  class="emo_chat" src="emoticon/' . $select . '.png"> ', $emoticon);
				}
				if(strpos($file, '.gif')){
					$emoticon = str_replace(':' . $select . ':', '<img  class="emo_chat" src="emoticon/' . $select . '.gif"> ', $emoticon);
				}
			}
		}
		closedir($dir);
	}
	return $emoticon;
}
function getEmo(){
	$emo = array();
	$dir = glob(__DIR__ . '/../emoticon/*' , GLOB_ONLYDIR);
	foreach($dir as $dirnew){
		array_push($emo, str_replace(__DIR__ . '/../emoticon/', '', $dirnew));
	}
	return $emo;
}
function boomFileVersion(){
	global $data;
	if($data['bbfv'] > 1.0){
		return '?v=' . $data['bbfv'];
	}
	return '';
}
function boomPostIt($content, $type = 1) {
	$content = systemReplace($content);
	if(!badWord($content)){
		$source = $content;
		$regex = '\w/_\.\%\+#\-\?:\=\&\;\(\)';
		if(normalise($content, 2)){
			$content = str_replace('youtu.be/','youtube.com/watch?v=',$content);
			$content = preg_replace('@https?:\/\/([-\w\.]+[-\w])+(:\d+)?\/[' . $regex . ']+\.(png|gif|jpg|jpeg)((\?\S+)?[^\.\s])?@i', '<div class="post_image"> <a href="$0" class="fancybox"><img src="$0"/></a> </div>', $content);
			$content = preg_replace('@https?:\/\/(www\.)?youtube.com/watch\?v=([\w_-]*)([' . $regex . ']*)?@ui', '<div class="video_container"><iframe src="https://www.youtube.com/embed/$2" frameborder="0" allowfullscreen></iframe></div>', $content);
			if(preg_last_error()) {
				$content = $source;
			}
			$content = preg_replace('@([^=][^"])(https?://([-\w\.]+[-\w])+(:\d+)?(/([' . $regex . ']*(\?\S+)?[^\.\s])?)?)@ui', '$1<a href="$2" target="_blank">$2</a>', $content);
			$content = preg_replace('@^(https?://([-\w\.]+[-\w])+(:\d+)?(/([' . $regex . ']*(\?\S+)?[^\.\s])?)?)@ui', '<a href="$1" target="_blank">$1</a>', $content);
		}
	}
	if($type == 1){
		return nl2br($content);
	}
	else {
		return $content;
	}
}
function linking($content) {
	if(!badWord($content)){
		$source = $content;
		$regex = '\w/_\.\%\+#\-\?:\=\&\;\(\)';
		if(normalise($content, 1)){
			$content = str_replace('youtu.be/','youtube.com/watch?v=',$content);
			$content = preg_replace('@https?:\/\/(www\.)?youtube.com/watch\?v=([\w_-]*)([' . $regex . ']*)?@ui', '<div class="chat_video_container"><div class="chat_video"><iframe src="https://www.youtube.com/embed/$2" frameborder="0" allowfullscreen></iframe></div><div data="https://www.youtube.com/embed/$2" value="youtube" class="boom_youtube open_player hide_mobile"><i class="fa fa-external-link-square"></i></div></div>', $content);
			//$content = preg_replace('@https?:\/\/(www\.)?soundcloud.com/([\w_\/\?\=-]{1,})@ui', '<div class="chat_soundcloud"><iframe src="https://w.soundcloud.com/player/?url=//soundcloud.com/$2" frameborder="0" allowfullscreen></iframe></div>', $content);
			$content = preg_replace('@https?:\/\/([-\w\.]+[-\w])+(:\d+)?\/[' . $regex . ']+\.(png|gif|jpg|jpeg)((\?\S+)?[^\.\s])?@ui', ' <a href="$0" class="fancybox"><img class="chat_image"src="$0"/></a> ', $content);
			if(preg_last_error()) {
				$content = $source;
			}
			$content = preg_replace('@([^=][^"])(https?://([-\w\.]+[-\w])+(:\d+)?(/([' . $regex . ']*(\?\S+)?[^\.\s])?)?)@ui', '$1<a href="$2" target="_blank">$2</a>', $content);
			$content = preg_replace('@^(https?://([-\w\.]+[-\w])+(:\d+)?(/([' . $regex . ']*(\?\S+)?[^\.\s])?)?)@ui', '<a href="$1" target="_blank">$1</a>', $content);
		}
	}
	return $content;
}
function linkingReg($content){
	if(!badWord($content)){
		$regex = '\w/_\.\%\+#\-\?:\=\&\;\(\)';
		if(normalise($content, 1)){
			$content = preg_replace('@([^=][^"])(https?://([-\w\.]+[-\w])+(:\d+)?(/([' . $regex . ']*(\?\S+)?[^\.\s])?)?)@ui', '$1<a href="$2" target="_blank">$2</a>', $content);
			$content = preg_replace('@^(https?://([-\w\.]+[-\w])+(:\d+)?(/([' . $regex . ']*(\?\S+)?[^\.\s])?)?)@ui', '<a href="$1" target="_blank">$1</a>', $content);;
		}
	}
	return $content;
}
function customChatImg($source, $tumb = ''){
	if(empty($tumb)){
		$tumb = $source;
	}
	return '<a href="' . $source . '" class="fancybox"><img class="chat_image"src="' . $tumb . '"/></a>';
}
function fileProcess($f, $r){
	$file = array(
		'file'=> $f,
		'title'=> $r
	);
	return boomTemplate('element/file', $file);
}
function musicProcess($f, $r){
	$file = array(
		'file'=> $f,
		'title'=> $r
	);
	return boomTemplate('element/audio', $file);
}
function cleanBoomName($name){
	return str_replace(array(' ', "'", '"', '<', '>', ","), array('_', '', '', '', '', ''), $name);
}
function filterOrigin($origin){
	if(strlen($origin) > 55){
		$origin = mb_substr($origin, 0, 55);
	}
	return str_replace(array(' ', '.', '-'), '_', $origin);
}
function badWord($content){
	$regex = '\w/_\.\%\+#\-\?:\=\&\;\(\)';
	if(preg_match('@https?:\/\/(www\.)?([' . $regex . ']*)?([\*]{4}){1,}([' . $regex . ']*)?@ui', $content)){
		return true;
	}
}
function clearUserData($u){
	global $mysqli;
	if(empty($u)){
		return false;
	}
	$id = $u['user_id'];
	$av = $u['user_tumb'];
	$mysqli->query("DELETE FROM boom_chat WHERE user_id = '$id'");
	$mysqli->query("DELETE FROM boom_room_action WHERE action_user = '$id'");
	$mysqli->query("DELETE FROM boom_private WHERE target = '$id' OR hunter = '$id'");
	$mysqli->query("DELETE FROM boom_post WHERE post_user = '$id'");
	$mysqli->query("DELETE FROM boom_post_reply WHERE reply_user = '$id' OR reply_uid = '$id'");
	$mysqli->query("DELETE FROM boom_post_like WHERE uid = '$id' OR liked_uid = '$id'");
	$mysqli->query("DELETE FROM boom_room_staff WHERE room_staff = '$id'");
	$mysqli->query("DELETE FROM boom_friends WHERE hunter = '$id' OR target = '$id'");
	$mysqli->query("DELETE FROM boom_notification WHERE notifier = '$id' OR notified = '$id'");
	$mysqli->query("DELETE FROM boom_users WHERE user_id = '$id'");
	$mysqli->query("DELETE FROM boom_report WHERE report_user = '$id'");
	$mysqli->query("DELETE FROM boom_ignore WHERE ignorer  = '$id' OR ignored = '$id'");
	$del_av = unlinkAvatar($av);
}
function cleanList($type, $rank = 0){
	global $mysqli, $data;
	$user = array();
	$av = array();
	$find_query = cleanListQuery($type);
	if(empty($find_query) || !boomAllow($rank) || $find_query == ''){
		return false;
	}
	$find_list = $mysqli->query("SELECT user_id, user_tumb FROM boom_users WHERE $find_query");
	if($find_list->num_rows > 0){
		while($user_list = $find_list->fetch_assoc()){
			array_push($user, $user_list['user_id']);
			array_push($av, $user_list['user_tumb']);
		}
		if(!empty($user)){
			$list = implode(", ", $user);
			$mysqli->query("DELETE FROM boom_chat WHERE user_id IN ($list)");
			$mysqli->query("DELETE FROM boom_users WHERE user_id IN ($list) AND $find_query");
			$mysqli->query("DELETE FROM boom_private WHERE hunter  IN ($list) OR target  IN ($list)");
			$mysqli->query("DELETE FROM boom_room_action WHERE action_user  IN ($list)");
			$mysqli->query("DELETE FROM boom_room_staff WHERE room_staff IN ($list)");
			$mysqli->query("DELETE FROM boom_ignore WHERE ignorer  IN ($list) OR ignored  IN ($list)");
			$mysqli->query("DELETE FROM boom_report WHERE report_user IN ($list)");
			$mysqli->query("DELETE FROM boom_notification WHERE notifier IN ($list) OR notified IN ($list)");
			$mysqli->query("DELETE FROM boom_post WHERE post_user IN ($list)");
			$mysqli->query("DELETE FROM boom_post_reply WHERE reply_user IN ($list) OR reply_uid IN ($list)");
			$mysqli->query("DELETE FROM boom_post_like WHERE uid IN ($list) OR liked_uid IN ($list)");
			$mysqli->query("DELETE FROM boom_room_staff WHERE room_staff IN ($list)");
			$mysqli->query("DELETE FROM boom_friends WHERE hunter IN ($list) OR target IN ($list)");
		}
		if(!empty($av)){
			foreach($av as $del_av){
				unlinkAvatar($del_av);
			}
		}
	}	
}
function cleanListQuery($type){
	global $data;
	$chat_delay = calDay($data['chat_delete']);
	switch($type){
		case 'guest':
			return "user_rank = '0'";
		case 'innactive_guest':
			return "user_rank = '0' AND last_action <= '$chat_delay'";
		case 'system_bot':
			return "user_bot = '9'";
		default:
			return "";
	}
}
function softGuestDelete($u){
	global $mysqli, $boom_config, $data;
	$id = $u['user_id'];
	if(!isGuest($u['user_rank'])){
		return false;
	}
	$new_pass = randomPass();
	$new_name = '@' . $u['user_name'] . '-' . $id;
	$mysqli->query("DELETE FROM boom_room_action WHERE action_user = '$id'");
	$mysqli->query("DELETE FROM boom_private WHERE target = '$id' OR hunter = '$id'");
	$mysqli->query("DELETE FROM boom_room_staff WHERE room_staff = '$id'");
	$mysqli->query("DELETE FROM boom_friends WHERE hunter = '$id' OR target = '$id'");
	$mysqli->query("DELETE FROM boom_notification WHERE notifier = '$id' OR notified = '$id'");
	$mysqli->query("UPDATE boom_users SET user_name = '$new_name', user_password = '$new_pass' WHERE user_id = '$id'");
}
function clearRoom($id){
	global $data, $mysqli, $lang;
	$clearmessage = str_ireplace('%user%', $data['user_name'], $lang['room_clear']) . '<span class="b_o_o_m"></span>';
	$mysqli->query("DELETE FROM `boom_chat` WHERE `post_roomid` = '$id' ");
	systemSay($data['user_roomid'], $clearmessage);
	$mysqli->query("UPDATE boom_users SET caction = caction + 1 WHERE user_roomid = '$id'");
	$mysqli->query("DELETE FROM boom_report WHERE report_room = '$id'");
	return true;
}
function changeTopic($topic, $id){
	global $mysqli;
	$topic = preg_replace('/(^|[^"])(((f|ht){1}tp:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="\\2" target="_blank">\\2</a>', $topic);
	$mysqli->query("UPDATE `boom_rooms` SET `topic` = '$topic' WHERE `room_id` = '$id'");
	$mysqli->query("UPDATE boom_users SET taction = taction + 1 WHERE user_roomid = '$id'");
	return true;
}
function userSeen($name){
	global $lang, $data, $mysqli;
	$seen = array();
	$user = nameDetails($name);
	if(!empty($user)){
		$seen = roomInfo($user['user_roomid']);
	}
	if(empty($user) || $user['user_status'] == 6 || isBot($user['user_bot'])){
		return str_replace('%userseen%', '<b>' . $name . '</b>', $lang['not_seen']);
	}
	if($user['user_roomid'] == 0 || empty($seen)){
		return str_replace(array('%userseen%', '%seentime%'), array('<b>' . $user['user_name'] . '</b>', '<b>' . displayDate($user['last_action']) . '</b>'), $lang['seen_lobby']);
	}
	return str_replace(array('%userseen%', '%seentime%', '%seenroom%'), array('<b>' . $user['user_name'] . '</b>', '<b>' . displayDate($user['last_action']) . '</b>', '<b>' . $seen['room_name'] . '</b>'), $lang['seen']);
}
function muteCleanup(){
	global $mysqli, $data;
	$unmute = calMinutes($data['word_delay']);
	$mysqli->query("UPDATE boom_users SET user_word_mute = 0 WHERE user_word_mute < '$unmute'");
}
function boomAds($link, $img, $type){
	global $data;
	return '<a target="_blank" href="' . $link . '"><img class="' . $type . '" border="0" src="' . $data['domain'] . '/money/' . $img . '"></a>';	
}
function getRoomList($type){
	global $mysqli, $data, $lang;
	$check_action = getDelay();
	$rooms = $mysqli->query(" SELECT *, 
	( SELECT Count(boom_users.user_id) FROM boom_users  Where boom_users.user_roomid = boom_rooms.room_id AND last_action > '$check_action' AND user_status != 6 ) as room_count
	FROM  boom_rooms 
	ORDER BY room_count DESC");
	$sroom = 0;
	$room_list = '';
	while ($room = $rooms->fetch_assoc()){
		$ask = 0;
		$room['room_protected'] = '';
		$room['room_ask'] = '';
		$room['room_current'] = '';
		$room['myr'] = '';
		if($room['password'] != ''){
			$room['room_protected'] = '<i class="fa fa-lock r_lock"></i> ';
			$ask = 1;
		}
		if($room['description'] == ''){
			$room['room_description'] = $lang['room_no_description'];
		}
		else {
			$room['room_description'] = $room['description'];
		}
		if($room['room_id'] == $data['user_roomid']){
			$room['room_current'] = 'noview';
		}
		if($data['user_id'] == $room['room_creator']){
			$room['myr'] = 'owner ';
		}
		$room['room_ask'] = 'onclick="switchRoom(' . $room['room_id']  . ', ' . $ask . ', ' . $room['access'] . ', \'' . $room['room_name'] . '\');"';
		switch($type){
			case 'list':
				$room_list .= boomTemplate('element/room_item', $room);
				break;
			case 'box':
				$room_list .= boomTemplate('element/room_box', $room);
				break;
		}
	}
	return $room_list;
}
function loadAddonsJs($type = 'chat'){
	global $mysqli, $data, $lang;
	$load_addons = $mysqli->query("SELECT * FROM boom_addons");
	while ($addons = $load_addons->fetch_assoc()){
		include __DIR__ . '/../addons/' . $addons['addons'] . '/files/' . $addons['addons'] . '.php';
	}
}
function getAddons(){
	global $mysqli;
	$load_addons = $mysqli->query("SELECT * FROM boom_addons");
	return $load_addons;
}
function canModifyAvatar($user){
	global $data;
	if(empty($user)){
		return false;
	}
	if(isOwner() && !userOwner($user)){
		return true;
	}
	if(!boomAllow(9)){
		return false;
	}
	if(isBot($user['user_bot']) && !boomAllow(10)){
		return false;
	}
	if(!boomAllow($data['allow_avatar'])){
		return false;
	}
	if(!notMe($user['user_id'])){
		return true;
	}
	if(isGreater($user['user_rank'])){
		return true;
	}
	return false;
}
function getPageData($page_data = array()){
	global $data;
	$page_default = array(
		'page'=> '',
		'page_load'=> '',
		'page_menu'=> 0,
		'page_embed'=> 0,
		'page_rank'=> 0,
		'page_room'=> 1,
		'page_out'=> 0,
		'page_keyword'=> $data['site_keyword'],
		'page_description'=> $data['site_description'],
		'page_rtl'=> 1,
		'page_nohome'=> 0,
	);
	$page = array_merge($page_default, $page_data);
	return $page;
}
function lastRecordedId(){
	global $mysqli;
	$getid = $mysqli->query("SELECT MAX(user_id) AS last_id FROM boom_users");
	$id = $getid->fetch_assoc();
	return $id['last_id'] + 1;
}
function listThisArray($a){
	return implode(", ", $a);
}
function sameAccount($u){
	global $mysqli, $lang;
	$getsame = $mysqli->query("SELECT user_name FROM boom_users WHERE user_ip = '{$u['user_ip']}' AND user_id != '{$u['user_id']}' AND user_bot = 0 ORDER BY user_id DESC LIMIT 50");
	$same = array();
	if($getsame->num_rows > 0){
		while($usame = $getsame->fetch_assoc()){
			array_push($same, $usame['user_name']);
		}
	}
	else {
		array_push($same, $lang['none']);
	}
	return listThisArray($same);
}
function createIgnore(){
	global $mysqli, $data, $boom_config;
	$ignore_list = '';
	$get_ignore = $mysqli->query("SELECT ignored FROM boom_ignore WHERE ignorer = '{$data['user_id']}'");
	while($ignore = $get_ignore->fetch_assoc()){
		$ignore_list .= 'u' . $ignore['ignored'] . 'x';
	}
	$_SESSION[$boom_config['prefix'] . 'ignore'] = $ignore_list;
}
function getRoomId(){
	global $mysqli, $data;
	if(boomLogged()){
		if($data['user_roomid'] == 0){
			if(!useLobby()){
				$mysqli->query("UPDATE boom_users SET user_roomid = '1' WHERE user_id = '{$data['user_id']}'");
				return 1;
			}
		}
		else {
			return $data['user_roomid'];
		}
	}
	return 0;
}
function boomCookieLaw(){
	global $data, $boom_config;
	if(!isset($_COOKIE[$boom_config['prefix'] . "claw"]) && $data['cookie_law'] == 1){
		return true;
	}
}
function getActionList($type){
	global $data, $mysqli, $lang;
	$action_list = '';
	$action_info = getActionCritera($type);
	$getaction = $mysqli->query("SELECT * FROM boom_users WHERE $action_info ORDER BY last_action DESC");
	if($getaction->num_rows > 0){
		while($action = $getaction->fetch_assoc()){
			$action['type'] = $type;
			$action_list .= boomTemplate('element/admin_action_user', $action);
		}
	}
	else {
		$action_list .= emptyZone($lang['empty']);
	}
	return $action_list;
}
function getActionCritera($c){
	switch($c){
		case 'muted':
			return "user_mute > 0";
		case 'banned':
			return "user_banned > 0";
		default:
			return "user_rank > 1000";
	}	
}
function loadPageData($page){
	global $mysqli;
	$page_data = '';
	$get_page = $mysqli->query("SELECT * FROM boom_page WHERE page_name = '$page' LIMIT 1");
	if($get_page->num_rows > 0){
		$pdata = $get_page->fetch_assoc();
		$page_data = $pdata['page_content'];
	}
	return $page_data;
}
function boomFooterMenu(){
	global $data, $lang;
	include __DIR__ . '/../control/footer_menu.php';
}
function userFullDetails($id){
	global $mysqli, $data;
	$user = array();
	$getuser = $mysqli->query("SELECT *,
	(SELECT status FROM boom_friends WHERE hunter = '{$data['user_id']}' AND target = '$id') as are_friend,
	(SELECT count(ignore_id) FROM boom_ignore WHERE ignorer = '{$data['user_id']}' AND ignored = '$id' OR ignorer = '$id' AND ignored = '{$data['user_id']}' ) as ignored
	FROM boom_users WHERE `user_id` = '$id'");
	if($getuser->num_rows > 0){
		$user = $getuser->fetch_assoc();
	}
	return $user;
}
function boomAddFriend($id){
	global $mysqli, $data;
	$user = userFullDetails($id);
	if(empty($user)){
		return 3;
	}
	if($user['ignored'] > 0 || isBot($user['user_bot']) || !notMe($user['user_id'])){
		return 0;
	}
	if($user['are_friend'] == 1){
		$mysqli->query("UPDATE boom_friends SET status = 3 WHERE hunter = '{$data['user_id']}' AND target = '$id' OR hunter = '$id' AND target = '{$data['user_id']}'");
		regNotify($id, 'accept_friend');
		return 1;
	}
	if($user['are_friend'] == 3 || $user['are_friend'] == 2){
		return 4;
	}
	if(is_null($user['are_friend'])){
		$mysqli->query("INSERT INTO boom_friends (hunter, target, status) VALUES ('{$data['user_id']}', '$id', '2'), ('$id', '{$data['user_id']}', '1')");
		updateNotify($id);
		return 2;
	}
}
function boomRemoveFriend($id){
	global $mysqli, $data;
	$list = array();
	$mysqli->query("DELETE FROM boom_friends WHERE hunter = '{$data['user_id']}' AND target = '$id' OR hunter = '$id' AND target = '{$data['user_id']}'");
	$mysqli->query("DELETE FROM boom_notification WHERE notifier = '$id' AND notified = '{$data['user_id']}' OR notifier = '{$data['user_id']}' AND notified = '$id'");
	updateDualNotify($id, $data['user_id']);
	return 1;
}
function boomUserInfo($id){
	global $mysqli, $data;
	$user = array();
	$getuser = $mysqli->query("SELECT user_id, user_name, user_rank, user_bot, user_private,
	(SELECT count(id) FROM boom_friends WHERE hunter = '{$data['user_id']}' AND target = '$id' AND status = 3) as are_friend,
	(SELECT count(ignore_id) FROM boom_ignore WHERE ignorer = '{$data['user_id']}' AND ignored = '$id' OR ignorer = '$id' AND ignored = '{$data['user_id']}' ) as ignored
	FROM boom_users WHERE `user_id` = '$id'");
	if($getuser->num_rows > 0){
		$user = $getuser->fetch_assoc();
	}
	return $user;
}
function boomIgnored($hunter, $target){
	global $mysqli;
	$get_ignore = $mysqli->query("SELECT * FROM boom_ignore WHERE ignorer = '$hunter' AND ignored = '$target' OR ignorer = '$target' AND ignored = '$hunter'");
	if($get_ignore->num_rows > 0){
		return true;
	}
}
function canSendPrivate($id){
	global $mysqli, $data;
	$user = boomUserInfo($id);
	if(empty($user)){
		return false;
	}
	if(isStaff($data['user_rank'])){
		return true;
	}
	if(!isStaff($user['user_rank'])){
		if($user['user_private'] == 0){
			return false;
		}
		if($user['user_private'] == 2 && $user['are_friend'] != 1){
			return false;
		}
	}
	if($user['ignored'] > 0){
		return false;
	}
	return true;
}
function checkRecaptcha(){
	global $data;
	if(!boomRecaptcha()){
		return true;
	}
	if(!isset($_POST['recaptcha'])){
		return false;
	}
	$recapt = escape($_POST['recaptcha']);
	if(empty($recapt)){
		return false;
	}
	$response = doCurl('https://www.google.com/recaptcha/api/siteverify?secret=' . $data['recapt_secret'] . '&response=' . $recapt);
	$recheck = json_decode($response);
	if($recheck->success == true){
		return true;
	}
}
?>