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
require_once('config_session.php');

if(!boomAllow($data['allow_image']) || muted() || roomMuted()){ 
	die();
}

if (isset($_FILES["file"])){
	$info = pathinfo($_FILES["file"]["name"]);
	$extension = $info['extension'];
	$origin = escape(filterOrigin($info['filename']) . '.' . $extension);

	if ( fileError() ){
		echo 1;
		die();
	}
	
	$file_name = encodeFile($extension);
		
	if (isImage($extension)){
		$imginfo = getimagesize($_FILES["file"]["tmp_name"]);
		if ($imginfo !== false) {
			move_uploaded_file(preg_replace('/\s+/', '', $_FILES["file"]["tmp_name"]), "../upload/chat/" . $file_name);
			$myimage = $data['domain'] . "/upload/chat/" . $file_name;
			$myimage = linking($myimage);
			$mysqli->query("INSERT INTO `boom_chat` (post_date, user_id, post_message, post_roomid, type, file) VALUES ('" . time() . "', '{$data['user_id']}', '$myimage', '{$data['user_roomid']}', 'public', '1')");
			$rel_post = $mysqli->insert_id;
			$mysqli->query("UPDATE boom_users SET caction = caction + 1 WHERE user_roomid = '{$data['user_roomid']}'");
			$mysqli->query("INSERT INTO `boom_upload` (file_name, date_sent, file_user, file_zone, file_type, relative_post) VALUES ('$file_name', '" . time() . "', '{$data['user_id']}', 'chat', 'image', '$rel_post')");
			echo 5;
			die();
		}
		else {
			echo 1;
			die();
		}
	}
	else if (isFile($extension)){
		move_uploaded_file(preg_replace('/\s+/', '', $_FILES["file"]["tmp_name"]), "../upload/chat/" . $file_name);
		$myfile = $data['domain'] . "/upload/chat/" . $file_name;
		$myfile =  fileProcess($myfile, $origin);
		$mysqli->query("INSERT INTO `boom_chat` (post_date, user_id, post_message, post_roomid, type, file) VALUES ('" . time() . "', '{$data['user_id']}', '$myfile', '{$data['user_roomid']}', 'public', '1')");
		$rel_post = $mysqli->insert_id;
		$mysqli->query("UPDATE boom_users SET caction = caction + 1 WHERE user_roomid = '{$data['user_roomid']}'");
		$mysqli->query("INSERT INTO `boom_upload` (file_name, date_sent, file_user, file_zone, file_type, relative_post) VALUES ('$file_name', '" . time() . "', '{$data['user_id']}', 'chat', 'file', '$rel_post')");
		echo 5;
		die();
	}
	else if (isMusic($extension)){
		move_uploaded_file(preg_replace('/\s+/', '', $_FILES["file"]["tmp_name"]), "../upload/chat/" . $file_name);
		$myfile = $data['domain'] . "/upload/chat/" . $file_name;
		$myfile =  musicProcess($myfile, $origin);
		$mysqli->query("INSERT INTO `boom_chat` (post_date, user_id, post_message, post_roomid, type, file) VALUES ('" . time() . "', '{$data['user_id']}', '$myfile', '{$data['user_roomid']}', 'public', '1')");
		$rel_post = $mysqli->insert_id;
		$mysqli->query("UPDATE boom_users SET caction = caction + 1 WHERE user_roomid = '{$data['user_roomid']}'");
		$mysqli->query("INSERT INTO `boom_upload` (file_name, date_sent, file_user, file_zone, file_type, relative_post) VALUES ('$file_name', '" . time() . "', '{$data['user_id']}', 'chat', 'file', '$rel_post')");
		echo 5;
		die();
	}
	else {
		echo 1;
	}
}
else {
	echo 1;
}
?> 