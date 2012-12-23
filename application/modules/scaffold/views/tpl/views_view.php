<?php
return
<<<EOT
<h4>view</h4>
<?php get_messagebox(); ?>
<?php if( !isset( \$exit ) ) { ?>
<table class="table table-striped table-bordered table-condensed">
	<tbody>
		{tr_data}
		<tr>
			<th>操作</th>
			<td>
				<a href="<?php echo module_url("{table}/main/edit/{\$item_data['id']}"); ?>">修改</a>
				<a href="<?php echo module_url("{table}/main/delete/{\$item_data['id']}"); ?>">删除</a>
			</td>
		</tr>
	</tbody>
</table>
<?php } ?>
<hr>
<a href="javascript:window.history.go(-1);" class="btn">返回</a>
EOT;
?>