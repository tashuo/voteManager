<?php
    namespace Home\Controller;
    use Think\Controller;
    class RegisterController extends Controller{
            public function __construct(){
                        parent::__construct();
                        //检验登录状态
                        $Common = D('Common');
                        if(!$Common->isLogin()){
                            redirect(U('User/login'));
                        }
            }

            public function index(){
                            $this->assign('registerClass','active');
                            $this->assign('listClass', 'active');
    
                            $count = M('Project')->where('type = 2 AND del = 0')->count();
                            $Page = new \Think\Page($count, 15);
                            $show = $Page->show();
    
                            $list = M('Project')->where('type = 2 AND del = 0')->order('dateline DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
    
                            $this->assign('registerList', $list);
                            $this->assign('page', $show);
                            $this->display();
            }
    
            public function add(){
                            $this->assign('registerClass', 'active');
                            $this->assign('addClass', 'active');
                            $this->assign('optionType', C('REGISTER_OPTION_TYPE'));
                            $this->display();
            }
    
            public function edit(){
                            $this->assign('registerClass', 'active');
                            $this->assign('editClass', 'active');
                            $this->assign('optionType', C('REGISTER_OPTION_TYPE'));
                            $data = array();
    
                            $registerId = I('get.pid');
                            $registerInfo = M('Project')->where('id = '.$registerId)->find();
                            $registerOptions = M('ProjectFields')->where('pid = '.$registerId)->find();
                            $this->assign('optonsCount', $registerOptions['options_count']);
                            
                            $registerOptions = json_decode($registerOptions['options']);
    
                            //为什么这里用引用会出错
                            // foreach($registerOptions as &$val){
                            //     $val = get_object_vars($val);
                            // }
                            foreach($registerOptions as $key => $val){
                                $registerOptions[$key] = get_object_vars($val);
                                $registerOptions[$key]['option_count'] = count($registerOptions[$key]['options']);
                            }
    
                            $data['registerInfo'] = $registerInfo;
                            $data['registerOptions'] = $registerOptions;
    
                            $this->assign('registerId', $registerId);
                            $this->assign('registerData', $data);
    
                            // dump($data);exit;
                            $this->display();
            }
    
            public function delete(){
                            $vid = I('post.pId');
                            $retId = M('Project')->where('id = '.$vid)->setField('del', 1);
                            if($retId == 1){
                                $this->ajaxReturn(array('status'=>1,'data'=>'删除成功'));
                            }else{
                                $this->ajaxReturn(array('status'=>0,'data'=>'删除失败'));
                            }
    
            }

            /*
            *   function: result
            *    报名结果function
            */
            public function result(){
                        $registerId = I('get.proId')?I('get.proId'):0;
                        $registerInfo = D('Project')->getProjectInfo($registerId);
                        
                        //获取此项目的所有报名数据,并且将数组数据转换为字符串
                        $eachAction = M('ProjectEachAction')->where('pid = '.$registerId)->select();
                        $len = count($eachAction);
                        $pages = 15; //每页显示数目
                        //分页
                        $Page = new \Think\Page($len, $pages);
                        $show = $Page->show();
                        $eachAction = M('ProjectEachAction')->where('pid = '.$registerId)->limit($Page->firstRow.','.$Page->listRows)->select();

                        for($i = 0; $i < $pages; $i++){
                            if(empty($eachAction[$i]))
                                break;
                            $eachAction[$i]['action'] = json_decode($eachAction[$i]['action']);
                            foreach($eachAction[$i]['action'] as $key => $val){
                                if(is_array($val)){
                                    $eachAction[$i]['action'][$key] = implode(',', $val);
                                }
                            }
                        }

                        //项目选项及其子选项
                        $registerOptions = M('ProjectFields')->where('pid = '.$registerId)->find();
                        $items = array_map('get_object_vars',json_decode($registerOptions['options']));

                        $this->assign('registerClass', 'active');
                        $this->assign('resultClass', 'active');
                        $this->assign('registerInfo', $registerInfo);
                        $this->assign('items', $items);
                        $this->assign('eachAction', $eachAction);
                        $this->assign('totalRegister', $len);
                        $this->assign('page', $show);
                        $this->display();

            }
    }