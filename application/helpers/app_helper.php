<?php
/**
 * 应用函数库
 * @version 0.0
 * @package application
 * @subpackage application/helpers
 */

/**
 * 生成模块URL
 * @param string $uri URI
 * @return string
 */
function module_url( $uri = '' ) {
	return ( $uri ) ? base_url( "module/{$uri}" ) : base_url();
}

/**
 * 初始化消息框
 * @param string $content 消息内容
 * @param string $type 类型（参照bootstrap定义alert类型）
 * @param int $code 消息代码
 * @param string $redirect_url 重定向URL
 * @param string $title 标题（默认系统提示）
 * @param string $extra 额外数据
 */
function init_messagebox( $content, $type = 'success', $code = 1, $redirect_url = '', $title = '系统提示', $extra = '' ) {
	$CI = & get_instance();
	$config = array(
		'title' => $title,
		'content' => $content,
		'type' => $type,
		'code' => $code,
		'redirect_url' => $redirect_url,
		'extra' => $extra,
	);
	$CI->hooks->_register( 'messagebox', array(
		'class' => 'Common_Messagebox_Module',
		'function' => 'render',
		'filename' => 'messagebox.php',
		'filepath' => 'modules/common/controllers',
		'params' => $config,
	) );
}

/**
 * 获取消息框
 */
function get_messagebox() {
	// call
	$CI = & get_instance();
	$CI->hooks->_call_hook( 'messagebox' );
}

/**
 * 引用JS
 * @param string $js JS文件
 * @return string
 */
function js( $js ) {
	$is_relative = ( strpos( $js, 'http' ) === FALSE );
	if ( $is_relative ) $js = base_url( $js );
	return "<script type=\"text/javascript\" src=\"{$js}\"></script>";
}

/**
 * 引用CSS
 * @param string $css CSS文件
 * @param string $theme 主题
 * @return string
 */
function css( $css, $theme = '' ) {
	$is_relative = ( strpos( $css, 'http' ) === FALSE );
	// CSS
	// 当前主题
	if ( $is_relative ) {
		$current_theme = ( $theme ) ? $theme : config_item( 'theme' );
		$css = base_url( "theme/{$current_theme}/{$css}" );
	}
	return "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$css}\" media=\"all\" />";
}

/**
 * 将unix时间戳形式转化成时间日期格式
 * @param int $timestamp unix格式时间戳需要转换的时间
 * @param string $format 需要转换成的格式 如：‘Y-m-d’;默认为'Y-m-d H:i:s';
 * @param string $str_time
 * @return
 */
function init_date( $timestamp, $format = 'Y-m-d H:i:s', $str_time = null ) {
	$time = $str_time ? strtotime( $str_time ) : time();
	$time = $timestamp ? $timestamp : $time;
	return date( $format, $time );
}

/**
 * 获取相应模型某个字段的描述
 * @param string $model 模型
 * @param string $field 字段
 * @return string
 */
function get_field( $model, $field = '' ) {
	$CI =& get_instance();
	$CI->load->model( $model );
	return $CI->$model->get_field( $field );
}

/**
 * 获取语言包指定字段
 * @param string $line
 * @param string $package 包
 */
function get_lang( $line, $package = 'app' ) {
	$CI =& get_instance();
	$CI->lang->load( $package );
	$line = $package . '_' . $line;
	return $CI->lang->line($line);
}

/**
 * 获取页面标题
 */
function get_pagetitle() {
	$CI =& get_instance();
	$CI->hooks->_call_hook( 'pagetitle' );
}