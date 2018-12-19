<?php
require_once('../config_session.php');

if(!boomAllow(8)){
	echo 0;
	die();
}
?>
<div class="modal_menu">
	<ul>
		<li class="modal_menu_item modal_selected" onclick="modalZone(this, 'action_muted');"><?php echo $lang['muted']; ?></li>
		<?php if(boomAllow(9)){ ?>
		<li class="modal_menu_item" onclick="modalZone(this, 'action_banned');"><?php echo $lang['banned']; ?></li>
		<?php } ?>
	</ul>
</div>
<div class="modal_zone pad_box box_height" id="action_muted">
	<div id="action_muted_list">
		<?php echo getActionList('muted'); ?>
	</div>
</div>
<?php if(boomAllow(9)){ ?>
<div class="modal_zone pad_box box-height hide_zone" id="action_banned">
	<div id="action_banned_list">
		<?php echo getActionList('banned'); ?>
	</div>
</div>
<?php } ?>