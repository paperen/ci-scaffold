<?php

/**
 * 调试类
 * @author 梁子恩
 * @version 0.0
 * @package njsystem
 * @subpackage application/libraries
 */
class Debug
{
	private $_CI;
	private $_is_ajax;
	function __construct() {
		$this->_CI =& get_instance();
		$this->_is_ajax = $this->_CI->input->is_ajax_request();
	}

	public function profiler() {
		if ( !$this->_is_ajax )	$this->_CI->output->enable_profiler( ( defined('ENVIRONMENT') && ENVIRONMENT == 'development' ) );
	}
}
