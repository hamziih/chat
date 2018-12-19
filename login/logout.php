<?php
require('../system/config_session.php');

if(isset($_POST['logout_from_system'])){
	unsetBoomCookie();
	$mysqli->query("UPDATE `boom_users` SET `user_roomid` = '0', user_role = '0' WHERE `user_id` = '{$data["user_id"]}'");
	if(isGuest($data['user_rank'])){
		softGuestDelete($data);
	}
	echo 1;
	die();	
}
if(isset($_POST['overwrite'])){
	unsetBoomCookie();
	die();
}
?>