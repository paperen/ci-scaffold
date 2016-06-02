<?php
/**
 * 这是你应用的配置文件
 * 建议将一些基本配置参数写到这里
 */

// 应用名称
$config['app_name'] = 'ci-scaffold';
// 每页显示条数
$config['per_page'] = 5;
// 当前主题
$config['theme'] = 'default';
// layout
$config['layout'] = 'default';

// 分库分表配
$config['dist']['user_table'] = array(
	'0' => array(
		'hostname' => 'localhost',
		'table_count' => 10, // 分表数
		'username' => 'root',
		'password' => 'root',
		'dbdriver' => 'mysql',
		'dbprefix' => '',
		'pconnect' => FALSE,
		'db_debug' => TRUE,
		'cache_on' => FALSE,
		'cachedir' => FALSE,
		'char_set' => 'utf8',
		'dbcollat' => 'utf8_general_ci',
		'swap_pre' => '',
		'autoinit' => TRUE,
		'stricton' => FALSE,
	),
	'1' => array(
		'hostname' => 'localhost',
		'table_count' => 10, // 分表数
		'username' => 'root',
		'password' => 'root',
		'dbdriver' => 'mysql',
		'dbprefix' => '',
		'pconnect' => FALSE,
		'db_debug' => TRUE,
		'cache_on' => FALSE,
		'cachedir' => FALSE,
		'char_set' => 'utf8',
		'dbcollat' => 'utf8_general_ci',
		'swap_pre' => '',
		'autoinit' => TRUE,
		'stricton' => FALSE,
	),
);