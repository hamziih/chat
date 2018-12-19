<?php
$page_info = array(
	'page'=> 'lobby',
	'page_out'=> 1,
);
require_once("system/config.php");

// loading head tag element
include('control/head_load.php');

// load page header
include('control/header.php');

// load page content
$content = boomTemplate('pages/privacy/privacy_container');
echo boomTemplate('element/base_page_no_menu', $content);

// close page body
include('control/body_end.php');
?>