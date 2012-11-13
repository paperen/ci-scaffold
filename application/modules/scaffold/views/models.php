<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>模型生成器</title>
</head>
<body>

	<h2>模型生成器</h2>
	<form method="post">
		<p>
			<label>模型存放路径 <?php echo $app_path; ?><input type="text" name="path" value="<?php echo $default_models_path; ?>"></label>
		</p>
		<p>选择需要生成模型的表</p>
		<?php foreach( $tables_data as $table ) { ?>
		<p>
			<label><input type="checkbox" name="tables[]" value="<?php echo $table; ?>"> <?php echo $table; ?></label>
		</p>
		<?php } ?>
		<p>
			<input type="submit" value="生成" name="submit_btn">
		</p>
	</form>

</body>
</html>