<?php
return
<<<EOT
<?php if( isset( \$is_edit ) && \$is_edit ) { ?>
<h4><?php echo get_lang('edit'); ?></h4>
<?php } else { ?>
<h4><?php echo get_lang('add'); ?></h4>
<?php } ?>
<hr>
<?php get_messagebox(); ?>
<?php if( !isset( \$exit ) ) { ?>
<form method="post">
	{control_data}
	<div class="control-group">
		<div class="controls">
			<?php if( isset( \$is_edit ) && \$is_edit ) { ?>
			<button type="submit" class="btn btn-success"><i class="icon-white icon-ok"></i> <?php echo get_lang('edit'); ?></button>
			<?php } else { ?>
			<button type="submit" class="btn btn-success"><i class="icon-white icon-ok"></i> <?php echo get_lang('add'); ?></button>
			<?php } ?>
		</div>
	</div>
	<input type="hidden" name="{pk}" value="<?php echo isset( \$item_data['{pk}'] ) ? \$item_data['{pk}'] : ''; ?>">
	<input type="hidden" name="is_submit" value="1">
	<!--__TOKEN__-->
</form>
<?php } ?>
<hr>
<a href="javascript:window.history.go(-1);" class="btn"><?php echo get_lang('back'); ?></a>
EOT;
?>