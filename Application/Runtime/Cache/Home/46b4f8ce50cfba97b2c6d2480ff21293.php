<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <title>发起投票--妈网后台功能系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/mama/toupiao/Public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/mama/toupiao/Public/css/style.css">
    <link href="http://cdn.bootcss.com/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <!-- 导航栏 Start -->
  <header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
    <div class="container">
      <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="<?php echo U('Vote/index');?>" class="navbar-brand">妈网后台系统</a>
      </div>
      <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
        <ul class="nav navbar-nav first_ul">
            <li class="<?php echo ($voteClass); ?>">
              <a href="<?php echo U('Vote/index');?>">投票</a>
            </li>
            <li class="<?php echo ($registerClass); ?>">
              <a href="<?php echo U('Register/index');?>">报名</a>
            </li>
            <!-- <li class="<?php echo ($researchClass); ?>">
              <a href="<?php echo U('Research/index');?>">调查</a>
            </li> -->
        </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php if($_SESSION['login_uid']): ?><li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo ($_SESSION['login_username']); ?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo U('User/logout');?>">退出</a></li>
                </ul>
              </li>
            <?php else: ?>
              <li><a href="http://um.mama.cn/connect.php?action=view">登录</a></li><?php endif; ?>
          </ul>
      </nav>
    </div>
  </header>
  <!-- 导航栏 End-->

