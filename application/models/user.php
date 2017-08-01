<?php
/**
 * user模型
 * @author
 * @version 1.0
 * @package application/
 * @subpackage application/models
 */
class User extends MY_model
{
	protected $_table_name = 'user';
	protected $_pk = 'id';
	protected $_fields = array (
  'id' => 'id',
  'username' => ' 帐号',
  'password' => '密码',
  'ctime' => '创建时间',
);
}