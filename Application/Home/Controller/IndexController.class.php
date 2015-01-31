<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

	public function __construct(){
                        parent::__construct();
                        //检验登录状态
                        $Common = D('Common');
                        if(!$Common->isLogin()){
                            redirect(U('User/login'));
                        }
            }
    	public function index(){
    		
		$this->show();
    	}
	
    	public function createForm(){
	
    	}
}