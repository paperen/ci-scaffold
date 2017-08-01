<?php

/**
 * 脚手架模块——引导
 * @author paperen<paperen@gmail.com>
 * @link iamlze.cn
 * @package application
 * @subpackage application/modules/common/controllers
 */
class Scaffold_Index_Module extends CI_Module
{

	const PRI = 'PRI';
	const UNI = 'UNI';
	const MUL = 'MUL';

	private $_default_models_path = 'models';
	private $_default_modules_path = 'modules';
	private $_tables;
	private $_model_path;
	private $_module_path;
	private $_template_path;

	function __construct() {
		parent::__construct();

		$this->_template_path = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'views/tpl/';

		$this->_tables = $this->db->list_tables();
	}

	public function index() {
		$data = array( );

		$data['app_path'] = APPPATH;
		$data['model_path'] = $this->_default_models_path;
		$data['module_path'] = $this->_default_modules_path;
		$data['tables_data'] = $this->_tables;

		if ( $this->input->post( 'submit_btn' ) ) {
			$this->_submit( $data );
		}

		$this->load->view( 'index', $data );
	}

	/**
	 * 收集表单数据
	 * @return array
	 */
	private function _post_data() {
		$model_path = $this->input->post( 'model_path' );
		$module_path = $this->input->post( 'module_path' );
		if ( empty( $model_path ) ) $model_path = 'models';
		if ( empty( $module_path ) ) $module_path = 'modules';
		return array(
			'model_path' => $model_path,
			'module_path' => $module_path,
			'table_selected' => $this->input->post( 'tables' ),
		);
	}

	/**
	 * 生成文件夹结构
	 * @param string $path
	 * @return string
	 */
	private function _create_path( $path ) {
		$path = dirname( BASEPATH ) . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;
		if ( !is_dir( $path ) ) mkdir( $path, DIR_WRITE_MODE );

		if ( !is_really_writable( $path ) ) throw new Exception( "{$path}路径不可写" );
		return $path;
	}

	/**
	 * 生成指定的模块
	 * @param string $modules_path
	 * @param array $table_selected
	 * @return array 已生成的模块数组
	 */
	private function _generate_modules( $modules_path, $table_selected ) {

		$result = array();

		$apppath = APPPATH;
		$subpath = APPPATH . $modules_path;

		$create_modules = array( );

		// 过滤非法的表
		$table_fileter = array( );
		foreach ( $table_selected as $table ) {
			if ( in_array( $table, $this->_tables ) ) $table_fileter[] = $table;
		}
		unset( $table_selected );

		// 生成结构
		$controller_folder = 'controllers' . DIRECTORY_SEPARATOR;
		$view_folder = 'views' . DIRECTORY_SEPARATOR;

		// 生成的控制器名称
		$controller_files = array(
			'main',
		);
		$controller_patterns = array(
			'/\{module}/',
			'/\{module_upper}/',
		);
		// 生成的视图文件名称
		$views_files = array(
			'list',
			'form',
			'view',
			'delete',
		);

		foreach ( $table_fileter as $table ) {
			$module_path = $subpath . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR;
			$module_controller_path = $module_path . $controller_folder;
			$module_view_path = $module_path . $view_folder;

			$this->_create_path( $module_path );
			$this->_create_path( $module_controller_path );
			$this->_create_path( $module_view_path );

			$fields_arr = array( );
			$query = $this->db->query( "SHOW FULL FIELDS FROM `{$table}`" );
			foreach ( $query->result_array() as $single )
				$fields_arr[] = $single;

			$controller_replacement = array(
				$table,
				ucwords( $table ),
			);

			// 生成控制器
			foreach ( $controller_files as $single ) {
				$main_template = @include( $this->_template_path . "controllers_{$single}" . EXT );

				$main_content = preg_replace( $controller_patterns, $controller_replacement, $main_template );
				$this->_write_to_file( $module_controller_path . $single . EXT, $main_content );
			}

			// 生成各个view
			foreach ( $views_files as $single ) {
				$view_content = $this->_get_view_content( $table, $fields_arr, $single );
				$this->_write_to_file( $module_view_path . $single . EXT, $view_content );
			}

			$result[] = $table;
		}
		return $result;
	}

