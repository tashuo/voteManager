<?php
    namespace Home\Controller;
    use Think\Controller;
    class VoteController extends Controller{
            public function __construct(){
                        parent::__construct();
                        //检验登录状态
                        $Common = D('Common');
                        if(!$Common->isLogin()){
                            redirect(U('User/index'));
                        }
            }

    	public function index(){
                        $this->assign('voteClass','active');
                        $this->assign('listClass', 'active');

                        $count = M('Project')->where('type = 1 AND del = 0')->count();
                        $Page = new \Think\Page($count, 15);
                        $show = $Page->show();

                        $list = M('Project')->where('type = 1 AND del = 0')->order('dateline DESC')->limit($Page->firstRow.','.$Page->listRows)->select();

                        $this->assign('voteList', $list);
                        $this->assign('page', $show);
    		$this->display();
    	}

    	public function add(){
                        $this->assign('voteClass', 'active');
                        $this->assign('addClass', 'active');
                        $this->assign('voteRule', C('VOTE_RULE'));
                        $this->assign('optionType', C('VOTE_OPTION_TYPE'));

                        $this->display();
    	}

    	public function edit(){
                        $this->assign('voteClass', 'active');
                        $this->assign('editClass', 'active');
                        $this->assign('voteRule', C('VOTE_RULE'));
                        $this->assign('optionType', C('VOTE_OPTION_TYPE'));
                        $data = array();

                        $voteId = I('get.vid');
                        $voteInfo = M('Project')->where('id = '.$voteId)->find();
                        $voteOptions = M('ProjectFields')->where('pid = '.$voteId)->find();
                        $this->assign('optonsCount', $voteOptions['options_count']);
                        
                        $voteOptions = json_decode($voteOptions['options']);

                        //为什么这里用引用会出错
                        // foreach($voteOptions as &$val){
                        //     $val = get_object_vars($val);
                        // }
                        foreach($voteOptions as $key => $val){
                            $voteOptions[$key] = get_object_vars($val);
                            $voteOptions[$key]['option_count'] = count($voteOptions[$key]['options']);
                        }

                        $data['voteInfo'] = $voteInfo;
                        $data['voteOptions'] = $voteOptions;

                        $this->assign('voteId', $voteId);
                        $this->assign('voteData', $data);

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
            *    投票结果
            */
            
            public function result(){
                        $voteId = I('get.voteId')?I('get.voteId'):0;
                        $voteInfo = M('Project')->where('id = '.$voteId)->find();

                        if(!$voteInfo['see_able']){
                            $this->error('此投票结果不允许查看', 'http://mama.cn');
                        }

                        if($voteInfo['del']){
                            $this->error('此投票已删除', 'http://mama.cn');
                        }
                                   
                        $voteOptions = M('ProjectFields')->where('pid = '.$voteId)->find();
            
                        //选项及其子选项
                        $items = json_decode($voteOptions['options']);
                        // dump($items);exit;
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
                                    
                        $this->assign('voteInfo', $voteInfo);
                        $this->assign('items', $items);
                        $this->display();
            }
            public function test(){
                echo MODULE_PATH.'View/Public/error.html'.'<br/>';
                echo __ACTION__.'<br/>';
                echo __SELF__.'<br/>';
            }
    }