<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <title>管理员登录--广州妈妈网</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/mama/toupiao/Public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/mama/toupiao/Public/css/style.css">
    <link rel="stylesheet" href="/mama/toupiao/Public/css/flipclock.css">
    <link href="http://cdn.bootcss.com/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" rel="stylesheet">
    <script src="/mama/toupiao/Public/js/jquery-2.1.0.min.js"></script>
    <script src="/mama/toupiao/Public/js/main.js"></script>
    <style>
        .jumbotron{
          background-image: url("http://zt.mama.cn/images/topbg.jpg");
          height: 350px;
        }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <!-- 导航栏 Start -->
  <nav class="navbar navbar-inverse navbar-fixed-top nav-default" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="http://www.mama.cn" class="navbar-brand">妈妈网首页</a>
      </div>
      <div class="collapse navbar-collapse bs-navbar-collapse">
        <ul class="nav navbar-nav">
            <li>
              <a href="http://www.mama.cn/baby/">亲子</a>
            </li>
            <li>
              <a href="http://www.mama.cn/news/">资讯</a>
            </li>
            <li>
              <a href="http://www.mama.cn/daogou/">用品</a>
            </li>
            <li>
              <a href="http://tonglingquan.mama.cn/forum.php">互动</a>
            </li>
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
      </div>
    </div>
  </nav>
  <!-- 导航栏 End-->
  <div class="jumbotron">
  </div>


    <div class="container">
    	<div class="rows">
    		<div class="col-md-12">
    			<div class="alert alert-danger" align="center" role="alert">
    				<a href="<?php echo U('User/login');?>">请先登录</a>
    			</div>
    		</div>
    	</div>
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
  
  <script src="/mama/toupiao/Public/bootstrap/js/bootstrap.min.js"></script>
  
  </body>
</html>