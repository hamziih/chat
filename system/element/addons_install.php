<div class="tab_element sub_list">
	<div class="admin_sm_icon">
		<img class="sm_icon_img" src="<?php echo $data['domain']; ?>/addons/<?php echo $boom; ?>/files/icon.png"/>
	</div>
	<div class="admin_sm_content">
		<?php echo str_replace('_', ' ', $boom); ?>
	</div>
	<div class="admin_sm_button rtl_aleft">
		<button class="default_btn reg_button work_button"><i class="fa fa-clock-o"></i> Installing...</button>
		<button data="<?php echo $boom; ?>" type="button" class="activate_addons reg_button theme_btn"><i class="fa fa-upload edit_btn"></i> <span class="hide_mobile"><?php echo $lang['install']; ?></span></button>
	</div>
</div>