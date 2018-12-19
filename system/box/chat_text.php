<?php
require_once('../config_session.php');
if(!canColor()){
	die();
}
?>
<div class="pad_box">
	<div class="color_choices" data="<?php echo $data['bccolor']; ?>">
		<?php echo colorChoice($data['bccolor'], 2); ?>
	</div>
	<div class="clear"></div>
	<button id="boldit" data="<?php echo $data['bcbold']; ?>" class="set_button <?php echo boldIt($data['bcbold']); ?>"><?php echo $lang['bold']; ?></button>
	<div class="clear"></div>
</div>