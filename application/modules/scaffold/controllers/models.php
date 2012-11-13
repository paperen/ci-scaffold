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
		return file_exists( APPPATH . $path );
	}

	/**
	 * 生成已选表模型
	 * @param array $table_selected 已选的表
	 */
	private function _generate_models( $table_selected ) {
		// 过滤非法的表
		$table_fileter = array( );
		foreach ( $table_selected as $table ) {
			if ( in_array( $table, $this->_tables ) ) $table_fileter[] = $table;
		}
		unset( $table_selected );

		$patterns = array(
			'/\{modelname\}/',
			'/\{tablename}/',
			'/\{pk}/',
			'/\{fields}/',
		);

		if ( empty( $table_fileter ) ) return FALSE;
		foreach ( $table_fileter as $table ) {
			// 获取表的所有字段
			$fields_arr = $this->db->list_fields( $table );

			// @todo 更智能与准确地获取主键
			$pk = $fields_arr[0];
			$modelname = ucwords( $table );
			$fields = "'" . implode( "','", $fields_arr ) . "'";
			$replacement = array(
				$modelname,
				$table,
				$pk,
				$fields,
			);

			$string = preg_replace( $patterns, $replacement, $this->_template() );
			// 生成模型文件
			$this->_write_to_model( $table, $string );
		}
	}

	/**
	 * 将字符串写入到相应的模型
	 * @param string $tablename 表名
	 * @param string $str 字符串
	 * @return string 模型文件
	 * @todo
	 */
	private function _write_to_model( $tablename, $str ) {

	}

	/**
	 * 提交处理
	 * @param array $data
	 * @throws Exception
	 */
	private function _submit( &$data ) {
		try {
			$post_data = $this->_post_data();
			$data['post_data'] = $post_data;

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

	private function _template() {
		return
				<<<EOT
<?php

class {modelname}_model extends MY_model
{
	protected \$_table_name = '{tablename}';
	protected \$_pk = '{pk}';
	protected \$_fields = array(
		{fields}
	);
}
EOT;
	}

}