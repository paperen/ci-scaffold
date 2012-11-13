<?php

/**
 * 脚手架模块——模型生成器
 * @author 梁子恩
 * @version 1.0
 * @package application
 * @subpackage application/modules/common/controllers
 */
class Scaffold_Models_Module extends CI_Module
{

	private $_default_models_path = 'models';
	private $_tables;

	function __construct() {
		parent::__construct();

		$this->_tables = $this->db->list_tables();
	}

	public function index() {
		$data = array( );

		$data['app_path'] = APPPATH;
		$data['path'] = $this->_default_models_path;
		$data['tables_data'] = $this->_tables;

		if ( $this->input->post( 'submit_btn' ) ) {
			$this->_submit( $data );
		}

		$this->load->view( 'models', $data );
	}

	/**
	 * 收集表单数据
	 * @return array
	 */
	private function _post_data() {
		return array(
			'path' => $this->input->post( 'path' ),
			'table_selected' => $this->input->post( 'tables' ),
		);
	}

	/**
	 * 验证路径是否存在
	 * @param string $path
	 * @return bool
	 */
	private function _valid_path( $path ) {
		
	}

	/**
	 * 提交处理
	 * @param array $data
	 * @throws Exception
	 */
	private function _submit( &$data ) {
		try {
			$post_data = $this->_post_data();
			$data['path'] = $post_data['path'];

			if ( empty( $post_data['path'] ) ) throw new Exception( '没有选择任何表' );

			if ( empty( $post_data['table_selected'] ) ) throw new Exception( '没有选择任何表' );

			// 检查路径是否正确
			if ( !$this->_valid_path( $post_data['path'] ) ) throw new Exception( '生成路径不存在' );

			// 生成模型
			$this->_generate_models( $post_data['table_selected'] );
			throw new Exception( '生成完成' );
		} catch ( Exception $e ) {
			$data['tip'] = $e->getMessage();
		}
	}

}