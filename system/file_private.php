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


if(!boomAllow($data['allow_image']) || muted()){ 
	die();
}
if(isset($_POST['target'])){
	$target = escape($_POST['target']);
	if(!targetExist($target)){
		die();
	}
	$check_ignore = $mysqli->query("SELECT * FROM boom_ignore WHERE ignored = '{$data['user_id']}' AND ignorer = '$target' OR ignored = '$target' AND ignorer = '{$data['user_id']}'");
	if($check_ignore->num_rows > 0){
		echo 88;
		die();
	}
}
else {
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
			move_uploaded_file(preg_replace('/\s+/', '', $_FILES["file"]["tmp_name"]), "../upload/private/" . $file_name);
			$myimage = linking( $data['domain'] . "/upload/private/" . $file_name );
			$mysqli->query("INSERT INTO `boom_private` (time, target, hunter, message, file) VALUES ('" . time() . "', '$target', '{$data['user_id']}', '$myimage', 1)");
			$rel_post = $mysqli->insert_id;
			$mysqli->query("UPDATE boom_users SET pcount = pcount + 1 WHERE user_id = '{$data['user_id']}' OR user_id = '$target'");
			$mysqli->query("INSERT INTO `boom_upload` (file_name, date_sent, file_user, file_zone, file_type, relative_post) VALUES ('$file_name', '" . time() . "', '{$data['user_id']}', 'private', 'image', '$rel_post')");
			echo 5;
			die();
		}
		else {
			echo 1;
			die();
		}
	}
	else if (isFile($extension)){
		move_uploaded_file(preg_replace('/\s+/', '', $_FILES["file"]["tmp_name"]), "../upload/private/" . $file_name);
		$myfile = $data['domain'] . "/upload/private/" . $file_name;
		$myfile =  fileProcess($myfile, $origin);
		$mysqli->query("INSERT INTO `boom_private` (time, target, hunter, message, file) VALUES ('" . time() . "', '$target', '{$data['user_id']}', '$myfile', 1)");
		$rel_post = $mysqli->insert_id;
		$mysqli->query("UPDATE boom_users SET pcount = pcount + 1 WHERE user_id = '{$data['user_id']}' OR user_id = '$target'");
		$mysqli->query("INSERT INTO `boom_upload` (file_name, date_sent, file_user, file_zone, file_type, relative_post) VALUES ('$file_name', '" . time() . "', '{$data['user_id']}', 'private', 'file', '$rel_post')");
		echo 5;
		die();
	}
	else if (isMusic($extension)){
		move_uploaded_file(preg_replace('/\s+/', '', $_FILES["file"]["tmp_name"]), "../upload/private/" . $file_name);
		$myfile = $data['domain'] . "/upload/private/" . $file_name;
		$myfile =  musicProcess($myfile, $origin);
		$mysqli->query("INSERT INTO `boom_private` (time, target, hunter, message, file) VALUES ('" . time() . "', '$target', '{$data['user_id']}', '$myfile', 1)");
		$rel_post = $mysqli->insert_id;
		$mysqli->query("UPDATE boom_users SET pcount = pcount + 1 WHERE user_id = '{$data['user_id']}' OR user_id = '$target'");
		$mysqli->query("INSERT INTO `boom_upload` (file_name, date_sent, file_user, file_zone, file_type, relative_post) VALUES ('$file_name', '" . time() . "', '{$data['user_id']}', 'private', 'file', '$rel_post')");
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