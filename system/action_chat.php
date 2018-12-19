<?php
require('config_session.php');

if(isset($_POST['more_chat'])){
	$clogs = '';
	$count = 0;
	$last = escape($_POST['more_chat']);
	if(!boomAllow($data['allow_history'])){
		echo json_encode( array( "total" => 0, "clogs"=> 0 ), JSON_UNESCAPED_UNICODE);
		die();
	}
	$log = $mysqli->query("SELECT log.*, boom_users.user_name, boom_users.user_color, boom_users.bccolor, boom_users.user_tumb, boom_users.user_bot
	FROM ( SELECT * FROM `boom_chat` WHERE `post_roomid` = '{$data['user_roomid']}' AND post_id < '$last' ORDER BY `post_id` DESC LIMIT 60) AS log
	LEFT JOIN boom_users
	ON log.user_id = boom_users.user_id
	ORDER BY `post_id` ASC");
	
	if($log->num_rows > 0){
		while ($chat = $log->fetch_assoc()){
			$clogs .= createLog($data, $chat);
			$count++;
		}
	}
	else {
		$clogs = 0;
	}
	echo json_encode( array( "total" => $count, "clogs"=> $clogs ), JSON_UNESCAPED_UNICODE);
	die();
}
if(isset($_POST['more_private'], $_POST['target'])){
	$plogs = '';
	$count = 0;
	$last = escape($_POST['more_private']);
	$priv = escape($_POST['target']);
	
	$privlog = $mysqli->query("SELECT log.*, boom_users.user_id, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_bot 
	FROM ( SELECT * FROM `boom_private` WHERE  `hunter` = '{$data['user_id']}' AND `target` = '$priv' AND id < '$last' OR `hunter` = '$priv' AND `target` = '{$data['user_id']}'  AND id < '$last' ORDER BY `id` DESC LIMIT 30) AS log 
	LEFT JOIN boom_users
	ON log.hunter = boom_users.user_id
	ORDER BY `time` ASC");
	
	if($privlog->num_rows > 0){
		while ($private = $privlog->fetch_assoc()){
			if($private['hunter'] == $data['user_id']){
				$plogs .= privateLog($private, 1);
			}
			else {
				$plogs .= privateLog($private, 2);
			}
			$count++;
		}
	}
	else {
		$plogs = 0;
	}
	echo json_encode( array( "total" => $count, "clogs"=> $plogs ), JSON_UNESCAPED_UNICODE);
	die();
}
if(isset($_POST['del_post']) && isset($_POST['type'])){
	if(boomAllow(8) || boomRole(4)){
		$post = escape($_POST['del_post']);
		$type = escape($_POST['type']);
		$mysqli->query("DELETE FROM boom_chat WHERE post_id = '$post' AND post_roomid = '{$data['user_roomid']}'");
		$mysqli->query("DELETE FROM boom_report WHERE report_post = '$post' AND report_type = '1' AND report_room = '{$data['user_roomid']}'");
		
		if($type == 1){
			$mysqli->query("UPDATE boom_users SET post_delete = CONCAT(post_delete, ',$post') WHERE user_roomid = '{$data['user_roomid']}'");
		}
		else {
			$mysqli->query("UPDATE boom_users SET post_delete = '$post' WHERE user_roomid = '{$data['user_roomid']}'");
		}
		removeRelatedFile($post, 'chat');
		die();
	}
	else {
		die();
	}
}
if(isset($_POST['private_delete'])){
	$item = escape($_POST['private_delete']);
	$mysqli->query("UPDATE `boom_private` SET `status` = 3, `view` = 1  WHERE `hunter` = '$item' AND `target` = '{$data['user_id']}'");
	echo 1;
	die();
}
if(isset($_POST['clear_private'])){
	$mysqli->query("UPDATE `boom_private` SET `status` = 3, `view` = 1  WHERE `target` = '{$data['user_id']}'");
	echo 1;
	die();
}
if(isset($_POST['report_post'], $_POST['type'], $_POST['post'], $_POST['reason']) && boomAllow(1)){
	if($data['user_report'] > time() - 60){
		echo 3;
		die();
	}
	$post = escape($_POST['post']);
	$type = escape($_POST['type']);
	$reason = escape($_POST['reason']);
	if($reason != 'language' && $reason != 'spam' && $reason != 'content'){
		echo 0;
		die();
	}
	if($type != 1 && $type != 2){
		echo 0;
		die();
	}
	switch($type){
		case 1;
			$room = $data['user_roomid'];
			$t = 'boom_chat';
			break;
		case 2:
			$room = 0;
			$t = 'boom_post';
			break;
	}
	$check_report = $mysqli->query("SELECT * FROM boom_report WHERE report_post = '$post' AND report_type = '$type'");
	if($check_report->num_rows > 0){
		echo 2;
		die();
	}
	else {
		$valid_post = $mysqli->query("SELECT post_id FROM $t WHERE post_id = '$post'");
		if($valid_post->num_rows > 0){
			$mysqli->query("INSERT INTO boom_report (report_type, report_user, report_post, report_reason, report_date, report_room) VALUES ('$type', '{$data['user_id']}', '$post', '$reason', '" . time() . "', '$room')");
			$mysqli->query("UPDATE boom_users SET user_report = '" . time() . "' WHERE user_id = '{$data['user_id']}'");
			updateStaffNotify();
			echo 1;
			die();
		}
		else {
			echo 0;
			die();
		}
	}
}
?>