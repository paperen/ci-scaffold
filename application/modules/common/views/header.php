<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php get_pagetitle(); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php echo css( base_url( 'js/bootstrap/css/bootstrap.min.css' ) ); ?>
	<?php echo css( base_url('theme/common/layout.css') ); ?>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
					<span class="sr-only">菜单</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="<?php echo base_url(); ?>" class="navbar-brand"><?php echo config_item('app_name'); ?></a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav visible-xs">
					<li><a href="#"><i class="glyphicon glyphicon-log-out"></i> 注销</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right hidden-xs">
					<li><a href="#"><i class="glyphicon glyphicon-log-out"></i> 注销</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container-fluid">
		<div class="row">