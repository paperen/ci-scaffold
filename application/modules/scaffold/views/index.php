<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>CI脚手架-by paperen</title>
</head>
<body>

	<h2>CI脚手架-by <a href="http://iamlze.cn" target="_blank">paperen</a></h2>
	<?php if( isset( $tip ) && $tip ) { ?>
	<div class="alert alert-info">
		<p><strong><?php echo $tip; ?></strong></p>
	</div>
	<?php } ?>
	<form method="post">
		<p>
			<label>模型存放路径(models) <?php echo $app_path; ?><input type="text" name="model_path" value="<?php echo isset( $post_data['model_path'] ) ? $post_data['model_path'] : $model_path; ?>"></label> <i>建议保持默认</i>
		</p>
		<p>
			<label>模块存放路径(modules) <?php echo $app_path; ?><input type="text" name="module_path" value="<?php echo isset( $post_data['module_path'] ) ? $post_data['module_path'] : $module_path; ?>"></label> <i>建议保持默认</i>
		</p>
		<p>选择需要生成模块与模型</p>
		<?php foreach( $tables_data as $table ) { ?>
		<p>
			<label><input type="checkbox" name="tables[]" value="<?php echo $table; ?>" <?php if( isset( $post_data['table_selected'] ) && !in_array( $table, $post_data['table_selected'] ) ){ ?><?php } else { ?> checked="true"<?php } ?>> <?php echo $table; ?></label>
		</p>
		<?php } ?>
		<p>
			<input type="submit" value="生成" name="submit_btn">
		</p>
	</form>

</body>
</html>