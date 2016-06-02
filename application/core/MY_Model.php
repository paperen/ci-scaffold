<?php

/**
 * 在CI_Model基础上集成一些通用的模型方法
 * @author paperen
 * @version 1.0
 * @package application
 * @subpackage application/core/
 */
class MY_model extends CI_Model
{

	// primary key
	protected $_pk;
	// fileds
	protected $_fields = array( );
	// filed => value
	protected $_data = array( );
	// table name
	protected $_table_name;
	// rules
	protected $_rules;

	protected $_CI;

	function __construct() {
		parent::__construct();
		$this->_CI =& get_instance();
	}

	/**
	 * 初始化表结构 表名必须是小写
	 * @param string $pk 主键
	 * @param array $fields 字段
	 */
	public function _init( $pk, $fields ) {
		$model_name_arr = explode( '_', strtolower( get_class( $this ) ) );
		array_pop( $model_name_arr );
		$this->_table_name = implode( '_', $model_name_arr );
		$this->_pk = $pk;
		$this->_fields = $fields;
	}

	/**
	 * 获取表名
	 * @return string 表名
	 */
	public function _table_name() {
		return $this->_table_name;
	}

	/**
	 * 获得主键的名称
	 * @return string 主键
	 */
	public function _primary_key() {
		return $this->_pk;
	}

	/**
	 * 获得所有字段
	 * @return array 字段
	 */
	public function _fields() {
		return array_keys( $this->_fields );
	}

	/**
	 * 获取某个字段的描述
	 * @param string $key
	 * @return string
	 */
	public function get_field( $key = '' ) {
		return ( $key && isset( $this->_fields[$key] ) ) ? $this->_fields[$key] : $this->_fields;
	}

	/**
	 * 设置数据
	 * @param array $data 数据
	 */
	public function _set_data( $data ) {
		$this->_data = $data;
	}

	/**
	 * 根据字段过滤数据
	 * @param array $data 数据
	 * @param bool $is_pk 是否包含主键
	 * @return array 过滤后的数据
	 */
	public function _filter_data( $data, $is_pk = FALSE ) {
		$filter_data = array( );
		$fields = $this->_fields();
		foreach ( $data as $k => $v ) {
			if ( $is_pk && $this->_primary_key() == $k && !$this->_is_dist ) continue;
			if ( !in_array( $k, $fields ) ) continue;
			$filter_data[$k] = $v;
		}
		return $filter_data;
	}

	/**
	 * 获得数据
	 * @return array 数据
	 */
	public function _get_data() {
		return $this->_data;
	}

	/**
	 * 清空数据
	 */
	public function _clear_data() {
		$this->_data = array( );
	}

	/**
	 * 插入数据
	 * @param array $data 数据
	 * @return int 生成ID
	 */
	public function insert( $data ) {
		if ( empty( $data ) ) return FALSE;
		if ( $this->_is_dist ) {;
			$pk = $this->_primary_key();
			if ( isset($data[$pk]) ) $this->_dist_init($data[$pk]);
		}
		$this->_set_data( $this->_filter_data( $data ) );
		$this->db->insert( $this->_table_name(), $this->_get_data() );
		$this->_clear_data();
		return $this->db->insert_id();
	}

	/**
	 * 插入多行数据
	 * @param array $data
	 * @return int 影响行数
	 */
	public function insert_batch( $data ) {
		if ( empty( $data ) ) return FALSE;
		// not support insert batch
		if ( $this->_is_dist ) return FALSE;

		// @todo more pretty
		foreach ( $data as $single )
			$this->_data[] = $this->_filter_data( $single );

		$this->db->insert_batch( $this->_table_name(), $this->_get_data() );
		$this->_clear_data();
		return $this->db->affected_rows();
	}

	/**
	 * 更新数据
	 * @param array $data 数据
	 * @return int 影响行数
	 */
	public function update( $data ) {

		$pk = $this->_primary_key();

		if ( !isset( $data[$pk] ) ) return FALSE;
		$pk_value = $data[$pk];
		if ( $this->_is_dist ) $this->_dist_init($data[$pk]);

		$this->_set_data( $this->_filter_data( $data, TRUE ) );
		$this->db->where( $pk, $pk_value )->update( $this->_table_name(), $this->_get_data() );
		$this->_clear_data();
		return $this->db->affected_rows();
	}

	/**
	 * 通过主键删除数据
	 * @param int $pk 主键ID
	 * @return int 影响行数
	 */
	public function delete( $pk ) {
		if ( $this->_is_dist ) $this->_dist_init($pk);
		$this->db->where( $this->_primary_key(), $pk )->delete( $this->_table_name() );
		$this->db->affected_rows();
	}

	/**
	 * 通过主键获得单个数据
	 * @param int $pk 主键ID
	 * @return array 数据
	 */
	public function get_by_pk( $pk ) {
		if ( $this->_is_dist ) $this->_dist_init($pk);
		$query = $this->db->select( implode( ',', $this->_fields() ) )
				->from( $this->_table_name() )
				->where( $this->_primary_key(), $pk );
		return $query->get()->row_array();
	}

	/**
	 * 获取所有数据
	 * @param int $limit 每页显示条数
	 * @param int $offset 游标
	 * @return array 数据
	 */
	public function all( $limit = 0, $offset = 0 ) {
		// not support select all
		if ( $this->_is_dist ) return FALSE;
		$query = $this->db->select( implode( ',', $this->_fields() ) )
				->from( $this->_table_name() );
		if ( $limit ) $query->limit( $limit, $offset );
		return $query->order_by( $this->_primary_key(), 'desc' )->get()->result_array();
	}

	/**
	 * 获得总数
	 * @return int 总数
	 */
	public function total() {
		return $this->db->count_all_results( $this->_table_name() );
	}

	private $_is_dist = FALSE;

	/**
	 * 分表表名前缀
	 * @param string
	 */
	protected $_dist_table_prefix;

	/**
	 * 分库库名前缀
	 * @param string
	 */
	protected $_dist_db_prefix;

	/**
	 * 分表配置
	 * @param string
	 */
	protected $_dist_config;

	/**
	 * 分表配置键值
	 * @param string
	 */
	protected $_dist_config_key;

	/**
	 * 标记为分表分库操作
	 */
	public function dist($bool = FALSE) {
		$this->_is_dist = $bool;
		return $this;
	}

	protected function _dist_init($key) {
		if ( empty($this->_dist_config) ) $this->_dist_config = config_item('dist');
		$config = isset($this->_dist_config[$this->_dist_config_key]) ? $this->_dist_config[$this->_dist_config_key] : NULL;
		if ( empty($config) ) exit("read dist config failed.[{$this->_dist_config_key}]");

		// db count
		$db_count = count($config);
		$db_index = $key%$db_count;
		$db_config = $config[$db_index];
		if ( $db_count > 1 && $this->_dist_db_prefix ) {
			$db_config['database'] = "{$this->_dist_db_prefix}{$db_index}";
			$this->db = $this->_CI->load->database($db_config, TRUE);
			$this->_CI->db_ex[] = $this->db;
		}

		// table count
		$table_count = $db_config['table_count'];
		$table_index = $key%$table_count;
		$table_name = "{$this->_dist_table_prefix}{$table_index}";

		$this->_table_name = $table_name;
	}
}