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
require("../system/config.php");
$guest_lang = getLanguage();
$guest_password = randomPass();
$guest_ip = getIp();
if(!allowGuest() || !isset($_POST['guest_login'])){
	echo 0;
	die();
}
if(!okGuest($guest_ip)){
	echo 16;
	die();
}
$guest_count = boomGuestCount();
$guest_name = $data['guest_prefix'] . '0' . $guest_count;

$guest_user = array(
	'name'=> $guest_name,
	'password'=> randomPass(),
	'email'=> $boom_config['guest_email'],
	'language'=> $guest_lang,
	'ip'=> $guest_ip,
	'rank'=> 0,
	'avatar'=> 'default_guest.png'
);
$guest = boomInsertUser($guest_user);
if(empty($guest)){
	die();
}
echo 1;
?>