<?php
return
<<<EOT
<h4>delete</h4>
<?php get_messagebox();?>
<?php if ( !isset( \$exit ) ) {?>
<form method="post">
	<div class="alert alert-error">
		<h3 class="alert-heading"><?php echo get_lang('system_info'); ?></h3>
		<p><?php echo get_lang( 'delete_confirm' );?></p>
		<p>
			<button type="submit" class="btn btn-danger"><i class="icon-ok icon-white"></i> 确定</button>
		</p>
	</div>
	<input type="hidden" name="id" value="<?php echo isset( \$item_data['id'] ) ? \$item_data['id'] : ''; ?>">
	<input type="hidden" name="is_submit" value="1">
	<!--__TOKEN__-->
</form>
<?php }?>
<hr>
<a href="javascript:window.history.go(-1);" class="btn">返回</a>
EOT;
?>