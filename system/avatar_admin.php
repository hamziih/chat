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

if (isset($_FILES["file"], $_POST['avatar_target'])){
	
	$target = escape($_POST['avatar_target']);
	$user = userDetails($target);
	
	ini_set('memory_limit','128M');
	$info = pathinfo($_FILES["file"]["name"]);
	$extension = $info['extension'];
	
	if(fileError(2)){
		echo 1;
	}
	if(!canModifyAvatar($user)){
		die();
	}
			
	$count = rand(0,99999999);
	$count2 = rand(0,99999999);
	$file_tumb = "avatar_user" . $user["user_id"] . "_" . $count . $count2 . ".jpg";
	$file_avatar = "temporary_avatar_user_" . $user["user_id"] . "." . $extension;
	
	unlinkAvatar($file_avatar);
	
	if (isImage($extension)){
		$info = getimagesize($_FILES["file"]["tmp_name"]);
		if ($info !== false) {
			
			$width = $info[0];
			$height = $info[1];
			$type = $info['mime'];
			
			move_uploaded_file($_FILES["file"]["tmp_name"], "../avatar/" . $file_avatar);
			$filepath = '../avatar/' . $file_tumb;
			$filesource = '../avatar/' . $file_avatar;
			$create = createTumbnail($filesource, $filepath, $type, $width, $height, 200, 200);
			
			if(file_exists($filepath) && file_exists($filesource)){
				$new_av = getimagesize($filepath);
				if ($new_av !== false) {
					unlinkAvatar($user['user_tumb']);
					unlinkAvatar($file_avatar);
					$mysqli->query("UPDATE boom_users SET user_tumb = '$file_tumb' WHERE user_id = '{$user["user_id"]}'");
					echo 5;
					die();
				}
				else {
					unlinkAvatar($file_avatar);
					echo 7;
					die();
				}
			}
			else {
				unlinkAvatar($file_avatar);
				echo 7;
			}
		}
		else {
			echo 7;
			die();
		}
	}
	else {
		echo 1;
	}
}
else {
	echo 7;
}






?> 