<?php
class User_table extends MY_Model
{
	protected $_pk = 'id';
	protected $_fields = array(
		'id' => '',
		'username' => '',
		'email' => '',
		'password' => '',
	);
	// 分表表名前缀
	protected $_dist_table_prefix = 'user_table';
	// 
	protected $_dist_db_prefix = 'user_db';
	protected $_dist_config_key = 'user_table';
}