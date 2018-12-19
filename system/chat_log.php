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
require_once('config_chat.php');

$chat_history = 30;
$private_history = 18;
$status_delay = $data['last_action'] + 21;
$out_delay = time() - 1800;

// check for information sent by user
if( isset($_POST['last'], $_POST['snum'], $_POST['caction'], $_POST['taction'], $_POST['fload'], $_POST['preload'], $_POST['priv'], $_POST['lastp'], $_POST['pcount'], $_POST['room'], $_POST['notify'])){
	
	// clearing post data 
	
	$last = escape($_POST['last']);
	$fload = escape($_POST['fload']);
	$snum = escape($_POST['snum']);
	$caction = escape($_POST['caction']);
	$taction = escape($_POST['taction']);
	$preload = escape($_POST['preload']);
	$priv = escape($_POST['priv']);
	$lastp = escape($_POST['lastp']);
	$pcount = escape($_POST['pcount']);
	$room = escape($_POST['room']);
	$notify = escape($_POST['notify']);
	
	if($room != $data['user_roomid']){
		echo json_encode( array("check" => 99));
		die();
	}
	
	// main chat part
	
	$clogs = '';
	$plogs = '';
	$last_log = $last;
	$last_private = $lastp;
	$main = 1;
	$private = 1;
	$topic = '';
	$report = 0;
	$setting_room = 0;
	$news_count = 0;
	$report = 0;
	$notify_count = 0;
	$friend_count = 0;
	$use = 0;
	$muted = $data['room_mute'];
	
	if( time() > $status_delay || $fload == 0 ){
		$ip = getIp();
		if($fload == 0 && $data['join_msg'] == 0 || $data['last_action'] < $out_delay){
			joinRoom();
		}
		$mysqli->query("UPDATE boom_users SET join_msg = '1', last_action = '" . time() . "', user_ip = '$ip' WHERE user_id = '{$data['user_id']}'");
	}
	if($notify < $data['naction']){
		$use = 1;
		$get_notify = $mysqli->query("SELECT
		( SELECT count(*) FROM boom_friends WHERE target = '{$data['user_id']}' AND status = '2' AND viewed = '0') as friend_count,
		( SELECT count(*) FROM boom_notification WHERE notified = '{$data['user_id']}' AND notify_view = '0') as notify_count,
		( SELECT count(*) FROM boom_report ) as report_count,
		( SELECT count(*) FROM boom_news WHERE news_date > '{$data['user_news']}' ) as news_count
		");
		if($get_notify->num_rows == 1){
			$fetch = $get_notify->fetch_assoc();
			$friend_count = $fetch['friend_count'];
			$notify_count = $fetch['notify_count'];
			$news_count = $fetch['news_count'];
			if(boomAllow(8)){
				$report = $fetch['report_count'];
			}
		}
	}
	
	if($fload == 0){
		$log = $mysqli->query("SELECT log.*, boom_users.user_name, boom_users.user_color, boom_users.user_rank, boom_users.bccolor, boom_users.user_sex, boom_users.user_tumb, boom_users.user_bot
		FROM ( SELECT * FROM `boom_chat` WHERE `post_roomid` = '{$data['user_roomid']}' AND post_id > '$last' ORDER BY `post_id` DESC LIMIT $chat_history) AS log
		LEFT JOIN boom_users ON log.user_id = boom_users.user_id
		ORDER BY `post_id` ASC");
	}
	else {
		if($caction != $data['caction']){
			$log = $mysqli->query("SELECT log.*, boom_users.user_name, boom_users.user_color, boom_users.user_rank, boom_users.bccolor, boom_users.user_sex, boom_users.user_tumb, boom_users.user_bot
			FROM ( SELECT * FROM `boom_chat` WHERE `post_roomid` = '{$data['user_roomid']}' AND post_id > '$last' AND snum != '$snum' ORDER BY `post_id` DESC LIMIT $chat_history) AS log
			LEFT JOIN boom_users ON log.user_id = boom_users.user_id
			ORDER BY `post_id` ASC");
		}
		else {
			$clogs = 99;
			$main = 0;
		}
	}
	if($main == 1){
		if($log->num_rows > 0){
			while ($chat = $log->fetch_assoc()){
				$last_log = $chat['post_id'];
				$clogs .= createLog($data, $chat);
			}
			if(empty($clogs)){
				$clogs = 99;
			}
		}
		else {
			$clogs = 99;
		}
	}
	$delthis = array();
	$todelete = explode(",", $data['post_delete']);
	foreach($todelete as $delpost) {
		$delpost = trim($delpost);
		array_push($delthis, $delpost);
	}
	
	// private part
	
	if($preload == 1){
		$privlog = $mysqli->query("SELECT log.*, boom_users.user_id, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_bot 
		FROM ( SELECT * FROM `boom_private` WHERE  `hunter` = '{$data['user_id']}' AND `target` = '$priv'  OR `hunter` = '$priv' AND `target` = '{$data['user_id']}' ORDER BY `id` DESC LIMIT $private_history) AS log 
		LEFT JOIN boom_users
		ON log.hunter = boom_users.user_id
		ORDER BY `time` ASC");
	}
	else {
		if($pcount != $data['pcount'] && $priv != 0){
			$privlog = $mysqli->query("SELECT log.*, boom_users.user_id, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_bot
			FROM ( SELECT * FROM `boom_private` WHERE  `hunter` = '$priv' AND `target` = '{$data['user_id']}' AND id > '$lastp' OR hunter = '{$data['user_id']}' AND target = '$priv' AND id > '$lastp' AND file = 1 ORDER BY `id` DESC LIMIT $private_history) AS log 
			LEFT JOIN boom_users
			ON log.hunter = boom_users.user_id
			ORDER BY `time` ASC");
		}
		else {
			$plogs = 99;
			$private = 0;
		}
	}
	if($private == 1){
		if ($privlog->num_rows > 0){
			$mysqli->query("UPDATE `boom_private` SET `status` = 1 WHERE `hunter` = '$priv' AND `target` = '{$data['user_id']}'");
			while ($private = $privlog->fetch_assoc()){
				if($private['hunter'] == $data['user_id']){
					$plogs .= privateLog($private, 1);
				}
				else {
					$plogs .= privateLog($private, 2);
				}
				$last_private = $private['id'];
			}
		}
		else {
			$plogs = 99;
		}
	}
	if($taction != $data['taction'] || $fload == 0){
		$get_topic = processUserData(getTopic());
		if($get_topic != ''){
			$topic = systemSpecial($get_topic, 'welcome_log');
		}
		$taction = $data['taction'];
	}
	
	if(boomRole(5) || boomAllow(9)){
		$setting_room = 1;
	}
	
	if($data['user_word_mute'] > 0){
		wordUnmute($data);
	}
	if($data['ureg_mute'] > 0){
		regUnmute($data);
	}
	
	mysqli_close($mysqli);
	
	if(muted()){
		$muted = 2;
	}

	// sending results
	
	echo json_encode( array(
	"main_logs" => $clogs,
	"main_last"=> $last_log,
	"nnotif"=> $data['naction'],
	"cact"=> $data['caction'],
	"user_sound" => $data['user_sound'],
	"ses_compare" => $data['session_id'],
	"del"=> $delthis,
	"urank"=> $data['user_rank'],
	"check"=> 0,
	"action"=> $data['user_action'],
	"priv_logs"=> $plogs,
	"priv_last"=> $last_private,
	"pcount"=> $data['pcount'],
	"icon_private" => $data['private_count'],
	"topic" => $topic,
	"taction" => $taction,
	"curp"=> $priv,
	"report" => $report,
	"news"=> $news_count,
	"notify"=> $notify_count,
	"friends"=> $friend_count,
	"setroom"=> $setting_room,
	"use"=> $use,
	"rm"=> $muted,
	"acval"=> $data['act_time'],
	"speed"=> $data['speed'],
	"acd"=> $data['act_delay']
	), JSON_UNESCAPED_UNICODE);

}
?>