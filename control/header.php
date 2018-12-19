<div id="header2" class="background_header">
	<div id="wrap_main_header">
		<div id="main_header" class="out_head headers">
			<?php if($page['page_menu'] == 1){ ?>
				<div id="open_sub_mobile"><i class="fa fa-bars"></i></div>
			<?php } ?>
			<?php if($page['page_embed'] == 0){ ?>
			<div class="mobile_logo">
				<img alt="logo" src="default_images/mobile_logo.png"/>
			</div>
			<div class="head_logo">
				<img alt="logo" src="default_images/logo.png"/>
			</div>
			<?php } ?>
			<div id="empty_top_mob">
			</div>
			<?php if($page['page_nohome'] == 0){ ?>
			<div onclick="openSamePage('<?php echo $data['domain']; ?>');" class="head_option">
				<i class="i_btm fa fa-home"></i>
			</div>
			<?php } ?>
			<?php if(boomLogged()){?>
			<div id="main_mob_menu" class="add_cursor">
				<img class="glob_av avatar_menu" src="<?php echo myavatar($data['user_tumb']); ?>"/>
				<div id="mobile_main_menu" class="hideall sub_menu">
					<ul>
						<li onclick="editProfile();"><span class="boom_menu_icon menui"><i class="fa fa-user-circle-o"></i></span><?php echo $lang['my_profile']; ?></li>
						<?php if($page['page'] != 'admin' && boomAllow(10)){ ?>
						<li onclick="openLinkPage('admin.php');"><span class="boom_menu_icon menui"><i class="fa fa-cog"></i></span><?php echo $lang['admin_panel']; ?></li>
						<?php } ?>
						<li id="open_logout" onclick="openLogout();"><span class="boom_menu_icon menui"><i class="fa fa-sign-out"></i></span><?php echo $lang['logout']; ?></li>
					</ul>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="empty_subhead">
</div>