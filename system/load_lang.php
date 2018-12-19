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
require('config.php');
if(isset($_POST['lang'])){
	$lang = boomSanitize($_POST['lang']);
	if(file_exists('language/' . $lang . '/language.php')){
		setBoomLang($lang);
	}
}
?>