<?php
class Test_Main_Module extends MY_Module
{

	public function index() {
		$userdata = array(
			'username' => 'paperen',
			'email' => 'paperen@gmail.com',
			'password' => md5(123456),
		);

		// insert into user_index table
		$id = $this->model_user_index_insert(array('username'=>$userdata['username']));

		$userdata['id'] = $id;
		$this->model_user_table_dist(TRUE)->insert($userdata);

		print_r($this->model_user_table_dist(TRUE)->get_by_pk($id));
	}

}