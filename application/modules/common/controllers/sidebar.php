<?php

/**
 * 公共模块——边栏
 * @package application
 * @subpackage application/modules/common/controllers
 * @author
 */
class Common_Sidebar_Module extends CI_Module
{

	public function index() {
		$data = array( );
		$this->load->view( 'sidebar', $data );
	}

}
