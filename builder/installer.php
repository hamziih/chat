<?php 
if($chat_install != 2){ 
	die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" type="image/png" href="default_images/icon.png"/>
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
	<script data-cfasync="false" type="text/javascript" src="js/fancybox/jquery.fancybox.js"></script>
	<script data-cfasync="false" type="text/javascript" src="js/jqueryui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/global.min.js"></script>
	<script type="text/javascript" src="builder/install.js"></script>
	<link rel="stylesheet" type="text/css" href="css/selectboxit.css" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/themes/Lite/Lite.css" />
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<link rel="stylesheet" type="text/css" href="css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="builder/install.css" />
</head>
<body>
	<div id="install_head">
		<img class="install_logo" src="builder/images/logo.png"/>
	</div>
	<div id="container_install">
		<div id="install_box">
			<div id="install_content">
				<div class="page_element">
					<p class="install_h3">License agreement</p>
					<div class="can_do pad10">
						<p class="bold">You are allowed to</p>
						<ul class="list lite">
							<li><i class="fa fa-check success"></i> Install on one (1) domain only, additional license is required for each additional installation.</li>
							<li><i class="fa fa-check success"></i> Modify files for your need and personal use.</li>
						</ul>
						<p class="bold">You are not allowed to</p>
						<ul class="list lite">
							<li>
							<i class="fa fa-times error"></i> You cannot resell, redistribute or share any part of this software.
							</li>
							<li><i class="fa fa-times error"></i> Install on more than one (1) domain.</li>
							<li><i class="fa fa-times error"></i> Have multiple installation on same domain without having license for each installation.</li>
						</ul>
						<p class="bold">Legal disclamer</p>
						<p class="legal_text lite">
						BoomCoding neither assumes nor accepts any liability for any loss, damage caused by illegal use of
						this software. You confirm that you have paid for your license. You also agree that using this product
						illegally without license can lead to legal action for Copyright infringement. Installation made without proper
						license will be subject to DCMA report and may result in host exclusion and domain cancellation without notice.
						</p>
						<p class="install_rules"><i value="0" class="fa fa-circle accept_rules install_accept"></i> i agree and fully understand.</p>
						<button id="start_install" type="button" class="save_admin reg_button ok_btn set_button admin_btn">Start installation</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="saved_data"><span class="saved_span"></span></div>
</body>
</html>