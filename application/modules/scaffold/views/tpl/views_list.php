<?php
return
<<<EOT
<a href="<?php echo module_url('{table}/main/add'); ?>" class="btn pull-right">添加</a>
<h4>list</h4>
<hr>
<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			{th_data}
		</tr>
	</thead>
	<tbody>
		<?php
		if ( count( \$list_data ) ) {
			foreach( \$list_data as \$single ) {
		?>
		<tr>
			{td_data}
			<td>
				<a href="<?php echo module_url("{table}/main/view/{\$single['{pk}']}"); ?>"><?php echo get_lang('view'); ?></a>
				<a href="<?php echo module_url("{table}/main/edit/{\$single['{pk}']}"); ?>"><?php echo get_lang('edit'); ?></a>
				<a href="<?php echo module_url("{table}/main/delete/{\$single['{pk}']}"); ?>"><?php echo get_lang('delete'); ?></a>
			</td>
		</tr>
		<?php
			}
		} else {
		?>
		<tr><td colspan="{td_num}"><div class="alert alert-info"><p><?php echo get_lang('empty_result'); ?></p></div></td></tr>
		<?php } ?>
	</tbody>
</table>
<?php echo \$pagination; ?>
EOT;
?>