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
require_once("config_session.php");
if (isset($_POST['target']) && isset($_POST['content'])){
	if(checkFlood()){
		echo 100;
		die();
	}
	if(muted()){
		die();
	}
	$target = escape($_POST['target']);
	$content = escape($_POST['content']);
	$content2 = escape($_POST['content']);
	$hunter = $data["user_id"];
	$take_action = 0;
	$content = wordFilter($content, 1);
	$content = textFilter($content);
	if($content2 == '/clear'){
		clearPrivate($hunter, $target);
		echo 10;
		die();
	}
	else {
		if(!canSendPrivate($target)){
			echo 20;
			die();
		}
		else {
			postPrivate($hunter, $target, $content);
			$post = getBackPrivate($data['user_id']);
			if(!empty($post)){
				echo privateLog($post, 1);
			}
		}
	}
}
else {
	echo 4;
}



?>