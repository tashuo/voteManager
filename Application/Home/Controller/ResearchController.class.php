<?php
    namespace Home\Controller;
    use Think\Controller;
    class ResearchController extends Controller{
            public function __construct(){
                        $this->error('此页面暂不可访问', U('Vote/index'));
                        parent::__construct();
                        //检验登录状态
                        $Common = D('Common');
                        if(!$Common->isLogin()){
                            redirect(U('User/login'));
                        }
            }

    	public function index(){
                        $this->assign('researchClass','active');
                        $this->assign('listClass', 'active');

                        $count = M('Project')->where('type = 3 AND del = 0')->count();
                        $Page = new \Think\Page($count, 15);
                        $show = $Page->show();

                        $list = M('Project')->where('type = 3 AND del = 0')->order('dateline DESC')->limit($Page->firstRow.','.$Page->listRows)->select();

                        $this->assign('researchList', $list);
                        $this->assign('page', $show);
    		$this->display();
    	}

    	public function detail(){

    	}

    	public function add(){
                        $this->assign('researchClass', 'active');
                        $this->assign('addClass', 'active');
                        $this->assign('researchRule', C('VOTE_RULE'));
                        $this->assign('optionType', C('OPTION_TYPE'));

                        $this->display();
    	}

    	public function edit(){
                        $this->assign('researchClass', 'active');
                        $this->assign('editClass', 'active');
                        $this->assign('researchRule', C('VOTE_RULE'));
                        $this->assign('optionType', C('OPTION_TYPE'));
                        $data = array();

                        $researchId = I('get.vid');
                        $researchInfo = M('Project')->where('id = '.$researchId)->find();
                        $researchOptions = M('ProjectFields')->where('pid = '.$researchId)->find();
                        $this->assign('optonsCount', $researchOptions['options_count']);
                        
                        $researchOptions = json_decode($researchOptions['options']);

                        //为什么这里用引用会出错
                        // foreach($researchOptions as &$val){
                        //     $val = get_object_vars($val);
                        // }
                        foreach($researchOptions as $key => $val){
                            $researchOptions[$key] = get_object_vars($val);
                            $researchOptions[$key]['option_count'] = count($researchOptions[$key]['options']);
                        }

                        $data['researchInfo'] = $researchInfo;
                        $data['researchOptions'] = $researchOptions;

                        $this->assign('researchId', $researchId);
                        $this->assign('researchData', $data);

                        // dump($data);exit;
                        $this->display();
    	}

    	public function delete(){
                        $vid = I('post.researchId');
                        $retId = M('Project')->where('id = '.$vid)->setField('del', 1);
                        if($retId == 1){
                            $this->ajaxReturn(array('status'=>1,'data'=>'删除成功'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'data'=>'删除失败'));
                        }

    	}

            /*
            *   function: result
            *    投票结果
            */
            public function result(){
                        $researchId = I('get.researchId')?I('get.researchId'):0;
                        $researchInfo = M('Project')->where('id = '.$researchId)->find();
                        if(!$researchInfo['see_able']){
                            $this->error('此投票结果不允许查看', 'http://mama.cn');
                        }
                        if(!$researchInfo['del']){
                            $this->error('此投票已删除', 'http://mama.cn');
                        }
                                   
                        $researchOptions = M('ProjectFields')->where('pid = '.$researchId)->find();
            
                        //选项及其子选项
                        $items = json_decode($researchOptions['options']);
                        foreach($items as $key => $val){
                                        $items[$key] = get_object_vars($val);
                                        $items[$key]['option_count'] = count($items[$key]['options']);
                                        $totalVotes = 0;
                                        if(is_array($items[$key]['results'])){
                                            foreach($items[$key]['results'] as $value){
                                                $totalVotes += $value;
                                            }
                                        }
                                        $items[$key]['totalVotes'] = $totalVotes;
                                    }
            
                                    // dump($items);exit;
                                    
                                    $uid = session('login_uid')?session('login_uid'):0;
                                    $this->assign('researchInfo', $researchInfo);
                                    $this->assign('items', $items);
                                    $this->display();
                        }
    }