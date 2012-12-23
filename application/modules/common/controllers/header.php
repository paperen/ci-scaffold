<?php

/**
 * 公共模块——顶部
 * @package application
 * @subpackage application/modules/common/controllers
 * @author
 */
class Common_Header_Module extends CI_Module
{

	public function index() {
		$data = array( );
		$this->load->view( 'header', $data );
	}

	/**
	 * 设置页面标题
	 * 仅供hooks调用
	 * @param string $title
	 * @return
	 */
	public function _set_pagetitle( $title = '' ) {
		echo ( $title ) ? $title . ' &raquo; ' . config_item( 'app_name' ) : config_item( 'app_name' );
	}

}