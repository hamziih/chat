<div class="out_page_container">
	<div class="out_page_content">
		<div class="out_page_box">
			<div class="out_page_data pad_box">
				<p class="out_page_title"><?php echo $data['title']; ?></p>
				<p class="out_page_text sub_text"><?php echo $lang['left_welcome']; ?></p>
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
				<p id="last_embed_title"><?php echo $lang['last_active']; ?></p>
				<div id="last_embed">
					<?php echo embedActive(5); ?>
				</div>
				<div class="embed_lang add_cursor" onclick="getLanguage();">
					<img class="intro_lang" src="<?php echo $data['domain']; ?>/system/language/<?php echo $cur_lang; ?>/flag.png"/>
					<p><?php echo $lang['language']; ?></p>
				</div>			
			</div>
		</div>
		<?php if(useBridge()){ ?>
		<div onclick="getLogin();" class="adm_login add_cursor">
			<i class="fa fa-cog"></i> <?php echo $lang['login']; ?>
		</div>
		<?php } ?>
	</div>
</div>
<script data-cfasync="false" type="text/javascript" src="js/login.js<?php echo $bbfv; ?>"></script>