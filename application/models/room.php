<?php
/**
 * room模型
 * @author
 * @version 1.0
 * @package application/
 * @subpackage application/models
 */
class Room extends MY_model
{
	protected $_table_name = 'room';
	protected $_pk = 'id';
	protected $_fields = array (
  'id' => '',
  'room' => '宴厅',
  'position' => '位置',
  'ctime' => '创建时间',
);
}