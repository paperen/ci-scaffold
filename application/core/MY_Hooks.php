<?php

/**
 * 继承CI_Hooks，在其基础上加入了允许动态注册钩子的方法
 * @author 梁子恩
 * @version 0.0
 * @package njsystem
 * @subpackage application/core
 */
class MY_Hooks extends CI_Hooks
{

	/**
	 * override the Hooks Preferences
	 *
	 * @access	private
	 * @return	void
	 */
	function _initialize()
	{
		$CFG =& load_class('Config', 'core');

		// If hooks are not enabled in the config file
		// there is nothing else to do

		if ($CFG->item('enable_hooks') == FALSE)
		{
			return;
		}

		// Grab the "hooks" definition file.
		// If there are no hooks, we're done.

		if (defined('ENVIRONMENT') AND is_file(APPPATH.'config/'.ENVIRONMENT.'/hooks.php'))
		{
		    include(APPPATH.'config/'.ENVIRONMENT.'/hooks.php');
		}
		elseif (is_file(APPPATH.'config/hooks.php'))
		{
			include(APPPATH.'config/hooks.php');
		}

		if ( isset($hook) && is_array($hook) )
		{
			$this->hooks =& $hook;
		}

		$this->enabled = TRUE;
	}

	function _register( $hook_name, $args = array() )
	{
		$this->hooks[$hook_name] = $args;
	}

}

// end of Hook