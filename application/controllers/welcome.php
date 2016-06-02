<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('user_index');
		$this->load->model('user_table');
		
		$userdata = array(
			'username' => 'paperen',
			'email' => 'paperen@gmail.com',
			'password' => md5(123456),
		);
		
		// 只存放用户名到主表
		$id = $this->user_index->insert(array('username'=>$userdata['username']));
		
		// 具体用户数据插入相关的分表	
		$userdata['id'] = $id;
		$this->user_table->dist(TRUE)->insert($userdata);
		
		// 按照id查询用户数据
		$userdata = $this->user_table->dist(TRUE)->get_by_pk($id);
		print_r($userdata);
		
		//$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */