<?php

/**
 * 公共模块——底部
 * @package application
 * @subpackage application/modules/common/controllers
 * @author
 */
class Common_Footer_Module extends CI_Module
{
	public function index() {
		$data = array();
		$this->load->view('footer', $data);
	}
}
