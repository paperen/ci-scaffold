<?php

/**
 * 作為查詢緩存记录器
 * @author paperen
 */
class Querycache
{

	private $_cache;
	
	/**
	 * 根据索引获取缓存数据
	 * @param string $hash 索引
	 * @return mixed
	 */
	public function get( $hash ) {
		return isset( $this->_cache[$hash] ) ? $this->_cache[$hash] : NULL;
	}

	/**
	 * 保存缓存
	 * @param string $hash 索引
	 * @param mixed $data 数据
	 */
	public function save( $hash, $data ) {
		$this->_cache[$hash] = $data;
	}

}

// end of Querycache