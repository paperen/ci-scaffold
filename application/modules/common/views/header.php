<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php get_pagetitle(); ?></title>
	<?php echo css( base_url( 'js/bootstrap/css/bootstrap.min.css' ) ); ?>
	<?php echo css( base_url( 'js/bootstrap/css/bootstrap-responsive.min.css' ) ); ?>
	<?php echo css( base_url('theme/common/layout.css') ); ?>
</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a data-target=".navbar-inverse-collapse" data-toggle="collapse" class="btn btn-navbar">
				</a>
				<a href="#" class="brand"><?php echo config_item('app_name'); ?></a>
				<div class="nav-collapse collapse navbar-inverse-collapse">
					<ul class="nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
					</ul>
					<form action="" class="navbar-search pull-right">
					<input type="text" placeholder="Search" class="search-query span2">
					</form>
				</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div>
	<div class="container wrapper">
		<div class="row">