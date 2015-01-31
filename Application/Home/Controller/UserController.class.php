<?php
    namespace Home\Controller;
    use Think\Controller;
    class UserController extends Controller{
    	public function __initialize(){
    		//初始化函数
    	}

    	public function index(){
                $this->display();
    	}

    	public function login(){
    		//测试用，登录状态
    		if(!isset($_SESSION)){
    			session_start();
    		}
    		$_SESSION['login_uid'] = 1;
    		$_SESSION['login_username'] = 'ta_shuo';
    		$this->success('登录成功', U('Vote/index'));
                        // $this->display();
    	}

    	public function logout(){
    		$_SESSION = array();
    		session_destroy();
    		$this->success('退出登录', U('User/index'));
    	}
    }