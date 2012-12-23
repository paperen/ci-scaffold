<?php

/**
 * 消息框模块
 * @version 0.0
 * @package application
 * @subpackage application/modules/common/controllers
 */
class Common_Messagebox_Module extends CI_Module
{

	// JS重定向定时（默认4秒）

	const TIMEOUT = 4;

	/**
	 * 初始化消息框
	 * @param array $content 配置数据
	 */
	public function render( $config ) {
		if ( $config['redirect_url'] ) $config['content'] .= ' <strong>' . self::TIMEOUT . '</strong>' . get_lang( 'auto_redirect' );
		if ( substr( $config['content'], 0, 3 ) !== '<p>' ) $config['content'] = '<p>' . $config['content'] . '</p>';
		$this->load->view( 'messagebox', $config );
	}

}