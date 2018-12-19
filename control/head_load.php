<?php
if($chat_install != 1){
	header('location: ./');
	die();
}
if(isset($_GET['embed'])){
	$page_info['page_embed'] = 1;
}
$ip = getIp();
$page = getPageData($page_info);
$bbfv = boomFileVersion();
$brtl = 0;
if(isRtl($cur_lang) && $page['page_rtl'] == 1){
	$brtl = 1;
}
if($page['page'] == 'chat'){
	$room = roomDetails(1);
	$title = $room['room_name'];
	$radio = getPlayer($room['room_player_id']);
}
else {
	$title = $data['title'];
}
if(boomLogged() && !boomAllow($page['page_rank'])){
	header('location: ' . $data['domain']);
	die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $page['page_description']; ?>">
<meta name="keywords" content="<?php echo $page['page_keyword']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="shortcut icon" type="image/png" href="default_images/icon.png<?php echo $bbfv; ?>"/>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox.css<?php echo $bbfv; ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css<?php echo $bbfv; ?>" />
<link rel="stylesheet" type="text/css" href="css/selectboxit.css<?php echo $bbfv; ?>" />
<link rel="stylesheet" type="text/css" href="js/jqueryui/jquery-ui.css<?php echo $bbfv; ?>" />
<link rel="stylesheet" type="text/css" href="css/main.css<?php echo $bbfv; ?>" />
<link id="actual_theme" rel="stylesheet" type="text/css" href="css/themes/<?php echo getTheme(); ?><?php echo $bbfv; ?>" />
<link rel="stylesheet" type="text/css" href="css/responsive.css<?php echo $bbfv; ?>" />
<script data-cfasync="false" type="text/javascript" src="js/jquery-1.11.2.min.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" type="text/javascript" src="system/language/<?php echo $cur_lang; ?>/language.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" type="text/javascript" src="js/fancybox/jquery.fancybox.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" type="text/javascript" src="js/jqueryui/jquery-ui.min.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" type="text/javascript" src="js/global.min.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" type="text/javascript" src="js/split.js<?php echo $bbfv; ?>"></script>
<?php if(boomRecaptcha() && !boomLogged()){ ?>
<script src='https://google.com/recaptcha/api.js'></script>
<?php } ?>
<?php if(boomLogged()){ ?>
<script data-cfasync="false" type="text/javascript" src="js/split_logged.js<?php echo $bbfv; ?>"></script>
<?php } ?>
<?php if($brtl == 1){ ?>
<link rel="stylesheet" type="text/css" href="css/rtl.css<?php echo $bbfv; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="css/custom.css<?php echo $bbfv; ?>" />
	<script data-cfasync="false" type="text/javascript">
		var pageEmbed = <?php echo $page['page_embed']; ?>;
		var pageRoom = <?php echo $page['page_room']; ?>;
		var curPage = '<?php echo $page['page']; ?>';
		var loadPage = '<?php echo $page['page_load']; ?>';
		var bbfv = '<?php echo $bbfv; ?>';
		var rtlMode = '<?php echo $brtl; ?>';
	</script>
<?php if(!boomLogged()){ ?>
	<script data-cfasync="false" type="text/javascript">
		var logged = 0;
		var utk = '0';
		var recapt = <?php echo $data['use_recapt']; ?>;
		var recaptKey = '<?php echo $data['recapt_key']; ?>';
	</script>
<?php } ?>
<?php if(boomLogged()){ ?>
	<script data-cfasync="false" type="text/javascript">
		var user_rank = '<?php echo $data["user_rank"]; ?>';
		var user_id = '<?php echo $data["user_id"]; ?>';
		var utk = '<?php echo setToken(); ?>';
		var avw = <?php echo $data['max_avatar']; ?>;
		var fmw = <?php echo $data['file_weight']; ?>;
		var logged = 1;
	</script>
<?php } ?>
<?php if(boomLogged() && $page['page'] == 'chat'){ ?>
	<script data-cfasync="false" type="text/javascript">
		var user_room = '<?php echo $data['user_roomid']; ?>';
		var sesid = '<?php echo $data['session_id']; ?>';
		var userAction = '<?php echo $data['user_action']; ?>';
		var tAction = '<?php echo $data['taction']; ?>';
		var pCount = "<?php echo $data['pcount']; ?>";
		var source = "<?php echo $radio['player_url']; ?>";
		var speed = <?php echo $data['speed']; ?>;
		var balStart = <?php echo $data['act_time']; ?>;
		var inOut = <?php echo $data['act_delay']; ?>;
		var snum = "<?php echo genSnum(); ?>";
		var uSound = <?php echo $data['user_sound']; ?>;
		var rightHide = <?php echo $boom_config['right_breakpoint']; ?>;
		var rightHide2 = <?php echo $boom_config['right_breakpoint'] + 1; ?>;
		var leftHide = <?php echo $boom_config['left_breakpoint']; ?>;
		var leftHide2 = <?php echo $boom_config['left_breakpoint']; + 1 ?>;
		var defRightWidth = <?php echo $boom_config['right_size']; ?>;
		var defLeftWidth = <?php echo $boom_config['left_size']; ?>;
		var regMute = <?php echo $data['ureg_mute']; ?>;
	</script>
<?php } ?>
</head>
<body>
<?php
if(checkBan($ip)){
	include('banned.php');
	include('body_end.php');
	die();
}
if(boomLogged() && notVerified()){
	include('verification.php');
	include('body_end.php');
	die();
}
if(!boomLogged() && $page['page_out'] == 0){
	if($page['page_embed'] == 1){
		include('login_embed.php');
	}
	else {
		include('login.php');
	}
	include('body_end.php');
	die();
}
if($page['page'] == 'chat'){
	createIgnore();
}
?>