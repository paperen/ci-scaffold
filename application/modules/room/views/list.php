<a href="<?php echo module_url('room/main/add'); ?>" class="btn pull-right">添加</a>
<h4>list</h4>
<hr>
<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<th><?php echo get_field( 'room', 'room' ); ?></th><th><?php echo get_field( 'room', 'position' ); ?></th><th><?php echo get_field( 'room', 'ctime' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ( count( $list_data ) ) {
			foreach( $list_data as $single ) {
		?>
		<tr>
			<td><?php echo $single['room']; ?></td><td><?php echo $single['position']; ?></td><td><?php echo $single['ctime']; ?></td>
			<td>
				<a href="<?php echo module_url("room/main/view/{$single['id']}"); ?>"><?php echo get_lang('view'); ?></a>
				<a href="<?php echo module_url("room/main/edit/{$single['id']}"); ?>"><?php echo get_lang('edit'); ?></a>
				<a href="<?php echo module_url("room/main/delete/{$single['id']}"); ?>"><?php echo get_lang('delete'); ?></a>
			</td>
		</tr>
		<?php
			}
		} else {
		?>
		<tr><td colspan="3"><div class="alert alert-info"><p><?php echo get_lang('empty_result'); ?></p></div></td></tr>
		<?php } ?>
	</tbody>
</table>
<?php echo $pagination; ?>