<?php

/**
 * 表单验证加入令牌扩展
 * @package njsystem
 * @subpackage application/libraries
 * @version 0.0
 * @author 梁子恩
 */
if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class MY_Form_validation extends CI_Form_validation
{

	public $CI;
	// 调试模式
	private $_debug;

	// token标识符

	const TOKEN_TAG = '<!--__TOKEN__-->';

	// token session键值
	const TOKEN_SESSION = 'token';

	// token 过期时间(分钟)
	const TOKEN_TIMEOUT = 3;

	// 错误定界符
	const ERROR_PERFIX = '<p>';
	const ERROR_SUFFIX = '</p>';

	function __construct() {
		parent::__construct();
		$this->CI = & get_instance();
		$this->CI->load->library( 'session' );

		// 是否调试模式
		$this->_debug = ( defined( 'ENVIRONMENT' ) && ENVIRONMENT == 'development' ) ? TRUE : FALSE;

		// 设置错误定界符
		$this->set_error_delimiters( self::ERROR_PERFIX, self::ERROR_SUFFIX );
	}

	/**
	 * 使用自身的错误定界符封装错误信息
	 * @param string $message 错误信息
	 * @return string 封装后的信息
	 */
	public function wrap_error( $message ) {
		return $this->error_prefix . $message . $this->error_suffix;
	}

	/**
	 * 检查session中是否存在token
	 */
	private function _is_token() {
		return $this->CI->session->userdata( self::TOKEN_SESSION ) ? TRUE : FALSE;
	}

	/**
	 * 判断令牌是否正确
	 * @return bool 正确true/不正确false
	 */
	function check_token() {
		// 调试模式
		if ( $this->_debug ) return TRUE;

		// 判断是否存在token
		if ( $this->_is_token() ) {
			$now = time();
			$timeout = self::TOKEN_TIMEOUT * 60;
			$token = $this->get_token();
			if ( $token && $this->CI->input->post( self::TOKEN_SESSION ) == md5( $token ) ) {
				// 销毁掉
				$this->destroy_token();

				// 没时间限制
				if ( $timeout == 0 ) return TRUE;
				return ($now - $token) < $timeout;
			}
		}

		// 销毁掉
		$this->destroy_token();
		return FALSE;
	}

	/**
	 * 设置token值
	 * @param string
	 */
	public function set_token( $value ) {
		$this->CI->session->set_userdata( self::TOKEN_SESSION, $value );
	}

	/**
	 * 获取token值
	 * @return string
	 */
	public function get_token() {
		return $this->CI->session->userdata( self::TOKEN_SESSION );
	}

	/**
	 * 销毁存在session的token值
	 */
	public function destroy_token() {
		$this->CI->session->unset_userdata( self::TOKEN_SESSION );
	}

	/**
	 * 判断是否是日期格式
	 * @param string $str
	 */
	public function is_date( $str ) {
		return (bool)preg_match( '/\d{4}\-\d{1,2}\-\d{1,2}/', $str );
	}

	/**
	 * 生成令牌
	 */
	public function create_token() {
		$output = $this->CI->output->get_output();
		// 是否存在令牌标识符
		if ( strpos( $output, self::TOKEN_TAG ) !== FALSE ) {
			// 生成并设置令牌
			$time = time();
			$this->set_token( $time );

			// 生成input
			$name = self::TOKEN_SESSION;
			$value = md5( $time );
			$token_html = "<input type=\"hidden\" name=\"{$name}\" value=\"{$value}\">";
			$output = str_replace( self::TOKEN_TAG, $token_html, $output );
		}
		$this->CI->output->set_output( $output );
	}

	public function chinese_char( $str ) {
		return ( preg_match( '/^([\x0391-\xFFE5]+|[A-Za-z0-9]+)$/', $str ) ) ? TRUE : FALSE;
	}

	/**
	 * 判断是否是手机号码正则
	 * @param type $str
	 * @return type
	 */
	public function is_phone( $str ) {
		return ( preg_match( "/^((\(\d{2,3}\))|(\d{3}\-))?13\d{9}$/", $str ) ) ? TRUE : FALSE;
	}

	public function currenttime( $str ) {
		return time();
	}

}