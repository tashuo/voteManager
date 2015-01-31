<?php
    namespace Home\Controller;
    use Think\Controller;

    /**
    *表单统一处理入口
    */
    class PostController extends Controller{
    	public function index(){
    	    switch (I('post.formActionType')){
    	    	case 'newVote':
                                    // dump(I('post.'));exit;
                                    $result =D('Project')->addProject(I('post.'), 1);
                                    if($result['code'] == 0){
                                        $this->success('添加成功', U('Vote/index'));
                                    }else{
                                        // dump(json_decode($result['msg']));exit;
                                        $this->error($result['msg']);
                                    }
    	    		break;
                        case 'updateVote':
                                    // dump(I('post.'));exit;
                                    $result =D('Project')->updateProject(I('post.'), 1);
                                    if($result['code'] == 0){
                                        $this->success('修改成功', U('Vote/index'));
                                    }else{
                                        // dump($result['msg']);
                                        $this->error($result['msg']);
                                    }
                                    break;
                        case 'submitPro':
                                    // dump(I('post.'));exit;
                                    $result =D('Project')->submitProject(I('post.'));
                                    if($result['code'] == 1){
                                        $this->success($result['msg']);
                                    }else{
                                        // dump($result['msg']);exit;
                                        $this->error($result['msg']);
                                    }

                                    break;    
    	    	case 'newRegister':
                                    // dump(I('post.'));exit;
                                    $result = D('Project')->addProject(I('post.'), 2);
                                    if($result['code'] == 0){
                                        $this->success('添加成功', U('Register/index'));
                                    }else{
                                        // dump($result['msg']);exit;
                                        $this->error($result['msg']);
                                    }
    	    		break;
                        case 'updateRegister':
                                    // dump(I('post.'));exit;
                                    $result =D('Project')->updateProject(I('post.'), 2);
                                    if($result['code'] == 0){
                                        $this->success('修改成功', U('Register/index'));
                                    }else{
                                        // dump($result['msg']);
                                        $this->error($result['msg']);
                                    }
                                    break;
    
    	    	case 'newResearch':
    	    		//some codes
    	    		break;
    
    	    	default:
    	    		//some codes
    	    		break;
    	    }
    	}
    }
    