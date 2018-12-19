<div id="chat_head" class="chat_head">
	<?php if($page['page_embed'] == 0){?>
	<div class="mobile_logo">
		<img alt="logo" src="default_images/mobile_logo.png"/>
	</div>
	<div class="chat_head_logo">
		<img alt="logo" src="default_images/logo.png"/>
	</div>
	<?php } ?>
	<div id="empty_top_mob">
	</div>
	<?php if(usePlayer()){ ?>
	<div class="head_option" onclick="openPlayer();">
		<i class="i_btm fa fa-music"></i>
	</div>
	<?php } ?>
	<div title="<?php echo $lang['private_list']; ?>" value="0" onclick="getPrivate();" id="get_private" class="head_option">
		<i class="i_btm fa fa-envelope"></i>
		<div id="notify_private" class="notification bnotify"></div>
	</div>
	<?php if(boomAllow(1)){ ?>
	<div onclick="friendRequest();" class="head_option">
		<i class="fa fa-users"></i>
		<div id="notify_friends" class="notification bnotify"></div>
	</div>
	<?php } ?>
	<div onclick="getNotification();" class="head_option">
		<i class="fa fa-bell"></i>
		<div id="notify_notify" class="notification bnotify"></div>
	</div>
	<?php if(boomAllow(8)){ ?>
	<div onclick="loadReport();" class="head_option">
		<i class="fa fa-flag"></i>
		<div id="report_notify" class="notification bnotify"></div>
	</div>
	<?php } ?>
	<div id="main_mob_menu">
		<img class="avatar_menu glob_av" src="<?php echo myavatar($data['user_tumb']); ?>"/>
		<div id="mobile_main_menu" class="hideall sub_menu">
			<ul>
				<li onclick="editProfile();"><span class="boom_menu_icon menui"><i class="fa fa-user-circle-o"></i></span><?php echo $lang['my_profile']; ?></li>
				<?php if(useLobby()){ ?>
					<li id="back_home"><span class="boom_menu_icon menui"><i class="fa fa-home"></i></span><?php echo $lang['lobby']; ?></li>
				<?php } ?>
				<li class="room_granted nogranted" id="room_setting_menu" onclick="getRoomSetting();"><span class="boom_menu_icon menui"><i class="fa fa-cog"></i></span><?php echo $lang['room_side_settings']; ?></li>
				<?php if(boomAllow(8)){ ?>
					<li onclick="getActionBox();"><span class="boom_menu_icon menui"><i class="fa fa-legal"></i></span><?php echo $lang['manage_action']; ?></li>
				<?php } ?>
				<?php if(boomAllow(9)){ ?>
				<li onclick="openLinkPage('admin.php');"><span class="boom_menu_icon menui"><i class="fa fa-dashboard"></i></span><?php echo $lang['admin_panel']; ?></li>
				<?php } ?>
				<li id="open_logout" onclick="openLogout();"><span class="boom_menu_icon menui"><i class="fa fa-sign-out"></i></span><?php echo $lang['logout']; ?></li>
			</ul>
		</div>
	</div>
