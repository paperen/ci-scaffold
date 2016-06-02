# 针对CI模型的分库分表扩展

就CI在对于一些分库分表这块并没有支持而做的扩展

涉及以下文件

* application/libraries/MY_Profiler.php （仅仅为了支持在调试模式的SQL日志输出而重写了_compile_queries方法）
* application/core/MY_Model.php

---------------------

## 使用情景描述

在一些大型项目中可以会遇到DB将某些会出现大量数据的表拆分到多个表甚至是多个数据库中多个表

比如：用户数据

在单库单表的情况下只使用user表存放数据

	uid——username——email——password

但随着数据量增加后续会采取分表存放数据比如创建多个表，user0,user1,user2,user3，而同时有一个主表user_index记录用户的id与username，user_index作为用户的一个索引

	uid——username
	1——paperen
	2——paperen3
	3——paperen4

关于这三个用户的详细信息是分散到不同表存储的，如何知道是哪个表，则使用求余的方法
公式为：uid%4
通用公式为：id%(分表总数)

那对于paperen4这个用户他的详细数据是放在3%4=3，也就是user3表里面

## CI扩展分表使用例子

先在本地建立三个数据库，分别是test、user_db0、user_db1，db目录下分别有这三个数据库的SQL，创建数据库后直接分别在各个库执行对应的SQL

### 配置数据库信息
* application/config/app.php 中的 $config['dist']

	// 分库分表配
	$config['dist']['user_table'] = array(
		'0' => array(
			'hostname' => '数据库地址',
			'table_count' => 10, // 分表数
			'username' => '数据库帐号',
			'password' => '数据库密码',
			'dbdriver' => 'mysql',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => TRUE,
			'cache_on' => FALSE,
			'cachedir' => FALSE,
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'autoinit' => TRUE,
			'stricton' => FALSE,
		),
	);

这个例子演示的是拆分为10个表，table_count这个配置，其他配置跟database.php里面的配置是一样的，按需调整即可

* 建立模型

user_index.php 与 user_table.php,需要说明的是user_table.php中需要定义两个变量分别是 _dist_table_prefix 与 _dist_config_key

*_dist_table_prefix* 为分表的表前缀是什么，这里是user_table
*_dist_config_key* 为告诉该分表使用的db配置是哪个，这里也是user_table
*_dist_db_prefix* 对于分库才有用的，一般来说默认按配置里面填写的数据库名称，不过如果打算数据库是有规律的，比如：user0,user1..之类可以在配置时缺省database参数，而这里设置数据库前缀为user，会自动按规则匹配相应数据库

* 创建控制器测试

就使用自带的welcome来写点代码测试下

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
	
然后访问这个方法，会看到底下的SQL日志

	0.0010  	INSERT INTO `user_index` (`username`) VALUES ('paperen') 
	0.0000  	INSERT INTO `user_table2` (`username`, `email`, `password`, `id`) VALUES ('paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 152) 
	0.0000  	SELECT `id`, `username`, `email`, `password`
				FROM (`user_table2`)
				WHERE `id` =  152


## CI扩展分库分表使用例子

同样是使用上面创建的三个数据库作为测试前提

配置增加多一个数据库配置

	// 分库分表配
	$config['dist']['user_table'] = array(
		'0' => array(
			'database' => 'user_db',
			'hostname' => 'localhost',
			'table_count' => 10, // 分表数
			'username' => 'root',
			'password' => 'root',
			'dbdriver' => 'mysql',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => TRUE,
			'cache_on' => FALSE,
			'cachedir' => FALSE,
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'autoinit' => TRUE,
			'stricton' => FALSE,
		),
		'1' => array(
			'database' => 'user_db0',
			'hostname' => 'localhost',
			'table_count' => 10, // 分表数
			'username' => 'root',
			'password' => 'root',
			'dbdriver' => 'mysql',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => TRUE,
			'cache_on' => FALSE,
			'cachedir' => FALSE,
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'autoinit' => TRUE,
			'stricton' => FALSE,
		),
	);
	
其他一切不变，再次访问welcome控制器,查看SQL日志

	数据库:  test   查询: 1  (隐藏)
	0.0000  	INSERT INTO `user_index` (`username`) VALUES ('paperen') 
	数据库:  user_db0   查询: 1  (隐藏)
	0.0020  	INSERT INTO `user_table5` (`username`, `email`, `password`, `id`) VALUES ('paperen', 'paperen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 5) 
	数据库:  user_db0   查询: 1  (隐藏)
	0.0010  	SELECT `id`, `username`, `email`, `password`
				FROM (`user_table5`)
				WHERE `id` =  5 
				

可以使用扩展后那种操作模型的简易方法来写以上代码

	$id = $this->model_user_index_insert(array('username'=>$userdata['username']));
	
	$userdata['id'] = $id;
	$this->model_user_table_dist(TRUE)->insert($userdata);

	print_r($this->model_user_table_dist(TRUE)->get_by_pk($id));	