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
$boom_access = 0;
$time = time();
require("database.php");
require("variable.php");
require("function_bridge.php");
$bmysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno() || $check_install != 1) {
	die();
}
else{
	$bget_data = $bmysqli->query("SELECT boom_setting.*, boom_social_login.* FROM boom_setting, boom_social_login WHERE boom_setting.id = '1' AND boom_social_login.id = 1");
	if($bget_data->num_rows > 0){
		$bdata = $bget_data->fetch_assoc();
		$boom_access = 1;
	}
	else {
		die();
	}
}
date_default_timezone_set("{$bdata['timezone']}");
?>