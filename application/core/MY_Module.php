<?php

/**
 * 扩展的Module
 * 在原来的基础上对模型调用进行一些优化调整
 * @package		codeigniter
 * @subpackage	core
 * @author		paperen
 */
class MY_Module extends CI_Module
{

	/**
	 * 是否提交
	 * @return bool
	 */
	public function is_submit() {
		return ( $this->input->post( 'is_submit' ) ) ? TRUE : FALSE;
	}

	/**
	 * 通过魔法方法__call
	 * @param string $name
	 * @param array $arguments
	 */
	function __call( $name, $arguments ) {
		$tmp_arr = explode( '_', strtolower( $name ) );
		if ( isset( $tmp_arr[0] ) && array_shift( $tmp_arr ) == 'model' ) return $this->_model( $tmp_arr, $arguments );
	}

	/**
	 * 封装自定义调用模型方法
	 * 实现调用即加载模型的功能 同时增加查询缓存概念
	 * @param array $tmp_arr
	 * @param array $arguments
	 * @return mixed
	 */
	private function _model( $tmp_arr, $arguments ) {

		// 缓存模式
		if ( $tmp_arr[0] == 'cache' ) {
			$model_method = array_shift( $arguments );
			$hash = md5( $model_method . '_' . serialize( $arguments ) );
			$data = $this->querycache->get( $hash );
			if ( empty( $data ) ) {
				$data = call_user_func_array( array( $this, $model_method ), $arguments );
				$this->querycache->save( $hash, $data );
			}
			return $data;
		}

		// 没有声明使用哪个模型
		if ( empty( $tmp_arr ) ) exit( "\$this->{$name} ,model doesn't define" );

		// 没有声明使用哪个方法
		if ( count( $tmp_arr ) == 1 ) exit( "\$this->{$name} ,method doesn't define" );

		// 正常模式
		// 穷举所有可能性
		$possible_couple = array( );
		$length = count( $tmp_arr );
		for ( $i = 0; $i < $length - 1; $i++ ) {
			$possible_couple[] = array(
				'model' => implode( '_', array_slice( $tmp_arr, 0, $i + 1 ) ),
				'method' => implode( '_', array_slice( $tmp_arr, $i + 1 ) ),
			);
		}

		foreach ( $possible_couple as $single ) {
			$model_name = $single['model'];
			$method_name = $single['method'];
			$this->load->model( $model_name );
			if ( !isset( $this->$model_name  ) ) continue;
			if ( !in_array( $method_name, get_class_methods( $this->$model_name ) ) ) continue;
			return call_user_func_array( array( $this->$model_name, $method_name ), $arguments );
		}
		return NULL;
	}

	/**
	 * 设置页面标题
	 * @param string $title 标题
	 */
	public function _set_pagetitle( $title = '' ) {
		// 注册页面标题钩子
		$this->hooks->_register( 'pagetitle', array(
			'class' => 'Common_Header_Module',
			'function' => '_set_pagetitle',
			'filename' => 'header.php',
			'filepath' => 'modules/common/controllers',
			'params' => $title,
		) );
	}

}

// END MY_Module Class

/* End of file MY_Module.php */
/* Location: ./application/core/MY_Module.php */