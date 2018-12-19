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

if(!boomAllow(10)){ 
	die();
}
if (isset($_FILES["file"])){
	$info = pathinfo($_FILES["file"]["name"]);
	$extension = $info['extension'];
	$origin = escape(filterOrigin($info['filename']) . '.' . $extension);

	if ( fileError() ){
		echo json_encode( array("error"=> 1));
		die();
	}
	
	$file_name = encodeFile($extension);
	
	if (isImage($extension)){
			
		$imginfo = getimagesize($_FILES["file"]["tmp_name"]);
		
		if ($imginfo !== false) {
			
			move_uploaded_file(preg_replace('/\s+/', '', $_FILES["file"]["tmp_name"]), "../upload/news/" . $file_name);
			$myimage = $data['domain'] . "/upload/news/" . $file_name;
			$file_encrypt = encrypt($file_name);
			$file_type = 'image';
			$mysqli->query("INSERT INTO boom_upload (file_name, file_key, date_sent, file_user, file_zone, file_type, file_complete) VALUES ('$file_name', '$file_encrypt', '" . time() . "', '{$data['user_id']}', 'news', 'image', 0)");
			
			echo json_encode( array(
			"file" => '<div class="up_file"><div class="up_file_inside"><img src="' . $myimage . '"/><div class="up_file_remove olay" onclick="removeFile(\'' . $file_encrypt . '\');"><i class="fa fa-times"></i></div></div></div>',
			"key" => $file_encrypt,
			"error"=> 0
			));
			die();
		}
		else {
			echo json_encode( array("error"=> 1));
			die();
		}
	}
	else {
		echo json_encode( array("error"=> 1));
	}
}
else {
	echo json_encode( array("error"=> 1));
}






?> 