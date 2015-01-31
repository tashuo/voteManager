<?php
    namespace Home\Controller;
    use Think\Controller;
    class ShowController extends Controller{
    	public function index(){
    		$proId = I('get.proId')?I('get.proId'):0;
    		$proInfo = M('Project')->where('id = '.$proId)->find();
                        if(!$proInfo){
                            $this->error('该投票项目不存在', 'http://mama.cn');
                        }

                        //是否删除,是否需要登录
                        if($proInfo['del'] == 1){
                            $this->error('该投票项目已经被删除', 'http://mama.cn');
                        }
                        if($proInfo['login_require'] ==1 && !session('login_uid')){
                            $this->error('登录后才可查看', U('User/index'));
                        }

    		$proOptions = M('ProjectFields')->where('pid = '.$proId)->find();
    		//选项及其子选项
    		$items = json_decode($proOptions['options']);
    		foreach($items as $key => $val){
                            $items[$key] = get_object_vars($val);
                            $items[$key]['option_count'] = count($items[$key]['options']);
                        }
                        
                        //判断投票项目是否开始或者是否结束或者是否关闭
                        $now = time();
                        $proSign = array();
                        $proSign['notice'] = 0;
                        if(!$proInfo['is_active']){
                            $proSign['notice'] = 1;
                            $proSign['msg'] = '该项目暂时已经关闭，请稍后再查看';
                        }
                        if($now < $proInfo['start_time']){
                            $proSign['notice'] = 2;
                            $proSign['msg'] = '该项目还未开始，距离开始时间还有：';
                            $proSign['timeLong'] = $proInfo['start_time'] - $now;
                        }elseif($now > $proInfo['end_time']){
                            $proSign['notice'] = 3;
                            $proSign['msg'] = '该项目已经结束！';
                        }

                        $this->assign('proSign', $proSign);
                        $this->assign('optionLen', $optionLen);
                        $this->assign('proInfo', $proInfo);
                        $this->assign('items', $items);
    		$this->display();
    	}
    }