	/**
	 * 获取view内容
	 * @param string $table 表名
	 * @param array $fields_arr 表字段属性
	 * @param string $view 视图名称
	 * @return string
	 */
	private function _get_view_content( $table, $fields_arr, $view ) {
		$view_template = @include( $this->_template_path . "views_{$view}" . EXT );
		if ( $view == 'delete' ) {
			// 删除
		} else if ( $view == 'view' ) {
			// 详细
			$tr_data = '';
			foreach ( $fields_arr as $field ) {
				if ( $field['Key'] != self::PRI ) {
					$tr_data .= <<<EOT
	<tr>
		<th width=\"15%\"><?php echo get_field( '{table}', '{$field['Field']}' ); ?></th><td><?php echo \$item_data['{$field['Field']}']; ?></td>
	</tr>\n\r
EOT;
				}
			}
			$view_template = str_replace( '{tr_data}', $tr_data, $view_template );
		} else if ( $view == 'form' ) {
			// 表单
			$control_data = '';
			foreach ( $fields_arr as $field ) {
				if ( $field['Key'] != self::PRI ) {
					$control_data .= <<<EOT
	<div class="control-group">
		<label class="control-label" for="{$field['Field']}">{$field['Field']}</label>
		<div class="controls">
			<input type="text" id="{$field['Field']}" name="{$field['Field']}" placeholder="<?php echo get_field( '{table}', '{$field['Field']}' ); ?>" value="<?php echo isset( \$item_data['{$field['Field']}'] ) ? \$item_data['{$field['Field']}'] : ''; ?>">
		</div>
	</div>\n\r
EOT;
				}
			}
			// 获取primary key
			$pk = $this->_get_pk( $fields_arr );
			$view_template = str_replace( '{control_data}', $control_data, $view_template );
			$view_template = str_replace( '{pk}', $pk, $view_template );
		} else if ( $view == 'list' ) {
			// 列表
			$th_data = $td_data = '';
			$td_num = 0;
			foreach ( $fields_arr as $field ) {
				if ( $field['Key'] != self::PRI ) {
					$th_data .= "<th><?php echo get_field( '{table}', '{$field['Field']}' ); ?></th>";
					$td_data .= "<td><?php echo \$single['{$field['Field']}']; ?></td>";
					$td_num++;
				}
			}
			// 获取primary key
			$pk = $this->_get_pk( $fields_arr );
			$view_template = str_replace( '{th_data}', $th_data, $view_template );
			$view_template = str_replace( '{td_data}', $td_data, $view_template );
			$view_template = str_replace( '{pk}', $pk, $view_template );
			$view_template = str_replace( '{td_num}', $td_num, $view_template );
		}
		$view_template = str_replace( '{table}', $table, $view_template );
		return $view_template;
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
			$fields_arr = array( );
			$query = $this->db->query( "SHOW FULL FIELDS FROM `{$table}`" );
			foreach ( $query->result_array() as $single )
				$fields_arr[] = $single;

			$fields_attributes = array( );
			foreach ( $fields_arr as $single )
				$fields_attributes[$single['Field']] = $single['Comment'];

			// @todo 更智能与准确地获取主键
			$pk = $this->_get_pk( $fields_arr );
			$modelname = ucwords( $table );
			$fields = var_export( $fields_attributes, TRUE );
			$replacement = array(
				$table,
				$apppath,
				$subpath,
				$modelname,
				$table,
				$pk,
				$fields,
			);

			$string = preg_replace( $patterns, $replacement, $this->_model_template() );

			// 生成模型文件
			if ( $this->_write_to_file( $this->_model_path . $table . EXT, $string ) ) $created_models[] = $table;
		}