</div>
<div id="global_chat" class="chatheight" >
	<div id="chat_left" class="cleft chat_panel pheight" >
		<div id="chat_left_menu" class="pheight">
			<div id="status_menu" class="list_element">
				<div id="current_status" class="left_item cur_status">
					<div class="actual_in">
						<?php echo listStatus($data['user_status']); ?>
					</div>
				</div>
				<div id="status_list" class="sub_menu_in">
					<?php echo listAllStatus(); ?>
				</div>
			</div>
			<?php if(useWall() && boomAllow(1)){ ?>
			<div id="wall_menu" class="list_element left_item" onclick="getWall();">
				<div class="left_item_in">
					<span class="boom_menu_icon"><i class="fa fa-rss menui"></i></span><?php echo $lang['wall']; ?>
				</div>
			</div>
			<?php } ?>
			<div id="news_menu" class="list_element left_item" onclick="getNews();">
				<div class="left_item_in">
					<span class="boom_menu_icon"><i class="fa fa-newspaper-o menui"></i></span><?php echo $lang['system_news']; ?>
				</div>
				<div class="left_notify">
					<span id="news_notify" class="notif_left bnotify"></span>
				</div>
			</div>
			<div id="end_left_menu">
			</div>
			<div id="more_menu"class="list_element">
				<div id="open_more_menu" class="left_item" onclick="openMoreMenu();">
					<div class="left_item_in">
						<span class="boom_menu_icon"><i class="fa fa-plus-circle menui"></i></span><?php echo $lang['more']; ?>
					</div>
				</div>
				<div id="more_menu_list" class="sub_menu_in">
					<div id="chat_help_menu" class="left_item elem_in more_left" onclick="showHelp();">
						<div class="left_item_in">
							<span class="boom_menu_icon"><i class="fa fa-life-ring"></i></span><?php echo $lang['help']; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="container_extra">
				<!-- extra content for left panel do not exceed 250px width -->
			</div>
		</div>
	</div>
	<div id="chat_center" class="background_chat chatheight" style="position:relative;">
		<div  id="container_chat">
			<div id="wrap_chat">
				<div id="warp_show_chat">
					<div id="container_show_chat">
						<div id="inside_wrap_chat">
							<ul class="background_box" id="show_chat" value="1">
								<ul id="chat_logs_container">
								</ul>
							</ul>
						</div>
						<div value="0" id="main_emoticon" class="background_box">
							<div class="emo_head main_emo_head">
								<?php if(emoPlus()){ ?>
									<div data="base_emo" class="dark_selected emo_menu emo_menu_item"><img class="emo_select" src="emoticon_icon/base_emo.png"/></div>
									<?php echo emoItem(1); ?>
								<?php } ?>
								<div class="empty_emo">
								</div>
								<div class="emo_menu" onclick="hideEmoticon();">
									<i class="fa fa-times"></i>
								</div>
							</div>
							<div id="main_emo" class="emo_content">
								<?php listSmilies(1); ?>
							</div>
						</div>	
					</div>
						<!--
						<div id="special_space" style="width:100%; height:auto; position:absolute; top:0; left:0;">
							<img style="display:block; margin:0 auto; max-width:90%" src="<?php echo $data['domain'] . '/upload/banners/flywin.png'; ?>"/>
						</div>
						-->
					<div class="clear"></div>
				</div>
				<div class="chat_input_container">
					<div id="top_chat_container">
						<div id="container_input">
							<form id="main_input" name="chat_data" action="" method="post">
								<div class="input_table">
									<div id="ok_sub_item" class="input_item main_item base_main sub_hidden" onclick="getChatSub();">
										<i class="fa fa-plus input_icon bblock"></i>
									</div>
									<div value="0" class="input_item main_item base_main" onclick="showEmoticon();" id="emo_item">
										<i class="fa fa-smile-o bblock"></i>
									</div>
									<div class="input_item main_item sub_main main_hide" onclick="closeChatSub();">
										<i class="fa fa-minus input_icon bblock"></i>
									</div>
									<?php if(canColor()){ ?>
									<div class="input_item main_item sub_main sub_options main_hide" onclick="getTextOptions();">
										<i class="fa fa-font input_icon bblock"></i>
									</div>
									<?php } ?>
									<div id="main_input_box" class="td_input">
										<input type="text" spellcheck="false" name="content" maxlength="<?php echo $data['max_main']; ?>" id="content" autocomplete="off"/>
									</div>
									<?php if( canUpload()){ ?>
									<div class="input_item main_item base_main" id="send_image"><i id="chat_file_icon" data="fa-paperclip" class="fa fa-paperclip bblock"></i>
										<input id="chat_file" onchange="uploadChat();" type="file"/>
									</div>
									<?php } ?>	
									<div id="inputt_right" class="main_item">
										<button type="submit"  class="default_btn" id="submit_button"><i class="fa fa-paper-plane"></i></button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<div id="chat_right" class="cright chat_panel prheight">
		<div id="chat_right_content" class="prheight">
			<div class="wrap_right_data" class="prheight">
				<div id="right_panel_bar" class="panel_bar">
					<div class="bcell_mid panel_bar_item closeright">
						<i class="fa fa-times"></i>
					</div>
					<div class="bcell_mid">
					</div>
				</div>
				<div id="chat_right_data" class="crheight">
				</div>
			</div>
		</div>
	</div>
