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
		<label class="control-label" for="room">room</label>
		<div class="controls">
			<input type="text" id="room" name="room" placeholder="<?php echo get_field( 'room', 'room' ); ?>" value="<?php echo isset( $item_data['room'] ) ? $item_data['room'] : ''; ?>">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="position">position</label>
		<div class="controls">
			<input type="text" id="position" name="position" placeholder="<?php echo get_field( 'room', 'position' ); ?>" value="<?php echo isset( $item_data['position'] ) ? $item_data['position'] : ''; ?>">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ctime">ctime</label>
		<div class="controls">
			<input type="text" id="ctime" name="ctime" placeholder="<?php echo get_field( 'room', 'ctime' ); ?>" value="<?php echo isset( $item_data['ctime'] ) ? $item_data['ctime'] : ''; ?>">
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