		return $created_models;
	}

	/**
	 * 找到primary key
	 * @param array $fields_arr
	 */
	private function _get_pk( $fields_arr ) {
		$pk = NULL;
		$mul_fields = $uni_fields = array( );
		foreach ( $fields_arr as $single ) {
			if ( $single['Key'] == self::PRI ) {
				$pk = $single['Field'];
				return $pk;
			} else if ( $single['Key'] == self::MUL ) {
				$mul_fields[] = $single['Field'];
			} else if ( $single['Key'] == self::UNI ) {
				$uni_fields[] = $single['Field'];
			}
		}
		if ( $pk == NULL ) $pk = isset( $mul_fields[0] ) ? $mul_fields[0] : NULL;
		if ( $pk == NULL ) $pk = isset( $uni_fields[0] ) ? $uni_fields[0] : NULL;
		return $pk;
	}

	/**
	 * 将字符串写入到相应的模型
	 * @param string $path 路径
	 * @param string $tablename 表名
	 * @param string $str 字符串
	 * @return string 模型文件
	 */
	private function _write_to_file( $filename, $str ) {

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

			if ( empty( $post_data['model_path'] ) ) throw new Exception( '模型路径没有定义' );
			if ( empty( $post_data['module_path'] ) ) throw new Exception( '模块路径没有定义' );
			if ( empty( $post_data['table_selected'] ) ) throw new Exception( '没有选择任何表' );

			// 生成路径
			$this->_model_path = $this->_create_path( APPPATH . $post_data['model_path'] );
			$this->_module_path = $this->_create_path( APPPATH . $post_data['module_path'] );

			// 生成模型
			$create_models = $this->_generate_models( $post_data['model_path'], $post_data['table_selected'] );

			$result = NULL;
			if ( empty( $create_models ) ) {
				$result .= '<h3>没有生成任何模型</h3>';
			} else {
				$result .= '<h3>生成完成 已生成模型：' . implode( ',', $create_models ) . '</h3>';
			}

			// 生成模块
			$create_modules = $this->_generate_modules( $post_data['module_path'], $post_data['table_selected'] );
			if ( empty( $create_modules ) ) {
				$result .= '<h3>没有生成任何模块</h3>';
			} else {
				$link_arr = '';
				foreach( $create_modules as $module ) {
					$url = module_url("{$module}/main/index");
					$link_arr[] .= "<a href=\"{$url}\" target=\"_blank\">{$module}</a>";
				}
				$result .= '<h3>生成完成 已生成模块：' . implode( ',', $link_arr ) . '</h3>';
			}

			$this->_generate_menu($create_modules);

			throw new Exception( $result );
		} catch ( Exception $e ) {
			$data['tip'] = $e->getMessage();
		}
	}

	/**
	 * 生成菜单
	 * @param array $create_modules 生成的模块
	 */
	private function _generate_menu($create_modules) {
		if ( empty( $create_modules ) ) return FALSE;

		// 生成菜单
		$menu = "<!--menu-->\n";
		foreach( $create_modules as $module ) {
			$link = module_url("{$module}/main/index");
			$menu .= "<li><a href=\"{$link}\"><i class=\"glyphicon\"></i><span class=\"hidden-xs\">&nbsp;&nbsp;{$module}</span></a></li>\n";
		}
		$menu_view_file = $this->_module_path . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . "views/sidebar.php";
		$content = file_get_contents($menu_view_file);
		$content = str_replace('<!--menu-->', $menu, $content);

		file_put_contents($menu_view_file, $content);
	}

	private function _model_template() {
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
class {modelname} extends MY_model
{
	protected \$_table_name = '{tablename}';
	protected \$_pk = '{pk}';
	protected \$_fields = {fields};
}
EOT;
	}

}