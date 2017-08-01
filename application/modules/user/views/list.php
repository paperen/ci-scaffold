<a href="<?php echo module_url('user/main/add'); ?>" class="btn pull-right">添加</a>
<h4>list</h4>
<hr>
<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<th><?php echo get_field( 'user', 'username' ); ?></th><th><?php echo get_field( 'user', 'password' ); ?></th><th><?php echo get_field( 'user', 'ctime' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ( count( $list_data ) ) {
			foreach( $list_data as $single ) {
		?>
		<tr>
			<td><?php echo $single['username']; ?></td><td><?php echo $single['password']; ?></td><td><?php echo $single['ctime']; ?></td>
			<td>
				<a href="<?php echo module_url("user/main/view/{$single['id']}"); ?>"><?php echo get_lang('view'); ?></a>
				<a href="<?php echo module_url("user/main/edit/{$single['id']}"); ?>"><?php echo get_lang('edit'); ?></a>
				<a href="<?php echo module_url("user/main/delete/{$single['id']}"); ?>"><?php echo get_lang('delete'); ?></a>
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