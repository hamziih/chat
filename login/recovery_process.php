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
if (isset($_POST["ruser"]) && isset($_POST["remail"])){
	require_once("../system/config.php");
	
	$name = escape($_POST['ruser']);
	$email = escape($_POST['remail']);
	
	$getuser = $mysqli->query("SELECT * FROM boom_users WHERE user_name = '$name' AND user_email = '$email' LIMIT 1");
	if($getuser->num_rows > 0){
		
		$user = $getuser->fetch_assoc();
		echo resetUserPass($user);
		die();
	}
	else {
		echo 2;
		die();
	}
}
else {
	echo 99;
	die();
}
?>