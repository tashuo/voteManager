<?php
namespace Home\Model;
use Think\Model;

/**
 * 用户数据
 */
class CommonModel extends Model {

	/*
	* 获取用户信息，参数 str 用户名
	*/
	public function getUserInfoByUsername($username){
		return $this->table('admin')->field()->where("username = '%s'",$username)->find();
	}

	/*
	*test 用户登录检测
	*/
	public function isLogin(){
		return session('login_uid');
	}

	/**
	 * 获取当前登录用户信息
	 * @param brandId 品牌ID
	 * @return array 返回当前登录用户信息
	 */
	public function getLoginUserInfo($brandId) {
		if($this->isLogin()){
			return array('uid' => session('login_uid'),
				        'username' => session('login_username'),
				        );
		}
	}
}
