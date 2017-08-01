<h4>view</h4>
<?php get_messagebox(); ?>
<?php if( !isset( $exit ) ) { ?>
<table class="table table-striped table-bordered table-condensed">
	<tbody>
			<tr>
		<th width=\"15%\"><?php echo get_field( 'room', 'room' ); ?></th><td><?php echo $item_data['room']; ?></td>
	</tr>
	<tr>
		<th width=\"15%\"><?php echo get_field( 'room', 'position' ); ?></th><td><?php echo $item_data['position']; ?></td>
	</tr>
	<tr>
		<th width=\"15%\"><?php echo get_field( 'room', 'ctime' ); ?></th><td><?php echo $item_data['ctime']; ?></td>
	</tr>

		<tr>
			<th>操作</th>
			<td>
				<a href="<?php echo module_url("room/main/edit/{$item_data['id']}"); ?>">修改</a>
				<a href="<?php echo module_url("room/main/delete/{$item_data['id']}"); ?>">删除</a>
			</td>
		</tr>
	</tbody>
</table>
<?php } ?>
<hr>
<a href="javascript:window.history.go(-1);" class="btn">返回</a>