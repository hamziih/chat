<div class="tab_element sub_list">
	<div class="admin_sm_icon">
		<img class="sm_icon_img" src="<?php echo $data['domain']; ?>/addons/<?php echo $boom['addons']; ?>/files/icon.png"/>
	</div>
	<div class="admin_sm_content">
		<?php echo str_replace('_', ' ', $boom['addons']); ?>
	</div>
	<div class="admin_sm_button rtl_aleft">
		<button class="default_btn reg_button work_button"><i class="fa fa-clock-o"></i> Uninstalling...</button>
		<button data="<?php echo $boom['addons']; ?>" type="button" class="config_addons reg_button default_btn"><i class="fa fa-cogs edit_btn"></i> <span class="hide_mobile"><?php echo $lang['settings']; ?></span></button>
		<button data="<?php echo $boom['addons']; ?>" type="button" class="desactivate_addons reg_button delete_btn"><i class="fa fa-trash edit_btn"></i> <span class="hide_mobile"><?php echo $lang['uninstall']; ?></span></button>
	</div>
</div>