<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <title>妈网投票系统--妈网后台功能系统</title>
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
	<div class="table-responsive">
	    <table class="table table-hover">
	        <tr class="success">
	            <th>标题</th>
	            <th>创建人</th>
	            <th>创建时间</th>
	            <th>开始时间</th>
	            <th>结束时间</th>
	            <th>状态</th>
	            <th>操作</th>
	        </tr>
	        <?php if(is_array($voteList)): foreach($voteList as $key=>$v): ?><tr>
	        	    <td><?php echo ($v["title"]); ?></td>
	                <td><?php echo ($v["username"]); ?></td>
	                <td><?php echo (date('Y-m-d H:i:s',$v["dateline"])); ?></td>
	                <td><?php echo (date('Y-m-d H:i:s',$v["start_time"])); ?></td>
	                <td><?php echo (date('Y-m-d H:i:s',$v["end_time"])); ?></td>
	                <td>
	                    <?php if($v["is_active"] == 1): ?>已启动
	                    	<?php else: ?>未启动<?php endif; ?>
	                </td>
	                <td><a href="<?php echo U('Vote/edit','vid='.$v[id]);?>" target="_blank">编辑</a> || <a href="<?php echo U('Vote/delete');?>" idAttr="<?php echo ($v["id"]); ?>" class="deleteProLink">删除</a> || <a href="<?php echo U('Show/index','proId='.$v[id]);?>" target="_blank">预览</a> || <a href="<?php echo U('Vote/result','voteId='.$v[id]);?>" target="_blank" >查看结果</a>
	                </td>
	            </tr><?php endforeach; endif; ?>
	    </table>
	</div>
	<div align="center"><?php echo ($page); ?></div>
    </div>
  </div>
</div>

<!--删除出错提示窗-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 class="modal-title text-center" id="myModalLabel">提示框</h3>
        </div>
        <div class="modal-body">
          <h4><strong>Error!</strong></h4>
          <h5 class="alert alert-danger" role="alert">数据删除失败！</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
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