<div id="login_wrap">
	<div id="header2" class="background_header">
		<div id="wrap_main_header">
			<div id="main_header" class="out_head headers">
				<div class="mobile_logo">
					<img alt="logo" src="default_images/mobile_logo.png"/>
				</div>
				<div class="head_logo">
					<img alt="logo" src="default_images/logo.png"/>
				</div>
				<div class="login_main_menu">
				</div>
				<div onclick="getLanguage();" class="add_cursor" id="open_login_menu">
					<img alt="flag" class="intro_lang" src="<?php echo $data['domain']; ?>/system/language/<?php echo $cur_lang; ?>/flag.png"/>
				</div>
			</div>
		</div>
	</div>
	<div class="empty_subhead">
	</div>
	<div id="content_page">
		<div id="intro_top">
			<div id="container_intro">
				<div id="intro_content">
					<div class="opacity_box" id="intro_inside">
						<p class="titles_big shadow_text"><?php echo $lang['left_title']; ?></p>
						<p class="title_small shadow_text"><?php echo $lang['left_welcome']; ?></p>
						<div id="intro_control">
						<?php if(useBridge()){ ?>
						<button class="theme_btn intro_btn" onclick="bridgeLogin('<?php echo getChatPath(); ?>');">
							<i class="fa fa-send"></i> <?php echo $lang['enter_now']; ?>
						</button>
						<?php } else { ?>
						<button class="theme_btn intro_btn" onclick="getLogin();">
							<i class="fa fa-send"></i> <?php echo $lang['enter_now']; ?>
						</button>
						<?php } ?>
						<?php if(allowGuest()){ ?>
						<br/>
						<button class="default_btn intro_btn" onclick="getGuestLogin();">
							<i class="fa fa-paw"></i> <?php echo $lang['guest_login']; ?>
						</button>
						<?php } ?>
						<?php if(alterLogin()){ ?>
						<br/>
						<button class="ok_btn small_intro_btn" onclick="moreLogin();">
							<i class="fa fa-plus-circle"></i> <?php echo $lang['more_login']; ?>
						</button>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section" id="intro_section_user">
			<div class="section_content">
				<div class="section_inside">
					<p id="last_title"><?php echo $lang['last_active']; ?></p>
					<div id="last_active">
					  <div class="left-arrow"></div>
					  <div class="right-arrow"></div>

					  <div class="last-clip">
						<div class="last_10">
							<?php echo introActive(16); ?>
						</div>
					  </div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section" id="intro_section_bottom">
		</div>
		<div class="section intro_footer" id="main_footer">
			<div class="section_content">
				<div class="section_inside">
					<?php boomFooterMenu(); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<?php if(boomCookieLaw()){ ?>
<div class="cookie_wrap">
	<div class="cookie_bar back_dark add_shadow">
		<div class="cookie_left">
			<i class="fa fa-exclamation-circle"></i> <?php echo str_replace('%data%', '<span onclick="openSamePage(\'privacy.php\');" class="bold add_cursor link_like">' . $lang['privacy'] . '</span>', $lang['cookie_law']); ?>
		</div>
		<div class="cookie_right">
			<button onclick="hideCookieBar();" class="ok_btn reg_button"><i class="fa fa-check"></i> <?php echo $lang['ok']; ?></button>
		</div>
	</div>
</div>
<?php } ?>
<script data-cfasync="false" type="text/javascript" src="js/login.js<?php echo $bbfv; ?>"></script>