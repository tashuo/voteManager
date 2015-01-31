<?php
    namespace Home\Model;
    /*
    * 项目数据
    */
    class ProjectModel extends CommonModel{

    	public function getProjectList($offset = 0, $rowCount = 10, $orderBy = "deteline DESC"){
    		$where = array();
    		$voteList = $this->table($this->tableProject)->where($where)->order($orderBy)->limit($offset, $rowCount)->select();
    		return $voteList;
    	} 

    	public function getProjectInfo($proId){
    		$voteInfo = $this->table($this->tableProject)->where('id = '.$proId)->find();
                        return $voteInfo;
    	}

            public function getProjectOptions($proId){
                        $voteOptions = $this->table($this->tableProjectFields)->where('pid = '.$proId)->find();
                        return $voteOptions;
            }

            public function addProject($postData, $type = 1){
                        //获取登录用户信息
                        $userInfo = $this->getLoginUserInfo();
                        if(empty($userInfo)){
                            return array('code' => -1,
                                                'msg' => '请登录后再操作',
                                                );
                        }

                        $postData = array_map('htmlspecialchars', $postData);
                        $proData['type'] = $type;
                        $proData['is_active'] = $postData['isStart'];
                        $proData['dateline'] = time();
                        $proData['start_time'] = chinese_to_timestamp($postData['startDate']);
                        $proData['end_time'] = chinese_to_timestamp($postData['endDate']);
                        $proData['title'] = $postData['projectTitle'];
                        $proData['login_require'] = $postData['loginRequire'];
                        $proData['username'] = $userInfo['username'];
                        $proData['uid'] = $userInfo['uid'];

                        //投票所有字段
                        $type == 1 & $proData['see_able'] = $postData['seeAble'];
                        $type == 1 & $proData['vote_rule'] = $postData['voteRule'];

                        //报名所有字段
                        if($type == 2){
                            $postData['login_require']?$proData['register_allow_times'] = $postData['registerRule']:$proData['register_allow_times'] = 0;
                        }

                        // return array('code' => -1, 'msg' => $proData);
                        //插入project表
                        $Project = M('Project');
                        $proId = $Project->data($proData)->add();
                        // return array('code' => -1, 'msg' => $Project->_sql());
                        if($proId){
                            $optionNum = $postData['optionNum'];
                            $arr_option = array();
                            //对传入的数组进行处理
                            for($i = 0;$i < $optionNum; $i++){
                                $tmp_option = array();
                                $tmp_results = array();
                                foreach($postData as $key => $val){
                                    if($key == 'childType'.$i){
                                        $arr_option[$i]['type'] = $val;
                                    }elseif($key == 'childTitle'.$i){
                                        $arr_option[$i]['title'] = $val;
                                    }elseif($key == 'childRange'.$i){
                                        $arr_option[$i]['range'] = $val;
                                    }elseif($key == 'childType'.($i+1)){
                                        $arr_option[$i]['options'] = $tmp_option;
                                        $arr_option[$i]['results'] = $tmp_results;
                                        break;
                                    }elseif(substr($key, 0, strpos($key, '_')) == 'childOption'.$i){
                                        $tmp_option[] = $val;
                                        $tmp_results[] = 0;
                                    }             
                                }
                                //将最后一个题目添加进来
                                if($i == $optionNum-1){
                                    $arr_option[$i]['options'] = $tmp_option;
                                    $arr_option[$i]['results'] = $tmp_results;
                                }
                                continue;
                            }

                            //对用户提交的表单元素进行排序
                            usort($arr_option, 'order_by_range');

                            $optionData = array();
                            $optionData['pid'] = $proId;
                            $optionData['options'] = json_encode($arr_option);
                            $optionData['options_count'] = $optionNum;
                             // return array('code' => -1, 'msg' => $optionData['options']);
                            $ProjectFields = M('ProjectFields');
                            $pro_field_id = $ProjectFields->data($optionData)->add();
                            // return array('code' => -1, 'msg' => $ProjectFields->_sql());
                            if(isset($pro_field_id)){
                                return array('code' => 0,
                                                    'msg' => '添加成功！',
                                                    );
                            }else{
                                return array('code' => -1,
                                                    'msg' => '插入Project_fields表出错',
                                                    );
                            }

                        }else{
                            return array('code' => -1,
                                                'msg' => '插入project表出错',
                                                );
                        }
            }

            public function updateProject($postData, $type = 1){
                        //获取登录用户信息
                        $userInfo = $this->getLoginUserInfo();
                        if(empty($userInfo)){
                            return array('code' => -1,
                                                'msg' => '请登录后再操作',
                                                );
                        }
                        $postData = array_map('htmlspecialchars', $postData);
                        $id = $postData['proId'];
                        $proData['is_active'] = $postData['isStart'];
                        $proData['dateline'] = time();
                        $proData['start_time'] = chinese_to_timestamp($postData['startDate']);
                        $proData['end_time'] = chinese_to_timestamp($postData['endDate']);
                        $proData['title'] = $postData['proTitle'];
                        $proData['login_require'] = $postData['loginRequire'];
                        $proData['username'] = $userInfo['username'];
                        $proData['uid'] = $userInfo['uid'];

                        //获取项目的类型
                        $proInfo = $this->getProjectInfo($id);
                        $type = $proInfo['type'];
                        //投票所有字段
                        $type == 1 & $proData['see_able'] = $postData['seeAble'];
                        $type == 1 & $proData['vote_rule'] = $postData['voteRule'];

                        //报名所有字段
                        if($type == 2){
                            $postData['login_require']?$proData['register_allow_times'] = $postData['registerRule']:$proData['register_allow_times'] = 0;
                        }

                        // return array('code' => -1, 'msg' => json_encode($proData));
                        //更新project表与project_fields表
                        if($this->table('project')->where('id = '.$id)->save($proData) !== FALSE){
                            $optionNum = $postData['optionNum'];
                            $arr_option = array();
                            //对传入的数组进行处理
                            for($i = 0;$i < $optionNum; $i++){
                                $tmp_option = array();
                                $tmp_results = array();
                                foreach($postData as $key => $val){
                                    if($key == 'childType'.$i){
                                        $arr_option[$i]['type'] = $val;
                                    }elseif($key == 'childTitle'.$i){
                                        $arr_option[$i]['title'] = $val;
                                    }elseif($key == 'childRange'.$i){
                                        $arr_option[$i]['range'] = $val;
                                    }elseif($key == 'childType'.($i+1)){
                                        $arr_option[$i]['options'] = $tmp_option;
                                        $arr_option[$i]['results'] = $tmp_results;
                                        break;
                                    }elseif(substr($key, 0, strpos($key, '_')) == 'childOption'.$i){
                                        $tmp_option[] = $val;
                                        $tmp_results[] = 0;
                                    }             
                                }
                                if($i == $optionNum-1){
                                    $arr_option[$i]['options'] = $tmp_option;
                                    $arr_option[$i]['results'] = $tmp_results;
                                }
                                continue;
                            }

                            $optionData = array();
                            $optionData['options'] = json_encode($arr_option);
                            $optionData['options_count'] = $optionNum;
                            $ProjectFields = M('ProjectFields');
                            if($ProjectFields->where('pid = '.$id)->save($optionData) !== FALSE){
                                return array('code' => 0,
                                                    'msg' => 'okay',
                                                    );
                            }else{
                                return array('code' => -1,
                                                    'msg' => $ProjectFields->_sql().'插入出错',
                                                    );
                            }
                        }else{
                            return array('code' => -1,
                                                'msg' => '更新project表出错',
                                                );
                        }
            }

            public function submitProject($postData){
                        //首先判断该项目是否已过期，如果是投票的话，过滤掉绕过客户端限制进行的非法投票
                        $validData = $this->isValidProject($postData['pid'], get_client_ip(), session('login_uid'));
                        if(!$validData['retCode'])
                            return array('code' => -1, 'msg' => $validData['retMsg']);

                        //此处使用TP提供的对多维数组处理的array_map函数
                        $postData = array_map_recursive('htmlspecialchars', $postData);

                        $postData['action'] = array();
                        $data = array();
                        $data['ip'] = get_client_ip();
                        $data['uid'] = session('login_uid')?session('login_uid'):0;
                        $data['username'] = session('login_username');

                        //取出相应项目的投票结果,以便随后更新投票结果
                        $pid = $postData['pid'];
                        $voteInfo = $this->table('project_fields')->where('pid = '.$pid)->find();
                        $voteOptions = $voteInfo['options'];
                        // return array('code' => -1, 'msg' => json_encode($voteOptions));
                        $voteOptions = json_decode($voteOptions);

                        //这里使用data，add方法为什么不会自动过滤不存在的字段，需要将不存在的key手动删除？
                        //将投票结果更新到数组中:project_each_action中写入实际的(投票)结果，project_fields只写入(投票)累计数目
                        foreach($postData as $key => $value){
                            if(is_int($key)){
                                //根据type的不同进行分类处理
                                if($voteOptions[$key]->type == "textarea" || $voteOptions[$key]->type == 'text'){
                                    $voteOptions[$key]->results[] = $value;
                                    $postData['action'][$key] = $value;
                                }elseif(is_array($value)){
                                    $postData['action'][$key] = array();
                                    foreach($value as $val){
                                        //对各个子项的投票结果自增1
                                        $voteOptions[$key]->results[$val] += 1;
                                        $postData['action'][$key][] = $voteOptions[$key]->options[$val];
                                    }
                                }else{
                                    $voteOptions[$key]->results[$value] += 1;
                                    $postData['action'][$key] = $voteOptions[$key]->options[$value];
                                }
                            }else{
                                $data[$key] = $value;
                            }
                        }
                        // return array('code' => -1, 'msg' => json_encode($postData).json_encode($postData['action']));
                        $data['action'] = json_encode($postData['action']);
                        $data['dateline'] = time();
                        $data['action_day'] = date('Ymd', $data['dateline']);
                        //清除不存在的字段key
                        unset($data['formActionType']);
                        // return array('code' => -1, 'msg' => json_encode($voteOptions));
                        $ProjectEachAction = M('ProjectEachAction');
                        $retId = $ProjectEachAction->data($data)->add();
                        // return array('code' => -1, 'msg' => $ProjectEachAction->_sql());
                        if($retId){
                            //将提交的数据结果更新到投票字段
                            $ProjectFields = M('ProjectFields');
                            $updateId = $ProjectFields->where('pid = '.$pid)->save(array('options' => json_encode($voteOptions)));
                            if($updateId){
                                //更新project表的有效投票次数
                                $proSubId = $this->table('project')->where('id = '.$pid)->setInc('submitnum');
                                if(!$proSubId){
                                    return array('code' => -1,
                                                        'msg' => '更新project表出错 '.$ProjectFields->_sql(),
                                                        );
                                }
                            }else{
                                return array('code' => -1,
                                                    'msg' => '更新project_fields表出错',
                                                    );
                            }
                        }else{
                            return array('code' => -1,
                                                'msg' => '插入project_each_action表出错',
                                                );
                        }

                        return array('code' => 1,
                                            'msg' => $retId,
                                            );

            }

            public function delete($vid = 0){
                        
            }

            //判断项目是否在开始结束时间范围内以及投票是否符合投票规则
            public function isValidProject($proId, $ip=null, $uid=0){
                $retCode = 1;
                $retMsg = '';
                $now = time();
                $proInfo = $this->getProjectInfo($proId);
                if($proInfo['start_time'] > $now){
                    $retCode = 0;
                    $retMsg = '该项目还未开始，请稍后再来!';
                }elseif($proInfo['end_time'] < $now){
                    $retCode = 0;
                    $retMsg = '该项目已经结束，请选择其他项目';
                }elseif($proInfo['type'] == 1){
                    $voteRule = $proInfo['vote_rule'];
                    $ip = $ip?$ip:get_client_ip();
                    $nowDay = date('Ymd');
                    switch ($voteRule){
                        case uid:
                            $where = array('uid' => $uid, 
                                                      'pid' => $proId,
                                                      );
                            if($this->table('project_each_action')->where($where)->getField('id')){
                                $retCode = 0;
                                $retMsg = '该项目每个用户只能投一票，您已经投过请选择其他项目进行投票';
                            }
                            break;
                        case ip:
                            $where = array('pid' => $proId,
                                                      'ip' => $ip,
                                                      );
                            if($this->table('project_each_action')->where($where)->getField('id')){
                                $retCode = 0;
                                $retMsg = '该项目每个ip只能投一票，您已经投过请选择其他项目进行投票';
                            }
                            break;
                        case uid_day:
                            $where = array('uid' => $uid, 
                                                      'pid' => $proId,
                                                      'vote_day' => $nowDay,
                                                      );
                            if($this->table('project_each_action')->where($where)->getField(id)){
                                $retCode = 0;
                                $retMsg = '该项目每个用户每天只能投一票，您今天已经投过请明天再投';
                            }
                            break;
                        case ip_day:
                            $where = array('ip' => $ip,
                                                      'pid' => $proId,
                                                      'vote_day' => $nowDay,
                                                      );
                            if($this->table('project_each_action')->where($where)->getField('id')){
                                $retCode = 0;
                                $retMsg = '该项目每个ip每天只能投一票，您今天已经投过请明天再投';
                            }
                            break;
                        case uid_ip_day:
                            $where = array('pid' => $proId,
                                                      'uid' => $uid,
                                                      'ip' => $ip,
                                                      'vote_day' => $nowDay,
                                                      );
                            if($this->table('project_each_action')->where($where)->getField('id')){
                                $retCode = 0;
                                $retMsg = '该项目每个用户每个ip每天只能投一票，您今天已经投过请明天再投';
                            }
                            break;
                        default:
                            ;
                    }
                }elseif($proInfo['type'] == 2){
                    if($proInfo['register_allow_times'] > 0){
                        $where = array('pid' => $proId,
                                                  'uid' => $uid,
                                                );
                        if($this->table('project_each_action')->where($where)->count('id') >= $proInfo['register_allow_times']){
                            $retCode = 0;
                            $retMsg = '该项目每个用户最多只能报名'.$proInfo['register_allow_times'].'次，您已经到达上限';
                        }
                    }
                }

                return array('retCode' => $retCode,
                                    'retMsg' => $retMsg,
                                    );
            }


    }
