<?php
return array(
	/*数据库设置*/
	'DB_TYPE' => 'mysql',
	'DB_HOST' => 'localhost',
	'DB_NAME' => 'mama_toupiao',
	'DB_USER' => 'root',
	'DB_PWD' => 'hzc8730672',
	'DB_PORT' => '3306',
	'DB_PREFIX' => '',
	'DB_CHARSET'=> 'utf8',

	'URL_MODEL'             =>  '2', // URL访问模式,可选参数0、1、2、3,代表以下四种模式：0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式

	//默认控制器
	'DEFAULT_CONTROLLER' => 'Vote',

	// 定义错误跳转页面URL地址
	// 'ERROR_PAGE'=> MODULE_PATH.'View/Public/error.html' ,

	//默认开启session
	'SESSION_AUTO_START' => true,

	//项目分为投票，报名，调查三种类型
	'PROJECT_TYPE' => array('vote' 	=>'投票',
				    'register' 	=> '报名',
				    // 'research' 	=> '调查',
				    ),
	//每个投票条目有三种类型：单选框，多选框，文本域
	'VOTE_OPTION_TYPE' => array('radio' 	=> '单选框',
				    'checkbox' 	=> '多选框',
				    'textarea' 	=> '文本域',
				    ),

	//每个报名条目有5种类型
	'REGISTER_OPTION_TYPE' =>array('radio' => '单选框',
					        'checkbox' => '多选框',
					        'text' => '单行文本(或数字)',
					        'textarea' => '多行文本',
					        ),

	//投票规则
	'VOTE_RULE' => array('uid' 		=> '每个uid只能投一票',
				'ip' 		=> '每个ip只能投一票',
				'uid_day' 	=> '每个uid每天只能投一票',
				'ip_day' 	=>'每个ip每天只能投一票',
				'uid_ip_day' 	=>'每个uid同一ip每天只能投一票',
				'none'		=>'无限制',
				),
	);