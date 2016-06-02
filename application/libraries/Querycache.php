<?php

/**
 * 作為查詢緩存，避免不同模塊執行相同SQL導致性能下降一個組件
 * 依賴于CI模型
 * @author paperen
 */
class Querycache
{

	private $_CI;
	private $_cache;
	private $_redis;

	function __construct()
	{
		$this->_CI = & get_instance();
		if ( config_item( 'redis' ) ) {
			$this->_CI->load->library('redis');
			$this->_redis =& $this->_CI->redis;
		}
	}

	/**
	 * 直接執行模型操作
	 * @param string $model_name 模型名
	 * @param string $method 方法
	 * @param mixed $args 參數
	 * @return mixed
	 */
	public function execute( $model, $method, $args )
	{
		$model_name = "{$model}_model";
		if ( !isset( $this->_CI->$model_name ) ) $this->_CI->load->model( $model_name );
		return call_user_func_array( array( $this->_CI->$model_name, $method ), $args );
	}

	/**
	 * 用于作为redis的tag
	 * @var string
	 */
	private $_redis_tag;
	public function tag( $tag ) {
		$this->_redis_tag = $tag;
		return $this;
	}

	/**
	 * 删除redis里面指定的tag
	 * @param string $tag
	 */
	public function unset_tag( $tag ) {
		if ( config_item( 'redis' ) && $tag ) $this->_redis->del(array($tag));
	}

	/**
	 *
	 * @param string $model 模型名(不需要加_model)
	 * @param string $method 方法
	 * @return mixed
	 */
	public function get( $model, $method )
	{
		// 获取参数数据
		$args = func_get_args();
		$model_and_method = array_shift( $args ) . '_' . array_shift( $args );

		// 索引
		$hash = md5("{$model_and_method}_" . serialize( $args ));

		// 存在缓存直接返回
		if ( isset( $this->_cache[$hash] ) ) return $this->_cache[$hash];
		if ( config_item( 'redis' ) && $this->_redis_tag ) {
			$redis_data = @unserialize($this->_redis->get($this->_redis_tag));
			if ( $redis_data ) {
				$this->_redis_tag = NULL;
				return $redis_data;
			}
		}

		// 通过模型获取数据
		$result = $this->execute( $model, $method, $args, TRUE );

		// 缓存起来
		$this->_cache[$hash] = $result;
		if ( config_item( 'redis' ) && $this->_redis_tag && $result ) $this->_redis->set($this->_redis_tag, @serialize($result));
		$this->_redis_tag = NULL;

		return $result;
	}

}

// end of Querycache