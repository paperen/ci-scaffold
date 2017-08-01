<?php if( isset( $is_edit ) && $is_edit ) { ?>
<h4><?php echo get_lang('edit'); ?></h4>
<?php } else { ?>
<h4><?php echo get_lang('add'); ?></h4>
<?php } ?>
<hr>
<?php get_messagebox(); ?>
<?php if( !isset( $exit ) ) { ?>
<form method="post">
		<div class="control-group">
		<label class="control-label" for="username">username</label>
		<div class="controls">
			<input type="text" id="username" name="username" placeholder="<?php echo get_field( 'user', 'username' ); ?>" value="<?php echo isset( $item_data['username'] ) ? $item_data['username'] : ''; ?>">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="password">password</label>
		<div class="controls">
			<input type="text" id="password" name="password" placeholder="<?php echo get_field( 'user', 'password' ); ?>" value="<?php echo isset( $item_data['password'] ) ? $item_data['password'] : ''; ?>">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ctime">ctime</label>
		<div class="controls">
			<input type="text" id="ctime" name="ctime" placeholder="<?php echo get_field( 'user', 'ctime' ); ?>" value="<?php echo isset( $item_data['ctime'] ) ? $item_data['ctime'] : ''; ?>">
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<?php if( isset( $is_edit ) && $is_edit ) { ?>
			<button type="submit" class="btn btn-success"><i class="icon-white icon-ok"></i> <?php echo get_lang('edit'); ?></button>
			<?php } else { ?>
			<button type="submit" class="btn btn-success"><i class="icon-white icon-ok"></i> <?php echo get_lang('add'); ?></button>
			<?php } ?>
		</div>
	</div>
	<input type="hidden" name="id" value="<?php echo isset( $item_data['id'] ) ? $item_data['id'] : ''; ?>">
	<input type="hidden" name="is_submit" value="1">
	<!--__TOKEN__-->
</form>
<?php } ?>
<hr>
<a href="javascript:window.history.go(-1);" class="btn"><?php echo get_lang('back'); ?></a>