</div>
<div id="private_box">
	<div class="top_panel btable" id="private_top">
		<?php if(boomAllow(1)){ ?>
		<div class="bcell_mid crt_item">
			<i class="fa fa-user"></i>
		</div>
		<?php } ?>
		<div id="private_name" class="bcell_elips crt_empty <?php if(!boomAllow(1)){ echo 'lpad10'; } ?>">
			<p class="bellips"></p>
		</div>
		<div  title="<?php echo $lang['close']; ?>" id="private_close" class="bcell_mid crt_item">
			<i class="fa fa-times"></i>
		</div>
	</div>
	<div id="private_content" class="background_box" value="1">
		<ul>
		</ul>
	</div>
	<div id="private_input">
		<form id="message_form"  action="" method="post" name="private_form">
			<div class="input_table">
				<div value="0" id="emo_item_priv" class="input_item main_item">
					<i class="fa fa-smile-o"></i>
				</div>
				<div id="private_input_box" class="td_input">
					<input spellcheck="false" id="message_content" maxlength="<?php echo $data['max_private']; ?>" data-target=""  autocomplete="off"/>
				</div>
				<?php if( canUpload()){ ?>
				<div class="input_item main_item"><i id="private_file_icon" data="fa-paperclip" class="fa fa-paperclip"></i>
					<input id="private_file" onchange="uploadPrivate();" type="file"/>
				</div>
				<?php } ?>
				<div id="message_send" class="main_item">
					<button class="default_btn" id="private_send"><i class="fa fa-paper-plane"></i></button>
				</div>
			</div>
		</form>
		<div id="private_emoticon" class="background_box">
			<div class="emo_head private_emo_head">
				<?php if(emoPlus()){ ?>
					<div data="base_emo" class="dark_selected emo_menu emo_menu_item_priv"><img class="emo_select" src="emoticon_icon/base_emo.png"/></div>
					<?php echo emoItem(2); ?>
				<?php } ?>
				<div class="empty_emo">
				</div>
				<div class="emo_menu" id="emo_close_priv">
					<i class="fa fa-times"></i>
				</div>
			</div>
			<div id="private_emo" class="emo_content_priv">
				<?php listSmilies(2); ?>
			</div>
		</div>
	</div>
</div>
<div id='container_stream' class="background_stream">
	<div id='stream_header'>
		<i id='close_stream' class='fa fa-times'></i>
	</div>
	<div id='wrap_stream'>
		<iframe src='' allowfullscreen scrolling='no' frameborder='0'></iframe>
	</div>
</div>
<div id="wrap_footer" data="1" >
	<div class="chat_footer" id="menu_container">
		<div id="menu_container_inside">
			<div id="my_menu">
				<div id="open_left_menu" class="chat_footer_item">
					<i class="i_btm fa fa-bars"></i>
					<div id="bottom_news_notify" class="notification bnotify"></div>
				</div>
				<div class="chat_footer_empty bcell">
				</div>
				<div onclick="getRoomList();" class="chat_footer_item">
					<i class="i_btm fa fa-home"></i>
				</div>
				<div title="<?php echo $lang['user_list']; ?>" onclick="userReload(1);" class="chat_footer_item">
					<i class="i_btm fa fa-users"></i>
				</div>
				<?php if(boomAllow(1)){ ?>
				<div title="<?php echo $lang['friend_list']; ?>" onclick="myFriends(1);" class="chat_footer_item">
					<i class="i_btm fa fa-user-plus"></i>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<div id="av_menu">
	<ul class="sub_menu">
		<li data="" value=""  class="avitem gprivate avpriv"><?php echo $lang['private_chat']; ?></li>
		<li data="" class="avitem get_info"><?php echo $lang['info']; ?></li>
	</ul>
</div>
<div id="monitor_data" onclick="getMonitor();">
	<p>Count: <span id="logs_counter">0</span></p>
	<p>Speed: <span id="current_speed">0</span></p>
	<p>Latency: <span id="current_latency">0</span></p>
</div>
<?php 
if(usePlayer()){
	echo boomTemplate('element/radio_player', $radio);
}
?>
<div id="action_menu" class="hidden">
	<?php echo boomTemplate('element/actions'); ?>
</div>
<?php loadAddonsJs();?>
<script data-cfasync="false" type="text/javascript" src="js/function.js<?php echo $bbfv; ?>"></script>
<script data-cfasync="false" type="text/javascript" src="js/player.js<?php echo $bbfv; ?>"></script>