<div class="container">
  <div class="rows">
    <div class="col-md-12 content">
    	<ul class="nav nav-tabs" role="tablist">
    		<li role="presentation" class="<?php echo ($listClass); ?>"><a href="<?php echo U('Vote/index');?>">投票列表</a></li>
		<li role="presentation" class="<?php echo ($addClass); ?>"><a href="<?php echo U('Vote/add');?>">发起投票</a></li>
	</ul>

	<div class="addvote">
	    <div class="alert alert-info" role="alert">请填写控制信息</div>
	    <form class="form-horizontal" id="voteForm" role="form" method="post" action="<?php echo U('Post/index');?>">
	    	<div class="form-group">
	    		<label for="projectTitle" class="col-sm-2 control-label">投票项目标题</label>
	    		<div class="col-sm-5">
	    			<!-- <div class="has-error"> -->
	    			<input type="text" class="form-control require" name="projectTitle" id="projectTitle" placeholder="项目标题">
	    			<!-- </div> -->
	    		</div>
	    	</div>
	    	<div class="form-group">
	    		<label for="startDate" class="col-sm-2 control-label">投票时间区间</label>
	    		    <div class="col-sm-5" id="RangeDate">
		    	    	<div class="input-daterange input-group">
    		    	        	    <input type="text" class="form-control require" id="startDate" name="startDate" />
    		    	        	    <span class="input-group-addon">至</span>
    		    	        	    <input type="text" class="form-control require" id="endDate" name="endDate" />
    		    	    	</div>
    		    	    </div>
    		</div>
    		<div class="form-group">
    			<label for="" class="col-sm-2 control-label">是否启动</label>
    			<div class="col-sm-5">
    			    <label class="radio-inline">
    			    	<input type="radio" name="isStart" value="1" checked="checked">启动
    			    </label>
    			    <label class="radio-inline">
    			    	<input type="radio" name="isStart" value="0">不启动
    			    </label>
    			</div>
    		</div>
    		<div class="form-group">
    			<label for="" class="col-sm-2 control-label">是否需要登录</label>
    			<div class="col-sm-5">
    			    <label class="radio-inline">
    			    	<input type="radio" name="loginRequire" value="1" checked="checked">需要
    			    </label>
    			    <label class="radio-inline">
    			    	<input type="radio" name="loginRequire" value="0">不需要
    			    </label>
    			</div>
    		</div>
    		<div class="form-group">
    			<label for="" class="col-sm-2 control-label">是否允许查看结果</label>
    			<div class="col-sm-5">
    			    <label class="radio-inline">
    			    	<input type="radio" name="seeAble" value="1" checked="checked">允许
    			    </label>
    			    <label class="radio-inline">
    			    	<input type="radio" name="seeAble" value="0">不允许
    			    </label>
    			</div>
    		</div>
		<div class="form-group">
			<label for="" class="col-sm-2 control-label">投票规则</label>
			<div class="col-sm-5">
				<select name="voteRule" class="form-control">
					<?php if(is_array($voteRule)): foreach($voteRule as $k=>$val): ?><option value="<?php echo ($k); ?>"><?php echo ($val); ?></option><?php endforeach; endif; ?>
				</select>
			</div>
		</div>
		<div class="alert alert-info" role="alert">
			请添加所需投票项
			<button type="button" class="btn btn-default" id="addItem"><span class="glyphicon glyphicon-plus"></span>  添加新条目</button>
		</div>
		<table class="table table-hover" id="optionTable">
			<tr>
			    <th width="20%">类型</th>
			    <th width="40%">标题</th>
			    <th width="10%">编号排序</th>
			    <th>选项</th>
			</tr>
			<?php $__FOR_START_1446301543__=0;$__FOR_END_1446301543__=1;for($i=$__FOR_START_1446301543__;$i < $__FOR_END_1446301543__;$i+=1){ ?><tr>
			        <td>
			        	<div class="input-group">
			        	    <span class="input-group-btn">
			        	    	<button class="btn btn-danger deleteItem" type="button" data-toggle="tooltip" data-placement="right" title="删除此题">删除
			        	    	</button>
			        	    </span>
			                <select name="childType<?php echo ($i); ?>" class="form-control">
			                    <?php if(is_array($optionType)): foreach($optionType as $k=>$val): ?><option value="<?php echo ($k); ?>"><?php echo ($val); ?></option><?php endforeach; endif; ?>
			                </select>
			        	</div>
			        </td>
			        <td>
			        	<div>
			        	    <input type="text" class="form-control require" name="childTitle<?php echo ($i); ?>" placeholder="标题" />
			        	</div>
			        <td>
			        	<div>
			        	    <input type="text" class="form-control require" name="childRange<?php echo ($i); ?>" placeholder="排序" value="1"/>
			        	</div>
			        </td>
			        <td>
			        	    <div class="input-group">
			        	        <input type="text" class="form-control require" name="childOption<?php echo ($i); ?>_1" placeholder="选项1"/>
			        	        <span class="input-group-btn">
			        	            <button class="btn btn-info addOption" type="button" data-toggle="tooltip" data-placement="right" title="新建一个子选项">添加
			        	            </button>
			        	        </span>
			        	    </div>
			        </td>
			    </tr><?php } ?>
		</table>
		<input type="hidden" id="optionNum" name="optionNum" value="1" />
		<input type="hidden" name="formActionType" value="newVote" />
		<div align="center">
		    <button type="submit" class="btn btn-primary btn-lg">生成表单</button>
		</div>
	    </form>
	</div>

  <div align="center">  
    <footer class="about-footer" role="contentinfo">
      <div class="container">
        <p><a rel="nofollow" href="http://www.mama.cn/">妈妈网</a> | <a rel="nofollow" href="http://about.mama.cn/">公司简介</a> | <a rel="nofollow" href="http://about.mama.cn/news.html">媒体报道</a> | <a rel="nofollow" href="http://about.mama.cn/contact.html">联系我们</a> | <a rel="nofollow" href="http://about.mama.cn/join us.html">诚聘英才</a> | <a rel="nofollow" href="http://about.mama.cn/link.html">友情链接</a></p>
        <p>联系地址：广州市天河区天河路228号广晟大厦2706室</p>
        <p>COPYRIGHT <a href="http://www.mama.cn/">MaMa.cn</a> All Right Reserved 版权所有：<a href="http://www.mama.cn/">妈妈网</a> 粤ICP备09174648号-35</p>
      </div>
    </footer>
  </div>
  <script src="/mama/toupiao/Public/js/jquery-2.1.0.min.js"></script>
  <script src="/mama/toupiao/Public/bootstrap/js/bootstrap.min.js"></script>
  <script src="/mama/toupiao/Public/js/main.js"></script>
  <script src="http://cdn.bootcss.com/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
  <script src="http://cdn.bootcss.com/bootstrap-datepicker/1.3.0/js/locales/bootstrap-datepicker.zh-CN.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function(){
      //添加新条目
      $('#addItem').click(function(){
        var trLen = $('#optionTable tr').length;
        var end = trLen - 1;
        //此时还未将新的tr节点插入，所以option的个数等于tr的个数
        $('#optionNum').val(trLen);
        var trNode = $('<tr style="display: none"></tr>').html('<td><div class="input-group"><span class="input-group-btn"><button class="btn btn-danger deleteItem" type="button" data-toggle="tooltip" data-placement="right" title="删除此题">删除</button></span><select name="childType'+end+'" class="form-control"><?php if(is_array($optionType)): foreach($optionType as $k=>$val): ?><option value="<?php echo ($k); ?>"><?php echo ($val); ?></option><?php endforeach; endif; ?></select></div></td><td><input type="text" name="childTitle'+end+'" class="form-control require" placeholder="标题" /></td><td><input type="text" class="form-control require" name="childRange'+end+'" placeholder="排序" value="'+trLen+'"/></td><td><div class="input-group"><input type="text" class="form-control require" name="childOption'+end+'_1" placeholder="选项1"/><span class="input-group-btn"><button class="btn btn-info addOption" type="button" data-toggle="tooltip" data-placement="right" title="新建一个子选项">添加</button></span></div></td>');
        $('#optionTable').append(trNode);
        trNode.fadeIn('slow');
      })
  })
  </script>
  <script>
              $('#RangeDate .input-daterange').datepicker({
                    language: "zh-CN",
                    orientation: "top auto",
                    autoclose: true,
                    keyboardNavigation: false,
                    forceParse: false,
                    todayHighlight: true
               });
  </script>
  </body>
</html>