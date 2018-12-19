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
$page_info = array(
	'page'=> 'admin',
	'page_load'=> 'system/pages/admin/setting_dashboard.php',
	'page_menu'=> 1,
	'page_rank'=> 9,
	'page_nohome'=> 1,
);
require_once("system/config.php");

// loading head tag element
include('control/head_load.php');

// load page header
include('control/header.php');

// create page menu
$side_menu = '';
if(boomAllow(9)){
	$side_menu .= pageMenu('admin/setting_dashboard.php', 'tachometer', $lang['dashboard']);
}
if(boomAllow(10)){
	$side_menu .= pageMenu('admin/setting_main.php', 'cog', $lang['main_settings']);
	$side_menu .= pageMenu('admin/setting_registration.php', 'pencil-square-o', $lang['registration_settings']);
}
if(boomAllow(9)){
	$side_menu .= pageMenu('admin/setting_members.php', 'users', $lang['users_management']);
	$side_menu .= pageMenu('admin/setting_action.php', 'legal', $lang['manage_action']);
}
if(boomAllow(10)){
	$side_menu .= pageMenu('admin/setting_chat.php', 'comment', $lang['chat_settings']);
	$side_menu .= pageMenu('admin/setting_rooms.php', 'home', $lang['room_management']);
}
if(isOwner()){
	$side_menu .= pageMenu('admin/setting_email.php', 'envelope-o', $lang['email_settings']);
}
if(boomAllow(10)){
	$side_menu .= pageMenu('admin/setting_data.php', 'database', $lang['database_management']);
	$side_menu .= pageMenu('admin/setting_limit.php', 'filter', $lang['limit_management']);
	$side_menu .= pageMenu('admin/setting_player.php', 'music', $lang['player_settings']);
}
if(boomAllow(9)){
	$side_menu .= pageMenu('admin/setting_filter.php', 'hand-paper-o', $lang['filter']);
}
if(boomAllow(9)){
	$side_menu .= pageMenu('admin/setting_ip.php', 'ban', $lang['ban_management']);
}
if(boomAllow(10)){
	$side_menu .= pageMenu('admin/setting_modules.php', 'cubes', $lang['manage_modules']);
	$side_menu .= pageMenu('admin/setting_addons.php', 'puzzle-piece', $lang['addons_management']);
}
if(isOwner()){
	$side_menu .= pageMenu('admin/setting_pages.php', 'file-text', $lang['page']);
	$side_menu .= pageMenu('admin/setting_update.php', 'wrench', $lang['update_zone']);
}
if(boomAllow(10)){
	$side_menu .= '<li onclick="openLinkPage(\'documentation.php\');" class="pmenu"><span class="boom_menu_icon pagemenui"><i class="fa fa-book"></i></span>' . $lang['manual'] . '</li>';
}

// load page content
echo boomTemplate('element/base_page_menu', $side_menu);
 ?>
 <!-- load page script -->
<script type="text/javascript" src="js/admin.js<?php echo $bbfv; ?>"></script>
<?php
// close page body
include('control/body_end.php');
?>

