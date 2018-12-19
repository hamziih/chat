<?php
require_once('../config_session.php');

$cur_session = setToken();
?>
<div class="pad_box">
	<div class="chat_settings ">
		<p class="label"><?php echo $lang['sounds']; ?></p>
		<select id="set_sound" onchange="setUserSound(this);">
			<option <?php echo selCurrent($data['user_sound'], 0); ?> value="0"><?php echo $lang['no_sound']; ?></option>
			<option <?php echo selCurrent($data['user_sound'], 1); ?> value="1"><?php echo $lang['private_sound']; ?></option>
			<option <?php echo selCurrent($data['user_sound'], 2); ?> value="2"><?php echo $lang['all_sound']; ?></option>
		</select>
	</div>
	<?php if(boomAllow($data['allow_theme'])){ ?>
	<div class="chat_settings ">
		<p class="label"><?php echo $lang['user_theme']; ?></p>
		<select id="set_user_theme" onchange="setUserTheme(this);">
			<?php echo listTheme($data['user_theme'], 2); ?>
		</select>
	</div>
	<?php } ?>
	<?php if(boomAllow($data['allow_colors'])){ ?>
	<div class="clear10"></div>
	<p class="label"><?php echo $lang['text_color']; ?></p>
	<div class="color_choices" data="<?php echo $data['bccolor']; ?>">
		<?php echo colorChoice($data['bccolor'], 2); ?>
	</div>
	<div class="clear"></div>
	<button id="boldit" data="<?php echo $data['bcbold']; ?>" class="set_button <?php echo boldIt($data['bcbold']); ?>"><?php echo $lang['bold']; ?></button>
	<?php } ?>
	<div class="clear"></div>
</div>