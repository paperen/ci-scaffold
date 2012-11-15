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
	private $_models_path;

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
	 * 生成文件夹结构
	 * @param string $path
	 * @return bool
	 */
	private function _create_path( $path ) {
		$model_ab_path = dirname( BASEPATH ) . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;
		if ( !is_dir( $model_ab_path ) ) mkdir( $model_ab_path, DIR_WRITE_MODE );

		if ( !is_really_writable( $path ) ) throw new Exception( "{$path}路径不可写" );

		$this->_models_path = $model_ab_path;
	}

	/**
	 * 生成已选表模型
	 * @param string $models_path 模型存放路径
	 * @param array $table_selected 已选的表
	 * @return array 已生成的表名数组
	 */
	private function _generate_models( $models_path, $table_selected ) {

		$apppath = APPPATH;
		$subpath = APPPATH . $models_path;

		$created_models = array( );

		// 过滤非法的表
		$table_fileter = array( );
		foreach ( $table_selected as $table ) {
			if ( in_array( $table, $this->_tables ) ) $table_fileter[] = $table;
		}
		unset( $table_selected );

		$patterns = array(
			'/\{tablename\}/',
			'/\{apppath\}/',
			'/\{subpath\}/',
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
				$table,
				$apppath,
				$subpath,
				$modelname,
				$table,
				$pk,
				$fields,
			);

			$string = preg_replace( $patterns, $replacement, $this->_template() );

			// 生成模型文件
			if ( $this->_write_to_file( $table, $string ) ) $created_models[] = $table;
		}

		return $created_models;
	}

	/**
	 * 将字符串写入到相应的模型
	 * @param string $tablename 表名
	 * @param string $str 字符串
	 * @return string 模型文件
	 */
	private function _write_to_file( $tablename, $str ) {

		$filename = $this->_models_path . "{$tablename}_model.php";
		// 文件存在的话不写入
		if ( file_exists( $filename ) ) return FALSE;

		$handle = fopen( $filename, FOPEN_WRITE_CREATE_DESTRUCTIVE );
		$len = fwrite( $handle, $str );
		fclose( $handle );

		return $len;
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

			// 生成路径
			$this->_create_path( APPPATH . $post_data['path'] );

			// 生成模型
			$create_models = $this->_generate_models( $post_data['path'], $post_data['table_selected'] );

			if ( empty( $create_models ) ) throw new Exception( '没有生成任何模型' );

			$resutl = '生成完成 已生成模型：' . implode( ',', $create_models );
			throw new Exception( $resutl );
		} catch ( Exception $e ) {
			$data['tip'] = $e->getMessage();
		}
	}

	private function _template() {
		return
				<<<EOT
<?php
/**
 * {tablename}模型
 * @author
 * @version 1.0
 * @package {apppath}
 * @subpackage {subpath}
 */
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